<?php

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
	$rr = croute($PP2, $x, $y, 1);
	$char = substr("ABCDEFGHIJKLMNOPQRST", $day, 1);

	foreach($rr[0] as $pnum => $xx)
	{
		list($x, $y, $t, $d, $min) = $xx;
		$pools[$day][$pnum] = $xx;
		unset($PP2[$pnum]);
		break;	
	}
}


