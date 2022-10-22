<div class="modal fade" id="modalProfil" tabindex="-1" role="dialog" aria-labelledby="modalProfilTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="modalProfilTitle">Modification du profil</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <form id="formEditionProfil" class="form" autocomplete="off">

            <div id="errorTxt"></div>

               <div class="col-xs-12 col-md-6">

                    <div class="form-group">
                        <label for="nom">Nom de famille *</label>
                        <input type="text" 
                            class="form-control nomPrenom" 
                            id="nom" 
                            name="nom" 
                            maxlength="40" 
                            placeholder="Votre nom de famille"
                            value="{$identite.nom}">
                        <span class="help-block">Nom de famille</span>
                    </div>
                
                </div>

                <div class="col-xs-12 col-md-6">

                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" 
                            class="form-control nomPrenom" 
                            id="prenom" 
                            name="prenom" 
                            maxlength="40" 
                            placeholder="Votre prénom"
                            value="{$identite.prenom}">
                        <span class="help-block">Prénom</span>
                    </div>

                </div>

                <div class="col-md-3 col-xs-12">

                    <div class="form-group">
                        <label for="acronyme">Pseudo</label>
                        <input type="text" 
                            class="form-control" 
                            id="acro" 
                            placeholder="Nom d'utilisateur"
                            value="{$identite.acronyme}"
                            name="acronyme"
                            readonly>
                    </div>

                </div>


                <div class="col-md-9 col-xs-12">

                    <div class="form-group">
                        <label for="mail">Adresse mail *</label>
                        <input type="email" 
                            class="form-control" 
                            id="mail" 
                            name="mail" 
                            maxlength="60" 
                            placeholder="Votre adresse mail"
                            value="{$identite.mail}">
                    </div>

                </div>

                <div class="col-md-6 col-xs-12">

                    <div class="form-group">
                        <label for="passwd">Mot de passe souhaité *</label>
                        <div class="input-group">
                        <input type="password" 
                            class="form-control pwd" 
                            id="passwd" 
                            name="passwd" 
                            minlength="6" 
                            maxlength="20" 
                            placeholder="Ne rien indiquer si pas de changement"
                            value=""
                            autocomplete="off">
                            <span class="input-group-btn">
                                <button class="btn btn-primary voir" type="button"><i class="fa fa-eye"></i></button>
                            </span>
                        </div>
                    </div>

                </div>

                <div class="col-md-6 col-xs-12">

                    <div class="form-group">
                        <label for="passwd">Mot de passe souhaité *</label>
                        <div class="input-group">
                        <input type="password" 
                            class="form-control pwd" 
                            id="passwd2" 
                            name="passwd2" 
                            minlength="6" 
                            maxlength="20" 
                            placeholder="Ne rien indiquer si pas de changement"
                            value=""
                            autocomplete="off">
                            <span class="input-group-btn">
                                <button class="btn btn-primary voir" type="button"><i class="fa fa-eye"></i></button>
                            </span>
                        </div>
                    </div>

                </div>

                <div class="col-xs-12 col-md-8">

                    <div class="form-group">
                        <label for="adresse">Adresse postale (optionnel)</label>
                        <input type="text" 
                            class="form-control" 
                            id="adresse" 
                            name="adresse" 
                            maxlength="40" 
                            placeholder="Rue et numéro"
                            value="{$identite.adresse}">
                    </div>

                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label for="cpostal">Code postal (optionnel)</label>
                        <input type="text"
                            class="form-control" 
                            id="cpostal" 
                            name="cpostal" 
                            maxlength="6"
                            placeholder="Code Postal"
                            value="{$identite.cpostal}">
                    </div>
                </div>

                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                        <label for="commune">Commune de résidence (optionnel)</label>
                        <input type="text" 
                            class="form-control" 
                            id="commune" 
                            name="commune" 
                            maxlength="40" 
                            placeholder="Commune"
                            value="{$identite.commune}">
                    </div>
                </div>


                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label for="adresse">Téléphone (optionnel)</label>
                        <input type="tel" 
                            class="form-control" 
                            id="telephone" 
                            name="telephone" 
                            maxlength="40" 
                            placeholder="Numéro de téléphone"
                            value="{$identite.telephone}">
                    </div>
                </div> 
                
            <div class="clearfix micro">Les champs marqués d'une * sont obligatoires</div>

        </form> 

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="btn-saveProfil">Enregistrer</button>
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

        $('#formEditionProfil').validate({
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
                    maxlength: 20
                },
                passwd2: {
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