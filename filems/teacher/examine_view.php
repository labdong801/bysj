<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "��ҵ��Ƴɼ��޸�";
$YM_ZT2 = "�鿴��ҵ��Ƴɼ�¼�����";
$YM_MK = "��ҵ��ƴ�����ϵͳ";
$YM_PT = "���ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 20; //��ҳ������ҪȨ�ޣ�����Ա
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 <?php
 if($com_auth>80){
	$fz = $_GET["fz"];
	if($fz=="") $fz=$com_fenzu;
	$fenzu = array(
   		$CURR_YEAR."A",
   		$CURR_YEAR."B",
   		$CURR_YEAR."C",
   		$CURR_YEAR."D",
   		$CURR_YEAR."E",
   		$CURR_YEAR."F",
   		"GOOD",
	);
	echo "ѡ����Ҫ�޸ĵķ��飺";
	for($i=0;$i<sizeof($fenzu);$i++){
		  echo "[<a href=".$PHP_SELF."?fz=".$fenzu[$i]."><font color=blue><u>".$fenzu[$i]."</u></font></a>]&nbsp;";
	}
} else $fz = $com_fenzu;

if($autoavg == "yeah"){  //�Զ����³ɼ�
	$sql = "select student_id from ".$TABLE."ok_topic where fenzu='".$fz."' order by  sequence,student_id";
	$que = mysql_query($sql);
	while($fet=@mysql_fetch_array($que)){
		$sid = $fet["student_id"];
		$s_sql = "select avg(score1) as score1,avg(score2) as score2,avg(score3) as score3,avg(score4) as score4 from ".$TABLE."examine3 where student_id = '".$sid."'&&(score1>0&&score2>0&&score3>0)  group by student_id";
		$s_query = mysql_query($s_sql);
		$tmpavg = mysql_fetch_array($s_query);
		$score3_1 = ceil($tmpavg["score1"]*10)/10.0;
		$score3_2 = ceil($tmpavg["score2"]*10)/10.0;
		$score3_3 = ceil($tmpavg["score3"]*10)/10.0;
		$score3_4 = ceil($tmpavg["score4"]*10)/10.0;
		
		$a_sql = "update ".$TABLE."ok_topic set 
			score3_1 = '$score3_1',
			score3_2 = '$score3_2',
			score3_3 = '$score3_3',
			score3_4 = '$score3_4'
			where student_id = '$sid' && (fenzu = '".$fz."')";
		//echo "<br>".$a_sql;
		mysql_query($a_sql);
	}
}   
?>
<table width="770" border="0" align="center" cellpadding="2" cellspacing="3">
<tr>
<td align=center>
<font color=blue><b>��ֵ˵����</b></font><font color=red>ÿ�����Ϊ����100��</font>��ϵͳ���Զ�����ʵ�ʷ�ֵ��<br>
<table width=800 border=1 align=center cellpadding=3 bordercolor=#000000>
	
<tr  bgcolor=#5a6e8f height=38 align=center>
<td rowspan=2 width="40"><font color=#FFFFFF><div align=center>���</div></font></td>
<td rowspan=2 width="80"><font color=#FFFFFF><div align=center>ָ����ʦ</div></font></td>
<td rowspan=2 width="100"><font color=#FFFFFF><div align=center><?php echo "<font size=+1><b>".$fz."��</b></font>";?></div></font></td>
<td  rowspan=2><font color=#FFFFFF><div align="center">ѧ��</div></font></td>
<td  rowspan=2 width="80"><font color=#FFFFFF><div align="center">ѧ������</div></font></td>
<td colspan=3><font color=#FFFFFF>ָ���ɼ�</font></td>
<td colspan=3><font color=#FFFFFF>���ĳɼ�</font></td>	
<td colspan=4><font color=#FFFFFF>���ɼ�<?php  if($CURR_YEAR==$YEAR_C&&($com_auth==20||$com_auth>80)) { ?><a onclick='{if(confirm("���������д���ʦ����¼�뱾���С����ɼ���ִ�б�������\r\rȷ��Ҫִ���Զ�������ɼ�������?")){return true;}return false;}' href=<?php echo $PHP_SELF; ?>?autoavg=yeah&fz=<?php echo $fz;?>><font color=yellow><u>�Զ�����</u></font></a><?php } ?></font></td>
<td rowspan=2><font color=#FFFFFF>ָ��<br>�ɼ�</font></td>
<td rowspan=2><font color=#FFFFFF>���<br>�ɼ�</font></td>
<td rowspan=2><font color=#FFFFFF>�ܳɼ�</font></td>
</tr>	
<tr  bgcolor=#5a6e8f  >
<td><font color=#FFFFFF><div align="center">1</div></font></td>
<td><font color=#FFFFFF><div align="center">2</div></font></td>
<td><font color=#FFFFFF><div align="center">3</div></font></td>
<td><font color=#FFFFFF><div align="center">1</div></font></td>
<td><font color=#FFFFFF><div align="center">2</div></font></td>
<td><font color=#FFFFFF><div align="center">3</div></font></td>
<td><font color=#FFFFFF><div align="center">1</div></font></td>
<td><font color=#FFFFFF><div align="center">2</div></font></td>
<td><font color=#FFFFFF><div align="center">3</div></font></td>
<td><font color=#FFFFFF><div align="center">4</div></font></td>
</tr>
<?php
 $sql = "select oktopic.student_id,oktopic.type,student.name as sname,oktopic.topic,class,teacher.name as tname,
 score1_1,score1_2,score1_3,
 score2_1,score2_2,score2_3,
 score3_1,score3_2,score3_3,score3_4,
 ceil((score1_1*10+score1_2*10+score1_2*10)/30) as zscore,
 ceil((score1_1*10+score1_2*10+score1_2*10+score2_1*8+score2_2*6+score2_3*6+score3_1*10+score3_2*10+score3_3*15+score3_4*15)/100) as score,
 ceil((score1_1*10+score1_2*10+score1_2*10+score2_1*8+score2_2*6+score2_3*6+score3_1*15+score3_2*15+score3_3*20)/100) as score2,
 ceil((score3_1*10+score3_2*10+score3_3*15+score3_4*15)/50) as dscore,
 ceil((score3_1*15+score3_2*15+score3_3*20)/50) as dscore2
   from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher where oktopic.teacher_id=teacher.teacher_id&&oktopic.student_id=student.number&&oktopic.fenzu='".$fz."' order by  sequence,student_id";
//echo $sql;
 $result = mysql_query($sql);  //��ȡ��ؼ�¼
  $cnt = 0;
$num_rows = mysql_num_rows($result);  

$nn = 1;
while($row = mysql_fetch_array($result)){
 $id = $cnt++;
 $s1_1 = "s1_1_".$id;
 $s1_2 = "s1_2_".$id;
 $s1_3 = "s1_3_".$id;
 $s2_1 = "s2_1_".$id;
 $s2_2 = "s2_2_".$id;
 $s2_3 = "s2_3_".$id;
 $s3_1 = "s3_1_".$id;
 $s3_2 = "s3_2_".$id;
 $s3_3 = "s3_3_".$id;
 $s3_4 = "s3_4_".$id;
 
	if($row["type"]=="��ѧ�о�") $typeclass = 1;
	else $typeclass = 0;	
	
 echo "<tr align=center>";
 echo "<td>".($nn++)."</td>";
 echo "<td>".$row["tname"]."</td>";
 echo "<td>".$row["class"]."</td>";
 echo "<td>".substr($row["student_id"],9)."</td>";
 echo "<td>".$row["sname"]."</td>";
 ?>
<td>
<?php echo $row["score1_1"]>0?$row["score1_1"]:"&nbsp;";?>
</td>
<td>
<?php echo $row["score1_2"]>0?$row["score1_2"]:"&nbsp;";?>
</td>
<td>
<?php echo $row["score1_3"]>0?$row["score1_3"]:"&nbsp;";?>
</td><td>
<?php echo $row["score2_1"]>0?$row["score2_1"]:"&nbsp;";?>
</td>
<td>
<?php echo $row["score2_2"]>0?$row["score2_2"]:"&nbsp;";?>
</td>
<td>
<?php echo $row["score2_3"]>0?$row["score2_3"]:"&nbsp;";?>
</td>
<td>
<?php echo $row["score3_1"]>0?$row["score3_1"]:"&nbsp;";?>
</td>
<?php
if($typeclass!=0){
	echo "<td>����</td>";
}
?>
<td>
<?php echo $row["score3_2"]>0?$row["score3_2"]:"&nbsp;";?>
</td>
<td>
<?php echo $row["score3_3"]>0?$row["score3_3"]:"&nbsp;";?>
</td>
<?php
if($typeclass==0){
?>
<td>
<?php echo $row["score3_4"]>0?$row["score3_4"]:"&nbsp;";?>
</td>
<?php
}
echo "<td>".$row["zscore"]."</td>";
if($typeclass==1) echo "<td>".$row["dscore2"]."</td>";
else  echo "<td>".$row["dscore"]."</td>";
if($typeclass==1) echo "<td>".$row["score2"]."</td>";
else  echo "<td>".$row["score"]."</td>";
?>
</tr>
<?php
}
?>
</table>
<font color=blue><b>��ֵ˵����</b></font><font color=red>ÿ�����Ϊ����100��</font>��ϵͳ���Զ�����ʵ�ʷ�ֵ��
</td>
</tr>
</table>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

