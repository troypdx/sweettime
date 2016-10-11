<!--
  Name: Troy Scott
  Date: September, 2016
  Email: troy_pdx@fastmail.fm
-->

<?php
  session_start();
  $email = $_REQUEST["email"];
  $password = $_REQUEST["password"];
  require_once("../../db_connect.php");

  $empsql = 'SELECT ID,
      firstName,
      lastName,
      email,
      employeeTitle,
      password,
      adminFlag,
      rate
    FROM employees WHERE email = \'' .$email. '\';';
  // echo $empsql. '<br/>';

  $empresult = mysql_query($empsql) or die(mysql_error());
  $emprow = mysql_fetch_array($empresult);

?>

<!-- Create a HTML document if necessary to display user feedback -->
<!DOCTYPE html>
<html>
<title>Log In Failure | SweetTime!</title>
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
  <!-- SweetTime! banner -->
  <div class="w3-container w3-light-grey w3-center w3-large">
      <h1 class="w3-margin w3-xlarge"><i class="fa fa-clock-o w3-text-blue"></i> SweetTime!</h1>
      <h2 class="w3-margin w3-large">Web-Based Time Tracking System</h2>
  </div>

  <!-- Content -->
  <div class="w3-container w3-dark-grey w3-padding-64">
    <div class="w3-content">

      <div class="w3-content w3-row">
        <div class="w3-third">
          <p class="w3-xlarge w3-text-orange">Log In Failure</p>
        </div>
        <div class="w3-twothird">
          <?php
          if ($emprow) {
            $employeeId = $emprow['ID'];
            print("<p>Confirmed " .$emprow['email']. " is a registered user. ");

            if (password_verify($password, $emprow['password'])) {
            //if ($password == $emprow['password']) {
            //if ($email == $emprow['email']) {
              session_regenerate_id();
              //print("Confirmed " .$emprow['password']. " is the correct password.<br/>");
              //print("Continue to the <a href='timecard_view.php?id=$employeeId'>Time Card View</a>.<br/>");
              $_SESSION['loginOk'] = TRUE;

              $_SESSION['employeeId'] = $employeeId;
              $_SESSION['firstName'] = $emprow['firstName'];
              $_SESSION['lastName'] = $emprow['lastName'];
              $_SESSION['email'] = $emprow['email'];
              $_SESSION['employeeTitle'] = $emprow['employeeTitle'];
              $_SESSION['adminFlag'] = $emprow['adminFlag'];
              $_SESSION['rate'] = $emprow['rate'];

              header("Location: timecard_view.php?id=$employeeId");
              exit;
            }
            else {
              print("However, the password is incorrect. <br/>Contact an administrator if you're unable to access the system.</p>");
              print("<p>Return to the <a href='login.php'>Log In</a>.</p>");
              //header("Location: login.php");
              //exit;
            }
          } else {
            print("<p>" .$email. " is not a recognized user. <br/>Contact an administrator if you're unable to access the system.</p>");
            print("<p>Return to the <a href='login.php'>Log In</a>.</p>");
            //header("Location: login.php");
            //exit;
          }
          ?>

        </div>
      </div>
    </div> <!-- end w3-content -->
  </div> <!-- end w3-container -->

</body>
</html>
