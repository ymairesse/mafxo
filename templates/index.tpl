<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Oxfam: Gestion des bénévoles</title>

{include file="styles.sty"}
{include file="javascript.js"}

</head>

<body>

<div class="container-fluid">
	{include file="boutonsHaut.tpl"}
</div>

<div id="corpsPage">
	{if isset($corpsPage)}
		{include file="$corpsPage.tpl"}
	{/if}
</div>

<div id="modal"></div>

{include file="footer.tpl"}

</body>

<script src="js/inscriptions.js"></script>	
<script src="js/conge.js"></script>
<script src="js/gestion.js"></script>

<script>

	function testSession(){
		$.post('inc/testSession.inc.php', {},
			function(resultat){
			if (resultat == '') {
				bootbox.alert({
					title: 'Dépassement du délai',
					message: 'Votre session s\'est achevée. Veuillez vous reconnecter.',
					callback: function(){
						window.location.replace('accueil.php');
					}
					})
				}
			})
		}

	$(document).ready(function() {

		$('body').on('click', '#btn-gestion', function(){
			testSession();

			var month = $('#month').val();
			var year = $('#year').val();;
			
			$.post('inc/gestion.inc.php', {
				month: month,
				year: year
				}, 
				function(resultat){
					$('#corpsPage').html(resultat);
				})
		})

		$('body').on('click', '#reset', function(){
			$('#formInscription')[0].reset();
			$('.me').removeClass('unSelect');	
			$('button.candidat').remove();
		})

		$('body').on('click', '#btn-conges', function(){
			testSession();

			var month = $('#month').val();
			var year = $('#year').val();;
			
			$.post('inc/editConges.inc.php', {
				month: month,
				year: year
				}, 
				function(resultat){
					$('#corpsPage').html(resultat);
				})
		})

		$('body').on('click', '#btn-savePeriodes', function(){
			testSession();

			var formulaire = $('#formEditPeriodes').serialize();
			$.post('inc/savePeriodes.inc.php', {
				formulaire: formulaire},
				function(resultat){
					bootbox.alert({
						title: 'Enregistrement',
						message: resultat + ' périodes enregistrées'
					})
			})
		})

		$('#btn-calendrier').click(function() {
			testSession();

			var month = $('#month').val();
			var year = $('#year').val();

			$.post('inc/getCalendar.inc.php', {
				month: month,
				year: year
				}, function(resultat) {
				$('#corpsPage').html(resultat);
			})
		})

		$('#btn-periodes').click(function(){
			testSession();

			$.post('inc/editPeriodes.inc.php', {}, function(resultat){
				$('#corpsPage').html(resultat);
			})
		})

		$('#btn-logout').click(function() {
			bootbox.confirm({
				title: 'Déconnexion',
				message: 'Veuillez confirmer la déconnexion',
				callback: function(result) {
					if (result == true) {
						$.post('inc/logout.inc.php', {},
							function(resultat) {
								window.location.assign('{$BASEDIR}');
							})
					}
				}
			})
		})

		$('#btn-profil').click(function() {
			testSession();

			$.post('inc/editProfile.inc.php', {}, function(resultat) {
				$('#modal').html(resultat);
				$('#modalProfil').modal('show');
			})
		})

		$('body').on('click', '#btn-saveProfil', function(){
			if ($('#formEditionProfil').valid()) {
				var formulaire = $('#formEditionProfil').serialize();
				$.post('inc/saveUser.inc.php', {
					formulaire: formulaire
				}, function(resultat){
					bootbox.alert(resultat);
					$('#modalProfil').modal('hide');
				})
			}
		})


		$('#btn-passwd').click(function(){
			testSession();
			
			$.post('inc/passwd.inc.php', {}, function(resultat){
				$('#corpsPage').html(resultat);
			})
		})

	})
</script>

</html>