var xmlhttp;
function xmlhttprequest(){
  if(window.ActiveXObject){//如果是IE浏览器
	  xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');//实例化对象
   }else if(window.XMLHttpRequest){//如果是非IE浏览器
	  xmlhttp = new XMLHttpRequest();   
   }
}

function change_item(objID,id,act){
  xmlhttprequest();
  var url = "ajax_mission.php?id="+id+"&act=change"+act+"&time="+Date();
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  document.getElementById(objID).innerHTML = xmlhttp.responseText;	
	} 
  }
  xmlhttp.send(null);
}

function change_item_date(objID,id,act,value){
  xmlhttprequest();
  var url = "ajax_mission.php?id="+id+"&act=change"+act+"&value="+value+"&time="+Date();
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  	document.getElementById(objID).value = xmlhttp.responseText;
	} 
  }
  xmlhttp.send(null);
}

function makemoretime(objID,id,value){
  xmlhttprequest();
  var url = "ajax_teacher.php?id="+id+"&act=makemoretime&value="+value+"&time="+Date();
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  document.getElementById(objID).innerHTML = xmlhttp.responseText;	
	} 
  }
  xmlhttp.send(null);
}

function verify_record(objID,id,msg,record){  //暂未用
  xmlhttprequest();
  var value=prompt(msg,record);
  if(!value)return ;
  var url = "ajax_report.php?id="+id+"&value="+value+"&act=record";
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

function change_fenzu(objID,id,v){
  xmlhttprequest();
  var url = "ajax_teacher.php?id="+id+"&act=changefenzu&value="+v+"&time="+Date();
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  document.getElementById(objID).innerHTML = xmlhttp.responseText;	
	} 
  }
  xmlhttp.send(null);
}

function change_fenzu2(objID,id,v){
  xmlhttprequest();
  var url = "ajax_teacher.php?id="+id+"&act=changefenzu2&value="+v+"&time="+Date();
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  document.getElementById(objID).innerHTML = xmlhttp.responseText;	
	} 
  }
  xmlhttp.send(null);
}

function change_pingyue(objID,id,v){
  xmlhttprequest();
  var url = "ajax_teacher.php?id="+id+"&act=changepingyue&value="+v+"&time="+Date();
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  document.getElementById(objID).innerHTML = xmlhttp.responseText;	
	} 
  }
  xmlhttp.send(null);
}

function old_comment(objID,v,id){
  xmlhttprequest();
  var url = "ajax_teacher.php?id="+id+"&act=get_comment&value="+v+"&time="+Date();
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  document.getElementById(objID).value = xmlhttp.responseText;	
	} 
  }
  xmlhttp.send(null);
}

function old_comment2(objID,objID2,v,id){
  xmlhttprequest();
  var url = "ajax_teacher.php?id="+id+"&act=get_comment2&value='"+v+"'&time="+Date();
  //alert(url);
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
		  var a = xmlhttp.responseText;
          var b = a.split("|||"); 
	  document.getElementById(objID).value = b[0];	
	  document.getElementById(objID2).value = b[1];	
	} 
  }
  xmlhttp.send(null);
}