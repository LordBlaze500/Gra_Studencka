<?php
require "db_connect.php";
$connect = new mysqli($db_host, $db_user, $db_password, $db_name);

$z = "SELECT * FROM gs_campuses";
$q = $connect->query($z);
?>
{
    "wiocha" : [
<?php
for($i = 0; $rec = $q->fetch_assoc(); $i++) {
    if($i != 0) echo ",\n";
    echo '      {"x":"'.$rec["x_coord"].'", "y":"'.$rec["y_coord"].'"}';
}
?>   
    ]
}
<?php
$q->free_result();
$connect->close();
?>