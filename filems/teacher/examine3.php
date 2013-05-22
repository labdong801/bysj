<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "考核环节：答辩";
$YM_ZT2 = "考核环节：答辩小组评定学生毕业设计情况";
$YM_MK = "毕业设计答辩管理系统";
$YM_PT = "答辩系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;

if($com_auth!=20) $seemy = "yeah";
?>
<?php
$sid = $_GET["sid"];
if($_POST["sid"]!="")$sid = $_POST["sid"];
if($_POST["submit"]){
	//提交考核表进行的操作
 	//$type = $_POST["type"];
 	//$topic = $_POST["topic"];
 	//$score3_1 = $_POST["score3_1"];
 	//$score3_2 = $_POST["score3_2"];
 	//$score3_3 = $_POST["score3_3"];
 	//$score3_4 = $_POST["score3_4"];
	//$nums1 = array("０","１","２","３","４","５","６","７","８","９");
	//$nums2 = array("0","1","2","3","4","5","6","7","8","9");
 	//$score3_1 = str_replace($nums1,$nums2,$score3_1);
 	//$score3_2 = str_replace($nums1,$nums2,$score3_2);
 	//$score3_3 = str_replace($nums1,$nums2,$score3_3);
 	//$score3_4 = str_replace($nums1,$nums2,$score3_4);
 	$comment3 = $_POST["comment3"];
 	$comment4 = $_POST["comment4"];

/*
    $autoavg = $_POST["autoavg"];
    if($autoavg == "ON"){  //自动更新成绩
    	   $sql = "select student_id,avg(score1) as score1,avg(score2) as score2,avg(score3) as score3,avg(score4) as score4 from ".$TABLE."examine3 where student_id = '".$sid."'&&(score1>0&&score2>0&&score3>0)  group by student_id";
    	   //echo $sql;
    	   $sql_query = mysql_query($sql);
    	   $tmpavg = mysql_fetch_array($sql_query);
    	   $score3_1 = ceil($tmpavg["score1"]*10)/10.0;
    	   $score3_2 = ceil($tmpavg["score2"]*10)/10.0;
    	   $score3_3 = ceil($tmpavg["score3"]*10)/10.0;
    	   $score3_4 = ceil($tmpavg["score4"]*10)/10.0;
    	   //echo $tmpavg["score1"];
    }


    if($score3_1>100) $score3_1 = 100;  if($score3_1<0) $score3_1 = 0;
    if($score3_2>100) $score3_2 = 100;  if($score3_2<0) $score3_2 = 0;
    if($score3_3>100) $score3_3 = 100;  if($score3_3<0) $score3_3 = 0;
    if($score3_4>100) $score3_4 = 100;  if($score3_4<0) $score3_4 = 0;
*/ 	
 	$comment3 = HTMLSpecialChars($comment3); 	
 	$comment4 = HTMLSpecialChars($comment4); 	
 	//$topic = HTMLSpecialChars($topic); 	
/*禁止修改题目、类型、分数  	
    $sql = "update ".$TABLE."ok_topic set 
            score3_1 = '$score3_1',
            score3_2 = '$score3_2',
            score3_3 = '$score3_3',
            score3_4 = '$score3_4',
            comment3 = '$comment3',
            comment4 = '$comment4'
            where student_id = '$sid' && (fenzu = '".$com_fenzu."')";
*/            

    $sql = "update ".$TABLE."ok_topic set 
            comment3 = '$comment3',
            comment4 = '$comment4'
            where student_id = '$sid' && (fenzu = '".$com_fenzu."')";
   $open = mysql_query($sql);
}

echo "<script  type=\"text/javascript\" src=\"ajax_js_teacher.js\"></script>";
echo "<script>
function update_comment(no){
      old_comment2('comment3','comment4','comment3,comment4',no);
}
</script>";
?>
<table width="660" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor=#000000>
<tr>
<td colspan=5>
	<font class=bigdate ><strong><font color=green>3.&nbsp;&nbsp;综合&nbsp;&nbsp;</font></strong></font>
	以下是您负责答辩的学生清单，请您对他们的答辩情况进行综合评价
	<?php
	    if($com_auth==20){
			if($seemy!="yeah")	  echo "[<a href=".$PHP_SELF."?seemy=yeah>只看自己的</a>]";
			else 	  echo "[<a href=".$PHP_SELF.">看本小组全部</a>]";
		}
	?>
	</td>
</tr>
<?php
if($seemy!="yeah")  $tiaojian = "&& oktopic.fenzu = '".$com_fenzu."'";  //有点问题
else $tiaojian = "&& oktopic.teacher2_id = '".$teacher_id."'";
//echo $tiaojian;
 $sql = "select student_id,oktopic.fenzu,oktopic.teacher2_id,student.name as sname,score3_1,score3_2,score3_3,score3_4,type  from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student where oktopic.student_id=student.number&&student.year=$CURR_YEAR".$tiaojian." order by student_id";
//echo $sql;
 $sqlquery = mysql_query($sql);
  if($sqlquery) $currrows=mysql_num_rows($sqlquery);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=5 height=68 align=center>对不起，答辩秘书还没有给您安排论文评阅任务，所以此处也看不到您需要负责的学生名单！</td></tr>";
  }  
  $cnt = 0;
while($row = mysql_fetch_array($sqlquery)){
	if($cnt%5==0) echo "<tr>";
	if($row["type"]=="科学研究") $hisscore = ($row["score3_1"]*15+$row["score3_2"]*15+$row["score3_3"]*20)/50;
	else $hisscore = ($row["score3_1"]*10+$row["score3_2"]*10+$row["score3_3"]*15+$row["score3_4"]*15)/50;
	$hisscore = ceil($hisscore);
     echo "<td width=130 align=center><a href=".$PHP_SELF."?seemy=$seemy&sid=".$row["student_id"]."><font color=blue><u>".$row["sname"]."</u></font></a>(".$hisscore.")</td>";
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
   from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher where oktopic.student_id=student.number&&oktopic.teacher2_id=teacher.teacher_id&&oktopic.student_id='".$sid."'".$tiaojian;
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
	 if($typeclass==1){
         $score3_1 = $detail["score3_1"]*15.0/100.0;
         $score3_2 = $detail["score3_2"]*15.0/100.0;
         $score3_3 = $detail["score3_3"]*20.0/100.0;
         $score3_4 = 0;
     } else {
         $score3_1 = $detail["score3_1"]*10.0/100.0;
         $score3_2 = $detail["score3_2"]*10.0/100.0;
         $score3_3 = $detail["score3_3"]*15.0/100.0;
         $score3_4 = $detail["score3_4"]*15.0/100.0;
    }
     
    $score1_1 = ceil($score1_1*10)/10.0;
    $score1_2 = ceil($score1_2*10)/10.0;
    $score1_3 = ceil($score1_3*10)/10.0;
    $score2_1 = ceil($score2_1*10)/10.0;
    $score2_2 = ceil($score2_2*10)/10.0;
    $score2_3 = ceil($score2_3*10)/10.0;
    $score3_1 = ceil($score3_1*10)/10.0;
    $score3_2 = ceil($score3_2*10)/10.0;
    $score3_3 = ceil($score3_3*10)/10.0;
    $score3_4 = ceil($score3_4*10)/10.0;

	 $score1 = $score1_1+$score1_2+$score1_3;
	 $score2 = $score2_1+$score2_2+$score2_3;
	 $score3 = $score3_1+$score3_2+$score3_3+$score3_4;
	 $totalscore = ceil($score1 + $score2 + $score3);


	$items = array(
	     array("设计说明<br>书 10%","图纸<br>10%","解决问题<br>能力 15%","答辩<br>15%"),
	     array("论文说明<br>书 15%","解决问题<br>能力 15%","答辩<br>20%")
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
      <td  rowspan="<?php echo $typeclass?4:5?>" height="160"  valign=top><b>下方填写答辩情况考核意见：</b><br>
            <textarea name="comment3" cols="58" rows="7"><?php echo $detail["comment3"]; ?></textarea>
            <strong>请对学生的毕业设计进行<font color=green>综合评价</font>：</strong><br>
        <textarea name="comment4" cols="58" rows="6"><?php echo $detail["comment4"]; ?></textarea>
            </td>
      <td width="100" height="30" align="center" valign="middle"><p align="center"><?php echo $items[$typeclass][0];?></p></td>
      <td width="120" align="center" valign="middle">
      	<?php
      	//echo "<input type=text  size=4 maxlength=4 name=score3_1 value=".$detail["score3_1"]." onmouseover=\"showTip('请按百分制评分，系统会自动折算！')\" onmouseout=hideTip() >分";
      	echo $detail["score3_1"];
      	 ?>
      	 </td>
    </tr>
    <tr>
      <td width="100" height="30" ><p align="center"><?php echo $items[$typeclass][1];?></p></td>
      <td width="120" align="center" >
      	<?php
      	//echo "<input type=text  size=4 maxlength=4 name=score3_2 value=".$detail["score3_2"]." onmouseover=\"showTip('请按百分制评分，系统会自动折算！')\" onmouseout=hideTip() >分";
      	echo $detail["score3_2"];
      	 ?>
      	 </td>
    </tr>
    <tr>
      <td width="100" height="30" ><p align="center"><?php echo $items[$typeclass][2];?></p></td>
      <td width="120" align="center" >
      	<?php
      	//echo "<input type=text  size=4 maxlength=4 name=score3_3 value=".$detail["score3_3"]." onmouseover=\"showTip('请按百分制评分，系统会自动折算！')\" onmouseout=hideTip() >分";
      	echo $detail["score3_3"];
      	 ?>
      	 </td>
    </tr>
<?php
if($typeclass==0){
?>
    <tr>
      <td width="100" height="30" ><p align="center"><?php echo $items[$typeclass][3];?></p></td>
      <td width="120" align="center" >
      	<?php
      	//echo "<input type=text  size=4 maxlength=4 name=score3_4 value=".$detail["score3_4"]." onmouseover=\"showTip('请按百分制评分，系统会自动折算！')\" onmouseout=hideTip() >分";
      	echo $detail["score3_4"];
      	 ?>
      	 </td>
    </tr>
 <?php
} else {
	//echo "<input type=hidden name=score3_4 value=0>";
}
?>    
    <tr>
      <td width="220" colspan=2 height="30" ><p align="center"><strong>答辩折算得分：
      	<?php 
      	echo ceil($score3*2); 
      	?> 分</strong><br>
      	<?php
      	if(ceil($score3*2)<10) echo "<font color=green><b>请等待秘书计算答辩得分后再评</b></font>";
      	//echo "<input type=checkbox name=autoavg value=ON ".($score3<10?" checked":"")."  onmouseover=\"showTip('若选中此项，则系统自动根据“小组答辩成绩”中的评分计算平均值；<br>若不选中，则以您输入具体评分为准（即手工录入）！')\" onmouseout=hideTip() ><span   onmouseover=\"showTip('若选中此项，则系统自动根据“小组答辩成绩”中的评分计算平均值；<br>若不选中，则以您输入具体评分为准（即手工录入）！')\" onmouseout=hideTip()> <font color=green><b>自动计算小组平均分</b></font></span><br>";
      	?>
       (指导教师考核参考：<?php echo ceil($score1*10/3); ?> 分)<br>
      (评阅教师评阅参考：<?php echo ceil($score2*5); ?> 分)
      </p></td>
    </tr>
    <tr>
      <td  colspan="2" align="left" height=38 valign="middle"><?php
      	$sql = "select oktopic.id,oktopic.topic,student.name from ".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher,".$TABLE."ok_topic as oktopic where teacher.teacher_id=oktopic.teacher2_id &&oktopic.student_id=student.number&&teacher.teacher_id='$teacher_id'&& comment3<>''order by id desc  limit 0,10";
		$query = mysql_query($sql);
		if($sqlquery) $currrows=mysql_num_rows($sqlquery);  
		else $currrows = 0;
	if($currrows>0  && ($TMPWRITE || $CURR_YEAR==$YEAR_C)){
		echo "<font color=green>参考往届的答辩意见：</font><select size=1   onChange=update_comment(this.options[this.options.selectedIndex].value)>";
		while($comfet = @mysql_fetch_array($query)){
			echo "<option value=".$comfet["id"].">".$comfet["topic"]."</option>";
		}
		echo "</select><br>";
	}
            ?></td>
      <td align="center" valign="middle"><strong>
      	<?php 
      	    $dengji = array("不及格","及格","中等","良好","优秀");
            $ji = ($totalscore-50-$totalscore%10)/10;
            if($ji < 0) $ji = 0;
            if($ji >4) $ji = 4;
      	    echo "综合".$totalscore."分<br> (".$dengji[$ji].")"; 
      	?>
      	</strong></td>
    </tr>    
  </table>
</div>
<?php
if($TMPWRITE || $CURR_YEAR==$YEAR_C){
?>
    <br><input type=submit name=submit value=提交答辩小组答辩意见与成绩>
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
