<?php

session_start();

require_once '../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
// valeur de $action
include 'entetes.inc.php';

$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : null;
$form = array();
parse_str($formulaire, $form);

foreach ($form['id'] as $n => $id) {
    $listePeriodes[$n] = array('id' => $id, 'debut' => $form['debut'][$n], 'fin' => $form['fin'][$n]);
}

$nb = $Application->savePeriodes($listePeriodes);

echo $nb;