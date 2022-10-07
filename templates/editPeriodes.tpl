<div class="container">

    <h2>Gestion des périodes de permanence</h2>

    <form id="formEditPeriodes">

    {foreach from=$listePeriodes key=id item=periode}
        {include file="inc/inputPeriode.tpl"}
    {/foreach}

    <button type="button" id="btn-savePeriodes" class="btn btn-primary pull-right">Enregistrer</button>
    <button type="reset" class="btn  btn-default pull-right">Annuler</button>

    <div class="clearfix"></div>
    </form>

</div>
