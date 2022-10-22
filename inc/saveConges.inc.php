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

$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : null;
$form = array();
parse_str($formulaire, $form);

$month = isset($_POST['month']) ? $_POST['month'] : null;

// reset des congés hebdomadaires dans la BD
$Application->resetCongesHebdo();

// enregistrement des congés hebdomadaires dans la BD
$nb = 0;
foreach ($form['hebdo'] as $wtf => $value){
    $jp = explode('_', $value);
    $jour = $jp[0];
    $periode = $jp[1];
    $nb += $Application->saveCongeHebdo($jour, $periode);
}

// reset des jours fériés du mois $month
$Application->resetFeries($month);

// remise en ordre des champs à enregistrerr
$listeFeries = array();
foreach ($form as $field => $value) {
    if (SUBSTR($field, 0, 4) == 'date') {
        $jour = explode('_', $field)[1];
        $value = $Application->dateMySQL($value);
        if ($value != Null)
            $listeFeries[$jour] = array('date' => $value, 'periodes' => array());
    }
    if (SUBSTR($field, 0, 5) == 'check'){
        $ex = explode('_', $field);
        $jour = $ex[1];
        $periode = $ex[2];
        $listeFeries[$jour]['periodes'][] = $periode;
    }
}

// enregistrement dans la BD
foreach ($listeFeries as $wtf => $unJour){
    if (isset($unJour['date'])) {
        $uneDate = $unJour['date'];
        $lesPeriodes = $unJour['periodes'];
        foreach ($lesPeriodes as $wtf => $unePeriode) {
            $nb += $Application->saveJourFerie($uneDate, $unePeriode);
        }
    }
}

echo $nb;