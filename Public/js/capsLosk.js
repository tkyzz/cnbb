(function(){ 
var inputPWD = document.getElementById('register_password'); 
var capital = false; 
var capitalTip = { 
elem:document.getElementById('register_password'), 
toggle:function(s){ 
// var sy = this.elem.style; 
// var d = sy.display; 
if(s){ 
 layer.tips('大小写锁定已开启', '#register_password');
}else{ 
layer.closeAll();
} 
} 
} 
var detectCapsLock = function(event){ 
if(capital){return}; 
var e = event||window.event; 
var keyCode = e.keyCode||e.which; // 按键的keyCode 
var isShift = e.shiftKey ||(keyCode == 16 ) || false ; // shift键是否按住 
if ( 
((keyCode >= 65 && keyCode <= 90 ) && !isShift) // Caps Lock 打开，且没有按住shift键 
|| ((keyCode >= 97 && keyCode <= 122 ) && isShift)// Caps Lock 打开，且按住shift键 
){capitalTip.toggle('block');capital=true} 
else{capitalTip.toggle('none');} 
} 
inputPWD.onkeypress = detectCapsLock; 
inputPWD.onkeyup=function(event){ 
var e = event||window.event; 
if(e.keyCode == 20 && capital){ 
capitalTip.toggle(); 
return false; 
} 
} 
})() 
