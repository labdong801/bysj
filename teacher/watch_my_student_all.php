<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "ָ��ѧ��һ��";
$YM_ZT2 = "��ָ����ѧ����ϵ��Ϣһ��";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��:��ͨ��ʦ
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 <div align="center">��ǰ������ָ��ѧ������ϵ��ʽ
		<?php
	echo "[<a href=".$PHP_SELF."?select_year=".$YEAR_C."><font color=blue><u>".$YEAR_C."��(����)</u></font></a>]";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   ���죺";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) echo "[<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$i."��</u></font></a>] ";
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	//��<a href=/bysj/filems/teacher/teacher_m.php?mission_log=1>�����ĵ�����ϵͳ</a>
	?>	
</div><br>
<?php
$sql = mysql_query(" select name,class,dorm,phone,mobilephone,short_number,qq_number,email,topic from ".$TABLE."student_sheet as student,".$TABLE."topic as topic where topic .teacher_id = '".$teacher_id."' && topic.is_select = 1 && topic.student_number = student.number&&student.year=$select_year order by student.number");
if($sql) $currrows=mysql_num_rows($sql);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<table width=760 border=1 bordercolor=#000000 cellpadding=5>";
	echo "<tr><td height=138 align=center>�Բ������� <b>".$select_year." ��</b> ��ҵ����л�û��ѡ��Ҫָ����ѧ����</td></tr>";
	echo "</table>";
} else {
	echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;����Ϊ���� <b>".$select_year." ��</b> ��ҵ�����ָ����ѧ����Ϣ��<p>";
}

while($row = mysql_fetch_array($sql)){
?>
<table width="760" border="1" bordercolor=#000000 cellpadding=5>
<tr>
<td width="90">������</td>
<td width="120"><font color=blue><? echo "&nbsp;".$row["name"];?></font></td>
<td width="90">�༶��</td>
<td><? echo "&nbsp;".$row["class"]."( ����ţ�".$row["dorm"].")";?></td>
</tr>
<tr>
<td>��ϵ�绰��</td>
<td><? echo "&nbsp;".$row["phone"];?></td>
<td>�ֻ����룺</td>
<td><? echo "&nbsp;".$row["mobilephone"]."( �̺ţ�".$row["short_number"].")"; ?></td>
</tr>
<tr>
<td>QQ���룺</td>
<td><? echo "&nbsp;".$row["qq_number"];?></td>
<td>�������䣺</td>
<td><? echo "&nbsp;".$row["email"];?></td>
</tr>
<tr>
<td>ָ����ʦ��</td>
<td><? echo "&nbsp;".$com_name;?></td>
<td>������⣺</td>
<td><? echo "&nbsp;".$row["topic"];?></td>
</tr>
</table><br>
<?php
}
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>