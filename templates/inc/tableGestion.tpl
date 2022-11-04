<!-- -------------------- Navigation temporelle -------------------- -->

    <div style="text-align: center">
        <h2 id="encadre">
            <button type="button" 
                class="btn btn-primary pull-left" 
                id="btn-prevGestMonth"
                title="Mois précédent">
                <i class="fa fa-arrow-left"></i>
                <span class="hidden-xs hidden-sm"> Mois précédent</span>
            </button>
            <span id="navMonthName">{$monthName}</span>
            <span id="navYear" class="hidden-xs">{$year}</span>
            <button type="button" 
                class="btn btn-primary pull-right"
                id="btn-nextGestMonth"
                title="Mois suivant">
                <span class="hidden-sm hidden-xs">Mois suivant </span>
                <i class="fa fa-arrow-right"></i>
            </button> 
        </h2>
    </div>

<!-- --------------------------------------------------------------------------------- -->

<table class="table table-condensed" id="calendar-table">

    <tr>
        <th style="width:10%">
            &nbsp;
        </th>

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

                    <div class="postit"
                        class="btn btn-default btn-xs btn-block" 
                        data-dayofweek = "{$dataJournee.day.dayOfWeek}">
                            {$dataJournee.day.fr|substr:0:2}<br><span style="font-size:1.2em">{$dataJournee.day.fr|substr:4}</span>
                    </div>
                    <div class="btn-group-vertical btn-block">
                    <a href="#" 
                        class="btn btn-primary btn-xs btn-block btn-confirm" 
                        data-toggle="tooltip" 
                        data-container="body"
                        data-placement="right"
                        data-nombre="1"
                        title="Confirmer le 1er">
                        1
                    </a>
                    <a href="#" 
                        class="btn btn-warning btn-xs btn-block btn-confirm" 
                        data-toggle="tooltip" 
                        data-container="body"
                        data-placement="right"
                        data-nombre="2" 
                        title="Confirmer les deux 1ers">
                        2
                    </a>
                    <a href="#" 
                        class="btn btn-info btn-xs btn-block btn-confirm" 
                        data-toggle="tooltip" 
                        data-container="body"
                        data-placement="right"
                        data-nombre="3" 
                        title="Confirmer les trois 1ers">
                        3
                    </a>
                </div>

            </td>

            {foreach from=$dataJournee.periodes key=periode item=dateHeure}
                <!-- liste des acronymes pour cette période -->
                {assign var=benevoles value=$dataJournee.periodes.$periode|array_keys}
    
                <td data-periode="{$periode}" 
                    data-date="{$laDate}" 
                    class="case {if (isset($listeConges.feries.$laDate.$periode)) || (isset($listeConges.hebdo.$numJourSemaine.$periode))}conge{/if}"
                    {if (isset($listeConges.feries.$laDate.$periode)) || (isset($listeConges.hebdo.$numJourSemaine.$periode))}
                    title="Congé ou fermeture"
                    {/if}>

                    <div style="padding: 1em">

                        <input  
                            type="checkbox" name="inscriptions[]" class="inscription" hidden
                            {if (isset($listeConges.feries.$laDate.$periode)) || (isset($listeConges.hebdo.$numJourSemaine.$periode))}disabled{/if}
                            value = "{$laDate}_{$periode}"
                            data-date = "{$laDate}"
                            data-dayofweek = "{$dataJournee.day.dayOfWeek}"
                            data-periode = "{$periode}">

                            <span class="badge badge-info">{$listePeriodes.$periode.debut}</span>

                            {if !((isset($listeConges.feries.$laDate.$periode)) || (isset($listeConges.hebdo.$numJourSemaine.$periode)))}
                                <button type="button" 
                                    class="btn btn-xs btn-primary btn-inscription pull-right"
                                    data-placement="left" 
                                    data-toggle="tooltip" 
                                    title="Inscription ou désinscription"
                                    data-date="{$laDate}"
                                    data-periode="{$periode}">
                                    <span class="visible hidden-xs desinscription hidden">Désinscription</span>
                                    <span class="visible hidden-xs inscription">Inscription</span>

                                    <span class="visible-xs hidden-sm"><i class="fa fa-calendar-check-o"></i></span>
                                </button>
                            {/if}

                    </div>

                    <div class="listeBenevoles" data-date="{$laDate}" data-periode="{$periode}">
                        {foreach from=$benevoles item=unAcronyme}

                            {assign var=benevole value=$usersList.$unAcronyme}

                            <div class="btn-group btn-group-justified doubleBtn">

                                <div class="btn-group" style="width:85%">
                                    <button type="button" 
                                        class="btn btn-primary btn-block btn-benevole {if $calendar.$laDate.periodes.$periode.$unAcronyme.confirme == 1}confirmed{/if}" 
                                        data-toggle="popover"
                                        data-html="true"
                                        data-title="Paramètres de contact"
                                        data-content="{$benevole.prenom} {$benevole.nom}<br>
                                            <i class='fa fa-send'></i> <a href='mailto:{$benevole.mail}'>{$benevole.mail}</a><br>
                                            <i class='fa fa-phone'></i> {$benevole.telephone}"
                                        data-container="body"
                                        data-acronyme="{$benevole.acronyme}"
                                        data-confirme="false"
                                        data-placement="top">
                                            <span class="visible-xs hidden-md hidden-lg">
                                                {$benevole.prenom|truncate:10:"...":true} 
                                                    <span class="check">{if $calendar.$laDate.periodes.$periode.$unAcronyme.confirme == 1} <i class="fa fa-check"></i>{/if}</span>
                                                <span class="disk" hidden>(<i class="fa fa-floppy-o"></i>)</span>
                                            </span>
                                            <span class="visible-sm visible-md visible-lg">
                                                {$benevole.prenom} {$benevole.nom} 
                                                    <span class="check">{if $calendar.$laDate.periodes.$periode.$unAcronyme.confirme == 1}<i class="fa fa-check"></i>{/if}</span>
                                                <span class="disk" hidden>(<i class="fa fa-floppy-o"></i>)</span>
                                            </span>
                                    </button>
                                </div>

                                <div class="btn-group" style="width:15%">
                                    <button type="button" 
                                        class="btn btn-success btn-confirmePermanence"
                                        data-acronyme="{$unAcronyme}">
                                            <i class="fa fa-check"></i>
                                    </button>
                                </div>

                            </div>

                        {/foreach}
                    </div>

                </td>
            {/foreach}

        </tr>

        {/foreach}

</table>