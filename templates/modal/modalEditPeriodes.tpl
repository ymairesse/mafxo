<div class="modal fade" id="modalEditPeriodes" tabindex="-1" role="dialog" aria-labelledby="modalEditPeriodesTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="modalEditPeriodesTitle">Modification des périodes de permanences</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

            <form id="formEditPeriodes">

                {foreach from=$listePeriodes key=id item=periode}
                    {include file="../inc/inputPeriode.tpl"}
                {/foreach}

            <div class="clearfix"></div>

            </form>

      </div>

      <div class="modal-footer">
            <button type="button" id="btn-savePeriodes" class="btn btn-primary">Enregistrer</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
      </div>
    </div>
  </div>

