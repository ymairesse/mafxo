<?php
/* Smarty version 3.1.34-dev-7, created on 2022-10-04 16:25:01
  from '/home/yves/www/mdm/templates/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_633c423d807639_31646414',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '44f0df7087bfd92334c963d117d16425fb7afe19' => 
    array (
      0 => '/home/yves/www/mdm/templates/index.tpl',
      1 => 1664893475,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:styles.sty' => 1,
    'file:javascript.js' => 1,
    'file:boutonsHaut.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_633c423d807639_31646414 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Oxfam: Gestion des bénévoles</title>

<?php $_smarty_tpl->_subTemplateRender("file:styles.sty", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:javascript.js", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</head>

<body>

<div class="container-fluid">
	<?php $_smarty_tpl->_subTemplateRender("file:boutonsHaut.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>

<div id="corpsPage">
	<?php if ((isset($_smarty_tpl->tpl_vars['corpsPage']->value))) {?>
		<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['corpsPage']->value).".tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
	<?php }?>
</div>

<div id="modal"></div>

<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</body>

<?php echo '<script'; ?>
>

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
			$('.case').removeClass('candidat');
			$('.case').removeClass('notCandidat')
			$('.me').removeClass('unSelect');	
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

		$('body').on('click', '.btn-sameAsDay', function(){
			var title = 'Report de vos inscriptions';
			var message = '<br><strong style="color:red">N\'OUBLIEZ PAS D\'ENREGISTRER</strong>';
			var jour = $(this).data('dayofweek');
			var jourFR = $(this).data('jourfr');
			var date = $(this).closest('tr').data('date');
			var listeCheckBoxes = $('input:checkbox[data-date="' + date + '"]');
			var modeleJour = {};
			listeCheckBoxes.each(function(i){
				var ch = $(this).is(':checked') ? 1 : 0;
				modeleJour[i] = ch;
				})
console.log(modeleJour);
			bootbox.confirm({
				title: title,
				message: 'Veuillez confirmer la recopie de <strong>vos inscriptions</strong> sur chaque <strong>' + jourFR + '</strong> du mois',
				callback: function(result){
					if (result == true) {
						var n = 0
						// recopier le modèle de journée dans les jours semaine suivants
						$('input:checkbox[data-dayofweek="' + jour + '"]').each(function(i){
							// à quelle période de la journée sommes-nous?
							var periode = $(this).data('periode');
							// parmi les checkboxes du même jour que l'originale,
							// attribuer la valeur trouvée dans le modèle pour cette période
							$(this).prop('checked', (modeleJour[periode] == 1));
							if (modeleJour[periode] == 1)
								$(this).closest('td').addClass('candidat');
							n++
						})
						bootbox.alert({
							title: title,
							message: '<strong>' + n + '</strong> recopies sur chaque <strong>' + jourFR + '</strong>' + message
							})
					}
				}
			})
		})

		$('body').on('click', '.btn-allDay', function(){
			var date = $(this).data('date');
			$('input:checkbox[data-date="' + date + '"]').each(function(){
				$(this).prop('checked', !$(this).is(':checked'));
			});
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
								window.location.assign('<?php echo $_smarty_tpl->tpl_vars['BASEDIR']->value;?>
');
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

		$('body').on('click', '.btn-inscription', function(event){
			var date = $(this).data('date');
			var periode = $(this).data('periode');
			var checkbox = $('input:checkbox.inscription[data-periode="' + periode + '"][data-date="' + date + '"]');
			// cocher ou décocher la case
			checkbox.trigger('click');
			var ceci = $(this).closest('td');

			var isChecked = checkbox.prop('checked');
			if (isChecked == true) {
				// si un bouton .me existe, il repasse à la couleur rouge
				ceci.find('.listeBenevoles button.me').removeClass('btn-lightRed').addClass('btn-danger');
				// s'il existe déjà un bouton ".me", on ne rajoute plus rien, sinon ajouter le bouton .candidat
				if (ceci.find('.listeBenevoles button.me').length == 0)
					$.post('inc/btn-candidat.inc.php', {
						date: date,
						periode: periode
					}, function(resultat){
						// ajouter le bouton pour le candidat bénévole à la période
						$('td[data-date="' + date + '"][data-periode="' + periode + '"]').find('.listeBenevoles').append(resultat);
					})
			}
			else {
				$.post('inc/remove-btn-candidat.inc.php', {
					date: date,
					periode: periode
				}, function(acronyme){
					// suppression d'une inscription pas encore enregistrée
					$('td[data-date="' + date + '"][data-periode="' + periode + '"] button.candidat[data-acronyme="' + acronyme + '"]').remove();
					// mise au rebut d'une inscription enregistrée
					ceci.find('.listeBenevoles button.me').removeClass('btn-danger').addClass('btn-lightRed');
				})
			}
		})



		$('body').on('click', '#btn-saveCalendar', function(){
			var month = $('#month').val();
			var year = $('#year').val();
			var formulaire = $('#formInscription').serialize();
			var title = 'Enregistrement des permanences';
			$.post('inc/warningModifCalendar.inc.php', {
				month: month,
				year: year,
				formulaire: formulaire
				}, function(resultat){
					bootbox.confirm({
						title: title,
						message: resultat,
						    buttons: {
								confirm: {
									label: 'Je confirme!',
									className: 'btn-danger'
								},
								cancel: {
									label: 'Annuler',
									className: 'btn-info'
								}
							},
						callback: function(result){
							if (result == true) {
								$.post('inc/saveCalendar.inc.php', {
									month: month,
									year: year,
									formulaire: formulaire
								}, function(resultat){
									$.post('inc/getCalendar.inc.php', {
										year: year,
										month: month
										}, function(resultat2) {
									$('#corpsPage').html(resultat2);
									});
								})
							}
						}
					
					})

					}
				)
			})

	    $('[data-toggle="popover"]').popover();

        $('[data-toggle="tooltip"]').tooltip();

	})
<?php echo '</script'; ?>
>

</html>
<?php }
}
