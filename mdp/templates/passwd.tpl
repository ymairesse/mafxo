<div class="container">

    <h2>Changement du mot de passe</h2>

    <p>Bonjour <strong>{$identite.prenom}</strong>. Heureux de vous retrouver. Veuillez indiquer ci-dessous le nouveau mot de passe que vous souhaitez utiliser.</p>
    <p>Évitez les solutions trop simples (votre prénom, votre date de naissance,...).</p>

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
                    maxlength="12" 
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
                <input type="password" class="form-control pwd" id="passwd2" name="passwd2" minlength="6" maxlength="12" placeholder="Répétez le mot de passe que vous souhaitez utiliser">
                    <span class="input-group-btn">
                        <button class="btn btn-primary voir" type="button"><i class="fa fa-eye"></i></button>
                    </span>
                </div>
            </div>

        </div>

        <button type="button" class="btn btn-primary pull-right" id="btn-save">Envoyer</button>
        <input type="text" value="{$token}" name="token">
        <input type="text" value="{$identite.acronyme}" name="acronyme">

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

        $('#btn-save').click(function() {
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


        $.validator.addMethod('pwcheck', function(value, element) {
            var countNum = (value.match(/[0-9]/g) || []).length;
            var countLet = (value.match(/[a-zA-Z]/g) || []).length;
            return ((countNum >= 2) && (countLet >= 2));
        });


        $('#form-passwd').validate({
            rules: {
                passwd: {
                    minlength: 6,
                    maxlength: 12,
                },
                passwd2: {
                    equalTo: "#passwd"
                }
            },
            messages: {
                passwd: 'Au moins 6 signes, lettres et chiffres.',
                passwd2: 'Les deux versions diffèrent',
                errorElement: 'div',
                errorLabelContainer: '#errorText'

            }
        });




    })
</script>