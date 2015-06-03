<?php

include_once("extern.php");

myheader();

$MAX = fdata("MAX");
$MIN = fdata("MIN");
$DAYS = fdata("DAYS");
$CELLTIME = fdata("CELLTIME");
$METHOD = intval(fdata("METHOD"));
if(!file_exists("route${METHOD}.php"))
    $METHOD = "";

list($ok, $err, $CSV) = get_form_file("csv");
if(!$ok)
    $CSV = fn2txt("input.csv");
#        die("No CSV");

$x = -1;
$X1 = $X2 = $Y1 = $Y2 = -1;
$ss = preg_split("/\s*[\r\n]\s*/", $CSV);
$MAXX = count($ss);
foreach($ss as $str)
{
	$x++;
	$xx = split(",", $str);
	if($MAXY < count($xx))
		$MAXY = count($xx);
	for($y = 0; $y < count($xx); $y++)
	{
		$min = $xx[$y];
		if($min)
		{
			if($X1 == -1 || $x < $X1)
				$X1 = $x;
			if($X2 == -1 || $x > $X2)
				$X2 = $x;
			if($Y1 == -1 || $y < $Y1)
				$Y1 = $y;
			if($Y2 == -1 || $y > $Y2)
				$Y2 = $y;
			$key = sprintf("%05d\t%s\t%s", $min, $x, $y);
			$MM[$key] = count($PP);
			$PP[] = array($x, $y, $min);
		}
	}
}

# Start from the longest times
krsort($MM, SORT_NUMERIC);
$pools = array();


include_once("route${METHOD}.php");

list($WTIME, $cells, $TXT, $RCSV, $TBL) = psummary($pools);

setcookie("RCSV", $RCSV, time() + 600);

print <<<EOF
<a href="csv.php"><h4>Download CSV</h4></a>
<h4>Total time: $WTIME</h4>
$TXT
$TBL
EOF;


