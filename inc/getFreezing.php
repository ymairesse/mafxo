<?php

require_once INSTALL_DIR.'/smarty/Smarty.class.php';
$smarty = new Smarty();
$smarty->template_dir = '../templates';
$smarty->compile_dir = '../templates_c';

// liste des mois de fonctionnements de l'application
$listeMois = $Application->getCalendarMonths();

$freezes = $Application->getFreezings4month(array_keys($listeMois));

require_once INSTALL_DIR."/smarty/Smarty.class.php";
$smarty = new Smarty();
$cwd = getcwd();
$smarty->template_dir = "$cwd/templates";
$smarty->compile_dir = "$cwd/templates_c";

$smarty->assign('listeMois', $listeMois);
$smarty->assign('freezes', $freezes);

$smarty->display('modal/modalFreezing.tpl');