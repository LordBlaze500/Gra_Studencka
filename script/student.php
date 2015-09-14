<?php
include "army.php";
include "style.php";
$Student = new Troops_Type('student');
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
            <center><b><font size="5">Student</font></b></br>
            <img src="img/student.png" alt="Student" width="100" height="100">
            </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center></br><i>
            Wychudzony z powodu nadmiaru alkoholu i niedomiaru pożywienia student zalicza się do lekkiej piechoty. </br>
            Świetnie radzi sobie z nerdami, którzy sami uciekają na myśl o konflikcie w innym świecie niż wirtualny. </br>
            Dobrze radzi sobie też przeciwko menelom, ze względu na bycie ich naturalnym wrogiem w walce o alkohol, mając <br/>
            jednak przewagę młodego wieku. Przegrywa z magistrami ze względu na absolutny brak wiedzy i w konsekwencji groźbę</br>
            dziekanki oraz kanarami - ponieważ nie stać go na bilety. </br>
            Student potrzebuje przede wszystkim wódy do picia, kebab na zagryche i wifi - żeby pobrać od kolegów sciągi na sesję. </br>
            </i></center></br>
         </td>
      </tr>
   </table>

   <table border=1 bgcolor=<?php Bg_Color_Three();?> >
      <tr>
         <td> <b>Koszt rekrutacji: </b></td>
         <td> <i> <?php $Student->Costs_Display(); ?> </i></td>
      </tr>
      <tr>
         <td> <b>Statystyki: </b></td>
         <td> <i> <?php $Student->Statistics_Display(); ?> </i></td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>