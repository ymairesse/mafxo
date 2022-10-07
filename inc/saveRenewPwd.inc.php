<?php

require_once '../config.inc.php';

require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();


$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : null;
$form = array();
parse_str($formulaire, $form);

$passwd = isset($form['passwd']) ? $form['passwd'] : Null;
$passwd2 = isset($form['passwd2']) ? $form['passwd2'] : Null;
$acronyme = isset($form['acronyme']) ? $form['acronyme'] : Null;
$token = isset($form['token']) ? $form['token'] : Null;


if (($passwd == $passwd2) && ($passwd != Null)){
    $identite = $Application->getUser4token($acronyme, $token);
    if ($acronyme == $identite['acronyme']){
        $nb = $Application->savePasswd($acronyme, $passwd);
        $n = $Application->delToken4acronyme($acronyme);
        echo sprintf('<strong>%d</strong> mot de passe enregistré pour <strong>%s %s (%s)</strong>', $nb, $identite['nom'], $identite['prenom'], $acronyme);
        }
    else echo 'token incorrect';
}
else echo 'Problème: le nouveau mot de passe n\'est pas enregistré';