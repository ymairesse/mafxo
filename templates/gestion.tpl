<div class="col-md-10 col-sm-12">

    <div style="text-align: center">
        <h2 id="encadre">
            <button type="button" 
                class="btn btn-primary btn-sm pull-left btn-prevGestMonth" 
                title="Mois précédent">
                <i class="fa fa-arrow-left"></i>
                <span class="hidden-xs hidden-sm"> Mois précédent</span>
            </button> 
            {$monthName} <span class="hidden-xs">{$year}</span>
            <button type="button" 
                class="btn btn-primary btn-sm pull-right btn-nextGestMonth"
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
        <span class="visible-xs hidden-md hidden-lg">{$identite.acronyme} <span class="disk">(<i class="fa fa-floppy-o"></i>)</span></span>
        <span class="visible-sm visible-md visible-lg">{$identite.prenom} {$identite.nom} <span class="disk">(<i class="fa fa-floppy-o"></i>)</span></span>
    </button>
</div>

    <div style="max-height:55em; overflow: auto">

        <!------------------------------------------------------------------------------------->

        <form id="formGestion" style="padding: 0 !important">
        
        {include file="inc/tableCalendar.tpl"}

        </form>
    <div class="clearfix"></div>
    </div>

    </div>

    <div class="col-md-2 col-sm-12">

        {include file='inc/usersList.tpl'}

    </div>


<script>

    $(document).ready(function(){

        var popoverTemplate = ['<div class="timePickerWrapper popover">',
            '<div class="arrow"></div>',
            '<div class="popover-content">',
            '</div>',
            '</div>'].join('');

        var content = ['<div class="timePickerCanvas">asfaf asfsadf</div>',
            '<div>test</div>',
            '<div class="timePickerClock timePickerHours">asdf asdfasf</div>',
            '<div class="timePickerClock timePickerMinutes"> asfa </div>', ].join('');
    
        $('[data-toggle="popover"]').popover({
                trigger: 'click',
                content: 'bisou',
                placement: "top",
                html: true
            });
        

        $('[data-toggle="tooltip"]').tooltip();
    
    })

</script>
