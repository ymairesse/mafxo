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

          <div class="col-md-6 col-xs-12">

            <div class="form-group">
              <label for="passwd">Mot de passe souhaité</label>
              <input type="passwd" class="form-control" id="passwd" name="passwd" minlength="6" maxlength="15"
                placeholder="Nouveau mot de passe">
            </div>

          </div>
          <div class="col-md-6 col-xs-12">

            <div class="form-group">
              <label for="passwd">Encore une fois</label>
              <input type="password" class="form-control" id="passwd2" name="passwd2" minlength="6" maxlength="15"
                placeholder="Répétez le mot de passe">
            </div>

          </div>

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

    $('#formPasswd').validate({
      rules: {
        passwd: {
          maxlength: 12,
          minlength: 6,
          pwcheck: true
        },
        passwd2: {
          minlength: 6,
          equalTo: "#passwd"
        }
      },
      messages: {
        passwd: {
          pwcheck: 'Au moins deux lettres et au moins 2 chiffres'
        }
      }
    })

    $.validator.addMethod("pwcheck", function(value, element) {
            var countNum = (value.match(/[0-9]/g) || []).length;
            var countLet = (value.match(/[a-zA-Z]/g) || []).length;
            return ((countNum >= 2) && (countLet >= 2));
        });

    // $.validator.addMethod.pwcheck = function(value, element) {
    //   console.log(element);
    //   var countNum = (value.match(/[0-9]/g) || []).length;
    //   var countLet = (value.match(/[a-zA-Z]/g) || []).length;
    //   return ((countNum >= 2) && (countLet >= 2))
    // }

  })
</script>