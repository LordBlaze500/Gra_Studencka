<?php
include "army.php";
include "style.php";
$Clochard = new Troops_Type('clochard');
?>

   <center>
   <table border=1>
      <tr bgcolor=<?php Bg_Color_One();?>>
         <td>
            <center><b><font size="5">Kloszard</font></b></br>
            <img src="img/kloszard.png" alt="Kloszard" width="100" height="100">
            </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center></br><i>
            Kloszard kumpluje się z Panem Tadeuszem i Sobieskim, lubi wycieczki do Finlandii, kocha </br>
            Krupnik na zimno a o żołądek dba regularnie wszystkim, co Żołądkowo Gorzkie. </br> 
            Kloszard, nie mając zbędnego balastu na utrzymaniu w postaci domu, może wydać na wódę jeszcze więcej.</br>
            </i></center></br>
         </td>
      </tr>
   </table>

   <table border=1 bgcolor=<?php Bg_Color_Three();?> >
      <tr>
         <td> <b>Koszt rekrutacji: </b></td>
         <td> <i> <?php $Clochard->Costs_Display(); ?> </i></td>
      </tr>
      <tr>
         <td> <b>Statystyki: </b></td>
         <td> <i> <?php $Clochard->Statistics_Display(); ?> </i></td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
