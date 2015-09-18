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
$Transit = new Recrutation_Building('transit', $ID_Campus);
$Inspector = new Force(new Troops_Type('inspector'), $ID_Army);
$Veteran = new Force(new Troops_Type('veteran'), $ID_Army);

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

if (isset($_POST['inspector_number']) && $Transit->Status_Getter() > 0)
{
   $Number = $_POST['inspector_number'];
   Recruiter($Inspector, $Number);
}

if (isset($_POST['veteran_number']) && $Transit->Status_Getter() > 1)
{
   $Number = $_POST['veteran_number'];
   Recruiter($Veteran, $Number);
}
$Vodka = new Resource('vodka', $ID_Campus);
$Kebab = new Resource('kebab', $ID_Campus);
$Wifi = new Resource('wifi', $ID_Campus);
?>

   <center>
   <table border=1>
      <tr bgcolor=<?php Bg_Color_One();?>>
         <td>
            <center><b>
            <?php
            if ($Transit->Status_Getter() == 0) echo '<font size="5">Autobusy (nie zbudowano)</font>';
            if ($Transit->Status_Getter() == 1) echo '<font size="5">Autobusy</font>';
            if ($Transit->Status_Getter() == 2) echo '<font size="5">Tramwaje</font>';
            ?>
            <br/></b>
            <?php
            if ($Transit->Status_Getter() == 1) echo '<img src="img/autobusy.png" alt="Autobusy" width="377" height="128">';
            if ($Transit->Status_Getter() == 2) echo '<img src="img/tramwaj.png" alt="Tramwaj" width="377" height="128">'
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
            if ($Transit->Status_Getter() == 2) echo 'Tramwaje pozwalają rekrutować kanarów i kanarów weteranów.';
            else echo 'Autobusy pozwalają rekrutować kanarów.';?>
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
         <td><i><a href="?l=inspector"><img src="img/kanar.png" width="30" height="30">Kanar</a></i></td>
         <td><i><center><img src="img/wodka.png" width="30" height="30">
            <?php
            echo $Inspector->Type_Getter()->Cost_Vodka_Getter();
            ?>
            <img src="img/kebab.png" width="30" height="30">
            <?php
            echo $Inspector->Type_Getter()->Cost_Kebab_Getter();
            ?>
            <img src="img/wifi.png" width="30" height="30"> 
            <?php
            echo $Inspector->Type_Getter()->Cost_Wifi_Getter();
            ?>
            </center></i></td>
         </td>
         <td><i><center>
            <?php
            echo $Inspector->Number_Getter(); 
            echo ' (';
            echo $Inspector->Number_In_Total_Getter();
            echo ')/';
            echo $Inspector->Maximum_Getter();
            ?>
            </center></i>
         </td>
         <td><i>
            <?php
            if ($Transit->Status_Getter() > 0)
            { 
               echo '<form method="POST">';
               echo '<input type="hidden" name="l" value="transit">';
               echo '<input type="text" name="inspector_number">';
               echo '<input type="submit" value="Rekrutuj">';
               echo 'Max: ';
               echo $Inspector->Maximum_Possible();
               echo '</form>';
            }
            else echo 'Wymagane autobusy';
            ?>
            </i>
         </td>
      </tr>
      <tr>
         <td><i><a href="?l=veteran"><img src="img/weteran.png" width="30" height="30">Kanar weteran</a></i></td>
         <td><i><center>
            <img src="img/wodka.png" width="30" height="30">
            <?php
            echo $Veteran->Type_Getter()->Cost_Vodka_Getter();
            ?> 
            <img src="img/kebab.png" width="30" height="30"> 
            <?php
            echo $Veteran->Type_Getter()->Cost_Kebab_Getter();
            ?>
            <img src="img/wifi.png" width="30" height="30">
            <?php
            echo $Veteran->Type_Getter()->Cost_Wifi_Getter();
            ?>
            </center>
            </i>
         </td>
         <td><i><center>
            <?php
            echo $Veteran->Number_Getter();
            echo ' (';
            echo $Veteran->Number_In_Total_Getter();
            echo ')/';
            echo $Veteran->Maximum_Getter();
            ?>
            </center></i>
         </td>
         <td><i>
            <?php
            if ($Transit->Status_Getter() > 1)
            { 
               echo '<form method="POST">';
               echo '<input type="hidden" name="l" value="transit">';
               echo '<input type="text" name="veteran_number">';
               echo '<input type="submit" value="Rekrutuj">';
               echo 'Max: ';
               echo $Veteran->Maximum_Possible();
               echo '</form>';
            }
            else echo 'Wymagane tramwaje';
            ?>
            </i>
         </td>
      </tr>
</table>
<a href="?l=main">Powrót</a>
</center>