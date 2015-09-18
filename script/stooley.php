<?php
include "army.php";
include "style.php";
$Stooley = new Troops_Type('stooley');
?>

   <center>
   <table border=1>
      <tr bgcolor=<?php Bg_Color_One();?>>
         <td>
            <center><b><font size="5">Stulejarz</font></b></br>
            <img src="img/stulejarz.png" alt="Stulejarz" width="100" height="100">
            </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center></br><i>
            Naturalne kolejne ogniwo w łańcuchu ewolucji istot nerdopodobnych. Stulejarz uświadamia sobie</br>
            beznadzieję wszelkiego życia społecznego i z tego też powodu odcina się on całkowicie od ludzi. </br>
            Wyposażony w szybsze internety i dodatkowego kebaba jest gotowy na podbój świata, wirtualnego oczywiście. </br>
            Stulejarz nie pije alkoholu, bo mama wciąż mu nie pozwala. </br>
            </i></center></br>
         </td>
      </tr>
   </table>

   <table border=1 bgcolor=<?php Bg_Color_Three();?> >
      <tr>
         <td> <b>Koszt rekrutacji: </b></td>
         <td> <i> <?php $Stooley->Costs_Display(); ?> </i></td>
      </tr>
      <tr>
         <td> <b>Statystyki: </b></td>
         <td> <i> <?php $Stooley->Statistics_Display(); ?> </i></td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
