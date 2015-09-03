function CheckAll(list, checkboxStatus) {
  if(checkboxStatus) {
    for(var i = 0;i <= list.length;i++) {
      if(list[i].type == 'checkbox' && list[i].name != 'CUAll') {
        list[i].checked                                                         = true;
        //document.getElementById('TR'+list[i].id).style.backgroundColor          = '#FFFF66';
      }
    }
  } else {
    for(var i = 0;i <= list.length;i++) {
      if(list[i].type == 'checkbox' && list[i].name != 'CUAll') {
        list[i].checked                                                         = false;
        //document.getElementById('TR'+list[i].id).style.backgroundColor          = '#909090';
      }
    }
  }                               
} 

function Check(checkbox) {
  if(document.getElementById(checkbox).checked) {
    document.getElementById(checkbox).checked                                   = false;  
    //document.getElementById('TR'+checkbox).style.backgroundColor                = '#909090';
  } else {
    document.getElementById(checkbox).checked                                   = true;
    //document.getElementById('TR'+checkbox).style.backgroundColor                = '#FFFF66';
  }
}

function Check2(checkbox) {
  if(document.getElementById(checkbox).checked) {
    document.getElementById(checkbox).checked                                   = true;
    //document.getElementById('TR'+checkbox).style.backgroundColor                = '#FFFF66'; 
  } else {
    document.getElementById(checkbox).checked                                   = false;
    //document.getElementById('TR'+checkbox).style.backgroundColor                = '#909090';
  }
}