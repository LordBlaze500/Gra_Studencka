<?php
include "army.php";
include "style.php";
$Doctor = new Troops_Type('doctor');
?>

   <center>
   <table border=1>
      <tr bgcolor=<?php Bg_Color_One();?>>
         <td>
            <center><b><font size="5">Doktor</font></b></br>
            <img src="img/doktor.png" alt="Doktor" width="100" height="100">
            </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center></br><i>
            Doktor uzyskał swój zaszczytny tytuł przekupując komisję egzaminacyjną. </br>
            Teraz postanawia resztę życia spędzic w spokoju pijąc, jedząc, siedząc na wykopie no i </br>
            oczywiście oblewając studentów raz za razem. W końcu hajs z poprawek jest potrzebny, kredyt </br>
            wzięty na łapowki sam się nie spłaci. </br>
            </i></center></br>
         </td>
      </tr>
   </table>

   <table border=1 bgcolor=<?php Bg_Color_Three();?> >
      <tr>
         <td> <b>Koszt rekrutacji: </b></td>
         <td> <i> <?php $Doctor->Costs_Display(); ?> </i></td>
      </tr>
      <tr>
         <td> <b>Statystyki: </b></td>
         <td> <i> <?php $Doctor->Statistics_Display(); ?> </i></td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
