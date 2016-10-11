<!--
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm
-->

<?php
  session_start();
  session_unset();
  session_destroy();
  session_start();

  header("Location: login.php");
  exit;

?>
