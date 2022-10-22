<div style="max-height:45em; overflow: auto" class="row">

    <div class="panel panel-default">

        <div class="panel-heading">

        <h4>Liste des {$usersList|count} bénévoles</h4>

        </div>

        <div class="panel-body">

            <div class="btn-group btn-group-justified">
                <a href="javascript:void(0)" class="btn btn-info" id="btn-alphaNom"><i class="fa fa-sort-alpha-asc"></i> Par nom</a>
                <a href="javascript:void(0)" class="btn btn-warning" id="btn-alphaPrenom"><i class="fa fa-sort-alpha-asc"></i> Par prénom</a>
            </div>

            <div id="ulList">

                {include file="inc/ulUsersList.tpl"}

            </div>

        </div>

    </div>

</div>
