<?php
session_start();
header('Content-type: text/html;charset=GB2312');
include("../../connect_db.php");
include("../../global_fun.php");
$teacher_id = $_SESSION["com_id"];
$com_online = $_SESSION["com_online"];
if(!$com_online||!$teacher_id){
	mysql_close($link);
	echo "�����µ�¼";
	echo "</body></html>";
	exit;
}
$id = $_GET["id"];
$value = $_GET["value"];
switch($act){
  case "changeuploader":
	$cn = set_value($id,"uploader","",2);
	$str = array("ѧ��","ָ����ʦ");
	echo $str[$cn];
	break;
  case "changeneeddoc":
	$cn = set_value($id,"needdoc","",2);
	$str = array("��ͨ","<font color=blue>����</font>");
	echo $str[$cn];
	break;
  case "changelockit":
	$cn = set_value($id,"lockit","",3);
	$str = array("����","<font color=blue>����</font>","<font color=red>ͣ��</font>");
	echo $str[$cn];
	break;
  case "changestart_time":
	$cn = set_value($id,"start_time",$value);
	echo date("Y-m-d",$cn);
	break;
  case "changeend_time":
	$cn = set_value($id,"end_time",$value);
	echo date("Y-m-d",$cn);
	break;
  case "changeprint_time":
	$cn = set_value($id,"print_time",$value);
	echo date("Y-m-d",$cn);
	break;
  case "msg":
	break;
}
mysql_close($link);

function set_value($id,$item,$value,$max=0){
	global $TABLE;
	if($max<1) {
		$sql = "update ".$TABLE."mission_list set ".$item." = '".$value."' where mission_id = '$id'";
	} else {
		$sql = "update ".$TABLE."mission_list set ".$item." = (".$item."+1) mod ".$max." where mission_id = '$id'";
	}
	$que = mysql_query($sql);
	$sql = "select ".$item." from ".$TABLE."mission_list where mission_id='$id'";
	$que = mysql_query($sql);
	$res = mysql_fetch_array($que);
	return $res[0];
}
?>
