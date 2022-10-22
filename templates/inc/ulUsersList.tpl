<ul class="list-unstyled" id="usersList">
    {foreach from=$usersList key=acronyme item=data}
        <li>
            <div class="btn-group btn-group-justified">
                <a href="#" class="btn btn-warning btn-editProfile" 
                    data-toggle="tooltip" 
                    data-container="body"
                    data-placement="left"
                    data-acronyme="{$data.acronyme}"
                    style="width:20%;" 
                    title="Modifier le profil">
                    <i class="fa fa-user"></i>
                </a>

                <a href="#"class="btn btn-success btn-block btn-user"
                    data-statut="{$data.statut}"
                    data-acronyme="{$data.acronyme}"
                    data-nom="{$data.prenom} {$data.nom}"
                    data-prenom="{$data.prenom}"
                    style="width:80%">
                    {if $triUsers == 'alphaNom'}
                        <strong>{$data.nom}</strong> {$data.prenom}
                    {else}
                        {$data.prenom} <strong>{$data.nom}</strong>
                    {/if}
                </a>

            </div>
        </li>
    {/foreach}
</ul>