var xmlhttp;
function xmlhttprequest(){
  if(window.ActiveXObject){//�����IE�����
	  xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');//ʵ��������
   }else if(window.XMLHttpRequest){//����Ƿ�IE�����
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
  	alert("��¼�ʺų��ȷ�Χ��2��10�ַ�����˲�");  	
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