<?php
include "db_connect.php";
include "style.php";
include "army.php";

$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
$ID_Campus = $_SESSION['id_campus'];
if (!$ID_Campus) header('Location: index.php');
$SQL_String = "SELECT id_owner FROM gs_campuses WHERE id_campus=$ID_Campus";
$Query = $Connect->Query($SQL_String);
$Record = $Query->fetch_assoc();
if (!$_SESSION['id_user'])
{
   $_SESSION['id_campus'] = NULL;
   header('Location: index.php');
}
if ($Record['id_owner'] != $_SESSION['id_user'])
{
   $_SESSION['id_campus'] = NULL;
   header('Location: index.php');
}
?>

<html>
<head>
   <?php Style_Inline(); ?>
</head>
<body>
   <center>
   <?php
   if (isset($_GET['id_move']))
   {
      echo '<font size="5"><b>Informacje o ruchu wojsk</b></font></br>';
   	  $ID_Move = $_GET['id_move'];
   	  $SQL_String = "SELECT * FROM gs_moves WHERE id_move=$ID_Move";
   	  $Query = $Connect->Query($SQL_String);
   	  $Record = $Query->fetch_assoc();
   	  if (!$Record)
   	  {
   	  	  echo '<font size="4" color="yellow">Ruch o takim ID nie istnieje!</font>';
   	  	  exit();
   	  }
        if ($Record['strike'] == 1 && $Record['id_source'] == $ID_Campus)
        {
           echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
              echo '<tr>';
                 echo '<td>';
                 echo '<b>Atak na:</b>';
                 echo '</td>';
                 echo '<td><i>';
                 $ID_Destination = $Record['id_destination'];
                 $SQL_String_2 = "SELECT name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Destination";
                 $Query_2 = $Connect->Query($SQL_String_2);
                 $Record_2 = $Query_2->fetch_assoc();
                 echo '<a href="?l=campus_info&id_campus=';
                 echo $ID_Destination;
                 echo '">';
                 echo $Record_2['name'];
                 echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')';
                 echo '</a>';
                 echo '</i></td>';
              echo '</tr>';
              echo '<tr>';
                 echo '<td>';
                 echo '<b>Pochodzenie:</b>';
                 echo '</td>';
                 echo '<td><i>';
                 $ID_Source = $Record['id_source'];
                 $SQL_String_2 = "SELECT name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Source";
                 $Query_2 = $Connect->Query($SQL_String_2);
                 $Record_2 = $Query_2->fetch_assoc();
                 echo '<a href="?l=campus_info&id_campus=';
                 echo $ID_Source;
                 echo '">';
                 echo $Record_2['name'];
                 echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')';
                 echo '</a>';
                 echo '</i></td>';
              echo '</tr>';
              echo '<tr>';
                 echo '<td>';
                 echo '<b>Godzina przybycia:</b>';
                 echo '</td>';
                 echo '<td><i>';
                 echo $Record['arrival_time'];
                 echo '</i></td>';
              echo '</tr>';
           echo '</table>';
           $Move = new Move($Record['id_move']);
           echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
              echo '<tr>';
                 echo '<td><b>';
                 echo '<img src="img/student.png" alt="Student" width="50" height="50">';
                 echo $Move->Army_Getter()->Student_Getter()->Number_Getter();
                 echo '<img src="img/spadochroniarz.png" alt="Spadochroniarz" width="50" height="50">';
                 echo $Move->Army_Getter()->Parachute_Getter()->Number_Getter();
                 echo '<img src="img/menel.png" alt="Menel" width="50" height="50">';
                 echo $Move->Army_Getter()->Drunkard_Getter()->Number_Getter();
                 echo '<img src="img/kloszard.png" alt="Kloszard" width="50" height="50">';
                 echo $Move->Army_Getter()->Clochard_Getter()->Number_Getter();
                 echo '<img src="img/nerd.png" alt="Nerd" width="50" height="50">';
                 echo $Move->Army_Getter()->Nerd_Getter()->Number_Getter();
                 echo '<img src="img/stulejarz.png" alt="Stulejarz" width="50" height="50">';
                 echo $Move->Army_Getter()->Stooley_Getter()->Number_Getter();
                 echo '<img src="img/magister.png" alt="Magister" width="50" height="50">';
                 echo $Move->Army_Getter()->Master_Getter()->Number_Getter();
                 echo '<img src="img/doktor.png" alt="Doktor" width="50" height="50">';
                 echo $Move->Army_Getter()->Doctor_Getter()->Number_Getter();
                 echo '<img src="img/kanar.png" alt="Kanar" width="50" height="50">';
                 echo $Move->Army_Getter()->Inspector_Getter()->Number_Getter();
                 echo '<img src="img/weteran.png" alt="Weteran" width="50" height="50">';
                 echo $Move->Army_Getter()->Veteran_Getter()->Number_Getter();
                 echo '</b></td>';
              echo '</tr>';
           echo '</table>';
        }
        if ($Record['strike'] == 0 && ($Record['id_source'] == $ID_Campus || $Record['id_destination'] == $ID_Campus))
        {
           echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
              echo '<tr>';
                 echo '<td><b>';
                 echo 'Wsparcie dla:';
                 echo '</b></td>';
                 echo '<td><i>';
                 $ID_Destination = $Record['id_destination'];
                 $SQL_String_2 = "SELECT name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Destination";
                 $Query_2 = $Connect->Query($SQL_String_2);
                 $Record_2 = $Query_2->fetch_assoc();
                 echo '<a href="?l=campus_info&id_campus=';
                 echo $ID_Destination;
                 echo '">';
                 echo $Record_2['name'];
                 echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')';
                 echo '</a>';
                 echo '</i></td>';
              echo '</tr>';
              echo '<tr>';
                 echo '<td><b>';
                 echo 'Pochodzenie:';
                 echo '</b></td>';
                 echo '<td><i>';
                 $ID_Source = $Record['id_source'];
                 $SQL_String_2 = "SELECT name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Source";
                 $Query_2 = $Connect->Query($SQL_String_2);
                 $Record_2 = $Query_2->fetch_assoc();
                 echo '<a href="?l=campus_info&id_campus=';
                 echo $ID_Source;
                 echo '">';
                 echo $Record_2['name'];
                 echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')';
                 echo '</a>';
                 echo '</i></td>';
              echo '</tr>';
              echo '<tr>';
                 echo '<td><b>';
                 echo 'Godzina przybycia:';
                 echo '</b></td>';
                 echo '<td><i>';
                 echo $Record['arrival_time'];
                 echo '</i></td>';
              echo '</tr>';
           echo '</table>';
           $Move = new Move($Record['id_move']);
           echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
              echo '<tr>';
                 echo '<td><b>';
                 echo '<img src="img/student.png" alt="Student" width="50" height="50">';
                 echo $Move->Army_Getter()->Student_Getter()->Number_Getter();
                 echo '<img src="img/spadochroniarz.png" alt="Spadochroniarz" width="50" height="50">';
                 echo $Move->Army_Getter()->Parachute_Getter()->Number_Getter();
                 echo '<img src="img/menel.png" alt="Menel" width="50" height="50">';
                 echo $Move->Army_Getter()->Drunkard_Getter()->Number_Getter();
                 echo '<img src="img/kloszard.png" alt="Kloszard" width="50" height="50">';
                 echo $Move->Army_Getter()->Clochard_Getter()->Number_Getter();
                 echo '<img src="img/nerd.png" alt="Nerd" width="50" height="50">';
                 echo $Move->Army_Getter()->Nerd_Getter()->Number_Getter();
                 echo '<img src="img/stulejarz.png" alt="Stulejarz" width="50" height="50">';
                 echo $Move->Army_Getter()->Stooley_Getter()->Number_Getter();
                 echo '<img src="img/magister.png" alt="Magister" width="50" height="50">';
                 echo $Move->Army_Getter()->Master_Getter()->Number_Getter();
                 echo '<img src="img/doktor.png" alt="Doktor" width="50" height="50">';
                 echo $Move->Army_Getter()->Doctor_Getter()->Number_Getter();
                 echo '<img src="img/kanar.png" alt="Kanar" width="50" height="50">';
                 echo $Move->Army_Getter()->Inspector_Getter()->Number_Getter();
                 echo '<img src="img/weteran.png" alt="Weteran" width="50" height="50">';
                 echo $Move->Army_Getter()->Veteran_Getter()->Number_Getter();
                 echo '</b></td>';
              echo '</tr>';
           echo '</table>';
        }
        if ($Record['strike'] == 2 && $Record['id_source'] == $ID_Campus)
        {
           echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
              echo '<tr>';
                 echo '<td><b>';
                 echo 'Powrót do:';
                 echo '</b></td>';
                 echo '<td><i>';
                 $ID_Destination = $Record['id_destination'];
                 $SQL_String_2 = "SELECT name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Destination";
                 $Query_2 = $Connect->Query($SQL_String_2);
                 $Record_2 = $Query_2->fetch_assoc();
                 echo '<a href="?l=campus_info&id_campus=';
                 echo $ID_Destination;
                 echo '">';
                 echo $Record_2['name'];
                 echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')';
                 echo '</a>';
                 echo '</i></td>';
              echo '</tr>';
              echo '<tr>';
                 echo '<td><b>';
                 echo 'Powrót z:';
                 echo '</b></td>';
                 echo '<td><i>';
                 $ID_Source = $Record['old_id_destination'];
                 $SQL_String_2 = "SELECT name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Source";
                 $Query_2 = $Connect->Query($SQL_String_2);
                 $Record_2 = $Query_2->fetch_assoc();
                 echo '<a href="?l=campus_info&id_campus=';
                 echo $ID_Source;
                 echo '">';
                 echo $Record_2['name'];
                 echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')';
                 echo '</a>';
                 echo '</i></td>';
              echo '</tr>';
              echo '<tr>';
                 echo '<td><b>';
                 echo 'Godzina przybycia:';
                 echo '</b></td>';
                 echo '<td><i>';
                 echo $Record['arrival_time'];
                 echo '</i></td>';
              echo '</tr>';
           echo '</table>';
           $Move = new Move($Record['id_move']);
           echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
              echo '<tr>';
                 echo '<td><b>';
                 echo '<img src="img/student.png" alt="Student" width="50" height="50">';
                 echo $Move->Army_Getter()->Student_Getter()->Number_Getter();
                 echo '<img src="img/spadochroniarz.png" alt="Spadochroniarz" width="50" height="50">';
                 echo $Move->Army_Getter()->Parachute_Getter()->Number_Getter();
                 echo '<img src="img/menel.png" alt="Menel" width="50" height="50">';
                 echo $Move->Army_Getter()->Drunkard_Getter()->Number_Getter();
                 echo '<img src="img/kloszard.png" alt="Kloszard" width="50" height="50">';
                 echo $Move->Army_Getter()->Clochard_Getter()->Number_Getter();
                 echo '<img src="img/nerd.png" alt="Nerd" width="50" height="50">';
                 echo $Move->Army_Getter()->Nerd_Getter()->Number_Getter();
                 echo '<img src="img/stulejarz.png" alt="Stulejarz" width="50" height="50">';
                 echo $Move->Army_Getter()->Stooley_Getter()->Number_Getter();
                 echo '<img src="img/magister.png" alt="Magister" width="50" height="50">';
                 echo $Move->Army_Getter()->Master_Getter()->Number_Getter();
                 echo '<img src="img/doktor.png" alt="Doktor" width="50" height="50">';
                 echo $Move->Army_Getter()->Doctor_Getter()->Number_Getter();
                 echo '<img src="img/kanar.png" alt="Kanar" width="50" height="50">';
                 echo $Move->Army_Getter()->Inspector_Getter()->Number_Getter();
                 echo '<img src="img/weteran.png" alt="Weteran" width="50" height="50">';
                 echo $Move->Army_Getter()->Veteran_Getter()->Number_Getter();
                 echo '</b></td>';
              echo '</tr>';
           echo '</table>';
           echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
              echo '<tr>';
                 echo '<td><b>';
                 echo '<img src="img/wodka.png" alt="Wodka" width="50" height="50">';
                 echo $Move->Stolen_Vodka_Getter();
                 echo '<img src="img/kebab.png" alt="Kebab" width="50" height="50">';
                 echo $Move->Stolen_Kebab_Getter();
                 echo '<img src="img/wifi.png" alt="Wifi" width="50" height="50">';
                 echo $Move->Stolen_Wifi_Getter();
                 echo '</b></td>';
              echo '</tr>';
           echo '</table>';
        }
   }
   ?>
   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>