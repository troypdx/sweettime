<!--
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm
-->

<?php
  require_once("logincheck.php");
  require_once("../../db_connect.php");

  $employeeId = $_REQUEST['id'];
  $last = $_REQUEST['last'];
  $first= $_REQUEST['first'];
  $email= $_REQUEST['email'];
  $title= $_REQUEST['title'];
  $password= $_REQUEST['password'];
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $administrator= $_REQUEST['administrator'];
  $rate= $_REQUEST['rate'];

  // $sql = "SELECT ID, employees.employeeId, firstName, lastName, email, employeeTitle, password, adminFlag, rate FROM employees" . ";";

  $empsql= "UPDATE employees SET
          firstName='" .$first. "',
          lastName='" .$last. "',
          eMail='" .$email. "',
          employeeTitle='" .$title. "',
          password='" .$hash. "',
          adminFlag='" .$administrator. "',
          rate=" .$rate. " WHERE ID=" .$employeeId. ";";

  echo $empsql. '<br/>';

  mysql_query($empsql);
  mysql_close($conn);

  //echo($employeeId. " successfully updated.<br/>");
  //echo("<br/>Go back to <a href='emp_view.php'>main page.</a>")

  $_SESSION["authorized"] = true;
  session_regenerate_id();

  header("Location: emp_view.php");
  exit;

?>
