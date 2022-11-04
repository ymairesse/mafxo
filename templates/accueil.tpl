<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Oxfam: Gestion des bénévoles</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	{include file="styles.sty"}
	{include file="javascript.js"}
</head>

<body>

<div class="container">

<div class="col-md-8 col-sm-12">

	<h2>Identification</h2>

	<form id="formLogin">
		<div class="panel panel-success">

			<div class="panel-heading">
				<h4 class="panel-title">Veuillez vous identifier</h4>
			</div>

			<div class="panel-body">

				<div class="form-group">
					<label for="name" class="control-label sr-only">Identifiant</label>
					<input type="text" id="identifiant" name="identifiant" class="form-control input-lg"
						placeholder="Nom d'utilisateur ou adresse mail" value="{$identifiant|default:''}" autocomplete="off">
					<span class="help-group">Identifiant en 6 lettres <strong style="color:red">OU adresse mail</strong></span>
				</div>

				<div class="input-group">
					<label for="mdp" class="control-label sr-only">Mot de passe</label>
						<span class="input-group-btn">
						<button class="btn btn-primary btn-lg" id="btn-view" type="button"><i class="fa fa-eye"></i></button>
					</span>
					<input type="password" 
						id="mdp" 
						name="mdp" 
						class="form-control input-lg" 
						placeholder="Mot de passe"
						value="" 
						autocomplete="off">

				</div>

				<div class="btn-group pull-right">
					<button class="btn btn-default btn-lg" type="reset">Annuler</button>
					<button class="btn btn-primary btn-lg" type="button" id="btn-login">Connexion</button>
				</div>
			</div> <!-- panel-body -->

			<div class="panel-footer">
				<button type="button" id="btnNewUser" class="btn btn-danger btn-lg"><i class="fa fa-pencil"></i> M'inscrire</button>
				<button type="button" id="btnMDP" class="btn btn-warning btn-sm pull-right">Mot de passe perdu</button>
			</div>

			<div class="clearfix"></div>

		</div> <!-- panel -->
	</form>

</div> <!-- col-md- -->

<div class="col-md-4 col-sm-12">

	{include file="information.tpl"}

</div> <!-- col-md -->

<div id="modal"></div>

</div>

</body>

<script>

	$(document).ready(function() {

		$('input:enabled').eq(0).focus();

		$('input').not('.autocomplete').attr('autocomplete', false);

		$('body').on('click', '#btn-modalRenewPwd', function(){
			var identifiant = $('#identifiantMDP').val();
			$.post('inc/prepareNewPasswd.inc.php', {
				identifiant: identifiant
				},
				function(resultat){
					alert(resultat);
					$('#modalRenewPwd').modal('hide');
				}
			)
		});


		$('#formLogin').validate({
			rules: {
				identifiant: {
					required: true,
					minlength: 6,
					maxlength: 60
				},
				mdp: {
					required: true,
					minlength: 6
				}
			},
			errorElement: 'span',
			errorClass: 'error'
		})

		$('#btn-view').click(function(){
			if ($('input#mdp').prop('type') == 'password')
				$('input#mdp').prop('type', 'text');
				else $('input#mdp').prop('type', 'password');
		})

		$('#btnMDP').click(function() {
			$.post('inc/changeLostPwd.inc.php', {
			}, function(resultat){
				$('#modal').html(resultat);
				$('#modalRenewPwd').modal('show');
			})
		})


		// ----------------------------------------------------
		$('#btnNewUser').click(function(){
			$.post('inc/modalNewUser.inc.php', {
			}, function(resultat){
				$('#modal').html(resultat);
				$('#modalInscription').modal('show');
			})
		})

		$('body').on('click', '#btn-inscription', function(){
			if ($("#formInscription").valid()){
				var formulaire = $('#formInscription').serialize();
				$.post('inc/saveNewUser.inc.php', {
					formulaire: formulaire
				}, function(resultat){
					bootbox.alert({
						title: 'Enregistrement de vos données',
						message: resultat
					})
					$('#modalInscription').modal('hide');
				})
			}
		})
		// ----------------------------------------------------

		$('#btn-login').click(function() {
			if ($('#formLogin').valid()) {
				var formulaire = $('#formLogin').serialize();
				$.post('inc/login.inc.php', {
					formulaire: formulaire
				}, function(resultat) {
					if (resultat != 'ok') {
						bootbox.alert(resultat);
						}
					else {
						window.location.assign('index.php');
					}
				})
			}
			else bootbox.alert({
				title: "Connexion",
				message: "Utilisateur inconnu ou mot de passe incorrect"
			})
		})

		$('body').on('keyup', '.nomPrenom', function(){
			var nom = $('#nom').val();
			var prenom = $('#prenom').val();
			$.post('inc/acroFromNomPrenom.inc.php', {
				nom: nom,
				prenom: prenom
			}, function(resultat){
				$('#acronyme, #acro').val(resultat);
			})
		})

		$('body').on('change', '.nomPrenom', function(){
			var nom = $('#nom').val();
			var prenom = $('#prenom').val();
			$.post('inc/verifAcroExiste.inc.php', {
				nom: nom,
				prenom: prenom
			}, function(resultat){
				if (resultat == 1){
					alert('Cet utilisateur/utilisatrice existe déjà');
					$('#btn-inscription').prop('disabled', true);
				}
				else $('#btn-inscription').prop('disabled', false);
			})
		})

		$('body').on('change', '#mail', function(){
			var mail = $('#mail').val();
			$.post('inc/verifMailExiste.inc.php', {
				mail: mail
			}, function(resultat){
				if (resultat == 1){
					alert('Cette adresse mail est déjà utilisée');
					$('#btn-inscription').prop('disabled', true);
				}
				else $('#btn-inscription').prop('disabled', false);
			})
		})

	})
</script>