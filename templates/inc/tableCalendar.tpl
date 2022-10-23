<!-- -------------------- Navigation temporelle -------------------- -->

<div style="text-align: center">
    <h2 id="encadre">
        <button type="button" 
            class="btn btn-primary pull-left" id="btn-prevMonth"
            title="Mois précédent">
            <i class="fa fa-arrow-left"></i>
            <span class="hidden-xs hidden-sm"> Mois précédent</span>
        </button> 
        {$monthName} <span class="hidden-xs">{$year}</span>
        <button type="button" 
            class="btn btn-primary pull-right" id="btn-nextMonth"
            title="Mois suivant">
            <span class="hidden-sm hidden-xs">Mois suivant </span>
            <i class="fa fa-arrow-right"></i>
        </button> 
    </h2>
</div>

<!-- --------------------------------------------------------------------------------- -->

<input type="hidden" id="freezeStatus" name="freezeStatus" value="{$freezeStatus}">

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
        data-date="{$laDate}"
        {if $numJourSemaine == 1}class="beginOfWeek"{/if}>

        <td style="padding:0">

            <div class="btn-group-vertical btn-block">

                <button type="button" 
                    class="btn btn-success btn-xs" 
                    data-dayofweek = "{$dataJournee.day.dayOfWeek}">
                        {$dataJournee.day.fr|substr:0:2}<br><span style="font-size:1.2em">{$dataJournee.day.fr|substr:4}</span>
                </button>
                <button type="button" 
                    class="btn btn-warning btn-xs btn-sameAsDay"
                    data-dayofweek="{$dataJournee.day.dayOfWeek}"
                    data-jourfr="{$daysOfWeek.$numJourSemaine}"
                    data-toggle="tooltip"
                    data-placement="right"
                    data-container="body"
                    title="Reporter sur chaque {$daysOfWeek.$numJourSemaine} du mois">
                    <i class="fa fa-plus-square-o"></i>
                </button>

            </div>
        </td>

        {foreach from=$dataJournee.periodes key=periode item=dateHeure}
            
            {assign var=benevoles value=$dataJournee.periodes.$periode|array_keys}
            
            <td data-periode="{$periode}" 
                data-date="{$laDate}" 
                class="case {if (isset($listeConges.feries.$laDate.$periode)) || (isset($listeConges.hebdo.$numJourSemaine.$periode))}conge{/if}"
                {if (isset($listeConges.feries.$laDate.$periode)) || (isset($listeConges.hebdo.$numJourSemaine.$periode))}
                title="Congé ou fermeture"
                {/if}>

                <div style="padding: 1em;">

                    <input  
                        type="checkbox" name="inscriptions[]" class="inscription" hidden
                        {if (isset($listeConges.feries.$laDate.$periode)) || (isset($listeConges.hebdo.$numJourSemaine.$periode))}disabled{/if}
                        value="{$laDate}_{$periode}"
                        data-date="{$laDate}"
                        data-dayofweek = "{$dataJournee.day.dayOfWeek}"
                        data-periode="{$periode}"
                        {if $acronyme|in_array:$benevoles}checked{/if}>

                        <span class="badge badge-info">{$listePeriodes.$periode.debut}</span>

                        {if !((isset($listeConges.feries.$laDate.$periode)) || (isset($listeConges.hebdo.$numJourSemaine.$periode)))}

                            <button type="button" 
                                class="btn btn-xs btn-primary btn-inscription pull-right" 
                                data-placement="left" 
                                data-toggle="tooltip" 
                                title="Inscription ou désinscription"
                                data-date="{$laDate}"
                                data-periode="{$periode}">

                                <span class="hidden-xs">
                                    {assign var=visibles value=(in_array($acronyme, $dataJournee.periodes.$periode|array_keys))}
                                    <span class="visible desinscription" {if (in_array($acronyme, $dataJournee.periodes.$periode|array_keys) != '1')}hidden{/if}>
                                    Désinscription
                                    </span>
                                    <span class="visible inscription" {if (in_array($acronyme, $dataJournee.periodes.$periode|array_keys) == '1')}hidden{/if}>
                                    Inscription
                                    </span>
                                </span>
                                <span class="visible-xs hidden-sm"><i class="fa fa-calendar-check-o"></i></span>
                            </button>

                        {/if}

                </div>

                <div class="listeBenevoles" data-date="{$laDate}" data-periode="{$periode}">
                    {foreach from=$benevoles item=unAcronyme}

                        {assign var=benevole value=$usersList.$unAcronyme}

                        <button 
                            type="button" 
                            class="btn {if $unAcronyme == $acronyme}me btn-danger{else}btn-primary{/if} {if $calendar.$laDate.periodes.$periode.$unAcronyme.confirme == 1}confirmed{/if} btn-block" 
                            data-toggle="popover"
                            data-html="true"
                            data-title="Paramètres de contact"
                            data-content="{$benevole.prenom} {$benevole.nom}<br>
                                    <i class='fa fa-send'></i> {$benevole.mail}<br>
                                    <i class='fa fa-phone'></i> {$benevole.telephone|default:'---'}"
                            data-container="body"
                            data-acronyme="{$acronyme}"
                            data-placement="top">
                            <span class="visible-xs hidden-md hidden-lg">{$benevole.prenom|truncate:10:"...":true}  
                            {if $calendar.$laDate.periodes.$periode.$unAcronyme.confirme == 1} <i class="fa fa-check"></i>{/if}
                                <span class="disk" hidden>(<i class="fa fa-floppy-o"></i>)</span>
                            </span>
                            <span class="visible-sm visible-md visible-lg">
                            {$benevole.prenom} {$benevole.nom}
                                {if $calendar.$laDate.periodes.$periode.$unAcronyme.confirme == 1}<i class="fa fa-check"></i>{/if}
                             <span class="disk" hidden>(<i class="fa fa-floppy-o"></i>)</span>
                             </span>
                        </button>

                    {/foreach}
                </div>

            </td>
        {/foreach}

    </tr>

    {/foreach}

</table>

