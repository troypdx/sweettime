<?php
  /*
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm

  Function: Check log in credentials
  */

  // My session start function support timestamp management
  function my_session_start() {
    session_start();
    // Do not allow to use too old session ID
    if (!empty($_SESSION['deleted_time']) && $_SESSION['deleted_time'] < time() - 600) {
        session_destroy();
        session_start();
        header("Location: login.php");
        exit;
    }
  }

  // Make sure use_strict_mode is enabled.
  // use_strict_mode is mandatory for security reasons.
  ini_set('session.use_strict_mode', 1);
  my_session_start();

  if (!$_SESSION['loginOk']) {
    session_unset();
    session_destroy();
    session_start();
    header("Location: login.php");
    exit;
  }

?>
