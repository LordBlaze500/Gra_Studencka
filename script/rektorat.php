<?php
include "building.php";
include "resource.php";
include "style.php";

$ID_Campus = $_SESSION['id_campus'];
if (!$ID_Campus) header('Location: index.php');

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

if(isset($_GET['tobuild']))
{
   switch ($_GET['tobuild'])
   {
      case 'dormitory':
      Builder($Dormitory);
      break;
      case 'transit':
      Builder($Transit);
      break;
      case 'college':
      Builder($College);
      break;
      case 'liquirstore':
      Builder($Liquirstore);
      break;
      case 'parking':
      Builder($Parking);
      break;
      case 'bench':
      Builder($Bench);
      break;
      case 'terminus':
      Builder($Terminus);
      break;
      case 'cafe':
      Builder($Cafe);
      break;
      case 'distillery':
      Builder($Distillery);
      break;
      case 'wifispot':
      Builder($Wifispot);
      break;
      case 'doner':
      Builder($Doner);
      break;
      default: echo 'Nieznany budynek';
   }
}

function Builder($Building)
{
   $Result = $Building->Build();
   if ($Result == 0)
   {
      $_POST['info'] = "built";
      header('Location: index.php?l=rektorat');
   } 
   if ($Result == 1)
   {
      $_POST['info'] = "alreadybuilt";
      header('Location: index.php?l=rektorat');
   } 
   if ($Result == 2)
   {
      $_POST['info'] = "noresources";
      header('Location: index.php?l=rektorat');
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
            <center><b><font size="5">Rektorat</font></b><br/>
            <img src="img/rektorat.png" alt="Rektorat" width="301" height="135"><br/>
            </center>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td></br><i>Rektorat pozwala na rozbudowę kampusu.</i></br></br></td>
      </tr>
   </table>

   <?php
   if (isset($_POST['info']))
   {
      switch ($_POST['info'])
      {
      case 'built':
         echo '<b><font size=5 color="yellow"> Zbudowane </font></b>';
         break;
      case 'alreadybuilt': 
         echo '<b><font size=5 color="yellow"> Ten budynek już istnieje </font></b>';
         break;
      case 'noresources': 
         echo '<b><font size=5 color="yellow"> Za mało surowców </font></b>';
         break;
      } 
   }
   ?>

   <table border=1>
      <tr align="center" bgcolor=<?php Bg_Color_Three();?>>
         <td><b>Nazwa</b></td>
         <td>
            <img src="img/wodka.png" alt="Wodka" height="40" width="40"> <?php echo $Vodka->Amount_Getter();?>
         </td>
         <td>
            <img src="img/kebab.png" alt="Kebab" height="40" width="40"> <?php echo $Kebab->Amount_Getter();?>
         </td>
         <td>
         <img src="img/wifi.png" alt="Wifi" height="40" width="40"> <?php echo $Wifi->Amount_Getter();?>
         </td>
         <td><b>Budowa</b></td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Three();?>>
         <td> 
            <?php 
            echo '<a href="?l=dormitory">';
            if ($Dormitory->Status_Getter() == 0) echo 'Akademik';
            else echo 'Akademik po remoncie';
            echo '</a>';
            ?>
         </td>
         <td>
         <?php
         echo $Dormitory->Vodka_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Dormitory->Kebab_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Dormitory->Wifi_Needed_Getter();
         ?>
         </td>
         <td>
         <?php 
         if ($Dormitory->Status_Getter() == 2) echo 'Zbudowane';
         if ($Dormitory->Status_Getter() == 1) echo '<a href="index.php?l=rektorat&tobuild=dormitory">Ulepsz</a>';
         if ($Dormitory->Status_Getter() == 0) echo '<a href="index.php?l=rektorat&tobuild=dormitory">Buduj</a>';?>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Three();?>>
         <td> 
            <?php 
            echo '<a href="?l=transit">';
            if ($Transit->Status_Getter() == 0) echo 'Autobusy';
            else echo 'Tramwaje';
            echo '</a>';
            ?>
         </td>
         <td>
         <?php
         echo $Transit->Vodka_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Transit->Kebab_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Transit->Wifi_Needed_Getter();
         ?>
         </td>
         <td>
         <?php 
         if ($Transit->Status_Getter() == 2) echo 'Zbudowane';
         if ($Transit->Status_Getter() == 1) echo '<a href="index.php?l=rektorat&tobuild=transit">Ulepsz</a>';
         if ($Transit->Status_Getter() == 0) echo '<a href="index.php?l=rektorat&tobuild=transit">Buduj</a>';?>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Three();?>>
         <td> 
            <?php 
            echo '<a href="?l=college">';
            if ($College->Status_Getter() == 0) echo 'WI1';
            else echo 'WI2';
            echo '</a>';
            ?>
         </td>
         <td>
         <?php
         echo $College->Vodka_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $College->Kebab_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $College->Wifi_Needed_Getter();
         ?>
         </td>
         <td>
         <?php 
         if ($College->Status_Getter() == 2) echo 'Zbudowane';
         if ($College->Status_Getter() == 1) echo '<a href="index.php?l=rektorat&tobuild=college">Ulepsz</a>';
         if ($College->Status_Getter() == 0) echo '<a href="index.php?l=rektorat&tobuild=college">Buduj</a>';?>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Three();?>>
         <td> 
            <?php 
            echo '<a href="?l=liquirstore">';
            if ($Liquirstore->Status_Getter() == 0) echo 'Monopolowy';
            else echo 'Monopolowy 24h';
            echo '</a>';
            ?>
         </td>
         <td>
         <?php
         echo $Liquirstore->Vodka_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Liquirstore->Kebab_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Liquirstore->Wifi_Needed_Getter();
         ?>
         </td>
         <td>
         <?php 
         if ($Liquirstore->Status_Getter() == 2) echo 'Zbudowane';
         if ($Liquirstore->Status_Getter() == 1) echo '<a href="index.php?l=rektorat&tobuild=liquirstore">Ulepsz</a>';
         if ($Liquirstore->Status_Getter() == 0) echo '<a href="index.php?l=rektorat&tobuild=liquirstore">Buduj</a>';?>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Three();?>>
         <td> 
         <a href="?l=parking">Parking</a>
         </td>
         <td>
         <?php
         echo $Parking->Vodka_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Parking->Kebab_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Parking->Wifi_Needed_Getter();
         ?>
         </td>
         <td>
         <?php 
         if ($Parking->Status_Getter() == 1) echo 'Zbudowane';
         if ($Parking->Status_Getter() == 0) echo '<a href="index.php?l=rektorat&tobuild=parking">Buduj</a>';?>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Three();?>>
         <td> 
         <a href="?l=bench">Ławeczka</a>
         </td>
         <td>
         <?php
         echo $Bench->Vodka_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Bench->Kebab_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Bench->Wifi_Needed_Getter();
         ?>
         </td>
         <td>
         <?php 
         if ($Bench->Status_Getter() == 1) echo 'Zbudowane';
         if ($Bench->Status_Getter() == 0) echo '<a href="index.php?l=rektorat&tobuild=bench">Buduj</a>';?>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Three();?>>
         <td> 
         <a href="?l=terminus">Zajezdnia</a>
         </td>
         <td>
         <?php
         echo $Terminus->Vodka_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Terminus->Kebab_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Terminus->Wifi_Needed_Getter();
         ?>
         </td>
         <td>
         <?php 
         if ($Terminus->Status_Getter() == 1) echo 'Zbudowane';
         if ($Terminus->Status_Getter() == 0) echo '<a href="index.php?l=rektorat&tobuild=terminus">Buduj</a>';?>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Three();?>>
         <td> 
            <?php 
            echo '<a href="?l=cafe">';
            if ($Cafe->Status_Getter() == 0) echo 'E-Kafejka';
            else echo 'Ulepszona E-Kafejka';
            echo '</a>';
            ?>
         </td>
         <td>
         <?php
         echo $Cafe->Vodka_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Cafe->Kebab_Needed_Getter();
         ?>
         </td>
         <td>
         <?php
         echo $Cafe->Wifi_Needed_Getter();
         ?>
         </td>
         <td>
         <?php 
         if ($Cafe->Status_Getter() == 2) echo 'Zbudowane';
         if ($Cafe->Status_Getter() == 1) echo '<a href="index.php?l=rektorat&tobuild=cafe">Ulepsz</a>';
         if ($Cafe->Status_Getter() == 0) echo '<a href="index.php?l=rektorat&tobuild=cafe">Buduj</a>';?>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Three();?>>
         <td><a href="?l=distillery">Gorzelnia poziom
            <?php
            if ($Distillery->Level_Getter() < 10) echo $Distillery->Level_Getter()+1;
            else echo '10';
            ?>
            </a>
         </td>
         <td>
            <?php
            echo $Distillery->Vodka_Needed_Getter();
            ?>
         </td>
         <td>
            <?php
            echo $Distillery->Kebab_Needed_Getter();
            ?>
         </td>
         <td>
            <?php
            echo $Distillery->Wifi_Needed_Getter();
            ?>
         </td>
         <td>
            <?php 
            if ($Distillery->Level_Getter() == 10) echo 'Zbudowane';
            else echo '<a href="index.php?l=rektorat&tobuild=distillery">Ulepsz</a>';
            ?>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Three();?>>
         <td><a href="?l=wifispot"> Spot WiFi poziom
            <?php
            if ($Wifispot->Level_Getter() < 10) echo $Wifispot->Level_Getter()+1;
            else echo '10';
            ?>
            </a>
         </td>
         <td>
            <?php
            echo $Wifispot->Vodka_Needed_Getter();
            ?>
         </td>
         <td>
            <?php
            echo $Wifispot->Kebab_Needed_Getter();
            ?>
         </td>
         <td>
            <?php
            echo $Wifispot->Wifi_Needed_Getter();
            ?>
         </td>
         <td>
            <?php 
            if ($Wifispot->Level_Getter() == 10) echo 'Zbudowane';
            else echo '<a href="index.php?l=rektorat&tobuild=wifispot">Ulepsz</a>';
            ?>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Three();?>>
         <td> <a href="?l=doner">Doner poziom
            <?php
            if ($Doner->Level_Getter() < 10) echo $Doner->Level_Getter()+1;
            else echo '10';
            ?>
            </a>
         </td>
         <td>
            <?php
            echo $Doner->Vodka_Needed_Getter();
            ?>
         </td>
         <td>
            <?php
            echo $Doner->Kebab_Needed_Getter();
            ?>
         </td>
         <td>
            <?php
            echo $Doner->Wifi_Needed_Getter();
            ?>
         </td>
         <td>
            <?php 
            if ($Doner->Level_Getter() == 10) echo 'Zbudowane';
            else echo '<a href="index.php?l=rektorat&tobuild=doner">Ulepsz</a>';
            ?>
         </td>
      </tr>
   </table>
   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>