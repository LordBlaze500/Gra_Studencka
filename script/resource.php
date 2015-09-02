<?php
if (!defined('__RESOURCE_PHP__'))
{
   define('__RESOURCE_PHP__',1);
   include "db_connect.php";

   class Resource
   {
      private static $Connect;
      private static $Object_Counter;
      private $ID_Campus;
      private $Update_Flag;
      private $Name;
      private $Amount;
      private static $Maximum;
      public function __construct($Arg_Name, $Arg_ID_Campus)
      {
         if (self::$Object_Counter == 0)
         {
            self::$Connect = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
         }
         self::$Object_Counter = self::$Object_Counter + 1;
         $this->Update_Flag = 0;
         $this->ID_Campus = $Arg_ID_Campus;
         $this->Name = $Arg_Name;
         $this->Maximum = 20000;
         $SQL_String = "SELECT amount_"."$this->Name FROM gs_campuses WHERE id_campus='$Arg_ID_Campus'";
         $Query = self::$Connect->query($SQL_String);
         $Record = $Query->fetch_assoc();
         $this->Amount = $Record["amount_"."$this->Name"];
      }
      public function Amount_Getter()
      {
         return $this->Amount;
      }
      public function Maximum_Getter()
      {
         return $this->Maximum;
      }
      public function Increase ($Gain)
      {
         $this->Update_Flag = 1;
         $this->Amount = $this->Amount + $Gain;
         if ($this->Amount > $this->Maximum) $this->Amount = $this->Maximum;
      }
      public function Decrease ($Cost)
      {
         $this->Update_Flag = 1;
         $this->Amount = $this->Amount - $Cost;
         if ($this->Amount < 0) $this->Amount = 0;
      }
      public function __destruct()
      {
         if ($this->Update_Flag == 1)
         {
            $SQL_String = "UPDATE gs_campuses SET amount_"."$this->Name="."$this->Amount WHERE id_campus=$this->ID_Campus";
            $Query = self::$Connect->Query($SQL_String);
         }
         $this->Object_Counter = $this->Object_Counter - 1;
         if (self::$Object_Counter == 0) self::$Connect->close();
      }
   }
}
?>