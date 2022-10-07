<?php

// require_once '../config.inc.php';


require_once '../smarty/Smarty.class.php';
$smarty = new Smarty();
$smarty->template_dir = '../templates';
$smarty->compile_dir = '../templates_c';

$smarty->display('modal/modalInscription.tpl');