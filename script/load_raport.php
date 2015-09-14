<?php
session_start();

if(isset($_POST["msg_id"])) 
    $msg_id = $_POST["msg_id"];
else {
    echo "Blad...";
    exit();
} 

if(!$_SESSION["zalogowany"]) exit();

require "db_connect.php";
$connect = new mysqli($db_host, $db_user, $db_password, $db_name);

$z = "SELECT content, seen FROM gs_raports WHERE id_raport = $msg_id";
$rec = $connect->query($z)->fetch_assoc();

if(!$rec["seen"]) {
    $z = "UPDATE gs_raports SET seen = 1 WHERE id_raport = $msg_id";
    $q = $connect->query($z);
}

$connect->close();   
?>
{
    "msg" : {"content":"<?php echo str_replace("\"", "\'", str_replace("\r\n", "", nl2br($rec["content"]))); ?>"}
}