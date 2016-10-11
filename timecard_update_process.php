<!--
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm
  Function: Update Time Records.
-->

<?php
  function time_to_decimal($time) {
    $timeArr = explode(':', $time);
    $decTime = $timeArr[0] + ($timeArr[1]/60);

    return $decTime;
  }

  require_once("logincheck.php");
  require_once("../../db_connect.php");

  $timerecordId = $_REQUEST['timerecordId'];
  $workType = $_REQUEST['workType'];
  $timeInAM = $_REQUEST['timeInAM'];
  $timeOutAM = $_REQUEST['timeOutAM'];
  $timeInPM = $_REQUEST['timeInPM'];
  $timeOutPM = $_REQUEST['timeOutPM'];
  $notes = $_REQUEST['notes'];

  session_start();
  $requestTimeCardId = $_SESSION['requestTimeCardId'];
  $requestEmployeeId = $_SESSION['requestEmployeeId'];

?>

<!-- Create a HTML document if necessary to display user feedback -->
<!DOCTYPE html>
<html>
<title>Edit Time Card Error | SweetTime!</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<style>
  body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
  .w3-navbar,h1,button {font-family: "Montserrat", sans-serif}
</style>
<body>
  <!-- Navbar -->
  <ul class="w3-navbar w3-light-blue w3-card-2 w3-top w3-left-align w3-large">
    <li class="w3-hide-medium w3-hide-large w3-opennav w3-right">
      <a class="w3-padding-large w3-hover-white w3-large w3-light-blue" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    </li>
    <li><a href="timecard_view.php?id=<?php print($requestEmployeeId); ?>" class="w3-xlarge w3-padding-medium w3-white"><i class="fa fa-clock-o"></i></a></li>
  </ul>
  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:51px">
    <ul class="w3-navbar w3-left-align w3-large w3-black">
      <li><a class="w3-padding-large" href="timecard_view.php?id=<?php print($requestEmployeeId); ?>">Time Cards</a></li>
    </ul>
  </div>

<!-- Content -->
<div class="w3-container w3-dark-grey w3-padding-64">
  <div class="w3-content">

    <?php
    // Update 14 Time Records of the Time Card
    for ($key = 0; $key <= 13; $key++) {

      // Calculate hours accumulated per Time Record
      $startAM = new DateTime($timeInAM[$key]);
      $sincestartAM = $startAM->diff(new DateTime($timeOutAM[$key]));
      $hrsAM[$key] = time_to_decimal($sincestartAM->h.':'.$sincestartAM->i);
      $startPM = new DateTime($timeInPM[$key]);
      $sincestartPM = $startPM->diff(new DateTime($timeOutPM[$key]));
      $hrsPM[$key] = time_to_decimal($sincestartPM->h.':'.$sincestartPM->i);
      if ($workType[$key] == "Tax") {
        $hrsTax[$key] = $hrsAM[$key] + $hrsPM[$key];
        $hrsEdu[$key] = 0;
      } else {
        $hrsTax[$key] = 0;
        $hrsEdu[$key] = $hrsAM[$key] + $hrsPM[$key];
      }
      $dailyLimit = $hrsAM[$key] + $hrsPM[$key];

      // Detect Time Records that exceeds daily limit
      if ($dailyLimit > 24) {
        $hrLimit = TRUE;
        break;
      }

      // Detect cases of zero hours and insert NULL into database for related fields
      if ($hrsAM[$key]==0 && $hrsPM[$key]==0) {
        $trsql = 'UPDATE timerecords SET
            timeInAM=NULL,
            timeOutAM=NULL,
            hrsAM=NULL,
            timeInPM=NULL,
            timeOutPM=NULL,
            hrsPM=NULL,
            notes=\''.$notes[$key].'\',
            workType=\''.$workType[$key].'\',
            hrsTax=NULL,
            hrsEdu=NULL,
            timecardId=\''.$requestTimeCardId.'\'
          WHERE ID='.$timerecordId[$key].';';
      } elseif ($hrsAM[$key]==0) {
      $trsql = 'UPDATE timerecords SET
          timeInAM=NULL,
          timeOutAM=NULL,
          hrsAM=NULL,
          timeInPM =\''.$timeInPM[$key].'\',
          timeOutPM=\''.$timeOutPM[$key].'\',
          hrsPM=\''.$hrsPM[$key].'\',
          notes=\''.$notes[$key].'\',
          workType=\''.$workType[$key].'\',
          hrsTax=\''.$hrsTax[$key].'\',
          hrsEdu=\''.$hrsEdu[$key].'\',
          timecardId=\''.$requestTimeCardId.'\'
        WHERE ID='.$timerecordId[$key].';';
      } elseif ($hrsPM[$key]==0) {
        $trsql = 'UPDATE timerecords SET
            timeInAM=\''.$timeInAM[$key].'\',
            timeOutAM=\''.$timeOutAM[$key].'\',
            hrsAM=\''.$hrsAM[$key].'\',
            timeInPM=NULL,
            timeOutPM=NULL,
            hrsPM=NULL,
            notes=\''.$notes[$key].'\',
            workType=\''.$workType[$key].'\',
            hrsTax=\''.$hrsTax[$key].'\',
            hrsEdu=\''.$hrsEdu[$key].'\',
            timecardId=\''.$requestTimeCardId.'\'
          WHERE ID='.$timerecordId[$key].';';
      } else {
        $trsql = 'UPDATE timerecords SET
            timeInAM=\''.$timeInAM[$key].'\',
            timeOutAM=\''.$timeOutAM[$key].'\',
            hrsAM=\''.$hrsAM[$key].'\',
            timeInPM=\''.$timeInPM[$key].'\',
            timeOutPM=\''.$timeOutPM[$key].'\',
            hrsPM=\''.$hrsPM[$key].'\',
            notes=\''.$notes[$key].'\',
            workType=\''.$workType[$key].'\',
            hrsTax=\''.$hrsTax[$key].'\',
            hrsEdu=\''.$hrsEdu[$key].'\',
            timecardId =\''.$requestTimeCardId.'\'
          WHERE ID='.$timerecordId[$key].';';
      }
      // echo $trsql.'<br/>';
      mysql_query($trsql);

    } /* End for loop */

    // If a case of a Time Record >24Hrs then report error
    if ($hrLimit) {
      print('<p class="w3-xlarge w3-text-orange">Sorry! Edit Time Card Did Not Complete Successfully</p>');
      print('<p>ERROR: Time Record >24 Hours<br/>
        SweetTime! cannot log more than 24 hours of time per day. And on top of that is a violation of the space-time continuum.<br/><br/>
        Review the times entered or consult with your Payroll Administrator if you need to modify an existing Time Card.</p>');

      print('A faulty record of ' .$dailyLimit. ' hours was detected.</p>');
      print('
      <table class="w3-table w3-bordered w3-medium">
        <tr>
          <th>Time</br>Record ID</th>
          <th>Work</br>Type</th>
          <th>Time</br>In</th>
          <th>Time</br>Out</th>
          <th>Hrs</br>AM</th>
          <th>Time</br>In</th>
          <th>Time</br>Out</th>
          <th>Hrs</br>PM</th>
          <th>Hrs</br>Tax</th>
          <th>Hrs</br>Edu</th>
        </tr>
        <tr>
          <td>' .$key. '</td>
          <td>' .$workType[$key]. '</td>
          <td>' .$timeInAM[$key]. '</td>
          <td>' .$timeOutAM[$key]. '</td>
          <td>' .$hrsAM[$key]. '</td>
          <td>' .$timeInPM[$key]. '</td>
          <td>' .$timeOutPM[$key]. '</td>
          <td>' .$hrsPM[$key]. '</td>
          <td>' .$hrsTax[$key]. '</td>
          <td>' .$hrsEdu[$key]. '</td>
        </tr>
      </table>');
      print('<p>Return to <a href="timecard_update.php?id='.$requestTimeCardId.'">Edit Time Card: '.$requestTimeCardId.'</a></p>');

    } else {
      // Query the updated Time Records in order to update the related Time Card
      $trsql = 'SELECT
          ID, timecardId, date, workType,
          timeInAM, timeOutAM, hrsAM,
          timeInPM, timeOutPM, hrsPM,
          notes, hrsTax, hrsEdu, payRate
        FROM timerecords WHERE timecardId='.$requestTimeCardId.';';
      // echo($trsql. '<br/>');
      $trresult = mysql_query($trsql) or die(mysql_error());

      // Calculate Week 1 Regular and OT Hours
      for ($key = 0; $key <= 6; $key++) {
        $trrow = mysql_fetch_array($trresult);
        // Calculate Tax Hours
        if ($trrow['hrsTax'] + $subTotalRegWk1Tax + $subTotalRegWk1Edu <= 40) {
          // If sum of new record's Tax hrs. and Total Wk1 hrs. < 40, then continue accumulating Reg Tax hrs.
          $subTotalRegWk1Tax = $subTotalRegWk1Tax + $trrow['hrsTax'];
        } else {
          $recOT = $trrow['hrsTax'] + $subTotalRegWk1Tax + $subTotalRegWk1Edu - 40;
          $recReg = $trrow['hrsTax'] - $recOT;
          $subTotalOTWk1Tax = $subTotalOTWk1Tax + $recOT;
          $subTotalRegWk1Tax = $subTotalRegWk1Tax + $recReg;
        }
        // echo $key. ': ' .$trrow['hrsTax']. ' hrsTax, ' .$subTotalRegWk1Tax. ' RegWk1Tax, ' .$subTotalOTWk1Tax. ' OTWk1Tax<br>';
        // Calculate Edu Hours
        if ($trrow['hrsEdu'] + $subTotalRegWk1Edu + $subTotalRegWk1Tax <= 40) {
          $subTotalRegWk1Edu = $subTotalRegWk1Edu + $trrow['hrsEdu'];
        } else {
          $recOT = $trrow['hrsEdu'] + $subTotalRegWk1Edu + $subTotalRegWk1Tax - 40;
          $recReg = $trrow['hrsEdu'] - $recOT;
          $subTotalOTWk1Edu = $subTotalOTWk1Edu + $recOT;
          $subTotalRegWk1Edu = $subTotalRegWk1Edu + $recReg;
        }
        // echo $key. ': ' .$trrow['hrsEdu']. ' hrsEdu, ' .$subTotalRegWk1Edu. ' RegWk1Edu, ' .$subTotalOTWk1Edu. ' OTWk1Edu<br>';
      }

      // Calculate Week 2 Regular and OT Hours
      for ($key = 7; $key <= 13; $key++) {
        $trrow = mysql_fetch_array($trresult);
        // Calculate Tax Hours
        if ($trrow['hrsTax'] + $subTotalRegWk2Tax + $subTotalRegWk2Edu <= 40) {
          // If sum of new record's Tax hrs. and Total Wk2 hrs. < 40, then continue accumulating Reg Tax hrs.
          $subTotalRegWk2Tax = $subTotalRegWk2Tax + $trrow['hrsTax'];
        } else {
          $recOT = $trrow['hrsTax'] + $subTotalRegWk2Tax + $subTotalRegWk2Edu - 40;
          $recReg = $trrow['hrsTax'] - $recOT;
          $subTotalOTWk2Tax = $subTotalOTWk2Tax + $recOT;
          $subTotalRegWk2Tax = $subTotalRegWk2Tax + $recReg;
        }
        // echo $key. ': ' .$trrow['hrsTax']. ' hrsTax, ' .$subTotalRegWk2Tax. ' RegWk2Tax, ' .$subTotalOTWk2Tax. ' OTWk2Tax<br>';
        // Calculate Edu Hours
        if ($trrow['hrsEdu'] + $subTotalRegWk2Edu + $subTotalRegWk2Tax <= 40) {
          $subTotalRegWk2Edu = $subTotalRegWk2Edu + $trrow['hrsEdu'];
        } else {
          $recOT = $trrow['hrsEdu'] + $subTotalRegWk2Edu + $subTotalRegWk2Tax - 40;
          $recReg = $trrow['hrsEdu'] - $recOT;
          $subTotalOTWk2Edu = $subTotalOTWk2Edu + $recOT;
          $subTotalRegWk2Edu = $subTotalRegWk2Edu + $recReg;
        }
        // echo $key. ': ' .$trrow['hrsEdu']. ' hrsEdu, ' .$subTotalRegWk2Edu. ' RegWk2Edu, ' .$subTotalOTWk2Edu. ' OTWk2Edu<br>';
      }

      $twoWeekTotalRegTax = $subTotalRegWk1Tax + $subTotalRegWk2Tax;
      $twoWeekTotalOTTax  = $subTotalOTWk1Tax + $subTotalOTWk2Tax;

      $twoWeekTotalRegEdu = $subTotalRegWk1Edu + $subTotalRegWk2Edu;
      $twoWeekTotalOTEdu  = $subTotalOTWk1Edu + $subTotalOTWk2Edu;

      $twoWeekTotalComb   = $twoWeekTotalRegTax + $twoWeekTotalRegEdu + $twoWeekTotalOTTax + $twoWeekTotalOTEdu;

      /*
      echo 'Two Wk Total Reg Tax '.$twoWeekTotalRegTax.' Hrs.<br/>';
      echo 'Two Wk Total Reg Edu '.$twoWeekTotalRegEdu.' Hrs.<br/>';
      echo 'Two Wk Total OT Tax '.$twoWeekTotalOTTax.' Hrs.<br/>';
      echo 'Two Wk Total OT Edu '.$twoWeekTotalOTEdu.' Hrs.<br/>';
      echo 'Two Wk Total Comb '.$twoWeekTotalComb.' Hrs.<br/>';
      */

      $tcsql= 'UPDATE timecards SET
          subTotalRegWk1Tax  =\''.$subTotalRegWk1Tax.  '\',
          subTotalRegWk1Edu  =\''.$subTotalRegWk1Edu.  '\',
          subTotalOTWk1Tax   =\''.$subTotalOTWk1Tax.   '\',
          subTotalOTWk1Edu   =\''.$subTotalOTWk1Edu.   '\',
          subTotalRegWk2Tax  =\''.$subTotalRegWk2Tax.  '\',
          subTotalRegWk2Edu  =\''.$subTotalRegWk2Edu.  '\',
          subTotalOTWk2Tax   =\''.$subTotalOTWk2Tax.   '\',
          subTotalOTWk2Edu   =\''.$subTotalOTWk2Edu.   '\',
          twoWeekTotalRegTax =\''.$twoWeekTotalRegTax. '\',
          twoWeekTotalRegEdu =\''.$twoWeekTotalRegEdu. '\',
          twoWeekTotalOTTax  =\''.$twoWeekTotalOTTax.  '\',
          twoWeekTotalOTEdu  =\''.$twoWeekTotalOTEdu.  '\',
          twoWeekTotalComb   =\''.$twoWeekTotalComb.   '\'
        WHERE ID='.$requestTimeCardId.';';
      // echo $tcsql.'<br/>';

      mysql_query($tcsql);
      mysql_close($conn);

      //echo('Time Card ID: '.$requestTimeCardId.' successfully updated.<br/>');
      //echo('Go back to <a href="timerec_view.php?id='.$requestTimeCardId.'">Time Card Details.</a>');

      header("Location: timerec_view.php?id=$requestTimeCardId");
      exit;
    }

    ?>

  </div> <!-- end w3-content -->
</div> <!-- end w3-container -->

<div class="w3-container w3-light-grey w3-center w3-opacity w3-padding-64">
  <h1 class="w3-margin w3-xlarge"><i class="fa fa-clock-o w3-text-blue"></i> SweetTime!</h1>
  <h2 class="w3-margin w3-large">Web-Based Time Tracking System</h2>
  <p class="w3-margin w3-medium">Copyright (c) 2016 Troy Scott</p>
</div> <!-- end w3-container -->

</body>
</html>
