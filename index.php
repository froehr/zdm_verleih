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
	
	// print template (whole contents)
	print $tpl;
?>