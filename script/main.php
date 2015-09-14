<?php 
include "db_connect.php";
include "style.php";
include "building.php";
include "resource.php";
include "army.php";

$ID_Campus = $_SESSION['id_campus'];
if (!$ID_Campus) header('Location: index.php');
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
      
$z = "SELECT * FROM gs_messages WHERE seen = 0 AND addressee = (SELECT id_user FROM gs_users WHERE login = '".$_SESSION["login"]."')";
$q = $Connect->query($z);
$nowe_wiadomosci = $q->num_rows;   

$z = "SELECT * FROM gs_raports WHERE seen = 0 AND id_addressee = (SELECT id_user FROM gs_users WHERE login = '".$_SESSION["login"]."')";
$q = $Connect->query($z);
$nowe_raporty = $q->num_rows; 

$SQL_String = "SELECT id_army FROM gs_armies WHERE id_homecampus=$ID_Campus AND id_stayingcampus=$ID_Campus";
$Query = $Connect->Query($SQL_String);
$Record = $Query->fetch_assoc();
$ID_Army = $Record['id_army'];   

$Dormitory = new Recrutation_Building('dormitory', $ID_Campus);
$Transit = new Recrutation_Building('transit', $ID_Campus);
$College = new Recrutation_Building('college', $ID_Campus);
$Liquirstore = new Recrutation_Building('liquirstore', $ID_Campus);
$Parking = new Special_Building('parking', $ID_Campus);
$Bench = new Special_Building('bench', $ID_Campus);
$Terminus = new Special_Building('terminus', $ID_Campus);
$Cafe = new Recrutation_Building('cafe', $ID_Campus);
$Distillery = new Mining_Building('distillery', $ID_Campus);
$Doner = new Mining_Building('doner', $ID_Campus);
$Wifispot = new Mining_Building('wifispot', $ID_Campus);

$Vodka = new Resource('vodka', $ID_Campus);
$Kebab = new Resource('kebab', $ID_Campus);
$Wifi = new Resource('wifi', $ID_Campus);
$Army = new Army($ID_Army);
      
?>

<html>
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <title>Gra studencka</title>
   <link rel="icon" href="img/wodka.png" type="image/png">
   <style>
   table
   {
   border-collapse: collapse;
   }
   body {
   font-family:Georgia;
   }
   </style>
</head>
<body>
   <center>
   <table border=1 bgcolor=<?php Bg_Color_Three();?> style="border: 3px solid #0404B4;">
      <tr>
         <td style="border: 3px solid #0404B4;">
            <a href="?l=attacks"><img src="img/crossed_swords.png" alt="Ataki" width=50 height=50> 
            <?php
            $Attacks_Counter = 0;
            $SQL_String = "SELECT * FROM gs_moves WHERE id_destination=$ID_Campus AND strike=1"; 
            $Query = $Connect->Query($SQL_String);
            while ($Record = $Query->fetch_assoc())
            {
               $Attacks_Counter = $Attacks_Counter + 1;
            }
            if ($Attacks_Counter > 0) { echo '<b><font color=red>('; echo $Attacks_Counter; echo ')</font></b>'; }
            else echo '(0)';
            ?>
         </td>
         <td style="border: 3px solid #0404B4;">
            <?php
            $SQL_String = "SELECT name, x_coord, y_coord, obedience FROM gs_campuses WHERE id_campus=$ID_Campus";
            $Query = $Connect->Query($SQL_String);
            $Record = $Query->fetch_assoc();
            echo '<a href="?l=campus_info&id_campus=';
            echo $ID_Campus;
            echo '">';
            echo $Record['name'];
            echo ' ('; echo $Record['x_coord']; echo '|'; echo $Record['y_coord']; echo ')';
            echo '</a>';
            ?>
            <a href="?l=change_name"><img src="img/edytuj.png" alt="Edytuj" width="50" height="50"></a>
         </td>
         <td>
            <b><a href="?l=obedience"><img src="img/crown.png" alt="Poparcie" width="50" height="50">
            <?php 
            if ($Record['obedience'] < 100) echo '<font color="red">';
            echo $Record['obedience'];
            if ($Record['obedience'] < 100) echo '</font>';
            ?> </a></b>
         </td>
         <td style="border: 3px solid #0404B4;">
            <b>
            <img src="img/wodka.png" alt="Wodka" width="50" height="50">
            <?php
            if ($Vodka->Amount_Getter() == $Vodka->Maximum_Getter()) 
            {
               echo '<font color="red">';
               echo $Vodka->Amount_Getter(); 
               echo '</font>';
            }
            else echo $Vodka->Amount_Getter(); 
            ?>
            <img src="img/kebab.png" alt="Kebab" width="50" height="50">
            <?php
            if ($Kebab->Amount_Getter() == $Kebab->Maximum_Getter()) 
            {
               echo '<font color="red">';
               echo $Kebab->Amount_Getter(); 
               echo '</font>';
            }
            else echo $Kebab->Amount_Getter(); 
            ?>
            <img src="img/wifi.png" alt="Wifi" width="50" height="50">
            <?php
            if ($Wifi->Amount_Getter() == $Wifi->Maximum_Getter()) 
            {
               echo '<font color="red">';
               echo $Wifi->Amount_Getter(); 
               echo '</font>';
            }
            else echo $Wifi->Amount_Getter(); 
            ?>
            </b>
         </td>
         <td style="border: 3px solid #0404B4;">
            <a href="?l=trade_center"><img src="img/trade.png" alt="Handel" width="50" height="50"></a>
            <a href="?l=help"><img src="img/pomoc.png" alt="Raporty" width="50" height="50"></a>
            <a href="script/raports.php" target="window_iframe" onClick="javascript:Window_('#window', 550, 600, 'Raporty', 'on')"><img src="<?php echo ($nowe_raporty == 0) ? "img/noraport.png" : "img/raport.png"; ?>" alt="Raporty" width="50" height="50"></a>
            <a href="script/messages.php" target="window_iframe" onClick="javascript:Window_('#window', 350, 500, 'Wiadomości', 'on')"><img src="<?php echo ($nowe_wiadomosci == 0) ? "img/nomsg.png" : "img/newmsg.png"; ?>" alt="Wiadomosci" style="width:50px;height:50px;"></a>
            <a href="?l=campus_select"><img src="img/switch.png" alt="Zmien kampus" width="50" height="50"></a>
            <a href="?l=map"><img src="img/map.png" alt="Mapa" width="50" height="50"></a>
            <a href="?l=settings"><img src="img/ustawienia.png" alt="Ustawienia" width="50" height="50"></a>
            <a href="?logout=true"><img src="img/logout.png" alt="Wyloguj" width="50" height="50"></a>
         </td>
      </tr>
   </table>
   <table bgcolor=<?php Bg_Color_Three();?> style="border: 3px solid #0404B4;">
      <tr>
         <td>
            <a href="?l=student">
            <img src="img/student.png" alt="Student" width="50" height="50">
            <?php
            $SQL_String_2 = "SELECT sum(student) AS sum FROM gs_armies WHERE id_stayingcampus=$ID_Campus";
            $Query_2 = $Connect->Query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            echo $Record_2['sum'];
            ?>
            </a>
            <a href="?l=parachute">
            <img src="img/spadochroniarz.png" alt="Spadochroniarz" width="50" height="50">
            <?php
            $SQL_String_2 = "SELECT sum(parachute) AS sum FROM gs_armies WHERE id_stayingcampus=$ID_Campus";
            $Query_2 = $Connect->Query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            echo $Record_2['sum'];
            ?>
            </a>
            <a href="?l=drunkard">
            <img src="img/menel.png" alt="Menel" width="50" height="50">
            <?php
            $SQL_String_2 = "SELECT sum(drunkard) AS sum FROM gs_armies WHERE id_stayingcampus=$ID_Campus";
            $Query_2 = $Connect->Query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            echo $Record_2['sum'];
            ?>
            </a>
            <a href="?l=clochard">
            <img src="img/kloszard.png" alt="Kloszard" width="50" height="50">
            <?php
            $SQL_String_2 = "SELECT sum(clochard) AS sum FROM gs_armies WHERE id_stayingcampus=$ID_Campus";
            $Query_2 = $Connect->Query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            echo $Record_2['sum'];
            ?>
            </a>
            <a href="?l=nerd">
            <img src="img/nerd.png" alt="Nerd" width="50" height="50">
            <?php
            $SQL_String_2 = "SELECT sum(nerd) AS sum FROM gs_armies WHERE id_stayingcampus=$ID_Campus";
            $Query_2 = $Connect->Query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            echo $Record_2['sum'];
            ?>
            </a>
            <a href="?l=stooley">
            <img src="img/stulejarz.png" alt="Stulejarz" width="50" height="50">
            <?php
            $SQL_String_2 = "SELECT sum(stooley) AS sum FROM gs_armies WHERE id_stayingcampus=$ID_Campus";
            $Query_2 = $Connect->Query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            echo $Record_2['sum'];
            ?>
            </a>
            <a href="?l=master">
            <img src="img/magister.png" alt="Magister" width="50" height="50">
            <?php
            $SQL_String_2 = "SELECT sum(master) AS sum FROM gs_armies WHERE id_stayingcampus=$ID_Campus";
            $Query_2 = $Connect->Query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            echo $Record_2['sum'];
            ?>
            </a>
            <a href="?l=doctor">
            <img src="img/doktor.png" alt="Doktor" width="50" height="50">
            <?php
            $SQL_String_2 = "SELECT sum(doctor) AS sum FROM gs_armies WHERE id_stayingcampus=$ID_Campus";
            $Query_2 = $Connect->Query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            echo $Record_2['sum'];
            ?>
            </a>
            <a href="?l=inspector">
            <img src="img/kanar.png" alt="Kanar" width="50" height="50">
            <?php
            $SQL_String_2 = "SELECT sum(inspector) AS sum FROM gs_armies WHERE id_stayingcampus=$ID_Campus";
            $Query_2 = $Connect->Query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            echo $Record_2['sum'];
            ?>
            </a>
            <a href="?l=veteran">
            <img src="img/weteran.png" alt="Kanar weteran" width="50" height="50">
            <?php
            $SQL_String_2 = "SELECT sum(veteran) AS sum FROM gs_armies WHERE id_stayingcampus=$ID_Campus";
            $Query_2 = $Connect->Query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            echo $Record_2['sum'];
            ?>
            </a>
         </td>
      </tr>
   </table>
   <table bgcolor="#BDBDBD">
      <tr align="center">
         <td>
            <?php 
            if($Dormitory->Status_Getter() == 0) echo '<img src="img/akademiknull.png" alt="Akademik" width="230" height="148">';
            if($Dormitory->Status_Getter() == 1) echo '<a href="?l=dormitory"><img src="img/akademikpasnik.png" alt="Akademik" width="230" height="148"></a>';
            if($Dormitory->Status_Getter() == 2) echo '<a href="?l=dormitory"><img src="img/akademikupgraded.png" alt="Akademik" width="230" height="148"></a>';
            ?> 
         </td>
         <td>
            <?php
            if($Transit->Status_Getter() == 0) echo '<img src="img/autobusynull.png" width="377" height="128">';
            if($Transit->Status_Getter() == 1) echo '<a href="?l=transit"><img src="img/autobusy.png" alt="Autobusy" width="377" height="128"></a>';
            if($Transit->Status_Getter() == 2) echo '<a href="?l=transit"><img src="img/tramwaj.png" alt="Tramwaj" width="377" height="128"></a>';
            ?> 
         </td>
         <td>
            <?php                                                
            if($College->Status_Getter() == 0) echo '<img src="img/wi1null.png" width="250" height="138">';
            if($College->Status_Getter() == 1) echo '<a href="?l=college"><img src="img/wi1.png" alt="WI1" width="250" height="138"></a>';
            if($College->Status_Getter() == 2) echo '<a href="?l=college"><img src="img/wi2.png" alt="WI2" width="250" height="138"></a>';
            ?> 
         </td>
      </tr>
      <tr align="center">
         <td>
            <?php                                                
            if($Liquirstore->Status_Getter() == 0) echo '<img src="img/monopolnull.png" width="293" height="163">';
            if($Liquirstore->Status_Getter() == 1) echo '<a href="?l=liquirstore"><img src="img/monopol.png" alt="Monopolowy" width="293" height="163"></a>';
            if($Liquirstore->Status_Getter() == 2) echo '<a href="?l=liquirstore"><img src="img/monopol24.png" alt="Monopolowy 24h" width="293" height="163"></a>';
            ?>
         </td>
         <td>
            <a href="?l=rektorat"><img src="img/rektorat.png" alt="Rektorat" width="351" height="175"></a>
         </td>
         <td>
            <?php                                                
            if($Parking->Status_Getter() == 0) echo '<img src="img/parkingnull.png" alt="Parking" width="251" height="181">';
            if($Parking->Status_Getter() == 1) echo '<a href="?l=parking"><img src="img/parking.png" alt="Parking" width="251" height="181"></a>';
            ?> 
         </td>
      </tr>
      <tr align="center">
         <td>
            <?php                                          
            if($Bench->Status_Getter() == 0) echo '<img src="img/laweczkanull.png" alt="Laweczka" width="234" height="111">';
            if($Bench->Status_Getter() == 1) echo '<a href="?l=bench"><img src="img/laweczka.png" alt="Laweczka" width="234" height="111"></a>';
            ?> 
         </td>
         <td>
            <?php                                                
            if($Terminus->Status_Getter() == 0) echo '<img src="img/zajezdnianull.png" alt="Zajezdnia" width="386" height="118">';
            if($Terminus->Status_Getter() == 1) echo '<a href="?l=terminus"><img src="img/zajezdnia.png" alt="Zajezdnia" width="386" height="118"></a>';
            ?> 
         </td>
         <td>
            <?php                                                
            if($Cafe->Status_Getter() == 0) echo '<img src="img/cafenull.png" width="168" height="129">';
            if($Cafe->Status_Getter() == 1) echo '<a href="?l=cafe"><img src="img/cafe.png" alt="E-Kafejka" width="168" height="129"></a>';
            if($Cafe->Status_Getter() == 2) echo '<a href="?l=cafe"><img src="img/cafebetter.png" alt="Ulepszona e-Kafejka" width="168" height="129"></a>';
            ?> 
         </td>
      </tr>
      <tr align="center">
         <td>
            <a href="?l=distillery"><img src="img/gorzelnia.png" alt="Gorzelnia" width="250" height="162"></a>
         </td>
         <td>
            <a href="?l=wifispot"><img src="img/spotwifi.png" alt="Spot wifi" width="132" height="161"></a>
         </td>
         <td>
            <a href="?l=doner"><img src="img/doner.png" alt="Doner" width="208" height="150"></a>
         </td>
      </tr>
   </table>
   </center>
   <?php $Connect->Close(); ?>
</body>
</html>
