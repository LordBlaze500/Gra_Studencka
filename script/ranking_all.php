<?php
include "db_connect.php";
include "style.php";

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
$ID_User = $_SESSION['id_user'];
?>

   <center>
       <font size="5"><b>Ranking</b></font><br/>
   	   <table border=1>
       <tr bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <b>Pozycja</b>
         </td>
         <td>
         	<b>Login</b>
         </td>
         <td>
         	<b>Punkty</b>
         </td>
         <td>
         	<b>Liczba kampusów</b>
         </td>
      </tr>
      <?php
      $SQL_String = "SELECT id_user, login, points_total, ranking FROM gs_users ORDER BY ranking ASC";
      $Query = $Connect->Query($SQL_String);
      while ($Record = $Query->fetch_assoc())
      {
         if ($Record['login'] != 'WORLD')
         {
         	$ID_Owner = $Record['id_user'];
            echo '<tr bgcolor=<';
            echo Bg_Color_Two();
            echo '>';
            echo '<td><i>';
            if ($Record['id_user'] == $ID_User) echo '<b>';
            echo $Record['ranking'];
            if ($Record['id_user'] == $ID_User) echo '</b>';
            echo '</i></td>';
            echo '<td><i>';
            if ($Record['id_user'] == $ID_User) echo '<b>';
            echo '<a href="?l=user_info&id_user='; echo $ID_Owner; echo '">'; echo $Record['login']; echo '</a>';
            if ($Record['id_user'] == $ID_User) echo '</b>';
            echo '</i></td>';
            echo '<td><i>';
            if ($Record['id_user'] == $ID_User) echo '<b>';
            echo $Record['points_total'];
            if ($Record['id_user'] == $ID_User) echo '</b>';
            echo '</i></td>';
            $SQL_String = "SELECT COUNT(id_owner) AS campuses_counter FROM gs_campuses WHERE id_owner=$ID_Owner";
            $Query_2 = $Connect->Query($SQL_String);
            $Record_2 = $Query_2->fetch_assoc();
            echo '<td><i>';
            if ($Record['id_user'] == $ID_User) echo '<b>';
            echo $Record_2['campuses_counter'];
            if ($Record['id_user'] == $ID_User) echo '</b>';
            echo '</i></td>';
         }	
      }
      $Connect->close();
      ?>
      </table>
   <a href="?l=main">Powrót</a>
   </center>

