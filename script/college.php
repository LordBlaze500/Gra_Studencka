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
$College = new Recrutation_Building('college', $ID_Campus);
$Master = new Force(new Troops_Type('master'), $ID_Army);
$Doctor = new Force(new Troops_Type('doctor'), $ID_Army);

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

if (isset($_POST['master_number']) && $College->Status_Getter() > 0)
{
   $Number = $_POST['master_number'];
   Recruiter($Master, $Number);
}

if (isset($_POST['doctor_number']) && $College->Status_Getter() > 1)
{
   $Number = $_POST['doctor_number'];
   Recruiter($Doctor, $Number);
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
            if ($College->Status_Getter() == 0) echo '<font size="5">WI1 (nie zbudowano)</font>';
            if ($College->Status_Getter() == 1) echo '<font size="5">WI1</font>';
            if ($College->Status_Getter() == 2) echo '<font size="5">WI2</font>';
            ?>
            <br/></b>
            <?php
            if ($College->Status_Getter() == 1) echo '<img src="img/wi1.png" alt="WI1" width="250" height="138">';
            if ($College->Status_Getter() == 2) echo '<img src="img/wi2.png" alt="WI2" width="250" height="138">'
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
            if ($College->Status_Getter() == 2) echo 'WI2 pozwala rekrutować magistrów i doktorów.';
            else echo 'WI1 pozwala rekrutować magistrów.';?>
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
         <td><i><a href="?l=master"><img src="img/magister.png" width="30" height="30">Magister</a></i></td>
         <td><i><center><img src="img/wodka.png" width="30" height="30">
            <?php
            echo $Master->Type_Getter()->Cost_Vodka_Getter();
            ?>
            <img src="img/kebab.png" width="30" height="30">
            <?php
            echo $Master->Type_Getter()->Cost_Kebab_Getter();
            ?>
            <img src="img/wifi.png" width="30" height="30"> 
            <?php
            echo $Master->Type_Getter()->Cost_Wifi_Getter();
            ?>
            </center></i></td>
         </td>
         <td><i><center>
            <?php
            echo $Master->Number_Getter(); 
            echo ' (';
            echo $Master->Number_In_Total_Getter();
            echo ')/';
            echo $Master->Maximum_Getter();
            ?>
            </center></i>
         </td>
         <td><i>
            <?php
            if ($College->Status_Getter() > 0)
            { 
               echo '<form method="POST">';
               echo '<input type="hidden" name="l" value="college">';
               echo '<input type="text" name="master_number">';
               echo '<input type="submit" value="Rekrutuj">';
               echo 'Max: ';
               echo $Master->Maximum_Possible();
               echo '</form>';
            }
            else echo 'Wymagane WI1';
            ?>
            </i>
         </td>
      </tr>
      <tr>
         <td><i><a href="?l=doctor"><img src="img/doktor.png" width="30" height="30">Doktor</a></i></td>
         <td><i><center>
            <img src="img/wodka.png" width="30" height="30">
            <?php
            echo $Doctor->Type_Getter()->Cost_Vodka_Getter();
            ?> 
            <img src="img/kebab.png" width="30" height="30"> 
            <?php
            echo $Doctor->Type_Getter()->Cost_Kebab_Getter();
            ?>
            <img src="img/wifi.png" width="30" height="30">
            <?php
            echo $Doctor->Type_Getter()->Cost_Wifi_Getter();
            ?>
            </center>
            </i>
         </td>
         <td><i><center>
            <?php
            echo $Doctor->Number_Getter();
            echo ' (';
            echo $Doctor->Number_In_Total_Getter();
            echo ')/';
            echo $Doctor->Maximum_Getter();
            ?>
            </center></i>
         </td>
         <td><i>
            <?php
            if ($College->Status_Getter() > 1)
            { 
               echo '<form method="POST">';
               echo '<input type="hidden" name="l" value="college">';
               echo '<input type="text" name="doctor_number">';
               echo '<input type="submit" value="Rekrutuj">';
               echo 'Max: ';
               echo $Doctor->Maximum_Possible();
               echo '</form>';  
            }
            else echo 'Wymagane WI2';
            ?>
            </i>
         </td>
      </tr>
</table>
<a href="?l=main">Powrót</a>
</center>



