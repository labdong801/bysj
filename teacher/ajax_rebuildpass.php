<?php
session_start();
header('Content-type: text/html;charset=GB2312');
?>
<?php
include("../connect_db.php");
include("../global_fun.php");
$teacher_id = $_SESSION["com_id"];
$com_online = $_SESSION["com_online"];
if(!$com_online||!$teacher_id){
	mysql_close($link);
	echo "请重新登录";
	echo "</body></html>";
	exit;
}
$id = $_GET["id"];
if($type=="student"){
	$newpass = $id;
	$sql = "update ".$TABLE."student_sheet set password = '$newpass' where number = '$id'";
} else {
	$newpass = makepassword();
	$sql = "update ".$TABLE."teacher_information set password = '$newpass' where teacher_id = '$id'";
}
//echo $sql;
mysql_query($sql);
if(mysql_affected_rows()>0) {
	echo "<font color=blue><b>$newpass</b></font>";
} else {
	echo "<font color=red>未改变</font>";
}

mysql_close($link);
?>
