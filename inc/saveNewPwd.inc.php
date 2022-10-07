<?php

session_start();

require_once '../config.inc.php';

// définition de la class Application, y compris la lecture de config.ini
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

// récupération de 'action' qui définit toujours l'action principale à prendre
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;


// définition de la class USER utilisée en variable de SESSION
require_once INSTALL_DIR.'/inc/classes/class.User.php';
$User = isset($_SESSION[APPLICATION]) ? unserialize($_SESSION[APPLICATION]) : null;

// si pas d'utilisateur authentifié en SESSION et répertorié dans la BD, on renvoie à l'accueil
if ($User == null) {
	header('Location: '.BASEDIR.'/accueil.php');
	exit;
}

$acronyme = $User->getAcronyme();


$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : null;
$form = array();
parse_str($formulaire, $form);

$passwd = isset($form['passwd']) ? $form['passwd'] : Null;
$passwd2 = isset($form['passwd2']) ? $form['passwd2'] : Null;

if (($passwd == $passwd2) && ($passwd != Null)){
    $nb = $User->savePasswd($acronyme, $passwd);
    echo sprintf('<strong>%d</strong> mot de passe enregistré', $nb);
}
else echo 'Problème: le nouveau mot de passe n\'est pas enregistré';