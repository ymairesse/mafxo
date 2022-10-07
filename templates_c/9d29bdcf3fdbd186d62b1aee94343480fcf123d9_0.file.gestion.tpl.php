<?php
/* Smarty version 3.1.34-dev-7, created on 2022-10-02 08:29:02
  from '/home/yves/www/mdm/templates/gestion.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_63392fae1777c0_41294963',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d29bdcf3fdbd186d62b1aee94343480fcf123d9' => 
    array (
      0 => '/home/yves/www/mdm/templates/gestion.tpl',
      1 => 1664692138,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:inc/usersList.tpl' => 1,
  ),
),false)) {
function content_63392fae1777c0_41294963 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="col-md-10 col-sm-12">

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

    <div class="clearfix"></div>

    <div class="btn-group">

        <button type="button" class="btn btn-danger btn-sm" id="btn-saveCalendar">
            <i class="fa fa-floppy-o"></i><span class="hidden-xs"> N'oubliez pas d'Enregistrer</span>
        </button>
        <button type="button" class="btn btn-default btn-sm" id="reset">
            <i class="fa fa-recycle"></i><span class="hidden-xs"> Annuler les modifications</span>
        </button>

    </div>

    <div style="max-height:45em; overflow: auto">

        <!------------------------------------------------------------------------------------->

        <form id="formGestion" style="padding: 0 !important">
        
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

                <td style="padding: 1em">

                    <div class="btn-group">
                    <button type="button" 
                        style="height: 5em"
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
                    <button type="button" 
                        style="height: 5em"
                        class="btn btn-success btn-xs" 
                        data-dayofweek = "<?php echo $_smarty_tpl->tpl_vars['dataJournee']->value['day']['dayOfWeek'];?>
">
                            <?php echo substr($_smarty_tpl->tpl_vars['dataJournee']->value['day']['fr'],0,2);?>
<br><span style="font-size:1.5em"><?php echo substr($_smarty_tpl->tpl_vars['dataJournee']->value['day']['fr'],4);?>
</span>
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
                        class="caseAdmin <?php if (((isset($_smarty_tpl->tpl_vars['listeConges']->value['feries'][$_smarty_tpl->tpl_vars['laDate']->value][$_smarty_tpl->tpl_vars['periode']->value]))) || ((isset($_smarty_tpl->tpl_vars['listeConges']->value['hebdo'][$_smarty_tpl->tpl_vars['numJourSemaine']->value][$_smarty_tpl->tpl_vars['periode']->value])))) {?>conge<?php }?>"
                        <?php if (((isset($_smarty_tpl->tpl_vars['listeConges']->value['feries'][$_smarty_tpl->tpl_vars['laDate']->value][$_smarty_tpl->tpl_vars['periode']->value]))) || ((isset($_smarty_tpl->tpl_vars['listeConges']->value['hebdo'][$_smarty_tpl->tpl_vars['numJourSemaine']->value][$_smarty_tpl->tpl_vars['periode']->value])))) {?>
                        title="Congé ou fermeture"
                        <?php }?>>

                        <div class="checkbox" style="float:left">
                            <label>
                                <input  type="checkbox" name="inscriptions[]" class="inscription" hidden
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
                                        <span><?php echo $_smarty_tpl->tpl_vars['listePeriodes']->value[$_smarty_tpl->tpl_vars['periode']->value]['debut'];?>
</span>
                            </label>
                        </div>

                        <div class="listeBenevoles">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['benevoles']->value, 'unAcronyme');
$_smarty_tpl->tpl_vars['unAcronyme']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['unAcronyme']->value) {
$_smarty_tpl->tpl_vars['unAcronyme']->do_else = false;
?>
                                <?php $_smarty_tpl->_assignInScope('benevole', $_smarty_tpl->tpl_vars['usersList']->value[$_smarty_tpl->tpl_vars['unAcronyme']->value]);?>
                                <div class="<?php if ($_smarty_tpl->tpl_vars['unAcronyme']->value == $_smarty_tpl->tpl_vars['acronyme']->value) {?>me<?php }?> benevole" 
                                    data-toggle="popover"
                                    data-html="true"
                                    data-title="Paramètres de contact"
                                    data-content="<?php echo $_smarty_tpl->tpl_vars['benevole']->value['prenom'];?>
 <?php echo $_smarty_tpl->tpl_vars['benevole']->value['nom'];?>
<br><?php echo $_smarty_tpl->tpl_vars['benevole']->value['mail'];?>
<br><?php echo $_smarty_tpl->tpl_vars['benevole']->value['telephone'];?>
<br>"
                                    data-container="body"
                                    data-placement="top">
                                    <span class="visible-sm visible-xs hidden-md hidden-lg"><?php echo $_smarty_tpl->tpl_vars['unAcronyme']->value;?>
</span>
                                    <span class="visible-md visible-lg"><?php echo $_smarty_tpl->tpl_vars['benevole']->value['prenom'];?>
 <?php echo $_smarty_tpl->tpl_vars['benevole']->value['nom'];?>
</span>
                                </div>
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
    <div class="clearfix"></div>
    </div>

    </div>

    <div class="col-md-2 col-sm-12">


        <?php $_smarty_tpl->_subTemplateRender('file:inc/usersList.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    </div>


<?php echo '<script'; ?>
>

    $(document).ready(function(){

        var popoverTemplate = ['<div class="timePickerWrapper popover">',
            '<div class="arrow"></div>',
            '<div class="popover-content">',
            '</div>',
            '</div>'].join('');

        var content = ['<div class="timePickerCanvas">asfaf asfsadf</div>',
            '<div>test</div>',
            '<div class="timePickerClock timePickerHours">asdf asdfasf</div>',
            '<div class="timePickerClock timePickerMinutes"> asfa </div>', ].join('');
    
        $('[data-toggle="popover"]').popover({
                trigger: 'click',
                content: 'bisou',
                placement: "top",
                html: true
            });
        

        $('[data-toggle="tooltip"]').tooltip();
    
    })

<?php echo '</script'; ?>
>
<?php }
}
