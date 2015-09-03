var internetExplorer = document.all ? true : false;
var mouseX    = 0;
var mouseY    = 0;
var positionX = 0;
var positionY = 0;
var move      = false;
var documentHeigh;
var documentWidth;
var windowPositionX;
var windowPositionY;
var windowName;
var tmp_title;

if(!internetExplorer) document.captureEvents(Event.MOUSEMOVE);
document.onmousemove = MousePosition;

function MousePosition(j) { 
  if(internetExplorer) {
    mouseX = event.clientX + document.body.scrollLeft;
    mouseY = event.clientY + document.body.scrollTop; 
  } else {
    mouseX = j.pageX;
    mouseY = j.pageY;
  }
  if(move) {
    $(windowName).css({'top':windowPositionY + (mouseY - positionY)});
    $(windowName).css({'left':windowPositionX + (mouseX - positionX)});
  }
}
function Window_(id, height_, title_, status_) { 
  width_          = 350;
  if(status_ == 'on') tmp_title = title_;
  $('.move').text(title_);
  documentHeight  = $(document).height();
  documentWidth   = $(document).width();
  $('#window_iframe').css({height:height_-50});
  if(status_ != 'off') {$(id).css({height:height_});}
  if(status_ != 'off') {$(id).css({width:width_});}
  windowPositionX = (documentWidth / 2) - ($(id).width() / 2);
  windowPositionY = (documentHeight / 2) - ($(id).height() / 2);

  if(status_ == 'on') {
    $(id).css({top:windowPositionY});
    $(id).css({left:windowPositionX});
    $(id).fadeIn();
  }
  if(status_ == 'off') {
    $(id).fadeOut();
    //setTimeout('document.getElementById(\'window_iframe\').src = \'script/loading/\'', 500);
    if(tmp_title == 'Wiadomości')
      document.location.href = document.location.href;
  }
}
function Move(id) {
  move        = true;
  positionX   = mouseX;
  positionY   = mouseY;
  windowName  = id;
}
function StopMove() {
  move = false;
  windowPositionY += (mouseY - positionY);
  windowPositionX += (mouseX - positionX);;  
}