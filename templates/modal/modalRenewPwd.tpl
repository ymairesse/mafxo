<div class="modal fade" id="modalRenewPwd" tabindex="-1" role="dialog" aria-labelledby="modalChangePwdTitle"
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

        <form id="formRenewPasswd">

            <div class="form-group">
              <label for="passwd">Veuillez indiquer votre identifiant (6 ou 7 signes) ou l'adresse mail de votre profil</label>
              <input type="text" class="form-control" id="identifiantMDP" name="identifiantMDP" minlength="6" maxlength="60"
                placeholder="Votre identifiant" value="">
            </div>
          
          <div class="clearfix"></div>

        </form>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="btn-modalRenewPwd">Envoyer la demande</button>
      </div>
    </div>
  </div>
</div>
