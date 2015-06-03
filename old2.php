	continue;
	{
		$minn = $maxn = -1;
		$dd = array();
		for($n = 0; $n < $DAYS; $n++)
		{
			$pp = $pools[$n];
			$pn = count($pp);
			if($pn)
			{
				list($px, $py) = wxy($pp);
				$pd = xdist($px, $py, $x, $y);
			}
			else
				$pd = 0;
			$dd[$n] = $pd;
			if($minn == -1 || $minn > $pn)
				$minn = $pn;						
			if($maxn == -1 || $maxn < $pn)
				$maxn = $pn;						
		}		
		asort($dd, SORT_NUMERIC);
		foreach($dd as $n => $pd)
		{
			if(count($pools[$n]) < $maxn || $minn == $maxn)
			{
				$pools[$n][$pnum] = $PP[$pnum];
#				print("$pnum >> $n\n");
				break;
			}
		}
	}






$DAY = 0;
foreach($pools as $pp)
{
	$DAY++;
	$rr = route($pp, $X1, $Y1, 0);
	$rr = $rr[0];
#	$rr = $pp;
print_r($rr);
	$char = substr("ABCDEFGHIJKLMNOPQRST", $DAY - 1, 1);

	# Check if chain time is OK and swap elements if needed
	radjust($rr);
	$oo = array();
	$hnum = 0;
	$tts = array();
	$time = 0;
	foreach($rr as $n => $xx)
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

