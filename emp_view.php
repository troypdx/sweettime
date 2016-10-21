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
  $sql = 'SELECT
      ID,
      firstName,
      lastName,
      email,
      employeeTitle,
      password,
      adminFlag,
      rate
    FROM employees;';
  $result = mysql_query($sql) or die(mysql_error());
?>

<html>
<head>
  <title>Employees | SweetTime</title>
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
        <p class="w3-xlarge w3-text-light-blue">Manage Employees</p>
      </div>
      <div class="w3-twothird">
        <p>This is the Employee administration page. You can Add, Edit, or Delete an Employee profile. You can also access the Time Cards related to each employee. Note that Delete removes all Time Cards and Time Records related to the Employee. Use Delete with caution.
        </p>
      </div>
    </div>

    <div class="w3-content">
      <div class="w3-responsive">
        <p>why black font?</p>
        <table class="w3-table w3-bordered w3-medium w3-text-white">
          <tr>
            <th>Employee<br/>Id</th>
            <th>Last<br/>Name</th>
            <th>First<br/>Name</th>
            <th>Email<br/>Address</th>
            <th>Job<br/>Title</th>
            <th><br/>Administrator</th>
            <th>Hourly<br/>Rate</th>
            <th>Time<br/>Cards</th>
            <th><br/>Edit</th>
            <th><br/>Delete</th>
          </tr>
          <?php
            while($row = mysql_fetch_array($result)) {
              /* Production Version
              print('<tr>
              <td>' .$row['ID']. '</td>
              <td>' .$row['lastName']. '</td>
              <td>' .$row['firstName']. '</td>
              <td>' .$row['email']. '</td>
              <td>' .$row['employeeTitle']. '</td>
              <td>' .$row['adminFlag']. '</td>
              <td>' .$row['rate']. '</td>
              <td><a href=\'timecard_view.php?id=' .$row['ID']. '\'><i class="fa fa-stack-overflow w3-text-blue w3-margin-right"></i></a></td>
              <td><a href=\'emp_update.php?id=' .$row['ID']. '\'><i class="fa fa-pencil w3-text-green w3-margin-right"></i></a></td>
              <td><a href=\'emp_delete.php?id=' .$row['ID']. '\'><i class="fa fa-remove w3-text-red w3-margin-right"></i></a></td></tr>');
              */
              print('<tr>
              <td>' .$row['ID']. '</td>
              <td>' .$row['lastName']. '</td>
              <td>' .$row['firstName']. '</td>
              <td>' .$row['email']. '</td>
              <td>' .$row['employeeTitle']. '</td>
              <td>' .$row['adminFlag']. '</td>
              <td>' .$row['rate']. '</td>
              <td><a href=\'timecard_view.php?id=' .$row['ID']. '\'><i class="fa fa-stack-overflow w3-text-blue w3-margin-right"></i></a></td>
              <td><i class="fa fa-pencil w3-text-white w3-margin-right"></i></td>
              <td><i class="fa fa-remove w3-text-white w3-margin-right"></i></td></tr>');
            }
          ?>
        </table>
      </div> <!-- end w3-responsive -->
      <p>
      <form action="emp_insert_process.php?id=$row['ID']" method="post">
        <table class="w3-table w3-medium w3-text-white">
          <tr>
            <td colspan=2></td>
            <th><p w3-text-light-blue>New Employee Information:</p></th>
            <td colspan=3></td>
          </tr>
          <tr>
            <td colspan=2></td>
            <td>First Name:</td>
            <td><input type="text" name="first"/></td>
            <td>Last Name:</td>
            <td><input type="text" name="last"/></td>
          </tr>
          <tr>
            <td colspan=2></td>
            <td>Email Address:</td>
            <td><input type="text" name="email"/></td>
            <td>Job Title:</td>
            <td><input type="text" name="title"/></td>
          </tr>
          <tr>
            <td colspan=2></td>
            <td>Password:</td>
            <td><input type="password" name="password"/></td>
            <td>Administrator</td>
            <td><select name="administrator">
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select></td>
          </tr>
          <tr>
            <td colspan=2></td>
            <td>Rate:</td>
            <td><input type="text" name="rate"/></td>
            <td></td>
            <td><input class="w3-btn w3-green w3-round" type="submit" value="Add Employee" /></td>
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
