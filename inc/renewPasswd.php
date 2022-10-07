<?php

// récupération de 'action' qui définit toujours l'action principale à prendre
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;


// définition de la class USER utilisée en variable de SESSION
require_once INSTALL_DIR.'/inc/classes/class.User.php';
$User = isset($_SESSION[APPLICATION]) ? unserialize($_SESSION[APPLICATION]) : null;

$token = isset($_GET['token']) ? $_GET['token'] : Null;
$acronyme = isset($_GET['acronyme']) ? $_GET['acronyme'] : Null;

$identite = $Application->getUser4token($acronyme, $token);
$smarty->assign('identite', $identite);
$smarty->assign('token', $token);

$smarty->assign('noButtons', true);

$smarty->assign('corpsPage', 'renewPasswd');

