<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�鿴������</title>
<style>
.align_top{vertical-align:top}
</style>
<link rel="stylesheet" type="text/css" href="../xeasy.css">
</head>

<body>
<?php
include("../head.html");
?>
<?php
include("../connect_db.php");
$teacher_id = $_SESSION["teacher_id"];
$aaa = mysql_query("select name,authority from ".$TABLE."teacher_information where teacher_id = '$teacher_id'");
$bbb = mysql_fetch_array($aaa);
if($bbb["name"]){
?>
<table width="960" align="center">
<tr class="align_top">
<td align="center">
<?php
include("navigation.php");
?>
</td>
<td>
<?php
function dispEnter($content){
   $content = str_replace("\n","<br>",$content);
   return $content;
 }
$mission_id = $_GET["mission_id"];
$suggestion = mysql_query("select check_suggestion from ".$TABLE."mission_log where id = $mission_id");
$arr = mysql_fetch_array($suggestion);
?>
<table width="700" align="center">
<tr>
<td align="center">����������</td>
</tr>
<tr>
<td align="center">
<?php 
if($arr["check_suggestion"]!=""){
 echo dispEnter($arr["check_suggestion"]);
}else{
 echo "<br><br><font color = 'red'>�����ڴ��ǰ�����ĵ������ܱ䶯���������ն���֮ǰ���ĵ������ָ����ʦ�Լ��ϸ�ѹء�<br><br>ϵ�Ҳ�������ˣ�����ָ����ʦ����ʵ�������Ը�ԭ��</font>"; 
}
?>
</td>
</tr>
</table>
</td>
</tr>
</table>
<?php
}else{
echo "<script>alert('���ȵ�¼��');history.back();</script>";
}
?>
<?php
include("../tail.html");
mysql_close($link);
?>
</body>
</html>
