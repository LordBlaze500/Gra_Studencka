<?php
include "army.php";
include "style.php";
$Parachute = new Troops_Type('parachute');
?>

<html>
<head>
   <?php Style_Inline(); ?>
</head>
<body>
   <center>
   <table border=1>
      <tr bgcolor=<?php Bg_Color_One();?>>
         <td>
            <center><b><font size="5">Student spadochroniarz</font></b></br>
            <img src="img/spadochroniarz.png" alt="Spadochroniarz" width="100" height="100">
            </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center></br><i>
            Ulepszony gatunek studenta. Po przykrych doświadczeniach z niezaliczonego roku postanawia wykorzystać </br>
            potęgę internetów do nauki. Oczywiście najpierw wykop, fejsbuk, demoty, jutube... </br>
            </i></center></br>
         </td>
      </tr>
   </table>

   <table border=1 bgcolor=<?php Bg_Color_Three();?> >
      <tr>
         <td> <b>Koszt rekrutacji: </b></td>
         <td> <b> <?php $Parachute->Costs_Display(); ?> </b></td>
      </tr>
      <tr>
         <td> <b>Statystyki: </b></td>
         <td> <b> <?php $Parachute->Statistics_Display(); ?> </b></td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>