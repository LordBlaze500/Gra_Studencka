<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); 
$headers            = "From: Gra_Studencka\r\n".
                        "Content-type: text/html; charset=utf-8\r\n".
                        "Reply-to: Gra_Studencka\r\n";
$message            = "Dziękujemy za rejestrację :) bleble \r\n".
                        "Link aktywacyjny: http://www.grastudencka.cba.pl blabla"; 
                        
//$result = mail (                                                                                                                       
//"root@grastudencka.cba.pl", "Aktywacja konta", $message, $headers
//);

$result = mail('pajejek500@gmail.com', "Aktywacja konta", $message, $headers);                  

echo 'chuj<br/>';  
echo $result;
?>
