<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "学生答辩分组";
$YM_ZT2 = "查看学生答辩分组及其答辩时间安排";
$YM_MK = "毕业设计答辩管理系统";
$YM_PT = "答辩系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
<?php
while(list($k,$v) = each($dabian)){
	if(($k=="2010E"||$k=="2010F")&&$bb["fenzu2"]=="none") continue;  //专科跳离
	if(substr($k,0,4)!=$CURR_YEAR) continue;
	
echo "<p align=left><font size=+1>学生所在小组：<b>".$k[4]."组</b> 小组清单";
if($com_auth>80){
	 TeacherArchiveDown("","","",$k,"","songping","(<b>下载".$k."组送评论文</b>)");
	 echo " <a href=/download/tools/DOC转PDF中文版.rar><font color=blue><u>DOC转PDF工具</u></font></a>";
}
echo "<br>小组答辩时间：<b>".$v[0]."</b><br>小组答辩地点：<b>".$v[1]."</b><br>
<font color=blue size=+1><b>公开答辩时间：".$gooddabian[$CURR_YEAR][0]."，地点：".$gooddabian[$CURR_YEAR][1]."！</b></font>";
?>
<table width="770" border="1" align="center" cellpadding="2" cellspacing="3" bordercolor=#000000>
<tr>
<td>
<table width="760" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor=#000000>
<tr bgcolor=#5a6e8f height=38>
<td><font color=#FFFFFF><div align=center>答辩次序</div></font></td>
<td><font color=#FFFFFF><div align="center">学生班级</div></font></td>
<td width="80"><font color=#FFFFFF><div align="center">学生姓名</div></font></td>
<td><font color=#FFFFFF><div align="center">毕业设计题目</div></font></td>
<td><font color=#FFFFFF><div align="center">所在分组</div></font></td>
</tr>
<?php
 $sql = "SELECT oktopic.fenzu, topic,student.name as sname,class,oktopic.student_id as sid,teacher.fenzu as tfenzu
FROM ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher
WHERE oktopic.fenzu = '".$k."'&&oktopic.teacher_id=teacher.teacher_id&&oktopic.student_id=student.number&&oktopic.year=$CURR_YEAR
ORDER BY sequence, student_id";

//echo $sql;
 $sql = mysql_query($sql);
  $cnt = 1;
if($sql) $currrows=mysql_num_rows($sql);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=168 colspan=5 align=center><b>".$CURR_YEAR."届 毕业设计暂未对学生进行分组。</td></tr>";
  }     
while($row = @mysql_fetch_array($sql)){
	if($row["sid"]==$student_id)$bgcolor="#EEEEEE";
	else $bgcolor="";
 echo "<tr align=center bgcolor=$bgcolor>";
 ?>
<td><?php echo $cnt++;	?></td>
<td><?php echo $row["class"]; ?></td>
<td><?php echo $row["sname"]; ?></td>
<td align=left>&nbsp;<?php echo $row["topic"]; ?></td>
<td><?php echo $row["fenzu"][4].($com_auth>80?("/".$row["tfenzu"][4]):""); ?> 组</td>
</tr>
<?php
}
?>
</table>
</td>
</tr>
</table>
<?php
} //分组分别显示 while 结束
?>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
