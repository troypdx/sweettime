<!--
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm
-->

<?php
  require_once("logincheck.php");
  require_once("../../db_connect.php");

  $employeeId = $_REQUEST['id'];
  $empsql = 'SELECT ID,
      firstName,
      lastName,
      email,
      employeeTitle,
      password,
      adminFlag,
      rate
    FROM employees WHERE ID=' .$employeeId. ';';

  // echo($empsql);
  $empresult = mysql_query($empsql) or die(mysql_error());
  $emprow = mysql_fetch_array($empresult) or die(mysql_error());

?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Employee | SweetTime!</title>
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
    <li class="w3-hide-small"><a href="logout_process.php" class="w3-padding-large w3-hover-white">Log Out</a></li>
  </ul>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:51px">
    <ul class="w3-navbar w3-left-align w3-large w3-black">
      <li><a class="w3-padding-large" href="home.php">Home</a></li>
      <li><a class="w3-padding-large" href="logout_process.php">Log Out</a></li>
    </ul>
  </div>

  <!-- Content -->
  <div class="w3-container w3-dark-grey w3-padding-64">
    <div class="w3-content">
      <p><a href="emp_view.php">Employees</a></p>

      <p class="w3-xlarge w3-text-light-blue">Edit Employee</p>

      <form action="emp_update_process.php?id=<?php print($employeeId); ?>" method="post">
        <table class="w3-table w3-medium">
          <tr>
            <td colspan=2></td>
            <td>First Name:</td>
            <td><input type="text" value="<?php print($emprow['firstName']) ?>" name="first"/></td>
            <td>Last Name:</td>
            <td><input type="text" value="<?php print($emprow['lastName']) ?>" name="last"/></td>
          </tr>
          <tr>
            <td colspan=2></td>
            <td>Email Address:</td>
            <td><input type="text" value="<?php print($emprow['email']) ?>" name="email"/></td>
            <td>Job Title:</td>
            <td><input type="text" value="<?php print($emprow['employeeTitle']) ?>" name="title"/></td>
          </tr>
          <tr>
            <td colspan=2></td>
            <td>Password:</td>
            <td><input type="password" value="<?php print($emprow['password']) ?>" name="password"/></td>
            <td>Administrator</td>
            <td><select name="administrator">
              <option <?php if($emprow['adminFlag']=='Yes'){ print('selected'); } ?> value="Yes">Yes</option>
              <option <?php if($emprow['adminFlag']=='No'){ print('selected'); } ?> value="No">No</option>
            </select></td>
          </tr>
          <tr>
            <td colspan=2></td>
            <td>Rate:</td>
            <td><input type="text" value="<?php print($emprow['rate']) ?>" name="rate"/></td>
            <td></td>
            <td><input class="w3-btn w3-color-green w3-round" type="submit" value="Update Information" /></td>
          </tr>
        </table>
      </form>

    </div> <!-- end w3-content -->
  </div> <!-- end w3-container -->

  <div class="w3-container w3-light-grey w3-center w3-opacity w3-padding-64">
      <h1 class="w3-margin w3-xlarge"><i class="fa fa-clock-o w3-text-blue"></i> SweetTime!</h1>
      <h2 class="w3-margin w3-large">Web-Based Time Tracking System</h2>
      <p class="w3-margin w3-medium">Copyright (c) 2016 Troy Scott</p>
  </div>

</body>
</html>
