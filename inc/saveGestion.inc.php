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

$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : null;
$form = array();
parse_str($formulaire, $form);

$year = isset($_POST['year']) ? $_POST['year'] : Null;
$month = isset($_POST['month']) ? $_POST['month'] : Null;
$acronyme = isset($_POST['acronyme']) ? $_POST['acronyme'] : Null;

if (($year != Null) && ($month != Null))
    $yearMonth = sprintf("%d_%02d", $year, $month);
    else die('Mauvais format de date');

$oldInscriptions = $Application->getInscriptions($yearMonth, $acronyme);

// remise en ordre des périodes de permanence
$dataOld = array();
foreach ($oldInscriptions as $laDate => $data4dates) {
    foreach ($data4dates as $periode => $data4periodes) {
        $data = $data4periodes[$acronyme];
        $key = sprintf('%s_%d', $data['date'], $data['periode']);
        $dataOld[$key] = $data4periodes[$acronyme];
    }
}

// nouvelles (et éventuellemnt encore anciennes inscriptions)
$dataNew = array();
if (isset($form['inscriptions']))
    foreach ($form['inscriptions'] as $wtf => $datePeriode) {
        $data = explode('_', $datePeriode);
        $key = sprintf('%s_%d', $data[0], $data[1]);
        $dataNew[$key] = array('date' => $data[0], 'periode' => $data[1]);
    }

// périodes disparues à effacer
$deleted = array_diff(array_keys($dataOld), array_keys($dataNew));

$nbDeleted = 0;
foreach ($deleted as $wtf => $dateHeure){
    $dateHeure = explode('_', $dateHeure);
    $date = $dateHeure[0];
    $periode = $dateHeure[1];
    $nbDeleted += $Application->deletePeriode($date, $periode, $acronyme);
}

// périodes à ajouter
$added = array_diff(array_keys($dataNew), array_keys($dataOld));

$nbAdded = 0;
foreach ($added as $wtf => $dateHeure) {
    $dateHeure = explode('_', $dateHeure);
    $date = $dateHeure[0];
    $periode = $dateHeure[1];
    $nbAdded += $Application->addPeriode($date, $periode, $acronyme);
}

$message = sprintf('%d inscriptions annulée(s) et %d inscriptions ajoutée(s)', $nbDeleted, $nbAdded);

echo $message;