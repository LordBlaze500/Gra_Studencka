<?php
include "db_connect.php";
include "style.php";

$ID_Campus = $_SESSION['id_campus'];
if (!$ID_Campus) header('Location: index.php');
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
?>

<html>
<head>
   <?php Style_Inline(); ?>
</head>
<body>
   <center>
   <b><font size="4">Zmiana nazwy kampusu</font></b>

   <?php
   if (isset($_POST['new_name']))
   {
      $New_Name = $_POST['new_name'];
      $SQL_String = "UPDATE gs_campuses SET name='$New_Name' WHERE id_campus=$ID_Campus";
      $Query = $Connect->Query($SQL_String);
      header('Location: index.php?l=change_name');
   }
   ?>

   <table border=1 bgcolor=<?php Bg_Color_Two();?>>
      <tr>
         <td>
            Aktualna nazwa:
         </td>
         <td>
            <?php
            $SQL_String = "SELECT name FROM gs_campuses WHERE id_campus=$ID_Campus";
            $Query = $Connect->Query($SQL_String);
            $Record = $Query->fetch_assoc();
            $Current_Name = $Record['name'];
            echo $Current_Name;
            ?>
         </td>
      </tr>
      <tr>
         <td>
            Nowa nazwa:
         </td>
         <td>
            <form method="POST">
            <input type="hidden" name="l" value="change_name">
            <input type="text" name="new_name">
            <input type="submit" value="Zmień">
            </form>
         </td>
      </tr>   

   
   </table>
   <a href="?l=main">Powrót</a>
   </center>
   <?php $Connect->close(); ?>
</body>
</html>