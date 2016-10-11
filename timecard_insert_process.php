<!--
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm
  Function: Add a new Time Card for the requested Pay Period start date.
-->

<?php
  require_once("logincheck.php");
  require_once("../../db_connect.php");
  $date = new DateTime();

  $payPeriodStart = $_REQUEST['payPeriodStart'];

  // Obtain employee information for this session
  session_start();
  $requestEmployeeId = $_SESSION['requestEmployeeId'];
  $empsql = 'SELECT
      ID,
      firstName,
      lastName,
      employeeTitle,
      adminFlag,
      rate
    FROM employees WHERE ID='.$requestEmployeeId.';';
  //echo $empsql. '<br/>';
  $empresult = mysql_query($empsql) or die(mysql_error());
  $emprow = mysql_fetch_array($empresult) or die(mysql_error());

?>

<!-- Create a HTML document if necessary to display user feedback -->
<!DOCTYPE html>
<html>
<title>Add Time Card Error | SweetTime!</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<style>
  body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
  .w3-navbar,h1,button {font-family: "Montserrat", sans-serif}
</style>
<body>
  <!-- Navbar -->
  <ul class="w3-navbar w3-light-blue w3-card-2 w3-top w3-left-align w3-large">
    <li class="w3-hide-medium w3-hide-large w3-opennav w3-right">
      <a class="w3-padding-large w3-hover-white w3-large w3-light-blue" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    </li>
    <li><a href="timecard_view.php?id=<?php print('$requestEmployeeId'); ?>" class="w3-xlarge w3-padding-medium w3-white"><i class="fa fa-clock-o"></i></a></li>
  </ul>
  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:51px">
    <ul class="w3-navbar w3-left-align w3-large w3-black">
      <li><a class="w3-padding-large" href="timecard_view.php?id=<?php print('$requestEmployeeId'); ?>">Time Cards</a></li>
    </ul>
  </div>


  <!-- Content -->
  <div class="w3-container w3-dark-grey w3-padding-64">
    <div class="w3-content">
        <p>
          <a href="timecard_view.php?id=<?php print($requestEmployeeId); ?>">Time Cards</a>
        </p>
        <p class="w3-xlarge w3-text-orange">Add Time Card Did Not Complete Successfully</p>

        <!-- Insert a new Time Card and 14 new Time Records for the time period requested by the user -->
        <?php
          // Confirm that the Time Card being added does not overlap another Time Card's pay period
          $beginPayPeriod = new DateTime($payPeriodStart);
          $endPayPeriod = new DateTime($payPeriodStart);
          $endPayPeriod->add(new DateInterval('P14D'));
          $interval = new DateInterval('P1D');
          $dateRange = new DatePeriod($beginPayPeriod, $interval, $endPayPeriod);
          $overlap = FALSE;

          // Time Card pay period overlap check
          foreach ($dateRange as $dateCheck) {
            // echo $dateCheck->format("m-d-Y") . "<br>";
            // Search for overlapping pay periods
            $tcsql = 'SELECT ID,
                employeeId,
                payPeriodStart
              FROM timecards WHERE employeeId='.$requestEmployeeId.';';
            //echo $tcsql.'<br>';
            $tcresult = mysql_query($tcsql);

            while($tcrow = mysql_fetch_array($tcresult)) {
              // Select all Time Records for the Time Cards related to each Time Card
              $trsql = 'SELECT
                    ID, timecardId, date
                  FROM timerecords
                  WHERE timecardId='.$tcrow['ID'].' AND date = \''.$dateCheck->format("Y-m-d").'\';';
              //echo $trsql. '<br>';
              $trresult = mysql_query($trsql);
              while($trrow = mysql_fetch_array($trresult)) {
                if ($trrow['date'] == $dateCheck->format("Y-m-d")) {
                  // The select query found a Time Card with an overlapping pay period
                  $overlap = TRUE;
                  echo 'Pay period overlap detected in Time Card ID: ' .$tcrow['ID']. '.<br>';
                  break 3; // If match then stop searching all Time Card / Time Record permutations
                }
              }
            }
          }
          if ($overlap) {
            // The select query found a Time Card with an overlapping pay period
            print("<p>ERROR: The pay period starting date of, " .$payPeriodStart. ", overlaps the 2-week pay period of Time Card ID: " .$tcrow['ID']. ".
            <br/>SweetTime! cannot introduce Time Cards that overlap pay periods.<br/><br/>
            Choose a different date or consult with your Payroll Administrator if you need to modify an existing Time Card.</p>");
            mysql_close($conn);
            print("<p>Return to <a href='timecard_view.php?id=" .$requestEmployeeId. "'>Time Card Administration</a></p>");

          } else {
            // Insert a new Time Card
            $tcsql= 'INSERT INTO timecards (
                employeeId, payPeriodStart, payRate)
              VALUES (
                '.$requestEmployeeId.', \''.$payPeriodStart.'\', '.$emprow['rate'].');';
            //echo $tcsql.'<br/>';
            mysql_query($tcsql) or die(mysql_error());

            // Obtain the new Time Card ID to be used with new Time Records
            $tcsql = 'SELECT ID,
                employeeId, payPeriodStart
              FROM timecards WHERE
                employeeId = '.$requestEmployeeId.' AND payPeriodStart=\''.$payPeriodStart.'\';';
            //echo $tcsql.'<br/>';
            $result = mysql_query($tcsql) or die(mysql_error());
            $row = mysql_fetch_array($result);

            $paydate = new DateTime($payPeriodStart);

            // Insert 14 new Time Records (one two week payroll period) using the new Time Card ID
            for ($x = 1; $x <= 14; $x++) {
              $trsql= "INSERT INTO timerecords (date, timecardId)
                  VALUES ('".$paydate->format('Y-m-d')."', ".$row['ID'].");";
              //echo $trsql . '<br/>';
              $paydate->add(new DateInterval('P1D'));
              mysql_query($trsql) or die(mysql_error());
            }

            // Alternative to header(); exit; below for troubleshooting this module
            //echo("Time Card ID: ".$row['ID']." for Employee ID: ".$requestEmployeeId." successfully added to the database.");
            //echo("<br/>Go back to Time Card View <a href='timecard_view.php?id=".$requestEmployeeId."'>main page.</a>");
            mysql_close($conn);

            header("Location: timecard_view.php?id=$requestEmployeeId");
            exit;
          }

        ?>
      </div> <!-- end w3-content -->
    </div> <!-- end w3-container -->

  <div class="w3-container w3-light-grey w3-center w3-opacity w3-padding-64">
      <h1 class="w3-margin w3-xlarge"><i class="fa fa-clock-o w3-text-blue"></i> SweetTime!</h1>
      <h2 class="w3-margin w3-large">Web-Based Time Tracking System</h2>
      <p class="w3-margin w3-medium">Copyright (c) 2016 Troy Scott</p>
  </div>

</body>
</html>
