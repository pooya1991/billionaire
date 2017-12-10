 <?php
  header('Content-type: application/json; charset=utf-8');
	require('php-excel-reader/excel_reader2.php');
	require('SpreadsheetReader.php');
  $result="";
	$Reader = new SpreadsheetReader('risknumber.csv');
  foreach ($Reader as $key => $value) {
    $result[$key]=$value;
  }
  print json_encode($result);
  ?>
