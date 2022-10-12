<!-- -------------------- Navigation temporelle -------------------- -->

<div style="text-align: center">
    <h2 id="encadre">
        <button type="button" 
            class="btn btn-primary btn-sm pull-left btn-prevMonth" 
            title="Mois précédent">
            <i class="fa fa-arrow-left"></i>
            <span class="hidden-xs hidden-sm"> Mois précédent</span>
        </button> 
        {$monthName} <span class="hidden-xs">{$year}</span>
        <button type="button" 
            class="btn btn-primary btn-sm pull-right btn-nextMonth"
            title="Mois suivant">
            <span class="hidden-sm hidden-xs">Mois suivant </span>
            <i class="fa fa-arrow-right"></i>
        </button> 
    </h2>
</div>

<!-- --------------------------------------------------------------------------------- -->

<div class="clearfix"></div>

<!-- -------------------- Enregistrement et reset -------------------- -->

<div class="btn-group">

    <button type="button" class="btn btn-danger btn-sm" id="btn-saveCalendar">
        <i class="fa fa-floppy-o"></i><span class="hidden-xs"> N'oubliez pas d'Enregistrer</span>
    </button>
    <button type="button" class="btn btn-default btn-sm" id="reset">
        <i class="fa fa-recycle"></i><span class="hidden-xs"> Annuler les modifications</span>
    </button>

</div>
<!-- --------------------------------------------------------------------------------- -->

<!-- bouton modèle pour ajout dans la grille -->
<div id="bouton" hidden>
    <button type="button" 
        class="btn btn-pink candidat btn-block"
        data-acronyme="{$identite.acronyme}"
        data-toggle="tooltip"
        title="N'oubliez pas d'enregistrer">
        <span class="visible-xs hidden-md hidden-lg">{$identite.prenom|truncate:10:"...":true} <span class="disk">(<i class="fa fa-floppy-o"></i>)</span></span>
        <span class="visible-sm visible-md visible-lg">{$identite.prenom} {$identite.nom} <span class="disk">(<i class="fa fa-floppy-o"></i>)</span></span>
    </button>
</div>

<!-- ---------------- Grille et formulaire d'inscription ---------------- -->

<div style="max-height:55em; overflow: auto">

    <form id="formInscription" style="padding: 0 !important">
    
        {include file="inc/tableCalendar.tpl"}

    </form>

</div>

<!-- --------------------------------------------------------------------------------- -->

<script>

    $(document).ready(function(){

    $('[data-toggle="popover"]').on('click',function(e){
        e.preventDefault();
    }).popover();

    $('[data-toggle="tooltip"]').tooltip();
    
    })

    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

</script>
