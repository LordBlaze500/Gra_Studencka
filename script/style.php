<?php
if (!defined('__STYLE_PHP__'))
{
   define('__STYLE_PHP__',1);
   function Style_Inline()
   {
      echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
      echo '<title>Gra studencka</title>';
      echo '<link rel="icon" href="img/wodka.png" type="image/png">';
      echo '<style>';
      echo 'table';
      echo '{';
      echo '   border-collapse: collapse;';
      echo '}';
      echo 'table, td, th';
      echo '{';
      echo '   border: 3px solid #0404B4;';
      echo '}';
      echo 'body {';
      echo 'font-family:Georgia;';
      //echo 'font-size:1.3em;';
      echo '}';
      echo '</style>';
   }

   function Bg_Color_One()
   {
      echo '"#81F7F3"';
   }

   function Bg_Color_Two()
   {
      echo '"#FFBF00"';
   }

   function Bg_Color_Three()
   {
      echo '"#31B404"';
   }
}
?>