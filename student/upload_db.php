<?php
session_start();
header('Content-type: text/html;charset=GB2312');
include("../connect_db.php");
$number = $_SESSION["com_id"];
$com_online = $_SESSION["com_online"];
if(!$com_online||!$number){
	mysql_close($link);
	echo "请重新登录";
	exit;
}
$topicid = $_GET["topicid"];
$wish = $_GET["wish"];
$check = mysql_query("select topic_num from ".$TABLE."student_select where number = '$number' && wish ='$wish'");
$oldwish = mysql_fetch_array($check);
$cnt = 0;
if($oldwish) {
	$old_topic_id = $oldwish["topic_num"];
	$sql = "update ".$TABLE."student_select set topic_num = $topicid where wish = $wish && number = $number";
}else{
	$old_topic_id = 0;
	$sql = "insert into ".$TABLE."student_select(number,topic_num,wish,pro_id) values ('$number','$topicid','$wish','$com_pro_id')";
}
mysql_query($sql);
if(mysql_affected_rows()>0) {
	$cnt = 1;
} else {
	$cnt = 0;
	$topicid = $old_topic_id;
}
$sql = "select name,topic from ".$TABLE."topic ,".$TABLE."teacher_information  where id = '$topicid' && ".$TABLE."topic .teacher_id = ".$TABLE."teacher_information.teacher_id";
$que_sql = mysql_query($sql);
$nowresult = mysql_fetch_array($que_sql);
if($old_topic_id) $str = "修改";
else $str = "新增";
if($cnt) $str .= "成功";
else $str .= "失败";
echo "<input  type=text size=40 value='【".$str."】".$nowresult["topic"]."--".$nowresult["name"]."' onMouseDown='noinput()'> ";

mysql_close($link);
?>
