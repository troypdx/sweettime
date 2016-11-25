<!--
  Name: Troy Scott
  Date: August, 2016
  Email: troy_pdx@fastmail.fm
  Function: This module removes one Employee and all related Time Cards / Time Records.
-->

<?php
  require_once("logincheck.php");
  $employeeId = $_REQUEST['id'];
  require_once("../../db_connect.php");

  // Get any Time Cards related to the Employee
  $tcsql = 'SELECT ID FROM timecards WHERE employeeId = ' .$employeeId. ';';
  // echo $tcsql. '<br/>';
  // $tcresult = mysqli_query($con,$tcsql) or die(mysqli_error($con));
  $tcresult = mysqli_query($con,$tcsql);
  if ($tcresult) {
    // Delete Time Records related to each Time Card
    while ($tcrow = mysqli_fetch_array($tcresult)) {
      $trsql = 'DELETE FROM timerecords WHERE timecardId = ' .$tcrow['ID']. ';';
      //echo $trsql. '<br/>';
      mysqli_query($con,$trsql) or die(mysqli_error($con));
    }
    $tcsql = 'DELETE FROM timecards WHERE employeeId = ' .$employeeId. ';';
    //echo $tcsql. '<br/>';
    mysqli_query($con,$tcsql) or die(mysqli_error($con));
  }

  $empsql = 'DELETE FROM employees WHERE ID = ' .$employeeId. ';';
  //echo $empsql. '<br/>';
  mysqli_query($con,$empsql) or die(mysqli_error($con));

  //print("Employee " .$employeeId. " deleted from the database. <br/>");
  //print("Return to <a href='emp_view.php'>main page.</a>");

  header("Location: emp_view.php");
  exit;

?>
