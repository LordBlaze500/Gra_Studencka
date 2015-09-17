<?php
if (!defined('__ARMY_PHP__'))
{
   define('__ARMY_PHP__',1);
   include "db_connect.php";
   include "resource.php";

   class Troops_Type
   {
      private static $Connect;
      private static $Object_Counter;
      private $Name;
      private $Cost_Vodka;
      private $Cost_Kebab;
      private $Cost_Wifi;
      private $Attack_Light;
      private $Attack_Heavy;
      private $Attack_Cavalry;
      private $HP;   
      private $Speed;
      private $Capacity;
      private $Type;
      public function __construct($Arg_Name)
      {
         if (self::$Object_Counter == 0)
         {
            self::$Connect = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
         }
         self::$Object_Counter = self::$Object_Counter + 1;
         $this->Name = $Arg_Name;
         $SQL_String = "SELECT * FROM gs_troops WHERE name='$this->Name'";
         $Query = self::$Connect->query($SQL_String);
         $Record = $Query->fetch_assoc();
         $this->Cost_Vodka = $Record['cost_vodka'];
         $this->Cost_Kebab = $Record['cost_kebab'];
         $this->Cost_Wifi = $Record['cost_wifi'];
         $this->HP = $Record['hp'];
         $this->Attack_Light = $Record['attack_light'];
         $this->Attack_Heavy = $Record['attack_heavy'];
         $this->Attack_Cavalry = $Record['attack_cavalry'];
         $this->Speed = $Record['speed'];
         $this->Capacity = $Record['capacity'];
         $this->Type = $Record['type'];
      }
      public function Name_Getter()
      {
         return $this->Name;
      }
      public function Cost_Vodka_Getter()
      {
         return $this->Cost_Vodka;
      }
      public function Cost_Kebab_Getter()
      {
         return $this->Cost_Kebab;
      }
      public function Cost_Wifi_Getter()
      {
         return $this->Cost_Wifi;
      }
      public function Attack_Light_Getter()
      {
         return $this->Attack_Light;
      }
      public function Attack_Heavy_Getter()
      {
         return $this->Attack_Heavy;
      }
      public function Attack_Cavalry_Getter()
      {
         return $this->Attack_Cavalry;
      }
      public function Speed_Getter()
      {
         return $this->Speed;
      }
      public function HP_Getter()
      {
         return $this->HP;
      }
      public function Capacity_Getter()
      {
         return $this->Capacity;
      }
      public function Costs_Display()
      {
         echo '<img src="img/wodka.png" width="30" height="30">';
         echo $this->Cost_Vodka;
         echo '<img src="img/kebab.png" width="30" height="30">';
         echo $this->Cost_Kebab;
         echo '<img src="img/wifi.png" width="30" height="30">';
         echo $this->Cost_Wifi;
      }
      public function Statistics_Display()
      {  
         if ($this->Type == 1)
         {
            echo '<img src="img/light.png" width="30" height="30">';
            echo 'Lekka piechota';
         }
         if ($this->Type == 2)
         {
            echo '<img src="img/heavy.png" width="30" height="30">';
            echo 'Ciężka piechota';
         }
         if ($this->Type == 3)
         {
            echo '<img src="img/cavalry.png" width="30" height="30">';
            echo 'Kawaleria';
         }
         echo '<img src="img/attackvslight.png" width="30" height="30">';
         echo $this->Attack_Light;
         echo '<img src="img/attackvsheavy.png" width="30" height="30">';
         echo $this->Attack_Heavy;
         echo '<img src="img/attackvscavalry.png" width="30" height="30">';
         echo $this->Attack_Cavalry;  
         echo '<img src="img/health.png" width="30" height="30">';
         echo $this->HP;
         echo '<img src="img/speed.png" width="30" height="30">';
         echo $this->Speed;
         echo '<img src="img/sack.png" width="30" height="30">';
         echo $this->Capacity;
      }
      public function __destruct()
      {
         self::$Object_Counter = self::$Object_Counter - 1;
         if (self::$Object_Counter == 0) self::$Connect->close();
      }
   }

   class Force
   {
      private static $Connect;
      private static $Object_Counter;
      private $ID_Campus;
      private $Update_Flag;
      private $Type;
      private $Number;
      private $Number_In_Total;
      private $Maximum;
      private $ID_Army;
      public function __construct(Troops_Type $Arg_Type, $Arg_ID_Army)
      {
         if (self::$Object_Counter == 0)
         {
            self::$Connect = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
         }
         self::$Object_Counter = self::$Object_Counter + 1;
         $this->Update_Flag = 0;
         $this->ID_Army = $Arg_ID_Army;
         $this->Type = $Arg_Type;
         $Name = $this->Type->Name_Getter();
         $SQL_String = "SELECT $Name FROM gs_armies WHERE id_army=$Arg_ID_Army";
         $Query = self::$Connect->Query($SQL_String);
         $Record = $Query->fetch_assoc();
         $this->Number = $Record[$Name];
         $SQL_String = "SELECT id_homecampus FROM gs_armies WHERE id_army=$Arg_ID_Army";
         $Query = self::$Connect->Query($SQL_String);
         $Record = $Query->fetch_assoc();
         $this->ID_Campus = $Record['id_homecampus'];
         $this->Maximum = 2000;
         if ($Name == 'drunkard' || $Name == 'clochard')
         {
            $SQL_String = "SELECT bench FROM gs_campuses WHERE id_campus=$this->ID_Campus";
            $Query = self::$Connect->Query($SQL_String);
            $Record = $Query->fetch_assoc();
            $Bench = $Record['bench'];
            if ($Bench == 1) $this->Maximum = 2000;
            else $this->Maximum = 1000;
         }
         if ($Name == 'master' || $Name == 'doctor')
         {
            $SQL_String = "SELECT parking FROM gs_campuses WHERE id_campus=$this->ID_Campus";
            $Query = self::$Connect->Query($SQL_String);
            $Record = $Query->fetch_assoc();
            $Parking = $Record['parking'];
            if ($Parking == 1) $this->Maximum = 2000;
            else $this->Maximum = 1000;
         }
         if ($Name == 'inspector' || $Name == 'veteran')
         {
            $SQL_String = "SELECT terminus FROM gs_campuses WHERE id_campus=$this->ID_Campus";
            $Query = self::$Connect->Query($SQL_String);
            $Record = $Query->fetch_assoc();
            $Terminus = $Record['terminus'];
            if ($Terminus == 1) $this->Maximum = 2000;
            else $this->Maximum = 1000;
         }
         $SQL_String = "SELECT $Name FROM gs_armies WHERE id_homecampus=$this->ID_Campus";
         $Query = self::$Connect->Query($SQL_String);
         while ($Record = $Query->fetch_assoc())
         {
            $this->Number_In_Total = $this->Number_In_Total + $Record[$Name];
         }
      }
      public function Type_Getter()
      {
         return $this->Type;
      }
      public function Number_Getter()
      {
         return $this->Number;
      }
      public function Number_In_Total_Getter()
      {
         return $this->Number_In_Total;
      }
      public function Maximum_Getter()
      {
         return $this->Maximum;
      }
      public function Maximum_Possible()
      {
         $Maximum_Possible = $this->Maximum - $this->Number_In_Total;
         $Vodka = new Resource('vodka', $this->ID_Campus);
         $Kebab = new Resource('kebab', $this->ID_Campus);
         $Wifi = new Resource('wifi', $this->ID_Campus);
         if ($this->Type->Cost_Vodka_Getter() != 0)
         {
            $Max_By_Vodka = floor($Vodka->Amount_Getter() / $this->Type->Cost_Vodka_Getter());
            if ($Max_By_Vodka < $Maximum_Possible) $Maximum_Possible = $Max_By_Vodka;
         }
         if ($this->Type->Cost_Kebab_Getter() != 0)
         {
            $Max_By_Kebab = floor($Kebab->Amount_Getter() / $this->Type->Cost_Kebab_Getter());
            if ($Max_By_Kebab < $Maximum_Possible) $Maximum_Possible = $Max_By_Kebab;
         }
         if ($this->Type->Cost_Wifi_Getter() != 0)
         {
            $Max_By_Wifi = floor($Wifi->Amount_Getter() / $this->Type->Cost_Wifi_Getter());
            if ($Max_By_Wifi < $Maximum_Possible) $Maximum_Possible = $Max_By_Wifi;
         }
         return $Maximum_Possible;
      }
      public function Recruit($Arg_Number)
      {
         if ($this->Number_In_Total + $Arg_Number > $this->Maximum) return 3;
         $Vodka = new Resource('vodka', $this->ID_Campus);
         $Kebab = new Resource('kebab', $this->ID_Campus);
         $Wifi = new Resource('wifi', $this->ID_Campus);
         $Vodka_Needed = $Arg_Number * ($this->Type->Cost_Vodka_Getter());
         $Kebab_Needed = $Arg_Number * ($this->Type->Cost_Kebab_Getter());
         $Wifi_Needed = $Arg_Number * ($this->Type->Cost_Wifi_Getter());
         if ($Vodka_Needed > $Vodka->Amount_Getter() || $Kebab_Needed > $Kebab->Amount_Getter() || $Wifi_Needed > $Wifi->Amount_Getter()) return 2;
         $Vodka->Decrease($Vodka_Needed);
         $Kebab->Decrease($Kebab_Needed);
         $Wifi->Decrease($Wifi_Needed);
         $this->Update_Flag = 1;
         $this->Number = $this->Number + $Arg_Number;
         $this->Number_In_Total = $this->Number_In_Total + $Arg_Number;
         return 1;
      }
      public function Increase($Arg_Number)
      {
         $this->Update_Flag = 1;
         $this->Number = $this->Number + $Arg_Number;
         $this->Number_In_Total = $this->Number_In_Total + $Arg_Number;
         while ($this->Number_In_Total > $this->Maximum)
         {
            $this->Number = $this->Number - 1;
            $this->Number_In_Total = $this->Number_In_Total - 1;
         } 
      }
      public function Decrease($Arg_Number)
      {
         $this->Update_Flag = 1;
         $this->Number = $this->Number - $Arg_Number;
         $this->Number_In_Total = $this->Number_In_Total - $Arg_Number;
         while ($this->Number_In_Total < 0)
         {
            $this->Number = $this->Number + 1;
            $this->Number_In_Total = $this->Number_In_Total + 1;
         } 
      }
      public function __destruct()
      {
         if ($this->Update_Flag == 1)
         {
            $Name = $this->Type->Name_Getter();
            $Army_ID = $this->ID_Army;
            $SQL_String = "UPDATE gs_armies SET $Name=$this->Number WHERE id_army=$this->ID_Army";
            $Query = self::$Connect->Query($SQL_String);
         }
         self::$Object_Counter = self::$Object_Counter - 1;
         if (self::$Object_Counter == 0) self::$Connect->close();
      }
   }

   class Army
   {
      private static $Connect;
      private static $Object_Counter;
      private $Update_Flag;
      private $ID_Army;
      private $ID_Homecampus;
      private $ID_Stayingcampus;
      private $Student;
      private $Parachute;
      private $Drunkard;
      private $Clochard;
      private $Nerd;
      private $Stooley;
      private $Master;
      private $Doctor;
      private $Inspector;
      private $Veteran;
      private $Speed;
      public function __construct($Arg_ID_Army)
      {
         if (self::$Object_Counter == 0)
         {
            self::$Connect = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
         }
         self::$Object_Counter = self::$Object_Counter + 1;
         $this->Update_Flag = 0;
         $this->ID_Army = $Arg_ID_Army;
         $SQL_String = "SELECT id_homecampus, id_stayingcampus FROM gs_armies WHERE id_army=$Arg_ID_Army";
         $Query = self::$Connect->Query($SQL_String);
         $Record = $Query->fetch_assoc();
         $this->ID_Homecampus = $Record['id_homecampus'];
         $this->ID_Stayingcampus = $Record['id_stayingcampus'];
         $this->Student = new Force(new Troops_Type('student'), $this->ID_Army);
         $this->Parachute = new Force(new Troops_Type('parachute'), $this->ID_Army);
         $this->Drunkard = new Force(new Troops_Type('drunkard'), $this->ID_Army);
         $this->Clochard = new Force(new Troops_Type('clochard'), $this->ID_Army);
         $this->Nerd = new Force(new Troops_Type('nerd'), $this->ID_Army);
         $this->Stooley = new Force(new Troops_Type('stooley'), $this->ID_Army);
         $this->Master = new Force(new Troops_Type('master'), $this->ID_Army);
         $this->Doctor = new Force(new Troops_Type('doctor'), $this->ID_Army);
         $this->Inspector = new Force(new Troops_Type('inspector'), $this->ID_Army);
         $this->Veteran = new Force(new Troops_Type('veteran'), $this->ID_Army);
         $this->Speed = 0;
         if ($this->Student->Number_Getter() > 0 && $this->Student->Type_Getter()->Speed_Getter() > $this->Speed) $this->Speed = $this->Student->Type_Getter()->Speed_Getter();
         if ($this->Parachute->Number_Getter() > 0 && $this->Parachute->Type_Getter()->Speed_Getter() > $this->Speed) $this->Speed = $this->Parachute->Type_Getter()->Speed_Getter();
         if ($this->Drunkard->Number_Getter() > 0 && $this->Drunkard->Type_Getter()->Speed_Getter() > $this->Speed) $this->Speed = $this->Drunkard->Type_Getter()->Speed_Getter();
         if ($this->Clochard->Number_Getter() > 0 && $this->Clochard->Type_Getter()->Speed_Getter() > $this->Speed) $this->Speed = $this->Clochard->Type_Getter()->Speed_Getter();
         if ($this->Nerd->Number_Getter() > 0 && $this->Nerd->Type_Getter()->Speed_Getter() > $this->Speed) $this->Speed = $this->Nerd->Type_Getter()->Speed_Getter();
         if ($this->Stooley->Number_Getter() > 0 && $this->Stooley->Type_Getter()->Speed_Getter() > $this->Speed) $this->Speed = $this->Stooley->Type_Getter()->Speed_Getter();
         if ($this->Master->Number_Getter() > 0 && $this->Master->Type_Getter()->Speed_Getter() > $this->Speed) $this->Speed = $this->Master->Type_Getter()->Speed_Getter();
         if ($this->Doctor->Number_Getter() > 0 && $this->Doctor->Type_Getter()->Speed_Getter() > $this->Speed) $this->Speed = $this->Doctor->Type_Getter()->Speed_Getter();
         if ($this->Inspector->Number_Getter() > 0 && $this->Inspector->Type_Getter()->Speed_Getter() > $this->Speed) $this->Speed = $this->Inspector->Type_Getter()->Speed_Getter();
         if ($this->Veteran->Number_Getter() > 0 && $this->Veteran->Type_Getter()->Speed_Getter() > $this->Speed) $this->Speed = $this->Veteran->Type_Getter()->Speed_Getter();
      }
      public function ID_Army_Getter()
      {
         return $this->ID_Army;
      }
      public function ID_Homecampus_Getter()
      {
         return $this->ID_Homecampus;
      }
      public function ID_Stayingcampus_Getter()
      {
         return $this->ID_Stayingcampus;
      }
      public function Student_Getter()
      {
         return $this->Student;
      }
      public function Parachute_Getter()
      {
         return $this->Parachute;
      }
      public function Nerd_Getter()
      {
         return $this->Nerd;
      }
      public function Stooley_Getter()
      {
         return $this->Stooley;
      }
      public function Drunkard_Getter()
      {
         return $this->Drunkard;
      }
      public function Clochard_Getter()
      {
         return $this->Clochard;
      }
      public function Master_Getter()
      {
         return $this->Master;
      }
      public function Doctor_Getter()
      {
         return $this->Doctor;
      }
      public function Inspector_Getter()
      {
         return $this->Inspector;
      }
      public function Veteran_Getter()
      {
         return $this->Veteran;
      }
      public function Speed_Getter()
      {
         return $this->Speed;
      }
      public function Over_Thousand()
      {
         if ($this->Student->Number_Getter() + 
             $this->Parachute->Number_Getter() + 
             $this->Nerd->Number_Getter() + 
             $this->Stooley->Number_Getter() + 
             $this->Drunkard->Number_Getter() + 
             $this->Clochard->Number_Getter() + 
             $this->Master->Number_Getter() + 
             $this->Doctor->Number_Getter() + 
             $this->Inspector->Number_Getter() + 
             $this->Veteran->Number_Getter() >= 1000) return 1;
            else return 0;
      }
      public function Exterminated()
      {
         if ($this->Student->Number_Getter() == 0 && 
             $this->Parachute->Number_Getter() == 0 && 
             $this->Nerd->Number_Getter() == 0 && 
             $this->Stooley->Number_Getter() == 0 && 
             $this->Drunkard->Number_Getter() == 0 && 
             $this->Clochard->Number_Getter() == 0 && 
             $this->Master->Number_Getter() == 0 && 
             $this->Doctor->Number_Getter() == 0 && 
             $this->Inspector->Number_Getter() == 0 && 
             $this->Veteran->Number_Getter() == 0) return 1;
         else return 0;
      }
      public function Total_Attack_Light_Getter()
      {
         $Sum = 0;
         $Sum = $Sum + $this->Student->Number_Getter() * $this->Student->Type_Getter()->Attack_Light_Getter();
         $Sum = $Sum + $this->Parachute->Number_Getter() * $this->Parachute->Type_Getter()->Attack_Light_Getter();
         $Sum = $Sum + $this->Nerd->Number_Getter() * $this->Nerd->Type_Getter()->Attack_Light_Getter();
         $Sum = $Sum + $this->Stooley->Number_Getter() * $this->Stooley->Type_Getter()->Attack_Light_Getter();
         $Sum = $Sum + $this->Drunkard->Number_Getter() * $this->Drunkard->Type_Getter()->Attack_Light_Getter();
         $Sum = $Sum + $this->Clochard->Number_Getter() * $this->Clochard->Type_Getter()->Attack_Light_Getter();
         $Sum = $Sum + $this->Master->Number_Getter() * $this->Master->Type_Getter()->Attack_Light_Getter();
         $Sum = $Sum + $this->Doctor->Number_Getter() * $this->Doctor->Type_Getter()->Attack_Light_Getter();
         $Sum = $Sum + $this->Inspector->Number_Getter() * $this->Inspector->Type_Getter()->Attack_Light_Getter();
         $Sum = $Sum + $this->Veteran->Number_Getter() * $this->Veteran->Type_Getter()->Attack_Light_Getter();
         return $Sum;
      }
      public function Total_Attack_Heavy_Getter()
      {
         $Sum = 0;
         $Sum = $Sum + $this->Student->Number_Getter() * $this->Student->Type_Getter()->Attack_Heavy_Getter();
         $Sum = $Sum + $this->Parachute->Number_Getter() * $this->Parachute->Type_Getter()->Attack_Heavy_Getter();
         $Sum = $Sum + $this->Nerd->Number_Getter() * $this->Nerd->Type_Getter()->Attack_Heavy_Getter();
         $Sum = $Sum + $this->Stooley->Number_Getter() * $this->Stooley->Type_Getter()->Attack_Heavy_Getter();
         $Sum = $Sum + $this->Drunkard->Number_Getter() * $this->Drunkard->Type_Getter()->Attack_Heavy_Getter();
         $Sum = $Sum + $this->Clochard->Number_Getter() * $this->Clochard->Type_Getter()->Attack_Heavy_Getter();
         $Sum = $Sum + $this->Master->Number_Getter() * $this->Master->Type_Getter()->Attack_Heavy_Getter();
         $Sum = $Sum + $this->Doctor->Number_Getter() * $this->Doctor->Type_Getter()->Attack_Heavy_Getter();
         $Sum = $Sum + $this->Inspector->Number_Getter() * $this->Inspector->Type_Getter()->Attack_Heavy_Getter();
         $Sum = $Sum + $this->Veteran->Number_Getter() * $this->Veteran->Type_Getter()->Attack_Heavy_Getter();
         return $Sum;
      }
      public function Total_Attack_Cavalry_Getter()
      {
         $Sum = 0;
         $Sum = $Sum + $this->Student->Number_Getter() * $this->Student->Type_Getter()->Attack_Cavalry_Getter();
         $Sum = $Sum + $this->Parachute->Number_Getter() * $this->Parachute->Type_Getter()->Attack_Cavalry_Getter();
         $Sum = $Sum + $this->Nerd->Number_Getter() * $this->Nerd->Type_Getter()->Attack_Cavalry_Getter();
         $Sum = $Sum + $this->Stooley->Number_Getter() * $this->Stooley->Type_Getter()->Attack_Cavalry_Getter();
         $Sum = $Sum + $this->Drunkard->Number_Getter() * $this->Drunkard->Type_Getter()->Attack_Cavalry_Getter();
         $Sum = $Sum + $this->Clochard->Number_Getter() * $this->Clochard->Type_Getter()->Attack_Cavalry_Getter();
         $Sum = $Sum + $this->Master->Number_Getter() * $this->Master->Type_Getter()->Attack_Cavalry_Getter();
         $Sum = $Sum + $this->Doctor->Number_Getter() * $this->Doctor->Type_Getter()->Attack_Cavalry_Getter();
         $Sum = $Sum + $this->Inspector->Number_Getter() * $this->Inspector->Type_Getter()->Attack_Cavalry_Getter();
         $Sum = $Sum + $this->Veteran->Number_Getter() * $this->Veteran->Type_Getter()->Attack_Cavalry_Getter();
         return $Sum;
      }
      public function Hit_Light($Amount_Attack)
      {
         $Students_HP = $this->Student->Type_Getter()->HP_Getter() * $this->Student->Number_Getter();
         $Parachutes_HP = $this->Parachute->Type_Getter()->HP_Getter() * $this->Parachute->Number_Getter();
         $Total_HP = $Students_HP + $Parachutes_HP;
         if ($Amount_Attack >= $Total_HP)
         {
            $this->Student->Decrease($this->Student->Number_Getter());
            $this->Parachute->Decrease($this->Parachute->Number_Getter());
            $Amount_Attack = $Amount_Attack - $Total_HP;
            return $Amount_Attack;
         }
         else
         {
            $Students_Ratio = $Students_HP / $Total_HP;
            $Parachutes_Ratio = 1 - $Students_Ratio;
            if ($this->Student->Number_Getter() > 0) $this->Student->Decrease(ceil(($Students_Ratio * $Amount_Attack) / $this->Student->Type_Getter()->HP_Getter()));
            if ($this->Parachute->Number_Getter() > 0) $this->Parachute->Decrease(ceil(($Parachutes_Ratio * $Amount_Attack) / $this->Parachute->Type_Getter()->HP_Getter()));
            return 0;
         }
      }
      public function Hit_Heavy($Amount_Attack)
      {
         $Nerds_HP = $this->Nerd->Type_Getter()->HP_Getter() * $this->Nerd->Number_Getter();
         $Stooleys_HP = $this->Stooley->Type_Getter()->HP_Getter() * $this->Stooley->Number_Getter();
         $Drunkards_HP = $this->Drunkard->Type_Getter()->HP_Getter() * $this->Drunkard->Number_Getter();
         $Clochards_HP = $this->Clochard->Type_Getter()->HP_Getter() * $this->Clochard->Number_Getter();
         $Total_HP = $Nerds_HP + $Stooleys_HP + $Drunkards_HP + $Clochards_HP;
         if ($Amount_Attack >= $Total_HP)
         {
            $this->Nerd->Decrease($this->Nerd->Number_Getter());
            $this->Stooley->Decrease($this->Stooley->Number_Getter());
            $this->Drunkard->Decrease($this->Drunkard->Number_Getter());
            $this->Clochard->Decrease($this->Clochard->Number_Getter());
            $Amount_Attack = $Amount_Attack - $Total_HP;
            return $Amount_Attack;
         }
         else
         {
            $Nerds_Ratio = $Nerds_HP / $Total_HP;
            $Stooleys_Ratio = $Stooleys_HP / $Total_HP;
            $Drunkards_Ratio = $Drunkards_HP / $Total_HP;
            $Clochards_Ratio = 1 - ($Nerds_Ratio + $Stooleys_Ratio + $Drunkards_Ratio);
            if ($this->Nerd->Number_Getter() > 0) $this->Nerd->Decrease(ceil(($Nerds_Ratio * $Amount_Attack) / $this->Nerd->Type_Getter()->HP_Getter()));
            if ($this->Stooley->Number_Getter() > 0) $this->Stooley->Decrease(ceil(($Stooleys_Ratio * $Amount_Attack) / $this->Stooley->Type_Getter()->HP_Getter()));
            if ($this->Drunkard->Number_Getter() > 0) $this->Drunkard->Decrease(ceil(($Drunkards_Ratio * $Amount_Attack) / $this->Drunkard->Type_Getter()->HP_Getter()));
            if ($this->Clochard->Number_Getter() > 0) $this->Clochard->Decrease(ceil(($Clochards_Ratio * $Amount_Attack) / $this->Clochard->Type_Getter()->HP_Getter()));
            return 0;
         }
      }
      public function Hit_Cavalry($Amount_Attack)
      {
         $Masters_HP = $this->Master->Type_Getter()->HP_Getter() * $this->Master->Number_Getter();
         $Doctors_HP = $this->Doctor->Type_Getter()->HP_Getter() * $this->Doctor->Number_Getter();
         $Inspectors_HP = $this->Inspector->Type_Getter()->HP_Getter() * $this->Inspector->Number_Getter();
         $Veterans_HP = $this->Veteran->Type_Getter()->HP_Getter() * $this->Veteran->Number_Getter();
         $Total_HP = $Masters_HP + $Doctors_HP + $Inspectors_HP + $Veterans_HP;
         if ($Amount_Attack >= $Total_HP)
         {
            $this->Master->Decrease($this->Master->Number_Getter());
            $this->Doctor->Decrease($this->Doctor->Number_Getter());
            $this->Inspector->Decrease($this->Inspector->Number_Getter());
            $this->Veteran->Decrease($this->Veteran->Number_Getter());
            $Amount_Attack = $Amount_Attack - $Total_HP;
            return $Amount_Attack;
         }
         else
         {
            $Masters_Ratio = $Masters_HP / $Total_HP;
            $Doctors_Ratio = $Doctors_HP / $Total_HP;
            $Inspectors_Ratio = $Inspectors_HP / $Total_HP;
            $Veterans_Ratio = 1 - ($Masters_Ratio + $Doctors_Ratio + $Inspectors_Ratio);
            if ($this->Master->Number_Getter() > 0) $this->Master->Decrease(ceil(($Masters_Ratio * $Amount_Attack) / $this->Master->Type_Getter()->HP_Getter()));
            if ($this->Doctor->Number_Getter() > 0) $this->Doctor->Decrease(ceil(($Doctors_Ratio * $Amount_Attack) / $this->Doctor->Type_Getter()->HP_Getter()));
            if ($this->Inspector->Number_Getter() > 0) $this->Inspector->Decrease(ceil(($Inspectors_Ratio * $Amount_Attack) / $this->Inspector->Type_Getter()->HP_Getter()));
            if ($this->Veteran->Number_Getter() > 0) $this->Veteran->Decrease(ceil(($Veterans_Ratio * $Amount_Attack) / $this->Veteran->Type_Getter()->HP_Getter()));
            return 0;
         }
      }
      public function Split($Arg_Student_Number, $Arg_Parachute_Number, $Arg_Nerd_Number, $Arg_Stooley_Number, $Arg_Drunkard_Number, $Arg_Clochard_Number, $Arg_Master_Number, $Arg_Doctor_Number, $Arg_Inspector_Number, $Arg_Veteran_Number)
      {
         if ($Arg_Student_Number > $this->Student->Number_Getter() || 
             $Arg_Parachute_Number > $this->Parachute->Number_Getter() ||
             $Arg_Nerd_Number > $this->Nerd->Number_Getter() ||
             $Arg_Stooley_Number > $this->Stooley->Number_Getter() ||
             $Arg_Drunkard_Number > $this->Drunkard->Number_Getter() ||
             $Arg_Clochard_Number > $this->Clochard->Number_Getter() ||
             $Arg_Master_Number > $this->Master->Number_Getter() ||
             $Arg_Doctor_Number > $this->Doctor->Number_Getter() ||
             $Arg_Inspector_Number > $this->Inspector->Number_Getter() ||
             $Arg_Veteran_Number > $this->Veteran->Number_Getter()) return 1;
         $this->Student->Decrease($Arg_Student_Number);
         $this->Parachute->Decrease($Arg_Parachute_Number);
         $this->Nerd->Decrease($Arg_Nerd_Number);
         $this->Stooley->Decrease($Arg_Stooley_Number);
         $this->Drunkard->Decrease($Arg_Drunkard_Number);
         $this->Clochard->Decrease($Arg_Clochard_Number);
         $this->Master->Decrease($Arg_Master_Number);
         $this->Doctor->Decrease($Arg_Doctor_Number);
         $this->Inspector->Decrease($Arg_Inspector_Number);
         $this->Veteran->Decrease($Arg_Veteran_Number);
         $SQL_String = "INSERT INTO gs_armies (id_homecampus, id_stayingcampus, student, parachute, nerd, stooley, drunkard, clochard, master, doctor, inspector, veteran) VALUES ($this->ID_Homecampus, $this->ID_Homecampus, $Arg_Student_Number, $Arg_Parachute_Number, $Arg_Nerd_Number, $Arg_Stooley_Number, $Arg_Drunkard_Number, $Arg_Clochard_Number, $Arg_Master_Number, $Arg_Doctor_Number, $Arg_Inspector_Number, $Arg_Veteran_Number)";
         $Query = self::$Connect->Query($SQL_String);
         $this->Update_Flag = 1;
         return 0;
      }
      public function Unite($Arg_ID_Army)
      {
         $SQL_String = "SELECT * FROM gs_armies WHERE id_army=$Arg_ID_Army";
         $Query = self::$Connect->Query($SQL_String);
         $Record = $Query->fetch_assoc();
         $this->Student->Increase($Record['student']);
         $this->Parachute->Increase($Record['parachute']);
         $this->Nerd->Increase($Record['nerd']);
         $this->Stooley->Increase($Record['stooley']);
         $this->Drunkard->Increase($Record['drunkard']);
         $this->Clochard->Increase($Record['clochard']);
         $this->Master->Increase($Record['master']);
         $this->Doctor->Increase($Record['doctor']);
         $this->Inspector->Increase($Record['inspector']);
         $this->Veteran->Increase($Record['veteran']);
         $this->Update_Flag = 1;
         $SQL_String = "DELETE FROM gs_armies WHERE id_army=$Arg_ID_Army";
         $Query = self::$Connect->Query($SQL_String);
      }
      public function ID_Stayingcampus_Setter($Arg_ID_Stayingcampus)
      {
         $this->Update_Flag = 1;
         $this->ID_Stayingcampus = $Arg_ID_Stayingcampus;
      }
      public function __destruct()
      {  
         if ($this->Update_Flag == 1)
         {
            $SQL_String = "UPDATE gs_armies SET id_stayingcampus=$this->ID_Stayingcampus WHERE id_army=$this->ID_Army";
            $Query = self::$Connect->Query($SQL_String);
         }
         self::$Object_Counter = self::$Object_Counter - 1;
         if (self::$Object_Counter == 0) self::$Connect->close();
      }
   }

   function Calculate_Travel_Time($Arg_Connect, $Arg_A_Point_ID, $Arg_B_Point_ID, $Arg_Speed)
   {
      $SQL_String = "SELECT x_coord, y_coord FROM gs_campuses WHERE id_campus=$Arg_A_Point_ID";
      $Query = $Arg_Connect->Query($SQL_String);
      $Record = $Query->fetch_assoc();
      $A_X_Coord = $Record['x_coord'];
      $A_Y_Coord = $Record['y_coord'];
      $SQL_String = "SELECT x_coord, y_coord FROM gs_campuses WHERE id_campus=$Arg_B_Point_ID";
      $Query = $Arg_Connect->Query($SQL_String);
      $Record = $Query->fetch_assoc();
      $B_X_Coord = $Record['x_coord'];
      $B_Y_Coord = $Record['y_coord'];
      $a = abs($A_X_Coord - $B_X_Coord);
      $b = abs($A_Y_Coord - $B_Y_Coord);
      $Distance = sqrt($a*$a + $b*$b);
      $Distance = ceil($Distance);
      $Distance = $Distance * $Arg_Speed;
      return $Distance;
   }

   class Move
   {
      private static $Connect;
      private static $Object_Counter;
      private $Update_Flag;
      private $ID_Move;
      private $Army;
      private $ID_Source;
      private $ID_Destination;
      private $Old_ID_Destination;
      private $Arrival_Time;
      private $Strike;
      private $Stolen_Vodka;
      private $Stolen_Kebab;
      private $Stolen_Wifi;
      public function __construct($Arg_ID_Move)
      {
         if (self::$Object_Counter == 0)
         {
            self::$Connect = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
         }
         self::$Object_Counter = self::$Object_Counter + 1;
         $this->ID_Move = $Arg_ID_Move;
         $SQL_String = "SELECT * FROM gs_moves WHERE id_move=$this->ID_Move";
         $Query = self::$Connect->Query($SQL_String);
         $Record = $Query->fetch_assoc();
         $this->Army = new Army($Record['id_army']);
         $this->ID_Source = $Record['id_source'];
         $this->ID_Destination = $Record['id_destination'];
         $this->Arrival_Time = $Record['arrival_time'];
         $this->Strike = $Record['strike'];
         $this->Stolen_Vodka = $Record['stolen_vodka'];
         $this->Stolen_Kebab = $Record['stolen_kebab'];
         $this->Stolen_Wifi = $Record['stolen_wifi'];
      }
      public function Army_Getter()
      {
         return $this->Army;
      }
      public function ID_Source_Getter()
      {
         return $this->ID_Source;
      }
      public function ID_Destination_Getter()
      {
         return $this->ID_Destination;
      }
      public function Stolen_Vodka_Getter()
      {
         return $this->Stolen_Vodka;
      }
      public function Stolen_Kebab_Getter()
      {
         return $this->Stolen_Kebab;
      }
      public function Stolen_Wifi_Getter()
      {
         return $this->Stolen_Wifi;
      }
      public function Returning()
      {
         $this->Update_Flag = 1;
         $this->Strike = 2;
         $this->Old_ID_Destination = $this->ID_Destination;
         $this->ID_Destination = $this->ID_Source;
         $this->Arrival_Time = new DateTime(); 
         $this->Arrival_Time->add(new DateInterval('PT'.Calculate_Travel_Time(self::$Connect, $this->Old_ID_Destination, $this->ID_Source, $this->Army->Speed_Getter()).'M'));
      }
      public function Steal()
      {
         $this->Update_Flag = 1;
         $Total_Capacity = 0;
         $Total_Capacity = $Total_Capacity + $this->Army->Student_Getter()->Number_Getter() * $this->Army->Student_Getter()->Type_Getter()->Capacity_Getter();
         $Total_Capacity = $Total_Capacity + $this->Army->Parachute_Getter()->Number_Getter() * $this->Army->Parachute_Getter()->Type_Getter()->Capacity_Getter();
         $Total_Capacity = $Total_Capacity + $this->Army->Nerd_Getter()->Number_Getter() * $this->Army->Nerd_Getter()->Type_Getter()->Capacity_Getter();
         $Total_Capacity = $Total_Capacity + $this->Army->Stooley_Getter()->Number_Getter() * $this->Army->Stooley_Getter()->Type_Getter()->Capacity_Getter();
         $Total_Capacity = $Total_Capacity + $this->Army->Drunkard_Getter()->Number_Getter() * $this->Army->Drunkard_Getter()->Type_Getter()->Capacity_Getter();
         $Total_Capacity = $Total_Capacity + $this->Army->Clochard_Getter()->Number_Getter() * $this->Army->Clochard_Getter()->Type_Getter()->Capacity_Getter();
         $Total_Capacity = $Total_Capacity + $this->Army->Master_Getter()->Number_Getter() * $this->Army->Master_Getter()->Type_Getter()->Capacity_Getter();
         $Total_Capacity = $Total_Capacity + $this->Army->Doctor_Getter()->Number_Getter() * $this->Army->Doctor_Getter()->Type_Getter()->Capacity_Getter();
         $Total_Capacity = $Total_Capacity + $this->Army->Inspector_Getter()->Number_Getter() * $this->Army->Inspector_Getter()->Type_Getter()->Capacity_Getter();
         $Total_Capacity = $Total_Capacity + $this->Army->Veteran_Getter()->Number_Getter() * $this->Army->Veteran_Getter()->Type_Getter()->Capacity_Getter();
         $SQL_String = "SELECT amount_vodka, amount_kebab, amount_wifi FROM gs_campuses WHERE id_campus=$this->ID_Destination";
         $Query = self::$Connect->Query($SQL_String);
         $Record = $Query->fetch_assoc();
         $Vodka = $Record['amount_vodka'];
         $Kebab = $Record['amount_kebab'];
         $Wifi = $Record['amount_wifi'];
         while ($Total_Capacity > 0)
         {
            if ($Vodka > 0)
            {
               $Vodka = $Vodka - 1;
               $this->Stolen_Vodka = $this->Stolen_Vodka + 1;
               $Total_Capacity = $Total_Capacity - 1;
               if ($Total_Capacity == 0) break;
            } 
            if ($Kebab > 0)
            {
               $Kebab = $Kebab - 1;
               $this->Stolen_Kebab = $this->Stolen_Kebab + 1;
               $Total_Capacity = $Total_Capacity - 1;
               if ($Total_Capacity == 0) break;
            } 
            if ($Wifi > 0)
            {
               $Wifi = $Wifi - 1;
               $this->Stolen_Wifi = $this->Stolen_Wifi + 1;
               $Total_Capacity = $Total_Capacity - 1;
               if ($Total_Capacity == 0) break;
            } 
            if ($Vodka == 0 && $Kebab == 0 && $Wifi == 0) break;
         }
         $SQL_String = "UPDATE gs_campuses SET amount_vodka=$Vodka, amount_kebab=$Kebab, amount_wifi=$Wifi WHERE id_campus=$this->ID_Destination";
         $Query = self::$Connect->Query($SQL_String);
      }
      public function Delivery()
      {
         $Vodka = new Resource('vodka', $this->ID_Source);
         $Kebab = new Resource('kebab', $this->ID_Source);
         $Wifi = new Resource('wifi', $this->ID_Source);
         $Vodka->Increase($this->Stolen_Vodka);
         $Kebab->Increase($this->Stolen_Kebab);
         $Wifi->Increase($this->Stolen_Wifi);
      }
      public function __destruct()
      {
         if ($this->Update_Flag == 1)
         {
            $Date_String = $this->Arrival_Time->format('Y-m-d H:i:00');
            $SQL_String = "UPDATE gs_moves SET id_destination=$this->ID_Destination, arrival_time='$Date_String', strike=$this->Strike, stolen_vodka=$this->Stolen_Vodka, stolen_kebab=$this->Stolen_Kebab, stolen_wifi=$this->Stolen_Wifi, old_id_destination=$this->Old_ID_Destination WHERE id_move=$this->ID_Move";
            $Query = self::$Connect->Query($SQL_String);
         }
         self::$Object_Counter = self::$Object_Counter - 1;
         if (self::$Object_Counter == 0) self::$Connect->close(); 
      }
   }
  
}
?>