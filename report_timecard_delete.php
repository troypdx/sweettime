<!--
  Name: Troy Scott
  Date: September, 2016
  Email: troy_pdx@fastmail.fm
-->

<?php
  require_once("logincheck.php");
  require_once("../../db_connect.php");

  $timecardId = $_REQUEST['id'];

  $tcsql = "DELETE FROM timecards WHERE ID = '" .$timecardId. "';";
  // echo($tcsql. '<br/>');
  mysqli_query($con,$tcsql) or die(mysqli_error($con));

  $trsql = "DELETE FROM timerecords WHERE timecardId = '" .$timecardId. "';";
  mysqli_query($con,$trsql) or die(mysqli_error($con));
  // echo($trsql. '<br/>');

  // print("Timecard: " .$timecardId. " for Employee: " .$employeeId. " deleted from the database.<br/>");
  // print("Return to <a href='report_timecards.php'>main page.</a><br/>");

  header("Location: report_timecards.php");
  exit;

?>
