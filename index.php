<?php

session_start();

require_once 'config.inc.php';

// définition de la class Application, y compris la lecture de config.ini
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

// définition de la class USER utilisée en variable de SESSION
require_once INSTALL_DIR.'/inc/classes/class.User.php';
$User = isset($_SESSION[APPLICATION]) ? unserialize($_SESSION[APPLICATION]) : null;

// // si pas d'utilisateur authentifié en SESSION et répertorié dans la BD, on renvoie à l'accueil
// if ($User == null) {
// 	header('Location: '.BASEDIR.'/accueil.php');
// 	exit;
// }

require_once INSTALL_DIR.'/smarty/Smarty.class.php';
$smarty = new Smarty();
$smarty->template_dir = INSTALL_DIR."/templates";
$smarty->compile_dir = INSTALL_DIR."/templates_c";


// récupération de 'action' qui définit toujours l'action principale à prendre
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;

$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
$month = isset($_POST['month']) ? $_POST['month'] : date('n');

switch ($action) {
	case 'renewPasswd':
		require_once 'inc/renewPasswd.php';
		break;
	case 'profil':
		require_once 'inc/editProfile.php';
		break;
	case 'passwd':
		require_once 'inc/passwd.php';
		break;
	default:
		include 'inc/getCalendar.php';
		break;
}

$titre = TITREGENERAL;
$smarty->assign('titre', $titre);

$smarty->assign('year', $year);
$smarty->assign('month', $month);

$smarty->assign('action', $action);

$netId = $Application->getNetid();
$smarty->assign('netId', $netId);
$smarty->assign('BASEDIR', BASEDIR);

$identite = $Application->getIdentiteUser($acronyme);
$smarty->assign('identite', $identite);

$smarty->display('index.tpl');
