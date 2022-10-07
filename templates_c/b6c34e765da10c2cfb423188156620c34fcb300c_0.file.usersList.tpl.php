<?php
/* Smarty version 3.1.34-dev-7, created on 2022-10-04 15:56:24
  from '/home/yves/www/mdm/templates/inc/usersList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_633c3b88247d37_42371609',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b6c34e765da10c2cfb423188156620c34fcb300c' => 
    array (
      0 => '/home/yves/www/mdm/templates/inc/usersList.tpl',
      1 => 1664873399,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_633c3b88247d37_42371609 (Smarty_Internal_Template $_smarty_tpl) {
?><div style="max-height:45em; overflow: auto" class="row">

    <ul class="list-unstyled" id='usersList'>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['usersList']->value, 'data', false, 'acronyme');
$_smarty_tpl->tpl_vars['data']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['acronyme']->value => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->do_else = false;
?>
            <li>
                <div class="btn-group btn-group-justified">
                    <a href="#" class="btn btn-warning btn-editProfile <?php if ($_smarty_tpl->tpl_vars['data']->value['statut'] == 'admin') {?>btn-primary<?php } else { ?>btn-warning<?php }?>" 
                        data-toggle="tooltip" 
                        data-container="body"
                        data-placement="left"
                        style="width:20%;" title="Modifier le profil">
                        <i class="fa fa-user"></i>
                    </a>


                    <a href="#"class="btn btn-primary btn-block btn-user"
                        data-statut="<?php echo $_smarty_tpl->tpl_vars['data']->value['statut'];?>
"
                        data-acronyme="<?php echo $_smarty_tpl->tpl_vars['data']->value['acronyme'];?>
"
                        style="width:80%">
                        <?php echo $_smarty_tpl->tpl_vars['data']->value['nom'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['prenom'];?>

                    </a>

                </div>
            </li>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ul>

</div><?php }
}
