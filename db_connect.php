<?php
  /*
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm
  Function: This module enables database access
  */

  $db_name = "your_database";
  $un = "your_username";
  $pw = "your_password";
  $host = "your_host";

  mysql_connect($host, $un, $pw) or die(mysql_error());
  // echo("</br>INFO: Connected to MySQL.");

  mysql_select_db($db_name) or die(mysql_error());
  // echo("</br>INFO: Database selected.");

?>
