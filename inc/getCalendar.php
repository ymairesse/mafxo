<?php

// définition de la class USER utilisée en variable de SESSION
require_once INSTALL_DIR.'/inc/classes/class.User.php';
$User = isset($_SESSION[APPLICATION]) ? unserialize($_SESSION[APPLICATION]) : null;

// si pas d'utilisateur authentifié en SESSION et répertorié dans la BD, on renvoie à l'accueil
if ($User == null) {
	header('Location: '.BASEDIR.'/accueil.php');
	exit;
}




















$fmt1 = datefmt_create(
    'fr_FR',
    IntlDateFormatter::FULL,
    IntlDateFormatter::FULL,
    'Europe/Brussels',
    IntlDateFormatter::GREGORIAN,
    'EE dd/MM'
);

$fmt2 = datefmt_create(
    'fr_FR',
    IntlDateFormatter::FULL,
    IntlDateFormatter::FULL,
    'Europe/Brussels',
    IntlDateFormatter::GREGORIAN,
    'yyyy-MM-dd'
);

$daysOfWeek = $Application->getDaysName();

$nbJours = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$listePeriodes = $Application->getPeriodes();
$nbPeriodes = count($listePeriodes);

$calendar = array();

for ($d=1; $d <= $nbJours; $d++) {
    $time = mktime(12, 0, 0, $month, $d, $year);
    $universel = datefmt_format($fmt2, $time);
    $infoDate['day']['dayOfWeek'] = date('N', $time);
    $infoDate['day']['fr'] = ucfirst(datefmt_format($fmt1, $time));
    $infoDate['day']['dayOfMonth'] = $d;

    foreach ($listePeriodes as $noPeriode => $item){
        $periode = $item['debut'];
        $dateEtHeure = $universel.'_'.$periode;
        $infoDate['periodes'][$noPeriode] = array();
    }
    
    $calendar[$universel] = $infoDate;
    }
    
$yearMonth = sprintf('%d-%02d-', $year, $month).'%';
$inscriptions = $Application->getInscriptions($yearMonth);

foreach ($inscriptions as $date => $lesPeriodes){
    foreach ($lesPeriodes as $periode => $benevoles){
        $calendar[$date]['periodes'][$periode] = $benevoles;
    }
}

// liste des périodes de congé
$listeConges = $Application->getListeConges($month, $year, true);
$smarty->assign('listeConges', $listeConges);

$usersList = $Application->getUsersList();
$smarty->assign('usersList', $usersList);

$acronyme = $User->getAcronyme();
$smarty->assign('acronyme', $acronyme);

$identite = $User->getIdentiteUser($acronyme);
$smarty->assign('identite', $identite);

$identiteReseau = $User->identiteReseau();
$smarty->assign('identiteReseau', $identiteReseau);

$monthName = $Application->monthName($month);
$smarty->assign('monthName', $monthName);

$smarty->assign('year', $year);
$smarty->assign('month', $month);




// calendrier mensuel
$smarty->assign('calendar', $calendar);
// liste des périodes avec début et fin
$smarty->assign('listePeriodes', $listePeriodes);

$smarty->assign('daysOfWeek', $daysOfWeek);

$smarty->assign('inscriptions', $inscriptions);

$smarty->assign('noButtons', false);

$smarty->assign('corpsPage', 'calendar');
