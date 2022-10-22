<div class="row">

	<h1>{$titre}</h1>
	
	<div class="col-xs-12 btn-group">
	<button type="button" class="btn btn-warning btn-sm" name="button" id="btn-calendrier"><i
			class="fa fa-calendar"></i><span class="hidden-xs"> Calendrier</span>
		</button>
	<button type="button" class="btn btn-success btn-sm" name="button" id="btn-profil"><i
			class="fa fa-user"></i><span class="hidden-xs"> Profil et Mot de passe</span>
	</button>

	<button type="button" class="btn btn-danger btn-sm pull-right" name="button" id="btn-logout"><i
			class="fa fa-times"></i><span class="hidden-xs"> Quitter</span>
	</button>
	{if $identite.statut == 'admin'}
		<div class="btn-group pull-right">

		<button type="button" class="btn btn-warning btn-sm" id="btn-gestion">
			<i class="fa fa-calendar-check-o"></i><span class="hidden-xs">Gestion</span>
		</button>

		<button type="button" class="btn btn-info btn-sm" id="btn-conges">
			<i class="fa fa-calendar"></i><span class="hidden-xs"> Congés</span>
		</button>
		<button type="button" class="btn btn-primary btn-sm" name="button" id="btn-periodes">
			<i class="fa fa-hourglass"></i> <span class="hidden-xs">Périodes</span>
		</button>
		</div>
	{/if}



<input type="hidden" name="month" id="month" value="{$month}">
<input type="hidden" name="year" id="year" value="{$year}">

</div>