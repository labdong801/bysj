var xmlhttp;
function xmlhttprequest(){
  if(window.ActiveXObject){//如果是IE浏览器
	  xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');//实例化对象
   }else if(window.XMLHttpRequest){//如果是非IE浏览器
	  xmlhttp = new XMLHttpRequest();   
   }
}

function upload(objID,value,wish){
  xmlhttprequest();
  var url = "upload_db.php?topicid="+value+"&wish="+wish;
  xmlhttp.open('GET',url,true);
  xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readystate == 4 && xmlhttp.status == 200) {
	  document.getElementById(objID).innerHTML = xmlhttp.responseText;	
	} 
  }
  xmlhttp.send(null);
}