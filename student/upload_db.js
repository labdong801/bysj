var xmlhttp;
function xmlhttprequest(){
  if(window.ActiveXObject){//�����IE�����
	  xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');//ʵ��������
   }else if(window.XMLHttpRequest){//����Ƿ�IE�����
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