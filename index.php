<?php

include_once("extern.php");
myheader();

foreach($A2N as $a => $name)
{
    $aopts .= "<option value=$a>$name";
}

print <<<EOF
<table>
<form action='go.php' target='GOFR' method=post
enctype='multipart/form-data'
>
<tr>
<td>
Days
</td>
<td>
<input name='DAYS' value='$DAYS'>
</td>
</tr>

<tr>
<td>
Min
</td>
<td>
<input name='MIN' value='$MIN'>
</td>
</tr>

<tr>
<td>
Max
</td>
<td>
<input name='MAX' value='$MAX'>
</td>
</tr>

<tr>
<td>
Minutes per cell
</td>
<td>
<input name='CELLTIME' value='$CELLTIME'>
</td>
</tr>

<tr>
<td>
Method
</td>
<td>
<select name='METHOD' onchange='this.form.submit()'>
$aopts
</select>
</td>
</tr>

<tr>
<td>
CSV file
</td>
<td>
<input type=file name='csv'>
</td>
</tr>

<tr>
<td>
</td>
<td>
<input type=submit value="Calculate">
</td>
</tr>

</form>
</table>

<iframe id=GOFR name=GOFR width=100% height=1200 scrolling=no frameborder=0></iframe>
EOF;
