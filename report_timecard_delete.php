<!--
  Name: Troy Scott
  Date: September, 2016
  Email: troy_pdx@fastmail.fm
  Function: Delete a Time Card and related Time Records
-->

<?php
  require_once("logincheck.php");
  require_once("../../db_connect.php");

  $timecardId = $_REQUEST['id'];

  $tcsql = "DELETE FROM timecards WHERE ID = '" .$timecardId. "';";
  // echo($tcsql. '<br/>');
  mysql_query($tcsql) or die(mysql_error());

  $trsql = "DELETE FROM timerecords WHERE timecardId = '" .$timecardId. "';";
  mysql_query($trsql) or die(mysql_error());
  // echo($trsql. '<br/>');

  // print("Timecard: " .$timecardId. " for Employee: " .$employeeId. " deleted from the database.<br/>");
  // print("Return to <a href='report_timecards.php'>main page.</a><br/>");

  header("Location: report_timecards.php");
  exit;

?>
