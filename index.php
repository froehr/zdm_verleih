<?php
	include("inc/config.inc.php");
	include("inc/database.inc.php");
	include("inc/functions_general.inc.php");
	
	//load main template file
	$tpl = read_tpl('main');

	// get current site and set content template
	if ( isset($_GET['page']) ) {
		$page = mysql_real_escape_string($_GET['page']);
		$content_tpl = $page;
	}
	else {
		$page = '';
		$content_tpl = 'start';
	}

	// replace content placeholder with content template file
	$tpl = tpl_replace('content', read_tpl($content_tpl));
	
	// handle different pages
	switch($page) {
		case"neues_geraet":
			include("inc/neues_geraet.inc.php");
		break;
		case"uebersicht_geraete":
			include("inc/uebersicht_geraete.inc.php");
		break;
		case"ausleihe":
			include("inc/ausleihe.inc.php");
		break;
		case"verleiher_loeschen":
			include("inc/verleiher_loeschen.inc.php");
		break;
		case"verleiher_anlegen":
			include("inc/verleiher_anlegen.inc.php");
		break;
		case"ausleihe_mitarbeiter":
			include("inc/ausleihe_mitarbeiter.inc.php");
		break;
		case"ueberzogen":
			include("inc/ueberzogen.inc.php");
		break;
		case"historisch":
			include("inc/historisch.inc.php");
		break;
		case"geraete_uebersicht":
			include("inc/geraete_uebersicht.inc.php");
	}
	
	// remove special characters
	$tpl = str_replace(array("Ä","Ö","Ü","ä","ö","ü","ß"), array("&Auml;","&Ouml;","&Uuml;","&auml;","&ouml;","&uuml;","&szlig;"), $tpl);
	
	// print template (whole contents)
	print $tpl;
?>