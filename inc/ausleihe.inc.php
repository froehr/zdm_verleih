<?php
//Statusnachrichten
$errormessage ="";
$successmessage ="";
$bestaetigung ="";
$matrikel_nicht="";
$matrikel_da="";

$hidden="text";

//Infos zur Ausleihe
$verleiher_name="";
$vorname="";
$nachname="";
$email="";
$telefon="";
$strasse="";
$hausnummer="";
$plz="";
$matrikelform2="";
$matrikel2="";
$matrikelform3="";


if (isset($_POST["matrikel"])){
	$matrikel = htmlentities(mysql_real_escape_string($_POST["matrikel"]));
	$result = query("select * from ausleiher where matrikel =".$matrikel);
	
	//Dropdown für den Verleiher füllen
	$query = query("SELECT vorname FROM `verleiher` ORDER BY `vorname`");
	if (mysql_num_rows($query) != 0) {
		while ($row = mysql_fetch_object($query)) {
			$tpl = copy_code("verleiher");
 			$name = $row->vorname;
			if ($row->vorname != 0) {
				$name .= " ".$row->vorname;
			}
			$tpl = tpl_replace_once("verleiher_name", $row->vorname);
		}
	}
	$tpl = clean_code("verleiher");
	
	
	//Prüfen ob Matrikel schon vorhanden ist oder ob ein neuer Datensatz angelegt werden muss
	if (mysql_num_rows($result) == 0){
		$matrikel_nicht ="Matrikel noch nicht in der Datenbank! </br> Bitte Daten unten angeben:";
		$matrikelform=$matrikel;
		
		
		$tpl =tpl_replace("matrikelform2", $matrikel);
	}
	
	else{
	$row = mysql_fetch_object($result);
	$vorname=$row->vorname;
	$nachname=$row->name;
	$email=$row->email;
	$telefon=$row->telefon;
	$strasse=$row->strasse;
	$hausnummer=$row->hausnummer;
	$plz=$row->postleitzahl;
	$tpl =tpl_replace("matrikelform2", $matrikel);
	
	$matrikel_da ="Matrikel bereits bekannt! </br>Daten pr&uuml;fen und &uuml;bernehmen!";
	
	$hidden="hidden";
	}
}

else if (isset($_POST["matrikel2"])){
	$matrikel2 = htmlentities(mysql_real_escape_string($_POST["matrikel2"]));
	$vorname = htmlentities(mysql_real_escape_string($_POST["vorname"]));
	$nachname = htmlentities(mysql_real_escape_string($_POST["nachname"]));
	$email = htmlentities(mysql_real_escape_string($_POST["email"]));
	$telefon = htmlentities(mysql_real_escape_string($_POST["telefon"]));
	$strasse = htmlentities(mysql_real_escape_string($_POST["strasse"]));
	$hausnummer = htmlentities(mysql_real_escape_string($_POST["nummer"]));
	$plz = htmlentities(mysql_real_escape_string($_POST["plz"]));
	$bestaetigung ="Ausleiher best&auml;tigt!";
	
	query(
	"insert into ausleiher(`matrikel`, `name`, `vorname`, `email`, `telefon`, `postleitzahl`, `strasse`, `hausnummer`)
	values('".$matrikel2."', '".$vorname."', '".$nachname."', '".$email."', '".$telefon."', '".$plz."', '".$strasse."', '".$hausnummer."')");
	
	//Dropdown für den Verleiher füllen
	$query = query("SELECT vorname FROM `verleiher` ORDER BY `vorname`");
	if (mysql_num_rows($query) != 0) {
		while ($row = mysql_fetch_object($query)) {
			$tpl = copy_code("verleiher");
 			$name = $row->vorname;
			if ($row->vorname != 0) {
				$name .= " ".$row->vorname;
			}
			$tpl = tpl_replace_once("verleiher_name", $row->vorname);
		}
	}
	$tpl = clean_code("verleiher");
	

}
//Im ersten Formular
$tpl =tpl_replace("matrikel_nicht", $matrikel_nicht);
$tpl =tpl_replace("matrikel_da", $matrikel_da);
$tpl =tpl_replace("hidden", $hidden);


//Im zweiten Formular
$tpl = tpl_replace("vorname", $vorname);
$tpl = tpl_replace("nachname", $nachname);
$tpl = tpl_replace("email", $email);
$tpl = tpl_replace("telefon", $telefon);
$tpl = tpl_replace("strasse", $strasse);
$tpl = tpl_replace("hausnummer", $hausnummer);
$tpl = tpl_replace("matrikelform2", $matrikel2);
$tpl = tpl_replace("plz", $plz);
$tpl =tpl_replace("bestaetigung", $bestaetigung);

//Im dritten Formular
$tpl = tpl_replace("matrikelform3", $matrikel2);

$tpl =tpl_replace("successmassage", $successmessage);

?>