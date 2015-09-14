<?php 
include "db_connect.php";
include "style.php";
include "army.php";

$ID_Campus = $_SESSION['id_campus'];
if (!$ID_Campus) header('Location: index.php');

if (!isset($_SESSION['X']) || !isset($_SESSION['Y']))
{
   header('Location: index.php?l=main');
}

$X = $_SESSION['X'];
$Y = $_SESSION['Y'];
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
$SQL_String = "SELECT id_army FROM gs_armies WHERE id_homecampus=$ID_Campus AND id_stayingcampus=$ID_Campus";
$Query = $Connect->Query($SQL_String);
$Record = $Query->fetch_assoc();
$ID_Army = $Record['id_army'];
$Army = new Army($ID_Army);

$SQL_String = "SELECT id_campus, name, id_owner FROM gs_campuses WHERE x_coord=$X AND y_coord=$Y";
$Query = $Connect->Query($SQL_String);
$Record = $Query->fetch_assoc();
$Name = $Record['name'];
$ID_Owner = $Record['id_owner'];
$ID_Target = $Record['id_campus'];
$SQL_String = "SELECT login FROM gs_users WHERE id_user=$ID_Owner";
$Query = $Connect->Query($SQL_String);
$Record = $Query->fetch_assoc();
$Login = $Record['login'];

if (isset($_POST['send']))
{
   $Result = $Army->Split($_POST['student'], $_POST['parachute'], $_POST['nerd'], $_POST['stooley'], $_POST['drunkard'], $_POST['clochard'], $_POST['master'], $_POST['doctor'], $_POST['inspector'], $_POST['veteran']);
   if ($Result == 0)
   {
      $SQL_String = "SELECT id_army FROM gs_armies WHERE id_homecampus=$ID_Campus AND id_stayingcampus=$ID_Campus ORDER BY id_army DESC";
      $Query = $Connect->Query($SQL_String);
      $Record = $Query->fetch_assoc();
      $ID_New_Army = $Record['id_army'];
      $New_Army = new Army($ID_New_Army);
      $SQL_String = "UPDATE gs_armies SET id_stayingcampus=0 WHERE id_army=$ID_New_Army";
      $Query = $Connect->Query($SQL_String);
      $Arrival_Time = new DateTime(); 
      $Arrival_Time->add(new DateInterval('PT'.Calculate_Travel_Time($Connect, $New_Army->ID_Homecampus_Getter(),$ID_Target,$New_Army->Speed_Getter()).'M'));
      //$Arrival_Time->add(new DateInterval('PT'.$New_Army->Speed_Getter().'M'));
      $Date_String = $Arrival_Time->format('Y-m-d H:i:00');
      $SQL_String = "INSERT INTO gs_moves (id_army, id_source, id_destination, arrival_time, strike) VALUES ($ID_New_Army, $ID_Campus, $ID_Target, '$Date_String', 1)";
      $Query = $Connect->Query($SQL_String);
      echo '<center>';
      echo '<b><font size="4" color="yellow">Wojska wysłane</font></b>';
      echo '</center>';
   }
   if ($Result == 1)
   {
      echo '<center>';
      echo '<b><font size="4" color="yellow">Nie masz tyle wojsk!</font></b>';
      echo '</center>';
   }
}

?>

<html>
<head>
   <?php Style_Inline(); ?>
</head>
<body>
   <center>
   <font size="5"><b>Wyślij atak</b></font><br/>
   <table>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b>Cel:</b>
         </td>
         <td><i>
            <?php 
            echo '<a href="?l=campus_info&id_campus=';
            echo $ID_Target;
            echo '">';
            echo $Name;
            echo ' (';
            echo $X;
            echo '|';
            echo $Y;
            echo ')';
            echo '</a>';
            ?>
         </i></td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b>Właściciel:</b>
         </td>
         <td><i>
            <?php 
            echo '<a href="?l=user_info&id_user=';
            echo $ID_Owner;
            echo '">';
            echo $Login;
            echo '</a>';
            ?>
         </i></td>
      </tr>
      <form method="POST">
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b><a href="?l=student"><img src="img/student.png" width="30" height="30">Student</a>
            (<?php echo $Army->Student_Getter()->Number_Getter(); ?>)
            </b>
         </td>
         <td>
            <input type="text" name="student" value="0" style="width: 60px">
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b><a href="?l=parachute"><img src="img/spadochroniarz.png" width="30" height="30">Student spadochroniarz</a>
            (<?php echo $Army->Parachute_Getter()->Number_Getter(); ?>)
            </b>
         </td>
         <td>
            <input type="text" name="parachute" value="0" style="width: 60px">
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b><a href="?l=nerd"><img src="img/nerd.png" width="30" height="30">Nerd</a>
            (<?php echo $Army->Nerd_Getter()->Number_Getter(); ?>)
            </b>
         </td>
         <td>
            <input type="text" name="nerd" value="0" style="width: 60px">
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b><a href="?l=stooley"><img src="img/stulejarz.png" width="30" height="30">Stulejarz</a>
            (<?php echo $Army->Stooley_Getter()->Number_Getter(); ?>)
            </b>
         </td>
         <td>
            <input type="text" name="stooley" value="0" style="width: 60px">
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b><a href="?l=drunkard"><img src="img/menel.png" width="30" height="30">Menel</a>
            (<?php echo $Army->Drunkard_Getter()->Number_Getter(); ?>)
            </b>
         </td>
         <td>
            <input type="text" name="drunkard" value="0" style="width: 60px">
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b><a href="?l=clochard"><img src="img/kloszard.png" width="30" height="30">Kloszard</a>
            (<?php echo $Army->Clochard_Getter()->Number_Getter(); ?>)
            </b>
         </td>
         <td>
            <input type="text" name="clochard" value="0" style="width: 60px">
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b><a href="?l=master"><img src="img/magister.png" width="30" height="30">Magister</a>
            (<?php echo $Army->Master_Getter()->Number_Getter(); ?>)
            </b>
         </td>
         <td>
            <input type="text" name="master" value="0" style="width: 60px">
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b><a href="?l=doctor"><img src="img/doktor.png" width="30" height="30">Doktor</a>
            (<?php echo $Army->Doctor_Getter()->Number_Getter(); ?>)
            </b>
         </td>
         <td>
            <input type="text" name="doctor" value="0" style="width: 60px">
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b><a href="?l=inspector"><img src="img/kanar.png" width="30" height="30">Kanar</a>
            (<?php echo $Army->Inspector_Getter()->Number_Getter(); ?>)
            </b>
         </td>
         <td>
            <input type="text" name="inspector" value="0" style="width: 60px">
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b><a href="?l=veteran"><img src="img/weteran.png" width="30" height="30">Kanar weteran</a>
            (<?php echo $Army->Veteran_Getter()->Number_Getter(); ?>)
            </b>
         </td>
         <td>
            <input type="text" name="veteran" value="0" style="width: 60px">
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b>Potwierdź: </b>
         </td>
         <td>
            <input type="submit" name="send" value="Wyślij">
         </td>
      </tr>
      </form>
   </table>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>

<?php $Connect->close(); ?>