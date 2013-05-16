<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "论文送评安排";
$YM_ZT2 = "答辩小组指定学生送评论文的评阅教师";
$YM_MK = "毕业设计答辩管理系统";
$YM_PT = "答辩系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限：指导教师
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
		
		if($row["type"]=="工程设计"){
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
<td><font color=#FFFFFF><div align=center>答辩次序</div></font></td>
<td width="80"><font color=#FFFFFF><div align="center">班级</div></font></td>
<td width="70"><font color=#FFFFFF><div align="center">学生姓名</div></font></td>
<td><font color=#FFFFFF><div align="center">指导教师</div></font></td>
<td><font color=#FFFFFF><div align="center">评阅教师<?php  if($com_auth==20) { ?><br><a onclick='{if(confirm("建议在所有学生均已申请论文送评“待分配”后执行本操作！\r\r警告：系统将取消现有评阅安排，并完全随机设置评阅教师！\r\r确定要执行随机分配评阅教师操作吗?")){return true;}return false;}' href=<?php echo $PHP_SELF; ?>?autopingyue=yeah><font color=yellow><u>随机安排评阅</u></font></a><?php } ?></div></font></td>
<td><?php echo $com_auth>80?"<a href=".$PHP_SELF."?autofenzu=yeah>":"";?><font color=#FFFFFF><div align="center">分组设置</div></font><?php echo $com_auth>80?"</a>":"";?></td>
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
	echo "<tr><td colspan=6 height=168 align=center>对不起，暂未进入答辩环节，毕设课题信息未确定。<br>或者您查看的是往届信息，不予展示！</td></tr>";
  }  
$snum = 0; 
while($row = mysql_fetch_array($sql)){
 $id = $cnt++;
 $check = "check".$id;
 $select = "select".$id;
  if($lastgroup!=$row["fenzu"]) {
 	if($snum>0){
 		 echo "<tr align=center><td>小计</td><td colspan=5><b> $lastgroup 答辩小组 $snum 名学生</b></td></tr>";
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
	if($row["teacher2_id"]=="" && $row["spmissionid"]<1) echo "<option style='background:yellow;color:red' value=''>未申请送评</option>\n";
	else {
		if($CURR_YEAR==$YEAR_C) $where2 = "&&(fenzu='".$row["fenzu"]."'||teacher_id='".$row["teacher2_id"]."')";
		else $where2 = "&&(teacher_id='".$row["teacher2_id"]."')";
		$pysql = "select teacher_id,name,fenzu from ".$TABLE."teacher_information where 1".$where2." order by teacher_id Desc";
		//echo $pysql;
		if($CURR_YEAR==$YEAR_C&&$com_auth >= 20)echo "<option style='background:blue;color:#FFFFFF' value=''>待分配</option>\n";
		if($row["teacher2_id"]==""&&$com_auth >=20)echo "<option style='background:blue;color:#FFFFFF' value=''>未分配</option>\n";
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
		if($pyn==0&&$com_auth < 20)echo "<option style='background:blue;color:#FFFFFF' value=''>未分配评阅</option>\n";
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
	if($com_auth<80) echo $row["fenzu"][4]."组 ".$row["topic"];
	else {
		$fenzus = array($CURR_YEAR."A",$CURR_YEAR."B",$CURR_YEAR."C",$CURR_YEAR."D","none");
		$fz = array("A","B","C","D","其他");
		for($i=0;$i<sizeof($fenzus);$i++){
			if($row["fenzu"]==$fenzus[$i]) $checked = " CHECKED";
			else $checked = "";
			if($com_auth < 80 && $checked=="") $disabled = " disabled";
			else $disabled = "  onClick=change_fenzu2('fenzu".$id."','".$row["student_id"]."','".$fenzus[$i]."')";
			echo "<input name=".$check." type=radio".$checked.$disabled."  value=".$fenzus[$i].">".$fz[$i]."组 ";
		}
	}
?>
</td>
</tr>
<?php
}
if($snum>0){
	echo "<tr align=center><td>小计</td><td colspan=5><b> $lastgroup 答辩小组 $snum 名学生</b></td></tr>";
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
  	 <input type=checkbox name=rand value=ON> 随机调整次序
    <input type="submit" name="submit" value="调整答辩次序" />
  </div></td>
</tr>
<?
} else {
	echo "<tr><td>系统提示：小组答辩秘书可以调整答辩次序。</td></tr>";
}
?>
</table>
</form>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

