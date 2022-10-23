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
    die(Null);
}

$acronyme = $User->getAcronyme();

$date = isset($_POST['date']) ? $_POST['date'] : Null;
$periode = isset($_POST['periode']) ? $_POST['periode'] : Null;
$acronyme = isset($_POST['acronyme']) ? $_POST['acronyme'] : Null;

$nb = $User->confirmePermanence($date, $periode, $acronyme);

echo $nb;