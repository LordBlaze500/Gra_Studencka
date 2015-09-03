<?php
include "army.php";
include "style.php";
$Inspector = new Troops_Type('inspector');
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
            <center><b><font size="5">Kanar</font></b></br>
            <img src="img/kanar.png" alt="Kanar" width="100" height="100">
            </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center></br><i>
            Kanar w autobusie czy tramwaju to istna ciężka kawaleria. Zawsze atakuje studentów z wielką siła, bo </br>
            ci nigdy nie mają biletów. Odrażają ich menele, bowiem przebijanie się przez ich zapachową aurę ochronną</br>
            nie jest warte żadnego mandatu. Unikają tez nerdów, ponieważ ci zawsze posiadają czysty, czytelny, ważny,</br>
            skasowany bilet - choćby chciał to mandatu nie ma za co wystawić. </br>
            Kanar ze względu na częste wizyty w kebabowni prezentuje dużą masę. Poza tym potrzebuje wifi by na bieżąco </br>
            zgłaszać każdy wystawiony mandat oraz wódy - żeby odreagować codzienne serie bluzg skierowanych w jego osobę. </br>
            </i></center></br>
         </td>
      </tr>
   </table>

   <table border=1 bgcolor=<?php Bg_Color_Three();?> >
      <tr>
         <td> <b>Koszt rekrutacji: </b></td>
         <td> <b> <?php $Inspector->Costs_Display(); ?> </b></td>
      </tr>
      <tr>
         <td> <b>Statystyki: </b></td>
         <td> <b> <?php $Inspector->Statistics_Display(); ?> </b></td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>