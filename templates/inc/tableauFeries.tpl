        <table class="table table-condensed">
        <tr>
            <th style="width:40%">Date</th>
            {foreach from = $listePeriodes key=noPeriode item=permanence}
                <th style="width:20%">{$permanence.debut} - {$permanence.fin}</th>
            {/foreach}
            <td style="width:1em;">
                &nbsp;
            </td>
        </tr>

        <tbody id="congesFeries">
        {foreach from=$listeConges.feries key=laDate item=lesPeriodes name=ferie}
        
        <tr class="congesFeries">
            <td>

              <div class="form-group">
                <input type="text" name="datesConge[]" class="form-control datepicker" placeholder="date" value="{$laDate}">
            </div>
            
            </td>
            {foreach from=$listePeriodes key=noPeriode item=permanence}
                <td class="{if isset($listeConges.feries.$laDate.$noPeriode)}conge{/if}">
                    <div class="checkbox">
                        <label>
                            <input  
                                type="checkbox" 
                                name="feries[]"
                                value="{$noPeriode}"
                                data-laDate="{$laDate}"
                                data-periode="{$noPeriode}"
                                {if isset($listeConges.feries.$laDate.$noPeriode)}checked{/if}>
                                <span class="hidden-xs">{$permanence.debut}</span>
                        </label>
                    </div>
                </td>
            {/foreach}
            <td>
                <button type="button" 
                    class="btn btn-xs btn-danger btn-delConge"
                    title="Suppression de la ligne">
                    <i class="fa fa-times"></i>
                </button>
            </td>
        </tr>
        {/foreach}
        </tbody>

        <tfoot>
        <tr>

            <td colspan="5">
                <button type="button" 
                    class="btn btn-success btn-xs btn-block"
                    id="addDateConge"
                    title="Ajouter une date">
                    <i class="fa fa-plus"></i>
                    </button>
            </td>

        </tr>
        </tfoot>

        </table>