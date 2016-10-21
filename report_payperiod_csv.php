
<?php
  $payPeriodStart = $_REQUEST['payPeriodStart'];
  session_start();
  require_once("logincheck.php");
  require_once("../../db_connect.php");

  // Output headers so that the file is downloaded rather than displayed
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename=payperiod_report.csv');

  // Create a file pointer connected to the output stream
  $output = fopen('php://output', 'w');

  // Output the column headings
  fputcsv($output, array('Time Card ID',
    'Employee ID',
    'Pay Period Start',
    'Two Week Total Regular Tax',
    'Two Week Total Regular Edu',
    'Two Week Total Overtime Tax',
    'Two Week Total Overtime Edu',
    'Two Week Total Tax + Edu'));

  // Fetch the data
  //$rows = mysql_query('SELECT field1,field2,field3 FROM table');

  // Fetch all Time Cards for the requested Pay Period Start date
  $tcsql = 'SELECT ID,
      employeeId,
      payPeriodStart,
      twoWeekTotalRegTax,
      twoWeekTotalRegEdu,
      twoWeekTotalOTTax,
      twoWeekTotalOTEdu,
      twoWeekTotalComb FROM timecards WHERE payPeriodStart=\''.$payPeriodStart.'\';';
  //echo $tcsql.'<br/>';
  $tcresult = mysql_query($tcsql);

  // Loop over the rows, outputting them
  //while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);

  while ($tcrow=mysql_fetch_assoc($tcresult)) fputcsv($output, $tcrow);

  fclose($output);
  mysql_close($conn);

  // echo("Return to <a href='report_timecards.php'>Report Time Cards</a>.");

  //header("Location: report_timecards.php");
  //exit;

?>
