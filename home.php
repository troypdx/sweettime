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

?>

<!DOCTYPE html>
<html>
<head>
  <title>Home | SweetTime!</title>
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
    <div class="w3-content">

      <div class="w3-content w3-row">
        <div class="w3-third">
          <p>Employee ID: <?php print($employeeId); ?> <br/>
          Title: <?php print($employeeTitle); ?> <br/>
          Administrator: <?php print($adminFlag); ?> </p>
          <p class="w3-xlarge w3-text-light-blue">Hello <?php print($firstName. '!'); ?></p>
        </div>
        <div class="w3-twothird">
          <p>
          </p>
        </div>
      </div>

      <p>Welcome to SweetTime! a web-based time tracking system especially tailored for tax preparation firms. This administration page provides essential information about using the system to manage Employee profiles, Time Cards, and the reports available to SweetTime! administrators.</p>

      <h4>Time Tracking Essentials</h4>
      <p>Employees use SweetTime! to track work time with these features:</p>
      <ul>
        <li>Time Record Keeping - You can track time spent each day of the pay period on tax preparation (Tax) or education (Edu) tasks. Time In/Out events are constrained to 15 minute increments.</li>
        <li>Time Card View - Time Cards provide a summary of the total working hours with subtotals for Tax and Edu tasks. Regular and overtime hours are automatically accumulated for each Tax or Edu task. Time Cards are organized as two week pay periods with 14 days of Time Records. The system automatically prevents creation of Time Cards that have overlapping pay periods.</li>
      </ul>

      <h4>Administration Essentials</h4>
      <p>SweetTime! provides the following major features for administration of the time tracking system:</p>
      <ul>
        <li>Secure Access - Employees and administrators access the system using email and password credentials.</li>
        <li>Employee Management - You can add, edit, or delete employee profiles. Each profile includes essential information like name and e-mail address as well as an optional administration flag that gives an employee more control over the SweetTime! system.</li>
        <li>Time Card Management - You can add, edit, or delete Time Cards. Time Cards provide a summary of the working hours of each employee and what tasks they performed. Time Cards are organized as two week pay periods with 14 days of Time Records.</li>
        <li>Time Record Management - You can add, edit, or delete the individual Time Records that are associated with a Time Card. This is an advanced management feature that is rarely used.</li>
        <li>SweetTime! is written with the MySQL and PHP for easy deployment to in-house or cloud servers.</li>
      </ul>

    </div> <!-- end w3-content -->
  </div> <!-- end w3-container -->

  <div class="w3-container w3-light-grey w3-center w3-opacity w3-padding-64">
      <h1 class="w3-margin w3-xlarge"><i class="fa fa-clock-o w3-text-blue"></i> SweetTime!</h1>
      <h2 class="w3-margin w3-large">Web-Based Time Tracking System</h2>
      <p class="w3-margin w3-medium">Copyright (c) 2016 Troy Scott</p>
  </div>

  <script>
  // Used to toggle the menu on small screens when clicking on the menu button
  function myFunction() {
      var x = document.getElementById("navDemo");
      if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
      } else {
          x.className = x.className.replace(" w3-show", "");
      }
  }
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script>
  $(function() {
    $('a[href*="#"]:not([href="#"])').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          $('html, body').animate({
            scrollTop: target.offset().top
          }, 1000);
          return false;
        }
      }
    });
  });
  </script>

</body>
</html>
