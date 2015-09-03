<html>
    <body> 
    <canvas id="canvas" width="500" height="500" style="border: 1px solid black; cursor: grab"></canvas><br />
    <button onClick="javascript:zoom('in')">+</button>
    <button onClick="javascript:zoom('out')">-</button>
    <style type="text/css">
    .obj {position: absolute; width: 5px; height: 5px; background-color: red;}
    .center {position: absolute; width: 5px; height: 5px; background-color: green;}
    </style>
    <div id="wiochy"></div>
    <script type="text/javascript">
    var canvas          = document.getElementById('canvas');
    skala               = 3;
    var x               = 0;
    var y               = 0;
    pos_x               = 0;
    pos_y               = 0;
    vector_x            = 0;
    vector_y            = 0;  
    var przesuniecie_x  = 0;
    var przesuniecie_y  = 0;    
    var json_obj;
    var interval;
    
    /**********/
    
    var img_load        = false;
    var img             = new Image();
    img.src             = '../img/akademikupgraded.png';
    img.onload          = function() {
        img_load = true;
    }
    
    canvas.addEventListener('mousemove', mousemove, false);
    canvas.addEventListener('mousedown', mousedown, false);
    canvas.addEventListener('mouseup', mouseup, false);  
    
    function mousemove(ev) {
        if(ev.layerX || ev.layerX == 0) { 
            x = ev.layerX;
            y = ev.layerY;
        } else if(ev.offsetX || ev.offsetX == 0) { 
            x = ev.offsetX;
            y = ev.offsetY;
        }
    }
    
    function mousedown() {
        pos_x = x;
        pos_y = y;
        canvas.style.cursor = 'grabbing';  
        clearInterval(interval);
        interval = setInterval('move_map()', 30); 
    }
    
    function mouseup() {
        canvas.style.cursor = 'grab';
        clearInterval(interval);
        przesuniecie_x += vector_x;
        przesuniecie_y += vector_y;
    }
    
    function move_map() {
        vector_x = (pos_x - x) * -1;
        vector_y = (pos_y - y) * -1;
        rysuj_mape(skala);
    }
    
    if(canvas.getContext('2d')) {
        var c = canvas.getContext('2d');
        var w = canvas.width;
        var h = canvas.height;        
    
        var client = new XMLHttpRequest();
        client.open('POST', 'json_wiochy.php', true);
        client.send(null);
        client.onreadystatechange = function() {
            if(200 === this.status && 4 === this.readyState) {
                var json = this.responseText;
                eval('json_obj = ('+json+')');                               
            }
        }
        
        function zoom(id) {
            switch(id) {
                case 'in':
                    if(skala < 9) ++skala;
                break;
                case 'out':
                    if(skala > 3) --skala;
                break;
            }  
                        
            vector_x = 0;
            vector_y = 0;
            rysuj_mape();  
        }
        
        function rysuj_mape() { 
            if(!json_obj || !img_load)
                setTimeout('rysuj_mape()', 50);
             
            var s = Math.pow(2, skala);
            c.clearRect(0, 0, w, h);           
            c.fillStyle = 'red'; 
                            
                for(var i = 0; i < json_obj.wiocha.length; i++) {
                    c.beginPath();
                    //c.arc((json_obj.wiocha[i].x * (5+s)) - 50*s + przesuniecie_x + vector_x, (json_obj.wiocha[i].y * (5+s)) - 50*s + przesuniecie_y + vector_y, 0.2 * s, 0, Math.PI*2, true);                            
                    c.drawImage(img, (json_obj.wiocha[i].x * (5+s)) - 50*s + przesuniecie_x + vector_x, (json_obj.wiocha[i].y * (5+s)) - 50*s + przesuniecie_y + vector_y, 0.5*s, 0.5*s);
                    c.closePath();
                    c.fill();
                }
        }
        
        window.onload = rysuj_mape();    
    } else {alert('Zaopatrz sie w nowsza przegladarke...');}
    </script>
<?php
/*
require "db_connect.php";
$connect = new mysqli($db_host, $db_user, $db_password, $db_name);

$z = "SELECT x_coord, y_coord FROM gs_campuses";
$q = $connect->query($z);
for($i = 0; $rec = $q->fetch_assoc(); $i++) {
    if($rec["y_coord"] == 50 && $rec["x_coord"] == 50)
        echo '<div class="center" style="top: '.($rec["y_coord"]*10).'; left: '.($rec["x_coord"]*10).'"></div>'."\n";
    else    
        echo '<div class="obj" style="top: '.($rec["y_coord"]*10).'; left: '.($rec["x_coord"]*10).'"></div>'."\n";
} 

$connect->close();
*/
?>
    </body>
</html>