<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>任务审核与锁定</title>
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
<td>任务：</td>
<td><?php echo $ak["mlname"];?></td>
</tr>
<tr>
<td>任务说明：</td>
<td><?php echo dispEnter($ak["demonstration"])." ";?></td>
</tr>
<tr>
<td>打印时间：</td>
<td><?php echo $ak["print_time"];?></td>
</tr>
<tr>
<td>纸型：</td>
<td><?php echo $ak["paper_type"];?></td>
</tr>
<tr>
<td>份数：</td>
<td><?php echo $ak["paper_num"];?></td>
</tr>
<tr>
<td>最新上传时间：</td>
<td><?php echo $ak["last_uploadtime"];?></td>
</tr>
<tr>
<td>上传次数：</td>
<td><?php echo $ak["upload_times"];?></td>
</tr>
</table>
<form name="myform" action="" method="post">
<table width="780" align="center" border="1">
<tr>
<td>审核任务：</td>
<td>
<?php
 if($ak["is_check"]==-1){
?>
<input type="radio" name="check" value="-1" checked="checked"/><font color="#FF0000">不合要求，不予公布</font>&nbsp;&nbsp;<input type="radio" name="check" value="0" /><font color="#00FF00">等候再审核</font>&nbsp;&nbsp;<input type="radio" name="check" value="1" />审核通过，公布该选题
<?php
}elseif($ak["is_check"]==0){
?>
<input type="radio" name="check" value="-1" /><font color="#FF0000">不合要求，不予公布</font>&nbsp;&nbsp;<input type="radio" name="check" value="0" checked="checked"/><font color="#00FF00">等候再审核</font>&nbsp;&nbsp;<input type="radio" name="check" value="1" />审核通过，公布该选题
<?php
}else{
?>
<input type="radio" name="check" value="-1" /><font color="#FF0000">不合要求，不予公布</font>&nbsp;&nbsp;<input type="radio" name="check" value="0"/><font color="#00FF00">等候再审核</font>&nbsp;&nbsp;<input type="radio" name="check" value="1" checked="checked"/>审核通过，公布该选题
<?php
}
?>
</td>
</tr>
<tr>
<td>锁定任务：</td>
<td>
<?php
 if($ak["lock_flag"]==0){
?>
<input type="radio" name="lock" value="0" checked="checked"/>未锁定&nbsp;&nbsp;
<input type="radio" name="lock" value="1"/><font color="#FF0000">锁定</font>
<?php
}else{
?>
<input type="radio" name="lock" value="0"/>未锁定&nbsp;&nbsp;
<input type="radio" name="lock" value="1" checked="checked"/><font color="#FF0000">锁定</font>
<?php
}
?>	
</td>
</tr>
<tr>
<td>审核意见</td>
<td><textarea name="check_suggestion" cols="60" rows="8"  wrap="virtual"><?php echo $ak["check_suggestion"];?></textarea></td>
</tr>
<tr>
<td colspan="2"><input type="submit" name="submit" value="确定核审该选题" /></td>
</tr>
</table>
</form>
<table width="780" align="center">
<tr>
<td>说明：<br />
<li>只有通过审核的任务，教师或学生才能下载对方上传的文档；</li>
<li>锁定任务后，教师和学生都不能再上传该任务文档。</li>
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
   echo "<script>alert('数据提交成功！');history.back();</script>";
 }else{
   echo "<script>alert('数据提交失败！');history.back();</script>";
 } 
}
?>
<?php
}else{
echo "<script>alert('请先登录！');history.back();</script>";
}
?>
<?php
include("../tail.html");
mysql_close($link);
?>
</body>
</html>