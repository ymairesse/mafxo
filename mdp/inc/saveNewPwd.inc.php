<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
// valeur de $action
include 'entetesMin.inc.php';

$User = $_SESSION[APPLICATION];
die('test');    
$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : null;
$form = array();
parse_str($formulaire, $form);

$passwd = isset($form['passwd']) ? $form['passwd'] : Null;
$passwd2 = isset($form['passwd2']) ? $form['passwd2'] : Null;
$acronyme = isset($form['acronyme']) ? $form['acronyme'] : Null;
$token = isset($form['token']) ? $form['token'] : Null;

if (($passwd == $passwd2) && ($passwd != Null)){
    $identite = $User->getUser4token($acronyme, $token);
    if ($identite != false) {
        $nb = $User->savePasswd($acronyme, $passwd);
        echo sprintf('%d mot de passe enregistré', $nb);
    }
    
}
else echo 'Problème: le nouveau mot de passe n\'est pas enregistré';