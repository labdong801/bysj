<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "������������";
$YM_ZT2 = "���С��ָ��ѧ���������ĵ����Ľ�ʦ";
$YM_MK = "��ҵ��ƴ�����ϵͳ";
$YM_PT = "���ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ�ޣ�ָ����ʦ
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
<?php
if($_GET["autopingyue"]=="yeah"){
	$sql = "update ".$TABLE."ok_topic set teacher2_id = '' where fenzu='$com_fenzu'";
	$que = mysql_query($sql);
	$sql = "select oktopic.teacher_id,count(*) as leadnum from ".$TABLE."ok_topic as oktopic,".$TABLE."teacher_information as teacher where oktopic.year=$CURR_YEAR&&teacher.fenzu='$com_fenzu'&&teacher.teacher_id=oktopic.teacher_id group by teacher_id order by leadnum desc";
	$que = mysql_query($sql);
	while($row = @mysql_fetch_array($que)){
		$sql2 = "select student_id  from ".$TABLE."ok_topic where (teacher2_id=''||teacher2_id is NULL)&&teacher_id!='".$row["teacher_id"]."'&&year=$CURR_YEAR&&fenzu='$com_fenzu'&&spmissionid>0 order by rand()  limit 0,".$row["leadnum"].";";
		$que2 = mysql_query($sql2);
		while($row2 = @mysql_fetch_array($que2)){
			   $sql3 = "update ".$TABLE."ok_topic set teacher2_id = '".$row["teacher_id"]."' where student_id='".$row2["student_id"]."'";
			   mysql_query($sql3);
		}
	}
}

if($_GET["autofenzu"]=="yeah"){
	$sql = "select student_id,teacher.fenzu,oktopic.type  from ".$TABLE."ok_topic as oktopic,".$TABLE."teacher_information as teacher where oktopic.year=$CURR_YEAR&&oktopic.teacher_id=teacher.teacher_id";
	$que = mysql_query($sql);
	while($row = @mysql_fetch_array($que)){
		
		if($row["type"]=="�������"){
			if($row["fenzu"][4]=="A") $newfenzu = $CURR_YEAR."B";
			else if($row["fenzu"][4]=="B") $newfenzu = $CURR_YEAR."A";
			else $newfenzu = $CURR_YEAR.chr(ord("A")+($row["student_id"][strlen($row["student_id"])-1]+1)%4);
			if($row["fenzu"]==$newfenzu)$newfenzu = $CURR_YEAR.chr(ord("A")+($row["student_id"][strlen($row["student_id"])-1]+0)%4);
		} else{
			$newfenzu = chr(ord("C")+($row["student_id"][strlen($row["student_id"])-1]+1)%2);
			if($row["fenzu"][4]==$newfenzu)$newfenzu = chr(ord("C")+($row["student_id"][strlen($row["student_id"])-1]+0)%2);
			$newfenzu = $CURR_YEAR.$newfenzu;
		}
		$sql = "update ".$TABLE."ok_topic set fenzu='".$newfenzu."' where student_id='".$row["student_id"]."'";
		mysql_query($sql);
	}
	//echo $sql;
}
 
if($_POST["submit"]){
	$cnt = $_POST["cnt"];
	$rand = $_POST["rand"];
	if($rand=="ON") {
		$sql = "update ".$TABLE."ok_topic set sequence = FLOOR(1 + (RAND() * 40)) where fenzu='$com_fenzu'";
		mysql_query($sql);
	} else {
 		for($i=0;$i<$cnt;$i++){
 			$id = $_POST["sid".$i];
 			$seq = $_POST["seq".$i];
 			$sql = "update ".$TABLE."ok_topic set sequence = '$seq' where student_id = '$id'";
 			$open = mysql_query($sql);
 		}
 	}
}
 $bgcolor=array("#FFFFFF","#CCCCCC");
 $lastgroup = "";
 $cc = 1;
 echo "<script  type=\"text/javascript\" src=\"ajax_js_teacher.js\"></script>";
?>
<form id="form1" name="form1" method="post" action="">

<table width="780" border="0" align="center" cellpadding="2" cellspacing="3">
<tr>
<td align=center>
<table width="780" border="1" align="center" cellpadding="5" bordercolor=#000000>
<tr bgcolor=#5a6e8f height=38>
<td><font color=#FFFFFF><div align=center>������</div></font></td>
<td width="80"><font color=#FFFFFF><div align="center">�༶</div></font></td>
<td width="70"><font color=#FFFFFF><div align="center">ѧ������</div></font></td>
<td><font color=#FFFFFF><div align="center">ָ����ʦ</div></font></td>
<td><font color=#FFFFFF><div align="center">���Ľ�ʦ<?php  if($com_auth==20) { ?><br><a onclick='{if(confirm("����������ѧ�������������������������䡱��ִ�б�������\r\r���棺ϵͳ��ȡ���������İ��ţ�����ȫ����������Ľ�ʦ��\r\rȷ��Ҫִ������������Ľ�ʦ������?")){return true;}return false;}' href=<?php echo $PHP_SELF; ?>?autopingyue=yeah><font color=yellow><u>�����������</u></font></a><?php } ?></div></font></td>
<td><?php echo $com_auth>80?"<a href=".$PHP_SELF."?autofenzu=yeah>":"";?><font color=#FFFFFF><div align="center">��������</div></font><?php echo $com_auth>80?"</a>":"";?></td>
</tr>
<?php
 if($com_auth < 80&&$CURR_YEAR==$YEAR_C){
 	$where = "&&oktopic.fenzu='".$com_fenzu."'";
 }
 $sql = "select student_id,class,sequence,oktopic.fenzu,spmissionid,oktopic.topic,oktopic.teacher_id,teacher2_id,student.name as sname,teacher.name as tname  from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher where oktopic.student_id=student.number&&oktopic.year=$CURR_YEAR&&oktopic.teacher_id=teacher.teacher_id".$where." order by fenzu,sequence,student_id";
//echo $sql;
 $sql = mysql_query($sql);
  $cnt = 0;
  if($sql) $currrows=mysql_num_rows($sql);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=6 height=168 align=center>�Բ�����δ�����绷�ڣ����������Ϣδȷ����<br>�������鿴����������Ϣ������չʾ��</td></tr>";
  }  
$snum = 0; 
while($row = mysql_fetch_array($sql)){
 $id = $cnt++;
 $check = "check".$id;
 $select = "select".$id;
  if($lastgroup!=$row["fenzu"]) {
 	if($snum>0){
 		 echo "<tr align=center><td>С��</td><td colspan=5><b> $lastgroup ���С�� $snum ��ѧ��</b></td></tr>";
 		 $snum = 0;
 	}
 	$lastgroup = $row["fenzu"];
 	$cc = !$cc;
}
$snum ++;
 echo "<tr align=center bgcolor=".$bgcolor[$cc].">";
 ?>
<td><?php
	//echo $row["student_id"]; 
	if($com_auth == 20) echo "<input type=text size=3 maxlength=3 name=seq".$id." value=".$cnt.">";
    else echo $cnt;
	?></td>
<td><?php
	echo $row["class"]; 
	?></td><td><?php
	//echo $row["student_id"]; 
	echo $row["sname"]; 
	echo "<input type=hidden name=sid".$id." value=".$row["student_id"].">";
	?></td><td><?php
	//echo $row["teacher_id"]; 
	echo "<span id=fenzu".$id.">";
	echo $row["tname"]; 
	echo "</span>";
	?></td><td>
<?php
   echo "<select name=".$select."  onChange=change_pingyue('py".$id."','".$row["student_id"]."',this.options[this.options.selectedIndex].value)>";
	if($row["teacher2_id"]=="" && $row["spmissionid"]<1) echo "<option style='background:yellow;color:red' value=''>δ��������</option>\n";
	else {
		if($CURR_YEAR==$YEAR_C) $where2 = "&&(fenzu='".$row["fenzu"]."'||teacher_id='".$row["teacher2_id"]."')";
		else $where2 = "&&(teacher_id='".$row["teacher2_id"]."')";
		$pysql = "select teacher_id,name,fenzu from ".$TABLE."teacher_information where 1".$where2." order by teacher_id Desc";
		//echo $pysql;
		if($CURR_YEAR==$YEAR_C&&$com_auth >= 20)echo "<option style='background:blue;color:#FFFFFF' value=''>������</option>\n";
		if($row["teacher2_id"]==""&&$com_auth >=20)echo "<option style='background:blue;color:#FFFFFF' value=''>δ����</option>\n";
		$pysqlquery = mysql_query($pysql);
		$pyn = 0;
		while($py = mysql_fetch_array($pysqlquery)){
			if($row["teacher_id"]==$py["teacher_id"]) continue;
			if($row["teacher2_id"]==$py["teacher_id"]) $str = " selected";
			else $str = "";
			if($com_auth < 20 &&$str=="")continue;
			if($py["fenzu"]!=$row["fenzu"]) $setcolor = "style='background:red;color:yellow'";
			else $setcolor = "";
			echo "<option $setcolor value='".$py["teacher_id"]."'".$str.">".$py["name"]."</option>\n";
			$pyn ++;
		}
		if($pyn==0&&$com_auth < 20)echo "<option style='background:blue;color:#FFFFFF' value=''>δ��������</option>\n";
	}
?> 
</select>
<?php
	echo "<span id=py".$id.">";
	echo "</span>";
?>
</td>
<td align=left>
	<?php
	if($com_auth<80) echo $row["fenzu"][4]."�� ".$row["topic"];
	else {
		$fenzus = array($CURR_YEAR."A",$CURR_YEAR."B",$CURR_YEAR."C",$CURR_YEAR."D","none");
		$fz = array("A","B","C","D","����");
		for($i=0;$i<sizeof($fenzus);$i++){
			if($row["fenzu"]==$fenzus[$i]) $checked = " CHECKED";
			else $checked = "";
			if($com_auth < 80 && $checked=="") $disabled = " disabled";
			else $disabled = "  onClick=change_fenzu2('fenzu".$id."','".$row["student_id"]."','".$fenzus[$i]."')";
			echo "<input name=".$check." type=radio".$checked.$disabled."  value=".$fenzus[$i].">".$fz[$i]."�� ";
		}
	}
?>
</td>
</tr>
<?php
}
if($snum>0){
	echo "<tr align=center><td>С��</td><td colspan=5><b> $lastgroup ���С�� $snum ��ѧ��</b></td></tr>";
}
?>
</table>
</td>
</tr>
<?php
if($com_auth == 20 &&  $currrows>0){
?>
<tr>
<td>
  <div align="center">
  	 <input type=hidden name=cnt value=<?php echo $cnt; ?>>
  	 <input type=checkbox name=rand value=ON> �����������
    <input type="submit" name="submit" value="����������" />
  </div></td>
</tr>
<?
} else {
	echo "<tr><td>ϵͳ��ʾ��С����������Ե���������</td></tr>";
}
?>
</table>
</form>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

