<?php

session_start();

require_once '../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
// valeur de $action
include 'inc/entetesMin.inc.php';

$token = isset($_GET['token']) ? $_GET['token'] : Null;
$acronyme = isset($_GET['acronyme']) ? $_GET['acronyme'] : Null;

$identite = $User->getUser4token($acronyme, $token);

if ($identite != false) {
    $smarty->assign('identite', $identite);
    $smarty->assign('acronyme', $identite['acronyme']);
    $smarty->assign('token', $token);

    $smarty->assign('corpsPage', 'passwd');
    }
    else {
        $smarty->assign('corpsPage', 'invalidToken');
    }

$smarty->display('index.tpl');
