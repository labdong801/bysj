<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>修改任务</title>
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
$aaa = mysql_query("select name from ".$TABLE."teacher_information where teacher_id = '$teacher_id'");
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
 $id = $_GET["mission_log"];
 $lk = mysql_query("select * from ".$TABLE."mission_list where mission_id = $id");
 $kl = mysql_fetch_array($lk);
?>
<form name="myform" method="post" action="" enctype="multipart/form-data">
<table width="700" align="center" border="1">
 <tr>
  <td>任务文档名称：</td>
  <td><input name="name" type="text" size="20" value="<?php echo $kl["name"]?>"/></td>
  <td>保存地址：</td>
  <td><input name="address" type="text" size="20" value="<?php echo $kl["address"]?>"/></td>
 </tr>
 <tr>
  <td>文档上传者：</td>
  <td colspan="3">
  <?php
   if($kl["uploader"]==1){
  ?>
  <input type="radio" name="target" value="1" checked="checked"/>教师&nbsp;&nbsp;<input type="radio" name="target" value="2" />学生&nbsp;&nbsp;<input type="radio" name="target" value="0" />无需上传
  <?php
  }elseif($kl["uploader"]==2){
  ?>
  <input type="radio" name="target" value="1"/>教师&nbsp;&nbsp;<input type="radio" name="target" value="2" checked="checked"/>学生&nbsp;&nbsp;<input type="radio" name="target" value="0" />无需上传  
  <?php
  }else{
  ?>
  <input type="radio" name="target" value="1"/>教师&nbsp;&nbsp;<input type="radio" name="target" value="2" checked="checked"/>学生&nbsp;&nbsp;<input type="radio" name="target" value="0" checked="checked"/>无需上传   
  <?php
  }
  ?>
  </td>
 </tr>
 <tr>
  <td>任务参考文档1：</td>
  <td colspan="3">设计类：<input type="file" name="design" /></td>
 </tr>
 <tr>
  <td>任务参考文档2：</td>
  <td colspan="3">论文类：<input type="file" name="paper" /></td>
 </tr>
 <tr>
  <td>文档说明：</td>
  <td colspan="3"><textarea name="demonstration" cols="60" rows="8"  wrap="virtual"><?php echo $kl["demonstration"]?></textarea></td>
 </tr>
 <tr>
  <td>任务开始时间：</td>
  <td><input name="start_time" type="text" size="20" value="<?php echo $kl["start_time"]?>"/></td>
  <td>任务截止时间：</td>
  <td><input name="end_time" type="text" size="20" value="<?php echo $kl["end_time"]?>" /></td>
 </tr>
 <tr>
  <td>参考文档查看权根：</td>
  <td colspan="3">
 <?php
  if($kl["allow"]==1){
 ?>
<input type="radio" name="allow" value="1" checked="checked"/>教师&nbsp;&nbsp;<input type="radio" name="allow" value="2" />学生&nbsp;&nbsp;<input type="radio" name="allow" value="0"/>两者均可看
 <?php
 }elseif($kl["allow"]==2){
 ?>
<input type="radio" name="allow" value="1" />教师&nbsp;&nbsp;<input type="radio" name="allow" value="2" checked="checked"/>学生&nbsp;&nbsp;<input type="radio" name="allow" value="0"/>两者均可看 
 <?php
 }else{
 ?>
<input type="radio" name="allow" value="1" />教师&nbsp;&nbsp;<input type="radio" name="allow" value="2"/>学生&nbsp;&nbsp;<input type="radio" name="allow" value="0" checked="checked"/>两者均可看  
 <?php
 }
 ?>
  </td>
 </tr>
 <tr>
  <td colspan="7">打印时间：<input name="print_time" type="text" size="20" value="<?php echo $kl["print_time"]?>"/>&nbsp;&nbsp;纸型：
  <?php 
   if($kl["paper_type"]=="A4"){
  ?>
  <select name="paper_type"><option value="A4" selected="selected">A4</option><option value="16K">16K</option></select>
 <?php
 }else{
 ?> 
  <select name="paper_type"><option value="A4">A4</option><option value="16K" selected="selected">16K</option></select> 
 <?php
 }
 ?>
  &nbsp;&nbsp;份数：<input type="text" name="paper_num" size="20" value="<?php echo $kl["paper_num"]?>"/>
  </td>
 </tr>
 <tr align="center">
  <td colspan="4"><input type="submit" name="submit" value="提交" /></td>
 </tr>
</table>
</form>
<table width="700" align="center">
 <tr>
  <td>
   说明：
    <li>如果要提交的当前任务为第i个任务的话，保存地址应为【mission_logi】，如第1个任务，保存的地址为【mission_log1】</li>
	<li>文档上传者单选按钮栏中，选择【教师】表示该任务要求教师上传文档，选择【学生】表示该任务要求学生上传文档；</li>
	<li><font color="#FF0000">设计类上传的参考文档的文件名应为_1，论文类参考文档的文件名应为_2；</font></li>
	<li>参考文档单选按钮栏中，选择【教师】表示教师有权查看参考文档，选择【学生】表示学生有权查看参考文档，选择【两者均可看】表示教师和学生都有权查看参考文档；</li>
    <li><font color="#FF0000">时间的输入格式为：XXXX-XX-XX，如2009-01-01。</font></li>
  </td>
 </tr>
</table>
</td>
</tr>
</table>
<?php
 if($_POST["submit"]!=""){
   $mission_name = $_POST["name"];
   $address = $_POST["address"];
   $target = $_POST["target"];
   $demonstration = $_POST["demonstration"];
   $start_time = $_POST["start_time"];
   $end_time = $_POST["end_time"];
   $allow = $_POST["allow"];
   $print_time = $_POST["print_time"];
   $paper_type = $_POST["paper_type"];
   $paper_num = $_POST["paper_num"];
   $sql = mysql_query("update ".$TABLE."mission_list set name = '$mission_name',address = '$address',uploader = '$target',demonstration = '$demonstration',start_time = '$start_time',end_time = '$end_time',watch_authority = '$allow',print_time = '$print_time',paper_type = '$paper_type',paper_num = '$paper_num' where mission_id = '$id'");
 if($sql){
   if(is_uploaded_file($_FILES["design"]["tmp_name"]) or is_uploaded_file($_FILES["paper"]["tmp_name"])){
   $upfile = $_FILES["design"];
   $upload = $_FILES["paper"];
   $name_1 = $upfile["name"];
   $name_2 = $upload["name"];
   $tmp_name1 = $upfile["tmp_name"];
   $tmp_name2 = $upload["tmp_name"];
   $error1 = $upfile["error"];
   $error2 = $upload["error"];
   $destination1 = "../uploadfile/mission_log".$id.$name_1;
   $destination2 = "../uploadfile/mission_log".$id.$name_2;
  if($error1=='0'&&$error2=='0'){ 
     move_uploaded_file($tmp_name1,$destination1);
	 move_uploaded_file($tmp_name2,$destination2);
   }
  }
  echo "<script>alert('数据更新成功！');history.back();</script>";
 }else{
  echo "<script>alert('数据更新失败！');history.back();</script>";
 }  
}
?>
<?php
}else{
 echo "<script>alert('对不起，您没权访问该页面！');history.back();</script>";
}
?>
<?php
include("../tail.html");
mysql_close($link);
?>
</body>
</html>
</body>
</html>
