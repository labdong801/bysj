<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�鿴����ѡ��";
$YM_ZT2 = "��ҵ��ƣ����ģ�����һ����";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<?php
$op = $_GET["op"];
$id = $_GET["id"];

if($op=="copy"&&$com_auth>80){
	$sql = mysql_query("insert into ".$TABLE."topic (teacher_id,topic,source,student_number,is_select,type,profession,meaning,request,question,time,year) select '$teacher_id',topic,'0','0','0',type,profession,meaning,request,question,time,'$YEAR_C' FROM ".$TABLE."topic where id=$id");
	if($sql){
		echo "<script>alert('���Ƴɹ���');history.back();</script>";
		echo "<script>history.back();</script>";
	} else {
		echo "<script>alert('����ʧ�ܣ�');history.back();</script>";
	}
}
?> 
 
<table width="100%" align="center">
<tr class="align_top">
<td align="left">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
	echo "<a href=".$PHP_SELF."?select_year=".$YEAR_C."><font color=blue><u>�鿴".$YEAR_C."��(����)ѡ��</u></font></a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   �鿴����ѡ�⣺";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) echo "<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$i."��</u></font></a> ";
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	?>
	&nbsp;<br>&nbsp;<br>
<table width="760" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td width=38><font color=#FFFFFF>���</font></td>
<td><font color=#FFFFFF size=+1>���ύ�� <?php echo $select_year;?>�� ��ҵ�����Ŀ</font></td>
<td width=60><font color=#FFFFFF>��˽��</font></td>
<td width=50><font color=#FFFFFF>��ѡ<br>ѧ��</font></td>
<td width=38><font color=#FFFFFF>�޸�</font></td>
<td width=38><font color=#FFFFFF>ɾ��</font></td>
</tr>
<?php
$sql = mysql_query("select id,topic,source,student_number,is_select,verify,teacher_id from ".$TABLE."topic where (teacher_id = '$teacher_id' or verify = 9) && year=".$select_year." order by id");
if($sql) $currrows=mysql_num_rows($sql);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=6 height=138 align=center>�Բ�������û��Ϊ�����ύ��ҵ��ƿ���</td></tr>";
}
$topic_num = 1;
while($currrows&&$array = mysql_fetch_array($sql)){
?>
<tr align="center">
<td>
<?php 
 if($array["source"]==1){
  echo "��ѡ";
} else if($array["verify"]==9 && $array["teacher_id"]!=$teacher_id){
  echo "<font color=blue>ʾ��</font>";
 }else{
  echo $topic_num++;
 }
?>
</td>
<td align="left"><a href="topic_detail.php?topic_id=<? echo $array["id"];?>&select_year=<?echo $select_year;?>" title="�鿴�������ϸ��Ϣ"><? echo $array["topic"];?></a></td>
<td align="center"><?
	$shenhe = array(
	      "-1" => "<font color=red>δͨ��</font>",
	      "0" => "<font color=green>�����</font>",
	      "9" => "<font color=blue>ʾ����</font>",
	      "1" => "�����"
	      );
	 echo $shenhe[$array["verify"]];
	 ?>
</td>
<td>
<?php 
  if($array["is_select"]==1){
?>
<a href="watch_student.php?student=<? echo $array["student_number"];?>" title="�鿴��ѧ������ϵ��ʽ">
<?php
  $student_number = $array["student_number"];
  $ee = mysql_query("select name from ".$TABLE."student_sheet where number = '$student_number'");
  $ff = mysql_fetch_array($ee);
  echo $ff["name"];
  }else{
   echo "&nbsp;";
  }
?>
</a>
</td>
<td><?php
	   if($array["verify"]==9|| $array["source"]!=0||($array["is_select"]==1&&$select_year!=$YEAR_C)) echo "&nbsp;";
	   else echo "<a href=\"revise.php?id=".$array["id"]."\">�޸�</a>";
?></td>
<td><?php
	if($array["verify"]==9|| $array["source"]!=0||($array["is_select"]==1&&$select_year!=$YEAR_C)){
		if($com_auth>80&&$array["is_select"]==1&&$select_year!=$YEAR_C){
			echo "<a href=$PHP_SELF?id=".$array["id"]."&select_year=$select_year&op=copy onclick=\"return confirm('��ȷ��Ҫ���Ʊ�������')\">����</a>";
		} else {
			echo "&nbsp;";
		}
	} else {
		echo "<a href=\"delete.php?id=".$array["id"]."\" onclick=\"return confirm('��ȷ��Ҫɾ����')\">ɾ��</a>";
	}
?></td>
</tr>
<?php
 }
echo "<tr height=38><td colspan=6 align=center><a href=hand_on.php><font color=blue><u>�ύ�µı�ҵ���ѡ��</u></font></a></td></tr>";
?>
</table>
<br>
<table width="90%" class="STYLE1" align=center>
<tr align=left>
<td>ע�⣺</td>
</tr>
<tr align=left>
<td>1.����š�Ϊ�����֡��ģ��ǽ�ʦ�Լ��ύ����Ŀ�������Խ����޸ĺ�ɾ����</td>
</tr>
<tr align=left>
<td>2.����š�Ϊ����ѡ���ģ���ѧ���Լ��ύ����Ŀ������Ŀϣ���õ�����ָ���������޸ģ�������ɾ����</td>
</tr>
<tr align=left>
<td>3.����š�Ϊ��ʾ�����ģ��ǿ�����д�Ϸ��淶�����ӣ������Բο����ʾ�����޸��Լ��Ŀ��⡣<br>
	&nbsp;&nbsp;&nbsp;&nbsp;��ʾ�������ɹ���Աѡ���Զ������ڴˣ�������ɾ�����޸ġ�</td>
</tr>
<tr>
<td align=left>4. ���Լ��Ŀ��ⱻѡΪ��ʾ���⡱���Լ�Ҳ�����޸ĺ�ɾ����������ϵ����Աȡ����ʾ������ǡ�</td>
</tr>
</table>

</td>
</tr>
</table>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
