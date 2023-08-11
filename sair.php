<?php
# Parâmetros
$PATH = "";
$PAGENAME = "sair";
$PAGETITLE = "Sair";

# Carregamento do sistema
include_once @$PATH.'preLoadWithoutStyle.php';

session_destroy();

$page->goToPage("login");