<?php

$PP2 = $PP;
$pnum = -1;
while(count($PP2))
{
    list($wx, $wy) = wxy($PP2);

    $pnum++;
    list($n) = get_farthest($PP2, $wx, $wy, 1);

    $pp = array();
    list($cx, $cy) = $pp[$n] = $PP[$n];
    unset($PP2[$n]);
    while(count($PP2))
    {
	$rt = rtime($pp);
	list($n, $xx) = get_closest($PP2, $cx, $cy, 1);
	list($cx, $cy, $pt) = $xx;
	if($rt + $pt > $MAX)
	    break;
	$pp[$n] = $xx;
	unset($PP2[$n]);
    }
    $pools[$pnum] = $pp;
}
#print_r($pools);
