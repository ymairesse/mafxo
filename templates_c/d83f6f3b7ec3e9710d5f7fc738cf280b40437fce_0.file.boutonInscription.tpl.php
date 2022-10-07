<?php
/* Smarty version 3.1.34-dev-7, created on 2022-10-04 15:50:53
  from '/home/yves/www/mdm/templates/inc/boutonInscription.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_633c3a3d24e8e1_68348526',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd83f6f3b7ec3e9710d5f7fc738cf280b40437fce' => 
    array (
      0 => '/home/yves/www/mdm/templates/inc/boutonInscription.tpl',
      1 => 1664891444,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_633c3a3d24e8e1_68348526 (Smarty_Internal_Template $_smarty_tpl) {
?><button type="button" 
    class="btn btn-pink candidat btn-block"
    data-acronyme="<?php echo $_smarty_tpl->tpl_vars['identite']->value['acronyme'];?>
">
    <span class="visible-xs hidden-md hidden-lg"><?php echo $_smarty_tpl->tpl_vars['identite']->value['acronyme'];?>
</span>
    <span class="visible-sm visible-md visible-lg"><?php echo $_smarty_tpl->tpl_vars['identite']->value['prenom'];?>
 <?php echo $_smarty_tpl->tpl_vars['identite']->value['nom'];?>
</span>
</button><?php }
}
