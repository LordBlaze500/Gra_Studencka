<?php
include "db_connect.php";
include "army.php";
include "list.php";
include "raport.php";
$Connect = new mysqli($db_host, $db_user, $db_password, $db_name);
$Arrival_Time = new DateTime();
$Date_String = $Arrival_Time->format('Y-m-d H:i:00');
$SQL_String = "SELECT id_move, strike FROM gs_moves WHERE arrival_time <= '$Date_String'";
$Query = $Connect->Query($SQL_String);
while ($Record = $Query->fetch_assoc())
{
	if ($Record['strike'] == 1)
	{
		echo "dupxo";
		$Luck = rand(-20, 20);
		$Move = new Move($Record['id_move']);
		$Destination = $Move->ID_Destination_Getter();
		$SQL_String_2 = "SELECT id_army FROM gs_armies WHERE id_stayingcampus=$Destination";
		$Query_2 = $Connect->Query($SQL_String_2);
		$i = 0;
		$Defending_Armies = new My_List();
		//$Raport = new Battle_Raport($Luck, $Move, $Defending_Armies);
		while ($Record_2 = $Query_2->fetch_assoc())
		{
			$Defending_Armies->Insert(new Army($Record_2['id_army']));
			$i = $i + 1;
		}
		$Defenders_Attack_Light = 0;
		$Defenders_Attack_Heavy = 0;
		$Defenders_Attack_Cavalry = 0;
		$Defenders_Status = 0;
		while ($Move->Army_Getter()->Exterminated() == 0 && $Defenders_Status < $i)
		{
			for ($j = 0; $j < $i; $j = $j + 1)
		    {
	            $Defenders_Attack_Light = $Defenders_Attack_Light + $Defending_Armies->At($j)->Total_Attack_Light_Getter();
                $Defenders_Attack_Heavy = $Defenders_Attack_Heavy + $Defending_Armies->At($j)->Total_Attack_Heavy_Getter();
                $Defenders_Attack_Cavalry = $Defenders_Attack_Cavalry + $Defending_Armies->At($j)->Total_Attack_Cavalry_Getter();
	    	}
		    $Aggressor_Attack_Light = ($Move->Army_Getter()->Total_Attack_Light_Getter())*(1+($Luck/100));
	    	$Aggressor_Attack_Heavy = ($Move->Army_Getter()->Total_Attack_Heavy_Getter())*(1+($Luck/100));
	    	$Aggressor_Attack_Cavalry = ($Move->Army_Getter()->Total_Attack_Cavalry_Getter())*(1+($Luck/100));
            for ($j = 0; $j < $i; $j = $j + 1)
            {        
                $Light_Fraction = floor($Aggressor_Attack_Light/$i);
                $Aggressor_Attack_Light = $Aggressor_Attack_Light - $Light_Fraction;
                $Aggressor_Attack_Light = $Aggressor_Attack_Light + $Defending_Armies->At($j)->Hit_Light($Light_Fraction);
                $Heavy_Fraction = floor($Aggressor_Attack_Heavy/$i);
                $Aggressor_Attack_Heavy = $Aggressor_Attack_Heavy - $Heavy_Fraction;
                $Aggressor_Attack_Heavy = $Aggressor_Attack_Heavy + $Defending_Armies->At($j)->Hit_Heavy($Heavy_Fraction);
                $Cavalry_Fraction = floor($Aggressor_Attack_Cavalry/$i);
                $Aggressor_Attack_Cavalry = $Aggressor_Attack_Cavalry - $Cavalry_Fraction;
                $Aggressor_Attack_Cavalry = $Aggressor_Attack_Cavalry + $Defending_Armies->At($j)->Hit_Cavalry($Cavalry_Fraction);
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
           $Move->Steal();
           $Move->Returning();
           $SQL_String_3 = "SELECT obedience FROM gs_campuses WHERE id_campus=$Destination";
           $Query_3 = $Connect->Query($SQL_String_3);
           $Record_3 = $Query_3->fetch_assoc();
           $New_Obedience = $Record_3['obedience'] - rand(10,20);
           if ($New_Obedience <= 0)
           {
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
           $ID_Army = $Move->Army_Getter()->ID_Army_Getter();
           $SQL_String_3 = "DELETE FROM gs_armies WHERE id_army=$ID_Army";
           $Query_3 = $Connect->Query($SQL_String_3);
           $ID_Move = $Record['id_move'];
           $SQL_String_3 = "DELETE FROM gs_moves WHERE id_move=$ID_Move";
           $Query_3 = $Connect->Query($SQL_String_3);
        }
	}
	if ($Record['strike'] == 2)
	{
		echo "dupapaa";
        $Move = new Move($Record['id_move']);
        $Move->Delivery();
        $Destination = $Move->ID_Destination_Getter();
        $SQL_String_2 = "SELECT id_army FROM gs_armies WHERE id_homecampus=$Destination AND id_stayingcampus=$Destination";
        echo $SQL_String_2;
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
        $SQL_String_2 = "DELETE FROM gs_moves WHERE id_move=$ID_Move";
        $Query_2 = $Connect->Query($SQL_String_2);
	}
}

$Connect->close();
?>