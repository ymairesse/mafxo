<div class="col-md-10 col-sm-12">

    <div style="text-align: center">
        <h2 id="encadre">
            <button type="button" 
                class="btn btn-primary btn-sm pull-left btn-prevMonth" 
                title="Mois précédent">
                <i class="fa fa-arrow-left"></i>
                <span class="hidden-xs hidden-sm"> Mois précédent</span>
            </button> 
            {$monthName} <span class="hidden-xs">{$year}</span>
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
                {foreach from=$listePeriodes key=noPeriode item=$periode}
                    <th data-periode="{$noPeriode}" style="width:30%">{$periode.debut}<span class="hidden-xs"> -{$periode.fin}</span></th>
                {/foreach}
            </tr>

            {foreach from=$calendar key=laDate item=dataJournee}

            {assign var=numJourSemaine value=$dataJournee.day.dayOfWeek}
            <tr data-dayOfWeek="{$numJourSemaine}" 
                data-dayOfMonth="{$dataJournee.day.dayOfMonth}"
                data-date="{$laDate}">

                <td style="padding: 1em">

                    <div class="btn-group">
                    <button type="button" 
                        style="height: 5em"
                        class="btn btn-warning btn-xs btn-sameAsDay"
                        data-dayofweek="{$dataJournee.day.dayOfWeek}"
                        data-jourfr="{$daysOfWeek.$numJourSemaine}"
                        data-toggle="tooltip"
                        data-placement="right"
                        data-container="body"
                        title="Reporter sur chaque {$daysOfWeek.$numJourSemaine} du mois">
                        <i class="fa fa-plus-square-o"></i>
                    </button>
                    <button type="button" 
                        style="height: 5em"
                        class="btn btn-success btn-xs" 
                        data-dayofweek = "{$dataJournee.day.dayOfWeek}">
                            {$dataJournee.day.fr|substr:0:2}<br><span style="font-size:1.5em">{$dataJournee.day.fr|substr:4}</span>
                    </button>
                    </div>
                </td>

                {foreach from=$dataJournee.periodes key=periode item=dateHeure}
                    
                    {assign var=benevoles value=$dataJournee.periodes.$periode|array_keys}
                    
                    <td data-periode="{$periode}" 
                        data-date="{$laDate}" 
                        class="caseAdmin {if (isset($listeConges.feries.$laDate.$periode)) || (isset($listeConges.hebdo.$numJourSemaine.$periode))}conge{/if}"
                        {if (isset($listeConges.feries.$laDate.$periode)) || (isset($listeConges.hebdo.$numJourSemaine.$periode))}
                        title="Congé ou fermeture"
                        {/if}>

                        <div class="checkbox" style="float:left">
                            <label>
                                <input  type="checkbox" name="inscriptions[]" class="inscription" hidden
                                        {if (isset($listeConges.feries.$laDate.$periode)) || (isset($listeConges.hebdo.$numJourSemaine.$periode))}disabled{/if}
                                        value="{$laDate}_{$periode}"
                                        data-date="{$laDate}"
                                        data-dayofweek = "{$dataJournee.day.dayOfWeek}"
                                        data-periode="{$periode}"
                                        {if $acronyme|in_array:$benevoles}checked{/if}>
                                        <span>{$listePeriodes.$periode.debut}</span>
                            </label>
                        </div>

                        <div class="listeBenevoles">
                            {foreach from=$benevoles item=unAcronyme}
                                {assign var=benevole value=$usersList.$unAcronyme}
                                <div class="{if $unAcronyme == $acronyme}me{/if} benevole" 
                                    data-toggle="popover"
                                    data-html="true"
                                    data-title="Paramètres de contact"
                                    data-content="{$benevole.prenom} {$benevole.nom}<br>{$benevole.mail}<br>{$benevole.telephone}<br>"
                                    data-container="body"
                                    data-placement="top">
                                    <span class="visible-sm visible-xs hidden-md hidden-lg">{$unAcronyme}</span>
                                    <span class="visible-md visible-lg">{$benevole.prenom} {$benevole.nom}</span>
                                </div>
                            {/foreach}
                        </div>

                    </td>
                {/foreach}

            </tr>

            {/foreach}

        </table>

        </form>
    <div class="clearfix"></div>
    </div>

    </div>

    <div class="col-md-2 col-sm-12">


        {include file='inc/usersList.tpl'}

    </div>


<script>

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

</script>
