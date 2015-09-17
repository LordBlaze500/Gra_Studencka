<?php
include "db_connect.php";
include "style.php";
include "resource.php";
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
$ID_Campus = $_SESSION['id_campus'];
if (!$ID_Campus) header('Location: index.php');
$SQL_String = "SELECT id_owner FROM gs_campuses WHERE id_campus=$ID_Campus";
$Query = $Connect->Query($SQL_String);
$Record = $Query->fetch_assoc();
if (!$_SESSION['id_user'])
{
   $_SESSION['id_campus'] = NULL;
   header('Location: index.php');
}
if ($Record['id_owner'] != $_SESSION['id_user'])
{
   $_SESSION['id_campus'] = NULL;
   header('Location: index.php');
}

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

if(isset($_POST["X"])) {
    if($_POST["X"] > 0 && $_POST["X"] <= 100)
        $x_value = $_POST["X"];
    else
        $x_value = "0";
} else
    $x_value = "0";

if(isset($_POST["Y"])) {
    if($_POST["Y"] > 0 && $_POST["Y"] <= 100)
        $y_value = $_POST["Y"];
    else
        $y_value = "0";
} else
    $y_value = "0";
?>

<html>
<head>
   <?php Style_Inline(); ?>
</head>
<body>
    <style type="text/css">
    #send, #sell {display: none;}  
    .trade_menu span {background-color: #31B404; padding: 3px; border: 2px outset yellow; cursor: pointer;}
    .trade_menu span:hover {border: 2px inset red;}
    </style>
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">
    var send = 0;
    var sell = 0;
    
    /**********/
    
    function show_send_form() {
        $('#sell').slideUp(1000, function() {
            $('#send').slideDown(1000);
        });         
    }
    
    function show_sell_form() {
        $('#send').slideUp(1000, function() {
            $('#sell').slideDown(1000);
        });
    }
    
    <?php
    if($x_value != 0 && $y_value != 0)
        echo "window.onload = function() {show_send_form();}";
    ?>
    </script>
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
            <b><font color="red">Handlu jeszcze nie ma ale wyklepiemy jakoś na dniach.</font></b><br/>
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
       </table><br />
   
    <div class="trade_menu">
        <span onClick="javascript:show_send_form()">Wyślij surowce</span>&nbsp;&nbsp;<span onClick="javascript:show_sell_form()">Dodaj ogłoszenie</span>
    </div><br />
       
   <div id="send">
       <form method="POST">
           <table>
              <tr bgcolor=<?php Bg_Color_Three();?>>
                 <td>
                 <b>Wyślij surowce do:</b>
                 </td>
                 <td align="right"><i>                
                    <input type="hidden" name="l" value="trade_center">
                    X:
                    <input type="text" name="X" value="<?php echo $x_value; ?>" style="width: 60px">
                    Y:
                    <input type="text" name="Y" value="<?php echo $y_value; ?>" style="width: 60px">
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
       </form>
   </div>
   <div id="sell">       
       <form method="POST">
           <table>
              <tr bgcolor=<?php Bg_Color_Three();?>>
                 <td>
                 <b>Sprzedam:</b>
                 </td>
                 <td align="right">
                    <img src="img/wodka.png" alt="Wodka" width="30" height="30">
                    <input type="radio" name="item_for_sale" value="Vodka" style="width: 60px" />
                    <img src="img/kebab.png" alt="Kebab" width="30" height="30">
                    <input type="radio" name="item_for_sale" value="Kebab" style="width: 60px" />
                    <img src="img/wifi.png" alt="Wifi" width="30" height="30">
                    <input type="radio" name="item_for_sale" value="Wifi" style="width: 60px" />                    
                 </td>
              </tr>
              <tr bgcolor=<?php Bg_Color_Three();?>>
                 <td>
                    <b>Ilość:</b>
                 </td>
                 <td>
                    <input type="text" name="amount" />
                 </td>
              </tr>
              <tr bgcolor=<?php Bg_Color_Three();?>>
                <td>
                 <b>Zapłata w:</b>
                 </td>
                 <td align="right">
                    <img src="img/wodka.png" alt="Wodka" width="30" height="30">
                    <input type="radio" name="payment" value="Vodka" style="width: 60px" />
                    <img src="img/kebab.png" alt="Kebab" width="30" height="30">
                    <input type="radio" name="payment" value="Kebab" style="width: 60px" />
                    <img src="img/wifi.png" alt="Wifi" width="30" height="30">
                    <input type="radio" name="payment" value="Wifi" style="width: 60px" />                    
                 </td>
              </tr>
              <tr bgcolor=<?php Bg_Color_Three();?>>
                 <td>
                    <b>Cena:</b>
                 </td>
                 <td>
                    <input type="text" name="price" />
                 </td>
              </tr>
              <tr bgcolor=<?php Bg_Color_Three();?>>
                <td align="center" colspan="2">
                    <input type="submit" name="sell_ok" value="Wystaw ogłoszenie">
                </td>
              </tr>
           </table>
       </form>
   </div>

      <font size="4" color="yellow"><b>Ruchy twoich handlarzy</b></font>
      <table border=1>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td><b>Cel</b></td>
         <td><b>Liczba handlarzy</b></td>
         <td><b>Surowce</b></td>
         <td><b>Godzina przybycia</b></td>
      </tr> 
      <?php
      $No_Moves = 1;
      $SQL_String = "SELECT * FROM gs_trading_moves WHERE id_source=$ID_Campus OR id_destination=$ID_Campus";
      $Query = $Connect->Query($SQL_String);
      while ($Record = $Query->fetch_assoc())
      {
         if ($Record['going_back'] == 0 && $Record['id_destination'] == $ID_Campus) continue;
         if ($Record['going_back'] == 1 && $Record['id_source'] == $ID_Campus) continue;
         $No_Moves = 0;
         $ID_Destination = $Record['id_destination'];
         $SQL_String = "SELECT name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Destination";
         $Query_2 = $Connect->Query($SQL_String);
         $Record_2 = $Query_2->fetch_assoc();
         echo '<tr bgcolor='; Bg_Color_Three(); echo '>';
         if ($Record['id_destination'] == $ID_Campus) echo '<td><i>Powrót</i></td>';
         else echo '<td><i>'.$Record_2['name'].'('.$Record_2['x_coord'].'|'.$Record_2['y_coord'].')</i></td>';
         echo '<td><i>'.$Record['traders'].'</i></td>';
         echo '<td><i>'.'<img src="img/wodka.png" alt="Wodka" width="30" height="30">'.$Record['vodka'].'<img src="img/kebab.png" alt="Kebab" width="30" height="30">'.$Record['kebab'].'<img src="img/wifi.png" alt="Wifi" width="30" height="30">'.$Record['wifi'].'</i></td>';
         echo '<td><i>'.$Record['arrival_time'].'</i></td></tr>';
      }
      if ($No_Moves == 1)
      {
         echo '<tr bgcolor='; Bg_Color_Three(); echo '>';
         echo '<td><i>Brak</i></td>';  
         echo '<td><i>Brak</i></td>';  
         echo '<td><i>Brak</i></td>';  
         echo '<td><i>Brak</i></td></tr>';  
      }
      ?>
   </table>

   <font size="4" color="yellow"><b>Obcy handlarze zmierzający tutaj</b></font>
      <table border=1>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td><b>Pochodzenie</b></td>
         <td><b>Liczba handlarzy</b></td>
         <td><b>Surowce</b></td>
         <td><b>Godzina przybycia</b></td>
      </tr> 
      <?php
      $No_Moves = 1;
      $SQL_String = "SELECT * FROM gs_trading_moves WHERE id_destination=$ID_Campus AND going_back=0";
      $Query = $Connect->Query($SQL_String);
      while ($Record = $Query->fetch_assoc())
      {
         $No_Moves = 0;
         $ID_Source = $Record['id_source'];
         $SQL_String = "SELECT name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Source";
         $Query_2 = $Connect->Query($SQL_String);
         $Record_2 = $Query_2->fetch_assoc();
         echo '<tr bgcolor='; Bg_Color_Three(); echo '>';
         echo '<td><i>'.$Record_2['name'].'('.$Record_2['x_coord'].'|'.$Record_2['y_coord'].')</i></td>';
         echo '<td><i>'.$Record['traders'].'</i></td>';
         echo '<td><i>'.'<img src="img/wodka.png" alt="Wodka" width="30" height="30">'.$Record['vodka'].'<img src="img/kebab.png" alt="Kebab" width="30" height="30">'.$Record['kebab'].'<img src="img/wifi.png" alt="Wifi" width="30" height="30">'.$Record['wifi'].'</i></td>';
         echo '<td><i>'.$Record['arrival_time'].'</i></td></tr>';
      }
      if ($No_Moves == 1)
      {
         echo '<tr bgcolor='; Bg_Color_Three(); echo '>';
         echo '<td><i>Brak</i></td>';  
         echo '<td><i>Brak</i></td>';  
         echo '<td><i>Brak</i></td>';  
         echo '<td><i>Brak</i></td></tr>';  
      }
      ?>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>