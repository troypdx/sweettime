<!--
  Name: Troy Scott
  Date: September, 2016
  Email: troy_pdx@fastmail.fm
  Function: Delete all Time Records for a particular Time Card
-->

<?php
  require_once("logincheck.php");
  require_once("../../db_connect.php");
  $timecardId = $_POST["timecardId"];
  $sql = 'DELETE FROM timerecords WHERE timecardId = ' .$timecardId. ';';
  // echo $sql. '<br/>';
  mysql_query($sql) or die(mysql_error());

  //print("Time Records for Time Card: " .$timecardId. " deleted from the database.");
  //print("Return to the <a href='report_timerecs.php'>Time Record Administration</a>");

  header("Location: report_timerecs.php");
  exit;

?>
