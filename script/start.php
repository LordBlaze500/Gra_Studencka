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
    <div style="color: red; font-size: 50px;">Gra Studencka                          
    </div>                         
    <form method="post" name="log_form"><br />                              
        <table border="0" class="log_table">                                 
            <tr>                         
                <td class="bold" colspan="2">LOGOWANIE</td>                     
            </tr>                              
            <tr><td>Użytkownik</td><td>                             
                    <input type="text" name="user" /></td>                     
            </tr>                              
            <tr><td>Hasło</td><td>                             
                    <input type="password" name="password" /></td>                     
            </tr>                              
            <tr>                         
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
            
            
            header("Location: ".$_SERVER["REQUEST_URI"]);
        } else {
            echo "<span class=\"false\">Niepoprawny użytkownik lub hasło</span>";
        } 
          
        //$q->free_result();
        $connect->close();
    }
}
?>                                        
    <form method="post" name="registration" onsubmit="return walidator()"><br />                 
        <table border="0" class="register_table">                                 
            <tr>                         
                <td class="bold" colspan="2">REJESTRACJA</td>                     
            </tr>                              
            <tr><td>Nazwa użytkownika</td><td>                             
                    <input type="text" name="register_login" /></td>                     
            </tr>                        
            <tr><td>Email</td><td>                             
                    <input type="text" name="register_email" /></td>                     
            </tr>                     
            <tr><td>Powtórz email</td><td>                             
                    <input type="text" name="register_email_2" /></td>                     
            </tr>                     
            <tr><td>Hasło</td><td>                             
                    <input type="password" name="register_password" /></td>                     
            </tr>                            
            <tr><td>Powtórz hasło</td><td>                             
                    <input type="password" name="register_password_2" /></td>                     
            </tr>                              
            <tr>                         
                <td colspan="2" align="center">                             
                    <input type="submit" value="OK" name="register_OK" /></td>                     
            </tr>                                  
        </table>                     
    </form>   
<?php     
if(isset($_POST["register_OK"])) {
    $login              = $_POST["register_login"];
    $email              = $_POST["register_email"];
    $haslo              = md5($_POST["register_password"]);
    $k                  = rand(1, 9999).$login;
    $kod                = md5($k);
    $headers            = "From: Gra Studencka\r\n".
                        "Content-type: text/html; charset=utf-8\r\n".
                        "Reply-to: Gra Studencka\r\n";
    $message            = "Dziękujemy za rejestracje :) <br />\r\n".
                        "Link aktywacyjny: http://www.grastudencka.cba.pl/?action=activation&user=".$login."&activation_id=".$kod;  
    
    include "db_connect.php";
    $connect = new mysqli($db_host, $db_user, $db_password, $db_name);
    
    if($connect->errno != 0)
        echo "Error ".$connect->errno;
    else {        
        if($connect->query("SELECT * FROM gs_users WHERE login = '$login'")->num_rows != 0) echo "<span class=\"false\">Nick jest zajęty!!</span>"; else
        if($connect->query("SELECT * FROM gs_users WHERE email = '$email'")->num_rows != 0) echo "<span class=\"false\">Podany email jest już wykorzystany!!</span>"; else
        if(strlen($login) < 3 || strlen($login) > 16) echo "<span id=\"false\">Niepoprawny nick!!</span>"; else {
            // Konto
            $z = "INSERT INTO gs_users (login, password, email, code, active) VALUES ('$login', '$haslo', '$email', '$kod', 1)";
            $q = $connect->query($z);
            
            // Wiocha
            do {
                $pos_x = rand(1, 100);
                $pos_y = rand(1, 100);
                
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
            
            //mail (                                                                                                                       
            //$email, "Aktywacja konta", $message, $headers
            //);
            
            if($q) 
              //echo "<span class=\"true\">Rejestracja przebieg³a pomyœlnie!<br />Na podany email zosta³ wys³any link aktywacyjny</span>\n";
              echo "<span class=\"true\">Rejestracja przebiegła pomyślnie! Możesz się zalogować</span>\n";
            else 
              echo "<span class=\"flase\">Error!</span>\n";                                                                                                                                
        }
        
        $connect->close();
    }
}
if(@$_GET["action"] == "activation") 
    require "activation.php";
?>                   
</center>        