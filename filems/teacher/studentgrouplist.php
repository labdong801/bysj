<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "ѧ��������";
$YM_ZT2 = "�鿴ѧ�������鼰����ʱ�䰲��";
$YM_MK = "��ҵ��ƴ�����ϵͳ";
$YM_PT = "���ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
<?php
while(list($k,$v) = each($dabian)){
	if(($k=="2010E"||$k=="2010F")&&$bb["fenzu2"]=="none") continue;  //ר������
	if(substr($k,0,4)!=$CURR_YEAR) continue;
	
echo "<p align=left><font size=+1>ѧ������С�飺<b>".$k[4]."��</b> С���嵥";
if($com_auth>80){
	 TeacherArchiveDown("","","",$k,"","songping","(<b>����".$k."����������</b>)");
	 echo " <a href=/download/tools/DOCתPDF���İ�.rar><font color=blue><u>DOCתPDF����</u></font></a>";
}
echo "<br>С����ʱ�䣺<b>".$v[0]."</b><br>С����ص㣺<b>".$v[1]."</b><br>
<font color=blue size=+1><b>�������ʱ�䣺".$gooddabian[$CURR_YEAR][0]."���ص㣺".$gooddabian[$CURR_YEAR][1]."��</b></font>";
?>
<table width="770" border="1" align="center" cellpadding="2" cellspacing="3" bordercolor=#000000>
<tr>
<td>
<table width="760" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor=#000000>
<tr bgcolor=#5a6e8f height=38>
<td><font color=#FFFFFF><div align=center>������</div></font></td>
<td><font color=#FFFFFF><div align="center">ѧ���༶</div></font></td>
<td width="80"><font color=#FFFFFF><div align="center">ѧ������</div></font></td>
<td><font color=#FFFFFF><div align="center">��ҵ�����Ŀ</div></font></td>
<td><font color=#FFFFFF><div align="center">���ڷ���</div></font></td>
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
	echo "<tr><td height=168 colspan=5 align=center><b>".$CURR_YEAR."�� ��ҵ�����δ��ѧ�����з��顣</td></tr>";
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
<td><?php echo $row["fenzu"][4].($com_auth>80?("/".$row["tfenzu"][4]):""); ?> ��</td>
</tr>
<?php
}
?>
</table>
</td>
</tr>
</table>
<?php
} //����ֱ���ʾ while ����
?>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
