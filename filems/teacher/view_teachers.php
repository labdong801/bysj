<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "ָ����ʦһ��";
$YM_ZT2 = "�鿴��רҵָ����ʦһ����";
$YM_MK = "��ҵ��ƴ�����ϵͳ";
$YM_PT = "���ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 30; //��ҳ������ҪȨ�ޣ�����Ա
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 
<table width=800 border=1 align=center cellpadding=3 bordercolor=#000000>
<tr  bgcolor=#5a6e8f height=38 align=center>
<td><font color=#FFFFFF><div align=center>���</div></font></td>
<td><font color=#FFFFFF><div align=center>רҵ����</div></font></td>
<td><font color=#FFFFFF><div align=center>����</div></font></td>
<td><font color=#FFFFFF><div align=center>�Ա�</div></font></td>
<td><font color=#FFFFFF><div align=center>����</div></font></td>
<td><font color=#FFFFFF><div align=center>ѧ��</div></font></td>
<td><font color=#FFFFFF><div align=center>ѧλ</div></font></td>
<td><font color=#FFFFFF><div align=center>��ҵѧУ</div></font></td>
<td><font color=#FFFFFF><div align=center>��ҵʱ��</div></font></td>
<td><font color=#FFFFFF><div align=center>ְ��</div></font></td>
<td><font color=#FFFFFF><div align=center>Ƹ������</div></font></td>
</tr>	
<?php
 $sql = "SELECT name, sex, birthday, educatelevel, degree, graduateschool, graduate, oktopic.techpos, techposdate
FROM BYSJ_teacher_information as teacher, BYSJ_ok_topic as oktopic
WHERE oktopic.year = '".$CURR_YEAR."' && oktopic.student_pro_id=".$CURR_PID."&&oktopic.teacher_id=teacher.teacher_id
group by oktopic.teacher_id  order by name";
//echo $sql;
$result = mysql_query($sql);  //��ȡ��ؼ�¼
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

