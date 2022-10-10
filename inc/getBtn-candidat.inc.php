<?php

session_start();

require_once '../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
// valeur de $action
include 'entetes.inc.php';

Application::afficher('test', true);

// définition de la class USER utilisée en variable de SESSION
require_once INSTALL_DIR.'/inc/classes/class.User.php';

$User = isset($_SESSION[APPLICATION]) ? unserialize($_SESSION[APPLICATION]) : null;

// si pas d'utilisateur authentifié en SESSION et répertorié dans la BD, on renvoie à l'accueil
if ($User == null) {
    die(Null);
}

$acronyme = $User->getAcronyme();
$smarty->assign('acronyme', $acronyme);

$identite = $User->getIdentiteUser($acronyme);
$smarty->assign('identite', $identite);

$smarty->display('inc/boutonInscription.tpl');