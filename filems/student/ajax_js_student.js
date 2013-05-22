var xmlhttp;
function xmlhttprequest(){
  if(window.ActiveXObject){//如果是IE浏览器
	  xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');//实例化对象
   }else if(window.XMLHttpRequest){//如果是非IE浏览器
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
