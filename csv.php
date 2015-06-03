<?php

include_once("extern.php");

$csv = $_COOKIE["RCSV"];
header("Content-type: text/plain");

$ts = date("YmdHis");
$size = strlen($csv);
header('Content-Description: File Transfer');
header("Content-Disposition: attachment; filename=answers-$ts.csv");
header('Content-Type: text/csv');
#header('Content-Type: text/plain');
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . $size);

print($csv);
