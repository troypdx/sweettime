<!--
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm

  Function: This module removes one Time Card and all Time Records related to it.
-->

<?php

  require_once("logincheck.php");
  require_once("../../db_connect.php");

  $employeeId = $_SESSION['employeeId'];
  $timecardId = $_REQUEST['id'];

  $tcsql = "DELETE FROM timecards WHERE ID = '" .$timecardId. "';";
  //echo($tcsql. '<br/>');
  mysqli_query($con,$tcsql) or die(mysql_error($con));

  $trsql = "DELETE FROM timerecords WHERE timecardId = '" .$timecardId. "';";
  //echo($trsql. '<br/>');
  mysqli_query($con,$trsql) or die(mysql_error($con));

  //print("Timecard: " .$timecardId. " for Employee: " .$employeeId. " deleted from the database.<br/>");
  //print("Return to <a href='timecard_view.php?id=" .$employeeId. "'>main page.</a><br/>");

  header("Location: timecard_view.php?id=$employeeId");
  exit;

?>
