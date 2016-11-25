<!--
  Name: Troy Scott
  Date: September, 2016
  Email: troy_pdx@fastmail.fm
-->

<?php

  function time_to_decimal($time) {
    $timeArr = explode(':', $time);
    $decTime = $timeArr[0] + ($timeArr[1]/60);

    return $decTime;
  }

  require_once("../../db_connect.php");

  session_start();
  $payRate = $_SESSION['rate'];
  $timecardId = $_SESSION['timecardId'];

  $date = $_REQUEST['date'];
  $workType = $_REQUEST['workType'];
  $timeInAM = $_REQUEST['timeInAM'];
  $timeOutAM = $_REQUEST['timeOutAM'];
  $timeInPM = $_REQUEST['timeInPM'];
  $timeOutPM = $_REQUEST['timeOutPM'];
  $notes = $_REQUEST['notes'];

  foreach( $date as $key => $n ) {
    echo $key . '<br>';
    $startAM = new DateTime($timeInAM[$key]);
    $sincestartAM = $startAM->diff(new DateTime($timeOutAM[$key]));
    $hrsAM[$key] = time_to_decimal($sincestartAM->h.':'.$sincestartAM->i);

    $startPM = new DateTime($timeInPM[$key]);
    $sincestartPM = $startPM->diff(new DateTime($timeOutPM[$key]));
    $hrsPM[$key] = time_to_decimal($sincestartPM->h.':'.$sincestartPM->i);

    // echo $workType[$key].'<br>';
    if ($workType[$key] == "Tax") {
      $hrsTax[$key] = $hrsAM[$key] + $hrsPM[$key];
      $hrsEdu[$key] = 0;
    } else {
      $hrsTax[$key] = 0;
      $hrsEdu[$key] = $hrsAM[$key] + $hrsPM[$key];
    }

    $sql= "INSERT INTO timerecords (
        date, timeInAM, timeOutAM, timeInPM, timeOutPM, hrsAM, hrsPM,
        notes, workType, payRate, hrsTax, hrsEdu, timecardId )
      VALUES (
        '".$date[$key]."',".
        "'".$timeInAM[$key]."',".
        "'".$timeOutAM[$key]."',".
        "'".$timeInPM[$key]."',".
        "'".$timeOutPM[$key]."',".
        $hrsAM[$key].",".
        $hrsPM[$key].",".
        "'".$notes[$key]."',".
        "'".$workType[$key]."',".
        $payRate.",".
        $hrsTax[$key].",".
        $hrsEdu[$key].",".
        $timecardId.");";

        //echo $sql.'<br/>';
        mysqli_query($con,$sql);
  }
  mysqli_close($conn);

  /*
  echo("<br/>Time Record(s) for Time Card: ".$timecardId." successfully added to the database.");
  echo("<br/>Go back to the <a href='timerec_view.php?id=$timecardId'>Time Record view.</a>")
  */

  header("Location: timerec_view.php?id=$timecardId");
  exit;

?>
