<?php
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
      $Title = $Record_2['login'].' atakuje ';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="../img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/weteran.png" width="25" height="25"></td></tr><tr>';
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
      $Title = $Title.$Record['name'].'('.$Record['x_coord'].'|'.$Record['y_coord'].')';
      $Content = $Content.'<b>Obrońca: '.$Record_2['login'].', '.$Record['name'].'('.$Record['x_coord'].'|'.$Record['y_coord'].')</b><br/>';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="../img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/weteran.png" width="25" height="25"></td></tr><tr>';
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
      $Content = $Content.'Ukradzione surowce: '.'<img src="../img/wodka.png" width="25" height="25">'.($this->Stolen_Vodka).'<img src="../img/kebab.png" width="25" height="25">'.($this->Stolen_Kebab).'<img src="../img/wifi.png" width="25" height="25">'.($this->Stolen_Wifi).'</font><br/>';
      if ($this->Obedience_Loss > 0)
      {
         $Content = $Content.'<b>Poparcie spadło z '.($this->Obedience_Before).' na '.($this->Obedience_Before-$this->Obedience_Loss).'</b><br/>';
      }
      $Current_Date = new DateTime(); 
      $Date_String = $Current_Date->format('Y-m-d H:i:s');
      $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen, title, sent_date) VALUES ($ID_Owner, '$Content', 0, '$Title', '$Date_String')";
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
         $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen, title, sent_date) VALUES ($ID_User, '$Content', 0, '$Title', '$Date_String')";
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

class Retreat_Raport
{
   private static $Connect;
   private static $Object_Counter;
   private $ID_Move;
   public function __construct($Arg_ID_Move)
   {
      if (self::$Object_Counter == 0) self::$Connect = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
      self::$Object_Counter = self::$Object_Counter + 1;
      $this->ID_Move = $Arg_ID_Move;
   }
   public function Send()
   {
      $SQL_String = "SELECT id_army, id_source, old_id_destination FROM gs_moves WHERE id_move=$this->ID_Move";
      $Query = self::$Connect->Query($SQL_String);
      $Record = $Query->fetch_assoc();
      $ID_Source = $Record['id_source'];
      $ID_Destination = $Record['old_id_destination'];
      $ID_Army = $Record['id_army'];
      $SQL_String = "SELECT id_owner, name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Source";
      $Query_2 = self::$Connect->Query($SQL_String);
      $Record_2 = $Query_2->fetch_assoc();
      $ID_User = $Record_2['id_owner'];
      $SQL_String = "SELECT login FROM gs_users WHERE id_user=$ID_User";
      $Query_3 = self::$Connect->Query($SQL_String);
      $Record_3 = $Query_3->fetch_assoc();
      $SQL_String = "SELECT id_owner, name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Destination";
      $Query_4 = self::$Connect->Query($SQL_String);
      $Record_4 = $Query_4->fetch_assoc();
      $SQL_String = "SELECT * FROM gs_armies WHERE id_army=$ID_Army";
      $Query_5 = self::$Connect->Query($SQL_String);
      $Record_5 = $Query_5->fetch_assoc();
      $Content = "<font size=5><b>Wycofano wsparcie</b></font></br></br>";
      $Content = $Content."Gracz ".($Record_3['login']).", ".($Record_2['name'])."(".($Record_2['x_coord'])."|".($Record_2['y_coord']).") wycofał wsparcie z twojego kampusu:<br/>";
      $Title = $Record_3['login'].' wycofuje pomoc z '.($Record_4['name'])."(".($Record_4['x_coord'])."|".($Record_4['y_coord']).')';
      $Content = $Content."<b>".($Record_4['name'])."(".($Record_4['x_coord'])."|".($Record_4['y_coord']).")</b><br/>";
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="../img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/weteran.png" width="25" height="25"></td></tr><tr>';
      $Content = $Content.'<td>'.($Record_5['student']).'</td>';
      $Content = $Content.'<td>'.($Record_5['parachute']).'</td>';
      $Content = $Content.'<td>'.($Record_5['drunkard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['clochard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['nerd']).'</td>';
      $Content = $Content.'<td>'.($Record_5['stooley']).'</td>';
      $Content = $Content.'<td>'.($Record_5['master']).'</td>';
      $Content = $Content.'<td>'.($Record_5['doctor']).'</td>';
      $Content = $Content.'<td>'.($Record_5['inspector']).'</td>';
      $Content = $Content.'<td>'.($Record_5['veteran']).'</td></tr></table>';
      $ID_Player = $Record_4['id_owner'];
      $Current_Date = new DateTime(); 
      $Date_String = $Current_Date->format('Y-m-d H:i:s');
      $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen, title, sent_date) VALUES ($ID_Player, '$Content', 0, '$Title', '$Date_String')";
      $Query = self::$Connect->Query($SQL_String);
   }
   public function __destruct()
   {
      self::$Object_Counter = self::$Object_Counter - 1;
      if (self::$Object_Counter == 0) self::$Connect->close();
   }
}

class Sendback_Raport
{
   private static $Connect;
   private static $Object_Counter;
   private $ID_Move;
   public function __construct($Arg_ID_Move)
   {
      if (self::$Object_Counter == 0) self::$Connect = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
      self::$Object_Counter = self::$Object_Counter + 1;
      $this->ID_Move = $Arg_ID_Move;
   }
   public function Send()
   {
      $SQL_String = "SELECT id_army, id_source, old_id_destination FROM gs_moves WHERE id_move=$this->ID_Move";
      $Query = self::$Connect->Query($SQL_String);
      $Record = $Query->fetch_assoc();
      $ID_Source = $Record['id_source'];
      $ID_Destination = $Record['old_id_destination'];
      $ID_Army = $Record['id_army'];
      $SQL_String = "SELECT id_owner, name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Destination";
      $Query_2 = self::$Connect->Query($SQL_String);
      $Record_2 = $Query_2->fetch_assoc();
      $ID_User = $Record_2['id_owner'];
      $SQL_String = "SELECT login FROM gs_users WHERE id_user=$ID_User";
      $Query_3 = self::$Connect->Query($SQL_String);
      $Record_3 = $Query_3->fetch_assoc();
      $SQL_String = "SELECT id_owner, name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Source";
      $Query_4 = self::$Connect->Query($SQL_String);
      $Record_4 = $Query_4->fetch_assoc();
      $SQL_String = "SELECT * FROM gs_armies WHERE id_army=$ID_Army";
      $Query_5 = self::$Connect->Query($SQL_String);
      $Record_5 = $Query_5->fetch_assoc();
      $Content = "<font size=5><b>Odesłano wsparcie</b></font></br></br>";
      $Content = $Content."Gracz ".($Record_3['login']).", ".($Record_2['name'])."(".($Record_2['x_coord'])."|".($Record_2['y_coord']).") odesłał wsparcie z twojego kampusu:<br/>";
      $Title = $Record_3['login'].' odsyła pomoc z '.($Record_4['name'])."(".($Record_4['x_coord'])."|".($Record_4['y_coord']).')';
      $Content = $Content."<b>".($Record_4['name'])."(".($Record_4['x_coord'])."|".($Record_4['y_coord']).")</b><br/>";
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="../img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/weteran.png" width="25" height="25"></td></tr><tr>';
      $Content = $Content.'<td>'.($Record_5['student']).'</td>';
      $Content = $Content.'<td>'.($Record_5['parachute']).'</td>';
      $Content = $Content.'<td>'.($Record_5['drunkard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['clochard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['nerd']).'</td>';
      $Content = $Content.'<td>'.($Record_5['stooley']).'</td>';
      $Content = $Content.'<td>'.($Record_5['master']).'</td>';
      $Content = $Content.'<td>'.($Record_5['doctor']).'</td>';
      $Content = $Content.'<td>'.($Record_5['inspector']).'</td>';
      $Content = $Content.'<td>'.($Record_5['veteran']).'</td></tr></table>';
      $ID_Player = $Record_4['id_owner'];
      $Current_Date = new DateTime(); 
      $Date_String = $Current_Date->format('Y-m-d H:i:s');
      $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen, title, sent_date) VALUES ($ID_Player, '$Content', 0, '$Title', '$Date_String')";
      $Query = self::$Connect->Query($SQL_String);
   }
   public function __destruct()
   {
      self::$Object_Counter = self::$Object_Counter - 1;
      if (self::$Object_Counter == 0) self::$Connect->close();
   }
}

class Support_Raport
{
   private static $Connect;
   private static $Object_Counter;
   private $ID_Move;
   public function __construct($Arg_ID_Move)
   {
      if (self::$Object_Counter == 0) self::$Connect = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
      self::$Object_Counter = self::$Object_Counter + 1;
      $this->ID_Move = $Arg_ID_Move;
   }
   public function Send()
   {
      $SQL_String = "SELECT id_source, id_destination, id_army FROM gs_moves WHERE id_move=$this->ID_Move";
      $Query = self::$Connect->Query($SQL_String);
      $Record = $Query->fetch_assoc();
      $ID_Source = $Record['id_source'];
      $ID_Destination = $Record['id_destination'];
      $ID_Army = $Record['id_army'];
      $SQL_String = "SELECT id_owner, name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Source";
      $Query_2 = self::$Connect->Query($SQL_String);
      $Record_2 = $Query_2->fetch_assoc();
      $ID_Owner = $Record_2['id_owner'];
      $SQL_String = "SELECT login FROM gs_users WHERE id_user=$ID_Owner";
      $Query_3 = self::$Connect->Query($SQL_String);
      $Record_3 = $Query_3->fetch_assoc();
      $SQL_String = "SELECT id_owner, name, x_coord, y_coord FROM gs_campuses WHERE id_campus=$ID_Destination";
      $Query_4 = self::$Connect->Query($SQL_String);
      $Record_4 = $Query_4->fetch_assoc();
      $ID_Player = $Record_4['id_owner'];
      $SQL_String = "SELECT * FROM gs_armies WHERE id_army=$ID_Army";
      $Query_5 = self::$Connect->Query($SQL_String);
      $Record_5 = $Query_5->fetch_assoc();
      $Content = "<font size=5><b>Wsparcie dotarło</b></font></br></br>";
      $Content = $Content."Wsparcie od ".($Record_3['login']).", ".($Record_2['name'])."(".($Record_2['x_coord'])."|".($Record_2['y_coord']).") dotarło do kampusu ";
      $Title = $Record_3['login'].' wspiera '.($Record_4['name'])."(".($Record_4['x_coord'])."|".($Record_4['y_coord']).')';
      $Content = $Content."<b>".($Record_4['name'])."(".($Record_4['x_coord'])."|".($Record_4['y_coord']).")</b><br/>";
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="../img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/weteran.png" width="25" height="25"></td></tr><tr>';
      $Content = $Content.'<td>'.($Record_5['student']).'</td>';
      $Content = $Content.'<td>'.($Record_5['parachute']).'</td>';
      $Content = $Content.'<td>'.($Record_5['drunkard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['clochard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['nerd']).'</td>';
      $Content = $Content.'<td>'.($Record_5['stooley']).'</td>';
      $Content = $Content.'<td>'.($Record_5['master']).'</td>';
      $Content = $Content.'<td>'.($Record_5['doctor']).'</td>';
      $Content = $Content.'<td>'.($Record_5['inspector']).'</td>';
      $Content = $Content.'<td>'.($Record_5['veteran']).'</td></tr></table>';
      $Current_Date = new DateTime(); 
      $Date_String = $Current_Date->format('Y-m-d H:i:s');
      $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen, title, sent_date) VALUES ($ID_Player, '$Content', 0, '$Title', '$Date_String')";
      $Query = self::$Connect->Query($SQL_String);
      $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen, title, sent_date) VALUES ($ID_Owner, '$Content', 0, '$Title', '$Date_String')";
      $Query = self::$Connect->Query($SQL_String);
   }
   public function __destruct()
   {
      self::$Object_Counter = self::$Object_Counter - 1;
      if (self::$Object_Counter == 0) self::$Connect->close();
   }
}

class Delivery_Raport
{
   private static $Connect;
   private static $Object_Counter;
   private $ID_Trading_Move;
   public function __construct($Arg_ID_Trading_Move)
   {
      if (self::$Object_Counter == 0) self::$Connect = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
      self::$Object_Counter = self::$Object_Counter + 1;
      $this->ID_Trading_Move = $Arg_ID_Trading_Move;
   }
   public function Send()
   {
      $SQL_String = "SELECT id_source, id_destination, vodka, kebab, wifi FROM gs_trading_moves WHERE id_trading_move=$this->ID_Trading_Move";
      $Query = self::$Connect->Query($SQL_String);
      $Record = $Query->fetch_assoc();
      $ID_Source = $Record['id_source'];
      $ID_Destination = $Record['id_destination'];
      $Vodka = $Record['vodka'];
      if (!$Vodka) $Vodka = 0;
      $Kebab = $Record['kebab'];
      if (!$Kebab) $Kebab = 0;
      $Wifi = $Record['wifi'];
      if (!$Wifi) $Wifi = 0;
      $SQL_String = "SELECT name, x_coord, y_coord, id_owner FROM gs_campuses WHERE id_campus=$ID_Source";
      $Query_2 = self::$Connect->Query($SQL_String);
      $Record_2 = $Query_2->fetch_assoc();
      $SQL_String = "SELECT name, x_coord, y_coord, id_owner FROM gs_campuses WHERE id_campus=$ID_Destination";
      $Query_3 = self::$Connect->Query($SQL_String);
      $Record_3 = $Query_3->fetch_assoc();
      $ID_Sender = $Record_2['id_owner'];
      $ID_Receiver = $Record_3['id_owner'];
      $SQL_String = "SELECT login FROM gs_users WHERE id_user=$ID_Sender";
      $Query_4 = self::$Connect->Query($SQL_String);
      $Record_4 = $Query_4->fetch_assoc();
      $SQL_String = "SELECT login FROM gs_users WHERE id_user=$ID_Receiver";
      $Query_5 = self::$Connect->Query($SQL_String);
      $Record_5 = $Query_5->fetch_assoc();
      $Title = "Surowce od ".$Record_4['login'].' dotarły do '.$Record_3['name'].'('.$Record_3['x_coord'].'|'.$Record_3['y_coord'].')';
      $Content = "<font size=5><b>Surowce dotarły</b></font></br></br>";
      $Content = $Content.'Surowce od '.$Record_4['login'].' ,'.$Record_2['name'].'('.$Record_2['x_coord'].'|'.$Record_2['y_coord'].') dotarło do kampusu ';
      $Content = $Content.$Record_3['name'].'('.$Record_3['x_coord'].'|'.$Record_3['y_coord'].')</b></br>';
      $Content = $Content.'<table border=1><tr><td>';
      $Content = $Content.'<img src="img/wodka.png"></td><td><img src="img/kebab.png"></td><td><img src="img/wifi.png"></td></tr>';
      $Content = $Content.'<tr><td>'.$Vodka.'</td>'.$Kebab.'</td>'.$Wifi.'</td></tr></table>';
      $Current_Date = new DateTime(); 
      $Date_String = $Current_Date->format('Y-m-d H:i:s');
      $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen, title, sent_date) VALUES ($ID_Sender, '$Content', 0, '$Title', '$Date_String')";
      $Query = self::$Connect->Query($SQL_String);
      $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen, title, sent_date) VALUES ($ID_Receiver, '$Content', 0, '$Title', '$Date_String')";
      $Query = self::$Connect->Query($SQL_String);
   }
   public function __destruct()
   {
      self::$Object_Counter = self::$Object_Counter - 1;
      if (self::$Object_Counter == 0) self::$Connect->close();
   }
}

class Spying_Raport
{
   private static $Connect;
   private static $Object_Counter;
   private $ID_Move;
   public function __construct($Arg_ID_Move)
   {
      if (self::$Object_Counter == 0) self::$Connect = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
      self::$Object_Counter = self::$Object_Counter + 1;
      $this->ID_Move = $Arg_ID_Move;
   }
   public function Send_Lose()
   {
      $SQL_String = "SELECT id_source, id_destination, id_army FROM gs_moves WHERE id_move=$this->ID_Move";
      $Query = self::$Connect->Query($SQL_String);
      $Record = $Query->fetch_assoc();
      $ID_Source = $Record['id_source'];
      $ID_Destination = $Record['id_destination'];
      $ID_Army = $Record['id_army'];
      $SQL_String = "SELECT name, x_coord, y_coord, id_owner FROM gs_campuses WHERE id_campus=$ID_Source";
      $Query_2 = self::$Connect->Query($SQL_String);
      $Record_2 = $Query_2->fetch_assoc();
      $ID_Sender = $Record_2['id_owner'];
      $SQL_String = "SELECT name, x_coord, y_coord, id_owner FROM gs_campuses WHERE id_campus=$ID_Destination";
      $Query_3 = self::$Connect->Query($SQL_String);
      $Record_3 = $Query_3->fetch_assoc();
      $ID_Receiver = $Record_3['id_owner'];
      $SQL_String = "SELECT login FROM gs_users WHERE id_user=$ID_Sender";
      $Query_4 = self::$Connect->Query($SQL_String);
      $Record_4 = $Query_4->fetch_assoc();
      $SQL_String = "SELECT * FROM gs_armies WHERE id_army=$ID_Army";
      $Query_5 = self::$Connect->Query($SQL_String);
      $Record_5 = $Query_5->fetch_assoc();
      $Title = 'Szpiedzy gracza '.$Record_4['login'].' przyłapani';
      $Content = "<font size=5><b>Szpiedzy przyłapani</b></font></br></br>";
      $Content = $Content.'Szpiedzy od gracza '.$Record_4['login'].', '.$Record_2['name'].'('.$Record_2['x_coord'].'|'.$Record_2['y_coord'].') przyłapani w kampusie ';
      $Content = $Content.$Record_3['name'].'('.$Record_3['x_coord'].'|'.$Record_3['y_coord'].')<br/>';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="../img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/weteran.png" width="25" height="25"></td></tr><tr>';
      $Content = $Content.'<td>'.($Record_5['student']).'</td>';
      $Content = $Content.'<td>'.($Record_5['parachute']).'</td>';
      $Content = $Content.'<td>'.($Record_5['drunkard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['clochard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['nerd']).'</td>';
      $Content = $Content.'<td>'.($Record_5['stooley']).'</td>';
      $Content = $Content.'<td>'.($Record_5['master']).'</td>';
      $Content = $Content.'<td>'.($Record_5['doctor']).'</td>';
      $Content = $Content.'<td>'.($Record_5['inspector']).'</td>';
      $Content = $Content.'<td>'.($Record_5['veteran']).'</td></tr></table>';
      $Current_Date = new DateTime(); 
      $Date_String = $Current_Date->format('Y-m-d H:i:s');
      $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen, title, sent_date) VALUES ($ID_Sender, '$Content', 0, '$Title', '$Date_String')";
      $Query = self::$Connect->Query($SQL_String);
      $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen, title, sent_date) VALUES ($ID_Receiver, '$Content', 0, '$Title', '$Date_String')";
      $Query = self::$Connect->Query($SQL_String);
   }
   public function Send_Win_1()
   {
      $SQL_String = "SELECT id_source, id_destination, id_army FROM gs_moves WHERE id_move=$this->ID_Move";
      $Query = self::$Connect->Query($SQL_String);
      $Record = $Query->fetch_assoc();
      $ID_Source = $Record['id_source'];
      $ID_Destination = $Record['id_destination'];
      $ID_Army = $Record['id_army'];
      $SQL_String = "SELECT name, x_coord, y_coord, id_owner FROM gs_campuses WHERE id_campus=$ID_Source";
      $Query_2 = self::$Connect->Query($SQL_String);
      $Record_2 = $Query_2->fetch_assoc();
      $ID_Sender = $Record_2['id_owner'];
      $SQL_String = "SELECT name, x_coord, y_coord, id_owner FROM gs_campuses WHERE id_campus=$ID_Destination";
      $Query_3 = self::$Connect->Query($SQL_String);
      $Record_3 = $Query_3->fetch_assoc();
      $ID_Receiver = $Record_3['id_owner'];
      $SQL_String = "SELECT login FROM gs_users WHERE id_user=$ID_Sender";
      $Query_4 = self::$Connect->Query($SQL_String);
      $Record_4 = $Query_4->fetch_assoc();
      $SQL_String = "SELECT * FROM gs_armies WHERE id_army=$ID_Army";
      $Query_5 = self::$Connect->Query($SQL_String);
      $Record_5 = $Query_5->fetch_assoc();
      $Title = 'Szpiegowanie '.$Record_3['name'].'('.$Record_3['x_coord'].'|'.$Record_3['y_coord'].') udane';
      $Content = "<font size=5><b>Szpiegowanie udane</b></font></br></br>";
      $Content = $Content.'Szpiedzy od '.$Record_4['login'].', '.$Record_2['name'].'('.$Record_2['x_coord'].'|'.$Record_2['y_coord'].') donoszą <br/> informacje o kampusie ';
      $Content = $Content.$Record_3['name'].'('.$Record_3['x_coord'].'|'.$Record_3['y_coord'].')<br/>';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="../img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/weteran.png" width="25" height="25"></td></tr><tr>';
      $Content = $Content.'<td>'.($Record_5['student']).'</td>';
      $Content = $Content.'<td>'.($Record_5['parachute']).'</td>';
      $Content = $Content.'<td>'.($Record_5['drunkard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['clochard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['nerd']).'</td>';
      $Content = $Content.'<td>'.($Record_5['stooley']).'</td>';
      $Content = $Content.'<td>'.($Record_5['master']).'</td>';
      $Content = $Content.'<td>'.($Record_5['doctor']).'</td>';
      $Content = $Content.'<td>'.($Record_5['inspector']).'</td>';
      $Content = $Content.'<td>'.($Record_5['veteran']).'</td></tr></table></br>';
      $SQL_String = "SELECT * FROM gs_armies WHERE id_stayingcampus=$ID_Destination AND id_homecampus=$ID_Destination";
      $Query_6 = self::$Connect->Query($SQL_String);
      $Record_6 = $Query_6->fetch_assoc();
      $Content = $Content.'Wojska w kampusie (bez wojsk z zewnątrz):<br/>';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="../img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/weteran.png" width="25" height="25"></td></tr><tr>';
      $Content = $Content.'<td>'.($Record_6['student']).'</td>';
      $Content = $Content.'<td>'.($Record_6['parachute']).'</td>';
      $Content = $Content.'<td>'.($Record_6['drunkard']).'</td>';
      $Content = $Content.'<td>'.($Record_6['clochard']).'</td>';
      $Content = $Content.'<td>'.($Record_6['nerd']).'</td>';
      $Content = $Content.'<td>'.($Record_6['stooley']).'</td>';
      $Content = $Content.'<td>'.($Record_6['master']).'</td>';
      $Content = $Content.'<td>'.($Record_6['doctor']).'</td>';
      $Content = $Content.'<td>'.($Record_6['inspector']).'</td>';
      $Content = $Content.'<td>'.($Record_6['veteran']).'</td></tr></table><br/>';
      $SQL_String = "SELECT * FROM gs_campuses WHERE id_campus=$ID_Destination";
      $Query_7 = self::$Connect->Query($SQL_String);
      $Record_7 = $Query_7->fetch_assoc();
      $Content = $Content.'Budynki:<br/>';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td>Akademik</td>';
      $Content = $Content.'<td>'.($Record_7['dormitory']).'</td></tr>';
      $Content = $Content.'<tr><td>Autobusy</td>';
      $Content = $Content.'<td>'.($Record_7['transit']).'</td></tr>';
      $Content = $Content.'<tr><td>WI1</td>';
      $Content = $Content.'<td>'.($Record_7['college']).'</td></tr>';
      $Content = $Content.'<tr><td>Monopolowy</td>';
      $Content = $Content.'<td>'.($Record_7['liquirstore']).'</td></tr>';
      $Content = $Content.'<tr><td>Parking</td>';
      $Content = $Content.'<td>'.($Record_7['parking']).'</td></tr>';
      $Content = $Content.'<tr><td>Ławeczka</td>';
      $Content = $Content.'<td>'.($Record_7['bench']).'</td></tr>';
      $Content = $Content.'<tr><td>Zajezdnia</td>';
      $Content = $Content.'<td>'.($Record_7['terminus']).'</td></tr>';
      $Content = $Content.'<tr><td>Kafejka</td>';
      $Content = $Content.'<td>'.($Record_7['cafe']).'</td></tr>';
      $Content = $Content.'<tr><td>Gorzelnia</td>';
      $Content = $Content.'<td>'.($Record_7['distillery']).'</td></tr>';
      $Content = $Content.'<tr><td>Spot WiFi</td>';
      $Content = $Content.'<td>'.($Record_7['wifispot']).'</td></tr>';
      $Content = $Content.'<tr><td>Doner</td>';
      $Content = $Content.'<td>'.($Record_7['doner']).'</td></tr></table>';
      $Current_Date = new DateTime(); 
      $Date_String = $Current_Date->format('Y-m-d H:i:s');
      $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen, title, sent_date) VALUES ($ID_Sender, '$Content', 0, '$Title', '$Date_String')";
      $Query = self::$Connect->Query($SQL_String);
   }
   public function Send_Win_2()
   {
      $SQL_String = "SELECT id_source, id_destination, id_army FROM gs_moves WHERE id_move=$this->ID_Move";
      $Query = self::$Connect->Query($SQL_String);
      $Record = $Query->fetch_assoc();
      $ID_Source = $Record['id_source'];
      $ID_Destination = $Record['id_destination'];
      $ID_Army = $Record['id_army'];
      $SQL_String = "SELECT name, x_coord, y_coord, id_owner FROM gs_campuses WHERE id_campus=$ID_Source";
      $Query_2 = self::$Connect->Query($SQL_String);
      $Record_2 = $Query_2->fetch_assoc();
      $ID_Sender = $Record_2['id_owner'];
      $SQL_String = "SELECT name, x_coord, y_coord, id_owner FROM gs_campuses WHERE id_campus=$ID_Destination";
      $Query_3 = self::$Connect->Query($SQL_String);
      $Record_3 = $Query_3->fetch_assoc();
      $ID_Receiver = $Record_3['id_owner'];
      $SQL_String = "SELECT login FROM gs_users WHERE id_user=$ID_Sender";
      $Query_4 = self::$Connect->Query($SQL_String);
      $Record_4 = $Query_4->fetch_assoc();
      $SQL_String = "SELECT * FROM gs_armies WHERE id_army=$ID_Army";
      $Query_5 = self::$Connect->Query($SQL_String);
      $Record_5 = $Query_5->fetch_assoc();
      $Title = 'Szpiegowanie '.$Record_3['name'].'('.$Record_3['x_coord'].'|'.$Record_3['y_coord'].') udane';
      $Content = "<font size=5><b>Szpiegowanie udane</b></font></br></br>";
      $Content = $Content.'Szpiedzy od '.$Record_4['login'].', '.$Record_2['name'].'('.$Record_2['x_coord'].'|'.$Record_2['y_coord'].') donoszą <br/> informacje o kampusie ';
      $Content = $Content.$Record_3['name'].'('.$Record_3['x_coord'].'|'.$Record_3['y_coord'].')<br/>';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="../img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/weteran.png" width="25" height="25"></td></tr><tr>';
      $Content = $Content.'<td>'.($Record_5['student']).'</td>';
      $Content = $Content.'<td>'.($Record_5['parachute']).'</td>';
      $Content = $Content.'<td>'.($Record_5['drunkard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['clochard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['nerd']).'</td>';
      $Content = $Content.'<td>'.($Record_5['stooley']).'</td>';
      $Content = $Content.'<td>'.($Record_5['master']).'</td>';
      $Content = $Content.'<td>'.($Record_5['doctor']).'</td>';
      $Content = $Content.'<td>'.($Record_5['inspector']).'</td>';
      $Content = $Content.'<td>'.($Record_5['veteran']).'</td></tr></table></br>';
      $SQL_String = "SELECT * FROM gs_armies WHERE id_stayingcampus=$ID_Destination AND id_homecampus=$ID_Destination";
      $Query_6 = self::$Connect->Query($SQL_String);
      $Record_6 = $Query_6->fetch_assoc();
      $Content = $Content.'Wojska w kampusie (bez wojsk z zewnątrz):<br/>';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="../img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/weteran.png" width="25" height="25"></td></tr><tr>';
      $Content = $Content.'<td>'.($Record_6['student']).'</td>';
      $Content = $Content.'<td>'.($Record_6['parachute']).'</td>';
      $Content = $Content.'<td>'.($Record_6['drunkard']).'</td>';
      $Content = $Content.'<td>'.($Record_6['clochard']).'</td>';
      $Content = $Content.'<td>'.($Record_6['nerd']).'</td>';
      $Content = $Content.'<td>'.($Record_6['stooley']).'</td>';
      $Content = $Content.'<td>'.($Record_6['master']).'</td>';
      $Content = $Content.'<td>'.($Record_6['doctor']).'</td>';
      $Content = $Content.'<td>'.($Record_6['inspector']).'</td>';
      $Content = $Content.'<td>'.($Record_6['veteran']).'</td></tr></table><br/>';
      $SQL_String = "SELECT * FROM gs_campuses WHERE id_campus=$ID_Destination";
      $Query_7 = self::$Connect->Query($SQL_String);
      $Record_7 = $Query_7->fetch_assoc();
      $Content = $Content.'Budynki:<br/>';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td>Akademik</td>';
      $Content = $Content.'<td>'.($Record_7['dormitory']).'</td></tr>';
      $Content = $Content.'<tr><td>Autobusy</td>';
      $Content = $Content.'<td>'.($Record_7['transit']).'</td></tr>';
      $Content = $Content.'<tr><td>WI1</td>';
      $Content = $Content.'<td>'.($Record_7['college']).'</td></tr>';
      $Content = $Content.'<tr><td>Monopolowy</td>';
      $Content = $Content.'<td>'.($Record_7['liquirstore']).'</td></tr>';
      $Content = $Content.'<tr><td>Parking</td>';
      $Content = $Content.'<td>'.($Record_7['parking']).'</td></tr>';
      $Content = $Content.'<tr><td>Ławeczka</td>';
      $Content = $Content.'<td>'.($Record_7['bench']).'</td></tr>';
      $Content = $Content.'<tr><td>Zajezdnia</td>';
      $Content = $Content.'<td>'.($Record_7['terminus']).'</td></tr>';
      $Content = $Content.'<tr><td>Kafejka</td>';
      $Content = $Content.'<td>'.($Record_7['cafe']).'</td></tr>';
      $Content = $Content.'<tr><td>Gorzelnia</td>';
      $Content = $Content.'<td>'.($Record_7['distillery']).'</td></tr>';
      $Content = $Content.'<tr><td>Spot WiFi</td>';
      $Content = $Content.'<td>'.($Record_7['wifispot']).'</td></tr>';
      $Content = $Content.'<tr><td>Doner</td>';
      $Content = $Content.'<td>'.($Record_7['doner']).'</td></tr></table><br/>';
      $Content = $Content.'Surowce:<br/>';
      $Content = $Content.'<img src="../img/wodka.png" width="25" height="25">'.($Record_7['amount_vodka']).'<img src="../img/kebab.png" width="25" height="25">'.($Record_7['amount_kebab']).'<img src="../img/wifi.png" width="25" height="25">'.($Record_7['amount_wifi']).'</font><br/>';
      $Current_Date = new DateTime(); 
      $Date_String = $Current_Date->format('Y-m-d H:i:s');
      $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen, title, sent_date) VALUES ($ID_Sender, '$Content', 0, '$Title', '$Date_String')";
      $Query = self::$Connect->Query($SQL_String);
   }
   public function Send_Win_3()
   {
      $SQL_String = "SELECT id_source, id_destination, id_army FROM gs_moves WHERE id_move=$this->ID_Move";
      $Query = self::$Connect->Query($SQL_String);
      $Record = $Query->fetch_assoc();
      $ID_Source = $Record['id_source'];
      $ID_Destination = $Record['id_destination'];
      $ID_Army = $Record['id_army'];
      $SQL_String = "SELECT name, x_coord, y_coord, id_owner FROM gs_campuses WHERE id_campus=$ID_Source";
      $Query_2 = self::$Connect->Query($SQL_String);
      $Record_2 = $Query_2->fetch_assoc();
      $ID_Sender = $Record_2['id_owner'];
      $SQL_String = "SELECT name, x_coord, y_coord, id_owner FROM gs_campuses WHERE id_campus=$ID_Destination";
      $Query_3 = self::$Connect->Query($SQL_String);
      $Record_3 = $Query_3->fetch_assoc();
      $ID_Receiver = $Record_3['id_owner'];
      $SQL_String = "SELECT login FROM gs_users WHERE id_user=$ID_Sender";
      $Query_4 = self::$Connect->Query($SQL_String);
      $Record_4 = $Query_4->fetch_assoc();
      $SQL_String = "SELECT * FROM gs_armies WHERE id_army=$ID_Army";
      $Query_5 = self::$Connect->Query($SQL_String);
      $Record_5 = $Query_5->fetch_assoc();
      $Title = 'Szpiegowanie '.$Record_3['name'].'('.$Record_3['x_coord'].'|'.$Record_3['y_coord'].') udane';
      $Content = "<font size=5><b>Szpiegowanie udane</b></font></br></br>";
      $Content = $Content.'Szpiedzy od '.$Record_4['login'].', '.$Record_2['name'].'('.$Record_2['x_coord'].'|'.$Record_2['y_coord'].') donoszą <br/> informacje o kampusie ';
      $Content = $Content.$Record_3['name'].'('.$Record_3['x_coord'].'|'.$Record_3['y_coord'].')<br/>';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="../img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/weteran.png" width="25" height="25"></td></tr><tr>';
      $Content = $Content.'<td>'.($Record_5['student']).'</td>';
      $Content = $Content.'<td>'.($Record_5['parachute']).'</td>';
      $Content = $Content.'<td>'.($Record_5['drunkard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['clochard']).'</td>';
      $Content = $Content.'<td>'.($Record_5['nerd']).'</td>';
      $Content = $Content.'<td>'.($Record_5['stooley']).'</td>';
      $Content = $Content.'<td>'.($Record_5['master']).'</td>';
      $Content = $Content.'<td>'.($Record_5['doctor']).'</td>';
      $Content = $Content.'<td>'.($Record_5['inspector']).'</td>';
      $Content = $Content.'<td>'.($Record_5['veteran']).'</td></tr></table></br>';
      $Content = $Content.'Wojska w kampusie:<br/>';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td><img src="../img/student.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/spadochroniarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/menel.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kloszard.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/nerd.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/stulejarz.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/magister.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/doktor.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/kanar.png" width="25" height="25"></td>';
      $Content = $Content.'<td><img src="../img/weteran.png" width="25" height="25"></td></tr><tr>';
      $SQL_String = "SELECT sum(student) FROM gs_armies WHERE id_stayingcampus=$ID_Destination";
      $Query_6 = self::$Connect->Query($SQL_String);
      $Record_6 = $Query_6->fetch_assoc();
      $Content = $Content.'<td>'.($Record_6['sum(student)']).'</td>';
      $SQL_String = "SELECT sum(parachute) FROM gs_armies WHERE id_stayingcampus=$ID_Destination";
      $Query_6 = self::$Connect->Query($SQL_String);
      $Record_6 = $Query_6->fetch_assoc();
      $Content = $Content.'<td>'.($Record_6['sum(parachute)']).'</td>';
      $SQL_String = "SELECT sum(drunkard) FROM gs_armies WHERE id_stayingcampus=$ID_Destination";
      $Query_6 = self::$Connect->Query($SQL_String);
      $Record_6 = $Query_6->fetch_assoc();
      $Content = $Content.'<td>'.($Record_6['sum(drunkard)']).'</td>';
      $SQL_String = "SELECT sum(clochard) FROM gs_armies WHERE id_stayingcampus=$ID_Destination";
      $Query_6 = self::$Connect->Query($SQL_String);
      $Record_6 = $Query_6->fetch_assoc();
      $Content = $Content.'<td>'.($Record_6['sum(clochard)']).'</td>';
      $SQL_String = "SELECT sum(nerd) FROM gs_armies WHERE id_stayingcampus=$ID_Destination";
      $Query_6 = self::$Connect->Query($SQL_String);
      $Record_6 = $Query_6->fetch_assoc();
      $Content = $Content.'<td>'.($Record_6['sum(nerd)']).'</td>';
      $SQL_String = "SELECT sum(stooley) FROM gs_armies WHERE id_stayingcampus=$ID_Destination";
      $Query_6 = self::$Connect->Query($SQL_String);
      $Record_6 = $Query_6->fetch_assoc();
      $Content = $Content.'<td>'.($Record_6['sum(stooley)']).'</td>';
      $SQL_String = "SELECT sum(master) FROM gs_armies WHERE id_stayingcampus=$ID_Destination";
      $Query_6 = self::$Connect->Query($SQL_String);
      $Record_6 = $Query_6->fetch_assoc();
      $Content = $Content.'<td>'.($Record_6['sum(master)']).'</td>';
      $SQL_String = "SELECT sum(doctor) FROM gs_armies WHERE id_stayingcampus=$ID_Destination";
      $Query_6 = self::$Connect->Query($SQL_String);
      $Record_6 = $Query_6->fetch_assoc();
      $Content = $Content.'<td>'.($Record_6['sum(doctor)']).'</td>';
      $SQL_String = "SELECT sum(inspector) FROM gs_armies WHERE id_stayingcampus=$ID_Destination";
      $Query_6 = self::$Connect->Query($SQL_String);
      $Record_6 = $Query_6->fetch_assoc();
      $Content = $Content.'<td>'.($Record_6['sum(inspector)']).'</td>';
      $SQL_String = "SELECT sum(veteran) FROM gs_armies WHERE id_stayingcampus=$ID_Destination";
      $Query_6 = self::$Connect->Query($SQL_String);
      $Record_6 = $Query_6->fetch_assoc();
      $Content = $Content.'<td>'.($Record_6['sum(veteran)']).'</td></tr></table><br/>';
      $SQL_String = "SELECT * FROM gs_campuses WHERE id_campus=$ID_Destination";
      $Query_7 = self::$Connect->Query($SQL_String);
      $Record_7 = $Query_7->fetch_assoc();
      $Content = $Content.'Budynki:<br/>';
      $Content = $Content.'<table border=1><tr>';
      $Content = $Content.'<td>Akademik</td>';
      $Content = $Content.'<td>'.($Record_7['dormitory']).'</td></tr>';
      $Content = $Content.'<tr><td>Autobusy</td>';
      $Content = $Content.'<td>'.($Record_7['transit']).'</td></tr>';
      $Content = $Content.'<tr><td>WI1</td>';
      $Content = $Content.'<td>'.($Record_7['college']).'</td></tr>';
      $Content = $Content.'<tr><td>Monopolowy</td>';
      $Content = $Content.'<td>'.($Record_7['liquirstore']).'</td></tr>';
      $Content = $Content.'<tr><td>Parking</td>';
      $Content = $Content.'<td>'.($Record_7['parking']).'</td></tr>';
      $Content = $Content.'<tr><td>Ławeczka</td>';
      $Content = $Content.'<td>'.($Record_7['bench']).'</td></tr>';
      $Content = $Content.'<tr><td>Zajezdnia</td>';
      $Content = $Content.'<td>'.($Record_7['terminus']).'</td></tr>';
      $Content = $Content.'<tr><td>Kafejka</td>';
      $Content = $Content.'<td>'.($Record_7['cafe']).'</td></tr>';
      $Content = $Content.'<tr><td>Gorzelnia</td>';
      $Content = $Content.'<td>'.($Record_7['distillery']).'</td></tr>';
      $Content = $Content.'<tr><td>Spot WiFi</td>';
      $Content = $Content.'<td>'.($Record_7['wifispot']).'</td></tr>';
      $Content = $Content.'<tr><td>Doner</td>';
      $Content = $Content.'<td>'.($Record_7['doner']).'</td></tr></table><br/>';
      $Content = $Content.'Surowce:<br/>';
      $Content = $Content.'<img src="../img/wodka.png" width="25" height="25">'.($Record_7['amount_vodka']).'<img src="../img/kebab.png" width="25" height="25">'.($Record_7['amount_kebab']).'<img src="../img/wifi.png" width="25" height="25">'.($Record_7['amount_wifi']).'</font><br/>';
      $Content = $Content.'Poparcie: '.$Record_7['obedience'].'<br/>';
      $Current_Date = new DateTime(); 
      $Date_String = $Current_Date->format('Y-m-d H:i:s');
      $SQL_String = "INSERT INTO gs_raports (id_addressee, content, seen, title, sent_date) VALUES ($ID_Sender, '$Content', 0, '$Title', '$Date_String')";
      $Query = self::$Connect->Query($SQL_String);
   }
   public function __destruct()
   {
      self::$Object_Counter = self::$Object_Counter - 1;
      if (self::$Object_Counter == 0) self::$Connect->close();
   }
}

}
?>