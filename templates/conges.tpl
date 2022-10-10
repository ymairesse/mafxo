<form id="form-conges">

<h2>Jours de congés</h2>

<div class="col-xs-12 col-md-6">

    <h3>Fermetures hebodomadaires</h3>

    <table class="table table-condensed">
        <thead>
        <tr>
            <th style="width:10%">Jour</th>
            {foreach from = $listePeriodes key=noPeriode item=permanence}
                <th style="width:30%">{$permanence.debut} - {$permanence.fin}</th>
            {/foreach}
        </tr>
        </thead>

        <tbody>
        {foreach from = $daysOfWeek key=noJour item=jourFR}
            <tr data-jour="{$jourFR}">
                <th>{$jourFR}</th>
            {foreach from=$listePeriodes key=noPeriode item=permanence}
                <td data-jour="{$noJour}" data-periode="{$noPeriode}" class="{if isset($listeConges.hebdo.$noJour.$noPeriode)} conge{/if}">
                    <div class="checkbox" style="float:left">
                        <label>
                            <input  
                                type="checkbox" name="hebdo[]" 
                                class="conge" 
                                value="{$noJour}_{$noPeriode}"
                                data-jour="{$noJour}"
                                data-periode="{$noPeriode}"
                                {if isset($listeConges.hebdo.$noJour.$noPeriode)} checked{/if}>
                                <span class="hidden-xs">{$permanence.debut}</span>
                        </label>
                    </div>
                </td>
            {/foreach}
            <tr>
        {/foreach}
        </tbody>
    </table>

</div>

<div class="col-xs-12 col-md-6">

    <h3><button type="button" class="btn btn-info btn-sm btn-prevConge"><i class="fa fa-arrow-left"></i></button> 
        Jours fériés ou de fermeture extraordinaire (<span id="moisConge">{$month}/{$year}</span>) 
        <button type="button" class="btn btn-info btn-sm btn-nextConge"><i class="fa fa-arrow-right"></i></button>
    </h3>

    <div id="tableauFeries">

        {include file='inc/tableauFeries.tpl'}

    </div>

</div>

<button type="button" class="btn btn-danger btn-block" id="btn-saveDatesConge">Enregistrer</button>

</form>


<script>

    $(document).ready(function(){

        $('body').on('focus','.datepicker', function(){
            $(this).datepicker({
                format: 'dd/mm/yyyy',
                clearBtn: true,
                language: 'fr',
                calendarWeeks: true,
                autoclose: true,
                todayHighlight: true,
                changeMonth: false,
                startDate: new Date({$year},{$month-1},1),
                endDate: new Date({$year}, {$month}, 0),
                clearBtn: false,
                showTodayButton: true
            });
        });
    
    })

</script>