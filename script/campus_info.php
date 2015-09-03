<?php
include "db_connect.php";
include "style.php";
?>

<html>
<head>
   <?php Style_Inline(); ?>
</head>
<body>
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
         echo '<font size="4"><b>Informacje o kampusie</b></font>';
         echo '<table border=1 ';
         echo 'bgcolor=';
         Bg_Color_Three();
         echo '>';
            echo '<tr>';
               echo '<td>Nazwa:</td>';
               echo '<td>';
                  echo $Record['name'];
               echo '</td>';
            echo '</tr>';
            echo '<tr>';
               echo '<td>Współrzędne:</td>';
               echo '<td>';
                  echo '(';
                  echo $Record['x_coord'];
                  echo '|';
                  echo $Record['y_coord'];
                  echo ')';
               echo '</td>';
            echo '</tr>';
            echo '<tr>';
               echo '<td>Właściciel:</td>';
               echo '<td>';
                  $Login = $Record_2['login'];
                  echo '<a href="?l=user_info&id_user='; echo $Owner; echo '">'; echo $Login; echo '</a>';
               echo '</td>';
            echo '</tr>';
            echo '<tr>';
               echo '<td>';
                  echo 'Punkty:';
               echo '</td>';
               echo '<td>';
                  echo $Record['points'];
               echo '</td>';
            echo '</tr>';
         echo '</table>';
         $Connect->close();
      }
      else echo 'Kampus o takim ID nie istnieje!<br/>';
   }
   else echo 'Nie wybrano kampusu!<br/>';
   ?>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>
