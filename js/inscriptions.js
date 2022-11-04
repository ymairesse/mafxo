$('body').on('click', '#btn-prevMonth', function(){
    var nbCandidat = $('.listeBenevoles .candidat').length;
    var nbToDelete = $('.listeBenevoles .toDelete').length;
    var total = nbCandidat + nbToDelete;
    if (total > 0) {
        bootbox.alert({
            title: 'Attention',
            message: 'Vous avez <strong> ' + total + '</strong> modification(s) non enregistrée(s).<br>Veuillez la/les annuler.'
           })
        }
        else {
            var month = parseInt($('#month').val());
            var year = parseInt($('#year').val());
            if (month == 1) {
                month = 12;
                year = year-1
                }
                else month = month-1;
            $('#year').val(year);
            $('#month').val(month);
            Cookies.set('month', month, { sameSite: 'strict' }, { expires: 30 } );
            Cookies.set('year', year, { sameSite: 'strict' }, { expires: 30 } );
            $.post('inc/getCalendar.inc.php', {
                month: month,
                year: year
            }, function(resultat) {
                $('#corpsPage').html(resultat);
                // mise à jour du bouton PDF
                var href = $('#pdf-btn').prop('href');
                var posMonth = href.indexOf('month=') + 6;
                var newhref = href.substr(0, posMonth) + month + '&year=' + year;
                $('#pdf-btn').prop('href', newhref);
            })
        }
})

$('body').on('click', '#btn-nextMonth', function(){
    var nbCandidat = $('.listeBenevoles .candidat').length;
    var nbToDelete = $('.listeBenevoles .toDelete').length;
    var total = nbCandidat + nbToDelete;
    if (total > 0) {
        bootbox.alert({
            title: 'Attention',
            message: 'Vous avez <strong> ' + total + '</strong> modification(s) non enregistrée(s).<br>Veuillez la/les annuler.'
           })
        }
    else {
    var month = parseInt($('#month').val());
    var year = parseInt($('#year').val());
    if (month == 12) {
        month = 1;
        year = year+1
        }
        else month = month+1;
    $('#year').val(year);
    $('#month').val(month);
    Cookies.set('month', month, { sameSite: 'strict' }, { expires: 30 } );
    Cookies.set('year', year, { sameSite: 'strict' }, { expires: 30 } );
    $.post('inc/getCalendar.inc.php', {
        month: month,
        year: year
        }, function(resultat) {
           $('#corpsPage').html(resultat);
            // mise à jour du bouton PDF
            var href = $('#pdf-btn').prop('href');
            var posMonth = href.indexOf('month=') + 6;
            var newhref = href.substr(0, posMonth) + month + '&year=' + year;
            $('#pdf-btn').prop('href', newhref);
        })
    }
})


$('body').on('click', '#formInscription .btn-inscription', function(event){

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
    // isChecked sera à True s'il s'agit d'une désinscription
    var isChecked = checkbox.is(':checked');
    var freezeStatus = $('#freezeStatus').val();

    var title='Clôture des inscriptions';
    if (freezeStatus > 0) 
        message = '<div class="shout">Un administrateur a, partiellement ou totalement, clôturé les inscriptions.<br>';

    if (freezeStatus == 2) {
        bootbox.alert({
            title: title,
            message: message + '<strong>Les INSCRIPTIONS et les DÉSINSCRIPTIONS sont clôturées.</strong></div>'
        });
        return;
    }

    if (!(isChecked) && (freezeStatus == 1)) {
        bootbox.alert({
            title: title,
            message: message + '<strong>Attention, il ne vous sera pas possible de vous DÉSINSCRIRE.</strong></div>'
        })
    }

    if (isChecked && (freezeStatus > 0)) {
        bootbox.alert({
            title: title,
            message: message + '<strong>Les DÉSINSCRIPTIONS ne sont plus possibles. Les INSCRIPTIONS sont encore possibles.</strong></div>  '
        })
        return;
    }
    
    // 
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
            ceci.find('.listeBenevoles button.me').removeClass('btn-primary toDelete').addClass('btn-danger');
            // on supprime l'icône de la disquette
            ceci.find('.listeBenevoles button.me').find('.disk').prop('hidden', true);
            }
            else {
                var bouton = $('#bouton').html(); 
                // ajouter le bouton pour le candidat bénévole à la période
                $('td[data-date="' + date + '"][data-periode="' + periode + '"]').find('.listeBenevoles').append(bouton);
                }
    }
    else {
        $.post('inc/remove-btn-candidat.inc.php', {
            date: date,
            periode: periode
        }, function(acronyme){
            if (ceci.find('.listeBenevoles button.me').length > 0) {
                // mise au rebut d'une inscription enregistrée
                ceci.find('.listeBenevoles button.me').removeClass('btn-danger').addClass('btn-primary toDelete');
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

    $('body').on('click', '#formInscription .btn-sameAsDay', function(){
        var ceci = $(this);
        var freezeStatus = $('#freezeStatus').val();

        var title='Clôture des inscriptions';
        if (freezeStatus > 0) 
            message = '<div class="shout">Un administrateur a, partiellement ou totalement, clôturé les inscriptions.<br>';

        if (freezeStatus == 2) {
            bootbox.alert({
                title: title,
                message: message + '<strong>Les INSCRIPTIONS et les DÉSINSCRIPTIONS sont clôturées.</strong></div>'
            });
            return;
        }

        if (freezeStatus == 1) {
            // s'il y a quelque chose à recopier sur les autres jours
            if (ceci.closest('tr').find('input:checkbox').is(':checked'))
                bootbox.alert({
                    title: title,
                    message: message + '<strong>Attention, il ne vous sera pas possible de vous DÉSINSCRIRE.</strong></div>'
                });
                else return;
        }

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

