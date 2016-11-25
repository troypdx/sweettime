<!--
  Name: Troy Scott
  Date: September, 2016
  Email: troy_pdx@fastmail.fm
-->

<?php
  require_once("logincheck.php");
  require_once("../../db_connect.php");
  $timecardId = $_POST["timecardId"];
  $sql = 'DELETE FROM timerecords WHERE timecardId = ' .$timecardId. ';';
  // echo $sql. '<br/>';
  mysqli_query($con,$sql) or die(mysqli_error($con));

  //print("Time Records for Time Card: " .$timecardId. " deleted from the database.");
  //print("Return to the <a href='report_timerecs.php'>Time Record Administration</a>");

  header("Location: report_timerecs.php");
  exit;

?>
