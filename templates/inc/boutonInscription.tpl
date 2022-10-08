<button type="button" 
    class="btn btn-pink candidat btn-block"
    data-acronyme="{$identite.acronyme}"
    data-toggle="tooltip"
    title="N'oubliez pas d'enregistrer">
    <span class="visible-xs hidden-md hidden-lg">{$identite.acronyme} <span class="disk hidden">(<i class="fa fa-floppy-o"></i>)</span></span>
    <span class="visible-sm visible-md visible-lg">{$identite.prenom} {$identite.nom} <span class="disk hidden">(<i class="fa fa-floppy-o"></i>)</span></span>
</button>

<script>

    $(document).ready(function(){
    
    $('[data-toggle="tooltip"]').tooltip();
    
    })


</script>