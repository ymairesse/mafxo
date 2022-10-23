<div class="modal fade" id="modalFreezing" tabindex="-1" role="dialog" aria-labelledby="modalFreezingTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="modalFreezingTitle">Permissions sur les périodes</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <form id="formFreeze" class="form">

            <table class="table table-condensed">
                <tr>
                    <th>Date</th>
                    <th>Geler</th>
                </tr>

                {foreach from=$listeMois key=$mois item=dataMois}
                <tr>
                <th>{$dataMois.monthName} {$dataMois.year}</th>
                <td>
                <label class="radio-inline">
                    <input type="radio" name="freeze_{$mois}" value="0" checked>Libre
                    </label>
                    <label class="radio-inline">
                    <input type="radio" name="freeze_{$mois}" value="1" {if isset($freezes.$mois) && $freezes.$mois == 1} checked{/if}>Plus de désinscription
                    </label>
                    <label class="radio-inline">
                    <input type="radio" name="freeze_{$mois}" value="2"{if isset($freezes.$mois) && $freezes.$mois == 2} checked{/if}>Ni inscription ni désinscription
                    </label>
                </td>
                </tr>
                {/foreach}

            </table>
        </form> 

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="btn-modalFreeze">Confirmer</button>
      </div>
    </div>
  </div>

<style type="text/css">

    .help-block, .error {
        display: inline;
    }

    .error {
        color: red;
        font-weight: normal;
    }

    #acro {
        background-color: pink;
        font-size: 14pt;
        color: red;
    }

</style>

<script>

    $(document).ready(function(){

        $('#formInscription').validate({
            rules: {
                nom: {
                    required: true,
                    minlength: 2
                },
                prenom: {
                    required: true,
                    minlength: 2
                },
                mail: {
                    required: true,
                    email: true
                },
                passwd: {
                    maxlength: 12,
                    minlength: 6
                },
                passwd2: {
                    minlength : 6,
                    equalTo : "#passwd"
                }
            }
        })

        $('.voir').click(function (){
            if ($('input.pwd').prop('type') == 'text')
                $('input.pwd').prop('type', 'password');
                else $('input.pwd').prop('type', 'text');
        })


    })

</script>