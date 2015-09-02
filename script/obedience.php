<?php
include "style.php";
?>

<html>
<head>
   <?php Style_Inline(); ?>
</head>
<body>
   <center>
   <table border=1>
      <tr bgcolor=<?php Bg_Color_One();?> >
         <td>
            <b><center>
            <font size="5">Poparcie</font>
            <br/></b>
            <img src="img/crown.png" alt="Poparcie" width="200" height="200"><br/>  
            </center>          
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?> >
         <td>
         </br><i><center>Poparcie informuje, po ilu atakach kampus zostaje podbity.<br/>
         Każdy atak na kampus zakończony wygraną agresora obniża losowo poparcie o kilkanaście punktów.<br/>
         Gdy poparcie spadnie do 0 kampus zostaje przejęty przez agresora, który dokonał ostatniego ataku.<br/>
         Poparcie rośnie samo o 1 punkt co godzinę, maksymalne poparcie to 100.<br/>
         Poparcie w nowo przejętym kampusie wynosi 25.</center></i></br>
         </td>
      </tr>
   </table>
   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>