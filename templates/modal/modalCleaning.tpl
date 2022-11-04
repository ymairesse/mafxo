<div class="modal fade" id="modalCleaning" tabindex="-1" role="dialog" aria-labelledby="modalCleaningTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="modalCleaningTitle">Effacement des périodes échues</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <form id="formClean" class="form">

            <p><span class="btn-danger">Attention, la suppression est définitive.</span><br>
            Il n'est pas possible de supprimer une période non échue</p>

            <ul class="list-unstyled" style="height:10em; overflow: auto;">
                {foreach from=$listeMois key=$mois item=dataMois}
                <li>
                <div class="checkbox">
                    <label>
                    <input type="checkbox" 
                        name="{$dataMois.year}_{$dataMois.month}"
                        {if $dataMois.past == 0}disabled{/if} 
                        value="1">
                        {$dataMois.monthName} {$dataMois.year} {if $dataMois.past == 0} <strong>[Non échu]</strong>{/if}  
                    </label> 
                </div>
                </li>
                {/foreach}
            </ul>
        </form> 

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-danger" id="btn-modalClean">Confirmer</button>
      </div>
    </div>
  </div>
