<?php

session_start();

if(isset($_GET["logout"])) {

    session_destroy();

    header("Location: index.php");

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>                      

    <head>                                    

        <meta http-equiv="content-type" content="text/html; charset=utf-8"> 

        <link rel="stylesheet" type="text/css" href="css/window.css" />        

        <style type="text/css">

        body {background-image: url('img/bg.png');}        

        a {text-decoration: none; color: #FFFF00; font-weight: bold;}

        a:hover {text-decoration: underline;}

        </style>      

    </head>    

    <body>                

<?php



if(!isset($_SESSION["zalogowany"])):

    require "script/start.php";

else:

    if(isset($_GET["l"])) {

        $l = $_GET["l"];



        switch($l) {

            case "campus_select":

                require "script/campus_select.php";        

            break;
            
            case "move_info":

                require "script/move_info.php";        

            break;
            
            case "army_info":
                
                require "script/army_info.php";
            
            break;

            case "settings":

                require "script/settings.php";

            break;

            case "dormitory":

                require "script/dormitory.php";        

            break;
            
            case "attacks":

                require "script/attack_center.php";        

            break;
            
            case "send_attack":

                require "script/send_attack.php";        

            break;
            
            case "send_help":

                require "script/send_help.php";        

            break;
            
            case "campus_info":

                require "script/campus_info.php";        

            break;
            
            case "obedience":
                
                require "script/obedience.php";
            
            break;
            
            case "user_info":

                require "script/user_info.php";        

            break;
            
            case "change_name":

                require "script/change_name.php";        

            break;

            case "bench":

                require "script/bench.php";        

            break;

            case "terminus":

                require "script/terminus.php";        

            break;

            case "parking":

                require "script/parking.php";        

            break;

            case "transit":

                require "script/transit.php";        

            break;

            case "college":

                require "script/college.php";        

            break;

            case "cafe":

                require "script/cafe.php";        

            break;

            case "liquirstore":

                require "script/liquirstore.php";        

            break;

            case "distillery":

                require "script/distillery.php";        

            break;

            case "wifispot":

                require "script/wifispot.php";        

            break;

            case "student":

                require "script/student.php";        

            break;

            case "parachute":

                require "script/parachute.php";        

            break;

            case "drunkard":

                require "script/drunkard.php";        

            break;

            case "clochard":

                require "script/clochard.php";        

            break;

            case "nerd":

                require "script/nerd.php";        

            break;

            case "stooley":

                require "script/stooley.php";        

            break;

            case "master":

                require "script/master.php";        

            break;

            case "doctor":

                require "script/doctor.php";        

            break;

            case "inspector":

                require "script/inspector.php";        

            break;

            case "veteran":

                require "script/veteran.php";        

            break;

            case "doner":

                require "script/doner.php";        

            break;

            case "main":

                require "script/main.php";        

            break;

            case "rektorat":

                require "script/rektorat.php";        

            break;
            
            case "map":

                require "script/map.php";        

            break;
            
            case "help":

                require "script/help.php";        

            break;

            default:

                echo "Nic tu nie ma";

            break;

        }

    } else

        require "script/campus_select.php";

endif;



?>

        <table border="0" cellspacing="0" cellpadding="0" width="350" height="500" id="window">    

            <tr>

                <td class="move" onMouseDown="javascript:Move('#window')" onMouseUp="javascript:StopMove()">Title</td>

                <td class="close" onClick="javascript:Window_('#window', '0', '', 'off')"></td>

            </tr>    

            <tr>

                <td colspan="2">

                    <iframe style="border: 0px" id="window_iframe" name="window_iframe" width="350">

                    </iframe></td>

            </tr>                                                                                                                                                                                                                      

        </table>

        <script type="text/javascript" src="script/window.js"></script>

        <script type="text/javascript" src="script/jquery.js"></script> 

    </body>

</html>
