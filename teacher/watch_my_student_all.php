<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "指导学生一览";
$YM_ZT2 = "我指导的学生联系信息一览";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限:普通教师
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 <div align="center">当前您所有指导学生的联系方式
		<?php
	echo "[<a href=".$PHP_SELF."?select_year=".$YEAR_C."><font color=blue><u>".$YEAR_C."届(本届)</u></font></a>]";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   往届：";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) echo "[<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$i."届</u></font></a>] ";
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	//，<a href=/bysj/filems/teacher/teacher_m.php?mission_log=1>进入文档管理系统</a>
	?>	
</div><br>
<?php
$sql = mysql_query(" select name,class,dorm,phone,mobilephone,short_number,qq_number,email,topic from ".$TABLE."student_sheet as student,".$TABLE."topic as topic where topic .teacher_id = '".$teacher_id."' && topic.is_select = 1 && topic.student_number = student.number&&student.year=$select_year order by student.number");
if($sql) $currrows=mysql_num_rows($sql);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<table width=760 border=1 bordercolor=#000000 cellpadding=5>";
	echo "<tr><td height=138 align=center>对不起，您在 <b>".$select_year." 届</b> 毕业设计中还没有选定要指导的学生。</td></tr>";
	echo "</table>";
} else {
	echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;以下为您在 <b>".$select_year." 届</b> 毕业设计中指导的学生信息：<p>";
}

while($row = mysql_fetch_array($sql)){
?>
<table width="760" border="1" bordercolor=#000000 cellpadding=5>
<tr>
<td width="90">姓名：</td>
<td width="120"><font color=blue><? echo "&nbsp;".$row["name"];?></font></td>
<td width="90">班级：</td>
<td><? echo "&nbsp;".$row["class"]."( 宿舍号：".$row["dorm"].")";?></td>
</tr>
<tr>
<td>联系电话：</td>
<td><? echo "&nbsp;".$row["phone"];?></td>
<td>手机号码：</td>
<td><? echo "&nbsp;".$row["mobilephone"]."( 短号：".$row["short_number"].")"; ?></td>
</tr>
<tr>
<td>QQ号码：</td>
<td><? echo "&nbsp;".$row["qq_number"];?></td>
<td>电子邮箱：</td>
<td><? echo "&nbsp;".$row["email"];?></td>
</tr>
<tr>
<td>指导教师：</td>
<td><? echo "&nbsp;".$com_name;?></td>
<td>毕设课题：</td>
<td><? echo "&nbsp;".$row["topic"];?></td>
</tr>
</table><br>
<?php
}
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>