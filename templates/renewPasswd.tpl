<div class="container">

    <h2>Changement du mot de passe</h2>

    <form id="form-passwd" autocomplete="off">

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
                    placeholder="Le mot de passe que vous souhaitez utiliser"
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
                <input type="password" class="form-control pwd" id="passwd2" name="passwd2" minlength="6" maxlength="20" placeholder="Répétez le mot de passe que vous souhaitez utiliser">
                    <span class="input-group-btn">
                        <button class="btn btn-primary voir" type="button"><i class="fa fa-eye"></i></button>
                    </span>
                </div>
            </div>

        </div>

        <input type="hidden" name="acronyme" value="{$identite.acronyme}">
        <input type="hidden" name="token" value="{$token}">

        <button type="button" class="btn btn-primary pull-right" id="btn-renewPwd">Envoyer</button>

        <div class="clearfix"></div>

    </form>

</div>

<script>
    $(document).ready(function() {

        $('.voir').click(function (){
            if ($('input.pwd').prop('type') == 'text')
                $('input.pwd').prop('type', 'password');
                else $('input.pwd').prop('type', 'text');
        })

        $('#btn-renewPwd').click(function() {
            if ($('#form-passwd').valid()) {
                var formulaire = $('#form-passwd').serialize();
                $.post('inc/saveRenewPwd.inc.php', {
                    formulaire: formulaire
                }, function(resultat){
                    var message = '<br>Vous allez être redirigé·e vers la page d\'accueil';
                    bootbox.confirm({
                        title: 'Enregistrement',
                        message: resultat + message,
                        callback: function(result){
                         if (result === true) {
                            location.href = '{$BASEDIR}';
                        }
                        }
                    })
                })
            }
        })


    })
</script>