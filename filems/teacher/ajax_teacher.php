<?php
session_start();
header('Content-type: text/html;charset=GB2312');
include("../../connect_db.php");
include("../../global_fun.php");
$teacher_id = $_SESSION["com_id"];
$com_online = $_SESSION["com_online"];
if(!$com_online||!$teacher_id){
	mysql_close($link);
	echo "请重新登录";
	exit;
}
$id = $_GET["id"];
$value = $_GET["value"];
$now = time(0);
switch($act){
	case "makemoretime":
		$newtime = (ceil($now/86400)+2)*86400+86399;
		if($value=="teacher") {   //value 为帐号类型
			$res = set_value($TABLE."teacher_information","tmptime",$newtime,"teacher_id='$id'");
			if($res) echo "申请临时上传权限成功！<a href=# onclick=history.go(0)><font color=blue><u><b>点击此处上传电子文档</b></u></font></a>";
			else echo "申请临时上传权限失败，请联系专业主任解决问题！";
		} else  {
			$res = set_value($TABLE."student_sheet","tmptime",$newtime,"number='$id'");
			if($res) echo "为学生开启临时上传权限成功，3天有效！";
			else echo "开启临时上传权限失败，请联系专业主任！";
		}
		break;
	case "changeauth":
		$res = set_value($TABLE."teacher_information","authority",$value,"teacher_id='$id'");
		if($res) {
			if($value>20)echo "&nbsp;<font color=red><b>★</b></font>";
			else if($value==20) echo "&nbsp;<font color=green><b>☆</b></font>";
			else echo "&nbsp;<font color=red><b>-</b></font>";
		} else echo "&nbsp;<font color=red><b>×</b></font>";
		break;
	case "changefenzu":
		$res = set_value($TABLE."teacher_information","fenzu",$value,"teacher_id='$id'");
		if($res) {
			echo "<font color=red><b>新分".$value[4]."组</b></font>";
		} else echo "&nbsp;<font color=red><b>×</b></font>";
		break;
	case "changefenzu2":
		$res = set_value($TABLE."ok_topic","fenzu",$value,"student_id='$id'");
		if($res) {
			echo "<font color=red><b>新分".$value[4]."组</b></font>";
		} else echo "&nbsp;<font color=red><b>×</b></font>";
		break;
	case "changepingyue":
		$res = set_value($TABLE."ok_topic","teacher2_id",$value,"student_id='$id'");
		if($res) {
			echo "<font color=blue><b>√</b></font>";
		} else echo "&nbsp;<font color=red><b>×</b></font>";
		break;
	case "get_comment":
		$res = get_value($TABLE."ok_topic",$value,"id='$id'");
		echo $res;
		break;
	case "get_comment2":
	    $value = str_replace("\'","",$value);
		$res = get_value2($TABLE."ok_topic",$value,"id='$id'");
		echo $res;
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

function get_value($wbiao,$wzd,$wtj){
	$sql = "select ".$wzd." from ".$wbiao." where ".$wtj;
	$que = mysql_query($sql);
	$res = mysql_fetch_array($que);
	return $res[$wzd];
}

function get_value2($wbiao,$wzd,$wtj){
	$sql = "select ".$wzd." from ".$wbiao." where ".$wtj;
	$que = mysql_query($sql);
	$res = mysql_fetch_array($que);
	$plist = explode(",", $wzd);  
	$str = "";
	while(list($k,$v)=each($plist)){
		if($str != "") $str .= "|||";
		$str .= $res[$v];
	}
	return $str;
}
?>
