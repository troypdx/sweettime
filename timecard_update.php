<!--
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm

  Function: Edit Time Records for the requested Time Card
-->

<?php
  require_once("logincheck.php");
  require_once("../../db_connect.php");

  $requestTimeCardId=$_REQUEST['id'];

  // Fetch login details
  session_start();
  $_SESSION['requestTimeCardId'] = $requestTimeCardId;
  // $requestEmployeeId = $_SESSION['requestEmployeeId'];
  $employeeId = $_SESSION['employeeId'];
  $firstName = $_SESSION['firstName'];
  $lastName = $_SESSION['lastName'];
  $employeeTitle = $_SESSION['employeeTitle'];
  $adminFlag = $_SESSION['adminFlag'];
  $rate = $_SESSION['rate'];

  // Fetch Employee ID for the requested Time Card
  $tcsql = 'SELECT employeeId FROM timecards WHERE ID='.$requestTimeCardId.';';
  //echo $tcsql. '<br/>';
  $tcresult = mysqli_query($con,$tcsql);
  $tcrow = mysqli_fetch_array($tcresult);
  $requestEmployeeId = $tcrow['employeeId'];

  // Fetch Employee details related to the requsted Time Card
  $empsql = 'SELECT
      ID,
      firstName,
      lastName,
      employeeTitle,
      adminFlag,
      rate
    FROM employees WHERE ID='.$requestEmployeeId.';';
  // echo $empsql.'<br/>';
  $empresult = mysqli_query($con,$empsql) or die(mysqli_error($con));
  $emprow = mysqli_fetch_array($empresult) or die(mysqli_error($con));

  $trsql = 'SELECT
        ID, timecardId, date, workType,
        timeInAM, timeOutAM, hrsAM,
        timeInPM, timeOutPM, hrsPM,
        notes, hrsTax, hrsEdu, payRate
        FROM timerecords WHERE timecardId='.$requestTimeCardId.';';
  // echo $trsql.'<br/>';
  $trresult = mysqli_query($con,$trsql) or die(mysqli_error($con));
?>

<html>
<head>
  <title>Edit Time Card | SweetTime!</title>
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
    <li><a href="timecard_view.php?id=<?php print($requestEmployeeId); ?>" class="w3-xlarge w3-padding-medium w3-white"><i class="fa fa-clock-o"></i></a></li>
    <li class="w3-hide-small"><a href="timerec_view.php?id=<?php print($requestTimeCardId); ?>" class="w3-padding-large w3-hover-white">View Time Card</a></li>
    <?php if ($adminFlag == 'Yes') {
      print('<li class="w3-hide-small"><a href="home.php" class="w3-padding-large w3-hover-white">Administration</a></li>');
    } ?>
    <li class="w3-hide-small"><a href="logout_process.php" class="w3-padding-large w3-hover-white">Log Out</a></li>
  </ul>
  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:51px">
    <ul class="w3-navbar w3-left-align w3-large w3-black">
      <li><a class="w3-padding-large" href="timecard_view.php?id=<?php print($requestEmployeeId); ?>">Time Cards</a></li>
      <li><a class="w3-padding-large" href="timerec_view.php?id=<?php print($requestTimeCardId); ?>">View Time Card</a></li>
      <?php if ($adminFlag == 'Yes') {
        print('<li><a class="w3-padding-large" href="home.php">Administration</a></li>');
      } ?>
      <li><a class="w3-padding-large" href="logout_process.php">Log Out</a></li>
    </ul>
  </div>

  <!-- Container:
  w3-container class HTML container with 16px left and right padding -->
  <div class="w3-container w3-dark-grey w3-padding-64">

    <!-- Content:
    w3-content class defines a container for fixed size centered content default width (980px). -->
    <div class="w3-content w3-row">
      <div class="w3-container w3-third">
        <p class="w3-xlarge w3-text-light-blue">Edit Time Card: <?php print($requestTimeCardId); ?></p>
        <p>Employee ID: <?php print($emprow['ID']); ?> <br/>
        Name: <?php print($emprow['firstName']); ?> <?php print($emprow['lastName']); ?><br/>
        Title: <?php print($emprow['employeeTitle']); ?> <br/>
        Administrator: <?php print($emprow['adminFlag']); ?> </p>
      </div> <!-- end w3-third -->
      <div class="w3-container w3-twothird">
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
                <p>You are viewing this Time Card as an Administrator. <br/>
                Changes here will override entries made by an Employee.</td></tr>
                <p>Employee ID: '.$employeeId.'<br/>
                Name: '.$firstName.' '.$lastName.'<br/>
                Title: '.$employeeTitle.'</p>
              </div>
            </div>');
          }
        ?>
        <p>Note: Please track items worked on. For instance, if you are working on tax returns: list out the last names of those worked on. If you are working on education materials, list out what you have worked on: worksheets, research, sample problems, etc.</p>
        <p>All times be entered to the nearest 15 minutes (08:15 AM, 8:30 AM, etc.).</p>
      </div> <!-- end w3-twothird -->
    </div> <!-- end w3-content -->

    <div class="w3-content w3-row">
      <div class="w3-container">
        <div class="w3-row-padding">
          <div class="w3-col l1 m1 s1">Date</div>
          <div class="w3-col l1 m1 s1">Type</div>
          <div class="w3-col l2 m2 s2">Time In</div>
          <div class="w3-col l2 m2 s2">Time Out</div>
          <div class="w3-col l2 m2 s2">Time In</div>
          <div class="w3-col l2 m2 s2">Time Out</div>
          <div class="w3-col l2 m2 s2">Notes</div>
        </div> <!-- end w3-row -->
        <!-- Responsive style form -->
        <form action="timecard_update_process.php" method="post">
        <?php for ($x = 1; $x <= 14; $x++):
          $trrow = mysqli_fetch_array($trresult);
          $dateLabel = new Datetime($trrow['date']);
          ?>
          <div class="w3-row-padding">
            <div class="w3-col l1 m1 s1"><?php print($dateLabel->format('m-d')); ?></div>
            <div class="w3-col l1 m1 s1">
              <select class="w3-select w3-border w3-round" name="workType[]">
                <option <?php if($trrow['workType']=='Tax'){ print('selected'); } ?> value="Tax">Tax</option>
                <option <?php if($trrow['workType']=='Edu'){ print('selected'); } ?> value="Edu">Edu</option>
              </select></div>
            <div class="w3-col l2 m2 s2"><input class="w3-input w3-border w3-round" type="time" step="900.0" value="<?php print($trrow['timeInAM']); ?>" name="timeInAM[]"/></div>
            <div class="w3-col l2 m2 s2"><input class="w3-input w3-border w3-round" type="time" step="900.0" value="<?php print($trrow['timeOutAM']); ?>" name="timeOutAM[]"/></div>
            <div class="w3-col l2 m2 s2"><input class="w3-input w3-border w3-round" type="time" step="900.0" value="<?php print($trrow['timeInPM']); ?>" name="timeInPM[]"/></div>
            <div class="w3-col l2 m2 s2"><input class="w3-input w3-border w3-round" type="time" step="900.0" value="<?php print($trrow['timeOutPM']); ?>" name="timeOutPM[]"/></div>
            <div class="w3-col l2 m2 s2"><input class="w3-input w3-border w3-round" type="text" value="<?php print($trrow['notes']); ?>" name="notes[]"/>
              <input type="hidden" value="<?php print($trrow['ID']); ?>" name="timerecordId[]"/></div>
          </div> <!-- end w3-row -->
        <?php endfor; ?>
        <p><input class="w3-btn-block w3-green w3-round" type="submit" value="Save Information" /></p>
        </form>
      </div> <!-- end w3-container -->
    </div> <!-- end w3-content -->

  </div> <!-- end w3-container -->

  <div class="w3-container w3-light-grey w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge"><i class="fa fa-clock-o w3-text-blue"></i> SweetTime!</h1>
    <h2 class="w3-margin w3-large">Web-Based Time Tracking System</h2>
    <p class="w3-margin w3-medium">Copyright (c) 2016 Troy Scott</p>
  </div> <!-- end w3-container -->

  <script src="mobile_navbar.js"></script>

</body>
</html>
