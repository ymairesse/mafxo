<?php
/* Smarty version 3.1.34-dev-7, created on 2022-09-29 08:15:29
  from '/home/yves/www/mdm/templates/footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_63353801757289_39571016',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '523287cf948158851dbbfbf4ab6fd82a29bb11cd' => 
    array (
      0 => '/home/yves/www/mdm/templates/footer.tpl',
      1 => 1662138597,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63353801757289_39571016 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yves/www/mdm/smarty/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<div style="padding-bottom: 60px"></div>

<div class="hidden-print navbar-xs navbar-default navbar-fixed-bottom" style="padding-top:10px">
	<span class="hidden-xs">
		Le <?php echo smarty_modifier_date_format(time(),"%A, %e %b %Y");?>
 à <?php echo smarty_modifier_date_format(time(),"%Hh%M");?>

		Adresse IP: <strong><?php echo $_smarty_tpl->tpl_vars['netId']->value['ip'];?>
</strong> <?php echo $_smarty_tpl->tpl_vars['netId']->value['hostname'];?>

		Votre passage est enregistré
			
	</span>

	<span class="visible-xs">
		<?php echo $_smarty_tpl->tpl_vars['netId']->value['ip'];?>
 <?php echo $_smarty_tpl->tpl_vars['netId']->value['hostname'];?>
 <?php echo smarty_modifier_date_format(time(),"%A, %e %b %Y");?>
 <?php echo smarty_modifier_date_format(time(),"%Hh%M");?>

	</span>

</div>  <!-- navbar -->
<?php }
}
