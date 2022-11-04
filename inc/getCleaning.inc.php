<?php

session_start();

require_once '../config.inc.php';

// définition de la class Application, y compris la lecture de config.ini
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

// définition de la class USER utilisée en variable de SESSION
require_once INSTALL_DIR.'/inc/classes/class.User.php';

$User = isset($_SESSION[APPLICATION]) ? unserialize($_SESSION[APPLICATION]) : null;

// si pas d'utilisateur authentifié en SESSION et répertorié dans la BD, on renvoie à l'accueil
if ($User == null) {
	header('Location: '.BASEDIR.'/accueil.php');
	exit;
}

// liste des mois de fonctionnements de l'application
$listeMois = $Application->getCalendarMonths();

$todayYear = date('Y');
$todayMonth = date('m'); 
if (strlen($todayMonth) < 2)
	$todayMonth = '0'.$todayMonth;
$today = $todayYear.$todayMonth;

foreach ($listeMois as $monthYear => $data){
	// recherche des dates dans le passé % aujourd'hui
	if ($data['year'].$data['month'] < $today)
		$listeMois[$monthYear]['past'] = 1;
		else $listeMois[$monthYear]['past'] = 0;
}

require_once INSTALL_DIR."/smarty/Smarty.class.php";
$smarty = new Smarty();
$smarty->template_dir = "../templates";
$smarty->compile_dir = "../templates_c";

$smarty->assign('listeMois', $listeMois);

$smarty->display('modal/modalCleaning.tpl');