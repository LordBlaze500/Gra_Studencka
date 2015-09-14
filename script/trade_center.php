<?php
include "db_connect.php";
include "style.php";
$ID_Campus = $_SESSION['id_campus'];
if (!$ID_Campus) header('Location: index.php');
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
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
            <center><b><font size="5">Centrum handlu</font></b></br>
            <img src="img/trade.png" alt="Handel" width="150" height="150">
            </center><br/>
         </td>
      </tr>
      <tr align="center" bgcolor=<?php Bg_Color_Two();?>>
         <td>
            <center></br><i>
            Centrum handlu pozwala przesyłać surowce do innych kampusów oraz handlować nimi z innymi graczami. </br>
            Możesz stworzyć własną ofertę handlu bądź przyjąć cudzą. Każdy handlarz może unieść do 1000 sztuk surowców.</br>
            </i></center></br>
         </td>
      </tr>
   </table>
   <table>
      <tr>
         <td><b>Dostępni handlarze:</b></td>
         <td>
            <?php
            $SQL_String = "SELECT traders FROM gs_campuses WHERE id_campus=$ID_Campus";
            $Query = $Connect->Query($SQL_String);
            $Record = $Query->fetch_assoc();
            echo $Record['traders'];
            ?>
         </td>
     </tr>
   </table>
   <table>
      <tr>
         <td>
         <b>Wyślij surowce do:</b>
         </td>
         <td>
            <form method="POST">
            <input type="hidden" name="l" value="trade_center">
            X:
            <input type="text" name="X" value="0" style="width: 60px">
            Y:
            <input type="text" name="Y" value="0" style="width: 60px">
         </td>
      </tr>
      <tr>
         <td>
            <b>Ilość:</b>
         </td>
         <td>
            <img src="img/wodka.png" alt="Wodka" width="30" height="30">
            <input type="text" name="Vodka" value="0" style="width: 60px">
            <img src="img/kebab.png" alt="Kebab" width="30" height="30">
            <input type="text" name="Kebab" value="0" style="width: 60px">
            <img src="img/wifi.png" alt="Wifi" width="30" height="30">
            <input type="text" name="Wifi" value="0" style="width: 60px">
         </td>
      </tr>
      
   </table>

   <a href="?l=main">Powrót</a>
   </center>
</body>
</html>