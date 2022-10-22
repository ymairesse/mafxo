<?php

/**
* Entêtes suffisantes pour un accès sans authentification
* --------------------------------------------------------
*/

// définition de la class USER utilisée en variable de SESSION
require_once INSTALL_DIR.'/inc/classes/class.User.php';
$User = new User();

// définition de la class Application
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

// définition de la class Chrono
require_once INSTALL_DIR.'/inc/classes/class.Chrono.php';
$chrono = new chrono();


require_once INSTALL_DIR.'/smarty/Smarty.class.php';
$smarty = new Smarty();
$smarty->template_dir = INSTALL_DIR.'/mdp/templates';
$smarty->compile_dir = INSTALL_DIR.'/mdp/templates_c';

$smarty->assign('titre', TITREGENERAL);

// toutes les informations d'identification réseau (adresse IP, jour et heure)
$smarty->assign ('identification', $User->getIdentification());

// récupération de 'action' et 'mode' qui définissent toujours l'action principale à prendre
// d'autres paramètres peuvent être récupérés plus loin
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
$mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : null;
