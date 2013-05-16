<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "教师答辩分组";
$YM_ZT2 = "设置与查看指导教师答辩分组情况";
$YM_MK = "毕业设计答辩管理系统";
$YM_PT = "答辩系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
<?php
 if($_POST["submit"]){
 	$cnt = $_POST["cnt"];
 	for($i=0;$i<$cnt;$i++){
        $selected = $_POST["select".$i];
        $check = $_POST["check".$i];
        $id = $_POST["tid".$i];
        $sql = "update ".$TABLE."teacher_information set fenzu = '$check',authority = '$selected' where teacher_id = '$id'";
       $open = mysql_query($sql);
    }
}
 
 $bgcolor=array("#FFFFFF","#CCCCCC");
 $lastgroup = "";
 $cc = 1;
 echo "<script  type=\"text/javascript\" src=\"ajax_js_teacher.js\"></script>";
?>

<table width="670" border="0" align="center" cellpadding="2" cellspacing="3">
<tr>
<td>
<table width="660" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor=#000000>
<tr bgColor=#5a6e8f height=38>
<td width="40"><font color=#FFFFFF><div align="center">序号</div></font></td>
<td width="80"><font color=#FFFFFF><div align="center">姓名</div></font></td>
<td><font color=#FFFFFF><div align="center">授权</div></font></td>
<td><font color=#FFFFFF><div align="center">指导人数</div></font></td>
<td><font color=#FFFFFF><div align="center">评阅人数</div></font></td>
<td><font color=#FFFFFF><div align="center">【本科】分组设置</div></font></td>
</tr>
<?php
if($com_auth < 80) $where = " where fenzu='".$com_fenzu."'";
//$sql = "select teacher_id,name,fenzu,authority  from ".$TABLE."teacher_information ".$where." order by fenzu,authority Desc";
$sql = "select teacher.teacher_id,name,fenzu,authority,lead.leadnum,pingyue.pynum  from ".$TABLE."teacher_information as teacher left join (select teacher_id,count(*) as leadnum from ".$TABLE."ok_topic where year=$CURR_YEAR group by teacher_id) as lead on lead.teacher_id=teacher.teacher_id  left join (select teacher2_id,count(*) as pynum from ".$TABLE."ok_topic where year=$CURR_YEAR group by teacher2_id) as pingyue on pingyue.teacher2_id=teacher.teacher_id ".$where." order by fenzu,authority Desc,leadnum desc";
//echo $sql;
 $sql = mysql_query($sql);
 $cnt = 0;
 $snum = 0;
 $tnum = 0;
 while($row = mysql_fetch_array($sql)){
 $id = $cnt++;
 $check = "check".$id;
 $select = "select".$id;
 if($lastgroup!=$row["fenzu"]) {
 	if($snum>0){
 		 echo "<tr align=center><td>小计</td><td colspan=6><b> $lastgroup 答辩小组 $tnum 名老师，$snum 名学生</b><br>小组答辩时间：".$dabian[$lastgroup][0]." 地点：".$dabian[$lastgroup][1]."</td></tr>";
 		 $snum = 0;
 		 $tnum = 0;
 	}
 	$lastgroup = $row["fenzu"];
 	$cc = !$cc;
}
$snum += $row[leadnum];
$tnum ++;
echo "<tr align=center bgcolor=".$bgcolor[$cc].">";
echo "<td>".$cnt."</td>";
?>
<td><?php
	echo $row["name"]; 
	echo "<span id=auth".$id.">";
	if($row["authority"]>20) echo "&nbsp;<font color=red>★</font>";
	else if($row["authority"]==20) echo "&nbsp;<font color=green>☆</font>";
	else ;
	echo "</span>";
	?></td>
<td>
	<?php
	if($row["fenzu"]!=$com_fenzu&&$com_auth<80) echo "<select name=".$select." size=1>";
	else echo "<select name=".$select." size=1  onChange=change_auth('auth".$id."','".$row["teacher_id"]."',this.options[this.options.selectedIndex].value)>";
	reset($com_level);
	while(list($k,$v)=each($com_level)){
		if($k<10) continue;
		if($k>=$com_auth&&$k!=$row["authority"]) continue;
		//if($row["authority"]>$com_auth&&$k!=$row["authority"])continue;
		if(($row["authority"]>$com_auth||$com_auth<80&&$row["fenzu"]!=$com_fenzu)&&$k!=$row["authority"])continue; //不是本组的，不能设置其权限
		if($row["teacher_id"]==$teacher_id&&$k!=$row["authority"])continue;
		//echo "<option>".$k."</option>";
		while(strlen($v)<8) $v .= " ";
		$v = str_replace(" ","&nbsp;",$v);
		if($k==$row["authority"]) $s = " selected";
		else $s = "";
		echo "<option ".$s." value=".$k.">".$v."</option>";
		if($row["authority"]>$com_auth)break;
	}
	echo "</select>";
?>
</td>
<td>
<?php
echo $row[leadnum];
?>
</td>
<td>
<?php
echo "<span id=fenzu".$id.">";
echo $row["pynum"];
echo "</span>";
?>
</td>
<td>
	<?php
	$fenzus = array($CURR_YEAR."A",$CURR_YEAR."B",$CURR_YEAR."C",$CURR_YEAR."D","none");
	$fz = array("A","B","C","D","其他");
	for($i=0;$i<sizeof($fenzus);$i++){
	   if($row["fenzu"]==$fenzus[$i]) $checked = " CHECKED";
	   else $checked = "";
	   if($com_auth<80 && $checked=="") $disabled = " disabled";
	   else if($com_auth<20) $disabled = "";
	   else $disabled = "  onClick=change_fenzu('fenzu".$id."','".$row["teacher_id"]."','".$fenzus[$i]."')";
	   echo "<input name=".$check." type=radio".$checked.$disabled."  value=".$fenzus[$i].">".$fz[$i]."组 ";
	}
?>
</td>
</tr>
<?php
}
 	if($snum>0){
 		 echo "<tr align=center><td>小计</td><td colspan=6><b> $lastgroup 答辩小组 $tnum 名老师，$snum 名学生</b><br>小组答辩时间：".$dabian[$lastgroup][0]." 地点：".$dabian[$lastgroup][1]."</td></tr>";
 		 $snum = 0;
 		 $tnum = 0;
 	}

?>
</table>
</td>
</tr>
</table>
</form>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
