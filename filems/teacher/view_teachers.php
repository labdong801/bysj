<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "指导教师一览";
$YM_ZT2 = "查看本专业指导教师一览表";
$YM_MK = "毕业设计答辩管理系统";
$YM_PT = "答辩系统";
$YM_DH = 1; //需要导航条
$YM_QX = 30; //本页访问需要权限：管理员
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 
<table width=800 border=1 align=center cellpadding=3 bordercolor=#000000>
<tr  bgcolor=#5a6e8f height=38 align=center>
<td><font color=#FFFFFF><div align=center>序号</div></font></td>
<td><font color=#FFFFFF><div align=center>专业名称</div></font></td>
<td><font color=#FFFFFF><div align=center>姓名</div></font></td>
<td><font color=#FFFFFF><div align=center>性别</div></font></td>
<td><font color=#FFFFFF><div align=center>生日</div></font></td>
<td><font color=#FFFFFF><div align=center>学历</div></font></td>
<td><font color=#FFFFFF><div align=center>学位</div></font></td>
<td><font color=#FFFFFF><div align=center>毕业学校</div></font></td>
<td><font color=#FFFFFF><div align=center>毕业时间</div></font></td>
<td><font color=#FFFFFF><div align=center>职称</div></font></td>
<td><font color=#FFFFFF><div align=center>聘任日期</div></font></td>
</tr>	
<?php
 $sql = "SELECT name, sex, birthday, educatelevel, degree, graduateschool, graduate, oktopic.techpos, techposdate
FROM BYSJ_teacher_information as teacher, BYSJ_ok_topic as oktopic
WHERE oktopic.year = '".$CURR_YEAR."' && oktopic.student_pro_id=".$CURR_PID."&&oktopic.teacher_id=teacher.teacher_id
group by oktopic.teacher_id  order by name";
//echo $sql;
$result = mysql_query($sql);  //提取相关记录
$cnt = 0;
$num_rows = mysql_num_rows($result);  
$nn = 1;
while($row = mysql_fetch_array($result)){
	echo "<tr align=center>";
 	echo "<td>".($nn++)."</td>";
 	echo "<td>".$pro_name."</td>";
 	echo "<td>".$row["name"]."</td>";
 	echo "<td>".$row["sex"]."</td>";
 	echo "<td>".$row["birthday"]."</td>";
 	echo "<td>".$row["educatelevel"]."</td>";
 	echo "<td>".$row["degree"]."</td>";
 	echo "<td>".$row["graduateschool"]."</td>";
 	echo "<td>".$row["graduate"]."</td>";
 	echo "<td>".$row["techpos"]."</td>";
 	echo "<td>".$row["techposdate"]."</td>";
 	echo "</tr>";
}
?>
</table>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

