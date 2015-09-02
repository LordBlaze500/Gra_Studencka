<?php
if (!defined('__POINTS_PHP__'))
{
   define('__POINTS_PHP__',1);
   function Calculate_Points($Connect)
   {
   $SQL_String = "SELECT * FROM gs_campuses";
   $Query = $Connect->Query($SQL_String);
   while ($Record = $Query->fetch_assoc())
   {
      $Points = 1;
      if ($Record['dormitory'] == 1) $Points = $Points + 4;
      if ($Record['dormitory'] == 2) $Points = $Points + 9;
      if ($Record['transit'] == 1) $Points = $Points + 6;
      if ($Record['transit'] == 2) $Points = $Points + 13;
      if ($Record['college'] == 1) $Points = $Points + 6;
      if ($Record['college'] == 2) $Points = $Points + 13;
      if ($Record['liquirstore'] == 1) $Points = $Points + 5;
      if ($Record['liquirstore'] == 2) $Points = $Points + 11;
      if ($Record['cafe'] == 1) $Points = $Points + 5;
      if ($Record['cafe'] == 2) $Points = $Points + 11;
      if ($Record['terminus'] == 1) $Points = $Points + 4;
      if ($Record['bench'] == 1) $Points = $Points + 4;
      if ($Record['parking'] == 1) $Points = $Points + 4;
      if ($Record['distillery'] > 1) $Points = $Points + $Record['distillery'] - 1;
      if ($Record['doner'] > 1) $Points = $Points + $Record['doner'] - 1;
      if ($Record['wifispot'] > 1) $Points = $Points + $Record['wifispot'] - 1;
      if ($Record['distillery'] == 10) $Points = $Points + 1;
      if ($Record['doner'] == 10) $Points = $Points + 1;
      if ($Record['wifispot'] == 10) $Points = $Points + 1;
      $ID_Campus = $Record['id_campus'];
      $SQL_String_2 = "UPDATE gs_campuses SET points=$Points WHERE id_campus=$ID_Campus";
      $Query_2 = $Connect->Query($SQL_String_2);
   }
   }

   function Calculate_User_Points($Connect)
   {
      $SQL_String = "SELECT id_user FROM gs_users";
      $Query = $Connect->Query($SQL_String);
      while ($Record = $Query->fetch_assoc())
      {
         $ID_User = $Record['id_user'];
         $SQL_String_2 = "SELECT SUM(Points) AS total FROM gs_campuses WHERE id_owner=$ID_User";
         $Query_2 = $Connect->Query($SQL_String_2);
         $Record_2 = $Query_2->fetch_assoc();
         $Total = $Record_2['total'];
         $SQL_String_3 = "UPDATE gs_users SET points_total=$Total WHERE id_user=$ID_User";
         $Query_3 = $Connect->Query($SQL_String_3);
      }
   }

   function Calculate_Ranking($Connect)
   {
      $SQL_String = "SELECT id_user FROM gs_users ORDER BY points_total DESC";
      $Query = $Connect->Query($SQL_String);
      $Position = 0;
      while ($Record = $Query->fetch_assoc())
      {
         $ID_User = $Record['id_user'];
         $Position = $Position + 1;
         $SQL_String_2 = "UPDATE gs_users SET ranking=$Position WHERE id_user=$ID_User";
         $Query_2 = $Connect->Query($SQL_String_2);
      }
   }

}
?>