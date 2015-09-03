<?php
@$user   = $_GET["user"];
@$id     = $_GET["activation_id"];

include "db_connect.php";
$connect = new mysqli($db_host, $db_user, $db_password, $db_name);
    
    if($connect->errno != 0)
        echo "Error ".$connect->errno;
    else {
        $z = "SELECT active FROM gs_users WHERE login = '$user' AND code = '$id'";
        $q = $connect->query($z);
        $rec = $q->fetch_assoc(); 
        
        if($q->num_rows == 0) {
            echo "<center><span class=\"false\">Wyst¹pi³ b³¹d</span></center>";
        } else if($q->num_rows != 0 && $rec["active"]) {
            echo "<center><span class=\"true\">Twoje konto jest już aktywne</span></center>";
        } else {
            $z = "UPDATE gs_users SET active = 1 WHERE code = '$id'";
            $q = $connect->query($z);
            echo "<center><span class=\"true\">Aktywacja przebiegła pomyślnie</span></center>";
        }  
        
        $connect->close(); 
    }
?>