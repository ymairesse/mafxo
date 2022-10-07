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

$nom = isset($form['nom']) ? $form['nom'] : Null;
$prenom = isset($form['prenom']) ? $form['prenom'] : Null;
$mail = isset($form['mail']) ? $form['mail'] : Null;
$passwd = isset($form['passwd']) ? $form['passwd'] : Null;

$adresse = isset($form['adresse']) ? $form['adresse'] : Null;
$cpostal = isset($form['cpostal']) ? $form['cpostal'] : Null;
$commune = isset($form['commune']) ? $form['commune'] : Null;
$telephone = isset($form['telephone']) ? $form['telephone'] : Null;

if (($nom != Null) && ($prenom != Null) && ($mail != Null) && ($passwd != Null)) {
    $form['acronyme'] = $Application->acronyme4nomPrenom($nom, $prenom);
    $User = new User();
    
    $nb = $User->saveUserdata($form);
    $nb = ($nb == 2) ? 1 : $nb;

    $message = sprintf("%d enregistrement réussi. ", $nb);

    switch ($nb) {
        case 0: 
            $message .= sprintf("L'utilisateur <strong>%s</strong> existerait-il déjà? ", $form['acronyme']);
            break;
        case 1:
            $nbPasswd = $User->savePasswd ($form['acronyme'], $passwd);
            $message .= sprintf("Votre nom d'utilisateur est <strong>%s</strong>", $form['acronyme']);
            break;
        }
    }
else $message = "Il manque une information: PSEUDO, NOM, PRENOM, MAIL et/ou MOT DE PASSE";

echo $message;
