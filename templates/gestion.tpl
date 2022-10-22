<div class="row">
<div class="col-md-9 col-sm-12">

<div class="clearfix"></div>

<!-- -------------------- Enregistrement et reset -------------------- -->

<div class="btn-group">

    <button type="button" class="btn btn-danger btn-sm" id="btn-saveGestion">
        <i class="fa fa-graduation-cap"></i><span class="hidden-xs"> N'oubliez pas d'Enregistrer</span>
    </button>
    <button type="button" class="btn btn-default btn-sm" id="resetGestion">
        <i class="fa fa-recycle"></i><span class="hidden-xs"> Annuler les modifications</span>
    </button>

</div>

<!-- --------------------------------------------------------------------------------- -->

<!-- bouton modèle pour ajout dans la grille -->
<div id="bouton" hidden>
    <button type="button" 
        class="btn btn-pink candidat btn-block"
        data-acronyme=""
        data-toggle="tooltip"
        title="N'oubliez pas d'enregistrer">
        <span class="visible-xs hidden-md hidden-lg">
            <span class="prenom"></span>
            <span class="disk">(<i class="fa fa-floppy-o"></i>)</span>
        </span>
        <span class="visible-sm visible-md visible-lg">
            <span class="nom"></span> 
            <span class="disk">(<i class="fa fa-floppy-o"></i>)</span>
        </span>
    </button>
</div>

    <div style="max-height:55em; overflow: auto">

        <!------------------------------------------------------------------------------------->

        <form id="formGestion" style="padding: 0 !important">
        
        {include file="inc/tableGestion.tpl"}

        </form>

    <div class="clearfix"></div>
    </div>

    </div>

    <div class="col-md-3 col-sm-12">

        {include file='inc/usersList.tpl'}

    </div>
</div>

<script>

    $(document).ready(function(){

        $('[data-toggle="tooltip"]').tooltip();
    
    })

</script>
