<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�鿴ѧ����ϵ��ʽ";
$YM_ZT2 = "�鿴ѧ����ϵ��ʽ";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��
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
<td width="120">ѧ��������</td>
<td><? echo "&nbsp;<b>".$row["name"]."</b>&nbsp;&nbsp;&nbsp;�༶��<b>".$row["class"]."</b>";?></td>
</tr>
<tr>
<td width="120">����ţ�</td>
<td><? echo "&nbsp;".$row["dorm"];?></td>
</tr>
<tr>
<td>��ϵ�绰��</td>
<td><? echo "&nbsp;".$row["phone"];?></td>
</tr>
<tr>
<td>�ֻ����룺</td>
<td><? echo "&nbsp;".$row["mobilephone"];?></td>
</tr>
<tr>
<td>�̺ţ�</td>
<td><? echo "&nbsp;".$row["short_number"];?></td>
</tr>
<tr>
<td>QQ���룺</td>
<td><? echo "&nbsp;".$row["qq_number"];?></td>
</tr>
<tr>
<td>�������䣺</td>
<td><? echo "&nbsp;".$row["email"];?></td>
</tr>
</table>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>