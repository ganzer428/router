<?php

function ssplit($str)
{
    if(!preg_match("/\S/", $str))
        return(array());
    $str = preg_replace("/^\s+/", "", $str);
    $str = preg_replace("/\s+$/", "", $str);
    return(preg_split("/\s+/", $str));
}

function nsplit($str)
{
    if(!preg_match("/\S/", $str))
        return(array());
    $str = preg_replace("/^\s+/", "", $str);
    $str = preg_replace("/\s+$/", "", $str);
    return(preg_split("/[ \t\r]*\n[ \t\r]*/", $str));
}

function nsplit2($str)
{
    $xx = nsplit($str);
    $aa = array();
    for($n = 0; $n < count($xx); $n += 2)
        $aa[$xx[$n]] = $xx[$n + 1];
    return($aa);
}

function spchop($val)
{
    $val = preg_replace("/^\s+/", "", $val);
    $val = preg_replace("/\s+$/", "", $val);
    return($val);
}

function spchop2($val)
{
    $val = preg_replace("/^\s+/", "", $val);
    $val = preg_replace("/\s+$/", "", $val);
    $val = preg_replace("/\s+/", " ", $val);
    return($val);
}

function f2($x)
{
	return(sprintf("%.2f", $x));
}

function fn2txt($fn)
{
    if(!file_exists($fn))
        return("");
    $txt = "";
    $fd = fopen($fn, "r");
    if($fd === FALSE)
        return("");
    flock($fd, LOCK_SH);
    while(!feof($fd))
    {
        $txt .= fread($fd, 10240);
    }
    flock($fd, LOCK_UN);
    fclose($fd);
    return($txt);
}

function cmd2txt($fn)
{
    $txt = "";
    $fd = popen($fn, "r");
    if($fd === FALSE)
        return("");
    while(!feof($fd))
    {
        $txt .= fread($fd, 10240);
    }
    pclose($fd);
    return($txt);
}

function txt2fn($txt, $fn)
{
    global $_FILE_GROUP;

    $mode = file_exists($fn) ? "r+" : "w";
    $fd = fopen($fn, $mode);
    if(!$fd)
        return(FALSE);
    flock($fd, LOCK_EX);
    ftruncate($fd, 0);
    fseek($fd, 0, SEEK_SET);
    fwrite($fd, $txt);
    flock($fd, LOCK_UN);
    fclose($fd);
    chmod($fn, 0664);
    if($_FILE_GROUP)
        chgrp($fn, $_FILE_GROUP);
}

function get_form_file($name, $isimage)
{
    global $_HOME;

    foreach(ssplit("$_HOME/tmp /tmp c:/temp d:/temp") as $tdir)
    {
        if(file_exists($tdir))
        {
            $fdir = $tdir;
            break;
        }
    }

    if(!$fdir)
        die("Can't find TMP dir for form uploads!");

    $tfn = $_FILES[$name]['tmp_name'];
    $nfn = $_FILES[$name]['name'];

    if(!$tfn || $tfn == "none")
    {
        return(array(0, "No $name file parameter ($tfn)($nfn)"));
    }

	$data = fn2txt($tfn);
	unlink($tfn);

    return(array(1, "OK", $data));
}

function html_go($url)
{
    header("Location: $url");
    jsgo($url);
    exit;
}

if(count($_GET))
    $HTTP_GET_VARS = $_GET;
if(count($_POST))
    $HTTP_POST_VARS = $_POST;

function postget()
{
    global $HTTP_POST_VARS, $HTTP_GET_VARS;

    if(count($HTTP_GET_VARS))
	return($HTTP_GET_VARS);
    else
	return($HTTP_POST_VARS);
}

function postset($cc)
{
    global $HTTP_POST_VARS, $HTTP_GET_VARS, $_GET, $_POST;

    $HTTP_POST_VARS = $HTTP_GET_VARS = $_GET = $_POST = $cc;
}

function rawfdata($var)
{
    $pp = postget();
    if($pp[$var] != '')
        return($pp[$var]);
    return($pp[$pp["var_$var"]]);
}

function fdata($var)
{
    $val = rawfdata($var);
    if(strlen($val) < 1024)	
        $val = strclean($val);
    return($val);

}

function html_header()
{
	$x = <<<EOF
<html>
<head>

<link href="style.css" rel="stylesheet" type="text/css">
<title>
Router
</title>
</head>
<body>
EOF;
	return($x);
}

function myheader()
{
	print(html_header());
}

function strclean($val)
{
        $val = str_replace('\\\\', '\\', $val);
        $val = str_replace('\"', '"', $val);
        $val = str_replace("\'", "'", $val);
        $val = str_replace("\\'", "'", $val);
        $val = str_replace("`", "'", $val);
        $val = spchop2($val);
    return($val);
}

