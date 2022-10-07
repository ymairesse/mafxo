<?php
/* Smarty version 3.1.34-dev-7, created on 2022-10-04 15:55:39
  from '/home/yves/www/mdm/templates/calendar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_633c3b5b4c3436_67815461',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e055e3c89af55782a1962054d0cbc5e4982af7b5' => 
    array (
      0 => '/home/yves/www/mdm/templates/calendar.tpl',
      1 => 1664891735,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_633c3b5b4c3436_67815461 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- -------------------- Navigation temporelle -------------------- -->

<div style="text-align: center">
    <h2 id="encadre">
        <button type="button" 
            class="btn btn-primary btn-sm pull-left btn-prevMonth" 
            title="Mois précédent">
            <i class="fa fa-arrow-left"></i>
            <span class="hidden-xs hidden-sm"> Mois précédent</span>
        </button> 
        <?php echo $_smarty_tpl->tpl_vars['monthName']->value;?>
 <span class="hidden-xs"><?php echo $_smarty_tpl->tpl_vars['year']->value;?>
</span>
        <button type="button" 
            class="btn btn-primary btn-sm pull-right btn-nextMonth"
            title="Mois suivant">
            <span class="hidden-sm hidden-xs">Mois suivant </span>
            <i class="fa fa-arrow-right"></i>
        </button> 
    </h2>
</div>

<!-- --------------------------------------------------------------------------------- -->

<div class="clearfix"></div>

<!-- -------------------- Enregistrement et reset -------------------- -->

<div class="btn-group">

    <button type="button" class="btn btn-danger btn-sm" id="btn-saveCalendar">
        <i class="fa fa-floppy-o"></i><span class="hidden-xs"> N'oubliez pas d'Enregistrer</span>
    </button>
    <button type="button" class="btn btn-default btn-sm" id="reset">
        <i class="fa fa-recycle"></i><span class="hidden-xs"> Annuler les modifications</span>
    </button>

</div>
<!-- --------------------------------------------------------------------------------- -->

<!-- ---------------- Grille et formulaire d'inscription ---------------- -->

<div style="max-height:45em; overflow: auto">

    <form id="formInscription" style="padding: 0 !important">
    
    <table class="table table-condensed" id="calendar-table">

        <tr>
            <th style="width:10%">&nbsp;</td>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['listePeriodes']->value, 'periode', false, 'noPeriode');
$_smarty_tpl->tpl_vars['periode']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['noPeriode']->value => $_smarty_tpl->tpl_vars['periode']->value) {
$_smarty_tpl->tpl_vars['periode']->do_else = false;
?>
                <th data-periode="<?php echo $_smarty_tpl->tpl_vars['noPeriode']->value;?>
" style="width:30%"><?php echo $_smarty_tpl->tpl_vars['periode']->value['debut'];?>
<span class="hidden-xs"> -<?php echo $_smarty_tpl->tpl_vars['periode']->value['fin'];?>
</span></th>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </tr>

        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['calendar']->value, 'dataJournee', false, 'laDate');
$_smarty_tpl->tpl_vars['dataJournee']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['laDate']->value => $_smarty_tpl->tpl_vars['dataJournee']->value) {
$_smarty_tpl->tpl_vars['dataJournee']->do_else = false;
?>

        <?php $_smarty_tpl->_assignInScope('numJourSemaine', $_smarty_tpl->tpl_vars['dataJournee']->value['day']['dayOfWeek']);?>
        <tr data-dayOfWeek="<?php echo $_smarty_tpl->tpl_vars['numJourSemaine']->value;?>
" 
            data-dayOfMonth="<?php echo $_smarty_tpl->tpl_vars['dataJournee']->value['day']['dayOfMonth'];?>
"
            data-date="<?php echo $_smarty_tpl->tpl_vars['laDate']->value;?>
">

            <td>

                <div class="btn-group-vertical btn-block">

                    <button type="button" 
                        class="btn btn-success btn-xs" 
                        data-dayofweek = "<?php echo $_smarty_tpl->tpl_vars['dataJournee']->value['day']['dayOfWeek'];?>
">
                            <?php echo substr($_smarty_tpl->tpl_vars['dataJournee']->value['day']['fr'],0,2);?>
<br><span style="font-size:1.2em"><?php echo substr($_smarty_tpl->tpl_vars['dataJournee']->value['day']['fr'],4);?>
</span>
                    </button>
                    <button type="button" 
                        class="btn btn-warning btn-xs btn-sameAsDay"
                        data-dayofweek="<?php echo $_smarty_tpl->tpl_vars['dataJournee']->value['day']['dayOfWeek'];?>
"
                        data-jourfr="<?php echo $_smarty_tpl->tpl_vars['daysOfWeek']->value[$_smarty_tpl->tpl_vars['numJourSemaine']->value];?>
"
                        data-toggle="tooltip"
                        data-placement="right"
                        data-container="body"
                        title="Reporter sur chaque <?php echo $_smarty_tpl->tpl_vars['daysOfWeek']->value[$_smarty_tpl->tpl_vars['numJourSemaine']->value];?>
 du mois">
                        <i class="fa fa-plus-square-o"></i>
                    </button>

                </div>
            </td>

            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['dataJournee']->value['periodes'], 'dateHeure', false, 'periode');
$_smarty_tpl->tpl_vars['dateHeure']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['periode']->value => $_smarty_tpl->tpl_vars['dateHeure']->value) {
$_smarty_tpl->tpl_vars['dateHeure']->do_else = false;
?>
                
                <?php $_smarty_tpl->_assignInScope('benevoles', array_keys($_smarty_tpl->tpl_vars['dataJournee']->value['periodes'][$_smarty_tpl->tpl_vars['periode']->value]));?>
                
                <td data-periode="<?php echo $_smarty_tpl->tpl_vars['periode']->value;?>
" 
                    data-date="<?php echo $_smarty_tpl->tpl_vars['laDate']->value;?>
" 
                    class="case <?php if (((isset($_smarty_tpl->tpl_vars['listeConges']->value['feries'][$_smarty_tpl->tpl_vars['laDate']->value][$_smarty_tpl->tpl_vars['periode']->value]))) || ((isset($_smarty_tpl->tpl_vars['listeConges']->value['hebdo'][$_smarty_tpl->tpl_vars['numJourSemaine']->value][$_smarty_tpl->tpl_vars['periode']->value])))) {?>conge<?php }?>"
                    <?php if (((isset($_smarty_tpl->tpl_vars['listeConges']->value['feries'][$_smarty_tpl->tpl_vars['laDate']->value][$_smarty_tpl->tpl_vars['periode']->value]))) || ((isset($_smarty_tpl->tpl_vars['listeConges']->value['hebdo'][$_smarty_tpl->tpl_vars['numJourSemaine']->value][$_smarty_tpl->tpl_vars['periode']->value])))) {?>
                    title="Congé ou fermeture"
                    <?php }?>>

                    <div style="padding: 1em;">

                            <input  
                                type="checkbox" name="inscriptions[]" class="inscription" hidden
                                <?php if (((isset($_smarty_tpl->tpl_vars['listeConges']->value['feries'][$_smarty_tpl->tpl_vars['laDate']->value][$_smarty_tpl->tpl_vars['periode']->value]))) || ((isset($_smarty_tpl->tpl_vars['listeConges']->value['hebdo'][$_smarty_tpl->tpl_vars['numJourSemaine']->value][$_smarty_tpl->tpl_vars['periode']->value])))) {?>disabled<?php }?>
                                value="<?php echo $_smarty_tpl->tpl_vars['laDate']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['periode']->value;?>
"
                                data-date="<?php echo $_smarty_tpl->tpl_vars['laDate']->value;?>
"
                                data-dayofweek = "<?php echo $_smarty_tpl->tpl_vars['dataJournee']->value['day']['dayOfWeek'];?>
"
                                data-periode="<?php echo $_smarty_tpl->tpl_vars['periode']->value;?>
"
                                <?php if (in_array($_smarty_tpl->tpl_vars['acronyme']->value,$_smarty_tpl->tpl_vars['benevoles']->value)) {?>checked<?php }?>>

                                <span class="badge badge-info"><?php echo $_smarty_tpl->tpl_vars['listePeriodes']->value[$_smarty_tpl->tpl_vars['periode']->value]['debut'];?>
</span>

                                <?php if (!(((isset($_smarty_tpl->tpl_vars['listeConges']->value['feries'][$_smarty_tpl->tpl_vars['laDate']->value][$_smarty_tpl->tpl_vars['periode']->value]))) || ((isset($_smarty_tpl->tpl_vars['listeConges']->value['hebdo'][$_smarty_tpl->tpl_vars['numJourSemaine']->value][$_smarty_tpl->tpl_vars['periode']->value]))))) {?>
                                    <button type="button" 
                                        class="btn btn-xs btn-primary btn-inscription pull-right" 
                                        data-placement="left" 
                                        data-toggle="tooltip" 
                                        title="Inscription ou désinscription"
                                        data-date="<?php echo $_smarty_tpl->tpl_vars['laDate']->value;?>
"
                                        data-periode="<?php echo $_smarty_tpl->tpl_vars['periode']->value;?>
">
                                        <span class="hidden-xs">
                                            <?php if (in_array($_smarty_tpl->tpl_vars['acronyme']->value,array_keys($_smarty_tpl->tpl_vars['dataJournee']->value['periodes'][$_smarty_tpl->tpl_vars['periode']->value]))) {?>
                                                Désinscription
                                                <?php } else { ?>
                                                Je m'inscris
                                            <?php }?>
                                        </span>
                                        <span class="visible-xs hidden-sm"><i class="fa fa-calendar-check-o"></i></span>
                                    </button>
                                <?php }?>

                    </div>

                    <div class="listeBenevoles" data-date="<?php echo $_smarty_tpl->tpl_vars['laDate']->value;?>
" data-periode="<?php echo $_smarty_tpl->tpl_vars['periode']->value;?>
">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['benevoles']->value, 'unAcronyme');
$_smarty_tpl->tpl_vars['unAcronyme']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['unAcronyme']->value) {
$_smarty_tpl->tpl_vars['unAcronyme']->do_else = false;
?>
                            <?php $_smarty_tpl->_assignInScope('benevole', $_smarty_tpl->tpl_vars['usersList']->value[$_smarty_tpl->tpl_vars['unAcronyme']->value]);?>
                            <button type="button" class="btn <?php if ($_smarty_tpl->tpl_vars['unAcronyme']->value == $_smarty_tpl->tpl_vars['acronyme']->value) {?>me btn-danger<?php } else { ?>btn-primary<?php }?> btn-block " 
                                data-toggle="popover"
                                data-html="true"
                                data-title="Paramètres de contact"
                                data-content="<?php echo $_smarty_tpl->tpl_vars['benevole']->value['prenom'];?>
 <?php echo $_smarty_tpl->tpl_vars['benevole']->value['nom'];?>
<br><?php echo $_smarty_tpl->tpl_vars['benevole']->value['mail'];?>
<br><?php echo $_smarty_tpl->tpl_vars['benevole']->value['telephone'];?>
<br>"
                                data-container="body"
                                data-acronyme="<?php echo $_smarty_tpl->tpl_vars['acronyme']->value;?>
"
                                data-placement="top">
                                <span class="visible-xs hidden-md hidden-lg"><?php echo $_smarty_tpl->tpl_vars['unAcronyme']->value;?>
</span>
                                <span class="visible-sm visible-md visible-lg"><?php echo $_smarty_tpl->tpl_vars['benevole']->value['prenom'];?>
 <?php echo $_smarty_tpl->tpl_vars['benevole']->value['nom'];?>
</span>
                            </button>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </div>

                </td>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

        </tr>

        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

    </table>

    </form>

</div>

<!-- --------------------------------------------------------------------------------- -->

<?php echo '<script'; ?>
>

    $(document).ready(function(){
    
	    $('[data-toggle="popover"]').popover();

        $('[data-toggle="tooltip"]').tooltip();
    
    })

<?php echo '</script'; ?>
>
<?php }
}
