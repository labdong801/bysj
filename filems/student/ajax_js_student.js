var xmlhttp;
function xmlhttprequest(){
  if(window.ActiveXObject){//�����IE�����
	  xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');//ʵ��������
   }else if(window.XMLHttpRequest){//����Ƿ�IE�����
	  xmlhttp = new XMLHttpRequest();   
   }
}

function needmoretime(objID,id){
  xmlhttprequest();
  var url = "ajax_student.php?id="+id+"&act=needmoretime&time="+Date();
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  document.getElementById(objID).innerHTML = xmlhttp.responseText;	
	} 
  }
  xmlhttp.send(null);
}

function lunwensongshen(objID,id,lwid){
  xmlhttprequest();
  var url = "ajax_student.php?id="+id+"&act=lunwensongshen&value="+lwid+"&time="+Date();
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  document.getElementById(objID).innerHTML = xmlhttp.responseText;	
	} 
  }
  xmlhttp.send(null);
}
