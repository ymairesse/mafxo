$('body').on('click', '#addDateConge', function(){
    var trLast = $('#tableFeries tbody tr:last');
    trNew = trLast.clone();
    trLast.after(trNew);
    trNew.find('input:text').val('');
    trNew.find('input:checkbox').prop('checked', false);
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
    $('input:text').each(function () {
        // Check if the element is empty
        if ($(this).val() == '')
            $(this).css('background-color', '#f99').prop('placeholder', 'La date manque');
    })
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