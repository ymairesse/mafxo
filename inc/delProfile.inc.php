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

// le/la bénévole à supprimer
$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : Null;

// utilisateur admin actif
$acronyme = $User->getAcronyme();

if ($acronyme != $pseudo) {
	$del = $User->deleteProfile($pseudo);
	$message = sprintf('Effacement de <strong>%d</strong> permanences, <strong>%d</strong> mot de passe et <strong>%d</strong> profil',
		$del['nbCalendar'], 
		$del['nbPasswd'], 
		$del['nbProfile']);
	echo json_encode(array('ok' => true, 'message' => $message));
}
else echo json_encode(array('ok' => false, 'message' => "<strong>Vous ne pouvez pas supprimer votre propre profil</strong>	"));