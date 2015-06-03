$hmh = count($PP);

# Get the chain starting from the top left corner
list($rr, $time) = route($X1, $Y1, 1);

# Now chop it
$cn = 0;
$kk = array_keys($rr);
for($d = 1; $d <= $DAYS; $d++)
{
	$clen = intval(($d * $hmh) / $DAYS) - $cn;
#	print("$cn $clen/$hmh\n");
	$rc = array();
	foreach(array_slice($kk, $cn, $clen) as $n)
		$rc[$n] = $rr[$n];
	$rrc[] = $rc;
	$cn += $clen;
}


foreach($rrc as $d => $rc)
{
	$char = substr("ABCDEFGHIJKLMNOPQRST", $d - 0, 1);

	# Check if chain time is OK and swap elements if needed
	radjust($rc);
	$oo = array();
	$hnum = 0;
	$tts = array();
	$time = 0;
	foreach($rc as $n => $xx)
	{
		$hnum++;
		list($x, $y, $t, $d, $min) = $xx;
		if($hnum > 1)
			$comm = "$min + $d";
		else
			$comm = "$min";
		eval('$t = ' . "$comm;");
		$time += $t;
		$cells[$x][$y] = "$char$hnum<br>$t";
		$tts[] = "($comm)";
	}
	$ttxt = join(" + ", $tts);
	$txts .= "<li>${char}1-$char$hnum : $time : $ttxt
";
}

for($x = 0; $x < $X2; $x++)
{
	$tds = "";
	for($y = 0; $y < $MAXY; $y++)
	{
		$td = $cells[$x][$y];
		if(!$td)
			$td = "&nbsp";
		$tds .= "<td>$td</td>";
	}	
	$trs .= "<tr>$tds</tr>
";
}
	
$html = <<<EOF
<head>
<style>
td {
font-size: 10px;
width: 25px;
height: 25px;
}
</style>
</head>
<body>
$txts
<table border cellspacing=0>
$trs
</table>
EOF;

txt2fn($html, "index.html");	
