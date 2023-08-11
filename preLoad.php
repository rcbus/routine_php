<?php
if(!isset($PATH)){
	$PATH = "";
}
if(!isset($PATHB)){
	$PATHB = "";
}

include_once $PATH.$PATHB.'../RCD_7/version-app.php';
$_VERSION_RCD = $_VERSION;

include_once $PATH.$PATHB.'version-app.php';
$_VERSION_APP = $_VERSION;

include_once $PATH.$PATHB.'class/define.php';
include_once $PATH.$PATHB.'../RCD_7/load.php';
include_once $PATH.$PATHB.'../security/routine_php.php';

$page = new page($PAGENAME);
$page->setTitle($PAGETITLE);
$page->setPath($PATH.$PATHB);

$idsa = new iDataBase("iDataSetS");
$idsa->setConnection($_SECURITY[0]['host'], $_SECURITY[0]['user'], $_SECURITY[0]['pass'], $_SECURITY[0]['base'], $_SECURITY[0]['port']);
	
include_once $PATH.$PATHB.'../RCD_7/msg.php';

$js = new javaExe(true,$page,"profiableJavaExeA");