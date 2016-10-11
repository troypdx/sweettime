<!--
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm
  Function: This module enables the database access.
-->

<?php
  require_once("logincheck.php");
  require_once("../../db_connect.php");

  $last = $_REQUEST['last'];
  $first= $_REQUEST['first'];
  $email= $_REQUEST['email'];
  $title= $_REQUEST['title'];
  $password= $_REQUEST['password'];
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $administrator= $_REQUEST['administrator'];
  $rate= $_REQUEST['rate'];

  $sql= "INSERT INTO employees (
      firstName,
      lastName,
      eMail,
      employeeTitle,
      password,
      adminFlag,
      rate)
    VALUES (
      '" .$first. "',
      '" .$last. "',
      '" .$email. "',
      '" .$title. "',
      '" .$hash. "',
      '" .$administrator. "',
       " .$rate. ");";

  //echo $sql. '<br/>';

  mysql_query($sql);
  mysql_close($conn);

  //echo($last . " successfully added to the database.");
  //echo("<br/>Go back to <a href='emp_view.php'>main page.</a>")

  header("Location: emp_view.php");
  exit;

?>
