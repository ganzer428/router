<?php


$DAYS = 5;
$MIN = 360;
$MAX = 480;
$CELLTIME = 2;
$_HOME = getcwd();


include_once("include_common.php");
include_once("include_calculate.php");

$A2N = nsplit2("
1
Max weights 1
2
Remote clusters
3
Max weights 2
");

function psummary($pools)
{
#html_dump($pools);
    foreach($pools as $day => $pp)
    {
	$hnum = 0;
	$time = 0;
	$tts = array();
	$char = substr("ABCDEFGHIJKLMNOPQRST", $day, 1);
	foreach($pp as $pn => $xx)
	{
	    $hnum++;
	    list($x, $y, $t, $d, $min) = $xx;
	    if(!$min)
	    {
		$min = $t;
		$d = 0;
	    }
	    $comm = "$min + $d";
	    $cells[$x][$y] = "$char$hnum<br>$t";
	    $min = f2($min);
	    $time += $t;
	    $tts[] = "($t [$x:$y])";
	}
	$ttxt = join(" + ", $tts);
	$hnum = count($pp);
	$time = f2($time);
	$WTIME += $time;
	$txts .= "<li>${char}1-$char$hnum : $time : $ttxt
";
    }
    return(array($WTIME, $cells, $txts, pcsv($cells), ptable($cells)));
}

