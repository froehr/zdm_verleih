<?php
function read_tpl($filename) {
	if (file_exists('tpl/'.$filename.'.html')) {
		$f = fopen('tpl/'.$filename.'.html', 'r');
		return fread($f, filesize('tpl/'.$filename.'.html'));
	}
	else {
		return fread(fopen('tpl/error.html', 'r'), filesize('tpl/error.html'));
	}
}

function tpl_replace($old, $new) {
	GLOBAL $tpl;
	return str_replace('{'.$old.'}', $new, $tpl);
}
			
function tpl_replace_once($old, $new) {
	GLOBAL $tpl;
	return preg_replace('/\{'.$old.'\}/', $new, $tpl, 1);
}

function copy_code($tag) {
	GLOBAL $tpl;
	preg_match('@\{\+'.$tag.'\}(.*)\{\-'.$tag.'\}@s', $tpl, $subpattern);
	if ( isset($subpattern[1]) && isset($subpattern[0]) ) {
		return preg_replace('@\{\+'.$tag.'\}(.*)\{\-'.$tag.'\}@s', $subpattern[1].$subpattern[0], $tpl);
	}
	else {
		return false;
	}
}

function clean_code($tag) {
	GLOBAL $tpl;
	return preg_replace('@\{\+'.$tag.'\}(.*)\{\-'.$tag.'\}@s', '', $tpl);
}
?>