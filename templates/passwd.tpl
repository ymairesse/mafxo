<div class="container">

<h2>Changement du mot de passe</h2>

<h3>{$identite.nom} {$identite.prenom} [{$identite.acronyme}]</h3>

<form id="form-passwd" autocomplete="off">

    <div class="col-md-6 col-xs-12">

        <div class="form-group">
            <label for="passwd">Mot de passe souhaité *</label>
            <input type="password" 
                class="form-control pwd" 
                id="passwd" 
                name="passwd" 
                minlength="6" 
                maxlength="20" 
                placeholder="Le mot de passe que vous souhaitez utiliser"
                autocomplete="off">
        </div>

    </div>

    <div class="col-md-6 col-xs-12">

        <div class="form-group">
            <label for="passwd">Mot de passe souhaité *</label>
            <input type="password" 
                class="form-control pwd" 
                id="passwd2" 
                name="passwd2" 
                minlength="6" 
                maxlength="20" 
                placeholder="Répétez le mot de passe que vous souhaitez utiliser"
                autocomplete="off">
        </div>

    </div>

    <button type="button" class="btn btn-primary pull-right" id="btn-savePwd">Envoyer</button>

    <div class="clearfix"></div>
    
    <button type="button" class="btn btn-info btn-xs" id="btn-voir">Afficher le mot de passe</button>

</form>

</div>

<script>

    $(document).ready(function() {

        $('#btn-voir').click(function (){
            if ($('input.pwd').prop('type') == 'text')
                $('input.pwd').prop('type', 'password');
                else $('input.pwd').prop('type', 'text');
        })

        $('#btn-savePwd').click(function() {
            if ($('#form-passwd').valid()) {
                var formulaire = $('#form-passwd').serialize();
                
                $.post('inc/saveNewPwd.inc.php', {
                    formulaire: formulaire
                }, function(resultat){
                    bootbox.alert({
                        title: 'Enregistrement',
                        message: resultat
                    })
                })
            }
        })

        $('#form-passwd').validate({
            rules: {
                passwd: {
                    minlength: 6,
                    maxlength: 20,
                },
                passwd2: {
                    equalTo: "#passwd"
                }
            },
            messages: {
                passwd: 'Au moins 6 signes, lettres et chiffres.',
                passwd2: 'Les deux versions diffèrent',
            }
        });

    })
</script>