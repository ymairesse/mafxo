<?php
/* Smarty version 3.1.34-dev-7, created on 2022-10-01 09:20:13
  from '/home/yves/www/mdm/templates/boutonsHaut.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_6337ea2da5f450_28393995',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b6b75227e5ff87d0aa31b111cf223f8eb48079cd' => 
    array (
      0 => '/home/yves/www/mdm/templates/boutonsHaut.tpl',
      1 => 1664608803,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6337ea2da5f450_28393995 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="row">

			<h1><?php echo $_smarty_tpl->tpl_vars['titre']->value;?>
</h1>
			
			<div class="col-xs-12 btn-group">
			<button type="button" class="btn btn-warning btn-sm" name="button" id="btn-calendrier"><i
					class="fa fa-calendar"></i><span class="hidden-xs"> Calendrier</span>
				</button>
			<button type="button" class="btn btn-success btn-sm" name="button" id="btn-profil"><i
					class="fa fa-user"></i><span class="hidden-xs"> Profil</span>
			</button>
			<button type="button" class="btn btn-info btn-sm" name="button" id="btn-passwd"><i
					class="fa fa-user-secret"></i><span class="hidden-xs"> Mot de passe</span>
			</button>
			<button type="button" class="btn btn-danger btn-sm pull-right" name="button" id="btn-logout"><i
					class="fa fa-times"></i><span class="hidden-xs"> Quitter</span>
			</button>
			<?php if ($_smarty_tpl->tpl_vars['identite']->value['statut'] == 'admin') {?>
				<div class="btn-group pull-right">

				<button type="button" class="btn btn-warning btn-sm" id="btn-gestion">
					<i class="fa fa-calendar-check-o"></i><span class="hidden-xs">Gestion</span>
				</button>

				<button type="button" class="btn btn-info btn-sm" id="btn-conges">
					<i class="fa fa-calendar"></i><span class="hidden-xs"> Congés</span>
				</button>
				<button type="button" class="btn btn-primary btn-sm" name="button" id="btn-periodes">
					<i class="fa fa-hourglass"></i> <span class="hidden-xs">Périodes</span>
				</button>
				</div>
			<?php }?>



<input type="hidden" name="month" id="month" value="<?php echo $_smarty_tpl->tpl_vars['month']->value;?>
">
<input type="hidden" name="year" id="year" value="<?php echo $_smarty_tpl->tpl_vars['year']->value;?>
">

</div><?php }
}
