<?php
include "army.php";
include "style.php";
$Drunkard = new Troops_Type('drunkard');
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
            <center><b><font size="5">Menel</font></b></br>
            <img src="img/menel.png" alt="Menel" width="100" height="100">
            </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center></br><i>
            Uzbrojony w zapas taniego wina, torbę żulówkę i koszyk bogactw należy do ciężkiej piechoty. </br>
            Nie podskoczy mu żaden kanar - jego naturalna woń trzyma ich na dystans. Omijają go takze magistrowie </br>
            ze względu na ciągłe prośby o "5 złote". Studenci to ich jedyny groźny wróg - ze względu na sędziwy </br>
            wiek i problemy zdrowotne nie potrafią oni pokonać żaków w rywalizacji o napoje wyskokowe.</br>
            Ilość alkoholu spożywanego przez menela przechodzi ludzkie pojęcie. Oprócz tego lubi za ekstra</br>
            wyżebrany hajs kupić sobie dobrego kebsa. Menel nie ma pojęcia, że takie coś jak wifi istnieje. </br>
            </i></center></br>
         </td>
      </tr>
   </table>

   <table border=1 bgcolor=<?php Bg_Color_Three();?> >
      <tr>
         <td> <b>Koszt rekrutacji: </b></td>
         <td> <b> <?php $Drunkard->Costs_Display(); ?> </b></td>
      </tr>
      <tr>
         <td> <b>Statystyki: </b></td>
         <td> <b> <?php $Drunkard->Statistics_Display(); ?> </b></td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>