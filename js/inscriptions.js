$('body').on('click', '.btn-inscription', function(event){

    $.post('inc/testSession.inc.php', {},
        function(resultat){
        if (resultat == '') {
            alert('Votre session est s\'est achevée. Veuillez vous reconnecter.');
            window.location.replace('accueil.php');
            }
        })

    var date = $(this).data('date');

    var periode = $(this).data('periode');
    var checkbox = $('input:checkbox.inscription[data-periode="' + periode + '"][data-date="' + date + '"]');
    // cocher ou décocher la case
    checkbox.trigger('click');

    $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"]').find('.visible').toggle()
    // sélectionner la case
    var ceci = $(this).closest('td');
    // le bouton vient d'être checked quelques lignes plus haut ?
    var isChecked = checkbox.prop('checked');
    if (isChecked == true) {
        if (ceci.find('.listeBenevoles button.me').length != 0){
            // si un bouton .me existe, il repasse à la couleur rouge
            ceci.find('.listeBenevoles button.me').removeClass('btn-primary').addClass('btn-danger');
            // on supprime l'icône de la disquette
            ceci.find('.listeBenevoles button.me').find('.disk').prop('hidden', true);
            }
            else {
                var bouton = $('#bouton').html(); 
                // ajouter le bouton pour le candidat bénévole à la période
                $('td[data-date="' + date + '"][data-periode="' + periode + '"]').find('.listeBenevoles').append(bouton);
                // ceci.find('.listeBenevoles button'.me).find('.disk').last().prop('hidden', false);
                }
    }
    else {
        $.post('inc/remove-btn-candidat.inc.php', {
            date: date,
            periode: periode
        }, function(acronyme){
            if (ceci.find('.listeBenevoles button.me').length > 0) {
                // mise au rebut d'une inscription enregistrée
                ceci.find('.listeBenevoles button.me').removeClass('btn-danger').addClass('btn-primary');
                ceci.find('.listeBenevoles button.me').find('.disk').last().prop('hidden', false);
            }
            else {
                // simple suppression d'une inscription pas encore enregistrée
                $('td[data-date="' + date + '"][data-periode="' + periode + '"] button.candidat[data-acronyme="' + acronyme + '"]').remove();
                }
        })
    }

})

$('body').on('click', '#btn-saveCalendar', function(){
    var month = $('#month').val();
    var year = $('#year').val();
    var formulaire = $('#formInscription').serialize();
    var title = 'Enregistrement des permanences';

    $.post('inc/testSession.inc.php', {},
        function(resultat){
        if (resultat == '') {
            alert('Votre session est s\'est achevée. Veuillez vous reconnecter.');
            window.location.replace('accueil.php');
            }
        })

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

    bootbox.confirm({
        title: title,
        message: 'Veuillez confirmer la recopie de <strong>vos inscriptions</strong> sur chaque <strong>' + jourFR + '</strong> du mois',
        callback: function(result){
            if (result == true) {
                // vérifier que la session est encore active
                $.post('inc/testSession.inc.php', {},
                    function(resultat){
                    if (resultat == '') {
                        alert('Votre session est s\'est achevée. Veuillez vous reconnecter.');
                        window.location.replace('accueil.php');
                        }
                    })

                var bouton = $('#bouton').html();

                var n = 0;
                // recopier le modèle de journée dans les jours semaine suivants
                $('input:checkbox[data-dayofweek="' + jour + '"]').each(function(i){
                    // à quelle période de la journée sommes-nous?
                    var periode = $(this).data('periode');
                    // parmi les checkboxes du même jour que l'originale,
                    // attribuer la valeur trouvée dans le modèle pour cette période si pas déjà checked
                    if (($(this).prop('checked') == false) && (modeleJour[periode] == 1)) {
                        $(this).prop('checked', true);
                        // ajouter le bouton à la fin de la liste des bénévoles
                        $(this).closest('td').find('.listeBenevoles').append(bouton);
                        
                        $(this).closest('td').find('.btn-inscription .visible').toggle()

                        // $(this).closest('td').find('.listeBenevoles button').find('.disk').last().prop('hidden', false);
                        n++;
                        }
                })

                bootbox.alert({
                    title: title,
                    message: '<strong>' + n + '</strong> recopie(s) sur chaque <strong>' + jourFR + '</strong>' + message
                    })
            }
        }
    })
})

