<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "教师联系方式";
$YM_ZT2 = "指导教师个人联系方式";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限:普通教师
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 
 <?php
 $aaa = mysql_query("select * from ".$TABLE."teacher_information where teacher_id = '$teacher_id'");
$row = mysql_fetch_array($aaa);
?>

注：本信息仅供您最终指导的学生查看，请放心填写。
<form id="form1" name="form1" method="post" action="">
<table width="500" border="1"    cellpadding=5 bordercolor=#000000>
<tr>
<td width="120">电子邮箱：</td>
<td><input type="text" name="email" value="<? echo $row["email"];?>"/></td>
</tr>
<tr>
<td width="120">办公电话：</td>
<td><input type="text" name="officephone" value="<? echo $row["officephone"];?>"/></td>
</tr>
<tr>
<td>家庭电话：</td>
<td><input type="text" name="homephone" value="<? echo $row["homephone"];?>"/></td>
</tr>
<tr>
<td>手机号码：</td>
<td><input type="text" name="mobilephone" value="<? echo $row["mobilephone"];?>"/></td>
</tr>
<tr>
<td>短码：</td>
<td><input type="text" name="short_number" value="<? echo $row["short_number"];?>"/></td>
</tr>
<tr>
<td>QQ号码：</td>
<td><input type="text" name="qq_number" value="<? echo $row["qq_number"];?>"/></td>
</tr>
</table>
<br>
<input type="submit" name="submit" value="提交我的个人联系信息" />
</form>

<?php
  if($_POST["submit"]){
    	$email = trim($_POST["email"]);
    	$officephone = trim($_POST["officephone"]);
	$homephone = trim($_POST["homephone"]);
	$mobilephone = trim($_POST["mobilephone"]);
	$short_number = trim($_POST["short_number"]);
	$qq_number = trim($_POST["qq_number"]);
	$sql = mysql_query("update ".$TABLE."teacher_information set email='$email',officephone='$officephone',homephone= '$homephone',mobilephone='$mobilephone',short_number='$short_number',qq_number='$qq_number' where teacher_id = '$teacher_id'");
	if($sql){
	 echo "<script>alert('数据提交成功！');history.back();</script>";
	}else{
	 echo "<script>alert('数据提交失败！');history.back();</script>";
	}
  }
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>