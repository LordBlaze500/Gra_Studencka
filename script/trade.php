<?php
require_once "db_connect.php";
require_once "resource.php";
require_once "style.php";
include "raport.php";

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
            $z1 = "SELECT id_owner, name, x_coord, y_coord, login FROM gs_campuses JOIN gs_users ON (gs_campuses.id_owner = gs_users.id_user) WHERE id_campus = ".$rec["id_owner"];
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
                 '<td>'.$rec1["login"].', '.$rec1['name'].'('.$rec1['x_coord'].'|'.$rec1['y_coord'].')</td><td><form method="post"><input type="hidden" name="offer_id" value="'.$rec["id_offer"].'" /><input type="submit" name="buy" value="Kup" />';
                 
            if($_SESSION["id_campus"] == $rec["id_owner"])
                echo '<input type="submit" name="delete_offer" value="Anuluj" />';
                 
            echo  '</form></td>'.
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
                    $ID_Campus = $_SESSION['id_campus'];
                    $SQL_String = "SELECT traders FROM gs_campuses WHERE id_campus=$ID_Campus";
                    $Query = self::$connect->Query($SQL_String);
                    $Record = $Query->fetch_assoc();
                    $Traders = $Record['traders'];
                    $Traders_Needed = ceil(($rec['vodka_cost'] + $rec['kebab_cost'] + $rec['wifi_cost'])/1000);
                    $Traders_Needed_Seller = ceil(($rec['vodka'] + $rec['kebab'] + $rec['wifi'])/1000);
                    if ($Traders >= $Traders_Needed)
                    {
                        $New_Traders = $Traders - $Traders_Needed;
                        $SQL_String = "UPDATE gs_campuses SET traders=$New_Traders WHERE id_campus=$ID_Campus";
                        $Query = self::$connect->Query($SQL_String);
                        $vodka_amount->Decrease($rec["vodka_cost"]);
                        $kebab_amount->Decrease($rec["kebab_cost"]);
                        $wifi_amount->Decrease($rec["wifi_cost"]);  
                        $ID_Owner = $rec['id_owner'];
                        $Vodka = $rec['vodka'];
                        $Kebab = $rec['kebab'];
                        $Wifi = $rec['wifi'];
                        $Vodka_Cost = $rec['vodka_cost'];
                        $Kebab_Cost = $rec['kebab_cost'];
                        $Wifi_Cost = $rec['wifi_cost'];
                        $SQL_String = "SELECT x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Campus";
                        $Query = self::$connect->Query($SQL_String);
                        $Record = $Query->fetch_assoc();
                        $X_A = $Record['x_coord']; $Y_A = $Record['y_coord'];
                        $SQL_String = "SELECT x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Owner";
                        $Query = self::$connect->Query($SQL_String);
                        $Record = $Query->fetch_assoc();
                        $X_B = $Record['x_coord']; $Y_B = $Record['y_coord'];
                        $Distance = abs($X_A - $X_B) + abs($Y_A - $Y_B);
                        $Arrival_Time = new DateTime();
                        $Arrival_Time->add(new DateInterval('PT'.(10*$Distance).'M'));
                        $Date_String = $Arrival_Time->format('Y-m-d H:i:00');

                        $SQL_String = "INSERT INTO gs_trading_moves (id_source, id_destination, traders, vodka, kebab, wifi, arrival_time, going_back) VALUES
                        ($ID_Owner, $ID_Campus, $Traders_Needed_Seller, $Vodka, $Kebab, $Wifi, '$Date_String', 0)";
                        $Query = self::$connect->Query($SQL_String);
                        $SQL_String = "INSERT INTO gs_trading_moves (id_source, id_destination, traders, vodka, kebab, wifi, arrival_time, going_back) VALUES
                        ($ID_Campus, $ID_Owner, $Traders_Needed, $Vodka_Cost, $Kebab_Cost, $Wifi_Cost, '$Date_String', 0)";
                        $Query = self::$connect->Query($SQL_String);

                        $Raport = new Deal_Raport($offer_id);
                        $Raport->Send($ID_Owner, $ID_Campus);
                    
                    $z = "DELETE FROM gs_trade_offers WHERE id_offer = $offer_id";
                    $q = self::$connect->query($z);
                    
                    echo '<center><font size=4 color="yellow"><b>Dokonano zakupu</b></font></center>';
                    }
                    else
                    {
                        echo '<center><font size=4 color="yellow"><b>Masz za mało</b></font></center>';
                    }
                    //$vodka_amount->Increase($rec["vodka"]);
                    //$kebab_amount->Increase($rec["kebab"]);
                    //$wifi_amount->Increase($rec["wifi"]); 
 
                    //$seller_vodka_amount->Increase($rec["vodka_cost"]);
                    //$seller_kebab_amount->Increase($rec["kebab_cost"]);
                    //$seller_wifi_amount->Increase($rec["wifi_cost"]);   

                    // RAPORT TRADE HERE
                }
            }
        }
    }
    
    public static function delete_offer($offer_id) {
        if(Trade::validate_count($offer_id)) {
            $new = new Trade;
            $z = "SELECT vodka, kebab, wifi, id_owner FROM gs_trade_offers WHERE id_offer = ".$offer_id;
            $q = self::$connect->query($z);
            $rec = $q->fetch_assoc();
            
            if($rec["id_owner"] == $_SESSION["id_campus"]) {
                $ID_Campus = $rec['id_owner'];
                $SQL_String = "SELECT traders FROM gs_campuses WHERE id_campus=$ID_Campus";
                $Query = self::$connect->Query($SQL_String);
                $Record = $Query->fetch_assoc();

                $Vodka = new Resource('vodka', $_SESSION['id_campus']);
                $Kebab = new Resource('kebab', $_SESSION['id_campus']);
                $Wifi = new Resource('wifi', $_SESSION['id_campus']);
                $Vodka->Increase($rec['vodka']);
                $Kebab->Increase($rec['kebab']);
                $Wifi->Increase($rec['wifi']);
                $New_Traders = $Record['traders'] + ceil(($rec['vodka'] + $rec['kebab'] + $rec['wifi'])/1000);
                $SQL_String = "UPDATE gs_campuses SET traders=$New_Traders WHERE id_campus=$ID_Campus";
                $Query = self::$connect->Query($SQL_String);

                $z = "DELETE FROM gs_trade_offers WHERE id_offer = ".$offer_id;
                $q = self::$connect->query($z);
                
                if($q) 
                    echo '<center><font size=4 color="yellow"><b>Oferta została usunięta</b></font></center>'; 
                else
                    echo '<center><font size=4 color="yellow"><b>Error</b></font></center>';       
            } else 
                echo '<center><font size=4 color="yellow"><b>To nie jest oferta tego kampusu</b></font></center>';    
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
            $traders_need = ceil(($vodka + $kebab + $wifi) / 1000);
            $z = "SELECT traders FROM gs_campuses WHERE id_campus = ".$_SESSION["id_campus"];  
            $q = self::$connect->query($z);
            $traders = $q->fetch_assoc()["traders"];                    
            
            if($vodka > $vodka_amount->Amount_Getter() || $kebab > $kebab_amount->Amount_Getter() || $wifi > $wifi_amount->Amount_Getter() || $traders_need > $traders) { 
                if($traders_need > $traders)
                    echo '<center><font size=4 color="yellow"><b>Masz za mało handlarzy</b></font></center>';
                else
                    echo '<center><font size=4 color="yellow"><b>Masz za mało surowców</b></font></center>';
            } else {
                $z = "INSERT INTO gs_trade_offers (id_owner, vodka, kebab, wifi, vodka_cost, kebab_cost, wifi_cost) VALUES ($id_user, $vodka, $kebab, $wifi, $vodka_cost, $kebab_cost, $wifi_cost)";
                $q = self::$connect->query($z);
                
                $vodka_amount->Decrease($vodka);
                $kebab_amount->Decrease($kebab);
                $wifi_amount->Decrease($wifi);
                $ID_Campus = $_SESSION['id_campus'];
                $z = "UPDATE gs_campuses SET traders = ".($traders - $traders_need)." WHERE id_campus=$ID_Campus";
                $q1 = self::$connect->query($z); 
                                                       
                if($q && $q1) echo '<center><font size=4 color="yellow"><b>Aukcja została dodana</b></font></center>';
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