<?php
include "db_connect.php";
include "points.php";
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
Calculate_Points($Connect);
Calculate_User_Points($Connect);
Calculate_Ranking($Connect);

$SQL_String = "DELETE FROM gs_raports WHERE id_addressee=0";
$Query = $Connect->Query($SQL_String);

$Current_Time = new DateTime();

$SQL_String = "SELECT last_invoke FROM gs_interval_regulator WHERE id_reg=1";
$Query = $Connect->Query($SQL_String);
$Record = $Query->fetch_assoc();

$Current_Date = new DateTime();
$Last_Date = DateTime::createFromFormat('Y-m-d H:i:s', $Record['last_invoke']); 

if ($Current_Date < $Last_Date)
{
   $Connect->close();
   exit();
}

$Current_Date->add(new DateInterval('PT'.'45'.'M'));
$Date_String = $Current_Time->format('Y-m-d H:i:s');
$SQL_String = "UPDATE gs_interval_regulator SET last_invoke='$Date_String'";
echo $SQL_String;
$Query = $Connect->Query($SQL_String);

$SQL_String = "SELECT id_campus, amount_kebab, amount_wifi, amount_vodka, distillery, doner, wifispot, obedience FROM gs_campuses ORDER BY id_campus DESC";
$Query = $Connect->Query($SQL_String);
while ($Record = $Query->fetch_assoc())
{
   $ID_Campus = $Record["id_campus"];
   if ($Record['obedience'] < 100)
   {
      $New_Obedience = $Record['obedience'] + 1;
      $SQL_String_2 = "UPDATE gs_campuses SET obedience=$New_Obedience WHERE id_campus=$ID_Campus";
      $Query_2 = $Connect->Query($SQL_String_2);
   }
   $Distillery = $Record["distillery"];
   $Doner = $Record["doner"];
   $Wifispot = $Record["wifispot"];
   $SQL_String_2 = "SELECT income FROM gs_mines_costs WHERE name='distillery' AND level=$Distillery";
   $Query_2 = $Connect->query($SQL_String_2);
   $Record_2 = $Query_2->fetch_assoc();
   $Vodka_Income = $Record_2["income"];
   $SQL_String_2 = "SELECT income FROM gs_mines_costs WHERE name='doner' AND level=$Doner";
   $Query_2 = $Connect->query($SQL_String_2);
   $Record_2 = $Query_2->fetch_assoc();
   $Kebab_Income = $Record_2["income"];
   $SQL_String_2 = "SELECT income FROM gs_mines_costs WHERE name='wifispot' AND level=$Wifispot";
   $Query_2 = $Connect->query($SQL_String_2);
   $Record_2 = $Query_2->fetch_assoc();
   $Wifi_Income = $Record_2["income"];
   $New_Vodka = $Record["amount_vodka"] + $Vodka_Income;
   if ($New_Vodka > 20000) $New_Vodka = 20000;
   $New_Kebab = $Record["amount_kebab"] + $Kebab_Income;
   if ($New_Kebab > 20000) $New_Kebab = 20000;
   $New_Wifi = $Record["amount_wifi"] + $Wifi_Income;
   if ($New_Wifi > 20000) $New_Wifi = 20000;
   $SQL_String_2 = "UPDATE gs_campuses SET amount_vodka=$New_Vodka, amount_wifi=$New_Wifi, amount_kebab=$New_Kebab WHERE id_campus=$ID_Campus";
   $Query_2 = $Connect->query($SQL_String_2);
}
$Connect->close();
?>