<!--
  Name: Troy Scott
  Date: October, 2016
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
  // $tcresult = mysql_query($tcsql) or die(mysql_error());
  $tcresult = mysql_query($tcsql);
  if ($tcresult) {
    // Delete Time Records related to each Time Card
    while ($tcrow = mysql_fetch_array($tcresult)) {
      $trsql = 'DELETE FROM timerecords WHERE timecardId = ' .$tcrow['ID']. ';';
      //echo $trsql. '<br/>';
      mysql_query($trsql) or die(mysql_error());
    }
    $tcsql = 'DELETE FROM timecards WHERE employeeId = ' .$employeeId. ';';
    //echo $tcsql. '<br/>';
    mysql_query($tcsql) or die(mysql_error());
  }

  $empsql = 'DELETE FROM employees WHERE ID = ' .$employeeId. ';';
  //echo $empsql. '<br/>';
  mysql_query($empsql) or die(mysql_error());

  //print("Employee " .$employeeId. " deleted from the database. <br/>");
  //print("Return to <a href='emp_view.php'>main page.</a>");

  header("Location: emp_view.php");
  exit;

?>
