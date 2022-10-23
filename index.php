<?php

session_start();

require_once 'config.inc.php';

// définition de la class Application, y compris la lecture de config.ini
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

// définition de la class USER utilisée en variable de SESSION
require_once INSTALL_DIR.'/inc/classes/class.User.php';
$User = isset($_SESSION[APPLICATION]) ? unserialize($_SESSION[APPLICATION]) : null;

require_once INSTALL_DIR.'/smarty/Smarty.class.php';
$smarty = new Smarty();
$smarty->template_dir = INSTALL_DIR."/templates";
$smarty->compile_dir = INSTALL_DIR."/templates_c";

$year = isset($_COOKIE['year']) ? $_COOKIE['year'] : date('Y');
$month = isset($_COOKIE['month']) ? $_COOKIE['month'] : date('n');

include 'inc/getCalendar.php';

$titre = TITREGENERAL;
$smarty->assign('titre', $titre);

$smarty->assign('year', $year);
$smarty->assign('month', $month);

// $smarty->assign('action', $action);

$netId = $Application->getNetid();
$smarty->assign('netId', $netId);
$smarty->assign('BASEDIR', BASEDIR);

$identite = $Application->getIdentiteUser($acronyme);
$smarty->assign('identite', $identite);

$smarty->display('index.tpl');
