    <?php
      include "db_connect.php";
      include "building.php";
      include "resource.php";
      include "army.php";
      $Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
      
      $z = "SELECT * FROM gs_messages WHERE seen = 0 AND addressee = (SELECT id_user FROM gs_users WHERE login = '".$_SESSION["login"]."')";
      $q = $Connect->query($z);
      $nowe_wiadomosci = $q->num_rows;
         
      $Connect->close(); 
      ?>
      <center><table border=1>              
      <tr>
      <td><a href="?l=attacks"><img src="img/crossed_swords.jpg" alt="Ataki" width=50 height=50> 
      <?php
      $Attacks_Counter = 0;
      $SQL_String = "SELECT * FROM gs_moves WHERE id_destination=$ID_Campus AND strike=1"; 
      $Query = $Connect->Query($SQL_String);
      while ($Record = $Query->fetch_assoc())
      {
         $Attacks_Counter = $Attacks_Counter + 1;
      }
      if ($Attacks_Counter > 0) { echo '<b><font color=red>'; echo $Attacks_Counter; echo '</font></b>'; }
      else echo $Attacks_Counter;
      ?>
      </a></td>
      <td></td> 
         <td align="center" valign="middle">
         <font color="white">
         <img src="img/wodka.png" alt="Wodka" style="width:50px;height:50px;"> 
         <?php $Amount_Vodka = $Vodka->Amount_Getter(); 
         if ($Amount_Vodka >= $Vodka->Maximum_Getter()) 
         {
            echo '<font color="red">';
            echo $Amount_Vodka; 
            echo '</font>';
         }
         else echo $Amount_Vodka;
         ?>
         <img src="img/kebab.png" alt="Kebab" style="width:50px;height:50px;"> 
         <?php $Amount_Kebab = $Kebab->Amount_Getter(); 
         if ($Amount_Kebab >= $Kebab->Maximum_Getter())
         {
            echo '<font color="red">'; 
            echo $Amount_Kebab;
            echo '</font>';
         }
         else echo $Amount_Kebab;
         ?>
         <img src="img/wifi.png" alt="Wifi" style="width:50px;height:50px;">
         <?php $Amount_Wifi = $Wifi->Amount_Getter(); 
         if ($Amount_Wifi >= $Wifi->Maximum_Getter())
         {
            echo '<font color="red">';
            echo $Amount_Wifi;
            echo '</font>';
         }
         else echo $Amount_Wifi;
         ?>
         </font>
         </td>
         <td>
         <a href="script/messages.php" target="window_iframe" onClick="javascript:Window_('#window', '500', 'Wiadomości', 'on')"><img src="<?php echo ($nowe_wiadomosci == 0) ? "img/nomsg.png" : "img/newmsg.png"; ?>" alt="Wiadomosci" style="width:50px;height:50px;"></a>
         <a href="?l=campus_select"><img src="img/switch.png" alt="Zmien kampus" style="width:50px;height:50px;"></a>
         <a href="?logout=true"><img src="img/logout.png" alt="Wyloguj" style="width:50px;height:50px;"></a>
         </td> 
      </tr>
                    
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
      <td align="left"> 
      <a href="?l=student"><img src="img/student.png" width="40" height="40"></a>   <?php echo $Student->Number_Getter();?><br/>  
      <a href="?l=parachute"><img src="img/spadochroniarz.png" width="40" height="40"></a>   <?php echo $Parachute->Number_Getter();?><br/> 
      <a href="?l=drunkard"><img src="img/menel.png" width="40" height="40"></a>   <?php echo $Drunkard->Number_Getter();?><br/> 
      <a href="?l=clochard"><img src="img/kloszard.png" width="40" height="40"></a>   <?php echo $Clochard->Number_Getter();?><br/>   
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
      <td align="left">
      <a href="?l=nerd"><img src="img/nerd.png" width="40" height="40"></a>   <?php echo $Nerd->Number_Getter();?><br/>  
      <a href="?l=stooley"><img src="img/stulejarz.png" width="40" height="40"></a>   <?php echo $Stooley->Number_Getter();?><br/> 
      <a href="?l=master"><img src="img/magister.png" width="40" height="40"></a>  <?php echo $Master->Number_Getter();?><br/> 
      <a href="?l=doctor"><img src="img/doktor.png" width="40" height="40"></a>   <?php echo $Doctor->Number_Getter();?><br/> 
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
      <td align="left"> 
      <a href="?l=inspector"><img src="img/kanar.png" width="40" height="40"></a>   <?php echo $Inspector->Number_Getter();?><br/>  
      <a href="?l=veteran"><img src="img/weteran.png" width="40" height="40"></a>   <?php echo $Veteran->Number_Getter();?><br/> 
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
      <td>
      
      </td> 
      </tr>      
      </table></center>                            