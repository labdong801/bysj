<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�༭ѡ�����</title>
<style>
.align_top{vertical-align:top}
</style>
</head>

<body>
<?php
include("../head.html");
?>
<?php
include("../connect_db.php");
$teacher_id = $_SESSION["teacher_id"];
$aa = mysql_query("select authority from ".$TABLE."teacher_sheet where teacher_id = '$teacher_id'");
$bb = mysql_fetch_array($aa);
if($bb["authority"] == 1 || $bb["authority"] == 99){
?>
<table width="800" align="left">
<tr class="align_top">
<td align="center">
<?php
include("navigation.php");
?>
</td>
<td>
<form name="form1" action="" method="post">
<table width="500" border="1" align="center">
<tr>
<td colspan="2"><div align="center"><strong>�������</strong></div></td>
</tr>
<tr align="center">
<td>������ѡ�����</td>
<td><input name="name" type="text" />&nbsp;&nbsp;
<input type="submit"  name="add" value="���" /></td>
</tr>
</table>
</form>
<?php
$name = $_POST["name"];
if($_POST["add"]){
$sql = mysql_query("insert into ".$ART_TABLE."title_sort(name) values ('$name')");
if($sql){
 echo "<script>alert('�����ӳɹ���');history.back();</script>";
}
}
?>
<?php
 if($_POST["revise"]){
   $select_class = $_POST["type"];
   $new_name = $_POST["new_name"];
   $update = mysql_query("update ".$ART_TABLE."title_sort set name = '$new_name' where id = '$select_class'");
   if($update){
    echo "<script>alert('����޸ĳɹ���');history.back();</script>";
   }
 }
?>
<form name="form2" action="" method="post">
<table width="500" border="1" align="center">
<tr>
<td colspan="3"><div align="center"><strong>�޸��������</strong></div></td>
</tr>
<tr>
 <td>
 <select name="type" id="type">
   <?php    
	$query = mysql_query("select * from ".$ART_TABLE."title_sort");
	  while($row = mysql_fetch_array($query)){
	?>
  <option value="<? echo $row["id"];?>"><? echo $row["name"];?></option>
   <?php
	 }
   ?>
   </select>
  </td>
  <td>
  �µ��������<input type="text" name="new_name" />
  </td>
  <td>
  <input type="submit" name="revise" value="�༭" />
  </td>
</tr>
</table>
</form>
<?php
}else{
 echo "<script>alert('�Բ�����ûȨ���ʸ�ҳ�棡');history.back();</script>";
}
?>
</td>
</tr>
</table>
</body>
</html>
