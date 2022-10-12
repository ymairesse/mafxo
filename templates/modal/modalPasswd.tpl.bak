<div class="modal fade" id="modalChangePwd" tabindex="-1" role="dialog" aria-labelledby="modalChangePwdTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="modalChangePwdTitle">Changement du mot de passe</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <form id="formPasswd">

          <div class="col-xs-12">

            <div class="form-group">
              <label for="passwd">Mot de passe souhaité</label>
              <input type="password" class="form-control pwd" id="passwd" name="passwd" minlength="6" maxlength="12"
                placeholder="Nouveau mot de passe">
            </div>

          </div>
          <div class="col-xs-12">

            <div class="form-group">
              <label for="passwd">Encore une fois</label>
              <input type="password" class="form-control pwd" id="passwd2" name="passwd2" minlength="6" maxlength="12"
                placeholder="Répétez le mot de passe">
            </div>

          </div>

          <button type="button" class="btn btn-success btn-xs" id="btn-eye">Afficher le mot de passe</button>

          <div class="clearfix"></div>

        </form>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="btn-modalSavePwd">Enregistrer</button>
      </div>
    </div>
  </div>
</div>


<script>

  $(document).ready(function() {

    $('#btn-eye').click(function (){
      if ($('input.pwd').prop('type') == 'text')
          $('input.pwd').prop('type', 'password');
          else $('input.pwd').prop('type', 'text');
  })

		$('body').on('click', '#btn-modalSavePwd', function() {
      if ($('#formPasswd').valid()) {
        alert('test2');
        //         var formulaire = $('#form-passwd').serialize();
                
        //         $.post('inc/saveNewPwd.inc.php', {
        //             formulaire: formulaire
        //         }, function(resultat){
        //             bootbox.alert({
        //                 title: 'Enregistrement',
        //                 message: resultat
        //             })
        //         })
        }
      })



  $('#btn-modalSave')

    $('#formPasswd').validate({
      rules: {
        passwd: {
          minlength: 6
        },
        passwd2: {
          equalTo: "#passwd"
        }
      }
    })

  })
</script>