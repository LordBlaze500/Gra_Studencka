<?php
include "db_connect.php";
include "building.php";
include "army.php";
include "resource.php";
include "style.php";

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
$SQL_String = "SELECT id_army FROM gs_armies WHERE id_homecampus=$ID_Campus AND id_stayingcampus=$ID_Campus";
$Query = $Connect->Query($SQL_String);
$Record = $Query->fetch_assoc();
$ID_Army = $Record['id_army'];
$Liquirstore = new Recrutation_Building('liquirstore', $ID_Campus);
$Drunkard = new Force(new Troops_Type('drunkard'), $ID_Army);
$Clochard = new Force(new Troops_Type('clochard'), $ID_Army);

function Recruiter($Troop, $Number)
{
   $Result = $Troop->Recruit($Number);
   if ($Result == 1) 
   {
      $_POST['info'] = "recruited";
   }
   if ($Result == 2) 
   {
      $_POST['info'] = "noresources";
   }
   if ($Result == 3) 
   {
      $_POST['info'] = "nospace";
   }
}

if (isset($_POST['drunkard_number']) && $Liquirstore->Status_Getter() > 0)
{
   $Number = $_POST['drunkard_number'];
   Recruiter($Drunkard, $Number);
}

if (isset($_POST['clochard_number']) && $Liquirstore->Status_Getter() > 1)
{
   $Number = $_POST['clochard_number'];
   Recruiter($Clochard, $Number);
}
$Vodka = new Resource('vodka', $ID_Campus);
$Kebab = new Resource('kebab', $ID_Campus);
$Wifi = new Resource('wifi', $ID_Campus);
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
            <center><b>
            <?php
            if ($Liquirstore->Status_Getter() == 0) echo '<font size="5">Monopolowy (nie zbudowano)</font>';
            if ($Liquirstore->Status_Getter() == 1) echo '<font size="5">Monopolowy</font>';
            if ($Liquirstore->Status_Getter() == 2) echo '<font size="5">Monopolowy 24h</font>';
            ?>
            <br/></b>
            <?php
            if ($Liquirstore->Status_Getter() == 1) echo '<img src="img/monopol.png" alt="Monopolowy" width="293" height="163">';
            if ($Liquirstore->Status_Getter() == 2) echo '<img src="img/monopol24.png" alt="Monopolowy" width="293" height="163">'
            ?>
            <br/>
            </center>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?> >
         <td>
            <center>
            </br><i>
            <?php
            if ($Liquirstore->Status_Getter() == 2) echo 'Monopolowy 24h pozwala rekrutować meneli i kloszardów.';
            else echo 'Monopolowy pozwala rekrutować meneli.';?>
            </i></br></br>
            </center>
         </td>
      </tr>
   </table>

   <?php 
   if (isset($_POST['info']))
   {
      $Info = $_POST['info'];
      switch ($Info)
      {
      case "recruited": echo '<b><font size="4" color="yellow">Jednostki zrekrutowane</font></b>'; break;
      case "noresources": echo '<b><font size="4" color="yellow">Za mało surowców</font></b>'; break;
      case "nospace": echo '<b><font size="4" color="yellow">Za mały limit jednostek</font></b>'; break;
      }
   }
   ?>

   <table border=1 bgcolor=<?php Bg_Color_Three();?>>
      <tr>
         <td>
            <center><b><img src="img/wodka.png" width="50" height="50"><?php echo $Vodka->Amount_Getter(); ?> <img src="img/kebab.png" width="50" height="50"><?php echo $Kebab->Amount_Getter(); ?> <img src="img/wifi.png" width="50" height="50"><?php echo $Wifi->Amount_Getter(); ?></b></center>
         </td>
      </tr>
   </table>

   <table border=1 bgcolor=<?php Bg_Color_Three();?>>
      <tr>
         <td><center><b>Nazwa</b></center></td>
         <td><center><b>Koszt</b></center></td>
         <td><center><b>Obecnie/Maksimum</b></center></td>
         <td><center><b>Rekrutacja</b></center></td>
      </tr>
      <tr>
         <td><i><a href="?l=drunkard"><img src="img/menel.png" width="30" height="30">Menel</a></i></td>
         <td><i><center><img src="img/wodka.png" width="30" height="30">
            <?php
            echo $Drunkard->Type_Getter()->Cost_Vodka_Getter();
            ?>
            <img src="img/kebab.png" width="30" height="30">
            <?php
            echo $Drunkard->Type_Getter()->Cost_Kebab_Getter();
            ?>
            <img src="img/wifi.png" width="30" height="30"> 
            <?php
            echo $Drunkard->Type_Getter()->Cost_Wifi_Getter();
            ?>
            </center></i></td>
         </td>
         <td><i><center>
            <?php
            echo $Drunkard->Number_Getter(); 
            echo ' (';
            echo $Drunkard->Number_In_Total_Getter();
            echo ')/';
            echo $Drunkard->Maximum_Getter();
            ?>
            </center></i>
         </td>
         <td><i>
            <?php
            if ($Liquirstore->Status_Getter() > 0)
            { 
               echo '<form method="POST">';
               echo '<input type="hidden" name="l" value="liquirstore">';
               echo '<input type="text" name="drunkard_number">';
               echo '<input type="submit" value="Rekrutuj">';
               echo 'Max: ';
               echo $Drunkard->Maximum_Possible();
               echo '</form>';
            }
            else echo 'Wymagany monopolowy';
            ?>
            </i>
         </td>
      </tr>
      <tr>
         <td><i><a href="?l=clochard"><img src="img/kloszard.png" width="30" height="30">Kloszard</a></i></td>
         <td><i><center>
            <img src="img/wodka.png" width="30" height="30">
            <?php
            echo $Clochard->Type_Getter()->Cost_Vodka_Getter();
            ?> 
            <img src="img/kebab.png" width="30" height="30"> 
            <?php
            echo $Clochard->Type_Getter()->Cost_Kebab_Getter();
            ?>
            <img src="img/wifi.png" width="30" height="30">
            <?php
            echo $Clochard->Type_Getter()->Cost_Wifi_Getter();
            ?>
            </center>
            </i>
         </td>
         <td><i><center>
            <?php
            echo $Clochard->Number_Getter();
            echo ' (';
            echo $Clochard->Number_In_Total_Getter();
            echo ')/';
            echo $Clochard->Maximum_Getter();
            ?>
            </center></i>
         </td>
         <td><i>
            <?php
            if ($Liquirstore->Status_Getter() > 1)
            { 
               echo '<form method="POST">';
               echo '<input type="hidden" name="l" value="liquirstore">';
               echo '<input type="text" name="clochard_number">';
               echo '<input type="submit" value="Rekrutuj">';
               echo 'Max: ';
               echo $Clochard->Maximum_Possible();
               echo '</form>';  
            }
            else echo 'Wymagany monopolowy 24h';
            ?>
            </i>
         </td>
      </tr>

</center>
</table>

<a href="?l=main">Powrót</a>

</center>
</html>