<?php

session_start();

require_once 'config.inc.php';

// définition de la class USER
require_once INSTALL_DIR.'/inc/classes/class.User.php';

// définition de la class Application
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

$User = isset($_SESSION[APPLICATION]) ? $_SESSION[APPLICATION] : Null;

require_once INSTALL_DIR.'/smarty/Smarty.class.php';
$smarty = new Smarty();
$smarty->template_dir = INSTALL_DIR."/templates";
$smarty->compile_dir = INSTALL_DIR."/templates_c";


$smarty->assign('BASEDIR', BASEDIR);

$smarty->display('accueil.tpl');
