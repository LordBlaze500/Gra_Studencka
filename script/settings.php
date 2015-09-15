<?php
include "db_connect.php";
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

$SQL_String = "SELECT id_owner FROM gs_campuses WHERE id_campus=$ID_Campus";
$Query = $Connect->Query($SQL_String);
$Record = $Query->fetch_assoc();
$ID_User = $Record['id_owner'];
$Changed_Login = 0;
$Changed_Password = 0;
$Changed_Desc = 0;

if (isset($_POST['New_Login']))
{
	$New_Login = $_POST['New_Login'];
	$SQL_String = "SELECT * FROM gs_users WHERE login='$New_Login'";
	$Query = $Connect->Query($SQL_String);
	$Record = $Query->fetch_assoc();
	if ($Record)
	{
		$Changed_Login = 2;
	}
	else
	{
		$SQL_String = "SELECT login FROM gs_users WHERE id_user=$ID_User";
		$Query = $Connect->Query($SQL_String);
		$Record = $Query->fetch_assoc();
		$Old_Login = $Record['login'];
		$SQL_String = "UPDATE gs_users SET login='$New_Login' WHERE login='$Old_Login'";
		$Query = $Connect->Query($SQL_String);
		$Changed_Login = 1;
	}
}

if (isset($_POST['Change_Password']))
{
	$Old_Hash = md5($_POST['Old_Pass']);
    $SQL_String = "SELECT password FROM gs_users WHERE id_user=$ID_User";
    $Query = $Connect->Query($SQL_String);
    $Record = $Query->fetch_assoc();
    if ($Old_Hash != $Record['password'])
    {
       $Changed_Password = 2;
    }
    else
    {
       if ($_POST['New_Pass'] != $_POST['New_Pass_Again'])
       {
       	  $Changed_Password = 3;
       }
       else
       {
       	  $New_Hash = md5($_POST['New_Pass']);
       	  $SQL_String = "UPDATE gs_users SET password='$New_Hash' WHERE id_user=$ID_User";
       	  $Query = $Connect->Query($SQL_String);
       	  $Changed_Password = 1;
       }
    }
}

if (isset($_POST['New_Desc']))
{
	$Description = $_POST['New_Desc'];
	$SQL_String = "UPDATE gs_users SET description='$Description' WHERE id_user=$ID_User";
	$Query = $Connect->Query($SQL_String);
	$Changed_Desc = 1;
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
            <center>
            <font size="5"><b>Ustawienia</b></font><br/>
            <img src="img/ustawienia.png" alt="Centrum atakow" width="110" height="110">
            </center>
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center>
            <i>W ustawieniach możesz zmienić swój login, hasło i opis użytkownika.<br/></i>
            </center>
         </td>
      </tr>
   </table>
   <?php
   if ($Changed_Login == 1)
   {
      echo '<font size=4 color="yellow"><b>Login zmieniony.</b></font><br/>';
   }
   if ($Changed_Login == 2)
   {
   	  echo '<font size=4 color="yellow"><b>Taki login jest już zajęty.</b></font><br/>';
   }
   if ($Changed_Password == 1)
   {
   	  echo '<font size=4 color="yellow"><b>Hasło zmienione.</b></font><br/>';
   }
   if ($Changed_Password == 2)
   {
   	  echo '<font size=4 color="yellow"><b>Stare hasło nie jest prawidłowe.</b></font><br/>';
   }
   if ($Changed_Password == 3)
   {
   	  echo '<font size=4 color="yellow"><b>Hasła nie są zgodne.</b></font><br/>';
   }
   if ($Changed_Desc == 1)
   {
   	  echo '<font size=4 color="yellow"><b>Opis zmieniony.</b></font><br/>';
   }
   ?>
   <table border=1>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b>Zmiana loginu:</b>
         </td>
         <td align="right">
            <form method="POST">
            <input type="hidden" name="l" value="settings">
            <input type="text" name="New_Login" value="Nowy_login" style="width: 150px">
            <input type="submit" name="Change_Login" value="Zmień">
            </form>
         </td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b>Zmiana hasła:</b>
         </td>
         <td align="right"><i>
            <form method="POST">
            <input type="hidden" name="l" value="settings">
            Stare hasło:
            <input type="password" name="Old_Pass" value=""><br/>
            Nowe hasło:
            <input type="password" name="New_Pass" value=""><br/>
            Powtórz nowe hasło:
            <input type="password" name="New_Pass_Again" value=""><br/>
            <input type="submit" name="Change_Password" value="Zmień">
            </form>
         </i></td>
      </tr>
      <tr bgcolor=<?php Bg_Color_Three();?>>
         <td>
            <b>Zmiana opisu gracza:</b>
         </td>
         <td align="right"><i>
            <form method="POST">
            <input type="hidden" name="l" value="settings">
            Nowy opis:
            <input type="textbox" name="New_Desc" value="Opis...">
            <input type="submit" name="Change_Desc" value="Zmień">
            </form>
         </i></td>
      </tr> 
   </table>
   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>