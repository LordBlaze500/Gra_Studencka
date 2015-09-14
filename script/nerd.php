<?php
include "army.php";
include "style.php";
$Nerd = new Troops_Type('nerd');
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
            <center><b><font size="5">Nerd</font></b></br>
            <img src="img/nerd.png" alt="Nerd" width="100" height="100">
            </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center></br><i>
            Wg naukowców nerd spędza w internecie dokładnie 27 h na dobę. Zawsze ubrany jest w gęstą koszulę w kratę </br>
            oraz posiada przy sobie laptopa, tablet, ładowarkę i całą tonę innego sprzętu elektronicznego. Z tego powodu </br> 
            należy on do ciężkiej piechoty. Jest postrachem magistrów, ponieważ zdaje wszystkie egzaminy na 5,0 nawet, gdy </br>
            pytania są inne niż rok temu. Nerd może za to odpłacić się soczystymi 1 na ankiecie o wykładowach. </br>
            Unikają go też kanary, ponieważ zawsze ma przy sobie bilety. Realizuje on powiedzenie "kozak w necie ci*a w świecie", </br>
            dlatego unika on konfliktu ze studentami w świecie rzeczywistym. </br>
            Nerd bez wifi nie ma prawa istnieć. Ale nie samymi internetami człowiek żyje - potrzebne też kebsy do </br>
            utrzymania nadwagi. Nerd nie pije alkoholu, bo mama mu zabrania. </br>
            </i></center></br>
         </td>
      </tr>
   </table>

   <table border=1 bgcolor=<?php Bg_Color_Three();?> >
      <tr>
         <td> <b>Koszt rekrutacji: </b></td>
         <td> <i> <?php $Nerd->Costs_Display(); ?> </i></td>
      </tr>
      <tr>
         <td> <b>Statystyki: </b></td>
         <td> <i> <?php $Nerd->Statistics_Display(); ?> </i></td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>