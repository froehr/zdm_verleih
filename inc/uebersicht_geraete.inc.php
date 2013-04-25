  <?php
	$query = query("SELECT * FROM `ausleihobjekt` ORDER BY `geraet_typ`, `geraet_typ_id`");
	if (mysql_num_rows($query) != 0) {
		while ($row = mysql_fetch_object($query)) {
			$tpl = copy_code("geraet");
 			$name = $row->geraet_typ;
			if ($row->geraet_typ_id != 0) {
				$name .= " ".$row->geraet_typ_id;
			}
			$tpl = tpl_replace_once("geraet_name", $row->geraet_typ);
			$tpl = tpl_replace_once("geraet_status", "noch nichts");
		}
	}
	$tpl = clean_code("geraet");
?>