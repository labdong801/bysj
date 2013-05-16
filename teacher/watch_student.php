<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "查看学生联系方式";
$YM_ZT2 = "查看学生联系方式";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
$student_number = $_GET["student"];
 ?>
<table width="550" border="1"   bordercolor=#000000  cellpadding="5">
<?php
$sql = mysql_query("select * from ".$TABLE."student_sheet where number = '$student_number'");
$row = mysql_fetch_array($sql);
?>
<tr>
<td width="120">学生姓名：</td>
<td><? echo "&nbsp;<b>".$row["name"]."</b>&nbsp;&nbsp;&nbsp;班级：<b>".$row["class"]."</b>";?></td>
</tr>
<tr>
<td width="120">宿舍号：</td>
<td><? echo "&nbsp;".$row["dorm"];?></td>
</tr>
<tr>
<td>联系电话：</td>
<td><? echo "&nbsp;".$row["phone"];?></td>
</tr>
<tr>
<td>手机号码：</td>
<td><? echo "&nbsp;".$row["mobilephone"];?></td>
</tr>
<tr>
<td>短号：</td>
<td><? echo "&nbsp;".$row["short_number"];?></td>
</tr>
<tr>
<td>QQ号码：</td>
<td><? echo "&nbsp;".$row["qq_number"];?></td>
</tr>
<tr>
<td>电子邮箱：</td>
<td><? echo "&nbsp;".$row["email"];?></td>
</tr>
</table>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>