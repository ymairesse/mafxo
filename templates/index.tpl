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

		$('body').on('click', '#btn-save', function() {
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

		$('body').on('click', '.btn-delConge', function(){
			var bouton = $(this);
			var jourFerie = $(this).closest('tr');
			var laDate = jourFerie.find('input:text').val();
			$.post('inc/delJourFerie.inc.php', {
				laDate: laDate
				}, function(resultat){
					bootbox.alert({
						title: 'Suppression d\'une date de congé',
						message: resultat + ' période(s) de congé supprimée(s)',
						callback: function (){
							bouton.closest('tr').remove();
						}
					})
				})
		})

		$('body').on('click', '#btn-saveDatesConge', function(){
			// mise en ordre des noms des champs
			var listeFeries = $('.congesFeries');
			listeFeries.each(function(i){
				var laDate = $(this).find('input:text');
				laDate.prop('name', 'date_' + i )
				var lesCheck = $(this).find(':checkbox');
				lesCheck.each(function(p){
					$(this).prop('name', 'check_' + i + '_' + p);
					})
			})

			var formulaire = $('#form-conges').serialize();
			var month = $('#month').val();
			$.post('inc/saveConges.inc.php', {
				month: month,
				formulaire: formulaire
			}, function(resultat){
				bootbox.alert({
					title: 'Enregistrement des congés',
					message: resultat + ' période(s) de congés enregistrée(s)'
				})
			})
		})

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

		$('body').on('click', '.btn-prevConge', function(){
			var month = parseInt($('#month').val());
			var year = parseInt($('#year').val());
			if (month == 1) {
				month = 12;
				year = year-1
				}
				else month = month-1;
			$('#year').val(year);
			$('#month').val(month);
			$('#moisConge').text(month + '/' + year);
			$.post('inc/getTableauFeries.inc.php', {
				month: month,
				year: year
				}, function(resultat){
					$('#tableauFeries').html(resultat);
				})
		})

		$('body').on('click', '.btn-nextConge', function(){
			var month = parseInt($('#month').val());
			var year = parseInt($('#year').val());
			if (month == 12) {
				month = 1;
				year = year+1
				}
				else month = month+1;
			$('#year').val(year);
			$('#month').val(month);
			$('#moisConge').text(month + '/' + year);
			$.post('inc/getTableauFeries.inc.php', {
				month: month,
				year: year
				}, function(resultat){
					$('#tableauFeries').html(resultat);
				})
		})

		$('body').on('click', '#addDateConge', function(){
            var jourFerie = $('tbody#congesFeries tr').last();
            $('#tableauFeries table > tbody').append(jourFerie);
            $('tr.congesFeries').last().find('input:checkbox').prop('checked', false);   
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

		// $('body').on('click', '.btn-inscription', function(event){

		// 	$.post('inc/testSession.inc.php', {},
		// 		function(resultat){
		// 		if (resultat == '') {
		// 			alert('Votre session est s\'est achevée. Veuillez vous reconnecter.');
		// 			window.location.replace('accueil.php');
		// 			}
		// 		})

		// 	var date = $(this).data('date');

		// 	var periode = $(this).data('periode');
		// 	var checkbox = $('input:checkbox.inscription[data-periode="' + periode + '"][data-date="' + date + '"]');
		// 	// cocher ou décocher la case
		// 	checkbox.trigger('click');

		// 	$('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"]').find('.visible').toggle()
		// 	// sélectionner la case
		// 	var ceci = $(this).closest('td');
		// 	// le bouton vient d'être checked quelques lignes plus haut ?
		// 	var isChecked = checkbox.prop('checked');
		// 	if (isChecked == true) {
		// 		if (ceci.find('.listeBenevoles button.me').length != 0){
		// 			// si un bouton .me existe, il repasse à la couleur rouge
		// 			ceci.find('.listeBenevoles button.me').removeClass('btn-primary').addClass('btn-danger');
		// 			// on supprime l'icône de la disquette
		// 			ceci.find('.listeBenevoles button.me').find('.disk').prop('hidden', true);
		// 			}
		// 			else {
		// 				var bouton = $('#bouton').html(); 
		// 				// ajouter le bouton pour le candidat bénévole à la période
		// 				$('td[data-date="' + date + '"][data-periode="' + periode + '"]').find('.listeBenevoles').append(bouton);
		// 				// ceci.find('.listeBenevoles button'.me).find('.disk').last().prop('hidden', false);
		// 				}
		// 	}
		// 	else {
		// 		$.post('inc/remove-btn-candidat.inc.php', {
		// 			date: date,
		// 			periode: periode
		// 		}, function(acronyme){
		// 			if (ceci.find('.listeBenevoles button.me').length > 0) {
		// 				// mise au rebut d'une inscription enregistrée
		// 				ceci.find('.listeBenevoles button.me').removeClass('btn-danger').addClass('btn-primary');
		// 				ceci.find('.listeBenevoles button.me').find('.disk').last().prop('hidden', false);
		// 			}
		// 			else {
		// 				// simple suppression d'une inscription pas encore enregistrée
		// 				$('td[data-date="' + date + '"][data-periode="' + periode + '"] button.candidat[data-acronyme="' + acronyme + '"]').remove();
		// 				}
					
		// 		})
		// 	}

		// })

		// $('body').on('click', '#btn-saveCalendar', function(){
		// 	var month = $('#month').val();
		// 	var year = $('#year').val();
		// 	var formulaire = $('#formInscription').serialize();
		// 	var title = 'Enregistrement des permanences';
			
		// 	$.post('inc/testSession.inc.php', {},
		// 		function(resultat){
		// 		if (resultat == '') {
		// 			alert('Votre session est s\'est achevée. Veuillez vous reconnecter.');
		// 			window.location.replace('accueil.php');
		// 			}
		// 		})
			
		// 	$.post('inc/warningModifCalendar.inc.php', {
		// 		month: month,
		// 		year: year,
		// 		formulaire: formulaire
		// 		}, function(resultat){
		// 			bootbox.confirm({
		// 				title: title,
		// 				message: resultat,
		// 				    buttons: {
		// 						confirm: {
		// 							label: 'Je confirme!',
		// 							className: 'btn-danger'
		// 						},
		// 						cancel: {
		// 							label: 'Annuler',
		// 							className: 'btn-info'
		// 						}
		// 					},
		// 				callback: function(result){
		// 					if (result == true) {
		// 						$.post('inc/saveCalendar.inc.php', {
		// 							month: month,
		// 							year: year,
		// 							formulaire: formulaire
		// 						}, function(resultat){
		// 							$.post('inc/getCalendar.inc.php', {
		// 								year: year,
		// 								month: month
		// 								}, function(resultat2) {
		// 							$('#corpsPage').html(resultat2);
		// 							});
		// 						})
		// 					}
		// 				}
					
		// 			})

		// 			}
		// 		)
		// 	})

		// $('body').on('click', '.btn-sameAsDay', function(){
		// 	var title = 'Report de vos inscriptions';
		// 	var message = '<br><strong style="color:red">N\'OUBLIEZ PAS D\'ENREGISTRER</strong>';
		// 	var jour = $(this).data('dayofweek');
		// 	var jourFR = $(this).data('jourfr');
		// 	var date = $(this).closest('tr').data('date');
		// 	var listeCheckBoxes = $('input:checkbox[data-date="' + date + '"]');
		// 	var modeleJour = {};
		// 	listeCheckBoxes.each(function(i){
		// 		var ch = $(this).is(':checked') ? 1 : 0;
		// 		modeleJour[i] = ch;
		// 		})

		// 	bootbox.confirm({
		// 		title: title,
		// 		message: 'Veuillez confirmer la recopie de <strong>vos inscriptions</strong> sur chaque <strong>' + jourFR + '</strong> du mois',
		// 		callback: function(result){
		// 			if (result == true) {
		// 				// vérifier que la session est encore active
		// 				$.post('inc/testSession.inc.php', {},
		// 					function(resultat){
		// 					if (resultat == '') {
		// 						alert('Votre session est s\'est achevée. Veuillez vous reconnecter.');
		// 						window.location.replace('accueil.php');
		// 						}
		// 					})

		// 				var bouton = $('#bouton').html();

		// 				var n = 0;
		// 				// recopier le modèle de journée dans les jours semaine suivants
		// 				$('input:checkbox[data-dayofweek="' + jour + '"]').each(function(i){
		// 					// à quelle période de la journée sommes-nous?
		// 					var periode = $(this).data('periode');
		// 					// parmi les checkboxes du même jour que l'originale,
		// 					// attribuer la valeur trouvée dans le modèle pour cette période si pas déjà checked
		// 					if (($(this).prop('checked') == false) && (modeleJour[periode] == 1)) {
		// 						$(this).prop('checked', true);
		// 						// ajouter le bouton à la fin de la liste des bénévoles
		// 						$(this).closest('td').find('.listeBenevoles').append(bouton);
								
		// 						$(this).closest('td').find('.btn-inscription .visible').toggle()

		// 						// $(this).closest('td').find('.listeBenevoles button').find('.disk').last().prop('hidden', false);
		// 						n++;
		// 						}
		// 				})

		// 				bootbox.alert({
		// 					title: title,
		// 					message: '<strong>' + n + '</strong> recopie(s) sur chaque <strong>' + jourFR + '</strong>' + message
		// 					})
		// 			}
		// 		}
		// 	})
		// })

		// $('body').on('click', '.btn-allDay', function(){
		// 	var date = $(this).data('date');
		// 	$('input:checkbox[data-date="' + date + '"]').each(function(){
		// 		$(this).prop('checked', !$(this).is(':checked'));
		// 	});
		// })

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