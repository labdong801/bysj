<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "考核环节：指导";
$YM_ZT2 = "考核环节：指导教师评定学生毕业设计情况";
$YM_MK = "毕业设计答辩管理系统";
$YM_PT = "答辩系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 
<?php
$sid = $_GET["sid"];
if($_POST["sid"]!="")$sid = $_POST["sid"];
if($_POST["submit"]){
	//提交考核表进行的操作
 	$type = $_POST["type"];
 	$topic = $_POST["topic"];
 	$score1_1 = $_POST["score1_1"];
 	$score1_2 = $_POST["score1_2"];
 	$score1_3 = $_POST["score1_3"];
	$nums1 = array("０","１","２","３","４","５","６","７","８","９");
	$nums2 = array("0","1","2","3","4","5","6","7","8","9");
 	$score1_1 = str_replace($nums1,$nums2,$score1_1);
 	$score1_2 = str_replace($nums1,$nums2,$score1_2);
 	$score1_3 = str_replace($nums1,$nums2,$score1_3);
 	$comment1 = $_POST["comment1"];

    if($score1_1>100) $score1_1 = 100;  if($score1_1<0) $score1_1 = 0;
    if($score1_2>100) $score1_2 = 100;  if($score1_2<0) $score1_2 = 0;
    if($score1_3>100) $score1_3 = 100;  if($score1_3<0) $score1_3 = 0;
 	
 	$comment1 = HTMLSpecialChars($comment1); 	
 	$topic = HTMLSpecialChars($topic); 	
//  	禁止修改题目、类型、分数
	if($READONLY){
		$sql = "update ".$TABLE."ok_topic set comment1 = '$comment1' where student_id = '$sid' && teacher_id = '$teacher_id'";
	} else {
		$sql = "update ".$TABLE."ok_topic set 
            score1_1 = '$score1_1',
            score1_2 = '$score1_2',
            score1_3 = '$score1_3',
		comment1 = '$comment1' where student_id = '$sid' && teacher_id = '$teacher_id'";
	}
           
/*            
    $sql = "update ".$TABLE."ok_topic set 
            type = '$type',
            topic = '$topic',
            score1_1 = '$score1_1',
            score1_2 = '$score1_2',
            score1_3 = '$score1_3',
            comment1 = '$comment1'
            where student_id = '$sid' && teacher_id = '$teacher_id'";
*/            
   $open = mysql_query($sql);
}

echo "<script  type=\"text/javascript\" src=\"ajax_js_teacher.js\"></script>";
?>

<table width="660" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor=#000000>
<tr>
<td colspan=5>
	<font class=bigdate color=blue><strong>1.&nbsp;&nbsp;指导&nbsp;&nbsp;</strong></font>
	以下是您指导的学生清单，请对他们进行毕业设计考核评分</td>
</tr>
<?php
$fenshu = "ceil((score1_1+score1_2+score1_3)/3) as score";
 $sql = "select student_id,oktopic.fenzu,oktopic.teacher_id,student.name as sname,teacher.name as tname,".$fenshu."  from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher where oktopic.student_id=student.number&&student.year=$CURR_YEAR&&oktopic.teacher_id=teacher.teacher_id&&oktopic.teacher_id='".$teacher_id."' order by student_id";
//echo $sql;
 $sqlquery = mysql_query($sql);
  if($sqlquery) $currrows=mysql_num_rows($sqlquery);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=5 height=68 align=center>对不起，系统中没有您指导 <b>".$CURR_YEAR."届</b> 毕业设计的学生记录</td></tr>";
  }  
 
  $cnt = 0;
while($row = mysql_fetch_array($sqlquery)){
	if($cnt%5==0) echo "<tr>";
     echo "<td width=130 align=center><a href=".$PHP_SELF."?sid=".$row["student_id"]."><font color=blue><u>".$row["sname"]."</u></font></a>(".$row["score"].")</td>";
     if($cnt%5==4)echo "</tr>";
    $cnt++;
}
for(;$cnt%5!=0;$cnt++){
	echo "<td width=130>&nbsp;</td>";
}
?>
</table>

<?php
$showit = true;

if($sid=="") $showit = false;
 $sql = "select student.profession as spro,class,type,student_id,oktopic.teacher2_id,oktopic.teacher_id,student.name as sname,topic,
   score1_1,score1_2,score1_3,score2_1,score2_2,score2_3,score3_1,score3_2,score3_3,score3_4,
   comment1,comment2,comment3,comment4
   from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher where oktopic.student_id=student.number&&oktopic.teacher_id=teacher.teacher_id&&oktopic.student_id='".$sid."'&&oktopic.teacher_id='".$teacher_id."'";
//echo $sql;
 $sqlquery = mysql_query($sql);
 $detail = mysql_fetch_array($sqlquery);
 if($detail["student_id"]=="") $showit = false;

/////////下方是成绩考核表展示区
if($showit){
	
	$downsql = "select address,filename,oktopic.teacher_id,spmissionid,oktopic.student_pro_id,oktopic.year,name from ".$TABLE."mission_list as list,".$TABLE."mission_log as log,".$TABLE."ok_topic as oktopic where list.mission_id=oktopic.spmissionid &&oktopic.student_id=log.student_id&& log.mission_id=list.mission_id &&  log.student_id = '$sid'";
	//echo $downsql;
	$downquery = mysql_query($downsql);
	$down = mysql_fetch_array($downquery);	
	$candown = false;
	if($down["filename"]!=""){
		$downurl = "../../../Docs/".$down["year"]."/".$down["address"]."/".$down["filename"];
		if(file_exists($downurl)) $candown = true;
	}
?>
<table border=0 width=660 align=center>
<form id="form1" name="form1" method="post" action="">
<tr>
	<td valign=top align=center>
		<br>&nbsp;<br>
  学院:计算机与电子信息学院&nbsp;&nbsp;专业：<?php echo $detail["spro"]; ?>&nbsp;&nbsp;班级:<?php echo $detail["class"]; ?>&nbsp;&nbsp;学号:<?php echo $detail["student_id"]; ?><br>
<div align="center">
  <table width="660" border="1" cellpadding="5" cellspacing="0" bordercolor=#000000>
    <tr>
      <td width="424" height="46" align="left" valign="middle">设计题目：<b><?php echo $detail["topic"]; ?></b>
        <br>课题类型：<b><?php echo $detail["type"]; ?></b></td>
      <?php
         echo "<td align=center valign=middle".(!$candown?" bgcolor=red":"").">";
      	 if($candown) TeacherArchiveDown($down["year"],$down["student_pro_id"],$down["teacher_id"],$sid,$down["spmissionid"],"mydoc","<b>下载送评论文</b>");
      	 else echo "<font color=yellow><b>未申请答辩<br>或未上传论文</b></font>";
      	 echo "</td>";
      	?>
      <td align="center" valign="middle"><strong><?php echo $detail["sname"]; ?></strong></td>
    </tr>
    <tr>
      <td  rowspan="4"><b>下方填写指导老师考核意见：</b><br><textarea name="comment1" cols="58" rows="10"><?php echo $detail["comment1"]; ?></textarea></td>
      <td width="100" height="40" align="center" valign="middle"><p align="center">基本能力<br>10%</p></td>
      <td width="100" align="center" valign="middle">
      	<?php
      	if(!$candown) echo "<span onmouseover=\"showTip('学生论文未提交，不能评分！')\" onmouseout=hideTip() >0 分</span>";
      	else if($READONLY) echo "<span onmouseover=\"showTip('只读状态，不能评分！')\" onmouseout=hideTip() >".$detail["score1_1"]." 分</span>";
      	else 	echo "<input type=text  size=4 maxlength=4 name=score1_1 value=".$detail["score1_1"]." onmouseover=\"showTip('请按百分制评分，系统会自动折算！')\" onmouseout=hideTip() >分";
      	 ?>
      	 </td>
    </tr>
    <tr>
      <td width="100"><p align="center">工作能力<br>10%</p></td>
      <td width="100" align=center>
      	<?php
      	if(!$candown) echo "<span onmouseover=\"showTip('学生论文未提交，不能评分！')\" onmouseout=hideTip() >0 分</span>";
      	else if($READONLY) echo "<span onmouseover=\"showTip('只读状态，不能评分！')\" onmouseout=hideTip() >".$detail["score1_2"]." 分</span>";
      	else 	echo "<input type=text  size=4 maxlength=4 name=score1_2 value=".$detail["score1_2"]." onmouseover=\"showTip('请按百分制评分，系统会自动折算！')\" onmouseout=hideTip() >分";
      	 ?>
      	 </td>
    </tr>
    <tr>
      <td width="100"><p align="center">工作态度<br>10%</p></td>
      <td width="100" align=center>
      	<?php
      	if(!$candown) echo "<span onmouseover=\"showTip('学生论文未提交，不能评分！')\" onmouseout=hideTip() >0 分</span>";
      	else if($READONLY) echo "<span onmouseover=\"showTip('只读状态，不能评分！')\" onmouseout=hideTip() >".$detail["score1_3"]." 分</span>";
      	else 	echo "<input type=text  size=4 maxlength=4 name=score1_3 value=".$detail["score1_3"]." onmouseover=\"showTip('请按百分制评分，系统会自动折算！')\" onmouseout=hideTip() >分";
      	 ?>
      	 </td>
    </tr>
    <tr>
      <td width="200" colspan=2><p align="center"><strong>考核折算得分：<?php echo ceil(($detail["score1_1"]+$detail["score1_2"]+$detail["score1_3"])/3); ?> 分</strong></p></td>
    </tr>
    <tr>
      <td  colspan="3" align="left" height=38 valign="middle">
      	 <?php
      	$sql = "select oktopic.id,oktopic.topic,comment1,student.name from ".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher,".$TABLE."ok_topic as oktopic where teacher.teacher_id=oktopic.teacher_id &&oktopic.student_id=student.number&&teacher.teacher_id='$teacher_id'&& comment1<>'' order by id desc limit 0,10";
		$query = mysql_query($sql);
		if($sqlquery) $currrows=mysql_num_rows($sqlquery);  
		else $currrows = 0;
	if($currrows>0 && ($TMPWRITE || $CURR_YEAR==$YEAR_C)){
		echo "<font color=green>参考往届的考核意见：</font><select size=1   onChange=old_comment('comment1','comment1',this.options[this.options.selectedIndex].value)>";
		while($comfet = @mysql_fetch_array($query)){
			echo "<option value=".$comfet["id"].">".$comfet["topic"]."</option>";
		}
		echo "</select><br>";
	}
            ?></td>
    </tr>
  </table>
</div>
<?php
if($TMPWRITE||$CURR_YEAR==$YEAR_C){
?>
    <br><input type=submit name=submit value=提交指导教师考核意见与成绩>
    <input type=hidden name=sid value='<?php echo $sid;?>'>
<?php
}
?>    
	</td>
</tr>
</form>
</table>

<?php
}
?>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
