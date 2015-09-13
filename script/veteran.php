<?php
include "army.php";
include "style.php";
$Veteran = new Troops_Type('veteran');
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
            <center><b><font size="5">Kanar weteran</font></b></br>
            <img src="img/weteran.png" alt="Weteran" width="100" height="100">
            </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center></br><i>
            Mając kilkadziesiąt lat stażu kanar weteran jednym spojrzeniem ze współczynnikiem trafień 100% identyfikuje </br>
            każdego gapowicza. Ze względu na przekroczenie magicznej liczby miliona wystawionych mandatów dostał on </br>
            sporą podwyżkę - dlatego też może pozwolić sobie na większe niż dotychczas zaopatrzenie w wóde i kebsy. </br> 
            </i></center></br>
         </td>
      </tr>
   </table>

   <table border=1 bgcolor=<?php Bg_Color_Three();?> >
      <tr>
         <td> <b>Koszt rekrutacji: </b></td>
         <td> <b> <?php $Veteran->Costs_Display(); ?> </b></td>
      </tr>
      <tr>
         <td> <b>Statystyki: </b></td>
         <td> <b> <?php $Veteran->Statistics_Display(); ?> </b></td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>