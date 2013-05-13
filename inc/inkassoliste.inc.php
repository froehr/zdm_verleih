<?php

$heute = date("d.m.Y", time());

$tpl = tpl_replace_once("anfangsdatum", $heute);

$datum = "";
$kennung = "";
$betrag = "";
$posten = "";
$pfand = "";
$eingetragenvon = "";
$mahnung = "";
$zahl = "1";
$antwort = "";

if (isset($_POST["posten"])){
	$posten = htmlentities(mysql_real_escape_string($_POST["posten"]));
}
	
if (isset($_POST["pfand"])){
	$pfand = htmlentities(mysql_real_escape_string($_POST["pfand"]));
}
	
if (isset($_POST["eingetragenvon"])){
	$eingetragenvon = htmlentities(mysql_real_escape_string($_POST["eingetragenvon"]));
}
	
if (isset($_POST["mahnung"])){
	$mahnung = htmlentities(mysql_real_escape_string($_POST["mahnung"]));
}

if (isset($_POST["kennung"])){
	$datum = htmlentities(mysql_real_escape_string($_POST["datum"]));
	$kennung = htmlentities(mysql_real_escape_string($_POST["kennung"]));
	$betrag = htmlentities(mysql_real_escape_string($_POST["betrag"]));
	$betrag = str_replace ( "," , "." , $betrag);
	$datum = date("Y-m-d", strtotime($datum));
	
query("INSERT INTO `inkassoliste`(`datum`, `nutzerkennung`, `betrag`, `posten`, `pfand`, `eingetragenvon`, `mahnungen`)
						VALUES ('".$datum."','".$kennung."','".$betrag."','".$posten."','".$pfand."','".$eingetragenvon."','".$zahl."')");

if(mysql_affected_rows() != 0){
	
	$antwort =  '<script>
					alertify.success("Eintrag best&auml;tigt!")
				</script>';
}
else{
	$antwort =  '<script>
					alertify.error("Eintrag nicht eingef&uuml;gt!")
				</script>';}

}




//Tabelle nicht bezahlt füllen
$datum1= "";
$kennung1= "";
$betrag1= "";
$posten1= "";
$pfand1= "";
$eingetragenvon1= "";
$mahnungen1= "";

//MySQL abfrgaen aufgeteilt nach Überzogen, etc.
$nichtbezahlt = query("SELECT * FROM `inkassoliste` WHERE `bezahlt` = '0' ORDER BY `datum` DESC");

echo mysql_error();
//Tabelle mit Daten für alt füllen
if (mysql_num_rows($nichtbezahlt) != 0) {
		while ($row = mysql_fetch_object($nichtbezahlt)) {
			$tpl = copy_code("nichtbezahlt");

			$tpl = tpl_replace_once("datum1", date("d.m.Y", strtotime($row->datum)));	
			$tpl = tpl_replace_once("kennung1", $row->nutzerkennung);
			$tpl = tpl_replace_once("betrag1", $row->betrag."&euro;");
			$tpl = tpl_replace_once("posten1", $row->posten);
			$tpl = tpl_replace_once("pfand1", $row->pfand);
			$tpl = tpl_replace_once("eingetragenvon1", $row->eingetragenvon);
			$tpl = tpl_replace_once("mahnungen1", $row->mahnungen);
			$tpl = tpl_replace_once("aktion1", '<img src="img/bezahlt.png" alt="rueckgabe" onClick=
			
			\'alertify.confirm("Als bezahlt markieren?",function (e){
						if(e){
							var http = new XMLHttpRequest();
							http.open("POST", "inc/inkassoliste_helper.inc.php", false);
							http.setRequestHeader(
      							"Content-Type",
    							"application/x-www-form-urlencoded");
							http.send("inkasso_id='.$row->inkasso_id.'&rueckgabe=1");
							var help;
							help = http.responseText;
    						if(help == 1){
    							alertify.success("Als bezahlt markiert!");
    						}
    						else{
    							alertify.error("Konnte nicht als bezahlt markiert werden!");
    						}
   						} 
   						else {
   						 	alertify.error("Bezahlen wurde vom Benutzer abgebrochen!");
   					 	}
					});\'>
			
					<a href="mailto:'.$row->nutzerkennung.'@uni-muenster.de?cc=zdm@uni-muenster.de&bcc=&subject=&Uuml;berzogene Ausleihe&body=Hallo,%0D%0D
						du hast heute im ZDM deine Drucksachen nicht bezahlt. Begleiche deinen R&uuml;ckstand 
						bitte m&ouml;glichst schnell.%0D%0D Solltest du kein Pfand hinterlegt haben, werden 0,50&euro; Mahngeb&uuml;hr f&auml;llig!%0DZu zahlen dann mit Mensakarte.  %0D%0DGru&szlig;, %0D ZDM 
						Geowissenschaften"><img src="img/email.png" alt="mahnung"></a>
					');
			
		}
	}
$tpl = clean_code("nichtbezahlt");

//Tabelle für bezahlt füllen:

//Tabelle nicht bezahlt füllen
$datum2= "";
$kennung2= "";
$betrag2= "";
$posten2= "";
$pfand2= "";
$eingetragenvon2= "";
$mahnungen2= "";

//MySQL abfrgaen aufgeteilt nach Überzogen, etc.
$bezahlt = query("SELECT * FROM `inkassoliste` WHERE `bezahlt` != '0' ORDER BY `datum` DESC");

echo mysql_error();
//Tabelle mit Daten für alt füllen
if (mysql_num_rows($bezahlt) != 0) {
		while ($row = mysql_fetch_object($bezahlt)) {
			$tpl = copy_code("bezahlt");

			$tpl = tpl_replace_once("datum2", date("d.m.Y", strtotime($row->datum)));	
			$tpl = tpl_replace_once("kennung2", $row->nutzerkennung);
			$tpl = tpl_replace_once("betrag2", $row->betrag."&euro;");
			$tpl = tpl_replace_once("posten2", $row->posten);
			$tpl = tpl_replace_once("pfand2", $row->pfand);
			$tpl = tpl_replace_once("eingetragenvon2", $row->eingetragenvon);
			$tpl = tpl_replace_once("mahnungen2", $row->mahnungen);
			
		}
	}
$tpl = clean_code("bezahlt");

$tpl = tpl_replace("antwort", $antwort);
?>