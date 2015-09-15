<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>                           
    <head>                                             
        <meta http-equiv="content-type" content="text/html; charset=utf-8">          
        <link rel="stylesheet" type="text/css" href="css/window.css" />
        <script type="text/javascript" src="checkAll.js"></script>
        <script type="text/javascript">
        function load_msg(id) {
            var msg_area = document.getElementById(id);
            
            if(msg_area.style.display != 'table-cell') {                       
                msg_area.style.display = 'table-cell';
                msg_area.innerHTML = '<center><img width="30" height="30" src="../img/loading.gif" /></center>';
     
                var client = new XMLHttpRequest();
                client.open('POST', 'load_raport.php', true);
                client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                client.send('msg_id='+id.substring(4));
                client.onreadystatechange = function() {
                    if(200 === this.status && 4 === this.readyState) {
                        var json = this.responseText;
                        eval('var json_obj = ('+json+')'); 
                        msg_area.innerHTML = json_obj.msg.content;  
                        document.getElementById('TR'+id.substring(4)).className = 'msg_header';                           
                    }
                }
            } else
                msg_area.style.display = 'none';
        }
        </script>
        <style type="text/css">
        .true, .false {font-weight: bold;}
        .true {color: green;}
        .false {color: red;}
        /*MSG*/
        .msg_content {display: none;}
        .msg_header, .msg_header_new {cursor: pointer; border-radius: 10px;}
        .msg_header {background-image: url('../img/messages/1.gif');}
        .msg_header_new {background-image: url('../img/messages/2.gif');}
        /*
        #FF9020
        #10407F
        */
        </style>                            
    </head>         
    <body>  
<?php
require "db_connect.php";
$connect = new mysqli($db_host, $db_user, $db_password, $db_name);

if(isset($_POST["delete_messages"])) {
    @$message_table = $_POST["checkbox_message"];   
    
    for($i = 0; $i < count($message_table); $i++) {
        $z = "DELETE FROM gs_raports WHERE id_raport = '".$message_table[$i]."'";   
        $q = $connect->query($z); 
    } 
}

$z = "SELECT * FROM gs_raports WHERE id_addressee = (SELECT id_user FROM gs_users WHERE login = '".$_SESSION["login"]."') ORDER BY id_raport DESC";
$q = $connect->query($z);

if($q->num_rows != 0):
?>
            <form method="post">
                <table width="540" cellspacing="0" cellpadding="5" border="0">
                    <tr>
                        <td width="10">
                            <input type="checkbox" name="CUAll" value="Zaznacz wszystkie" onClick="javascript:CheckAll(this.form.elements, this.checked)" /></td>
                        <td align="center">
                            <input type="submit" name="delete_messages" value="Usuń" onClick="if(confirm('Na pewno?')) {return true;} else {return false;}" /></td>
                    </tr>
<?php
    while($rec = $q->fetch_assoc()):
        if($rec["seen"])
            echo "<tr class=\"msg_header\" id=\"TR".$rec["id_raport"]."\">";
        else
            echo "<tr class=\"msg_header_new\" id=\"TR".$rec["id_raport"]."\">";
        
        echo "<td width=\"10\" onClick=\"javascript:Check2('".$rec["id_raport"]."')\">".'<input type="checkbox" name="checkbox_message[]" value="'.$rec["id_raport"].'" id="'.$rec["id_raport"].'" />'."</td>";        
?>                      
                        <td onClick="javascript:load_msg('msg_<?php echo $rec["id_raport"]; ?>')">                                    
                            <?php echo $rec["title"]; ?>
                        </td>
                    </tr>
                    <tr>                              
                        <td colspan="2" class="msg_content" id="msg_<?php echo $rec["id_raport"]; ?>">             
                        </td>
                    </tr>
<?php
    endwhile;
?>   
                </table>
            </form>
<?php               
else:
    echo "<center>Pusto...</center>";
endif;

$q->free_result();
$connect->close();
?>
    </body>
</html>