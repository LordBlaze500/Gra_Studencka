<?php
include "building.php";
include "style.php";
$ID_Campus = $_SESSION["id_campus"];
$Terminus = new Special_Building("terminus", $ID_Campus);
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
            if ($Terminus->Status_Getter() == 0) echo '<font size="5">Zajezdnia (nie zbudowano)</font>';
            if ($Terminus->Status_Getter() == 1) echo '<font size="5">Zajezdnia</font>';
            ?>
            <br/></b>
            <img src="img/zajezdnia.png" alt="Ławeczka" width="386" height="118"><br/>  
            </center>          
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?> >
         <td>
         </br><i><center>Zajezdnia podwaja maksymalną możliwą do rekrutacji liczbę kanarów i kanarów weteranów.</center></i></br>
         </td>
      </tr>
   </table>
   <br/>
   <table border=1 bgcolor=<?php Bg_Color_Three();?>>
      <tr>
         <td> Bez zajezdni: </td>
         <td> 1000 </td>
      </tr>
      <tr>
         <td> <b>Z zajezdnią: </b></td>
         <td> <b>2000 </b></td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>

   </center>
</body>
</html>