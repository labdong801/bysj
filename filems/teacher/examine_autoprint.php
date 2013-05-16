<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "考核环节：考核表打印";
$YM_ZT2 = "考核环节：专业主任打印本专业成绩考核表";
$YM_MK = "毕业设计答辩管理系统";
$YM_PT = "答辩系统";
$YM_DH = 1; //需要导航条
$YM_QX = 20; //本页访问需要权限
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
<?php
include("inc_print.php");
$sid = $_GET["sid"];
if($_POST["sid"]!="")$sid = $_POST["sid"];
?>
<table width="660" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor=#000000>
<tr>
<td colspan=10>
	<font class=bigdate ><strong><font color=blue>&nbsp;&nbsp;考核表打印&nbsp;&nbsp;</font></strong></font>
	点击学生名单，则从该学生开始自动打印考核成绩单<?php
	?></td>
</tr>
<?php
 $sql = "select student_id,oktopic.teacher2_id,student.name as sname  from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student where oktopic.student_id=student.number&&oktopic.year=$CURR_YEAR && oktopic.student_pro_id=$CURR_PID order by student_id";
 //echo $sql;
 $sqlquery = mysql_query($sql);
  if($sqlquery) $currrows=mysql_num_rows($sqlquery);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=10 height=68 align=center>对不起，系统中没有当前专业的毕业生学生名单！</td></tr>";
  }  
  $cnt = 0;
while($row = mysql_fetch_array($sqlquery)){
	$sid = substr($row[student_id],strlen($row[student_id])-3,3)+0;
	if($cnt&&$sid%100==1){
			for(;$cnt%5!=0;$cnt++){
				echo "<td width=130 colspan=2>&nbsp;</td>";
			}	
			echo "</tr><tr><td colspan=10></td></tr>";
	}	
	if($cnt%5==0) echo "<tr>";
	   echo "<td width=30>".$sid."</td>";
     echo "<td width=78 align=center><a href=examine_print.php?sid=".$row["student_id"]."&autoprint=yeah target=_blank><font color=blue><u>".$row["sname"]."</u></font></a></td>";
     if($cnt%5==4)echo "</tr>";
    $cnt++;
}
for(;$cnt%5!=0;$cnt++){
	echo "<td width=130 colspan=2>&nbsp;</td>";
}
?>
</table>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
