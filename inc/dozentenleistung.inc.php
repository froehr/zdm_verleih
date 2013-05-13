<?php

$today = date("d.m.Y", time());


$dozent = query("SELECT * FROM `dozent` ORDER BY `dozent_name` ASC");

if (mysql_num_rows($dozent) != 0) {
		while ($row = mysql_fetch_object($dozent)) {
			$tpl = copy_code("dozent");
                        $tpl = tpl_replace_once("dozentname", $row->dozent_name);
			
			$tpl = copy_code("option");
                        $tpl = tpl_replace_once("dozentoption", $row->dozent_name);
		}
}

$tpl = clean_code("dozent");
		
		$tpl = tpl_replace("anfangsdatum", $today);

?>