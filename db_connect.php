<?php
  /*
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm
  Function: This module enables database access
  */

  $con = new mysqli("hostname", "database_user", "password", "database");
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " .mysqli_connect_error($con);
  }

?>
