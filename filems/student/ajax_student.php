<?php
session_start();
header('Content-type: text/html;charset=GB2312');
include("../../connect_db.php");
include("../../global_fun.php");
$number = $_SESSION["com_id"];
$com_online = $_SESSION["com_online"];
if(!$com_online||!$number){
	mysql_close($link);
	echo "�����µ�¼";
	exit;
}
$id = $_GET["id"];
$value = $_GET["value"];
$now = time(0);
switch($act){
	case "needmoretime":
		$res = set_value($TABLE."student_sheet","tmptime",999,"number='$id'");		
		if($res) echo "���ύ���룬��ָ����ʦ��ˣ�";
		else echo "����ʧ�ܣ�����ϵ����Ա��";
		break;
	case "lunwensongshen":
		$res = set_value($TABLE."ok_topic","spmissionid",$value,"student_id='$id'");		
		if($res) echo "�������ύ���������и��£�����������ʽ����ǰ���µ������У�";
		else echo "����ʧ�ܣ�����ϵ����Ա��";
		break;
	case "msg":
		break;
}
mysql_close($link);

function set_value($wbiao,$wzd,$wzhi,$wtj){
	$sql = "update ".$wbiao." set ".$wzd." ='".$wzhi."' where ".$wtj;
	$que = mysql_query($sql);
	$sql = "select ".$wzd." from ".$wbiao." where ".$wtj;
	$que = mysql_query($sql);
	$res = mysql_fetch_array($que);
	return $res[0]==$wzhi;
}
?>
