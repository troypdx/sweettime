<!--
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm
-->

<?php
  require_once("logincheck.php");

  $employeeId = $_SESSION['employeeId'];
  $firstName = $_SESSION['firstName'];
  $lastName = $_SESSION['lastName'];
  $email = $_SESSION['email'];
  $employeeTitle = $_SESSION['employeeTitle'];
  $adminFlag = $_SESSION['adminFlag'];
  $rate = $_SESSION['rate'];

  require_once("../../db_connect.php");
  $trsql = 'SELECT
      ID,
      timecardId,
      date,
      workType,

      timeInAM,
      timeOutAM,
      hrsAM,

      timeInPM,
      timeOutPM,
      hrsPM,

      notes,
      hrsTax,
      hrsEdu,
      payRate

    FROM timerecords;';

  $trresult = mysql_query($trsql) or die(mysql_error());
?>

<!DOCTYPE html>
<html>
<head>
  <title>Time Records | SweetTime!</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="sweettime.css">
</head>
<body>
  <!-- Navbar -->
  <ul class="w3-navbar w3-light-blue w3-card-2 w3-top w3-left-align w3-large">
    <li class="w3-hide-medium w3-hide-large w3-opennav w3-right">
      <a class="w3-padding-large w3-hover-white w3-large w3-light-blue" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    </li>
    <li><a href="home.php" class="w3-xlarge w3-padding-medium w3-white"><i class="fa fa-home"></i></a></li>
    <li class="w3-hide-small"><a href="emp_view.php" class="w3-padding-large w3-hover-white">Manage Employees</a></li>
    <li class="w3-hide-small"><a href="report_timecards.php" class="w3-padding-large w3-hover-white">Manage Time Cards</a></li>
    <li class="w3-hide-small"><a href="report_timerecs.php" class="w3-padding-large w3-hover-white">Manage Time Records</a></li>
    <li class="w3-hide-small"><a href="logout_process.php" class="w3-padding-large w3-hover-white">Log Out</a></li>
</ul>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:51px">
  <ul class="w3-navbar w3-left-align w3-large w3-black">
    <li><a class="w3-padding-large" href="emp_view.php">Manage Employees</a></li>
    <li><a class="w3-padding-large" href="report_timecards.php">Manage Time Cards</a></li>
    <li><a class="w3-padding-large" href="report_timerecs.php">Manage Time Records</a></li>
    <li><a class="w3-padding-large" href="logout_process.php">Log Out</a></li>
  </ul>
</div>

  <!-- Content -->
  <div class="w3-container w3-dark-grey w3-padding-64">

    <div class="w3-content w3-row">
      <div class="w3-third">
        <p>Employee ID: <?php print($employeeId); ?> <br/>
        Name: <?php print($firstName. ' ' .$lastName); ?> <br/>
        Title: <?php print($employeeTitle); ?> <br/>
        Administrator: <?php print($adminFlag); ?> </p>
        <p class="w3-xlarge w3-text-light-blue">Manage Time Records</p>
      </div>
      <div class="w3-twothird">
        <p>This page displays the all Time Records across all Time Cards entered into the system. You may delete individual Time Records or all Time Records related to a particular Time Card. Note that these changes will not be reflected in time tracking calculations until the Time Card is updated. Use Delete with caution!
        </p>
        <p>
        <form action="report_timerec_delete_range.php" method="post">
          <table>
            <tr>
              <td>Time Card ID: </td>
              <td><input type="text" name="timecardId"/></td>
              <td><input class="w3-btn w3-green w3-round" type="submit" value="Delete"/></td>
            </tr>
          </table>
        </form>
        </p>
      </div>
    </div>

    <div class="w3-content">
      <div class="w3-responsive">
        <table class="w3-table w3-bordered w3-medium">
          <tr>
            <th>Time<br/>Record ID</th>
            <th>Time<br/>Card ID</th>
            <!-- <th><br/>Employee</th> -->
            <th><br/>Date</th>
            <th>Work<br/>Type</th>
            <th>Hrs<br/>(AM)</th>
            <th>Hrs<br/>(PM)</th>
            <th><br/>Notes</th>
            <th>Hrs<br/>Tax</th>
            <th>Hrs<br/>Edu</th>
            <th><br/>Delete</th>
          </tr>

        <?php
          while($trrow = mysql_fetch_array($trresult)) {

            /*
            // Obtain the Employee ID for the related Time Card
            $tcsql = 'SELECT
                  ID,
                  employeeId
                FROM timecards WHERE ID = ' .$trrow['timecardId']. ';';
            echo $tcsql. '<br/>';
            $tcresult = mysql_query($tcsql) or die(mysql_error());

            // Obtain the Employee Name for the related Time Card
            $empsql = 'SELECT
                ID,
                firstName,
                lastName
              FROM employees WHERE ID = ' .$tcrow['employeeId']. ';';
            echo $empsql. '<br/>';
            $empresult = mysql_query($empsql) or die(mysql_error());
            $emprow = mysql_fetch_array($empresult);

            .'<td>' .$emprow['firstName']. ' ' .$emprow['lastName']. '</td>'

            */
            print('<tr><td>' .$trrow['ID']. '</td>'
            .'<td>' .$trrow['timecardId']. '</td>'
            .'<td>' .$trrow['date']. '</td>'
            .'<td>' .$trrow['workType']. '</td>'
            .'<td>' .$trrow['hrsAM']. '</td>'
            .'<td>' .$trrow['hrsPM']. '</td>'
            .'<td>' .$trrow['notes']. '</td>'
            .'<td>' .$trrow['hrsTax']. '</td>'
            .'<td>' .$trrow['hrsEdu']. '</td>'
            //.'<td><a href=\'report_timerec_update.php?id=' .$trrow['ID']. '\'><i class="fa fa-pencil w3-text-green w3-margin-right"></i></a></td>'
            .'<td><a href=\'report_timerec_delete.php?id=' .$trrow['ID']. '\'><i class="fa fa-remove w3-text-red w3-margin-right"></i></a></td></tr>');
          }
        ?>
      </table>
      </div>
    </div> <!-- end w3-content -->
  </div> <!-- end w3-container -->

  <div class="w3-container w3-light-grey w3-center w3-opacity w3-padding-64">
      <h1 class="w3-margin w3-xlarge"><i class="fa fa-clock-o w3-text-blue"></i> SweetTime!</h1>
      <h2 class="w3-margin w3-large">Web-Based Time Tracking System</h2>
      <p class="w3-margin w3-medium">Copyright (c) 2016 Troy Scott</p>
  </div>

  <script src="mobile_navbar.js"></script>

</body>
</html>
