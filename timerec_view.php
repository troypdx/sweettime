<!--
  Name: Troy Scott
  Date: September, 2016
  Email: troy_pdx@fastmail.fm
  Function: View the details of the requested Time Card
-->

<?php
  require_once("logincheck.php");
  require_once("../../db_connect.php");

  $requestTimeCardId = $_REQUEST['id'];

  session_start();
  // $requestEmployeeId = $_SESSION['requestEmployeeId'];
  $employeeId = $_SESSION['employeeId'];
  $firstName = $_SESSION['firstName'];
  $lastName = $_SESSION['lastName'];
  $employeeTitle = $_SESSION['employeeTitle'];
  $adminFlag = $_SESSION['adminFlag'];
  $rate = $_SESSION['rate'];

  // Fetch Employee ID for the requested Time Card
  $tcsql = 'SELECT employeeId FROM timecards WHERE ID='.$requestTimeCardId.';';
  //echo $tcsql. '<br/>';
  $tcresult = mysql_query($tcsql) or die(mysql_error());
  $tcrow = mysql_fetch_array($tcresult);
  $requestEmployeeId = $tcrow['employeeId'];

  // Fetch Employee details related to the requsted Time Card
  $empsql = 'SELECT
      ID,
      firstName,
      lastName,
      employeeTitle,
      adminFlag,
      rate
    FROM employees WHERE ID='.$requestEmployeeId.';';
  // echo $empsql.'<br/>';
  $empresult = mysql_query($empsql) or die(mysql_error());
  $emprow = mysql_fetch_array($empresult) or die(mysql_error());

?>

<!DOCTYPE html>
<html>
<head>
  <title>Time Records | SweetTime!</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

  <!-- Essentials for Morris.js Charts -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

  <style>
    body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
    .w3-navbar,h1,button {font-family: "Montserrat", sans-serif}
    .fa-tree,.fa-briefcase,.fa-file-text,.fa-coffee {font-size:200px}
  </style>

</head>
<body>
  <!-- Navbar -->
  <ul class="w3-navbar w3-light-blue w3-card-2 w3-top w3-left-align w3-large">
    <li class="w3-hide-medium w3-hide-large w3-opennav w3-right">
      <a class="w3-padding-large w3-hover-white w3-large w3-light-blue" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    </li>
    <li><a href="timecard_view.php?id=<?php print($requestEmployeeId); ?>" class="w3-xlarge w3-padding-medium w3-white"><i class="fa fa-clock-o"></i></a></li>
    <li class="w3-hide-small"><a href="timecard_update.php?id=<?php echo $requestTimeCardId; ?>" class="w3-padding-large w3-hover-white">Edit Time Card</a></li>
    <?php if ($adminFlag == 'Yes') {
      print('<li class="w3-hide-small"><a href="home.php" class="w3-padding-large w3-hover-white">Administration</a></li>');
    } ?>
    <li class="w3-hide-small"><a href="logout_process.php" class="w3-padding-large w3-hover-white">Log Out</a></li>
  </ul>
  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:51px">
    <ul class="w3-navbar w3-left-align w3-large w3-black">
      <li><a class="w3-padding-large" href="timecard_view.php?id=<?php print($requestEmployeeId); ?>">Time Cards</a></li>
      <li><a class="w3-padding-large" href="timecard_update.php?id=<?php print($requestTimeCardId); ?>">Edit Time Card</a></li>
      <?php if ($adminFlag == 'Yes') {
        print('<li><a class="w3-padding-large" href="home.php">Administration</a></li>');
      } ?>
      <li><a class="w3-padding-large" href="logout_process.php">Log Out</a></li>
    </ul>
  </div>

  <!-- Content -->
  <div class="w3-container w3-dark-grey w3-padding-64">

    <div class="w3-content w3-row">
      <div class="w3-container w3-third">
        <p class="w3-xlarge w3-text-light-blue">View Time Card: <?php print($requestTimeCardId); ?></p>
        <p>Employee ID: <?php print($emprow['ID']); ?> <br/>
        Name: <?php print($emprow['firstName']); ?> <?php print($emprow['lastName']); ?><br/>
        Title: <?php print($emprow['employeeTitle']); ?> <br/>
        Administrator: <?php print($emprow['adminFlag']); ?> </p>
        <p><a href="timecard_view.php?id=<?php print($requestEmployeeId); ?>">Time Cards</a></p>
      </div>
      <div class="w3-container w3-twothird">
        <?php
          if ($adminFlag=='Yes') {
            print('
              <div class="w3-panel w3-card-8 w3-yellow">
              </div>
              <div class="w3-card-4">
                <header class="w3-container w3-yellow">
                <h4>Caution!</h4>
                </header>
                <div class="w3-container">
                  <p>You are viewing this Time Card as an Administrator. <br/>
                  Changes here will override entries made by an Employee.</td></tr>
                  <p>Employee ID: '.$employeeId.'<br/>
                  Name: '.$firstName.' '.$lastName.'<br/>
                  Title: '.$employeeTitle.'</p>
                </div>
              </div>');
          }
        ?>
        <p>This page displays the details of a Time Card with a summary of hours accumulated and an estimate of gross pay based on your hourly rate. You may <a href="timecard_update.php?id=<?php echo $timecardId; ?>">edit the details</a> of a Time Card in order to log your time-in/time-out activity and work notes.</p>
        <div class="w3-content w3-center" id="bar-timecard" style="height: 175px; width: 350px;" ></div>
        <p class="w3-center">Total Combined Hours Tax + Edu</p>
      </div>
    </div>

    <div class="w3-content">
        <div class="w3-responsive">
        <table class="w3-table w3-bordered w3-medium">
          <tr>
            <th><br/>Date</th>
            <th>Work<br/>Type</th>
            <th>Time<br/>In</th>
            <th>Time<br/>Out</th>
            <th><br/>Hrs</th>
            <th>Time<br/>In</th>
            <th>Time<br/>Out</th>
            <th><br/>Hrs</th>
            <th><br/>Notes</th>
            <th>Hrs<br/>Tax</th>
            <th>Hrs<br/>Edu</th>
          </tr>

        <?php
          $trsql = 'SELECT
                ID,
                timecardId,
                date,
                workType,

                timeInAM,
                timeOutAM,
                hrsAM,

                timeInPM,
                timeOutPM,
                hrsPM,

                notes,
                hrsTax,
                hrsEdu,
                payRate

              FROM timerecords WHERE timecardId = ' .$requestTimeCardId. ';';

          $trresult = mysql_query($trsql) or die(mysql_error());

          $timecardsql = 'SELECT
                ID,
                employeeId,

                payPeriodStart,
                payPeriodEnd,

                subTotalRegWk1Tax,
                subTotalRegWk1Edu,
                subTotalOTWk1Tax,
                subTotalOTWk1Edu,
                subTotalRegWk2Tax,
                subTotalRegWk2Edu,
                subTotalOTWk2Tax,
                subTotalOTWk2Edu,

                twoWeekTotalRegTax,
                twoWeekTotalRegEdu,
                twoWeekTotalOTTax,
                twoWeekTotalOTEdu,
                twoWeekTotalComb,

                payRate

              FROM timecards WHERE ID='.$requestTimeCardId.';';

          // echo $timecardsql;
          $timecardresult = mysql_query($timecardsql) or die(mysql_error());
          $timecardrow = mysql_fetch_array($timecardresult) or die(mysql_error());

          $payrollReg = $timecardrow['payRate'] * ($timecardrow['twoWeekTotalRegTax'] + $timecardrow['twoWeekTotalRegEdu']);
          $payrollOT = 1.5 * $timecardrow['payRate'] * ($timecardrow['twoWeekTotalOTTax'] + $timecardrow['twoWeekTotalOTEdu']);
          $payrollTot = $payrollReg + $payrollOT;

          for ($x = 1; $x <= 7; $x++) {
            $trrow = mysql_fetch_array($trresult);

            print('<tr><td>' .$trrow['date']. '</td>'
            . '<td>' .$trrow['workType'].  '</td>'
            . '<td>' .$trrow['timeInAM'].  '</td>'
            . '<td>' .$trrow['timeOutAM']. '</td>'
            . '<td>' .$trrow['hrsAM'].     '</td>'
            . '<td>' .$trrow['timeInPM'].  '</td>'
            . '<td>' .$trrow['timeOutPM']. '</td>'
            . '<td>' .$trrow['hrsPM'].     '</td>'
            . '<td>' .$trrow['notes'].     '</td>'
            . '<td>' .$trrow['hrsTax'].    '</td>'
            . '<td>' .$trrow['hrsEdu'].    '</td></tr>');
            // . '<td>' .$row['payRate']. '</td>'
            // . '<td><a href=\'timerec_update.php?id=' . $row['ID'] . '\'><i class="fa fa-pencil w3-text-green w3-margin-right"></i></a></td></tr>');
            // . '<td><a href=\'timerec_delete.php?id=' . $row['ID'] . '\'><i class="fa fa-remove w3-text-red w3-margin-right"></i></a></td></tr>');
          }
          ?>

          <tr>
            <td colspan=6></td>
            <td colspan=3>Subtotal Reg. Hours Week 1</td>
            <td><?php print($timecardrow['subTotalRegWk1Tax']) ?></td>
            <td><?php print($timecardrow['subTotalRegWk1Edu']) ?></td>
          </tr>
          <tr>
            <td colspan=6></td>
            <td colspan=3>Subtotal Overtime Hours</td>
            <td><?php print($timecardrow['subTotalOTWk1Tax']) ?></td>
            <td><?php print($timecardrow['subTotalOTWk1Edu']) ?></td>
          </tr>

          <?php

          for ($x = 1; $x <= 7; $x++) {
            $trrow = mysql_fetch_array($trresult);

            print('<tr><td>' . $trrow['date']           . '</td>'
            . '<td>' . $trrow['workType']       . '</td>'
            . '<td>' . $trrow['timeInAM']       . '</td>'
            . '<td>' . $trrow['timeOutAM']      . '</td>'
            . '<td>' . $trrow['hrsAM']          . '</td>'
            . '<td>' . $trrow['timeInPM']       . '</td>'
            . '<td>' . $trrow['timeOutPM']      . '</td>'
            . '<td>' . $trrow['hrsPM']          . '</td>'
            . '<td>' . $trrow['notes']          . '</td>'
            . '<td>' . $trrow['hrsTax']         . '</td>'
            . '<td>' . $trrow['hrsEdu']         . '</td></tr>');
            // . '<td>' . $row['payRate']        . '</td>'
            // . '<td><a href=\'timerec_update.php?id=' . $row['ID'] . '\'><i class="fa fa-pencil w3-text-green w3-margin-right"></i></a></td></tr>');
          }
        ?>
        <tr>
          <td colspan=6></td>
          <td colspan=3>Subtotal Reg. Hours Week 2</td>
          <td><?php print($timecardrow['subTotalRegWk2Tax']) ?></td>
          <td><?php print($timecardrow['subTotalRegWk2Edu']) ?></td>
        </tr>
        <tr>
          <td colspan=6></td>
          <td colspan=3>Subtotal Overtime Hours</td>
          <td><?php print($timecardrow['subTotalOTWk2Tax']) ?></td>
          <td><?php print($timecardrow['subTotalOTWk2Edu']) ?></td>
        </tr>
        <tr><td colspan=11></td></tr>
        <tr>
          <td colspan=6></td>
          <td colspan=3>Two Week Total Reg Hours</td>
          <td><?php print($timecardrow['twoWeekTotalRegTax']) ?></td>
          <td><?php print($timecardrow['twoWeekTotalRegEdu']) ?></td>
        </tr>
        <tr>
          <td colspan=6></td>
          <td colspan=3>Two Week Total OT Hours</td>
          <td><?php print($timecardrow['twoWeekTotalOTTax']) ?></td>
          <td><?php print($timecardrow['twoWeekTotalOTEdu']) ?></td>
        </tr>
        <tr><td colspan=11></td></tr>
        <tr>
          <td colspan=6></td>
          <td colspan=3>Total Combined Hours Tax + Edu</td>
          <td colspan=2><?php print($timecardrow['twoWeekTotalComb']) ?></td>
        </tr>
        <tr><td colspan=11></td></tr>
        <tr>
          <td colspan=6></td>
          <td colspan=3>Payroll Estimate Regular</td>
          <td colspan=2>$<?php print($payrollReg) ?></td>
        </tr>
        <tr>
          <td colspan=6></td>
          <td colspan=3>Payroll Estimate Overtime</td>
          <td colspan=2>$<?php print($payrollOT) ?></td>
        </tr>
        <tr>
          <td colspan=6></td>
          <td colspan=3>Payroll Estimate Total</td>
          <td colspan=2>$<?php print($payrollTot) ?></td>
        </tr>
      </table>
      </div>

    </div> <!-- end w3-content -->


  </div> <!-- end w3-container -->

  <div class="w3-container w3-light-grey w3-center w3-opacity w3-padding-64">
      <h1 class="w3-margin w3-xlarge"><i class="fa fa-clock-o w3-text-blue"></i> SweetTime!</h1>
      <h2 class="w3-margin w3-large">Web-Based Time Tracking System</h2>
      <p class="w3-margin w3-medium">Copyright (c) 2016 Troy Scott</p>
  </div>

  <script>
  // Used to toggle the menu on small screens when clicking on the menu button
  function myFunction() {
      var x = document.getElementById("navDemo");
      if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
      } else {
          x.className = x.className.replace(" w3-show", "");
      }
  }
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script>
  $(function() {
    $('a[href*="#"]:not([href="#"])').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          $('html, body').animate({
            scrollTop: target.offset().top
          }, 1000);
          return false;
        }
      }
    });
  });
  </script>

  <script>
    /*
    Morris.Line({
      // ID of the element in which to draw the chart.
      element: 'myfirstchart',
      // Chart data records -- each entry in this array corresponds to a point on
      // the chart.
      data: [
        { year: '2008', value: 20 },
        { year: '2009', value: 10 },
        { year: '2010', value: 5 },
        { year: '2011', value: 5 },
        { year: '2012', value: 20 }
      ],
      // The name of the data record attribute that contains x-values.
      xkey: 'year',
      // A list of names of data record attributes that contain y-values.
      ykeys: ['value'],
      // Labels for the ykeys -- will be displayed when you hover over the
      // chart.
      labels: ['Value']
    });

    Morris.Donut({
      element: 'donut-timecard',
      data: [
        {label: "Download Sales", value: 12},
        {label: "In-Store Sales", value: 30},
        {label: "Mail-Order Sales", value: 20}
      ]
    });

    Morris.Bar({
      element: 'bar-timecard',
      data: [
        { y: 'Tax', a: "<?php print($timecardrow['twoWeekTotalRegTax']) ?>", b: "<?php print($timecardrow['twoWeekTotalOTTax']) ?>" },
        { y: 'Edu', a: "<?php print($timecardrow['twoWeekTotalRegEdu']) ?>",  b: "<?php print($timecardrow['twoWeekTotalOTEdu']) ?>" }
      ],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Regular Hrs', 'OT Hrs'],
      stacked: 'true'
    });

    */

    Morris.Bar({
      element: 'bar-timecard',
      data: [
        { y: 'Hrs Tax', a: "<?php print($timecardrow['twoWeekTotalRegTax']) ?>", b: "<?php print($timecardrow['twoWeekTotalOTTax']) ?>" },
        { y: 'Hrs Edu', a: "<?php print($timecardrow['twoWeekTotalRegEdu']) ?>", b: "<?php print($timecardrow['twoWeekTotalOTEdu']) ?>" }
      ],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Reg Hrs', 'OT Hrs'],
      barColors: function (row, series, type) {
            console.log("--> "+row.label, series, type);
            if(series.label == "Reg Hrs") return "#5DADE2";
            else if(series.label == "OT Hrs") return "#F4D03F";
          },
      hideHover: 'auto',
      gridTextColor: '#F8F9F9',
      stacked: 'true'
    });
  </script>

</body>
</html>
