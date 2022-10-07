<?php
/* Smarty version 3.1.34-dev-7, created on 2022-10-04 15:56:16
  from '/home/yves/www/mdm/templates/editPeriodes.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_633c3b8027d9a8_35986641',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e9c32f81943bc7486dbbf5f8797925facf53620b' => 
    array (
      0 => '/home/yves/www/mdm/templates/editPeriodes.tpl',
      1 => 1664301845,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:inc/inputPeriode.tpl' => 1,
  ),
),false)) {
function content_633c3b8027d9a8_35986641 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="container">

    <h2>Gestion des périodes de permanence</h2>

    <form id="formEditPeriodes">

    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['listePeriodes']->value, 'periode', false, 'id');
$_smarty_tpl->tpl_vars['periode']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['periode']->value) {
$_smarty_tpl->tpl_vars['periode']->do_else = false;
?>
        <?php $_smarty_tpl->_subTemplateRender("file:inc/inputPeriode.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

    <button type="button" id="btn-savePeriodes" class="btn btn-primary pull-right">Enregistrer</button>
    <button type="reset" class="btn  btn-default pull-right">Annuler</button>

    <div class="clearfix"></div>
    </form>

</div>
<?php }
}
