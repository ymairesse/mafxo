<?php

require_once '../config.inc.php';

// définition de la class APPLICATION
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

$nom = isset($_POST['nom']) ? $_POST['nom'] : Null;
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : Null;

$acronyme = $Application->acronyme4nomPrenom($nom, $prenom);

echo $acronyme;