<?php

include("config.inc.php");
include("database.inc.php");
include("functions_general.inc.php");

$heute = date("Y-m-d", time());

if ( isset($_POST["rueckgabe"]) ) {
$ausleihe = $_POST["ausleih_id"];
query("UPDATE `ausleihe` SET `abgeschlossen`='".$heute."' WHERE `ausleih_id` ='".$ausleihe."'");
if(mysql_affected_rows() == 1){
	echo 1;
	}
		
	else{
	echo 0;
	}
}

if ( isset($_POST["verlaengert"]) ) {
$ausleihe = $_POST["ausleih_id"];
$bis = htmlentities(mysql_real_escape_string($_POST["bis"]));
query("UPDATE `ausleihe` SET `bis`='".$bis."',`verlaengert`=`verlaengert` + 1  WHERE `ausleih_id` ='".$ausleihe."'");

if(mysql_affected_rows() == 1){
	echo $bis;
	}
		
	else{
	echo $bis;
	}
}

?>