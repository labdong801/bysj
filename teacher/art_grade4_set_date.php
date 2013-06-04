<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "设置选题日期";
$YM_ZT2 = "毕业设计时间设置";
$YM_MK = "艺术系课程双向选择系统";
$YM_PT ="全局设定";
$YM_DH = 1; //需要导航条
$YM_QX = 40; //本页访问需要权限:专业主任
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;

function ShowDateHint($dtime)
{
	$now = time(0);
	$now = $now - $now%86400;
	$dtime = $dtime - $dtime%86400;
	$cnt = ($dtime-$now)/86400;
	echo "&nbsp;(";
	if($cnt>330) echo "<font color=red>穿越中，请报告</font>";
	else if($cnt>120) echo "距今 $cnt 天！";
	else if($cnt>61)  echo "两个月后";
	else if($cnt>30)  echo "一个月后";
	else if($cnt>2)  echo "$cnt 天后";
	else if($cnt==2) echo "后天";
	else if($cnt==1) echo "明天";
	else if($cnt==0) echo "今天";
	else if($cnt>-7) echo "<font color=blue>距今已过去 ".(-1*$cnt)." 天</font>";
	else if($cnt>-15) echo "<font color=blue>距今已过去一周</font>";
	else if($cnt>-31) echo "<font color=blue>距今已过半个月</font>";
	else if($cnt>-61) echo "<font color=blue>距今已过一个月</font>";
	else if($cnt>-200) echo "距今已过去 ".(-1*$cnt)." 天";
	else if($cnt>-560) echo "<font color=red>去年的设置？</font>";
	else if($cnt>-860) echo "<font color=red>前年的设置？</font>";
	else if($cnt>-15640) echo "<font color=red>年代久远</font>";
	else echo "时间未设置，请设置";
	echo ")";
}
 ?>
<script language="JavaScript" src="/bysj/images/My97DatePicker/WdatePicker.js" defer="defer"></script>  


<?php

      $pro_list = explode(",", $com_pro_id);  
      
      if($_POST["submit"]){
         	//表单处理、
         //print_r($_POST);
         $topic_start = strtotime(trim($_POST["topic_start"]));
       	 $topic_end = strtotime(trim($_POST["topic_end"]))+86399;
         $student_start = strtotime(trim($_POST["student_start"]));
       	 $student_end = strtotime(trim($_POST["student_end"]))+86399;
       	 $teacher_start = strtotime(trim($_POST["teacher_start"]));
       	 $teacher_end = strtotime(trim($_POST["teacher_end"]))+86399;
       	 if($_POST['topic_start'] == "")
       	 {
       	 	echo "<script language='JavaScript' >alert('教师提交选题起始时间不能为空！');</script>";
       	 }
       	 else if($_POST['topic_end'] == "")
       	 {
       	 	echo "<script language='JavaScript' >alert('教师提交选题结束时间不能为空！');</script>";
       	 }
       	 else if($topic_end <= $topic_start)
       	 {
       	 	echo "<script language='JavaScript' >alert('教师提交选题结束时间小于起始时间！');</script>";
       	 }
         else if($_POST['student_start']=="")
         {
         	echo "<script language='JavaScript' >alert('学生选课题起始时间不能为空！');</script>";
         }
         else if($_POST['student_end']=="")
         {
         	echo "<script language='JavaScript' >alert('学生选课题结束时间不能为空！');</script>";
         }
         else if($student_end <= $student_start)
         {
         	echo "<script language='JavaScript' >alert('学生选课题结束时间小于起始时间！');</script>";
         }
         else if($_POST['teacher_start']=="")
         {
         	echo "<script language='JavaScript' >alert('教师选学生起始时间不能为空！');</script>";
         }
         else if($_POST['teacher_end']=="")
         {
         	echo "<script language='JavaScript' >alert('教师选学生结束时间不能为空！');</script>";
         }
         else if($teacher_end <= $teacher_start)
         {
         	echo "<script language='JavaScript' >alert('教师选学生结束时间小于起始时间！');</script>";
         }
         else
         {
         	//排除所有时间不合里的因素，开始记录数据库
         	$sql = "UPDATE `".$ART_TABLE."set_date` SET `topic_start`='".$topic_start."',`topic_end`='".$topic_end."',`student_start` = '".$student_start."',`student_end` = '".$student_end."',`teacher_start`='".$teacher_start."',`teacher_end`='".$teacher_end."'  WHERE `grade` =4;";
         	mysql_query($sql);
         }
         
      }      
      else if($_POST["clean"]){
      	$sql = "UPDATE `".$ART_TABLE."set_date` SET `topic_start`='0',`topic_end`='0',`student_start` = '0',`student_end` = '0',`teacher_start`='0',`teacher_end`='0'  WHERE `grade` =4;";
      	mysql_query($sql);
      }
//  
//     $majiorlist = get_majior_list($com_pro);
//	 $curr_pro_id = $set_pro_id;
//	 echo "请选择要设置的专业：";
//	 $pro_name = "";
//	 while(list($k,$v)=each($majiorlist)){
//	 	   if(in_array($k,$pro_list)&&$v[open]){
//	 	   	   if($curr_pro_id ==0) $curr_pro_id = $k;
//	 	   	   if($curr_pro_id == $v["id"]){
//	 	   	   	    echo "[<b>".$v["name"]."</b>]";
//			 	    $pro_name = $v["name"];
//	 	   	   } else echo "[<a href=".$PHP_SELF."?set_pro_id=".$k."><font color=blue><u>".$v["name"]."</u></font></a>]";
//	 	   	   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//	 	   }
// 	 }
//      	 
	 $sql = "select * from ".$ART_TABLE."set_date where grade = '4'";
	 $que_sql = mysql_query($sql);
	 $row = mysql_fetch_array($que_sql);
?>
<p>
<a href="art_grade1_set_date.php"><font color=blue>[器乐选修时间设置]</font></a>
<a href="art_grade2_set_date.php"><font color=blue>[钢琴、声乐时间设置]</font></a>
<a href="art_grade3_set_date.php"><font color=blue>[主修方向时间设置]</font></a>
<a href="art_grade4_set_date.php"><font color=blue>[毕业设计时间设置]</font></a>
</p>
<form name="form1" action="<?php echo $PHP_SELF; ?>" method="post">

 <?php if($row["student_start"]<10000) echo "<font color=red><b>提示：</b>当前尚未设置任何日期。若需设置，请点击“修改选题时段”按钮！</font> <br>"; ?>
 <br>
<table width="600" border="1" cellpadding="6" bordercolor=#000000>
<tr>
<td rowspan="2" width="128"><div align="center" width><span class="STYLE1"><FONT color=red size=+2 face=黑体><B>1.</B></FONT>教师提交选题</span></div></td>
<td width="100">起始时间：</td>
<td><input type="text" name="topic_start"  value="<?php echo date("Y-m-d",$row["topic_start"]>0?$row["topic_start"]:time(0));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["topic_start"]); ?></td>
</tr>
<tr>
<td>截止时间：</td>
<td><input type="text" name="topic_end"   value="<?php echo date("Y-m-d",$row["topic_end"]>0?$row["topic_end"]:(time(0)+5*86400));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["topic_end"]); ?></td>
</tr>
<tr>
<td rowspan="2"><div align="center"><span class="STYLE1"><FONT color=red size=+2 face=黑体><B>2.</B></FONT>学生选择课题</span></div></td>
<td width="100">起始时间：</td>
<td><input type="text" name="student_start"  value="<?php echo date("Y-m-d",$row["student_start"]>0?$row["student_start"]:(time(0)+6*86400));?>"   onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["student_start"]); ?></td>
</tr>
<tr>
<td>截止时间：</td>
<td><input type="text" name="student_end"  value="<?php echo date("Y-m-d",$row["student_end"]>0?$row["student_end"]:(time(0)+8*86400));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["student_end"]); ?></td>
</tr>
<tr>
<td rowspan="2"><div align="center"><span class="STYLE1"><FONT color=red size=+2 face=黑体><B>3.</B></FONT>教师选择学生</span></div></td>
<td width="100">起始时间：</td>
<td><input type="text" name="teacher_start" value="<?php echo date("Y-m-d",$row["teacher_start"]>0?$row["teacher_start"]:(time(0)+9*86400));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["teacher_start"]); ?></td>
</tr>
<tr>
<td>截止时间：</td>
<td><input type="text" name="teacher_end"  value="<?php echo date("Y-m-d",$row["teacher_end"]>0?$row["teacher_end"]:(time(0)+13*86400));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["teacher_end"]); ?></td>
</tr>

</table>


 <?php if($row["student_start"]<10000) echo "<br><font color=red><b>提示：</b>当前专业尚未设置任何日期。若需设置，请点击“修改选题时段”按钮！</font> <br>"; ?>
	<br><input type=hidden name=set_pro_id value=<?php echo $curr_pro_id; ?>>	
	<input type="submit" name="submit" value="修改选题时段">
	<input type="submit" name="clean" value="清空时间设置">
</form>

<table width="500">
<tr>
<td align="center">
  <span class="STYLE2">注意：时间的输入格式为：XXXX-XX-XX，如<?php echo date("Y-m-d");?></span></td>
</tr>
</table>


<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>