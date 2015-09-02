<?php
include "db_connect.php";
include "style.php";
include "building.php";
$ID_Campus = $_SESSION['id_campus'];
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
$Distillery = new Mining_Building('distillery', $ID_Campus);
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
         <center><b><font size="5">Gorzelnia poziom <?php echo $Distillery->Level_Getter();?></font></b><br/>
         <img src="img/gorzelnia.png" alt="Gorzelnia" width="250" height="162">
         </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
         </br><center><i>Gorzelnia dostarcza co godzinę określoną liczbę flaszek wódki.</br>
         Im wyższy poziom gorzelni tym więcej flaszek.</center></i></br>
         </td>
      </tr>
   </table>
   <br/>
   <table border=1 bgcolor=<?php Bg_Color_Three();?>>
      <tr>
         <td> <b>Obecny poziom: <?php echo $Distillery->Level_Getter(); ?> </b></td>
         <td> <b>Produkcja: <?php echo $Distillery->Production_Getter(); ?> flaszek/godzina </b></td>
      </tr>
      <?php
      if ($Distillery->Level_Getter() < 10)
      {
         echo '<tr>';
            echo '<td>'; echo '<b>Na nastepnym poziomie: </b>'; echo '</td>';
            echo '<td>';
            $Next_Level = $Distillery->Level_Getter()+1;
            $SQL_String = "SELECT * FROM gs_mines_costs WHERE name='distillery' AND level=$Next_Level";
            $Query = $Connect->query($SQL_String);
            $Record = $Query->fetch_assoc();
            echo '<b>Produkcja: ';
            echo $Record['income'];
            echo ' flaszek/godzina</b>';
            echo '</td>';
         echo '</tr>';
      }
      ?>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>