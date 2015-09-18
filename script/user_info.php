<?php
include "db_connect.php";
include "style.php";
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name); 
?>

   <center>
   <?php
   if (isset($_GET['id_user']))
   {
      $ID_User = $_GET['id_user'];
      $SQL_String = "SELECT login, description, points_total, ranking FROM gs_users WHERE id_user=$ID_User";
      $Query = $Connect->Query($SQL_String);
      if ($Record = $Query->fetch_assoc())
      {
         echo '<font size="5"><b>Informacje o użytkowniku</b></font>';
         echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
            echo '<tr>';
               echo '<td><b>Login:</b></td>';
               echo '<td><i>';
                  echo $Record['login'];
               echo '</i></td>';
            echo '</tr>';
            echo '<tr>';
               echo '<td><b>Punkty:</b></td>';
               echo '<td><i>';
                  echo $Record['points_total'];
               echo '</i></td>';
            echo '</tr>';
            echo '<tr>';
               echo '<td><b>Ranking:</b></td>';
               echo '<td><i>';
                  echo $Record['ranking'];
               echo '</i></td>'; 
            echo '</tr>';
            echo '<tr>'; 
               echo '<td><b>Opis użytkownika:</b></td>';
               echo '<td>';
                  echo '<i>';
                  echo $Record['description'];
                  echo '</i>';
               echo '</td>';
            echo '</tr>';
         echo '</table>';
         echo '<b><font size="4" color="yellow">Posiadane kampusy</font></b>';
         echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
         $SQL_String_2 = "SELECT id_campus, x_coord, y_coord, name, points FROM gs_campuses WHERE id_owner=$ID_User";
         $Query_2 = $Connect->Query($SQL_String_2);
         while ($Record_2 = $Query_2->fetch_assoc())
         {
            echo '<tr>';
               echo '<td>';
                  $ID_Campus = $Record_2['id_campus'];
                  echo '<a href="?l=campus_info&id_campus=';
                  echo $ID_Campus;
                  echo '">';
                  echo $Record_2['name'];
                  echo ' (';
                  echo $Record_2['x_coord'];
                  echo '|';
                  echo $Record_2['y_coord'];
                  echo ')';
                  echo '</a>';
               echo '</td>';
               echo '<td>';
                  echo $Record_2['points'];
                  echo ' pkt.';
               echo '</td>';
            echo '</tr>';
         }
         echo '</table>';
         $Connect->close();
      }
      else echo '<font size="4" color="yellow">Użytkownik o takim ID nie istnieje!</font><br/>';
   }
   else echo '<font size="4" color="yellow">Nie wybrano użytkownika!</font><br/>';
   ?>

   <a href="?l=main">Powrót</a>
   </center>

