<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<style>
.align_top{vertical-align:top}
.STYLE1 {
	font-family: "�����п�";
	font-size: x-large;
}
</style>
<script language="javascript">
function is_empty(){
 if(form1.answer.value==""){
   alert("�ύ������ͽ��鲻��Ϊ�գ�");
   return false;
 }
}
</script>
<title>�ظ�����</title>
</head>

<body>
<?php
include("../head.html");
?>
<?php
include("../connect_db.php");
$teacher_id = $_SESSION["teacher_id"];
$aa = mysql_query("select authority from ".$TABLE."teacher_information where teacher_id = '$teacher_id'");
$bb = mysql_fetch_array($aa);
if($bb["authority"] == 99){
?>
<table width="800" align="center">
<tr class="align_top">
<td align="center">
<?php
include("navigation.php");
?>
</td>
<td>
<form name="form1" action="" method="post">
<table width="600" border="1">
<tr>
 <td><div align="center" class="STYLE1">�ظ���������</div></td>
</tr>
<tr>
<td align="center"><textarea name="answer" cols="60" rows="8"  wrap="virtual"></textarea></td>
</tr>
<tr>
<td align="center"><input type="submit" name="submit" value="�ύ" onclick="return is_empty()"/></td>
</tr>
</table>
</form>
<?php
 if($_POST["submit"]){
 $id = $_GET["id"];
 $answer = $_POST["answer"];
 $sql = mysql_query("update ".$TABLE."suggestion set answer = '$answer' where id = $id");
 if($sql){
   echo "<script>alert('�����ύ�ɹ���');window.location.href='watch_suggestion.php';</script>";
 }else{
    echo "<script>alert('�����ύʧ�ܣ�');history.back();</script>";
 } 
 }
?>
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
