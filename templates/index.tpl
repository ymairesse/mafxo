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

<script>

	$(document).ready(function() {

		$('body').on('click', '#btn-gestion', function(){
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

		// $('body').on('click', '#btn-save', function(event) {
		// 	if ($('#form-passwd').valid()) {
        //         var formulaire = $('#form-passwd').serialize();
        //         $.post('inc/saveNewPwd.inc.php', {
        //             formulaire: formulaire
        //         }, function(resultat){
        //             bootbox.alert({
        //                 title: 'Enregistrement',
        //                 message: resultat
        //             })
        //         })
        //     }
        // })

		$('body').on('click', '#btn-conges', function(){
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

		$('body').on('click', '.btn-prevMonth', function(){
			var month = parseInt($('#month').val());
			var year = parseInt($('#year').val());
			if (month == 1) {
				month = 12;
				year = year-1
				}
				else month = month-1;
			$('#year').val(year);
			$('#month').val(month);
			$.post('inc/getCalendar.inc.php', {
				month: month,
				year: year
			}, function(resultat) {
				$('#corpsPage').html(resultat);
			})
		})

		$('body').on('click', '.btn-nextMonth', function(){
			var month = parseInt($('#month').val());
			var year = parseInt($('#year').val());
			if (month == 12) {
				month = 1;
				year = year+1
				}
				else month = month+1;
			$('#year').val(year);
			$('#month').val(month);

			$.post('inc/getCalendar.inc.php', {
				month: month,
				year: year
				}, function(resultat) {
			$('#corpsPage').html(resultat);
			})
		})

		$('#btn-calendrier').click(function() {
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
			$.post('inc/editProfile.inc.php', {}, function(resultat) {
				$('#corpsPage').html(resultat);
			})
		})

		$('#btn-passwd').click(function(){
			$.post('inc/passwd.inc.php', {}, function(resultat){
				$('#corpsPage').html(resultat);
			})
		})

	})
</script>

</html>