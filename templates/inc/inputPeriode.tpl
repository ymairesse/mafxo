
<div class="col-xs-12 col-sm-6">
  
  <input type="hidden" name="id[]" value="{$periode.id|default:''}">

  <div class="form-group">
    <label for="periode">Début de la période</label>
    <input type="text" class="form-control" name="debut[]" maxlength="5" value="{$periode.debut|default:''}">
  </div>

</div>


<div class="col-xs-12 col-sm-6">

  <div class="form-group">
    <label for="periode">Fin de la période</label>
    <input type="text" class="form-control" name="fin[]" maxlength="5" value="{$periode.fin|default:''}">
  </div>

</div>