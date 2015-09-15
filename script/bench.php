<?php
include "building.php";
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
?>

<html>
<head>
   <?php Style_Inline(); ?>
</head>
<body>
   <center>
   <table border=1>
      <tr bgcolor=<?php Bg_Color_One();?> >
         <td>
            <b><center>
            <?php 
            if ($Bench->Status_Getter() == 0) echo '<font size="5">Ławeczka (nie zbudowano)</font>';
            if ($Bench->Status_Getter() == 1) echo '<font size="5">Ławeczka</font>';
            ?>
            <br/></b>
            <img src="img/laweczka.png" alt="Ławeczka" width="234" height="111"><br/>  
            </center>          
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?> >
         <td>
         </br><i><center>Ławeczka podwaja maksymalną możliwą do rekrutacji liczbę meneli i kloszardów.</center></i></br>
         </td>
      </tr>
   </table>
   <br/>
   <table border=1 bgcolor=<?php Bg_Color_Three();?>>
      <tr>
         <td> Bez ławeczki: </td>
         <td> 1000 </td>
      </tr>
      <tr>
         <td> <b>Z ławeczką: </b></td>
         <td> <b>2000 </b></td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>

   </center>
</body>
</html>