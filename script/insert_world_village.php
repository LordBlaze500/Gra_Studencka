<?php
include "db_connect.php";

$X = $_GET['X'];
$Y = $_GET['Y'];

$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);

while (!$X || !$Y)
{
	$X = rand(45,55);
	$Y = rand(45,55);
	$SQL_String = "SELECT * FROM gs_campuses WHERE x_coord=$X AND y_coord=$Y";
	$Query = $Connect->Query($SQL_String);
	$Record = $Query->fetch_assoc();
	if ($Record)
	{
		$X = NULL;
		$Y = NULL;
	}
}

$SQL_String = "INSERT INTO gs_campuses (x_coord, y_coord, id_owner, amount_vodka, amount_kebab, 
	          amount_wifi, dormitory, transit, college, liquirstore, cafe, terminus, parking, bench, distillery,
	          doner, wifispot, name, points, obedience, traders) VALUES ($X, $Y, 0, 1000, 1000, 1000, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3, 3,'Wolny kampus'
	          ,1,100,10)";
$Query = $Connect->Query($SQL_String);
$SQL_String = "SELECT id_campus FROM gs_campuses WHERE x_coord=$X AND y_coord=$Y";
$Query = $Connect->Query($SQL_String);
$Record = $Query->fetch_assoc();
$ID_Campus = $Record['id_campus'];
$SQL_String = "INSERT INTO gs_armies (id_homecampus, id_stayingcampus, student, parachute, nerd, stooley, drunkard, clochard, master, doctor,
	inspector, veteran) VALUES ($ID_Campus, $ID_Campus, 0,0,0,0,0,0,0,0,0,0)";
$Query = $Connect->Query($SQL_String);
?>
