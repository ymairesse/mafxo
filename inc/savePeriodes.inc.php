<?php

session_start();

require_once '../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
// valeur de $action
include 'entetes.inc.php';

$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : null;
$form = array();
parse_str($formulaire, $form);

foreach ($form['id'] as $id => $wtf) {
    $listePeriodes[] = array('id' => $id, 'debut' => $form['debut'][$id], 'fin' => $form['fin'][$id]);
}

$nb = $Application->savePeriodes($listePeriodes);

echo $nb;