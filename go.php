<?php

include_once("extern.php");

myheader();

$MAX = fdata("MAX");
$MIN = fdata("MIN");
$DAYS = fdata("DAYS");
$CELLTIME = fdata("CELLTIME");

list($ok, $err, $CSV) = get_form_file("csv");
if(!$ok)
	die("No CSV");
include_once("route.php");

setcookie("RCSV", $RCSV, time() + 600);

print($HTML);