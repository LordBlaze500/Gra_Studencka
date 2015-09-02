<?php
/*
require "db_connect.php";
$connect = new mysqli($db_host, $db_user, $db_password, $db_name);

for($i = 0; $i < 10; $i++) {
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
    
    $z = "INSERT INTO gs_campuses (x_coord, y_coord) VALUES ($pos_x, $pos_y)";
    $q = $connect->query($z);
}

$connect->close();
*/
?>