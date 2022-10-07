<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Oxfam: Gestion des bénévoles</title>

<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" type="text/css" media="screen">
<link rel="stylesheet" href="../bootstrap/fa/css/font-awesome.min.css" type="text/css" media="screen, print">

<link rel="stylesheet" href="../js/bootstrapDatepicker/css/datepicker3.css" media="all">
<link rel="stylesheet" href="../js/font-awesome-animation.css" type="text/css" media="screen">
<link rel="stylesheet" href="../css/animate/animate.min.css" type="text/css" media="screen">

<link rel="stylesheet" href="../css/print.css" type="text/css" media="print">
<link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen">

<link rel="stylesheet" href="../css/buttons.css" type="text/css" media="screen, print">

<script src="../js/jquery-2.1.3.min.js"></script>

<script src="../js/jquery.validate.js"></script>

<script src="../js/bootbox/bootbox.min.js"></script>

<script src="../js/jsCookie/src/js.cookie.js"></script>

<script>
bootbox.setDefaults({
  locale: "fr",
  backdrop: false
});
</script>

</head>

<body>

<h1>{$titre}</h1>

<div id="corpsPage">
	{if isset($corpsPage)}
		{include file="$corpsPage.tpl"}
	{/if}
</div>

</body>