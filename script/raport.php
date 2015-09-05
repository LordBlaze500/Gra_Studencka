<?php
//OGOLNIE POTRZEBNE DANE:
 // pochodzenie ataku
 // cel ataku
 // wynik
 // szczescie
 // wojo agresora przed atakiem
 // wojo agresora po ataku
 // suma wojsk def przed atakiem
 // suma wojsk def po ataku
 // ile ukradziono surki
 // ile spadlo poparcie

// raport o ataku - dla agresora
 // jesli all wojo off zginelo to wstawic brak danych o wojskach def

// raport o ataku - dla obroncy
// raport o ataku - dla wspierajacego
 // suma wojsk jego woja przed atakiem
 // suma wojsk jego woja po ataku
if (!defined('__RAPORT_PHP__'))
{
   define('__RAPORT_PHP__',1);
   include "db_connect.php";
   include "list.php";

      class Number_Army
      {
         public $Student;
         public $Parachute;
         public $Drunkard;
         public $Clochard;
         public $Nerd;
         public $Stooley;
         public $Master;
         public $Doctor;
         public $Inspector;
         public $Veteran;
         public function __construct()
         {
            $this->Student = 0;
            $this->Parachute = 0;
            $this->Drunkard = 0;
            $this->Clochard = 0;
            $this->Nerd = 0;
            $this->Stooley = 0;
            $this->Master = 0;
            $this->Doctor = 0;
            $this->Inspector = 0;
            $this->Veteran = 0;
         }
      }

   class Battle_Raport
   {
   private static $Connect;
   private static $Object_Counter;
   private $ID_Source; //
   private $ID_Destination; //
   private $Result; // 1 - wygrana obrony, 2 - wygrana agro
   private $Luck; //
   private $Aggressor_Army_Before; //
   private $Aggressor_Army_After; //
   private $Defending_Armies_Before_Complete;
   private $Defending_Armies_Before; //
   private $Defending_Armies_After; //
   private $Obedience_Before;
   private $Obedience_Loss; //
   private $Stolen_Vodka;
   private $Stolen_Kebab;
   private $Stolen_Wifi;
   public function __construct()
   {
      if (self::$Object_Counter == 0) self::$Connect = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
	   self::$Object_Counter = self::$Object_Counter + 1;
      $this->Obedience_Loss = 0;
      $this->Stolen_Vodka = 0;
      $this->Stolen_Kebab = 0;
      $this->Stolen_Wifi = 0;
   }
   public function Source_Setter($Arg_ID_Source)
   {
   	if ($Arg_ID_Source > 0) $this->ID_Source = $Arg_ID_Source;
      else $this->ID_Source = 0;
   }
   public function Destination_Setter($Arg_ID_Destination)
   {
   	if ($Arg_ID_Destination > 0) $this->ID_Destination = $Arg_ID_Destination;
      else $this->ID_Destination = 0;
   }
   public function Luck_Setter($Arg_Luck)
   {
   	if ($Arg_Luck >= 0 && $Arg_Luck <= 20) $this->Luck = $Arg_Luck;
      else $this->Luck = 0;
   }
   public function Result_Setter($Arg_Result)
   {
      if ($Arg_Result == 1 || $Arg_Result == 2) $this->Result = $Arg_Result;
      else $this->Result = 0;
   }
   public function Aggressor_Army_Before_Setter($Arg_Army)
   {
      $this->Aggressor_Army_Before = new Number_Army();
      $this->Aggressor_Army_Before->Student = $Arg_Army->Student_Getter()->Number_Getter();
      $this->Aggressor_Army_Before->Parachute = $Arg_Army->Parachute_Getter()->Number_Getter();
      $this->Aggressor_Army_Before->Drunkard = $Arg_Army->Drunkard_Getter()->Number_Getter();
      $this->Aggressor_Army_Before->Clochard = $Arg_Army->Clochard_Getter()->Number_Getter();
      $this->Aggressor_Army_Before->Nerd = $Arg_Army->Nerd_Getter()->Number_Getter();
      $this->Aggressor_Army_Before->Stooley = $Arg_Army->Stooley_Getter()->Number_Getter();
      $this->Aggressor_Army_Before->Master = $Arg_Army->Master_Getter()->Number_Getter();
      $this->Aggressor_Army_Before->Doctor = $Arg_Army->Doctor_Getter()->Number_Getter();
      $this->Aggressor_Army_Before->Inspector = $Arg_Army->Inspector_Getter()->Number_Getter();
      $this->Aggressor_Army_Before->Veteran = $Arg_Army->Veteran_Getter()->Number_Getter();
   }
   public function Defending_Armies_Before_Setter($Arg_Defending_Armies_Before)
   {
      $i = 0;
      $this->Defending_Armies_Before_Complete = $Arg_Defending_Armies_Before;
      $this->Defending_Armies_Before = new Number_Army();
      while ($Arg_Defending_Armies_Before && $Arg_Defending_Armies_Before->At($i))
      {
         $this->Defending_Armies_Before->Student += $Arg_Defending_Armies_Before->At($i)->Student_Getter()->Number_Getter();
         $this->Defending_Armies_Before->Parachute += $Arg_Defending_Armies_Before->At($i)->Parachute_Getter()->Number_Getter();
         $this->Defending_Armies_Before->Drunkard += $Arg_Defending_Armies_Before->At($i)->Drunkard_Getter()->Number_Getter();
         $this->Defending_Armies_Before->Clochard += $Arg_Defending_Armies_Before->At($i)->Clochard_Getter()->Number_Getter();
         $this->Defending_Armies_Before->Nerd += $Arg_Defending_Armies_Before->At($i)->Nerd_Getter()->Number_Getter();
         $this->Defending_Armies_Before->Stooley += $Arg_Defending_Armies_Before->At($i)->Stooley_Getter()->Number_Getter();
         $this->Defending_Armies_Before->Master += $Arg_Defending_Armies_Before->At($i)->Master_Getter()->Number_Getter();
         $this->Defending_Armies_Before->Doctor += $Arg_Defending_Armies_Before->At($i)->Doctor_Getter()->Number_Getter();
         $this->Defending_Armies_Before->Inspector += $Arg_Defending_Armies_Before->At($i)->Inspector_Getter()->Number_Getter();
         $this->Defending_Armies_Before->Veteran += $Arg_Defending_Armies_Before->At($i)->Veteran_Getter()->Number_Getter();
         $i = $i+1;
      }
   }
   public function Aggressor_Army_After_Setter($Arg_Army)
   {
      if ($Arg_Army == NULL) $this->Aggressor_Army_After = new Number_Army();
      else
      {
         $this->Aggressor_Army_After = new Number_Army();
         $this->Aggressor_Army_After->Student = $Arg_Army->Student_Getter()->Number_Getter();
         $this->Aggressor_Army_After->Parachute = $Arg_Army->Parachute_Getter()->Number_Getter();
         $this->Aggressor_Army_After->Drunkard = $Arg_Army->Drunkard_Getter()->Number_Getter();
         $this->Aggressor_Army_After->Clochard = $Arg_Army->Clochard_Getter()->Number_Getter();
         $this->Aggressor_Army_After->Nerd = $Arg_Army->Nerd_Getter()->Number_Getter();
         $this->Aggressor_Army_After->Stooley = $Arg_Army->Stooley_Getter()->Number_Getter();
         $this->Aggressor_Army_After->Master = $Arg_Army->Master_Getter()->Number_Getter();
         $this->Aggressor_Army_After->Doctor = $Arg_Army->Doctor_Getter()->Number_Getter();
         $this->Aggressor_Army_After->Inspector = $Arg_Army->Inspector_Getter()->Number_Getter();
         $this->Aggressor_Army_After->Veteran = $Arg_Army->Veteran_Getter()->Number_Getter();
      }
   }
   public function Defending_Armies_After_Setter($Arg_Defending_Armies_After)
   {
      if ($Arg_Defending_Armies_After == NULL) $this->Defending_Armies_After = new Number_Army();
      else
      {
         $i = 0;
         $this->Defending_Armies_After = new Number_Army();
         while ($Arg_Defending_Armies_After->At($i))
         {
            $this->Defending_Armies_After->Student += $Arg_Defending_Armies_After->At($i)->Student_Getter()->Number_Getter();
            $this->Defending_Armies_After->Parachute += $Arg_Defending_Armies_After->At($i)->Parachute_Getter()->Number_Getter();
            $this->Defending_Armies_After->Drunkard += $Arg_Defending_Armies_After->At($i)->Drunkard_Getter()->Number_Getter();
            $this->Defending_Armies_After->Clochard += $Arg_Defending_Armies_After->At($i)->Clochard_Getter()->Number_Getter();
            $this->Defending_Armies_After->Nerd += $Arg_Defending_Armies_After->At($i)->Nerd_Getter()->Number_Getter();
            $this->Defending_Armies_After->Stooley += $Arg_Defending_Armies_After->At($i)->Stooley_Getter()->Number_Getter();
            $this->Defending_Armies_After->Master += $Arg_Defending_Armies_After->At($i)->Master_Getter()->Number_Getter();
            $this->Defending_Armies_After->Doctor += $Arg_Defending_Armies_After->At($i)->Doctor_Getter()->Number_Getter();
            $this->Defending_Armies_After->Inspector += $Arg_Defending_Armies_After->At($i)->Inspector_Getter()->Number_Getter();
            $this->Defending_Armies_After->Veteran += $Arg_Defending_Armies_After->At($i)->Veteran_Getter()->Number_Getter();
            $i = $i+1;
         }
      }
   }
   public function Obedience_Loss_Setter($Arg_Obedience_Loss, $Arg_Obedience_Before)
   {
      if ($Arg_Obedience_Before > 0) $this->Obedience_Before = $Arg_Obedience_Before;
      if ($Arg_Obedience_Loss > 0) $this->Obedience_Loss = $Arg_Obedience_Loss;
   }
   public function Stolen_Setter($Arg_Stolen_Vodka, $Arg_Stolen_Kebab, $Arg_Stolen_Wifi)
   {
      $this->Stolen_Vodka = $Arg_Stolen_Vodka;
      $this->Stolen_Kebab = $Arg_Stolen_Kebab;
      $this->Stolen_Wifi = $Arg_Stolen_Wifi;
   }
   public function Send()
   {
      $Content = '<font size=5><b>';
      if ($this->Result == 1) $Content = $Content.'Obrońca zwyciężył</b></font><br/><br/>';
      if ($this->Result == 2) $Content = $Content.'Agresor zwyciężył</b></font><br/><br/>';
      $Content = $Content.'Szczęście (z punktu widzenia agresora): ';
      if ($this->Luck-10 > 0) $Content = $Content.'<font color="green">';
      else $Content = $Content.'<font color="red">';
      $Content = $Content.($this->Luck-10).'%</font><br/><br/>';
      $Content = $Content.'<b>Atakujący: ';
      $SQL_String = "SELECT name, x_coord, y_coord, id_owner FROM gs_campuses WHERE id_campus=$this->ID_Source";
      $Query = self::$Connect->Query($SQL_String);
      $Record = $Query->fetch_assoc();
      $ID_Owner = $Record['id_owner'];
      $SQL_String_2 = "SELECT login FROM gs_users WHERE id_user=$ID_Owner";
      $Query_2 = self::$Connect->Query($SQL_String_2);
      $Record_2 = $Query_2->fetch_assoc();
      $Content = $Content.$Record_2['login'].', '.$Record['name'].'('.$Record['x_coord'].'|'.$Record['y_coord'].')</b><br/>';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/weteran.png" width="25" height="25"></td></tr><tr>';
      $Content = $Content.'<td>'.($this->Aggressor_Army_Before->Student).'</td>';
      $Content = $Content.'<td>'.($this->Aggressor_Army_Before->Parachute).'</td>';
      $Content = $Content.'<td>'.($this->Aggressor_Army_Before->Drunkard).'</td>';
      $Content = $Content.'<td>'.($this->Aggressor_Army_Before->Clochard).'</td>';
      $Content = $Content.'<td>'.($this->Aggressor_Army_Before->Nerd).'</td>';
      $Content = $Content.'<td>'.($this->Aggressor_Army_Before->Stooley).'</td>';
      $Content = $Content.'<td>'.($this->Aggressor_Army_Before->Master).'</td>';
      $Content = $Content.'<td>'.($this->Aggressor_Army_Before->Doctor).'</td>';
      $Content = $Content.'<td>'.($this->Aggressor_Army_Before->Inspector).'</td>';
      $Content = $Content.'<td>'.($this->Aggressor_Army_Before->Veteran).'</td></tr><tr>';
      $Content = $Content.'<td><font color="red">'.($this->Aggressor_Army_Before->Student - $this->Aggressor_Army_After->Student).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Aggressor_Army_Before->Parachute - $this->Aggressor_Army_After->Parachute).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Aggressor_Army_Before->Drunkard - $this->Aggressor_Army_After->Drunkard).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Aggressor_Army_Before->Clochard - $this->Aggressor_Army_After->Clochard).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Aggressor_Army_Before->Nerd - $this->Aggressor_Army_After->Nerd).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Aggressor_Army_Before->Stooley - $this->Aggressor_Army_After->Stooley).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Aggressor_Army_Before->Master - $this->Aggressor_Army_After->Master).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Aggressor_Army_Before->Doctor - $this->Aggressor_Army_After->Doctor).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Aggressor_Army_Before->Inspector - $this->Aggressor_Army_After->Inspector).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Aggressor_Army_Before->Veteran - $this->Aggressor_Army_After->Veteran).'</font></td></tr></table><br/><br/>';
      $SQL_String = "SELECT name, x_coord, y_coord, id_owner FROM gs_campuses WHERE id_campus=$this->ID_Destination";
      $Query = self::$Connect->Query($SQL_String);
      $Record = $Query->fetch_assoc();
      $ID_Owner_Target = $Record['id_owner'];
      $SQL_String_2 = "SELECT login FROM gs_users WHERE id_user=$ID_Owner_Target";
      $Query_2 = self::$Connect->Query($SQL_String_2);
      $Record_2 = $Query_2->fetch_assoc();
      $Content = $Content.'<b>Obrońca: '.$Record_2['login'].', '.$Record['name'].'('.$Record['x_coord'].'|'.$Record['y_coord'].')</b><br/>';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="img/weteran.png" width="25" height="25"></td></tr><tr>';
      $Content = $Content.'<td>'.($this->Defending_Armies_Before->Student).'</td>';
      $Content = $Content.'<td>'.($this->Defending_Armies_Before->Parachute).'</td>';
      $Content = $Content.'<td>'.($this->Defending_Armies_Before->Drunkard).'</td>';
      $Content = $Content.'<td>'.($this->Defending_Armies_Before->Clochard).'</td>';
      $Content = $Content.'<td>'.($this->Defending_Armies_Before->Nerd).'</td>';
      $Content = $Content.'<td>'.($this->Defending_Armies_Before->Stooley).'</td>';
      $Content = $Content.'<td>'.($this->Defending_Armies_Before->Master).'</td>';
      $Content = $Content.'<td>'.($this->Defending_Armies_Before->Doctor).'</td>';
      $Content = $Content.'<td>'.($this->Defending_Armies_Before->Inspector).'</td>';
      $Content = $Content.'<td>'.($this->Defending_Armies_Before->Veteran).'</td></tr><tr><font color="red">';
      $Content = $Content.'<td><font color="red">'.($this->Defending_Armies_Before->Student - $this->Defending_Armies_After->Student).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Defending_Armies_Before->Parachute - $this->Defending_Armies_After->Parachute).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Defending_Armies_Before->Drunkard - $this->Defending_Armies_After->Drunkard).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Defending_Armies_Before->Clochard - $this->Defending_Armies_After->Clochard).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Defending_Armies_Before->Nerd - $this->Defending_Armies_After->Nerd).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Defending_Armies_Before->Stooley - $this->Defending_Armies_After->Stooley).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Defending_Armies_Before->Master - $this->Defending_Armies_After->Master).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Defending_Armies_Before->Doctor - $this->Defending_Armies_After->Doctor).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Defending_Armies_Before->Inspector - $this->Defending_Armies_After->Inspector).'</font></td>';
      $Content = $Content.'<td><font color="red">'.($this->Defending_Armies_Before->Veteran - $this->Defending_Armies_After->Veteran).'</font></td></font></tr></table><br/><br/>';
      if ($this->Stolen_Vodka + $this->Stolen_Kebab + $this->Stolen_Wifi > 0) $Content = $Content.'<font color="red">';
      else $Content = $Content.'<font color="green">';
      $Content = $Content.'Ukradzione surowce: '.'<img src="img/wodka.png" width="25" height="25">'.($this->Stolen_Vodka).'<img src="img/kebab.png" width="25" height="25">'.($this->Stolen_Kebab).'<img src="img/wifi.png" width="25" height="25">'.($this->Stolen_Wifi).'</font><br/>';
      if ($this->Obedience_Loss > 0)
      {
         $Content = $Content.'<b>Poparcie spadło z '.($this->Obedience_Before).' na '.($this->Obedience_Before-$this->Obedience_Loss).'</b><br/>';
      }
      $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen) VALUES ($ID_Owner, '$Content', 0)";
      $Query = self::$Connect->Query($SQL_String);
      $i = 0;
      while ($this->Defending_Armies_Before_Complete->At($i))
      {
         $ID_Homecampus = $this->Defending_Armies_Before_Complete->At($i)->ID_Homecampus_Getter();
         $SQL_String = "SELECT id_owner FROM gs_campuses WHERE id_campus=$ID_Homecampus";
         echo 'SQL STring 1: ';
         echo $SQL_String;
         echo '<br/>';
         $Query = self::$Connect->Query($SQL_String);
         $Record = $Query->fetch_assoc();
         $ID_User = $Record['id_owner'];
         $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen) VALUES ($ID_Owner, '$Content', 0)";
         $Query = self::$Connect->Query($SQL_String);
         echo 'SQL STring 2: ';
         echo $SQL_String;
         echo '<br/>';
         $i = $i + 1;
      }
   }
   public function __destruct()
   {
      self::$Object_Counter = self::$Object_Counter - 1;
	   if (self::$Object_Counter == 0) self::$Connect->close();
   }
   }
}

// raport o wycofaniu woja
// raport o odeslaniu woja
// raport o dotarciu wsparcia

?>