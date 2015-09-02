<?php
include "db_connect.php";
include "style.php";
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name); 
?>

<html>
<head>
   <?php Style_Inline(); ?>
</head>
<body>
   <center>
   <?php
   if (isset($_GET['id_user']))
   {
      $ID_User = $_GET['id_user'];
      $SQL_String = "SELECT login, description, points_total, ranking FROM gs_users WHERE id_user=$ID_User";
      $Query = $Connect->Query($SQL_String);
      if ($Record = $Query->fetch_assoc())
      {
         echo '<font size="4"><b>Informacje o użytkowniku</b></font>';
         echo '<table border=1'; echo ' bgcolor='; echo Bg_Color_Three(); echo '>';
            echo '<tr>';
               echo '<td>Login:</td>';
               echo '<td>';
                  echo $Record['login'];
               echo '</td>';
            echo '</tr>';
            echo '<tr>';
               echo '<td>Punkty:</td>';
               echo '<td>';
                  echo $Record['points_total'];
               echo '</td>';
            echo '</tr>';
            echo '<tr>';
               echo '<td>Ranking:</td>';
               echo '<td>';
                  echo $Record['ranking'];
               echo '</td>'; 
            echo '</tr>';
            echo '<tr>'; 
               echo '<td>Opis użytkownika:</td>';
               echo '<td>';
                  echo '<i>';
                  echo $Record['description'];
                  echo '</i>';
               echo '</td>';
            echo '</tr>';
         echo '</table>';
         echo '<b>Posiadane kampusy</b>';
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
      else echo 'Użytkownik o takim ID nie istnieje!<br/>';
   }
   else echo 'Nie wybrano użytkownika!<br/>';
   ?>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>
