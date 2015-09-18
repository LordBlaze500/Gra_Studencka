<?php
include "db_connect.php";
include "style.php";
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
$User_Login = $_SESSION["login"];
?>

<html>
<head>
   <?php Style_Inline(); ?>
</head>
<body>
   <center>
   <font size="5"><b>Wybór kampusu</b></font><br/>
   <?php
   $SQL_String = "SELECT id_user FROM gs_users WHERE login = '$User_Login'";
   $Query = $Connect->query($SQL_String);
   $Record = $Query->fetch_assoc();
   $ID_User = $Record["id_user"];
   $_SESSION["id_user"] = $ID_User;
   
   $SQL_String = "SELECT id_campus, name, x_coord, y_coord FROM gs_campuses WHERE id_owner= '$ID_User'";
   $Query = $Connect->query($SQL_String);
   echo '<table border=1 >';
   while($Record = $Query->fetch_assoc())
   {
      $ID_Campus = $Record["id_campus"];
      echo '<tr align="center" bgcolor='; echo Bg_Color_Three(); echo '">'; echo '<td>';
      $String = $Record["name"];
      $String .= " (";
      $String .= $Record["x_coord"];
      $String .= "|";
      $String .= $Record["y_coord"];
      $String .= ")<br/>";
      echo '<a href="?l=campus_select&id='.$ID_Campus.'">'.$String.'</a>';
      echo '</td>'; echo '</tr>';
   }
   echo '</table>';
   if (isset($_GET['id']))
   {
      $ID_Campus = $_GET['id'];
      $SQL_String = "SELECT id_owner FROM gs_campuses WHERE id_campus='$ID_Campus'";
      $Query = $Connect->query($SQL_String);
      $Record = $Query->fetch_assoc();
      if ($Record["id_owner"] == $ID_User)
      {
         $_SESSION["id_campus"] = $ID_Campus;
         header("Location: ?l=main");
      }
      else
      {
         echo '<b><font size="4" color="yellow">To nie jest twój kampus!</font></b>';
      }
   }
   $Connect->close();
   ?>
   </center>
</body>
</html>

    