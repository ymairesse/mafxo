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

$form['acronyme'] = $acronyme;

$nom = isset($form['nom']) ? $form['nom'] : Null;
$prenom = isset($form['prenom']) ? $form['prenom'] : Null;
$mail = isset($form['mail']) ? $form['mail'] : Null;

$adresse = isset($form['adresse']) ? $form['adresse'] : Null;
$cpostal = isset($form['cpostal']) ? $form['cpostal'] : Null;
$commune = isset($form['commune']) ? $form['commune'] : Null;
$telephone = isset($form['telephone']) ? $form['telephone'] : Null;

if (($nom != Null) && ($prenom != Null) && ($mail != Null)) {

    $User = new User();
    
    $nb = $User->saveUserdata($form);
    $nb = ($nb == 2) ? 1 : $nb;

    $message = sprintf("%d enregistrement réussi. ", $nb);
    }

echo $message;
