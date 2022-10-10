<h2>Profil personnel</h2>

<form id="formInscription" class="form">

        <div class="col-xs-12 col-md-6">

            <div class="form-group">
                <label for="nom">Nom de famille *</label>
                <input type="text" 
                    class="form-control nomPrenom" 
                    id="nom" name="nom" 
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

        <div class="col-xs-12 col-md-3">

            <div class="form-group">
                <label for="acronyme">Pseudo</label> <i class="fa fa-info-circle fa-lg" title="Élément non modifiable"></i>
                <input type="text" 
                    class="form-control" 
                    id="acro" 
                    placeholder="Nom d'utilisateur" 
                    value="{$identite.acronyme}"
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
                <input type="text" 
                    class="form-control" 
                    id="telephone" 
                    name="telephone" 
                    maxlength="40" 
                    placeholder="Numéro de téléphone"
                    value="{$identite.telephone}">
            </div>
        </div> 
        
    <div class="clearfix micro">Les champs marqués d'une * sont obligatoires</div>

    <div class="btn-group pull-right">
        <input class="btn btn-default" type="reset" value="Annuler">
        <button type="button" class="btn btn-primary" id="btn-saveProfile">Enregistrer</button>
    </div>

</form> 

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
            }
        }
    })

    $('#btn-saveProfile').click(function(){
        var formulaire = $('#formInscription').serialize();
        $.post('inc/saveUser.inc.php', {
            formulaire: formulaire
        }, function(resultat){
            bootbox.alert({
                title: 'Enregistrement', 
                message: resultat
            })
        })
    })

})

</script>