var xmlhttp;
function xmlhttprequest(){
  if(window.ActiveXObject){//如果是IE浏览器
	  xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');//实例化对象
   }else if(window.XMLHttpRequest){//如果是非IE浏览器
	  xmlhttp = new XMLHttpRequest();   
   }
}

function student_auth(objID,value,tt){
  xmlhttprequest();
  var url = "ajax_student_auth.php?id="+value+"&type="+tt;
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  document.getElementById(objID).innerHTML = xmlhttp.responseText;	
	} 
  }
  xmlhttp.send(null);
}

function change_auth(objID,id,v){
  xmlhttprequest();
  var url = "ajax_teacher.php?id="+id+"&act=changeauth&value="+v+"&time="+Date();
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  document.getElementById(objID).innerHTML = xmlhttp.responseText;	
	} 
  }
  xmlhttp.send(null);
}

function rebuildpass(objID,value,tt){
  xmlhttprequest();
  var url = "ajax_rebuildpass.php?id="+value+"&type="+tt;
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  document.getElementById(objID).innerHTML = xmlhttp.responseText;	
	} 
  }
  xmlhttp.send(null);
}

function changealias(objID,value){
  xmlhttprequest();
  if(value.length<2||value.length>10){
  	alert("登录帐号长度范围：2～10字符，请核查");  	
  	return;
  }
  var url = "teacher/ajax_changealias.php?id="+value+"&time="+Date();
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  document.getElementById(objID).innerHTML = xmlhttp.responseText;	
	} 
  }
  xmlhttp.send(null);
}