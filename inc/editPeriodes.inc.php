<?php

session_start();

require_once '../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
// valeur de $action
include 'entetes.inc.php';

$listePeriodes = $Application->getPeriodes();
$smarty->assign('listePeriodes', $listePeriodes);

$smarty->display('modal/modalEditPeriodes.tpl');
