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

$triUsers = isset($_COOKIE['triUsers']) ? $_COOKIE['triUsers'] : 'alphaNom';

require_once INSTALL_DIR.'/smarty/Smarty.class.php';
$smarty = new Smarty();
$smarty->template_dir = INSTALL_DIR."/templates";
$smarty->compile_dir = INSTALL_DIR."/templates_c";

// liste des utilisateurs triés sur nom ou prenom selon le Cookie
$usersList = $Application->getUsersList($triUsers);

$smarty->assign('usersList', $usersList);
$smarty->assign('triUsers', $triUsers);

$smarty->display('inc/ulUsersList.tpl');