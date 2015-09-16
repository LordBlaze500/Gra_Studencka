<?php
include "db_connect.php";
include "army.php";
include "list.php";
include "raport.php";
include "resource.php";
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
$Arrival_Time = new DateTime();
$Date_String = $Arrival_Time->format('Y-m-d H:i:00');
$SQL_String = "SELECT id_move, strike FROM gs_moves WHERE arrival_time <= '$Date_String'";
$Query = $Connect->Query($SQL_String);
while ($Record = $Query->fetch_assoc())
{
	if ($Record['strike'] == 1)
	{
    if (date('H') > 21 || date('H') < 6) $Bonus = 2;
    else $Bonus = 1;
    echo 'date h: ';
    echo date('H');
    echo '<br/>';
    $Bonus_Set = 0;
    $Raport = new Battle_Raport();
		$Luck = rand(0, 20);
    $Raport->Luck_Setter($Luck);
		$Move = new Move($Record['id_move']);
    $Raport->Aggressor_Army_Before_Setter($Move->Army_Getter());
		$Destination = $Move->ID_Destination_Getter();
    $Raport->Source_Setter($Move->ID_Source_Getter());
    $Raport->Destination_Setter($Destination);
		$SQL_String_2 = "SELECT id_army FROM gs_armies WHERE id_stayingcampus=$Destination";
		$Query_2 = $Connect->Query($SQL_String_2);
		$i = 0;
		$Defending_Armies = new My_List();
		while ($Record_2 = $Query_2->fetch_assoc())
		{
			$Defending_Armies->Insert(new Army($Record_2['id_army']));
			$i = $i + 1;
		}
    $Raport->Defending_Armies_Before_Setter($Defending_Armies);
		$Defenders_Attack_Light = 0;
		$Defenders_Attack_Heavy = 0;
		$Defenders_Attack_Cavalry = 0;
		$Defenders_Status = 0;
		while ($Move->Army_Getter()->Exterminated() == 0 && $Defenders_Status < $i)
		{
      $Defenders_Attack_Light = 0;
      $Defenders_Attack_Heavy = 0;
      $Defenders_Attack_Cavalry = 0;
			for ($j = 0; $j < $i; $j = $j + 1)
		    {
	            $Defenders_Attack_Light = $Defenders_Attack_Light + $Defending_Armies->At($j)->Total_Attack_Light_Getter();
              $Defenders_Attack_Heavy = $Defenders_Attack_Heavy + $Defending_Armies->At($j)->Total_Attack_Heavy_Getter();
              $Defenders_Attack_Cavalry = $Defenders_Attack_Cavalry + $Defending_Armies->At($j)->Total_Attack_Cavalry_Getter();
	    	}
        if ($Bonus_Set == 0)
        {
           $Defenders_Attack_Light = $Defenders_Attack_Light * $Bonus;
           $Defenders_Attack_Heavy = $Defenders_Attack_Heavy * $Bonus;
           $Defenders_Attack_Cavalry = $Defenders_Attack_Cavalry * $Bonus;
           $Bonus_Set = 1;
        }
		    $Aggressor_Attack_Light = ($Move->Army_Getter()->Total_Attack_Light_Getter())*(1+($Luck/100));
	    	$Aggressor_Attack_Heavy = ($Move->Army_Getter()->Total_Attack_Heavy_Getter())*(1+($Luck/100));
	    	$Aggressor_Attack_Cavalry = ($Move->Army_Getter()->Total_Attack_Cavalry_Getter())*(1+($Luck/100));
        $Aggressor_Attack_Light_In_Total = $Aggressor_Attack_Light;
        $Aggressor_Attack_Heavy_In_Total = $Aggressor_Attack_Heavy;
        $Aggressor_Attack_Cavalry_In_Total = $Aggressor_Attack_Cavalry;
            for ($j = 0; $j < $i; $j = $j + 1)
            {        
                if ($j+1 == $i)
                {
                   $Defending_Armies->At($j)->Hit_Light($Aggressor_Attack_Light);
                   $Defending_Armies->At($j)->Hit_Heavy($Aggressor_Attack_Heavy);
                   $Defending_Armies->At($j)->Hit_Cavalry($Aggressor_Attack_Cavalry);
                }
                else
                {
                   $Light_Fraction = floor($Aggressor_Attack_Light_In_Total/$i);
                   $Aggressor_Attack_Light = $Aggressor_Attack_Light - $Light_Fraction;
                   $Aggressor_Attack_Light = $Aggressor_Attack_Light + $Defending_Armies->At($j)->Hit_Light($Light_Fraction);
                   $Heavy_Fraction = floor($Aggressor_Attack_Heavy_In_Total/$i);
                   $Aggressor_Attack_Heavy = $Aggressor_Attack_Heavy - $Heavy_Fraction;
                   $Aggressor_Attack_Heavy = $Aggressor_Attack_Heavy + $Defending_Armies->At($j)->Hit_Heavy($Heavy_Fraction);
                   $Cavalry_Fraction = floor($Aggressor_Attack_Cavalry_In_Total/$i);
                   $Aggressor_Attack_Cavalry = $Aggressor_Attack_Cavalry - $Cavalry_Fraction;
                   $Aggressor_Attack_Cavalry = $Aggressor_Attack_Cavalry + $Defending_Armies->At($j)->Hit_Cavalry($Cavalry_Fraction);
                }
            }

            $Move->Army_Getter()->Hit_Light($Defenders_Attack_Light);
            $Move->Army_Getter()->Hit_Heavy($Defenders_Attack_Heavy);
            $Move->Army_Getter()->Hit_Cavalry($Defenders_Attack_Cavalry);
            $Defenders_Status = 0;
            for ($j = 0; $j < $i; $j = $j + 1)
            {
                $Defenders_Status = $Defenders_Status + $Defending_Armies->At($j)->Exterminated();
            }
		}
		if ($Defenders_Status > 0)
		{
			for ($j = 0; $j < $i; $j = $j + 1)
			{
				if ($Defending_Armies->At($j)->Exterminated() == 1 && $Defending_Armies->At($j)->ID_Homecampus_Getter() != $Defending_Armies->At($j)->ID_Stayingcampus_Getter())
				{
					$ID_Army = $Defending_Armies->At($j)->ID_Army_Getter();
					$SQL_String_3 = "DELETE FROM gs_armies WHERE id_army=$ID_Army";
					$Query_3 = $Connect->Query($SQL_String_3);
				}
			}
		}
        if ($Defenders_Status == $i)
        {
           $SQL_String_3 = "SELECT amount_vodka, amount_kebab, amount_wifi FROM gs_campuses WHERE id_campus=$Destination";
           $Query_3 = $Connect->Query($SQL_String_3);
           $Record_3 = $Query_3->fetch_assoc();
           $Vodka_Before = $Record_3['amount_vodka'];
           $Kebab_Before = $Record_3['amount_kebab'];
           $Wifi_Before = $Record_3['amount_wifi'];
           $Move->Steal();
           $SQL_String_3 = "SELECT amount_vodka, amount_kebab, amount_wifi FROM gs_campuses WHERE id_campus=$Destination";
           $Query_3 = $Connect->Query($SQL_String_3);
           $Record_3 = $Query_3->fetch_assoc();
           $Vodka_After = $Record_3['amount_vodka'];
           $Kebab_After = $Record_3['amount_kebab'];
           $Wifi_After = $Record_3['amount_wifi'];
           $Raport->Stolen_Setter($Vodka_Before - $Vodka_After, $Kebab_Before - $Kebab_After, $Wifi_Before - $Wifi_After);
           $Move->Returning();
           $Raport->Result_Setter(2);
           $Raport->Defending_Armies_After_Setter(NULL);
           $Raport->Aggressor_Army_After_Setter($Move->Army_Getter());
           $SQL_String_3 = "SELECT obedience FROM gs_campuses WHERE id_campus=$Destination";
           $Query_3 = $Connect->Query($SQL_String_3);
           $Record_3 = $Query_3->fetch_assoc();
           $Obedience_Decrease = rand(10,20);
           $Raport->Obedience_Loss_Setter($Obedience_Decrease, $Record_3['obedience']);
           $New_Obedience = $Record_3['obedience'] - $Obedience_Decrease;
           if ($New_Obedience <= 0)
           {
              $Raport->Send();
           	  $Source = $Move->ID_Source_Getter();
           	  $SQL_String_3 = "SELECT id_owner FROM gs_campuses WHERE id_campus=$Source";
           	  $Query_3 = $Connect->Query($SQL_String_3);
           	  $Record_3 = $Query_3->fetch_assoc();
           	  $ID_Aggressor = $Record_3['id_owner'];
           	  $SQL_String_3 = "UPDATE gs_campuses SET id_owner=$ID_Aggressor, obedience=25 WHERE id_campus=$Destination";
           	  $Query_3 = $Connect->Query($SQL_String_3);
           }
           else
           {
           	  $SQL_String_3 = "UPDATE gs_campuses SET obedience=$New_Obedience WHERE id_campus=$Destination";
           	  $Query_3 = $Connect->Query($SQL_String_3);
           }
        }
        if ($Move->Army_Getter()->Exterminated() == 1)
        {
           $Raport->Result_Setter(1);
           $Raport->Defending_Armies_After_Setter($Defending_Armies);
           $Raport->Aggressor_Army_After_Setter(NULL);
           $ID_Army = $Move->Army_Getter()->ID_Army_Getter();
           $SQL_String_3 = "DELETE FROM gs_armies WHERE id_army=$ID_Army";
           $Query_3 = $Connect->Query($SQL_String_3);
           $ID_Move = $Record['id_move'];
           $SQL_String_3 = "DELETE FROM gs_moves WHERE id_move=$ID_Move";
           $Query_3 = $Connect->Query($SQL_String_3);
           $Raport->Send();
        }
        
	}
	if ($Record['strike'] == 2)
	{
        $Move = new Move($Record['id_move']);
        $Move->Delivery();
        $Destination = $Move->ID_Destination_Getter();
        $SQL_String_2 = "SELECT id_army FROM gs_armies WHERE id_homecampus=$Destination AND id_stayingcampus=$Destination";
        $Query_2 = $Connect->Query($SQL_String_2);
        $Record_2 = $Query_2->fetch_assoc();
        $ID_Army = $Record_2['id_army'];
        $Original_Army = new Army($ID_Army);
        $Original_Army->Unite($Move->Army_Getter()->ID_Army_Getter());
        $ID_Move = $Record['id_move'];
        $SQL_String_2 = "DELETE FROM gs_moves WHERE id_move=$ID_Move";
        $Query_2 = $Connect->Query($SQL_String_2);
	}
	if ($Record['strike'] == 0)
	{
		$Move = new Move($Record['id_move']);
		$ID_Army = $Move->Army_Getter()->ID_Army_Getter();
		$Destination = $Move->ID_Destination_Getter();
		$SQL_String_2 = "UPDATE gs_armies SET id_stayingcampus=$Destination WHERE id_army=$ID_Army";
		$Query_2 = $Connect->Query($SQL_String_2);
		$ID_Move = $Record['id_move'];
    $Raport = new Support_Raport($ID_Move);
    $Raport->Send();
    $SQL_String_2 = "DELETE FROM gs_moves WHERE id_move=$ID_Move";
    $Query_2 = $Connect->Query($SQL_String_2);
	}
}

$SQL_String = "SELECT id_trading_move, id_source, id_destination, traders, vodka, kebab, wifi, going_back FROM gs_trading_moves WHERE arrival_time <= '$Date_String'";
$Query = $Connect->Query($SQL_String);
while ($Record = $Query->fetch_assoc())
{  
   if ($Record['going_back'] == 0)
   {
      $ID_Move = $Record['id_trading_move'];
      $Source = $Record['id_source'];
      $Destination = $Record['id_destination'];
      $Traders = $Record['traders'];
      $Vodka = new Resource('vodka', $Destination);
      $Kebab = new Resource('kebab', $Destination);
      $Wifi = new Resource('wifi', $Destination);
      $Vodka->Increase($Record['vodka']);
      $Kebab->Increase($Record['kebab']);
      $Wifi->Increase($Record['wifi']);
      $SQL_String = "DELETE FROM gs_trading_moves WHERE id_trading_move=$ID_Move";
      $Query_2 = $Connect->Query($SQL_String);
      $SQL_String = "SELECT x_coord, y_coord FROM gs_campuses WHERE id_campus=$Source";
      $Query_3 = $Connect->Query($SQL_String);
      $Record_3 = $Query_3->fetch_assoc();
      $X_Source = $Record_3['x_coord'];
      $Y_Source = $Record_3['y_coord'];
      $SQL_String = "SELECT x_coord, y_coord FROM gs_campuses WHERE id_campus=$Destination";
      $Query_4 = $Connect->Query($SQL_String);
      $Record_4 = $Query_4->fetch_assoc();
      $X_Destination = $Record_4['x_coord'];
      $Y_Destination = $Record_4['y_coord'];
      $Distance = abs($X_Source - $X_Destination) + abs($Y_Source - $Y_Destination);
      $Arrival_Time = new DateTime(); 
      $Arrival_Time->add(new DateInterval('PT'.(10*$Distance).'M'));
      $Date_String = $Arrival_Time->format('Y-m-d H:i:00');
      $SQL_String = "INSERT INTO gs_trading_moves (id_source, id_destination, traders, vodka, kebab, wifi, arrival_time, going_back) VALUES ($Destination, $Source, $Traders, 0, 0, 0, '$Date_String', 1)";
      $Query_5 = $Connect->Query($SQL_String);
   }
   else
   {
      $ID_Move = $Record['id_trading_move'];
      $Raport = new Delivery_Raport($ID_Move);
      $Raport->Send();
      $Traders = $Record['traders'];
      $Destination = $Record['id_destination'];
      $SQL_String = "SELECT traders FROM gs_campuses WHERE id_campus=$Destination";
      $Query_2 = $Connect->Query($SQL_String);
      $Record_2 = $Query_2->fetch_assoc();
      $Old_Traders = $Record_2['traders'];
      $New_Traders = $Old_Traders + $Traders;
      $SQL_String = "UPDATE gs_campuses SET traders=$New_Traders WHERE id_campus=$Destination";
      $Query_3 = $Connect->Query($SQL_String);
      $SQL_String = "DELETE FROM gs_trading_moves WHERE id_trading_move=$ID_Move";
      $Query_4 = $Connect->Query($SQL_String);
   }

}

$Connect->close();
?>