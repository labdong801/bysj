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
	echo "�����µ�¼";
	echo "</body></html>";
	exit;
}
$id = $_GET["id"];
if($type=="student"){
	$sql = "update ".$TABLE."student_sheet set authority = (authority mod 2)+1 where number = '$id'";
} else {
	$sql = "";  //���޽�ʦ����ģ��
}
mysql_query($sql);
if(mysql_affected_rows()>0) {
	$kk = @mysql_fetch_array(@mysql_query("select authority from ".$TABLE."student_sheet where number = '$id'"));
	$bgstr = array(0=>"[<font color=red><b>ͣȨ</b></font>]",1=>"&nbsp;",2=>"[<font color=blue><b>���</b></font>]");	
	echo $bgstr[$kk["authority"]];
} else {
	echo "<font color=red>����ʧ��</font>";
}

mysql_close($link);
?>
