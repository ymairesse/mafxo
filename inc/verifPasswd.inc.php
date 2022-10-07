<?php

require_once '../config.inc.php';

// définition de la class USER
require_once INSTALL_DIR.'/inc/classes/class.User.php';
$User = new User();

$passwd = isset($_POST['passwd']) ? $_POST['passwd'] : Null;

echo $User->verifPasswdStrength($passwd);