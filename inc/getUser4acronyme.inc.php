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

$acronyme = isset($_POST['acronyme']) ? $_POST['acronyme'] : Null;
$ordre = isset($_POST['ordre']) ? $_POST['ordre'] : Null;

$identite = $User->getIdentiteUser($acronyme);

if ($ordre == 'alphaNom')
	echo sprintf("%s %s", $identite['nom'], $identite['prenom']);
	else echo sprintf("%s %s", $identite['prenom'], $identite['nom']);
