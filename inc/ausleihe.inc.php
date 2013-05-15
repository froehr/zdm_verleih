<?php
//Statusnachrichten
$errormessage ="";
$successmessage ="";
$bestaetigung ="";
$matrikel_nicht="";
$matrikel_da="";
$gefahr="";

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


//Dropdown für den Verleiher füllen	$query = query("SELECT verleiher_vorname FROM `verleiher` ORDER BY `verleiher_vorname`");
	if (mysql_num_rows($query) != 0) {
		while ($row = mysql_fetch_object($query)) {
			$tpl = copy_code("verleiher");
 			$name = $row->verleiher_vorname;
			if ($row->verleiher_vorname != 0) {
				$name .= " ".$row->verleiher_vorname;
			}
			$tpl = tpl_replace_once("verleiher_name", $row->verleiher_vorname);
		}
	}
	$tpl = clean_code("verleiher");


if (isset($_POST["matrikel"])){
	$matrikel = htmlentities(mysql_real_escape_string($_POST["matrikel"]));
	$result = query("select * from ausleiher where matrikel =".$matrikel);
	
	//Prüfen ob Matrikel schon vorhanden ist oder ob ein neuer Datensatz angelegt werden muss
	if (mysql_num_rows($result) == 0){
		$matrikel_nicht ='<script>
							matrikel_error();
						  </script>';
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
	
	$matrikel_da ='<script>
			  			matrikel_success();
				   </script>';
	$hidden="hidden";
	
	//Zeigt Meldung an falls schon mehrfach Verspätungen aufgetreten sind
	if ($row->verspaetungen >= 2){
		$gefahr = '<script>
						alertify.error("Achtung diese Person hat schon '.$row->verspaetungen.' Mal das Datum &uuml;berschritten!");
				   </script>';
				
		}
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
	values('".$matrikel2."', '".$nachname."', '".$vorname."', '".$email."', '".$telefon."', '".$plz."', '".$strasse."', '".$hausnummer."')");
	
	//Dropdown für den Verleiher füllen
	$query = query("SELECT verleiher_vorname FROM `verleiher` ORDER BY `verleiher_vorname`");
	if (mysql_num_rows($query) != 0) {
		while ($row = mysql_fetch_object($query)) {
			$tpl = copy_code("verleiher");
 			$name = $row->verleiher_vorname;
			if ($row->verleiher_vorname != 0) {
				$name .= " ".$row->verleiher_vorname;
			}
			$tpl = tpl_replace_once("verleiher_name", $row->verleiher_vorname);
		}
	}
	$tpl = clean_code("verleiher");
	

}
//Im ersten Formular
$tpl =tpl_replace("matrikel_nicht", $matrikel_nicht);
$tpl =tpl_replace("matrikel_da", $matrikel_da);
$tpl =tpl_replace("gefahr", $gefahr);
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

$tpl =tpl_replace("anfangsdatum", date("d.m.Y"));

//Im dritten Formular
$tpl = tpl_replace("matrikelform3", $matrikel2);

$tpl =tpl_replace("successmassage", $successmessage);

?>