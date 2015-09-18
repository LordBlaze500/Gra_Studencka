<?php
include "army.php";
include "style.php";
$Master = new Troops_Type('master');
?>

   <center>
   <table border=1>
      <tr bgcolor=<?php Bg_Color_One();?>>
         <td>
            <center><b><font size="5">Magister</font></b></br>
            <img src="img/magister.png" alt="Magister" width="100" height="100">
            </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center></br><i>
            Po intensywnych "żniwach" pieniężnych za poprawki z ostatniej sesji magister kupił sobie samochód. </br>
            Z tego powodu należy on do kawalerii. Każdy osobnik tego gatunku sieje postrach wśród studentów, </br>
            bowiem w jego rękach leży ich dalszy los (a konkretnie od tego, czy da te same pytania). Boi się jednak </br>
            nerdów, jako że ci zdają nawet najtrudniejsze egzaminy bez problemu, niejednokrotnie wytykając błędy </br>
            w pytaniach. Magistrowie unikają przedstawicieli menelstwa, jako że ci potrafią skutecznie uszczuplić </br>
            ich portfel w celu nabycia kolejnych trunków. </br>
            Magister nieskutecznie walczy z nabytym przez studia alkoholizmem. Oprócz tego potrzebuje zagrychy oraz </br>
            wifi - do szukania gotowca na pracę doktorską. </br>
            </i></center></br>
         </td>
      </tr>
   </table>

   <table border=1 bgcolor=<?php Bg_Color_Three();?> >
      <tr>
         <td> <b>Koszt rekrutacji: </b></td>
         <td> <i> <?php $Master->Costs_Display(); ?> </i></td>
      </tr>
      <tr>
         <td> <b>Statystyki: </b></td>
         <td> <i> <?php $Master->Statistics_Display(); ?> </i></td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
