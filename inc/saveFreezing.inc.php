<?php

session_start();

require_once '../config.inc.php';

// définition de la class APPLICATION
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : null;
$form = array();
parse_str($formulaire, $form);

$nb = 0;
foreach ($form as $fieldName => $value){
    $laDate = explode('_', $fieldName);
    $nb += $Application->saveFreezingStatus($laDate[1], $value);
}

echo sprintf('%d statuts enregistrés', $nb);