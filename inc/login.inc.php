<?php

session_start();

require_once '../config.inc.php';

// définition de la class APPLICATION
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

// définition de la class USER
require_once INSTALL_DIR.'/inc/classes/class.User.php';

$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : null;
$form = array();
parse_str($formulaire, $form);

$identifiant = isset($form['identifiant']) ? strtolower($form['identifiant']) : Null;
$mdp = isset($form['mdp']) ? $form['mdp'] : Null;

if (empty($identifiant) || empty($mdp)) {
    // le nom d'utilisateur ou le mot de passe n'ont pas été donnés
    echo "Le nom d'utilisateur et/ou le mot de passe manque";
    exit;   // --------------->>>
    }

$acronymeOrmail = strlen($identifiant) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $identifiant) ? 'mail' : 'acronyme';

if ($acronymeOrmail == 'mail') {
    $identite = $Application->getIdentite4mail($identifiant);
    $acronyme = $identite['acronyme'];
    }
    else $acronyme = $identifiant;


// recherche de toutes les informations sur l'utilisateur
$User = new User($acronyme);
if (!($User->userExists($acronyme))){
    // le nom d'utilisateur n'existe pas
    echo "Cet utilisateur ou utilisatrice est inconnu·e";
    exit;   // --------------->>>
    }

// vérification du mot de passe
if (!($User->getPasswd($acronyme) == md5($mdp))){
    // $User->mailAlerte($acronyme, $User, 'mdp', $mdp);
    echo "Mot de passe incorrect";
    exit;   // --------------->>>
    }

// noter le passage de l'utilisateur dans les logs
$User->logger($acronyme);
// mettre à jour la session avec les infos de l'utilisateur
$_SESSION[APPLICATION] = serialize($User);

echo "ok";
