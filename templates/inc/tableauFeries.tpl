        <table class="table table-condensed" id="tableFeries">
        <tr>
            <th style="width:40%">Date</th>
            {foreach from = $listePeriodes key=noPeriode item=permanence}
                <th style="width:20%">{$permanence.debut} - {$permanence.fin}</th>
            {/foreach}
            <td style="width:1em;">
                &nbsp;
            </td>
        </tr>

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

        <!-- Ligne vide à compléter --------------------------------------------------- -->

        <tr class="congesFeries">
        <td>
            <div class="form-group">
            <input type="text" name="datesConge[]" class="form-control datepicker" placeholder="Date de la fermeture" value="">
            </div>
        </td>
        <td>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="feries[]" value="0" data-ladate="" data-periode="0">
                        <span class="hidden-xs">10h00</span>
                </label>
            </div>
        </td>
        <td>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="feries[]" value="1" data-ladate="" data-periode="1">
                        <span class="hidden-xs">12h30</span>
                </label>
            </div>
        </td>
        <td>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="feries[]" value="2" data-ladate="" data-periode="2">
                        <span class="hidden-xs">15h00</span>
                </label>
            </div>
        </td>
        <td>
            <button type="button" class="btn btn-xs btn-danger btn-delConge" title="Suppression de la ligne">
                <i class="fa fa-times"></i>
            </button>
        </td>
        </tr>

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