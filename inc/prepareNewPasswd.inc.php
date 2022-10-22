<?php

session_start();

require_once '../config.inc.php';

// définition de la class APPLICATION
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

// définition de la class USER
require_once INSTALL_DIR.'/inc/classes/class.User.php';

$User = new User();

$identifiant = isset($_POST['identifiant']) ? strtolower(trim($_POST['identifiant'])) : Null;

// est-ce une adresse mail?

$qui = false;
if (filter_var($identifiant, FILTER_VALIDATE_EMAIL)){
    // vérifions que l'adresse mail existe dans la table des users en retournant
    // le couple acronyme/adresse mail
    $qui = $User->getIdentite4mail($identifiant);
    }
    else {
        // vérifions que l'adresse mail existe dans la table des users en retournant
        // le couple acronyme/adresse mail
        $qui = $User->getIdentite4acronyme($identifiant);
    }
    
if ($qui != false) {
        $date = date('d/m/Y');
        $heure = date('H:i');

        $acronyme = $qui['acronyme'];
        // reset d'un éventuel Token précédent
        $nb = $User->clearToken($acronyme);
        // création d'un nouveau Token
        $link = $User->createPasswdLink($acronyme);

        $identite = $User->getIdentiteUser($acronyme);
        $identiteReseau = $User->identiteReseau();

        require_once INSTALL_DIR.'/smarty/Smarty.class.php';
        $smarty = new Smarty();
        $smarty->template_dir = '../templates';
        $smarty->compile_dir = '../templates_c';

        $smarty->assign('expediteur', MAILADMIN);
        $smarty->assign('BASEDIR', BASEDIR);
        $smarty->assign('link', $link);
        $smarty->assign('identite', $identite);
        $smarty->assign('identiteReseau', $identiteReseau);
        $smarty->assign('date', $date);
        $smarty->assign('heure', $heure);

        $texte = $smarty->fetch('texteMailmdp.tpl');
        
        $Application->mailPasswd($identite['mail'], $texte);
        
        echo 'Nous venons d\'envoyer un mail à l\'adresse '.$identite['mail'].'. Il contient un lien qui vous permettra de changer de mot de passe';
    }
    else die("Cet utilisateur n'existe pas dans la base de données");
    