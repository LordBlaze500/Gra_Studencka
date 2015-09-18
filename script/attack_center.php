<?php
include "db_connect.php";
include "style.php";
include "army.php";
include "raport.php";
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


if (isset($_POST['strike']))
{
   $X = $_POST['X'];
   $Y = $_POST['Y'];
   $SQL_String = "SELECT id_campus FROM gs_campuses WHERE x_coord=$X AND y_coord=$Y";
   $Query = $Connect->Query($SQL_String);
   $Record = $Query->fetch_assoc();
   if (!$Record)
   {
      echo '<center><font size=4 color="yellow"><b>';
      echo 'Taki kampus nie istnieje!';
      echo '</b></font></center>';
   }
   if ($Record && $Record['id_campus'] == $ID_Campus)
   {
      echo '<center><font size=4 color="yellow"><b>';
      echo 'Nie możesz zaatakować kampusu wyjściowego!';
      echo '</b></font></center>';
   }
   if ($Record && $X > 0 && $Y > 0 && $Record['id_campus'] != $ID_Campus) 
   {
      $ID_Target = $Record['id_campus'];
      $SQL_String = "SELECT id_owner FROM gs_campuses WHERE id_campus=$ID_Target";
      $Query_2 = $Connect->Query($SQL_String);
      $Record_2 = $Query_2->fetch_assoc();
      $ID_Owner = $Record_2['id_owner'];
      $SQL_String = "SELECT registration_date FROM gs_users WHERE id_user=$ID_Owner";
      $Query_3 = $Connect->Query($SQL_String);
      $Record_3 = $Query_3->fetch_assoc(); 
      $Allowed_Date = DateTime::createFromFormat('Y-m-d H:i:s', $Record_3['registration_date']); 
      $Allowed_Date->add(new DateInterval('PT'.'2880'.'M'));
      $Current_Date = new DateTime();
      $Date_String = $Allowed_Date->format('Y-m-d H:i:00');
      if ($Allowed_Date >= $Current_Date)
      {
         echo '<center><font size="4" color="yellow"><b>Cel ma jeszcze ochronę początkową.</br>';
         echo 'Możesz wysłać atak najwcześniej '.$Date_String.'</b></font></center>';
      }
      else
      {
         $_SESSION['X'] = $X;
         $_SESSION['Y'] = $Y;
         header('Location: index.php?l=send_attack');
      }
   }
}

if (isset($_POST['help']))
{
   $X = $_POST['X'];
   $Y = $_POST['Y'];
   $SQL_String = "SELECT id_campus FROM gs_campuses WHERE x_coord=$X AND y_coord=$Y";
   $Query = $Connect->Query($SQL_String);
   $Record = $Query->fetch_assoc();
   if (!$Record)
   {
      echo '<center><font size=4><b>';
      echo 'Taki kampus nie istnieje!';
      echo '</b></font></center>';
   }
   if ($Record && $Record['id_campus'] == $ID_Campus)
   {
      echo '<center><font size=4><b>';
      echo 'Nie możesz wysłać wojsk do kampusu wyjściowego!';
      echo '</b></font></center>';
   }
   if ($Record && $X > 0 && $Y > 0 && $Record['id_campus'] != $ID_Campus) 
   {
      $_SESSION['X'] = $X;
      $_SESSION['Y'] = $Y;
      header('Location: index.php?l=send_help');
   }
}

if (isset($_POST['spying']))
{
   $X = $_POST['X'];
   $Y = $_POST['Y'];
   $SQL_String = "SELECT id_campus FROM gs_campuses WHERE x_coord=$X AND y_coord=$Y";
   $Query = $Connect->Query($SQL_String);
   $Record = $Query->fetch_assoc();
   if (!$Record)
   {
      echo '<center><font size=4><b>';
      echo 'Taki kampus nie istnieje!';
      echo '</b></font></center>';
   }
   if ($Record && $Record['id_campus'] == $ID_Campus)
   {
      echo '<center><font size=4><b>';
      echo 'Nie możesz wysłać wojsk do kampusu wyjściowego!';
      echo '</b></font></center>';
   }
   if ($Record && $X > 0 && $Y > 0 && $Record['id_campus'] != $ID_Campus) 
   {
      $ID_Target = $Record['id_campus'];
      $SQL_String = "SELECT id_owner FROM gs_campuses WHERE id_campus=$ID_Target";
      $Query_2 = $Connect->Query($SQL_String);
      $Record_2 = $Query_2->fetch_assoc();
      $ID_Owner = $Record_2['id_owner'];
      $SQL_String = "SELECT registration_date FROM gs_users WHERE id_user=$ID_Owner";
      $Query_3 = $Connect->Query($SQL_String);
      $Record_3 = $Query_3->fetch_assoc(); 
      $Allowed_Date = DateTime::createFromFormat('Y-m-d H:i:s', $Record_3['registration_date']); 
      $Allowed_Date->add(new DateInterval('PT'.'2880'.'M'));
      $Current_Date = new DateTime();
      $Date_String = $Allowed_Date->format('Y-m-d H:i:00');
      if ($Allowed_Date >= $Current_Date)
      {
         echo '<center><font size="4" color="yellow"><b>Cel ma jeszcze ochronę początkową.</br>';
         echo 'Możesz wysłać szpiegów najwcześniej '.$Date_String.'</b></font></center>';
      }
      else
      {
         $_SESSION['X'] = $X;
         $_SESSION['Y'] = $Y;
         header('Location: index.php?l=send_spying');
      }
   }
}

if (isset($_POST['retreat']) && isset($_POST['id_army']))
{
   $ID_Army = $_POST['id_army'];
   $SQL_String_2 = "SELECT id_army, id_stayingcampus FROM gs_armies WHERE id_army=$ID_Army AND id_homecampus=$ID_Campus AND id_stayingcampus != id_homecampus AND id_stayingcampus != 0";
   $Query_2 = $Connect->Query($SQL_String_2);
   $Record_2 = $Query_2->fetch_assoc();
   if ($Record_2['id_army'])
   {
      $Army = new Army($Record_2['id_army']);
      $Old_Destination = $Record_2['id_stayingcampus'];
      $Arrival_Time = new DateTime(); 
      $Arrival_Time->add(new DateInterval('PT'.Calculate_Travel_Time($Connect, $Army->ID_Homecampus_Getter(),$Army->ID_Stayingcampus_Getter(),$Army->Speed_Getter()).'M'));
      $Date_String = $Arrival_Time->format('Y-m-d H:i:00');
      $ID_Army = $Record_2['id_army'];
      $SQL_String_3 = "INSERT INTO gs_moves (id_army, id_source, id_destination, arrival_time, strike, old_id_destination) VALUES ($ID_Army, $ID_Campus, $ID_Campus, '$Date_String', 2, $Old_Destination)";
      $Query_3 = $Connect->Query($SQL_String_3);
      $SQL_String_3 = "UPDATE gs_armies SET id_stayingcampus=0 WHERE id_army=$ID_Army";
      $Query_3 = $Connect->Query($SQL_String_3);
      $SQL_String = "SELECT id_move FROM gs_moves WHERE id_army=$ID_Army";
      $Query_2 = $Connect->Query($SQL_String);
      $Record_2 = $Query_2->fetch_assoc();
      $Raport = new Retreat_Raport($Record_2['id_move']);
      $Raport->Send();
   }
}

if (isset($_POST['sendback']) && isset($_POST['id_army']))
{
   $ID_Army = $_POST['id_army'];
   $SQL_String_2 = "SELECT id_army, id_homecampus FROM gs_armies WHERE id_army=$ID_Army AND id_stayingcampus=$ID_Campus AND id_stayingcampus != id_homecampus AND id_stayingcampus != 0";
   $Query_2 = $Connect->Query($SQL_String_2);
   $Record_2 = $Query_2->fetch_assoc();
   if ($Record_2['id_army'])
   {
      $Army = new Army($Record_2['id_army']);
      $Old_Destination = $ID_Campus;
      $Arrival_Time = new DateTime(); 
      $Arrival_Time->add(new DateInterval('PT'.Calculate_Travel_Time($Connect, $Army->ID_Homecampus_Getter(),$Army->ID_Stayingcampus_Getter(),$Army->Speed_Getter()).'M'));
      $Date_String = $Arrival_Time->format('Y-m-d H:i:00');
      $ID_Army = $Record_2['id_army'];
      $ID_Homecampus = $Record_2['id_homecampus'];
      $SQL_String_3 = "INSERT INTO gs_moves (id_army, id_source, id_destination, arrival_time, strike, old_id_destination) VALUES ($ID_Army, $ID_Homecampus, $ID_Homecampus, '$Date_String', 2, $Old_Destination)";
      $Query_3 = $Connect->Query($SQL_String_3);
      $SQL_String_3 = "UPDATE gs_armies SET id_stayingcampus=0 WHERE id_army=$ID_Army";
      $Query_3 = $Connect->Query($SQL_String_3);
      $SQL_String = "SELECT id_move FROM gs_moves WHERE id_army=$ID_Army";
      $Query_2 = $Connect->Query($SQL_String);
      $Record_2 = $Query_2->fetch_assoc();
      $Raport = new Sendback_Raport($Record_2['id_move']);
      $Raport->Send();
   }
}
?>

   <center>
   <table border=1>
      <tr bgcolor=<?php Bg_Color_One();?>>
         <td>
            <center>
            <font size="5"><b>Centrum ataków</b></font><br/>
            <img src="img/crossed_swords.png" alt="Centrum atakow" width="150" height="150">
            </center>
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center><i>
            Centrum ataków informuje, jakie wojska idą na ten kampus<br/>
            oraz pozwala wysyłać wojska do innych kampusów.</i>
            </center>
         </td>
      </tr>
   </table>
   <font size="4" color="yellow"><b>Nadchodzące ataki</b></font><br/>

   <table border=1>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td><center><b>Pochodzenie</b></center></td>         
         <td><center><b>Gracz</b></center></td>
         <td><center><b>Godzina przybycia</b></center></td>
      </tr>
         <?php
         $No_Attacks = 1;
         $SQL_String = "SELECT * FROM gs_moves WHERE id_destination=$ID_Campus AND strike=1";
         $Query = $Connect->query($SQL_String);
         while ($Record = $Query->fetch_assoc())
         {
            $No_Attacks = 0;
            $Source = $Record['id_source'];
            $SQL_String_2 = "SELECT x_coord, y_coord, id_owner, name FROM gs_campuses WHERE id_campus=$Source";
            $Query_2 = $Connect->query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            $Owner = $Record_2['id_owner'];
            $SQL_String_3 = "SELECT login FROM gs_users WHERE id_user=$Owner";
            $Query_3 = $Connect->query($SQL_String_3);
            $Record_3 = $Query_3->fetch_assoc();
            echo '<tr';
            echo ' bgcolor=';
            echo Bg_Color_Three();
            echo '>';
            echo '<td><center><i>'; echo '<a href="?l=campus_info&id_campus='; echo $Source; echo '">'; echo $Record_2['name']; echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')'; echo '</a>'; echo '</i></center></td>';
            echo '<td><center><i>'; echo '<a href="?l=user_info&id_user='; echo $Owner; echo '">'; echo $Record_3['login']; echo '</a>'; echo '</i></center></td>';
            echo '<td><center><i>'; echo $Record['arrival_time']; echo '</i></center></td>';
            echo '</tr>';
         }
         if ($No_Attacks == 1)
         {
            echo '<tr';
            echo ' bgcolor=';
            echo Bg_Color_Three();
            echo '>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '</tr>';
         }
         ?>
   </table>

   <font size="4" color="yellow"><b>Nadchodzące wsparcie</b></font><br/>

   <table border=1>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td><center><b>Pochodzenie</b></center></td>         
         <td><center><b>Gracz</b></center></td>
         <td><center><b>Godzina przybycia</b></center></td>
         <td><center><b>Szczegóły</b></center></td>
      </tr>
         <?php
         $No_Attacks = 1;
         $SQL_String = "SELECT * FROM gs_moves WHERE id_destination=$ID_Campus AND strike=0";
         $Query = $Connect->query($SQL_String);
         while ($Record = $Query->fetch_assoc())
         {
            $No_Attacks = 0;
            $Source = $Record['id_source'];
            $SQL_String_2 = "SELECT x_coord, y_coord, id_owner, name FROM gs_campuses WHERE id_campus=$Source";
            $Query_2 = $Connect->query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            $Owner = $Record_2['id_owner'];
            $SQL_String_3 = "SELECT login FROM gs_users WHERE id_user=$Owner";
            $Query_3 = $Connect->query($SQL_String_3);
            $Record_3 = $Query_3->fetch_assoc();
            echo '<tr';
            echo ' bgcolor=';
            echo Bg_Color_Three();
            echo '>';
            echo '<td><center><i>'; echo '<a href="?l=campus_info&id_campus='; echo $Source; echo '">'; echo $Record_2['name']; echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')'; echo '</a>'; echo '</i></center></td>';
            echo '<td><center><i>'; echo '<a href="?l=user_info&id_user='; echo $Owner; echo '">'; echo $Record_3['login']; echo '</a>'; echo '</i></center></td>';
            echo '<td><center><i>'; echo $Record['arrival_time']; echo '</i></center></td>';
            echo '<td><center><i>'; echo '<a href="?l=move_info&id_move='; echo $Record['id_move']; echo '">'; echo 'Szczegóły'; echo '</a></i></center>';
            echo '</tr>';
         }
         if ($No_Attacks == 1)
         {
            echo '<tr';
            echo ' bgcolor=';
            echo Bg_Color_Three();
            echo '>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '</tr>';
         }
         ?>
   </table>

   <font size="4" color="yellow"><b>Twoje wojska w drodze</b></font><br/>

   <table border=1>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td><center><b>Typ</b></center></td>         
         <td><center><b>Cel</b></center></td>
         <td><center><b>Godzina przybycia</b></center></td>
         <td><center><b>Szczegóły</b></center></td>
      </tr>
         <?php
         $No_Attacks = 1;
         $SQL_String = "SELECT * FROM gs_moves WHERE id_source=$ID_Campus AND id_destination != $ID_Campus";
         $Query = $Connect->query($SQL_String);
         while ($Record = $Query->fetch_assoc())
         {
            $No_Attacks = 0;
            $Type = $Record['strike'];
            $ID_Destination = $Record['id_destination'];
            $SQL_String_2 = "SELECT x_coord, y_coord, name FROM gs_campuses WHERE id_campus=$ID_Destination";
            $Query_2 = $Connect->query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            echo '<tr';
            echo ' bgcolor=';
            echo Bg_Color_Three();
            echo '>';
            echo '<td><i><center>'; 
            if ($Type == 1) echo 'Atak';
            if ($Type == 0) echo 'Wsparcie';
            if ($Type == 3) echo 'Szpiegowanie';
            echo '</center></i></td>';
            echo '<td><i><center>'; echo '<a href="?l=campus_info&id_campus='; echo $ID_Destination; echo '">'; echo $Record_2['name']; echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')'; echo '</a>'; echo '</center></i></td>';
            echo '<td><i><center>'; echo $Record['arrival_time']; echo '</center></i></td>';
            echo '<td><i><center>'; echo '<a href="?l=move_info&id_move='; echo $Record['id_move']; echo '">'; echo 'Szczegóły'; echo '</a></center></i>';
            echo '</tr>';
         }
         if ($No_Attacks == 1)
         {
            echo '<tr';
            echo ' bgcolor=';
            echo Bg_Color_Three();
            echo '>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '</tr>';
         }
         ?>
   </table>

   <font size="4" color="yellow"><b>Powracające twoje wojska</b></font><br/>

   <table border=1>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td><center><b>Powrót z</b></center></td>         
         <td><center><b>Godzina przybycia</b></center></td>
         <td><center><b>Szczegóły</b></center></td>
      </tr>
         <?php
         $No_Attacks = 1;
         $SQL_String = "SELECT * FROM gs_moves WHERE id_destination=$ID_Campus AND strike=2";
         $Query = $Connect->query($SQL_String);
         while ($Record = $Query->fetch_assoc())
         {
            $No_Attacks = 0;
            $Old_Destination = $Record['old_id_destination'];
            $SQL_String_2 = "SELECT x_coord, y_coord, id_owner, name FROM gs_campuses WHERE id_campus=$Old_Destination";
            $Query_2 = $Connect->query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            $Owner = $Record_2['id_owner'];
            $SQL_String_3 = "SELECT login FROM gs_users WHERE id_user=$Owner";
            $Query_3 = $Connect->query($SQL_String_3);
            $Record_3 = $Query_3->fetch_assoc();
            echo '<tr';
            echo ' bgcolor=';
            echo Bg_Color_Three();
            echo '>';
            echo '<td><center><i>'; echo '<a href="?l=campus_info&id_campus='; echo $Old_Destination; echo '">'; echo $Record_2['name']; echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')'; echo '</a>'; echo '</i></center></td>';
            echo '<td><center><i>'; echo $Record['arrival_time']; echo '</i></center></td>';
            echo '<td><center><i>'; echo '<a href="?l=move_info&id_move='; echo $Record['id_move']; echo '">'; echo 'Szczegóły'; echo '</a></i></center>';
            echo '</tr>';
         }
         if ($No_Attacks == 1)
         {
            echo '<tr';
            echo ' bgcolor=';
            echo Bg_Color_Three();
            echo '>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '</tr>';
         }
         ?>
   </table>

   <font size="4" color="yellow"><b>Twoje wojska w innych kampusach</b></font><br/>

   <table border=1>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td><center><b>Kampus</b></center></td>         
         <td><center><b>Wycofaj</b></center></td>
         <td><center><b>Szczegóły</b></center></td>
      </tr>
         <?php
         $No_Attacks = 1;
         $SQL_String = "SELECT * FROM gs_armies WHERE id_homecampus=$ID_Campus AND id_stayingcampus > 0 AND id_stayingcampus != id_homecampus";
         $Query = $Connect->query($SQL_String);
         while ($Record = $Query->fetch_assoc())
         {
            $No_Attacks = 0;
            $ID_Stayingcampus = $Record['id_stayingcampus'];
            $SQL_String_2 = "SELECT x_coord, y_coord, name FROM gs_campuses WHERE id_campus=$ID_Stayingcampus";
            $Query_2 = $Connect->query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            echo '<tr';
            echo ' bgcolor=';
            echo Bg_Color_Three();
            echo '>';
            echo '<td><i><center>'; echo '<a href="?l=campus_info&id_campus='; echo $ID_Stayingcampus; echo '">'; echo $Record_2['name']; echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')'; echo '</a>'; echo '</center></i></td>';
            echo '<td><i>';
            echo '<form method="POST">';
            echo '<input type="hidden" name="l" value="attacks">';
            echo '<input type="hidden" name="id_army" value="';
            echo $Record['id_army'];
            echo '"">';
            echo '<input type="submit" name="retreat" value=Wycofaj>';
            echo '</form></i>';
            echo '</td>';
            echo '<td><i>';
            echo '<a href="?l=army_info&id_army='; echo $Record['id_army']; echo '">'; echo 'Szczegóły'; echo '</a>';
            echo '</i></td>';
            echo '</tr>';
         }
         if ($No_Attacks == 1)
         {
            echo '<tr';
            echo ' bgcolor=';
            echo Bg_Color_Three();
            echo '>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '<td><center><i>'; echo 'Brak'; echo '</i></center></td>';
            echo '</tr>';
         }
         ?>
   </table>

   <font size="4" color="yellow"><b>Cudze wojska w tym kampusie</b></font><br/>

   <table border=1>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td><center><b>Kampus</b></center></td>         
         <td><center><b>Odeślij</b></center></td>
         <td><center><b>Szczegóły</b></center></td>
      </tr>
         <?php
         $No_Attacks = 1;
         $SQL_String = "SELECT * FROM gs_armies WHERE id_stayingcampus=$ID_Campus AND id_stayingcampus > 0 AND id_stayingcampus != id_homecampus";
         $Query = $Connect->query($SQL_String);
         while ($Record = $Query->fetch_assoc())
         {
            $No_Attacks = 0;
            $ID_Homecampus = $Record['id_homecampus'];
            $SQL_String_2 = "SELECT x_coord, y_coord, name FROM gs_campuses WHERE id_campus=$ID_Homecampus";
            $Query_2 = $Connect->query($SQL_String_2);
            $Record_2 = $Query_2->fetch_assoc();
            echo '<tr';
            echo ' bgcolor=';
            echo Bg_Color_Three();
            echo '>';
            echo '<td><i><center>'; echo '<a href="?l=campus_info&id_campus='; echo $ID_Homecampus; echo '">'; echo $Record_2['name']; echo ' ('; echo $Record_2['x_coord']; echo '|'; echo $Record_2['y_coord']; echo ')'; echo '</a>'; echo '</center></i></td>';
            echo '<td><i>';
            echo '<form method="POST">';
            echo '<input type="hidden" name="l" value="attacks">';
            echo '<input type="hidden" name="id_army" value="';
            echo $Record['id_army'];
            echo '"">';
            echo '<input type="submit" name="sendback" value=Odeślij>';
            echo '</form>';
            echo '</i></td>';
            echo '<td><i>';
            echo '<a href="?l=army_info&id_army='; echo $Record['id_army']; echo '">'; echo 'Szczegóły'; echo '</a>';
            echo '</i></td>';
            echo '</tr>';
         }
         if ($No_Attacks == 1)
         {
            echo '<tr';
            echo ' bgcolor=';
            echo Bg_Color_Three();
            echo '>';
            echo '<td><i><center>'; echo 'Brak'; echo '</center></i></td>';
            echo '<td><i><center>'; echo 'Brak'; echo '</center></i></td>';
            echo '<td><i><center>'; echo 'Brak'; echo '</center></i></td>';
            echo '</tr>';
         }
         ?>
   </table>

   <font size="4" color="yellow"><b>Wyślij wojska</b></font><br/>
   <table>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td><b>
            <center>
            <form method="POST">
            <input type="hidden" name="l" value="attacks">
            X: 
            <input type="text" name="X" value="0" style="width: 60px">
            Y:
            <input type="text" name="Y" value="0" style="width: 60px">
            <input type="submit" name="strike" value="Atak">
            <input type="submit" name="help" value="Wsparcie">
            <input type="submit" name="spying" value="Szpiegowanie">
            </form>
            </center></b>
         </td>
      </tr>
   </table>

   <a href="?l=main">Powrót</a>
   </center>

<?php $Connect->close(); ?>

