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
$passwd2 = isset($form['passwd2']) ? $form['passwd2'] : Null;
$acronyme = isset($form['acronyme']) ? $form['acronyme'] : Null;

if (($nom != Null) && ($prenom != Null) && ($mail != Null) && ($acronyme != Null)) {
    $User = new User();
    
    $nb = $User->saveUserdata($form);
    $nb = ($nb == 2) ? 1 : $nb;

    $message = sprintf("<strong>%d</strong> enregistrement du profil. ", $nb);

    if (($passwd != Null) &&  ($passwd == $passwd2)) {
        $nbPasswd = $User->savePasswd ($form['acronyme'], $passwd);
        if ($nbPasswd == 1)
            $message .= sprintf("<br>Le mot de passe de <strong>%s %s</strong> a été modifié", $form['prenom'], $form['nom']);
    }
    }
else $message = "Il manque une information: PSEUDO, NOM, PRENOM, MAIL et/ou MOT DE PASSE";

echo $message;