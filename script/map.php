<?php
require "db_connect.php";
require "style.php";

$connect = new mysqli($db_host, $db_user, $db_password, $db_name);

$z = "SELECT x_coord, y_coord FROM gs_campuses WHERE id_campus = ".$_SESSION["id_campus"];
$q = $connect->query($z);
$rec = $q->fetch_assoc();

$connect->close();
?>
<center>
    <canvas id="canvas" width="700" height="700" style="border: 1px solid black; cursor: grab"></canvas>
    <br />
    <button onClick="javascript:zoom('in')">+</button>
    <button onClick="javascript:zoom('out')">-</button>
    <button onclick="javascript:moja_wiocha()">Moja wiocha</button>
    <form name="attacks" method="post" action="?l=attacks">
        <div id="div"></div>
    </form>
    <form method="post" name="send_item" action="?l=trade_center" style="display: none">        
        <input type="hidden" name="X" value="" />
        <input type="hidden" name="Y" value="" />
        <input type="submit" name="send_ok" value="OK" />
    </form>
    <a href="#" onClick="javascript:history.go(-1)">Powrót</a> 
</center>
<style type="text/css">
.obj {position: absolute; width: 5px; height: 5px; background-color: red;}
.center {position: absolute; width: 5px; height: 5px; background-color: green;} 
canvas {background-color: white;}
form {color: black;} /*#31B404   #0404B4*/
#div {/*background-color: #31B404; border: 2px solid #0404B4;*/ background-image: url('img/window/dymek.png'); background-size: 460px 130px; width: 460px; height: 130px; display: none; position: absolute;}
</style>
<script type="text/javascript">
var canvas          = document.getElementById('canvas');
var skala           = 4;
var x               = 0;
var y               = 0;
var pos_x           = 0;
var pos_y           = 0;
var vector_x        = 0;
var vector_y        = 0;  
var village_x       = <?php echo ((50-$rec["x_coord"])*7)."\n"; ?>
var village_y       = <?php echo ((50-$rec["y_coord"])*7)."\n"; ?>
var owner           = '<?php echo $_SESSION["login"]; ?>';
var przesuniecie_x  = village_x;
var przesuniecie_y  = village_y;
var siatka          = 1;
var lines           = new Array(10, 20, 20, 50, 100, 100); 
var dymek_left      = new Array(30, 25, 20, 14, 0, -32);
var mousewheele     = (/Firefox/i.test(navigator.userAgent))? "DOMMouseScroll" : "mousewheel";       
var json_obj;
var interval;  
 
/**********/

var img_load        = 0;
var img             = new Image();
var img2            = new Image();
var img3            = new Image();
img.src             = 'img/akademikupgraded.png';
img2.src            = 'img/blackwhite.png';
img3.src            = 'img/akademikowner.jpg';
img.onload          = function() {++img_load;}
img2.onload         = function() {++img_load;}
img3.onload         = function() {++img_load;}

canvas.addEventListener('mousemove', mousemove, false);
canvas.addEventListener('mousedown', mousedown, false);
canvas.addEventListener('mouseup', mouseup, false);  
canvas.addEventListener(mousewheele, scrolling, false);

function scrolling(e) {
    var evt = window.event || e; 
    var delta = evt.detail? evt.detail*(-120) : evt.wheelDelta;
    if(delta > 0) zoom('in');
    else zoom('out');
}

function moja_wiocha() {
    vector_x = vector_y = 0;
    przesuniecie_x = village_x;
    przesuniecie_y = village_y;
    
    init();
}

function colision() {   
    var s = Math.pow(2, skala);
     
    for(var i = 0; i < json_obj.wiocha.length; i++) {
        var current_village_x = json_obj.wiocha[i].x/100 * w * s + (przesuniecie_x + vector_x)*s - (w/2)*(s-1);
        var current_village_y = json_obj.wiocha[i].y/100 * h * s + (przesuniecie_y + vector_y)*s - (h/2)*(s-1);
        
        if(x > current_village_x - s*4/2 && x < current_village_x + s*4/2 && y > current_village_y - s*4/2 && y < current_village_y + s*4/2) 
            return ++i;
    } 
    
    return false;   
}

function mousemove(ev) {                       
    if(ev.layerX || ev.layerX == 0) { 
        x = ev.layerX;
        y = ev.layerY;
    } else if(ev.offsetX || ev.offsetX == 0) { 
        x = ev.offsetX;
        y = ev.offsetY;
    } 
     
    if(mousewheele == 'DOMMouseScroll') {    
        x -= canvas.offsetLeft;
        y -= canvas.offsetTop;
    }
    
    if(x < 0) x = 0;
    if(y < 0) y = 0;  
}

function mousedown() {                                        
    pos_x = x;
    pos_y = y;
    canvas.style.cursor = 'grabbing';                                 
    clearInterval(interval);
    interval = setInterval('move_map()', 30);  
    document.getElementById('div').style.display = 'none';       
}

function mouseup() {
    canvas.style.cursor = 'grab';
    clearInterval(interval);
    przesuniecie_x += vector_x;
    przesuniecie_y += vector_y; 
    check_position();       
}

function move_map() {
    var s = Math.pow(2, skala);
    vector_x = (pos_x - x) / -s;
    vector_y = (pos_y - y) / -s;
    init();   
}

function zoom(id) {
    switch(id) {
        case 'in':
            if(skala < 5) ++skala;
        break;
        case 'out':
            if(skala > 0) --skala;
        break;
    }  
                
    vector_x = 0;
    vector_y = 0;  
    document.getElementById('div').style.display = 'none';
    init();      
}

function wysylka(i) {
    document.forms['send_item'].X.value = json_obj.wiocha[i].x;
    document.forms['send_item'].Y.value = json_obj.wiocha[i].y;  
    document.forms['send_item'].send_ok.click();
}

function check_position() {
    var current_village_x, current_village_y;
    var s = Math.pow(2, skala);
    var i;
    
    if(i = colision()) { 
        --i; 
        var div = document.getElementById('div'); 
        div.innerHTML = '<input type="hidden" name="X" value="'+json_obj.wiocha[i].x+'" />'+
        '<input type="hidden" name="Y" value="'+json_obj.wiocha[i].y+'" />'+                
        '<br />Wiocha: <b>' + json_obj.wiocha[i].name + '(' + json_obj.wiocha[i].x + '|' + json_obj.wiocha[i].y + ')</b><br />Właściciel: <b>' + json_obj.wiocha[i].owner + '</b><br />'+
        '<input type="hidden" name="strike" value="1" />'+
        '<input type="submit" name="attack_ok" value="Atak" />'+
        '<input type="submit" name="help_ok" onClick="javascript:document.forms[\'attacks\'].strike.name=\'help\'" value="Wsparcie" />'+
        '<input type="submit" name="spying_ok" onClick="javascript:document.forms[\'attacks\'].strike.name=\'spying\'" value="Szpieguj" />'+
        '<input type="button" name="send_items" onClick="javascript:wysylka('+i+')" value="Wyślij surowce" />';   
        div.style.display = 'block';
        div.style.top = json_obj.wiocha[i].y/100 * h * s + (przesuniecie_y + vector_y)*s - (h/2)*(s-1) + canvas.offsetTop - 105;
        div.style.left = json_obj.wiocha[i].x/100 * w * s + (przesuniecie_x + vector_x)*s - (w/2)*(s-1) + canvas.offsetLeft - dymek_left[skala];
        
    }      
}

if(canvas.getContext('2d')) {
    var c = canvas.getContext('2d');
    var w = canvas.width;
    var h = canvas.height;        

    var client = new XMLHttpRequest();
    client.open('POST', 'script/json_wiochy.php', true);
    client.send(null);
    client.onreadystatechange = function() {
        if(200 === this.status && 4 === this.readyState) {
            var json = this.responseText;
            eval('json_obj = ('+json+')');                               
        }
    }        
    
    function rysuj_mape() { 
        if(!json_obj || img_load != 3)
            setTimeout('rysuj_mape()', 50);
         
        var s = Math.pow(2, skala); 
        var current_img;                          
                        
        for(var i = 0; i < json_obj.wiocha.length; i++) {
            if(json_obj.wiocha[i].owner == 'WORLD')
                current_img = img2;
            else if(json_obj.wiocha[i].owner == owner)
                current_img = img3;
            else
                current_img = img;
        
            c.beginPath();
            c.drawImage(current_img, json_obj.wiocha[i].x/100 * w * s + (przesuniecie_x + vector_x)*s - (w/2)*(s-1) - s*4/2, json_obj.wiocha[i].y/100 * h * s + (przesuniecie_y + vector_y)*s - (h/2)*(s-1) - s*4/2, s*4, s*4);
            c.closePath();
            c.fill();
        }
    }
    
    function rysuj_osie() {
        var s = Math.pow(2, skala);
        var line_count = lines[skala];         
        c.clearRect(0, 0, w, h);      
        c.strokeStyle = 'red'; 
        c.lineWidth = 1;                                                  
        c.font = '8pt Georgia'; 
        
        c.beginPath();
        c.moveTo(w-5, 5);
        c.lineTo(5, 5);
        c.lineTo(5, h-5);                                    
        c.stroke();
        c.closePath();    
        
        c.beginPath();
        c.fillStyle = 'red';        
        c.lineTo(10, h-5);
        c.lineTo(5, h);
        c.lineTo(0, h-5);
        c.lineTo(5, h-5);
        c.fillText('y', 10, h-7);
        c.fill();
        c.closePath();                                        

        c.beginPath();
        c.moveTo(w-5, 0);        
        c.lineTo(w, 5);
        c.lineTo(w-5, 10);
        c.lineTo(w-5, 0);        
        c.fillText('x', w-14, 14);
        c.fill();
        c.closePath();  
                        
        c.strokeStyle = 'gray'; 
        c.lineWidth = 0.5;
        
        for(var i = 1; i <= line_count; i++) {
            c.fillText(100/line_count*i, w/line_count*(i*s) + (przesuniecie_x + vector_x)*s - (w/2)*(s-1), 16);
            c.fillText(100/line_count*i, 10, h/line_count*(i*s) + (przesuniecie_y + vector_y)*s - (h/2)*(s-1)); 
            
            c.moveTo(w/line_count*(i*s) + (przesuniecie_x + vector_x)*s - (w/2)*(s-1), h-5);
            c.lineTo(w/line_count*(i*s) + (przesuniecie_x + vector_x)*s - (w/2)*(s-1), 5); 
            c.moveTo(w-5, h/line_count*(i*s) + (przesuniecie_y + vector_y)*s - (h/2)*(s-1));
            c.lineTo(5, h/line_count*(i*s) + (przesuniecie_y + vector_y)*s - (h/2)*(s-1));         
        }
        
        c.stroke();
        c.closePath();
    }
    
    function init() {
        rysuj_osie();
        rysuj_mape();     
    }
    
    window.onload = init();    
} else {alert('Zaopatrz sie w nowsza przegladarke...');}
</script>