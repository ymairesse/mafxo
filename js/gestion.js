$('body').on('click', '.btn-editProfile', function(){
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
    // $('#calendar-table').find('input:checkbox').prop('checked', false);
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
            message: 'Vous avez <strong> '+total+'</strong> modifications non enregistrées.<br><strong>Veuillez les annuler</strong>.',
        })
    }
    else {
        resetGestion();
    
        $('.btn-user').removeClass('selected');
        $(this).addClass('selected');
    
        var acronyme = $('#usersList a.selected').data('acronyme');
        $('#acronyme').val(acronyme);
    
        $('#calendar-table').find('button[data-acronyme="' + acronyme + '"]').removeClass('btn-primary').addClass('btn-danger confirme');
        
        $('#calendar-table').find('button[data-acronyme="' + acronyme + '"]').closest('td').find('input:checkbox').prop('checked', true);
        $('#calendar-table').find('button[data-acronyme="' + acronyme + '"]').closest('td').find('.desinscription').removeClass('hidden');
        $('#calendar-table').find('button[data-acronyme="' + acronyme + '"]').closest('td').find('span.inscription').addClass('hidden');
    }
})

$('body').on('click', '#resetGestion', function(){
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

    $.post('inc/testSession.inc.php', {},
        function(resultat){
        if (resultat == '') {
            alert('Votre session est s\'est achevée. Veuillez vous reconnecter.');
            window.location.replace('accueil.php');
            }
        })

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
        if (checked == true) {
            cellule.find('input:checkbox').prop('checked', false);
            cellule.find('button.confirme').removeClass('btn-danger').addClass('btn-lightRed toDelete');
            cellule.find('button.confirme').find('.disk').last().prop('hidden', false);
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.desinscription').addClass('hidden');
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.inscription').removeClass('hidden')
        }
        else {
            cellule.find('input:checkbox').prop('checked', true);
            cellule.find('button.confirme').removeClass('btn-lightRed toDelete').addClass('btn-danger');
            cellule.find('button.confirme').find('.disk').last().prop('hidden', true);
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.desinscription').removeClass('hidden');
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.inscription').addClass('hidden')
        }
    }
    else {
        var candidat = cellule.find('button.candidat').length > 0;

        if (candidat == true) {
            cellule.find('button.candidat').remove();
            cellule.find('input:checkbox').prop('checked', false);
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.desinscription').addClass('hidden');
            $('.btn-inscription[data-date="' + date + '"][data-periode="' + periode + '"] span.inscription').removeClass('hidden')
        }
        else {
            var leBouton = $('#bouton button').clone();
            var nom = $('#usersList a.selected').data('nom').trim();
            var prenom = $('#usersList a.selected').data('prenom').trim();
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

    $.post('inc/testSession.inc.php', {},
        function(resultat){
        if (resultat == '') {
            alert('Votre session est s\'est achevée. Veuillez vous reconnecter.');
            window.location.replace('accueil.php');
            }
        })

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

    $('body').on('click', '.btn-confirm', function(){
        var nombre = $(this).data('nombre');
        alert(nombre);
    })