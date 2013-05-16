<?php
session_start();
header('Content-type: text/html;charset=GB2312');
include("../../connect_db.php");
include("../../global_fun.php");
$number = $_SESSION["com_id"];
$com_online = $_SESSION["com_online"];
if(!$com_online||!$number){
	mysql_close($link);
	echo "请重新登录";
	exit;
}
$id = $_GET["id"];
$value = $_GET["value"];
$now = time(0);
switch($act){
	case "needmoretime":
		$res = set_value($TABLE."student_sheet","tmptime",999,"number='$id'");		
		if($res) echo "已提交申请，等指导教师审核！";
		else echo "申请失败，请联系管理员！";
		break;
	case "lunwensongshen":
		$res = set_value($TABLE."ok_topic","spmissionid",$value,"student_id='$id'");		
		if($res) echo "论文已提交送评，若有更新，请在论文正式评阅前更新到初稿中！";
		else echo "申请失败，请联系管理员！";
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
