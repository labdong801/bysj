<?php
session_start();
header('Content-type: text/html;charset=GB2312');
?>
<?php
include("../connect_db.php");
include("../global_fun.php");
$teacher_id = $_SESSION["com_id"];
$com_online = $_SESSION["com_online"];
if(!$com_online||!$teacher_id||$com_type!="teacher"){
	mysql_close($link);
	echo "�����µ�¼";
	exit;
}

$newalias = $_GET["id"];

$ssql = "select teacher_id,teacher_alias from ".$TABLE."teacher_information where teacher_id!='$teacher_id'&&(teacher_id='$newalias'||teacher_alias='$newalias')";
$qsql = mysql_query($ssql);
if($qsql) $currrows=mysql_num_rows($qsql);  
if($currrows>0){
	 echo "<font color=red>$newalias �ѱ�ʹ��</font>";
	 exit;
}

$sql = "update ".$TABLE."teacher_information set teacher_alias = '$newalias' where teacher_id = '$teacher_id'";
//echo $sql;
mysql_query($sql);
if(mysql_affected_rows()>0) {
	echo "<font color=blue><b>�� �ʺ����޸�</b></font>";
} else {
	echo "<font color=red>δ�ı�</font>";
}

mysql_close($link);
?>
