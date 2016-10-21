<!--
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm

  Function: Display Time Cards for the requested Employee
-->

<?php
  require_once("logincheck.php");
  require_once("../../db_connect.php");
  $requestEmployeeId=$_REQUEST['id'];

  // Fetch login details
  session_start();
  $_SESSION['requestEmployeeId'] = $requestEmployeeId;
  $employeeId = $_SESSION['employeeId'];
  $firstName = $_SESSION['firstName'];
  $lastName = $_SESSION['lastName'];
  $employeeTitle = $_SESSION['employeeTitle'];
  $adminFlag = $_SESSION['adminFlag'];
  $rate = $_SESSION['rate'];

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

  $tcsql = 'SELECT
        ID,
        employeeId,
        payPeriodStart,

        subTotalRegWk1Tax,
        subTotalRegWk1Edu,
        subTotalOTWk1Tax,
        subTotalOTWk1Edu,
        subTotalRegWk2Tax,
        subTotalRegWk2Edu,
        subTotalOTWk2Tax,
        subTotalOTWk2Edu,

        twoWeekTotalRegTax,
        twoWeekTotalRegEdu,
        twoWeekTotalOTTax,
        twoWeekTotalOTEdu,
        twoWeekTotalComb

      FROM timecards WHERE employeeId=' .$requestEmployeeId. ';';
  //echo $tcsql. '<br/>';
  $tcresult = mysql_query($tcsql) or die(mysql_error());

?>

<!DOCTYPE html>
<html>
<head>
  <title>Time Cards | SweetTime!</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="sweettime.css" />
</head>
<body>
  <!-- Navbar -->
  <ul class="w3-navbar w3-light-blue w3-card-2 w3-top w3-left-align w3-large">
    <li class="w3-hide-medium w3-hide-large w3-opennav w3-right">
      <a class="w3-padding-large w3-hover-white w3-large w3-light-blue" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    </li>
    <li><a href="timecard_view.php?id=<?php print($employeeId); ?>" class="w3-xlarge w3-padding-medium w3-white"><i class="fa fa-clock-o"></i></a></li>
    <?php if ($adminFlag == 'Yes') {
      print('<li class="w3-hide-small"><a href="home.php" class="w3-padding-large w3-hover-white">Administration</a></li>');
    } ?>
    <li class="w3-hide-small"><a href="logout_process.php" class="w3-padding-large w3-hover-white">Log Out</a></li>
  </ul>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:51px">
    <ul class="w3-navbar w3-left-align w3-large w3-black">
      <li><a class="w3-padding-large" href="timecard_view.php?id=<?php print($requestEmployeeId); ?>">Time Cards</a></li>
      <?php if ($adminFlag == 'Yes') {
        print('<li><a class="w3-padding-large" href="home.php">Administration</a></li>');
      } ?>
      <li><a class="w3-padding-large" href="logout_process.php">Log Out</a></li>
    </ul>
  </div>

  <!-- Content -->
  <div class="w3-container w3-dark-grey w3-padding-64">

    <div class="w3-content w3-row">
      <div class="w3-third">
        <p class="w3-xlarge w3-text-light-blue">Time Cards for <?php print($emprow['firstName']. ' ' .$emprow['lastName']); ?></p>
        <p>Employee ID: <?php print($emprow['ID']); ?> <br/>
        Name: <?php print($emprow['firstName']); ?> <?php print($emprow['lastName']); ?><br/>
        Title: <?php print($emprow['employeeTitle']); ?> <br/>
        Administrator: <?php print($emprow['adminFlag']); ?> </p>
      </div>
      <div class="w3-twothird">
        <?php
          if ($adminFlag=='Yes') {
            print('
              <div class="w3-panel w3-card-8 w3-yellow">
              </div>
              <div class="w3-card-4">
                <header class="w3-container w3-yellow">
                <h4>Caution!</h4>
                </header>
                <div class="w3-container">
                  <p>You are viewing this Time Card as an Administrator.<br/>
                  Changes here will override entries made by an Employee.</td></tr>
                  <p>Employee ID: '.$employeeId.'<br/>
                  Name: '.$firstName.' '.$lastName.'<br/>
                  Title: '.$employeeTitle.'</p>
                </div>
              </div>');
          }
        ?>
        <p>This page displays Time Cards related to an Employee. You may add, edit, or view the details of a Time Card. If you have Administration rights you may also delete a Time Card.
        </p>
      </div>
    </div>

    <div class="w3-content">
      <div class="w3-responsive">
      <table class="w3-table w3-bordered w3-medium">
        <tr>
          <th>Time<br/>Card<br/>Id</th>
          <th>Pay<br/>Period<br/>Start</th>
          <th>Two Week<br/>Total Reg.<br/>(Tax)</th>
          <th>Two Week<br/>Total Reg.<br/>(Edu)</th>
          <th>Two Week<br/>Total OT<br/>(Tax)</th>
          <th>Two Week<br/>Total OT<br/>(Edu)</th>
          <th><br/>Total<br/>Tax + Edu</th>
          <th><br/><br/>Details</th>
          <th><br/><br/>Edit</th>
          <th><br/><br/>Delete</th>
        </tr>
        <?php
          while($row = mysql_fetch_array($tcresult)) {
            print('<tr>
            <td>' .$row['ID']. '</td>
            <td>' .$row['payPeriodStart']. '</td>
            <td>' .$row['twoWeekTotalRegTax']. '</td>
            <td>' .$row['twoWeekTotalRegEdu']. '</td>
            <td>' .$row['twoWeekTotalOTTax']. '</td>
            <td>' .$row['twoWeekTotalOTEdu']. '</td>
            <td>' .$row['twoWeekTotalComb']. '</td>
            <td><a href=\'timerec_view.php?id=' .$row['ID']. '\'><i class="fa fa-book w3-text-blue w3-margin-right"></i></a></td>
            <td><a href=\'timecard_update.php?id=' .$row['ID']. '\'><i class="fa fa-pencil w3-text-green w3-margin-right"></i></a></td>');
            if ($adminFlag=='Yes') {
              print('<td><a href=\'timecard_delete.php?id=' .$row['ID']. '\'><i class="fa fa-remove w3-text-red w3-margin-right"></i></a></td>');
            } else {
              print('<td><i class="fa fa-remove w3-text-light-grey w3-margin-right"></i></td>');
            }
            print('</tr>');
          }
        ?>
      </table>
      </div>
      <p>
        <form action="timecard_insert_process.php" method="post">
          <table>
            <tr>
              <td>Pay Period Start: </td>
              <td><input type="date" name="payPeriodStart"/></td>
              <td><input class="w3-btn w3-green w3-round" type="submit" value="Add Time Card" /></td>
            </tr>
          </table>
        </form>
      </p>
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
