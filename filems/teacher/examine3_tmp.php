<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "���ɼ�¼��";
$YM_ZT2 = "����ʦ¼���ҵ��ƣ����ģ����ɼ�";
$YM_MK = "��ҵ��ƴ�����ϵͳ";
$YM_PT = "���ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<?php
if($_POST["submit"]){
 	$cnt = $_POST["cnt"];
	$nums1 = array("��","��","��","��","��","��","��","��","��","��");
	$nums2 = array("0","1","2","3","4","5","6","7","8","9");
 	for($i=0;$i<$cnt;$i++){
        $s1 = $_POST["s1_".$i];
        $s2 = $_POST["s2_".$i];
        $s3 = $_POST["s3_".$i];
        $s4 = $_POST["s4_".$i];
        $id = $_POST["sid".$i];
 		$s1 = str_replace($nums1,$nums2,$s1)+0;
 		$s2 = str_replace($nums1,$nums2,$s2)+0;
 		$s3 = str_replace($nums1,$nums2,$s3)+0;
 		$s4 = str_replace($nums1,$nums2,$s4)+0;
        if($s1>100) $s1 = 100;  if($s1<0) $s1 = 0;
        if($s2>100) $s2 = 100;  if($s2<0) $s2 = 0;
        if($s3>100) $s3 = 100;  if($s3<0) $s3 = 0;
        if($s4>100) $s4 = 100;  if($s4<0) $s4 = 0;
        $sql = "update ".$TABLE."examine3 set score1 = '$s1',score2 = '$s2',score3 = '$s3',score4 = '$s4' where student_id = '$id' && teacher_id='$teacher_id'";
        //echo $sql;
       if(!$READONLY)$open = mysql_query($sql);
    }
}

if($com_auth==20||$com_auth>80){
	$tid = $_GET["tid"];
	$fz = $_GET["fz"];
	if($tid=="") $tid = $teacher_id;
	if($fz==""||$com_auth<90) $fz = $com_fenzu;
	$fzstr = "";
	if($com_auth>80){
		$fenzu = array(
	   		$CURR_YEAR."A",
   			$CURR_YEAR."B",
   			$CURR_YEAR."C",
   			$CURR_YEAR."D",
   			$CURR_YEAR."E",
   			$CURR_YEAR."F",
		);
		echo "���飺";
		for($i=0;$i<sizeof($fenzu);$i++){
			if($fz==$fenzu[$i]) echo "[<b>".$fenzu[$i]."</b>]&nbsp;";
			else echo "[<a href=".$PHP_SELF."?fz=".$fenzu[$i]."><font color=blue><u>".$fenzu[$i]."</u></font></a>]&nbsp;";
		}
	}
	$sql = "select teacher.teacher_id as tid, name as tname from ".$TABLE."teacher_information as teacher where teacher.fenzu='$fz'";
	$que=mysql_query($sql);
	echo "<br>�鿴".$fz."���ʦ���������";
	while($fet=mysql_fetch_array($que)){
		if($fz!=$com_fenzu&&$tid==$teacher_id) $tid = $fet["tid"];
		$id = $fet["tid"];
		$name = $fet["tname"];
		if($tid==$id) {
			 echo "[<b>".$name."</b>] ";
			 $teachername = $name;
		} else {
			echo "[<a href=".$PHP_SELF."?tid=".$id."&fz=".$fz."><font color=blue><u>".$name."</u></font></a>] ";
		}
	}
} else {
	$tid = $teacher_id;
	$fz = $com_fenzu;
}


?>

<form id="form1" name="form1" method="post" action="">

<table width="770" border="0" align="center" cellpadding="5" bordercolor=#000000>
<tr>
<td align=center>
<font color=blue><b>��ֵ˵����</b></font>������ֱ���֣�<font color=red>ÿ�����Ϊ����100��</font>��ϵͳ���Զ�����ʵ�ʷ�ֵ��<br>
<table width="760" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor=#000000>
<tr bgColor=#5a6e8f height=38>
	<td><font color=#FFFFFF><div align=center>���</div></font></td>
<td width="80"><font color=#FFFFFF><div align="center">ѧ������</div></font></td>
<td><font color=#FFFFFF><div align="center">��ҵ�����Ŀ</div></font></td>
<td><font color=#FFFFFF><div align="center">��ƣ����ģ�<br>˵����</div></font></td>
<td><font color=#FFFFFF><div align="center">ͼֽ</div></font></td>
<td><font color=#FFFFFF><div align="center">�������<br>����</div></font></td>
<td><font color=#FFFFFF><div align="center">������</div></font></td>
</tr>
<?php
 $sql = "select oktopic.student_id,oktopic.type,student.name as sname,oktopic.topic,score1,score2,score3,score4  from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student,".$TABLE."examine3 as exam3 where oktopic.student_id=student.number&&oktopic.student_id=exam3.student_id&&oktopic.fenzu='".$fz."'&&exam3.teacher_id='$tid'  order by sequence,student_id";
 //echo $sql;
 $result = mysql_query($sql);  //��ȡ��ؼ�¼
  $cnt = 0;
$num_rows = mysql_num_rows($result);  
if($num_rows == 0){ //�����δ¼��ɼ������Զ�����ȱʡ�ɼ�0��
	 $tmpsql = "insert into ".$TABLE."examine3(student_id,teacher_id)  select student_id,'".$tid."'  from ".$TABLE."ok_topic where fenzu='".$fz."' order by sequence";
    $tmpresult = mysql_query($tmpsql);
    $result = mysql_query($sql); //������ȡ��ؼ�¼   
}

$nn = 1;
while($row = mysql_fetch_array($result)){
 $id = $cnt++;
 $s1 = "s1_".$id;
 $s2 = "s2_".$id;
 $s3 = "s3_".$id;
 $s4 = "s4_".$id;
 
	if($row["type"]=="��ѧ�о�") $typeclass = 1;
	else $typeclass = 0;	
 echo "<tr align=center>";
 echo "<td>".($nn++)."</td>";
 ?>
<td><?php
	//echo $row["student_id"]; 
	echo $row["sname"]; 
	echo "<input type=hidden name=sid".$id." value=".$row["student_id"].">";
	?></td>
<td align=left><?php
	echo $row["topic"]; 
	?></td>
<td>
<input type=text name=<?php echo $s1;?> value=<?php echo $row["score1"]>0?$row["score1"]:"''";?> size=4 maxlength=4  onmouseover="showTip('�밴�ٷ������֣�ϵͳ���Զ����㣡<br>��δ���������磬�벻Ҫ���֣�лл��')" onmouseout=hideTip() >
</td>
<?php
if($typeclass!=0){
	echo "<td><input type=hidden name=$s4 value=0>����".$detail["type"]."</td>";
}
?>
<td>
<input type=text name=<?php echo $s2;?> value=<?php echo $row["score2"]>0?$row["score2"]:"''";?> size=4 maxlength=4  onmouseover="showTip('�밴�ٷ������֣�ϵͳ���Զ����㣡<br>��δ���������磬�벻Ҫ���֣�лл��')" onmouseout=hideTip() >
</td>
<td>
<input type=text name=<?php echo $s3;?> value=<?php echo $row["score3"]>0?$row["score3"]:"''";?> size=4 maxlength=4  onmouseover="showTip('�밴�ٷ������֣�ϵͳ���Զ����㣡<br>��δ���������磬�벻Ҫ���֣�лл��')" onmouseout=hideTip() >
</td>
<?php
if($typeclass==0){
?>
<td>
<input type=text name=<?php echo $s4;?> value=<?php echo $row["score4"]>0?$row["score4"]:"''";?> size=4 maxlength=4  onmouseover="showTip('�밴�ٷ������֣�ϵͳ���Զ����㣡<br>��δ���������磬�벻Ҫ���֣�лл��')" onmouseout=hideTip() >
</td>
<?php
}
?>
</tr>
<?php
}
?>
</table>
<font color=blue><b>��ֵ˵����</b></font>������ֱ����֣�<font color=red>ÿ�����Ϊ����100��</font>��ϵͳ���Զ�����ʵ�ʷ�ֵ��
</td>
</tr>
<?php
if(!$READONLY&&($tid==$teacher_id||$com_auth>80)){
?>
<tr>
<td>
  <div align="center">
  	 <input type=hidden name=cnt value=<?php echo $cnt; ?>>
    <input type="submit" name="submit" value="�ύ<?php echo $tid==$teacher_id?"��":$teachername; ?>�ԡ�<?php echo $com_fenzu;?>�顿��ѧ�����ɼ�" onclick="tb()"/>
  </div></td>
</tr>
<?php
} else {
	echo "<tr><td align=center>Ŀǰ��ֻ��״̬�������޸ģ�</td></tr>";
}
?>
</table>
</form>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
