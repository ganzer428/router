<?php

function xdist($x1, $y1, $x2, $y2)
{
	global $CELLTIME;

	$x = $x2 - $x1;
	$y = $y2 - $y1;
	return(f2($CELLTIME * sqrt($x * $x + $y * $y)));
} 

function ptable($cells)
{
	global $X2, $MAXY;
	for($x = 0; $x <= $X2; $x++)
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
	
	$tbl = <<<EOF
<table border cellspacing=0>
$trs
</table>
EOF;
	return($tbl);
}

function pcsv($cells)
{
	global $X2, $MAXY;

	$delim = ",";
	for($x = 0; $x <= $X2; $x++)
	{
		$str = "";
		for($y = 0; $y < $MAXY; $y++)
		{
			list($c) = split("<br>", $cells[$x][$y]);
			if($y > 0)
				$str .= $delim;
			$str .= $c;
		}	
		$csv .= "$str\n";
	}
	return($csv);
}

function wxy($pp)
{
	global $PP;

	foreach($pp as $n => $xx)
	{
		list($x, $y, $min) = $xx;
		$tx += $x;	
		$ty += $y;	
	}
	$tx /= count($pp);	
	$ty /= count($pp);	
	return(array($tx, $ty));
}


function route($pp, $sx, $sy, $tcheck)
{
	global $DAYS;
	
	$hmh = count($pp);
	$rr = array();
	$time = 0;
	$cx = $sx;
	$cy = $sy;
	while(count($rr) < $hmh)
	{
		$bt = $bd = $bn = -1;
		foreach($pp as $n => $xx)
		{
			list($x, $y, $min) = $xx;
			
			$d = xdist($cx, $cy, $x, $y);
			$t = $d + ($tcheck ? $min : 0);
			if($bt >= 0 && $t > $bt)
				continue;
#print("$n $x/$y/$min\n");
			$bd = $d;
			$bt = $t;
			$bn = $n;
			$bx = $x;
			$by = $y;
			$bmin = $min;
		}
		unset($pp[$bn]);
		$cx = $bx;
		$cy = $by;
		$time += $bt;
		$rr[$bn] = array($bx, $by, $bt, $bd, $bmin);
	}
	$mt = $time / $DAYS;
#	print("$sx/$sy :: $time ($mt)\n");
	return(array($rr, $time));	
}

function radjust(&$rc)
{
}

