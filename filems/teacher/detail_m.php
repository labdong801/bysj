<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�������������</title>
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
$mission_id = $_GET["mission_id"];
function dispEnter($content){
   $content = str_replace("\n","<br>",$content);
   return $content;
 }
$ka = mysql_query("select ".$TABLE."mission_list.name as mlname,".$TABLE."mission_list.demonstration,".$TABLE."mission_list.print_time,".$TABLE."mission_list.paper_type,".$TABLE."mission_list.paper_num,".$TABLE."mission_log.last_uploadtime,".$TABLE."mission_log.upload_times,".$TABLE."mission_log.check_suggestion,".$TABLE."mission_log.lock_flag,".$TABLE."mission_log.is_check from ".$TABLE."mission_list,".$TABLE."mission_log where ".$TABLE."mission_list.mission_id = ".$TABLE."mission_log.mission_id && ".$TABLE."mission_log.id = '$mission_id'");
$ak = mysql_fetch_array($ka);
?>
<table width="780" align="center" border="1">
<tr>
<td>����</td>
<td><?php echo $ak["mlname"];?></td>
</tr>
<tr>
<td>����˵����</td>
<td><?php echo dispEnter($ak["demonstration"])." ";?></td>
</tr>
<tr>
<td>��ӡʱ�䣺</td>
<td><?php echo $ak["print_time"];?></td>
</tr>
<tr>
<td>ֽ�ͣ�</td>
<td><?php echo $ak["paper_type"];?></td>
</tr>
<tr>
<td>������</td>
<td><?php echo $ak["paper_num"];?></td>
</tr>
<tr>
<td>�����ϴ�ʱ�䣺</td>
<td><?php echo $ak["last_uploadtime"];?></td>
</tr>
<tr>
<td>�ϴ�������</td>
<td><?php echo $ak["upload_times"];?></td>
</tr>
</table>
<form name="myform" action="" method="post">
<table width="780" align="center" border="1">
<tr>
<td>�������</td>
<td>
<?php
 if($ak["is_check"]==-1){
?>
<input type="radio" name="check" value="-1" checked="checked"/><font color="#FF0000">����Ҫ�󣬲��蹫��</font>&nbsp;&nbsp;<input type="radio" name="check" value="0" /><font color="#00FF00">�Ⱥ������</font>&nbsp;&nbsp;<input type="radio" name="check" value="1" />���ͨ����������ѡ��
<?php
}elseif($ak["is_check"]==0){
?>
<input type="radio" name="check" value="-1" /><font color="#FF0000">����Ҫ�󣬲��蹫��</font>&nbsp;&nbsp;<input type="radio" name="check" value="0" checked="checked"/><font color="#00FF00">�Ⱥ������</font>&nbsp;&nbsp;<input type="radio" name="check" value="1" />���ͨ����������ѡ��
<?php
}else{
?>
<input type="radio" name="check" value="-1" /><font color="#FF0000">����Ҫ�󣬲��蹫��</font>&nbsp;&nbsp;<input type="radio" name="check" value="0"/><font color="#00FF00">�Ⱥ������</font>&nbsp;&nbsp;<input type="radio" name="check" value="1" checked="checked"/>���ͨ����������ѡ��
<?php
}
?>
</td>
</tr>
<tr>
<td>��������</td>
<td>
<?php
 if($ak["lock_flag"]==0){
?>
<input type="radio" name="lock" value="0" checked="checked"/>δ����&nbsp;&nbsp;
<input type="radio" name="lock" value="1"/><font color="#FF0000">����</font>
<?php
}else{
?>
<input type="radio" name="lock" value="0"/>δ����&nbsp;&nbsp;
<input type="radio" name="lock" value="1" checked="checked"/><font color="#FF0000">����</font>
<?php
}
?>	
</td>
</tr>
<tr>
<td>������</td>
<td><textarea name="check_suggestion" cols="60" rows="8"  wrap="virtual"><?php echo $ak["check_suggestion"];?></textarea></td>
</tr>
<tr>
<td colspan="2"><input type="submit" name="submit" value="ȷ�������ѡ��" /></td>
</tr>
</table>
</form>
<table width="780" align="center">
<tr>
<td>˵����<br />
<li>ֻ��ͨ����˵����񣬽�ʦ��ѧ���������ضԷ��ϴ����ĵ���</li>
<li>��������󣬽�ʦ��ѧ�����������ϴ��������ĵ���</li>
</td>
</tr>
</table>
</td>
</tr>
</table>
<?php
if($_POST["submit"]){
$is_check = $_POST["check"];
$check_suggestion = $_POST["check_suggestion"];
$lock = $_POST["lock"];
$al = mysql_query("update ".$TABLE."mission_log set is_check = '$is_check',check_suggestion = '$check_suggestion',lock_flag = '$lock' where id = '$mission_id'");
 if($al){
   echo "<script>alert('�����ύ�ɹ���');history.back();</script>";
 }else{
   echo "<script>alert('�����ύʧ�ܣ�');history.back();</script>";
 } 
}
?>
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