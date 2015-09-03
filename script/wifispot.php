<?php
include "db_connect.php";
include "style.php";
include "building.php";
$ID_Campus = $_SESSION['id_campus'];
if (!$ID_Campus) header('Location: index.php');
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
$Wifispot = new Mining_Building('wifispot', $ID_Campus);
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
         <center><b><font size="5">Spot WiFi poziom <?php echo $Wifispot->Level_Getter();?></font></b><br/>
         <img src="img/spotwifi.png" alt="Spot WiFi" width="132" height="161">
         </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
         </br><center><i>Spot WiFi dostarcza co godzinę określoną liczbę wiader internetów.</br>
         Im wyższy poziom spotu tym więcej wiader.</center></i></br>
         </td>
      </tr>
   </table>
   <br/>
   <table border=1 bgcolor=<?php Bg_Color_Three();?>>
      <tr>
         <td> <b>Obecny poziom: <?php echo $Wifispot->Level_Getter(); ?> </b></td>
         <td> <b>Produkcja: <?php echo $Wifispot->Production_Getter(); ?> wiader/godzina </b></td>
      </tr>
      <?php
      if ($Wifispot->Level_Getter() < 10)
      {
         echo '<tr>';
            echo '<td>'; echo '<b>Na nastepnym poziomie: </b>'; echo '</td>';
            echo '<td>';
            $Next_Level = $Wifispot->Level_Getter()+1;
            $SQL_String = "SELECT * FROM gs_mines_costs WHERE name='wifispot' AND level=$Next_Level";
            $Query = $Connect->query($SQL_String);
            $Record = $Query->fetch_assoc();
            echo '<b>Produkcja: ';
            echo $Record['income'];
            echo ' wiader/godzina</b>';
            echo '</td>';
         echo '</tr>';
      }
      ?>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>