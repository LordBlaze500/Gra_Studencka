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
                client.open('POST', 'load_msg.php', true);
                client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                client.send('msg_id='+id.substring(4));
                client.onreadystatechange = function() {                
                    if(200 == this.status && 4 == this.readyState) {
                        var json = this.responseText;
                        eval('var json_obj = ('+json+')'); 
                        msg_area.innerHTML = json_obj.msg.content + '<br /><br /><span class="data">Wysłano ' + json_obj.msg.data + '</span>';  
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
        /*TOP*/
        .top_buttons, .top_buttons_active {text-decoration: none; font-weight: bold; padding: 5px 5px 0px 5px;  border-top-left-radius: 10px; border-top-right-radius: 10px;}
        .top_buttons {color: green; background-color: #FF9020;}
        .top_buttons:hover {text-decoration: underline;}
        .top_buttons_active {color: white; background-color: #10407F;}
        /*MSG*/
        .msg_area {background-color: #10407F; border-radius: 20px; padding: 5px; position: relative; top: -1px;}
        .msg_content {display: none;}
        .msg_header, .msg_header_new {cursor: pointer; border-radius: 10px;}
        .msg_header {background-image: url('../img/messages/1.gif');}
        .msg_header_new {background-image: url('../img/messages/2.gif');}
        .data {color: yellow;}
        /*
        #FF9020
        #10407F
        */
        </style>                            
    </head>         
    <body>  
<?php
if(isset($_GET["messages_l"]))                                                      
    $messages_l = $_GET["messages_l"];
else
    $messages_l = "inbox";    
?> 
        <center>    
            <a id="top_inbox" class="<?php echo ($messages_l == "inbox") ? "top_buttons_active" : "top_buttons"; ?>" href="?messages_l=inbox">Odebrane</a>    
            <a id="top_new" class="<?php echo ($messages_l == "new") ? "top_buttons_active" : "top_buttons"; ?>" href="?messages_l=new">Nowa</a>
        </center>
        <div class="msg_area">
<?php
require "db_connect.php";
$connect = new mysqli($db_host, $db_user, $db_password, $db_name);

// Inbox

if($messages_l == "inbox"): 
    if(isset($_POST["delete_messages"])) {
        @$message_table = $_POST["checkbox_message"];   
        
        for($i = 0; $i < count($message_table); $i++) {
            $z = "DELETE FROM gs_messages WHERE id_message = '".$message_table[$i]."'";   
            $q = $connect->query($z); 
        } 
    }
    
    $z = "SELECT * FROM gs_messages JOIN gs_users ON (gs_messages.sender = gs_users.id_user) WHERE gs_messages.addressee = (SELECT id_user FROM gs_users WHERE login = '".$_SESSION["login"]."') ORDER BY id_message DESC";
    $q = $connect->query($z);
    
    if($q->num_rows != 0):
?>
                <form method="post">
                    <table width="310" cellspacing="0" cellpadding="5" border="0">
                        <tr>
                            <td width="10">
                                <input type="checkbox" name="CUAll" value="Zaznacz wszystkie" onClick="javascript:CheckAll(this.form.elements, this.checked)" /></td>
                            <td align="center">
                                <input type="submit" name="delete_messages" value="Usuń" onClick="if(confirm('Na pewno?')) {return true;} else {return false;}" /></td>
                        </tr>
<?php
        while($rec = $q->fetch_assoc()):
            if($rec["seen"])
                echo "<tr class=\"msg_header\" id=\"TR".$rec["id_message"]."\">";
            else
                echo "<tr class=\"msg_header_new\" id=\"TR".$rec["id_message"]."\">";
            
            echo "<td width=\"10\" onClick=\"javascript:Check2('".$rec["id_message"]."')\">".'<input type="checkbox" name="checkbox_message[]" value="'.$rec["id_message"].'" id="'.$rec["id_message"].'" />'."</td>";        
?>                      
                            <td onClick="javascript:load_msg('msg_<?php echo $rec["id_message"]; ?>')">                                    
                                <?php echo $rec["login"]; ?>
                            </td>
                        </tr>
                        <tr>                              
                            <td colspan="2" class="msg_content" id="msg_<?php echo $rec["id_message"]; ?>">            
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
    
// New

    $q->free_result();
else:
    if(isset($_POST["msg_ok"])) {
        $to         = $_POST["to"];
        $content    = $_POST["content"];
        
        if($to != -1 && $content != "") {
            $Current_Date = new DateTime(); 
            $Date_String = $Current_Date->format('Y-m-d H:i:s');
            $z = "INSERT INTO gs_messages (content, sender, addressee, seen, sent_date) VALUES ('$content', (SELECT id_user FROM gs_users WHERE login = '".$_SESSION["login"]."'), '$to', 0, '$Date_String')";
            $q = $connect->query($z);            
            
            echo ($q) ? '<center><font class="true">Wiadomość została wysłana</font></center><br />'."\n" : '<center><font class="false">Wystąpił błąd...</font></center><br />'."\n";
        } else
            echo '<center><font class="false">Wypełnij wszystkie pola!</font></center><br />'."\n";
    }
?>
            <form method="post">Do      
                <select name="to">        
                    <option value="-1" selected>--Wybierz--
                    </option>        
<?php
        $z = "SELECT id_user, login FROM gs_users WHERE id_user != 0";
        $q = $connect->query($z);
        
        while($rec = $q->fetch_assoc())
            echo '<option value='.$rec["id_user"].'>'.$rec["login"].'</option>'."\n";
?>    
                </select><br />    
                <textarea name="content" cols="37" rows="15"></textarea>    
                <center>        
                    <input type="reset" value="Czyść" />        
                    <input type="submit" value="Wyślij" name="msg_ok" />    
                </center>
            </form>
<?php
endif;
$connect->close();
?>
        </div>
    </body>
</html>