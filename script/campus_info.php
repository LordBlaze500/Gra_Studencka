<?php
include "db_connect.php";
include "style.php";
?>

   <center>
   <?php
   $Connect = new mysqli($db_host, $db_user, $db_password, $db_name); 
   if (isset($_GET['id_campus']))
   {
      $ID_Campus = $_GET['id_campus'];
      $SQL_String = "SELECT x_coord, y_coord, name, id_owner, points FROM gs_campuses WHERE id_campus=$ID_Campus";
      $Query = $Connect->Query($SQL_String);
      if ($Record = $Query->fetch_assoc())
      {
         $Owner = $Record['id_owner'];
         $SQL_String_2 = "SELECT login FROM gs_users WHERE id_user=$Owner";
         $Query_2 = $Connect->query($SQL_String_2);
         $Record_2 = $Query_2->fetch_assoc();
         echo '<font size="5"><b>Informacje o kampusie</b></font>';
         echo '<table border=1 ';
         echo 'bgcolor=';
         Bg_Color_Three();
         echo '>';
            echo '<tr>';
               echo '<td><b>Nazwa:</b></td>';
               echo '<td><i>';
                  echo $Record['name'];
               echo '</i></td>';
            echo '</tr>';
            echo '<tr>';
               echo '<td><b>Współrzędne:</b></td>';
               echo '<td><i>';
                  echo '(';
                  echo $Record['x_coord'];
                  echo '|';
                  echo $Record['y_coord'];
                  echo ')';
               echo '</i></td>';
            echo '</tr>';
            echo '<tr>';
               echo '<td><b>Właściciel:</b></td>';
               echo '<td><i>';
                  $Login = $Record_2['login'];
                  echo '<a href="?l=user_info&id_user='; echo $Owner; echo '">'; echo $Login; echo '</a>';
               echo '</i></td>';
            echo '</tr>';
            echo '<tr>';
               echo '<td><b>';
                  echo 'Punkty:';
               echo '</b></td>';
               echo '<td><i>';
                  echo $Record['points'];
               echo '</i></td>';
            echo '</tr>';
         echo '</table>';
         $Connect->close();
      }
      else echo '<font size="4" color="yellow">Kampus o takim ID nie istnieje!</font><br/>';
   }
   else echo '<font size="4" color="yellow">Nie wybrano kampusu!</font><br/>';
   ?>

   <a href="?l=main">Powrót</a>
   </center>

