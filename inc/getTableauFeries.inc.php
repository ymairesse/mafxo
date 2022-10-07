<?php

session_start();

require_once '../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
// valeur de $action
include 'entetes.inc.php';

$month = isset($_POST['month']) ? $_POST['month'] : Null;
$year = isset($_POST['year']) ? $_POST['year'] : Null;

$daysOfWeek = $Application->getDaysName ();
$smarty->assign('daysOfWeek', $daysOfWeek);

$listePeriodes = $Application->getPeriodes();
$smarty->assign('listePeriodes', $listePeriodes);

$smarty->assign('year', $year);
$smarty->assign('month', $month);

$listeConges = $Application->getListeConges($month, $year);
$smarty->assign('listeConges', $listeConges);

$smarty->display('inc/tableauFeries.tpl');