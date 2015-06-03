exit;
list($rr, $time) = route($X2, $Y2);
list($rr, $time) = route(($X1 + $X2) / 2, ($Y1 + $Y2) / 2);
list($rr, $time) = route($X2 + 20, $Y2 + 20);

foreach($PP as $n => $xx)
{
	list($x, $y, $min) = $xx;
	list($rr, $time) = route($x, $y);
}



# Build distance/wait charts for every point
foreach($pp as $n => $xx)
{
	list($x, $y, $min) = $xx;
	$QQ[$n] = xdist($X1, $Y1, $x, $y);
	$ZZ[$n] = xdist($X1, $Y1, $x, $y) + $min;
	$dd = $ww = array();
	foreach($pp as $m => $xx)
	{
		if($m == $n)
			continue;
		list($x2, $y2, $min2) = $xx;
		$dd["$m"] = xdist($x, $y, $x2, $y2);

		$ww["$m"] = xdist($x, $y, $x2, $y2) + $min2;
	}
	asort($dd, SORT_NUMERIC);
	$wdd[$n] = $dd;
	asort($ww, SORT_NUMERIC);
	$www[$n] = $ww;
}		
asort($QQ, SORT_NUMERIC);
asort($ZZ, SORT_NUMERIC);

$rr = array();

# Let's start from the one which is faster to finish
list($rr[0]) = array_keys($ZZ);
while($count($rr) < $hmh)
{
}

exit;

# Now find two points which are the closest to each other
foreach($dd as $n => $qq)
{
	foreach($qq as $cn => $cdist)
		break;
	if($cn < $n)
		continue;
#	list($cn) = array_keys($qq);
	$cqq = $dd[$cn];
	list($ccn) = array_keys($cqq);
	if($n != $ccn)
		continue;
	print("$n - $cn $cdist\n");
	$cc["$n\t$cn"] = $cdist;
}
asort($cc, SORT_NUMERIC);
list($x) = array_keys($cc);

$rr = array();
list($rr[$n1], $rr[$n2]) = split("\t", $x);
while(count($rr) < $hmh)
{
	$kk = array_keys($rr);
	$ln = $kk[count($kk) - 1];
}	



foreach($pp as $n => $xx)
{
	list($x, $y, $min) = $xx;
	$QQ[$n] = xdist($X1, $Y1, $x, $y);
	$ZZ[$n] = xdist($X1, $Y1, $x, $y) + $min;
	$dd = $ww = array();
	foreach($pp as $m => $xx)
	{
		if($m == $n)
			continue;
		list($x2, $y2, $min2) = $xx;
		$dd["$m"] = xdist($x, $y, $x2, $y2);

		$ww["$m"] = xdist($x, $y, $x2, $y2) + $min2;
	}
	asort($dd, SORT_NUMERIC);
	$wdd[$n] = $dd;
	asort($ww, SORT_NUMERIC);
	$www[$n] = $ww;
}		
asort($QQ, SORT_NUMERIC);
asort($ZZ, SORT_NUMERIC);

