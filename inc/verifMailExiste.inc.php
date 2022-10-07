<?php

require_once '../config.inc.php';

// définition de la class APPLICATION
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

// définition de la class USER
require_once INSTALL_DIR.'/inc/classes/class.User.php';

$mail = isset($_POST['mail']) ? $_POST['mail'] : Null;

$User = new User();
$test = $User->userExists(Null, $mail);

echo ($test == true) ? 1 : 0;