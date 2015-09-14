<?php
require "db_connect.php";
$connect = new mysqli($db_host, $db_user, $db_password, $db_name);

$z = "SELECT * FROM gs_campuses JOIN gs_users ON (gs_campuses.id_owner = gs_users.id_user)";
$q = $connect->query($z);
?>
{
    "wiocha" : [
<?php
for($i = 0; $rec = $q->fetch_assoc(); $i++) {
    if($i != 0) echo ",\n";
    echo '      {"x":"'.$rec["x_coord"].'", "y":"'.$rec["y_coord"].'", "name":"'.$rec["name"].'", "owner":"'.$rec["login"].'"}';
}
?>   
    ]
}
<?php
$q->free_result();
$connect->close();
?>                                             