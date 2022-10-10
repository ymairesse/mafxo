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

$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : null;
$form = array();
parse_str($formulaire, $form);

$year = isset($_POST['year']) ? $_POST['year'] : Null;
$month = isset($_POST['month']) ? $_POST['month'] : Null;

$yearMonth = sprintf("%d_%02d", $year, $month);

$oldInscriptions = $Application->getInscriptions($yearMonth, $acronyme);

Application::afficher($oldInscriptions, true);

// remise en ordre des périodes de permanence
$dataOld = array();
foreach ($oldInscriptions as $laDate => $data4dates) {
    foreach ($data4dates as $periode => $data4periodes) {
        $data = $data4periodes[$acronyme];
        $key = sprintf('%s_%d', $data['date'], $data['periode']);
        $dataOld[$key] = $data4periodes[$acronyme];
    }
}

// nouvelles (et éventuellement anciennes inscriptions)
$dataNew = array();
if (isset($form['inscriptions']))
    foreach ($form['inscriptions'] as $wtf => $datePeriode) {
        $data = explode('_', $datePeriode);
        $key = sprintf('%s_%d', $data[0], $data[1]);
        $dataNew[$key] = array('date' => $data[0], 'periode' => $data[1]);
    }


// périodes disparues à effacer
$nbToDelete = count(array_diff(array_keys($dataOld), array_keys($dataNew)));

// périodes à ajouter
$nbToAdd = count(array_diff(array_keys($dataNew), array_keys($dataOld)));

print_r(array('delete' => $nbToDelete, 'add' => $nbToAdd));