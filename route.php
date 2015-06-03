<?php

include_once("extern.php");

if(!$CSV)
{
	die("NO CSV");
	$IFN = "input.csv";

	$fd = fopen($IFN, "r");
	if(!$fd)
		die("Can't open $ifn\n");
	
	while(!feof($fd))
	{
        	$CSV .= fread($fd, 10240);
	}
	fclose($fd);
}

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


$day = -1;
$PP2 = $PP;
foreach($MM as $key => $pnum)
{
	$day++;
	list($min, $x, $y) = split("\t", $key);
	$pools[$day][$pnum] = $PP[$pnum];

	unset($PP2[$pnum]);
	$char = substr("ABCDEFGHIJKLMNOPQRST", $day, 1);
	$min = f2($min);
	$cells[$x][$y] = "${char}1<br>$min";
#	print("$x/$y -> ${char}1\n");
	if($day >= $DAYS - 1)
		break;
}

$dn = 0;
while(count($PP2))
{
	$day = ($DAYS - 1 - ($dn++ % $DAYS));
	$pp = $pools[$day];
	$kk = array_keys($pp);
	list($x, $y) = $PP[$kk[count($kk) - 1]];
	$hnum = count($kk) + 1;
	$rr = route($PP2, $x, $y, 1);
	$char = substr("ABCDEFGHIJKLMNOPQRST", $day, 1);

	foreach($rr[0] as $pnum => $xx)
	{
		list($x, $y, $t, $d, $min) = $xx;
#		print("$pnum $x/$y -> $day\n");
		$pools[$day][$pnum] = $xx;
		unset($PP2[$pnum]);

		$comm = "$min + $d";
		eval('$t = ' . "$comm;");
		$t = f2($min + $d);
		$time[$day] += $t;
		$cells[$x][$y] = "$char$hnum<br>$t";
		break;	
	}
}

$WTIME = 0;
foreach($pools as $day => $pp)
{
	$time = 0;
	$tts = array();
	$char = substr("ABCDEFGHIJKLMNOPQRST", $day, 1);
	foreach($pp as $xx)
	{
		list($x, $y, $min) = $xx;
		$min = f2($min);
		$time += $min;
		$tts[] = "($min [$x:$y])";
	}
	$ttxt = join(" + ", $tts);
	$hnum = count($pp);
	$time = f2($time);
	$WTIME += $time;
	$txts .= "<li>${char}1-$char$hnum : $time : $ttxt
";
}

$tbl = ptable($cells);
$RCSV = pcsv($cells);

$cfn = time() . ".csv";

$HTML = <<<EOF
<a href="csv.php"><h4>Download CSV</h4></a>
<h4>Total time: $WTIME</h4>
$txts
$tbl
EOF;


