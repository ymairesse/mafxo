<div style="padding-bottom: 60px"></div>

<div class="hidden-print navbar-xs navbar-default navbar-fixed-bottom" style="padding-top:10px">
	<span class="hidden-xs">
		Le {$smarty.now|date_format:"%A, %e %b %Y"} à {$smarty.now|date_format:"%Hh%M"}
		Adresse IP: <strong>{$netId.ip}</strong> {$netId.hostname}
		Votre passage est enregistré
			
	</span>

	<span class="visible-xs">
		{$netId.ip} {$netId.hostname} {$smarty.now|date_format:"%A, %e %b %Y"} {$smarty.now|date_format:"%Hh%M"}
	</span>

</div>  <!-- navbar -->
