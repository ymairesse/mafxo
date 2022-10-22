<?php

session_start();

require_once '../config.inc.php';

// définition de la class APPLICATION
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

// définition de la class USER
require_once INSTALL_DIR.'/inc/classes/class.User.php';

if (!(isset($_SESSION[APPLICATION]))) {
    echo "<script type='text/javascript'>document.location.replace('".BASEDIR."');</script>";
    exit;
}

$laDate = isset($_POST['laDate']) ? $_POST['laDate'] : null;

$laDate = $Application->dateMySQL($laDate);

$nb = $Application->delJourFerie($laDate);

echo $nb;