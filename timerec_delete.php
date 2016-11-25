<!--
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm
-->

<?php

  session_start();
  $timecardId = $_SESSION['timecardId'];
  $timerecordId = $_REQUEST['id'];
  require_once("../../db_connect.php");
  $sql = "DELETE FROM timerecords WHERE ID = '" .$timerecordId. "';";
  //echo($sql);
  mysqli_query($con,$sql) or die(mysqli_error($con));
  //print("Time Record " . $id . " deleted from the database.");
  //print("Return to the <a href='timerec_view.php'>Time Record view.</a>");
  header("Location: timerec_view.php?id=$timecardId");
  exit;

?>
