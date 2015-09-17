<?php
require_once "db_connect.php";
require_once "resource.php";
require_once "style.php";

class Trade {
    private static $connect;
    private static $obj_counter;
    
    
    public static function validate_count($data) {
        if(is_numeric($data) && $data != "" && $data >= 0)  
            return true;
        else
            return false;          
    }
    
    public static function show_offers() {  
        $new = new Trade;              
        $z = "SELECT * FROM gs_trade_offers";
        $q = self::$connect->query($z);        
           
        echo '<table border="0">'."\n".
             '<tr bgcolor="FFBF00"><td>Oferta</td><td>Cena</td><td>Sprzedający</td><td>Opcje</td></tr>'."\n";
        
        while($rec = $q->fetch_assoc()) {
            $z1 = "SELECT id_owner, login FROM gs_campuses JOIN gs_users ON (gs_campuses.id_owner = gs_users.id_user) WHERE id_campus = ".$rec["id_owner"];
            $q1 = self::$connect->query($z1);
            $rec1 = $q1->fetch_assoc();
            //JOIN gs_users ON (gs_users.id_user = gs_campuses.id_owner) 
            echo '<tr bgcolor="FFBF00"><td width="200">'.
                 '<img src="img/wodka.png" alt="Wodka" width="30" height="30">'.$rec["vodka"].
                 '<img src="img/kebab.png" alt="Kebab" width="30" height="30">'.$rec["kebab"].
                 '<img src="img/wifi.png" alt="Wifi" width="30" height="30">'.$rec["wifi"].'</td><td width="200">'.
                 '<img src="img/wodka.png" alt="Wodka" width="30" height="30">'.$rec["vodka_cost"].
                 '<img src="img/kebab.png" alt="Kebab" width="30" height="30">'.$rec["kebab_cost"].
                 '<img src="img/wifi.png" alt="Wifi" width="30" height="30">'.$rec["wifi_cost"].'</td>'.
                 '<td>'.$rec1["login"].'</td><td><form method="post"><input type="hidden" name="offer_id" value="'.$rec["id_offer"].'" /><input type="submit" name="buy" value="Kup" /></form></td>'.
                 '</tr>'."\n";
                 
        } 
        
        echo "</table>\n"; 
    }
    
    public static function buy_offer($offer_id) {
        $new = new Trade;
        $vodka_amount = new Resource('vodka', $_SESSION["id_campus"]);
        $kebab_amount = new Resource('kebab', $_SESSION["id_campus"]);
        $wifi_amount = new Resource('wifi', $_SESSION["id_campus"]); 
        
        $z = "SELECT * FROM gs_trade_offers WHERE id_offer = $offer_id";
        $q = self::$connect->query($z);
        if($q->num_rows != 0) {
            $rec = $q->fetch_assoc();
            
            $seller_vodka_amount = new Resource('vodka', $rec["id_owner"]);
            $seller_kebab_amount = new Resource('kebab', $rec["id_owner"]);
            $seller_wifi_amount = new Resource('wifi', $rec["id_owner"]); 
            
            if($rec["vodka_cost"] > $vodka_amount->Amount_Getter() || $rec["kebab_cost"] > $kebab_amount->Amount_Getter() || $rec["wifi_cost"] > $wifi_amount->Amount_Getter()) 
                echo '<center><font size=4 color="yellow"><b>Masz za mało surowców</b></font></center>';
            else {  
                if($_SESSION["id_campus"] == $rec["id_owner"]) 
                    echo '<center><font size=4 color="yellow"><b>Błąd</b></font></center>';
                else {                                       
                    $vodka_amount->Increase($rec["vodka"]);
                    $kebab_amount->Increase($rec["kebab"]);
                    $wifi_amount->Increase($rec["wifi"]); 
                    $vodka_amount->Decrease($rec["vodka_cost"]);
                    $kebab_amount->Decrease($rec["kebab_cost"]);
                    $wifi_amount->Decrease($rec["wifi_cost"]);   
                    $seller_vodka_amount->Increase($rec["vodka_cost"]);
                    $seller_kebab_amount->Increase($rec["kebab_cost"]);
                    $seller_wifi_amount->Increase($rec["wifi_cost"]);   
                    
                    $z = "DELETE FROM gs_trade_offers WHERE id_offer = $offer_id";
                    $q = self::$connect->query($z);
                    
                    echo '<center><font size=4 color="yellow"><b>Dokonano zakupu</b></font></center>';
                }
            }
        }
    }
    
    public function __construct($id_user=-1, $vodka=-1, $kebab=-1, $wifi=-1, $vodka_cost=-1, $kebab_cost=-1, $wifi_cost=-1) {        
        if(!self::$obj_counter) self::$connect = new mysqli($GLOBALS["db_host"], $GLOBALS["db_user"], $GLOBALS["db_password"], $GLOBALS["db_name"]);
        ++self::$obj_counter;
        //-------------------
        
        if($id_user != -1 && $vodka != -1 && $kebab != -1 && $wifi != -1 && $vodka_cost != -1 && $kebab_cost != -1 && $wifi_cost != -1) {
            $vodka_amount = new Resource('vodka', $_SESSION["id_campus"]);
            $kebab_amount = new Resource('kebab', $_SESSION["id_campus"]);
            $wifi_amount = new Resource('wifi', $_SESSION["id_campus"]);                
            
            if($vodka > $vodka_amount->Amount_Getter() || $kebab > $kebab_amount->Amount_Getter() || $wifi > $wifi_amount->Amount_Getter()) 
              echo '<center><font size=4 color="yellow"><b>Masz za mało surowców</b></font></center>';
            else {
                $z = "INSERT INTO gs_trade_offers (id_owner, vodka, kebab, wifi, vodka_cost, kebab_cost, wifi_cost) VALUES ($id_user, $vodka, $kebab, $wifi, $vodka_cost, $kebab_cost, $wifi_cost)";
                $q = self::$connect->query($z);
                
                $vodka_amount->Decrease($vodka);
                $kebab_amount->Decrease($kebab);
                $wifi_amount->Decrease($wifi);
                       
                if($q) echo '<center><font size=4 color="yellow"><b>Aukcja została dodana</b></font></center>';
                else '<center><font size=4 color="yellow"><b>Error</b></font></center>';
            } 
        }                   
    }
    
    public function __destruct() {
        --self::$obj_counter;
        if(!self::$obj_counter) self::$connect->close();
    }    
}

//CREATE TABLE gs_trade_offers (id_offer int NOT NULL PRIMARY KEY AUTO_INCREMENT, id_owner int NOT NULL, vodka int NOT NULL, kebab int NOT NULL, wifi int NOT NULL, vodka_cost int NOT NULL, kebab_cost int NOT NULL, wifi_cost int NOT NULL)
?>