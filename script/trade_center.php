<?php
include "db_connect.php";
include "style.php";
include "resource.php";
$ID_Campus = $_SESSION['id_campus'];
if (!$ID_Campus) header('Location: index.php');
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
$Vodka = new Resource('vodka', $ID_Campus);
$Kebab = new Resource('kebab', $ID_Campus);
$Wifi = new Resource('wifi', $ID_Campus);

if (isset($_POST['Send']))
{
   $X = $_POST['X'];
   $Y = $_POST['Y'];
   $Vodka_Amount = $_POST['Vodka'];
   $Kebab_Amount = $_POST['Kebab'];
   $Wifi_Amount = $_POST['Wifi'];
   $SQL_String = "SELECT id_campus FROM gs_campuses WHERE x_coord=$X AND y_coord=$Y";
   $Query = $Connect->Query($SQL_String);
   $Record = $Query->fetch_assoc();
   if (!$Record)
   {
      echo '<font size=4 color="yellow">Taki kampus nie istnieje!</font>';
   }
   else
   {
      if ($Vodka_Amount > $Vodka->Amount_Getter() || $Kebab_Amount > $Kebab->Amount_Getter() || $Wifi_Amount > $Wifi->Amount_Getter())
      echo '<font size=4 color="yellow>Nie masz wystarczająco surowców!</font>';
      else
      {
         $Traders_Needed = ceil(($Vodka_Amount + $Kebab_Amount + $Wifi_Amount)/1000);
         $SQL_String = "SELECT traders FROM gs_campuses WHERE id_campus=$ID_Campus";
         $Query_2 = $Connect->Query($SQL_String);
         $Record_2 = $Query_2->fetch_assoc();
         if ($Record_2['traders'] < $Traders_Needed) echo '<font size=4 color="yellow>Nie masz wystarczająco dużo wolnych kupców!</font>';
         else
         {
            $Destination = $Record['id_campus'];
            $Arrival_Time = new DateTime(); 
            $SQL_String = "SELECT x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Campus";
            $Query_5 = $Connect->Query($SQL_String);
            $Record_3 = $Query_5->fetch_assoc();
            $Distance = abs($Record_3['x_coord'] - $X) + abs($Record_3['y_coord'] - $Y);
            $Arrival_Time->add(new DateInterval('PT'.(10*$Distance).'M'));
            $Date_String = $Arrival_Time->format('Y-m-d H:i:00');
            $SQL_String = "INSERT INTO gs_trading_moves (id_source, id_destination, traders, vodka, kebab, wifi, arrival_time, going_back) VALUES ($ID_Campus, $Destination, $Traders_Needed, $Vodka_Amount, $Kebab_Amount, $Wifi_Amount, '$Date_String', 0)";
            $Query_3 = $Connect->Query($SQL_String);
            $New_Traders = $Record_2['traders'] - $Traders_Needed;
            $SQL_String = "UPDATE gs_campuses SET traders=$New_Traders WHERE id_campus=$ID_Campus";
            $Query_4 = $Connect->Query($SQL_String);
            $Vodka->Decrease($Vodka_Amount);
            $Kebab->Decrease($Kebab_Amount);
            $Wifi->Decrease($Wifi_Amount);
         }
      }
   }
}
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
            <center><b><font size="5">Centrum handlu</font></b></br>
            <img src="img/trade.png" alt="Handel" width="150" height="150">
            </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center></br><i>
            Centrum handlu pozwala przesyłać surowce do innych kampusów oraz handlować nimi z innymi graczami. </br>
            Możesz stworzyć własną ofertę handlu bądź przyjąć cudzą. Każdy handlarz może unieść do 1000 sztuk surowców.</br>
            </i></center></br>
         </td>
      </tr>
   </table>
   <table>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td><b>Dostępni handlarze:</b></td>
         <td><i>
            <?php
            $SQL_String = "SELECT traders FROM gs_campuses WHERE id_campus=$ID_Campus";
            $Query = $Connect->Query($SQL_String);
            $Record = $Query->fetch_assoc();
            echo $Record['traders'];
            echo '/10';
            ?>
         </i></td>
     </tr>
   </table>

   <table border=1 bgcolor=<?php Bg_Color_Three();?>>
      <tr>
         <td>
            <center><b><img src="img/wodka.png" width="50" height="50"><?php echo $Vodka->Amount_Getter(); ?> <img src="img/kebab.png" width="50" height="50"><?php echo $Kebab->Amount_Getter(); ?> <img src="img/wifi.png" width="50" height="50"><?php echo $Wifi->Amount_Getter(); ?></b></center>
         </td>
      </tr>
   </table>

   <table>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
         <b>Wyślij surowce do:</b>
         </td>
         <td align="right"><i>
            <form method="POST">
            <input type="hidden" name="l" value="trade_center">
            X:
            <input type="text" name="X" value="0" style="width: 60px">
            Y:
            <input type="text" name="Y" value="0" style="width: 60px">
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b>Ilość:</b>
         </td>
         <td align="right"><i>
            <img src="img/wodka.png" alt="Wodka" width="30" height="30">
            <input type="text" name="Vodka" value="0" style="width: 60px">
            <img src="img/kebab.png" alt="Kebab" width="30" height="30">
            <input type="text" name="Kebab" value="0" style="width: 60px">
            <img src="img/wifi.png" alt="Wifi" width="30" height="30">
            <input type="text" name="Wifi" value="0" style="width: 60px">
         </i></td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b>Potwierdź:</b>
         </td>
         <td align="right"><i>
            <input type="submit" name="Send" value="Wyślij">
         </i></td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>