$('body').on('click', '.btn-editProfile', function(){
    testSession();
    var acronyme = $(this).data('acronyme');
    $('.btn-editProfile').removeClass('selected');
    $(this).addClass('selected');

    $.post('inc/editProfilAdmin.inc.php', {
        acronyme: acronyme
    }, function(resultat){
        $('#modal').html(resultat);
        $('#modalProfilAdmin').modal('show');
    })
})

$('body').on('click', '#btn-saveProfilAdmin', function(){
    testSession();
    var formulaire = $('#formEditionProfil').serialize();
    $.post('inc/saveEditedUser.inc.php', {
        formulaire: formulaire
    }, function(resultat){
        bootbox.alert({
            title: 'Enregistrement',
            message: resultat
        });
        $('#modalProfilAdmin').modal('hide');
        var acronyme = $('.btn-editProfile.selected').data('acronyme');
        var ordre = Cookies.get('triUsers');
        $.post('inc/getUser4acronyme.inc.php', {
            acronyme: acronyme,
            ordre: ordre
        }, function(resultat){
            $('.btn-user[data-acronyme="' + acronyme + '"]').text(resultat);
        })

    })
})

// ordre de présentation des bénévoles
$('body').on('click', '#btn-alphaNom', function(){
    var acronyme = $('#usersList a.selected').data('acronyme');
    Cookies.set('triUsers', 'alphaNom', { sameSite: 'strict' });
    $.post('inc/getUsersList.inc.php', {
        triUsers: 'alphaNom'
        }, function(resultat){
            $('#ulList').html(resultat);
            $('#usersList .btn-user[data-acronyme="' + acronyme +'"]').addClass('selected');
        })
})

$('body').on('click', '#btn-alphaPrenom', function(){
    var acronyme = $('#usersList a.selected').data('acronyme');
    Cookies.set('triUsers', 'alphaPrenom', { sameSite: 'strict' });
    $.post('inc/getUsersList.inc.php', {
        triUsers: 'alphaPrenom'
        }, function(resultat){
            $('#ulList').html(resultat);
            $('#usersList .btn-user[data-acronyme="' + acronyme +'"]').addClass('selected');
        })
})

// ------------------------------------------------------------------------------------ 

function resetGestion(){
    // désélection des inscriptions (couleur des boutons)
    $('#calendar-table').find('button.btn-benevole').removeClass('btn-danger').addClass('btn-primary');
    $('#calendar-table').find('button.btn-benevole').removeClass('btn-lightRed toDelete');
    // désélection des checkboxes
    $('#calendar-table').find('input:checkbox').prop('checked', false);
    // suppression du marqueur temporaire "confirme"
    $('#calendar-table').find('button.confirme').removeClass('confirme');
    // bouton "Inscription" et "Désinscription"
    $('#calendar-table').find('.desinscription').addClass('hidden');
    $('#calendar-table').find('.inscription').removeClass('hidden');
    $('#calendar-table .candidat').remove();
}

// clic sur un bouton des users à droite dans la gestion
$('body').on('click', '.btn-user', function(){
    var nbCandidats = $('.listeBenevoles .candidat').length;
    var nbToDelete = $('.listeBenevoles .toDelete').length;
    var total = nbCandidats + nbToDelete;
    
    if (total > 0) {
        bootbox.alert({
            title: 'Attention',
            message: 'Vous avez <strong> '+total+'</strong> modifications non enregistrée(s).<br><strong>Veuillez annuler d\'abord.</strong>.',
        })
    }
    else {
        resetGestion();
    
        $('.btn-user').removeClass('selected');
        // marquer le bouton comme "selected"
        $(this).addClass('selected');
        // rechercher l'acronyme correspondant
        var acronyme = $('#usersList a.selected').data('acronyme');
        // mise en évidence de tous les boutons pour le bénévole ("confirme") et visuellement en "btn-danger"
        $('#calendar-table').find('button[data-acronyme="' + acronyme + '"]').removeClass('btn-primary').addClass('btn-danger confirme');
        $('#calendar-table').find('button[data-acronyme="' + acronyme + '"]').closest('td').find('input:checkbox').prop('checked', true);
        $('#calendar-table').find('button[data-acronyme="' + acronyme + '"]').closest('td').find('.desinscription').removeClass('hidden');
        $('#calendar-table').find('button[data-acronyme="' + acronyme + '"]').closest('td').find('span.inscription').addClass('hidden');
    }
})

$('body').on('click', '#resetGestion', function(){
    testSession();
    var nbCandidats = $('.listeBenevoles .candidat').length;
    var nbToDelete = $('.listeBenevoles .toDelete').length;
    var total = nbCandidats + nbToDelete;
    if (total > 0)
        bootbox.confirm({
            title: 'Attention',
            message: 'Veuillez confirmer l\'abandon de <strong>'+total+'</strong> modification(s) non confirmées',
            callback: function(result){
                if (result == true){
                    var year = $('#year').val();
                    var month = $('#month').val();
                    var acronyme = $('#usersList a.selected').data('acronyme');
                    $.post('inc/getGestion.inc.php', {
                        year: year,
                        month: month,
                        acronyme: acronyme
                    }, function(resultat){
                        $('#formGestion').html(resultat);
                        $('#usersList a.selected').trigger('click');
                    })
                }
            }
        })
})


$('body').on('click', '#formGestion .btn-inscription', function(){

    testSession();

    var acronyme = $('#usersList a.selected').data('acronyme');
    if (acronyme == undefined){
        bootbox.alert({
            title: 'Erreur', 
            message: 'Veuillez sélectionner un·e bénévole dans la liste à droite ou sous cette grille'
            });
        return;
    }
        
    var date = $(this).data('date');
    var periode = $(this).data('periode');
    var cellule = $('#calendar-table td[data-date="'+date+'"][data-periode="'+periode+'"]');

    // existe-t-il une inscription confirmée dans la base de données
    var BDconfirmed = $('#calendar-table td[data-date="'+date+'"][data-periode="'+periode+'"]').find('button.confirme').length > 0;

    if (BDconfirmed) {
        var checked = $('#calendar-table td[data-date="'+date+'"][data-periode="'+periode+'"]').find('input:checkbox').is(':checked')
        // la checkbox est cochée, c'était une inscription ferme
        if (checked == true) {
            // on décoche la case
            cellule.find('input:checkbox').prop('checked', false);
            // le bouton qui était en couleur btn-danger passe en btn-lightRed avec le flag "toDelete"
            cellule.find('button.confirme').removeClass('btn-danger').addClass('btn-lightRed toDelete');
            // l'icône de la disquette est montré
            cellule.find('button.confirme').find('.disk').last().prop('hidden', false);
            // on arrange les boutons Inscription/désinscription comme il faut
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.desinscription').addClass('hidden');
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.inscription').removeClass('hidden')
        }
        else {
            // c'était une hésitation sur la suppression, on revient en arrière
            // la case est re-cochée
            cellule.find('input:checkbox').prop('checked', true);
            // le bouton est remis en couleur btn-danger et le drapeau "toDelete" est supprimé
            cellule.find('button.confirme').removeClass('btn-lightRed toDelete').addClass('btn-danger');
            // on cache l'icône de la disquette
            cellule.find('button.confirme').find('.disk').last().prop('hidden', true);
            // on arrange les boutons Inscription/désinscription comme il faut
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.desinscription').removeClass('hidden');
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.inscription').addClass('hidden')
        }
    }
    else {
        // Y a-t-il déjà un bouton mauve ("candidat") dans cette case?
        var candidat = cellule.find('button.candidat').length > 0;

        if (candidat == true) {
            // alors, c'est une suppression du "candidat"
            cellule.find('button.candidat').remove();
            cellule.find('input:checkbox').prop('checked', false);
            // on arrange comme il faut le bouton d'inscription
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.desinscription').addClass('hidden');
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.inscription').removeClass('hidden')
        }
        else {
            // on prépare un nouveau bouton pour cette permanence
            var leBouton = $('#bouton button').clone();
            var nom = $('#usersList a.selected').data('nom').trim();
            var prenom = $('#usersList a.selected').data('prenom').trim();
            // on indique nom et prenom
            leBouton.find('span.nom').text(nom);
            leBouton.find('span.prenom').text(prenom);
            cellule.find('.listeBenevoles').append(leBouton);
            cellule.find('input:checkbox').prop('checked', true);
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.desinscription').removeClass('hidden');
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.inscription').addClass('hidden')
        }
    }

})

$('body').on('click', '#btn-saveGestion', function(){
    var month = $('#month').val();
    var year = $('#year').val();
    var acronyme = $('#usersList a.selected').data('acronyme');
    var formulaire = $('#formGestion').serialize();

    var title = 'Enregistrement des permanences';

    testSession();

    $.post('inc/warningModifGestion.inc.php', {
        month: month,
        year: year,
        acronyme: acronyme,
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
                        $.post('inc/saveGestion.inc.php', {
                            month: month,
                            year: year,
                            acronyme: acronyme,
                            formulaire: formulaire
                        }, function(){
                            $.post('inc/getGestion.inc.php', {
                                year: year,
                                month: month,
                                acronyme: acronyme
                                }, function(resultat) {
                            $('#formGestion').html(resultat);
                            $('#usersList a.selected').trigger('click');
                            });
                        })
                    }
                }
            
            })

            }
        )
    })

    $('body').on('click', '#btn-prevGestMonth', function(){
        testSession();
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
                var acronyme = $('#usersList a.selected').data('acronyme');
                if (month == 1) {
                    month = 12;
                    year = year-1
                    }
                    else month = month-1;
                $('#year').val(year);
                $('#month').val(month);
        
                $.post('inc/getGestion.inc.php', {
                    month: month,
                    year: year
                }, function(resultat) {
                    $('#formGestion').html(resultat);
                    $('#usersList a.selected').trigger('click');
                })
            }
    })

    $('body').on('click', '#btn-nextGestMonth', function(){
        testSession();
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
        var acronyme = $('#usersList a.selected').data('acronyme');
        if (month == 12) {
            month = 1;
            year = year+1
            }
            else month = month+1;
        $('#year').val(year);
        $('#month').val(month);

        $.post('inc/getGestion.inc.php', {
            month: month,
            year: year
            }, function(resultat) {
                $('#formGestion').html(resultat);
                $('#usersList a.selected').trigger('click');
        })
    }
    })

    $('body').on('click', '#btn-delBenevole', function(){
        var title = 'Effacement du profil'
        bootbox.confirm({
            title: title,
            message: '<span style="font-weight:bold; color: red">Effacement définitif de cette/ce bénévole (irrévocable)</span><br><b>Veuillez confirmer</b>',
            callback: function(result){
                if (result == true){
                    var acronyme = $('#formEditionProfil input#acro').val();
                    $.post('inc/delProfile.inc.php', {
                        pseudo: acronyme
                    }, function(resultatJSON){
                        resultat = JSON.parse(resultatJSON);
                        bootbox.alert({
                            title: title,
                            message: resultat['message']
                        });
                        if (resultat['ok'] == true) {
                            $('#modalProfilAdmin').modal('hide');
                            $('.btn[data-acronyme="' + acronyme + '"]').remove();
                        }
                    })
                }
            }
        })
    })

    $('body').on('click', '#btn-freeze', function(){
        $.post('inc/getFreezing.inc.php', {},
            function(resultat){
                $('#modal').html(resultat);
                $('#modalFreezing').modal('show');
            })
    })

    $('body').on('click', '#btn-modalFreeze', function(){
        var formulaire = $('#formFreeze').serialize();
        $.post('inc/saveFreezing.inc.php', {
            formulaire: formulaire
            }, function(resultat){
                bootbox.alert({
                    title: 'Enregistrement des blocages d\'inscriptions',
                    message: resultat
                });
                $('#modalFreezing').modal('hide');
            })
    })

    $('body').on('click', '.btn-confirm', function(){
        testSession();
        var nombre = $(this).data('nombre');
        var periodes = $(this).closest('tr').find('td.case');
        periodes.each(function(i){
            var listeBenevoles = $(this).find('.btn-benevole');
            // on considère la liste des bénévoles de la période
            // on les compte sur le paramètre "x"
            listeBenevoles.each(function(x){
                // on ne dépasse pas le nombre d'inscriptions automatiques demandé
                if (x < nombre){
                    // $(this) est le xième élément des la liste des bénévoles
                    var ceci = $(this);
                    var acronyme = $(this).data('acronyme');
                    var periode = $(this).closest('td').data('periode');
                    var date = $(this).closest('td').data('date');
                    $.post('inc/confirmePermanence.inc.php', {
                        acronyme: acronyme,
                        date: date,
                        periode: periode
                    }, function(resultat){
                        var leBouton = ceci.closest('.doubleBtn').find('.btn-benevole');
                        if (resultat == 1) {
                            leBouton.addClass('confirmed');
                            leBouton.find('.check').html('<i class="fa fa-check"></i>').show();
                        }
                        else {
                            leBouton.removeClass('confirmed');
                            leBouton.find('.check').hide()
                        }
                    })
                }
            })
        })
    })

    $('body').on('click', '.btn-confirmePermanence', function(){
        var ceci = $(this);
        var date = ceci.closest('td').data('date');
        var periode = ceci.closest('td').data('periode');
        var acronyme = ceci.data('acronyme');
        $.post('inc/confirmePermanence.inc.php', {
            acronyme: acronyme,
            date: date,
            periode: periode
        }, function(resultat){
            var leBouton = ceci.closest('.doubleBtn').find('.btn-benevole');
            if (resultat == 1) {
                leBouton.addClass('confirmed');
                leBouton.find('.check').html('<i class="fa fa-check"></i>').show();
            }
            else {
                leBouton.removeClass('confirmed');
                leBouton.find('.check').hide()
            }
        })
        

    })