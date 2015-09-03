<?php
if (!defined('__BUILDING_PHP__'))
{
   define('__BUILDING_PHP__',1);
   include "db_connect.php";
   include "resource.php";

   abstract class Building
   {
      protected static $Connect;
      private static $Object_Counter;
      protected $Update_Flag;
      protected $ID_Campus;
      protected $Name;
      protected $Vodka_Needed;
      protected $Kebab_Needed;
      protected $Wifi_Needed;
      public function __construct()
      {
         if (self::$Object_Counter == 0)
         {
            self::$Connect = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
         }
         self::$Object_Counter = self::$Object_Counter + 1;
         $this->Update_Flag = 0;
      }
      public function Vodka_Needed_Getter()
      {
         return $this->Vodka_Needed;
      }
      public function Kebab_Needed_Getter()
      {
         return $this->Kebab_Needed;
      }
      public function Wifi_Needed_Getter()
      {
         return $this->Wifi_Needed;
      }
      abstract public function Build();
      public function __destruct()
      {
         echo 'closing connection...';
         self::$Object_Counter = self::$Object_Counter - 1;
         if (self::$Object_Counter == 0) self::$Connect->close();
      }
   }                                                 
      
   class Mining_Building extends Building
   {
      private $Level;
      private $Production;
      public function __construct($Arg_Name, $Arg_ID_Campus)
      {
         parent::__construct();
         $this->Name = $Arg_Name;
         $this->ID_Campus = $Arg_ID_Campus;
         $SQL_String = "SELECT $this->Name FROM gs_campuses WHERE id_campus=$Arg_ID_Campus";
         $Query = self::$Connect->query($SQL_String);
         $Record = $Query->fetch_assoc();
         $this->Level = $Record[$this->Name]; 
         $SQL_String = "SELECT income FROM gs_mines_costs WHERE name='$this->Name' AND level=$this->Level";
         $Query = self::$Connect->query($SQL_String);
         $Record = $Query->fetch_assoc();
         $this->Production = $Record['income'];
         $Next_Level = ($this->Level)+1;
         if ($Next_Level <= 10)
         {
            $SQL_String = "SELECT vodka, kebab, wifi FROM gs_mines_costs WHERE name='$this->Name' AND level=$Next_Level";
            $Query = self::$Connect->query($SQL_String);
            $Record = $Query->fetch_assoc();
            $this->Vodka_Needed = $Record['vodka'];
            $this->Kebab_Needed = $Record['kebab'];
            $this->Wifi_Needed = $Record['wifi'];
         }
         else
         {
            $this->Vodka_Needed = 0;
            $this->Kebab_Needed = 0;
            $this->Wifi_Needed = 0;
         }
      }
      public function Level_Getter()
      {
         return $this->Level;
      }
      public function Production_Getter()
      {
         return $this->Production;
      }
      public function Build()
      {
         if ($this->Level == 10) return 1;
         $Vodka = new Resource('vodka', $this->ID_Campus);
         $Kebab = new Resource('kebab', $this->ID_Campus);
         $Wifi = new Resource('wifi', $this->ID_Campus);
         if ($this->Vodka_Needed > $Vodka->Amount_Getter() || $this->Kebab_Needed > $Kebab->Amount_Getter() || $this->Wifi_Needed > $Wifi->Amount_Getter()) return 2;
         $this->Update_Flag = 1;
         $this->Level = $this->Level + 1;
         $Vodka->Decrease($this->Vodka_Needed);
         $Kebab->Decrease($this->Kebab_Needed);
         $Wifi->Decrease($this->Wifi_Needed);
         return 0;                     
      }
      public function __destruct()
      {
         if ($this->Update_Flag == 1)
         {
            $SQL_String = "UPDATE gs_campuses SET $this->Name=$this->Level WHERE id_campus=$this->ID_Campus";
            $Query = self::$Connect->query($SQL_String);
         }
      }
   }
      
   class Recrutation_Building extends Building
   {
      protected $Status;
      public function __construct($Arg_Name, $Arg_ID_Campus)
      {
         parent::__construct();
         $this->Name = $Arg_Name;
         $this->ID_Campus = $Arg_ID_Campus;
         $SQL_String = "SELECT $this->Name FROM gs_campuses WHERE id_campus=$Arg_ID_Campus";
         $Query = self::$Connect->query($SQL_String);
         $Record = $Query->fetch_assoc();
         $this->Status = $Record[$this->Name];
         if ($this->Status == 0)
         {
            $SQL_String = "SELECT * FROM gs_buildings_costs WHERE name='$this->Name'";
            $Query = self::$Connect->Query($SQL_String);
            $Record = $Query->fetch_assoc();
            $this->Vodka_Needed = $Record['vodka'];
            $this->Kebab_Needed = $Record['kebab'];
            $this->Wifi_Needed = $Record['wifi'];
         }
         if ($this->Status == 1)
         {
            $SQL_String = "SELECT * FROM gs_buildings_costs WHERE name='$this->Name"."2'";
            $Query = self::$Connect->Query($SQL_String);
            $Record = $Query->fetch_assoc();
            $this->Vodka_Needed = $Record['vodka'];
            $this->Kebab_Needed = $Record['kebab'];
            $this->Wifi_Needed = $Record['wifi'];
         }
         if ($this->Status == 2)
         {
            $this->Vodka_Needed = 0;
            $this->Kebab_Needed = 0;
            $this->Wifi_Needed = 0;
         }
      }       
      public function Status_Getter()
      {
         return $this->Status;
      }
      public function Build()
      {
         if ($this->Status == 2) return 1;
         $Vodka = new Resource('vodka', $this->ID_Campus);
         $Kebab = new Resource('kebab', $this->ID_Campus);
         $Wifi = new Resource('wifi', $this->ID_Campus);
         if ($this->Vodka_Needed > $Vodka->Amount_Getter() || $this->Kebab_Needed > $Kebab->Amount_Getter() || $this->Wifi_Needed > $Wifi->Amount_Getter()) return 2;
         $this->Update_Flag = 1;
         $this->Status = $this->Status + 1;
         $Vodka->Decrease($this->Vodka_Needed);
         $Kebab->Decrease($this->Kebab_Needed);
         $Wifi->Decrease($this->Wifi_Needed);
         return 0;
      } 
      public function __destruct()
      {
         if ($this->Update_Flag == 1)
         {
            $SQL_String = "UPDATE gs_campuses SET $this->Name=$this->Status WHERE id_campus=$this->ID_Campus";
            $Query = self::$Connect->query($SQL_String);
         }
      }
   }

   class Special_Building extends Building
   {
      protected $Status;
      public function __construct($Arg_Name, $Arg_ID_Campus)
      {
         parent::__construct();
         $this->Name = $Arg_Name;
         $this->ID_Campus = $Arg_ID_Campus;
         $SQL_String = "SELECT $this->Name FROM gs_campuses WHERE id_campus=$Arg_ID_Campus";
         $Query = self::$Connect->query($SQL_String);
         $Record = $Query->fetch_assoc();
         $this->Status = $Record[$this->Name];
         if ($this->Status == 0)
         {
            $SQL_String = "SELECT * FROM gs_buildings_costs WHERE name='$this->Name'";
            $Query = self::$Connect->Query($SQL_String);
            $Record = $Query->fetch_assoc();
            $this->Vodka_Needed = $Record['vodka'];
            $this->Kebab_Needed = $Record['kebab'];
            $this->Wifi_Needed = $Record['wifi'];
         }
         if ($this->Status == 1)
         {
            $this->Vodka_Needed = 0;
            $this->Kebab_Needed = 0;
            $this->Wifi_Needed = 0;
         }
      }       
      public function Status_Getter()
      {
         return $this->Status;
      }
      public function Build()
      {
         if ($this->Status == 1) return 1;
         $Vodka = new Resource('vodka', $this->ID_Campus);
         $Kebab = new Resource('kebab', $this->ID_Campus);
         $Wifi = new Resource('wifi', $this->ID_Campus);
         if ($this->Vodka_Needed > $Vodka->Amount_Getter() || $this->Kebab_Needed > $Kebab->Amount_Getter() || $this->Wifi_Needed > $Wifi->Amount_Getter()) return 2;
         $this->Update_Flag = 1;
         $this->Status = $this->Status + 1;
         $Vodka->Decrease($this->Vodka_Needed);
         $Kebab->Decrease($this->Kebab_Needed);
         $Wifi->Decrease($this->Wifi_Needed);
         return 0;
      } 
      public function __destruct()
      {
         if ($this->Update_Flag == 1)
         {
            $SQL_String = "UPDATE gs_campuses SET $this->Name=$this->Status WHERE id_campus=$this->ID_Campus";
            $Query = self::$Connect->query($SQL_String);
         }
      }
   }
}
?>