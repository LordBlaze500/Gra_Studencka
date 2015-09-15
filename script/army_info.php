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
   if (isset($_GET['id_army']))
   {
      echo '<font size="5"><b>Informacje o wojskach</b></font></br>';
   	  $ID_Army = $_GET['id_army'];
   	  $SQL_String = "SELECT * FROM gs_armies WHERE id_army=$ID_Army";
   	  $Query = $Connect->Query($SQL_String);
   	  $Record = $Query->fetch_assoc();
   	  if (!$Record)
   	  {
   	  	  echo '<font size=4><b>Armia o takim ID nie istnieje!</b></font>';
   	  	  exit();
   	  }
   	  if ($Record['id_homecampus'] == $ID_Campus && $Record['id_stayingcampus'] != 0 && $Record['id_stayingcampus'] != $ID_Campus)
   	  {
         echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
            echo '<tr>';
               echo '<td>';
               echo '<b>Miejsce pobytu: </b>';
               echo '</td>';
               echo '<td><i>';
               $ID_Stayingcampus = $Record['id_stayingcampus'];
               $SQL_String_2 = "SELECT name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Stayingcampus";
               $Query_2 = $Connect->Query($SQL_String_2);
               $Record_2 = $Query_2->fetch_assoc();
               echo '<a href="?l=campus_info&id_campus='; echo $ID_Stayingcampus; echo '">'; echo $Record_2['name']; echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')</a>';
               echo '</i></td>';
            echo '</tr>';
            echo '<tr>';
               echo '<td><b>';
               echo 'Pochodzenie: ';
               echo '</b></td>';
               echo '<td><i>';
               $ID_Homecampus = $Record['id_homecampus'];
               $SQL_String_2 = "SELECT name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Homecampus";
               $Query_2 = $Connect->Query($SQL_String_2);
               $Record_2 = $Query_2->fetch_assoc();
               echo '<a href="?l=campus_info&id_campus='; echo $ID_Homecampus; echo '">'; echo $Record_2['name']; echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')</a>';
               echo '</i></td>';
            echo '</tr>';
         echo '</table>';
         $Army = new Army($ID_Army);
         echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
            echo '<tr>';
               echo '<td><b>';
               echo '<img src="img/student.png" alt="Student" width="50" height="50">';
               echo $Army->Student_Getter()->Number_Getter();
               echo '<img src="img/spadochroniarz.png" alt="Spadochroniarz" width="50" height="50">';
               echo $Army->Parachute_Getter()->Number_Getter();
               echo '<img src="img/menel.png" alt="Menel" width="50" height="50">';
               echo $Army->Drunkard_Getter()->Number_Getter();
               echo '<img src="img/kloszard.png" alt="Kloszard" width="50" height="50">';
               echo $Army->Clochard_Getter()->Number_Getter();
               echo '<img src="img/nerd.png" alt="Nerd" width="50" height="50">';
               echo $Army->Nerd_Getter()->Number_Getter();
               echo '<img src="img/stulejarz.png" alt="Stulejarz" width="50" height="50">';
               echo $Army->Stooley_Getter()->Number_Getter();
               echo '<img src="img/magister.png" alt="Magister" width="50" height="50">';
               echo $Army->Master_Getter()->Number_Getter();
               echo '<img src="img/doktor.png" alt="Doktor" width="50" height="50">';
               echo $Army->Doctor_Getter()->Number_Getter();
               echo '<img src="img/kanar.png" alt="Kanar" width="50" height="50">';
               echo $Army->Inspector_Getter()->Number_Getter();
               echo '<img src="img/weteran.png" alt="Weteran" width="50" height="50">';
               echo $Army->Veteran_Getter()->Number_Getter();
               echo '</b></td>';
            echo '</tr>';
        echo '</table>';
   	  }
   	  if ($Record['id_stayingcampus'] == $ID_Campus)
   	  {
           echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
            echo '<tr>';
               echo '<td><b>';
               echo 'Miejsce pobytu: ';
               echo '</b></td>';
               echo '<td><i>';
               $ID_Stayingcampus = $Record['id_stayingcampus'];
               $SQL_String_2 = "SELECT name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Stayingcampus";
               $Query_2 = $Connect->Query($SQL_String_2);
               $Record_2 = $Query_2->fetch_assoc();
               echo '<a href="?l=campus_info&id_campus='; echo $ID_Stayingcampus; echo '">'; echo $Record_2['name']; echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')</a>';
               echo '</i></td>';
            echo '</tr>';
            echo '<tr>';
               echo '<td><b>';
               echo 'Pochodzenie: ';
               echo '</b></td>';
               echo '<td><i>';
               $ID_Homecampus = $Record['id_homecampus'];
               $SQL_String_2 = "SELECT name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Homecampus";
               $Query_2 = $Connect->Query($SQL_String_2);
               $Record_2 = $Query_2->fetch_assoc();
               echo '<a href="?l=campus_info&id_campus='; echo $ID_Homecampus; echo '">'; echo $Record_2['name']; echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')</a>';
               echo '</i></td>';
            echo '</tr>';
         echo '</table>';
         $Army = new Army($ID_Army);
         echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
            echo '<tr>';
               echo '<td><b>';
               echo '<img src="img/student.png" alt="Student" width="50" height="50">';
               echo $Army->Student_Getter()->Number_Getter();
               echo '<img src="img/spadochroniarz.png" alt="Spadochroniarz" width="50" height="50">';
               echo $Army->Parachute_Getter()->Number_Getter();
               echo '<img src="img/menel.png" alt="Menel" width="50" height="50">';
               echo $Army->Drunkard_Getter()->Number_Getter();
               echo '<img src="img/kloszard.png" alt="Kloszard" width="50" height="50">';
               echo $Army->Clochard_Getter()->Number_Getter();
               echo '<img src="img/nerd.png" alt="Nerd" width="50" height="50">';
               echo $Army->Nerd_Getter()->Number_Getter();
               echo '<img src="img/stulejarz.png" alt="Stulejarz" width="50" height="50">';
               echo $Army->Stooley_Getter()->Number_Getter();
               echo '<img src="img/magister.png" alt="Magister" width="50" height="50">';
               echo $Army->Master_Getter()->Number_Getter();
               echo '<img src="img/doktor.png" alt="Doktor" width="50" height="50">';
               echo $Army->Doctor_Getter()->Number_Getter();
               echo '<img src="img/kanar.png" alt="Kanar" width="50" height="50">';
               echo $Army->Inspector_Getter()->Number_Getter();
               echo '<img src="img/weteran.png" alt="Weteran" width="50" height="50">';
               echo $Army->Veteran_Getter()->Number_Getter();
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