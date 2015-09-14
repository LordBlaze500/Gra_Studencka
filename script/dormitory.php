<?php
include "db_connect.php";
include "building.php";
include "army.php";
include "resource.php";
include "style.php";

$ID_Campus = $_SESSION['id_campus'];
if (!$ID_Campus) header('Location: index.php');
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
$SQL_String = "SELECT id_army FROM gs_armies WHERE id_homecampus=$ID_Campus AND id_stayingcampus=$ID_Campus";
$Query = $Connect->Query($SQL_String);
$Record = $Query->fetch_assoc();
$ID_Army = $Record['id_army'];
$Dormitory = new Recrutation_Building('dormitory', $ID_Campus);
$Student = new Force(new Troops_Type('student'), $ID_Army);
$Parachute = new Force(new Troops_Type('parachute'), $ID_Army);

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

if (isset($_POST['student_number']) && $Dormitory->Status_Getter() > 0)
{
   $Number = $_POST['student_number'];
   Recruiter($Student, $Number);
}

if (isset($_POST['parachute_number']) && $Dormitory->Status_Getter() > 1)
{
   $Number = $_POST['parachute_number'];
   Recruiter($Parachute, $Number);
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
            if ($Dormitory->Status_Getter() == 0) echo '<font size="5">Akademik (nie zbudowano)</font>';
            if ($Dormitory->Status_Getter() == 1) echo '<font size="5">Akademik</font>';
            if ($Dormitory->Status_Getter() == 2) echo '<font size="5">Akademik po remoncie</font>';
            ?>
            <br/></b>
            <?php
            if ($Dormitory->Status_Getter() == 1) echo '<img src="img/akademikpasnik.png" alt="Akademik" width="230" height="148">';
            if ($Dormitory->Status_Getter() == 2) echo '<img src="img/akademikupgraded.png" alt="Akademik" width="230" height="148">'
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
            if ($Dormitory->Status_Getter() == 2) echo 'Akademik po remoncie pozwala rekrutować studentów i studentów spadochroniarzy.';
            else echo 'Akademik pozwala rekrutować studentów.';?>
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
         <td><i><a href="?l=student"><img src="img/student.png" width="30" height="30">Student</a></i></td>
         <td><i><center><img src="img/wodka.png" width="30" height="30">
            <?php
            echo $Student->Type_Getter()->Cost_Vodka_Getter();
            ?>
            <img src="img/kebab.png" width="30" height="30">
            <?php
            echo $Student->Type_Getter()->Cost_Kebab_Getter();
            ?>
            <img src="img/wifi.png" width="30" height="30"> 
            <?php
            echo $Student->Type_Getter()->Cost_Wifi_Getter();
            ?>
            </center></i></td>
         </td>
         <td><i><center>
            <?php
            echo $Student->Number_Getter(); 
            echo ' (';
            echo $Student->Number_In_Total_Getter();
            echo ')/';
            echo $Student->Maximum_Getter();
            ?>
            </center></i>
         </td>
         <td><i>
            <?php
            if ($Dormitory->Status_Getter() > 0)
            { 
               echo '<form method="POST">';
               echo '<input type="hidden" name="l" value="dormitory">';
               echo '<input type="text" name="student_number">';
               echo '<input type="submit" value="Rekrutuj">';
               echo 'Max: ';
               echo $Student->Maximum_Possible();
               echo '</form>';
            }
            else echo 'Wymagany akademik';
            ?>
            </i>
         </td>
      </tr>
      <tr>
         <td><i><a href="?l=parachute"><img src="img/spadochroniarz.png" width="30" height="30">Student spadochroniarz</a></i></td>
         <td><i><center>
            <img src="img/wodka.png" width="30" height="30">
            <?php
            echo $Parachute->Type_Getter()->Cost_Vodka_Getter();
            ?> 
            <img src="img/kebab.png" width="30" height="30"> 
            <?php
            echo $Parachute->Type_Getter()->Cost_Kebab_Getter();
            ?>
            <img src="img/wifi.png" width="30" height="30">
            <?php
            echo $Parachute->Type_Getter()->Cost_Wifi_Getter();
            ?>
            </center>
            </i>
         </td>
         <td><i><center>
            <?php
            echo $Parachute->Number_Getter();
            echo ' (';
            echo $Parachute->Number_In_Total_Getter();
            echo ')/';
            echo $Parachute->Maximum_Getter();
            ?>
            </center></i>
         </td>
         <td><i>
            <?php
            if ($Dormitory->Status_Getter() > 1)
            { 
               echo '<form method="POST">';
               echo '<input type="hidden" name="l" value="dormitory">';
               echo '<input type="text" name="parachute_number">';
               echo '<input type="submit" value="Rekrutuj">';
               echo 'Max: ';
               echo $Parachute->Maximum_Possible();
               echo '</form>';  
            }
            else echo 'Wymagany akademik po remoncie';
            ?>
            </i>
         </td>
      </tr>

</center>
</table>

<a href="?l=main">Powrót</a>

</center>
</html>