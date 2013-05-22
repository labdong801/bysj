<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "考核环节：评阅";
$YM_ZT2 = "考核环节：评阅教师评定学生毕业设计情况";
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
 	$score2_1 = $_POST["score2_1"];
 	$score2_2 = $_POST["score2_2"];
 	$score2_3 = $_POST["score2_3"];
	$nums1 = array("０","１","２","３","４","５","６","７","８","９");
	$nums2 = array("0","1","2","3","4","5","6","7","8","9");
 	$score2_1 = str_replace($nums1,$nums2,$score2_1);
 	$score2_2 = str_replace($nums1,$nums2,$score2_2);
 	$score2_3 = str_replace($nums1,$nums2,$score2_3);
 	$comment2 = $_POST["comment2"];

    if($score2_1>100) $score2_1 = 100;  if($score2_1<0) $score2_1 = 0;
    if($score2_2>100) $score2_2 = 100;  if($score2_2<0) $score2_2 = 0;
    if($score2_3>100) $score2_3 = 100;  if($score2_3<0) $score2_3 = 0;

 	
 	$comment2 = HTMLSpecialChars($comment2); 	
 	$topic = HTMLSpecialChars($topic); 	
	if($READONLY){
		$sql = "update ".$TABLE."ok_topic set
			comment2 = '$comment2'
			where student_id = '$sid' && teacher2_id = '$teacher_id'";
	} else {
		$sql = "update ".$TABLE."ok_topic set
            score2_1 = '$score2_1',
            score2_2 = '$score2_2',
            score2_3 = '$score2_3',
			comment2 = '$comment2'
			where student_id = '$sid' && teacher2_id = '$teacher_id'";
	}
          
/*/            
    $sql = "update ".$TABLE."ok_topic set 
            type = '$type',
            topic = '$topic',
            score2_1 = '$score2_1',
            score2_2 = '$score2_2',
            score2_3 = '$score2_3',
            comment2 = '$comment2'
            where student_id = '$sid' && teacher2_id = '$teacher_id'";
 */
   $open = mysql_query($sql);
   
   //以下为上传评阅反馈意见部分
	$uploadret = false;
	if(is_uploaded_file($_FILES["uploadfile"]["tmp_name"])){
		$upfile = $_FILES["uploadfile"];
		$name = $upfile["name"];
		$tmp_name = $upfile["tmp_name"];
		$error = $upfile["error"];
		if(!file_exists("../../../Docs/".$CURR_YEAR."/LunWenPingYue")){
			mkdir("../../../Docs/".$CURR_YEAR."/LunWenPingYue",0700);
		}
		$tmp_type1=".".substr(strrchr($name,"."),1);
		$filename = $sid.$tmp_type1;
		$destination = "../../../Docs/".$CURR_YEAR."/LunWenPingYue/".$filename;
		if($error=='0')	$uploadret = move_uploaded_file($tmp_name,$destination);
	}
	if(!$uploadret) 	$filename = "";
	else {
		$sql = "select pyfilename  from ".$TABLE."ok_topic where student_id = '$sid'";
		$chk_que = mysql_query($sql);
		$chk_fet = @mysql_fetch_array($chk_que);
		$oldfilename = $chk_fet["pyfilename"];
		$sql = "update ".$TABLE."ok_topic set pyfilename='$filename' where student_id = '$sid'";
		$update = mysql_query($sql);
	}
	if($uploadret) $msg = "<font color=blue><b>您的反馈意见已成功更新</b></font>";
	else	$msg = "<font color=red><b>本次未上传反馈，或上传未成功</b></font>";
	if($uploadret&&$filename!=$oldfilename&&$oldfilename!=""){
		$path = "../../../Docs/".$CURR_YEAR."/LunWenPingYue/".$oldfilename;
		$delfile = @unlink($path);
	}
}

echo "<script  type=\"text/javascript\" src=\"ajax_js_teacher.js\"></script>";
?>
<table width="660" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor=#000000>
<tr>
<td colspan=5>
	<font class=bigdate ><strong><font color=blue>2.&nbsp;&nbsp;评阅&nbsp;&nbsp;</font></strong></font>
	以下是您评阅的学生清单，请对他们的毕业论文撰写情况进行评价</td>
</tr>
<?php
$fenshu = "ceil((score2_1*8+score2_2*6+score2_3*6)/20) as score";
 $sql = "select student_id,oktopic.fenzu,oktopic.teacher2_id,student.name as sname,teacher.name as tname,".$fenshu."  from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher where oktopic.student_id=student.number&&student.year=$CURR_YEAR&&oktopic.teacher2_id=teacher.teacher_id&&oktopic.teacher2_id='".$teacher_id."' order by student_id";
 //echo $sql;
 $sqlquery = mysql_query($sql);
  if($sqlquery) $currrows=mysql_num_rows($sqlquery);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=5 height=68 align=center>对不起，答辩秘书还没有给您安排论文评阅任务，请稍候再查看！</td></tr>";
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
   score1_1,score1_2,score1_3,score2_1,score2_2,score2_3,score3_1,score3_2,score3_3,score3_4,pyfilename,
   comment1,comment2,comment3,comment4
   from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher where oktopic.student_id=student.number&&oktopic.teacher2_id=teacher.teacher_id&&oktopic.student_id='".$sid."'&&oktopic.teacher2_id='".$teacher_id."'";
//echo $sql;
 $sqlquery = mysql_query($sql);
 $detail = mysql_fetch_array($sqlquery);
 if($detail["student_id"]=="") $showit = false;

/////////下方是成绩考核表展示区
if($showit){
	if($detail["type"]=="科学研究") $typeclass = 1;
	else $typeclass = 0;
	
    $score1_1 = $detail["score1_1"]*10.0/100.0;
     $score1_2 = $detail["score1_2"]*10.0/100.0;
     $score1_3 = $detail["score1_3"]*10.0/100.0;
     $score2_1 = $detail["score2_1"]*8.0/100.0;
     $score2_2 = $detail["score2_2"]*6.0/100.0;
     $score2_3 = $detail["score2_3"]*6.0/100.0;
     
    $score1_1 = ceil($score1_1*10)/10.0;
    $score1_2 = ceil($score1_2*10)/10.0;
    $score1_3 = ceil($score1_3*10)/10.0;
    $score2_1 = ceil($score2_1*10)/10.0;
    $score2_2 = ceil($score2_2*10)/10.0;
    $score2_3 = ceil($score2_3*10)/10.0;

	 $score1 = $score1_1+$score1_2+$score1_3;
	 $score2 = $score2_1+$score2_2+$score2_3;

	$items = array(
	     array("计算实验<br>创新 8%","设计说明<br>书 6%","图纸<br> 6%"),
	     array("方案论证<br>创新 8%","论文说明<br>书 6%","解决问题<br>能力 6%")
	     );
	$downsql = "select address,filename,oktopic.teacher_id,spmissionid,oktopic.student_pro_id,oktopic.year,name from ".$TABLE."mission_list as list,".$TABLE."mission_log as log,".$TABLE."ok_topic as oktopic where list.mission_id=oktopic.spmissionid &&oktopic.student_id=log.student_id&& log.mission_id=list.mission_id &&  log.student_id = '$sid'";
	$downquery = mysql_query($downsql);
	$down = mysql_fetch_array($downquery);	
	$candown = false;
	if($down["filename"]!=""){
		$downurl = "../../../Docs/".$down["year"]."/".$down["address"]."/".$down["filename"];
		if(file_exists($downurl)) $candown = true;
	}	
?>
<table border=0 width=660 align=center>
<form id="form1" name="form1" method="post" action=""  enctype="multipart/form-data">
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
      <td  rowspan="4"><b>下方填写评阅情况考核意见：</b><br>
            <textarea name="comment2" cols="58" rows="10"><?php echo $detail["comment2"]; ?></textarea>      </td>
      <td width="100" height="40" align="center" valign="middle"><p align="center"><?php echo $items[$typeclass][0];?></p></td>
      <td width="100" align="center" valign="middle">
      	<?php
      	if(!$candown) echo "<span onmouseover=\"showTip('学生论文未提交，不能评分！')\" onmouseout=hideTip() >0 分</span>";
      	else if($READONLY) echo "<span onmouseover=\"showTip('只读状态，不能评分！')\" onmouseout=hideTip() >".$detail["score2_1"]." 分</span>";
      	else 	echo "<input type=text  size=4 maxlength=4 name=score2_1 value=".$detail["score2_1"]." onmouseover=\"showTip('请按百分制评分，系统会自动折算！')\" onmouseout=hideTip() >分";
      	 ?>
      	 </td>
    </tr>
    <tr>
      <td width="100"><p align="center"><?php echo $items[$typeclass][1];?></p></td>
      <td width="100" align=center>
      	<?php
      	if(!$candown) echo "<span onmouseover=\"showTip('学生论文未提交，不能评分！')\" onmouseout=hideTip() >0 分</span>";
      	else if($READONLY) echo "<span onmouseover=\"showTip('只读状态，不能评分！')\" onmouseout=hideTip() >".$detail["score2_2"]." 分</span>";
      	else 	echo "<input type=text  size=4 maxlength=4 name=score2_2 value=".$detail["score2_2"]." onmouseover=\"showTip('请按百分制评分，系统会自动折算！')\" onmouseout=hideTip() >分";
      	 ?>
      	 </td>
    </tr>
    <tr>
      <td width="100"><p align="center"><?php echo $items[$typeclass][2];?></p></td>
      <td width="100" align=center>
      	<?php
      	if(!$candown) echo "<span onmouseover=\"showTip('学生论文未提交，不能评分！')\" onmouseout=hideTip() >0 分</span>";
      	else if($READONLY) echo "<span onmouseover=\"showTip('只读状态，不能评分！')\" onmouseout=hideTip() >".$detail["score2_3"]." 分</span>";
      	else 	echo "<input type=text  size=4 maxlength=4 name=score2_3 value=".$detail["score2_3"]." onmouseover=\"showTip('请按百分制评分，系统会自动折算！')\" onmouseout=hideTip() >分";
      	 ?>
      	 </td>
    </tr>
    <tr>
      <td width="200" colspan=2><p align="center"><strong>评阅折算得分：<?php echo ceil($score2*5); ?> 分</strong><br>
      (指导教师考核参考：<?php echo ceil($score1*10/3); ?> 分)
      </p></td>
    </tr>
    <tr>
      <td  colspan="3" align="left" height=38 valign="middle"><?php
      	$sql = "select oktopic.id,oktopic.topic,comment2,student.name from ".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher,".$TABLE."ok_topic as oktopic where teacher.teacher_id=oktopic.teacher2_id &&oktopic.student_id=student.number&&teacher.teacher_id='$teacher_id'&& comment2<>''order by id desc  limit 0,10";
		$query = mysql_query($sql);
		if($sqlquery) $currrows=mysql_num_rows($sqlquery);  
		else $currrows = 0;
	if($currrows>0  && ($TMPWRITE || $CURR_YEAR==$YEAR_C)){
		echo "<font color=green>参考往届的评阅意见：</font><select size=1   onChange=old_comment('comment2','comment2',this.options[this.options.selectedIndex].value)>";
		while($comfet = @mysql_fetch_array($query)){
			echo "<option value=".$comfet["id"].">".$comfet["topic"]."</option>";
		}
		echo "</select><br>";
	}
            ?> 上传评阅的反馈意见：<input type="file" name="uploadfile"  size=23 /><span onmouseover="showTip('您可以把反馈意见录入到一个文档中上传，也可以直接在学生的送评论文上采用“修订”的方式标明需要修改的地方，然后在此处上传，谢谢！')" onmouseout=hideTip() >(<?php echo $msg?$msg:("<font color=blue><u>".($detail["pyfilename"]?"您已上传意见，还可以更新评阅意见":"如何反馈意见给学生？")."</u></font>");?>)</span></td>
    </tr>
  </table>
</div>
<?php
if($TMPWRITE || $CURR_YEAR==$YEAR_C){
?>
    <br><input type=submit name=submit value=提交评阅教师评阅意见与成绩>
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