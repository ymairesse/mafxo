<div style="max-height:45em; overflow: auto" class="row">

    <div class="panel panel-default">

        <div class="panel-heading">

        <h4>Liste des Bénévoles</h4>

        </div>

        <div class="panel-body">

        <ul class="list-unstyled" id='usersList'>
            {foreach from=$usersList key=acronyme item=data}
                <li>
                    <div class="btn-group btn-group-justified">
                        <a href="#" class="btn btn-warning btn-editProfile {if $data.statut == 'admin'}btn-primary{else}btn-warning{/if}" 
                            data-toggle="tooltip" 
                            data-container="body"
                            data-placement="left"
                            style="width:20%;" title="Modifier le profil">
                            <i class="fa fa-user"></i>
                        </a>

                        <a href="#"class="btn btn-success btn-block btn-user"
                            data-statut="{$data.statut}"
                            data-acronyme="{$data.acronyme}"
                            style="width:80%">
                            {$data.nom} {$data.prenom}
                        </a>

                    </div>
                </li>
            {/foreach}
        </ul>

        </div>

    </div>

</div>

<script>

    $(document).ready(function(){
    
        $('body').on('click', '.btn-user', function(){
            $('.btn-user').removeClass('selected');
            $(this).addClass('selected');
        })


        $('body').on('click', '#formGestion .btn-inscription', function(){
            alert('test');
        })

    })


</script>