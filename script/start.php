<style type="text/css">         
.log_table {background-color: red; padding: 5px; font-weight: bold; border-radius: 20px;}          
.register_table {background-color: green; padding: 5px; font-weight: bold; border-radius: 20px;}     
.bold {font-weight: bold; text-align: center;}          
.true {color: green; font-weight: bold;}
.false {color: red; font-weight: bold;}
</style>            
<script type="text/javascript">
function walidator() {
  var x = document.forms['registration'];
  var goodEmail = /^[^@]+@([a-z0-9\-]+\.)+[a-z]{2,4}$/i;
  
  if(x.register_login.value == '') {
    alert('Podaj nick!');
    return false;
  } else if(x.register_login.value.length < 3 || x.register_login.value.length > 16) {
    alert('Niepoprawny login!');
    return false;  
  } else if(x.register_login.value == x.register_email.value) {
    alert('Login nie może być taki sam jak email!');
    return false;
  } else if(x.register_email.value == '') {
    alert('Podaj email!');
    return false;
  } else if(!goodEmail.test(x.register_email.value)) {
    alert('Niepoprawny email!');
    return false;
  } else if(x.register_email_2.value == '') {
    alert('Potwierdź email!');
    return false;
  } else if(x.register_email.value != x.register_email_2.value) {
    alert('Podane emaile różnią się!');
    return false;
  } else if(x.register_password.value == '') {
    alert('Podaj hasło!');
    return false;
  } else if(x.register_password_2.value == '') {
    alert('Potwierdź haslo!');
    return false;
  } else if(x.register_password.value != x.register_password_2.value) {
    alert('Podane hasla roznia sie!');
    return false;
  } else 
    return true;
}

window.onload = function() {document.forms['log_form'].user.focus();}               
</script>                          
<center>                           
    <div style="color: red; font-size: 50px;"><img src="img/logo.png">                         
    </div>                         
    <form method="post" name="log_form"><br />                              
        <table border="1">                                 
            <tr bgcolor="#31B404">                         
                <td colspan="2"><center><b><font size=4 color="yellow">LOGOWANIE</font></b></center></td>                     
            </tr>                              
            <tr bgcolor="#31B404"><td><i>Użytkownik</i></td><td>                             
                    <input type="text" name="user" /></td>                     
            </tr>                              
            <tr bgcolor="#31B404"><td><i>Hasło</i></td><td>                             
                    <input type="password" name="password" /></td>                     
            </tr>                              
            <tr bgcolor="#31B404">                         
                <td colspan="2" align="center">                             
                    <input type="submit" value="OK" name="log_OK" /></td>                     
            </tr>                                  
        </table>               
    </form>  
<?php
if(isset($_POST["log_OK"])) {
    $login    = $_POST["user"];
    $password = md5($_POST["password"]);
    
    require "db_connect.php";
    $connect = new mysqli($db_host, $db_user, $db_password, $db_name);
    
    if($connect->errno != 0)
        echo "Error ".$connect->errno;
    else {
        $z = "SELECT * FROM gs_users WHERE login = '$login' && password = '$password'";
        $q = $connect->query($z)->fetch_assoc();   
        
        if($q['login'] == $login && $q['password'] == $password && !$q['active']) {
            echo "<span class=\"false\">Twoje konto jest nieaktywne</span>";
        } else if($q['login'] == $login && $q['password'] == $password && $q['active']) {
            $_SESSION["zalogowany"] = true;
            $_SESSION["login"]      = $login;
            
            header("Location: ?=campus_select");
        } else {
            echo "<span class=\"false\">Niepoprawny użytkownik lub hasło</span>";
        } 
          
        //$q->free_result();
        $connect->close();
    }
}
?>                                        
    <form method="post" name="registration" onsubmit="return walidator()"><br />                 
        <table border="1">                                 
            <tr bgcolor="#31B404">                         
                <td colspan="2"><center><b><font size="4" color="yellow">REJESTRACJA</font></b></center></td>                     
            </tr>                              
            <tr bgcolor="#31B404"><td><i>Nazwa użytkownika</i></td><td>                             
                    <input type="text" name="register_login" /></td>                     
            </tr>                        
            <tr bgcolor="#31B404"><td><i>Email</i></td><td>                             
                    <input type="text" name="register_email" /></td>                     
            </tr>                     
            <tr bgcolor="#31B404"><td><i>Powtórz email</i></td><td>                             
                    <input type="text" name="register_email_2" /></td>                     
            </tr>                     
            <tr bgcolor="#31B404"><td><i>Hasło</i></td><td>                             
                    <input type="password" name="register_password" /></td>                     
            </tr>                            
            <tr bgcolor="#31B404"><td><i>Powtórz hasło</i></td><td>                             
                    <input type="password" name="register_password_2" /></td>                     
            </tr>                              
            <tr bgcolor="#31B404">                         
                <td colspan="2" align="center">                             
                    <input type="submit" value="OK" name="register_OK" /></td>                     
            </tr>                                  
        </table>                     
    </form> 
    <center><b><font size=4 color="yellow">Gra stworzona w celach humorystyczno-satyrycznych; nie ma na celu obrażenia żadnych osób ani grup społecznych</font></b></center>  
<?php   
function validate_login($data) {
    if(strlen($data) > 3 && strlen($data) < 20 && ereg('^[a-zA-ZąćęłńóśżźĄĆĘŁŃÓŚŻŹ _]+$', $data)) return true;
    else return false;
} 
  
if(isset($_POST["register_OK"])) {
    $login              = $_POST["register_login"]; 
    $email              = $_POST["register_email"];
    $haslo              = md5($_POST["register_password"]);
    $k                  = rand(1, 9999).$login;
    $kod                = md5($k);
    $headers            = "From: Gra_Studencka\r\n".
                        "Reply-to: Gra_Studencka\r\n";
    $message            = "Dziękujemy za rejestrację :) \r\n".
                        "Link aktywacyjny: http://www.grastudencka.cba.pl/?l=activation&user=".$login."&activation_id=".$kod.
                        "\r\nPo zalogowaniu i wejściu do kampusu zapoznaj się z pomocą oznaczoną ikoną pytajnika na górze strony.\r\n";  
    
    include "db_connect.php";
    $connect = new mysqli($db_host, $db_user, $db_password, $db_name);
    
    if($connect->errno != 0)
        echo "Error ".$connect->errno;
    else {        
        if($connect->query("SELECT * FROM gs_users WHERE login = '$login'")->num_rows != 0) echo "<span class=\"false\">Nick jest zajęty!!</span>"; else
        if($connect->query("SELECT * FROM gs_users WHERE email = '$email'")->num_rows != 0) echo "<span class=\"false\">Podany email jest już wykorzystany!!</span>"; else
        if(!validate_login($login)) echo "<span id=\"false\">Niepoprawny login!!</span>"; else {
            // Konto
            $Date_Time = new DateTime(); 
            $Date_String = $Date_Time->format('Y-m-d H:i:00');
            $z = "INSERT INTO gs_users (login, password, email, code, active, registration_date) VALUES ('$login', '$haslo', '$email', '$kod', 0, '$Date_String')";
            $q = $connect->query($z);
            
            // Wiocha
            $pos_x      = 50;
            $pos_y      = 50;
            
            do {
                $kierunek   = rand(1, 4);
                $krok       = rand(1, 3);
                
                switch($kierunek) {
                    case 1:
                        $pos_x += $krok;
                    break;
                    case 2:
                        $pos_x -= $krok;
                    break;
                    case 3:
                        $pos_y += $krok;
                    break;
                    case 4:
                        $pos_y -= $krok;
                    break;    
                }
                
                $z = "SELECT id_campus FROM gs_campuses WHERE x_coord = $pos_x AND y_coord = $pos_y";
                $q = $connect->query($z);
                $rec_num = $q->num_rows;    
            } while($rec_num != 0);
            
            $amount_vodka   = 500;
            $amount_kebab   = 500;
            $amount_wifi    = 500;
            
            $z = "INSERT INTO gs_campuses (x_coord, y_coord, id_owner, amount_vodka, amount_kebab, amount_wifi, dormitory, transit, college, liquirstore, cafe, terminus, parking, bench, distillery, doner, wifispot) VALUES".
            "($pos_x, $pos_y, (SELECT id_user FROM gs_users WHERE login = '$login'), $amount_vodka, $amount_kebab, $amount_wifi, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1)";
            $q = $connect->query($z);                        
            
            $z = "INSERT INTO gs_armies (id_homecampus, id_stayingcampus, student, parachute, inspector, veteran, master, doctor, drunkard, clochard, nerd, stooley) VALUES".
            "((SELECT id_campus FROM gs_campuses WHERE id_owner = (SELECT id_user FROM gs_users WHERE login = '$login')),".
            "(SELECT id_campus FROM gs_campuses WHERE id_owner = (SELECT id_user FROM gs_users WHERE login = '$login')), 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
            $q1 = $connect->query($z); 

            mail($email, "Aktywacja konta", $message, $headers);
            
            if($q && $q1) 
              echo "<span class=\"true\">Rejestracja przebiegła pomyślnie!<br />Na podany email został wysłany link aktywacyjny.</span>\n";
              //echo "<span class=\"true\">Rejestracja przebiegła pomyślnie! Możesz się zalogować</span>\n";
            else 
              echo "<span class=\"false\">Error!</span>\n";                                                                                                                                
        }
        
        $connect->close();
    } 
}
if(@$_GET["action"] == "activation") 
    require "activation.php";
?>                   
</center>        