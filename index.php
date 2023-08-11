<?php
$PATH = "";
$PAGENAME = "paginaInicial";
$PAGETITLE = "Página Inicial :: Routine";

include_once $PATH.'preLoad.php';

include_once $PATH.'security.php';

if($security===true){
	$page->useBootstrap();

	$corpo = new space($page, "corpo");
	$corpo->inSideH("ATALHO PARA AS TRANSAÇÕES MAIS UTILIZADAS POR VOCÊ");	
}

$page->End();