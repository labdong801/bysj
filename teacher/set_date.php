<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "设置选题日期";
$YM_ZT2 = "设置毕业设计各阶段起止日期";
$YM_MK = "毕业设计双向选题系统";
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
<script language="javascript">
function is_empty(){
  if(form1.topic_start.value==""){
    alert("教师提交选题起始时间不能为空");
    form1.topic_start.focus();
	return false;
  } 
  if(form1.topic_end.value==""){
    alert("教师提交选题截止时间不能为空");
    form1.topic_end.focus();
	return false;
  } 
  if(form1.topic_end.value<form1.topic_start.value){
    alert("教师提交选题截止日期比起始日期晚，不合理！");
    form1.topic_end.focus();
	return false;
  } 
  if(form1.student_start.value==""){
    alert("学生选题起始时间不能为空");
    form1.student_start.focus();
	return false;
  } 
  if(form1.student_end.value==""){
    alert("学生选题截止时间不能为空");
    form1.student_end.focus();
	return false;
  }   
  if(form1.student_end.value<form1.student_start.value){
    alert("学生选择教师截止日期比起始日期晚，不合理！");
    form1.student_end.focus();
	return false;
  } 
  if(form1.teacher_start.value==""){
    alert("教师选择学生起始时间不能为空");
    form1.teacher_start.focus();
	return false;
  } 
  if(form1.teacher_end.value==""){
    alert("教师选择学生结束时间不能为空");
    form1.teacher_end.focus();
	return false;
  } 
  if(form1.teacher_end.value<form1.teacher_start.value){
    alert("教师选择学生截止日期比起始日期晚，不合理！");
    form1.teacher_end.focus();
	return false;
  } 
}
</script>

<?php

      $pro_list = explode(",", $com_pro_id);  
      
      if($_POST["submit"]){
         	$set_pro_id = trim($_POST["set_pro_id"]);
             $truncateselect = $_POST["truncateselect"];
         	if(!in_array($set_pro_id,$pro_list)){
         		Show_Message("对不起，非授权操作，操作被拒绝。");  		
          	     @include($baseDIR."/bysj/inc_foot.php");
                 exit;
         	} else {  		
               $topic_start = strtotime(trim($_POST["topic_start"]));
               //echo "\$topic_start = $topic_start , ".date("Y-m-d H:i:s",$topic_start )."<br>";
       	       $topic_end = strtotime(trim($_POST["topic_end"]))+86399;
       	       $student_start = strtotime(trim($_POST["student_start"]));
       	       $student_end = strtotime(trim($_POST["student_end"]))+86399;
       	       $teacher_start = strtotime(trim($_POST["teacher_start"]));
       	       $teacher_end = strtotime(trim($_POST["teacher_end"]))+86399;
       	       $query = mysql_query("select * from ".$TABLE."set_date where pro_id = '$set_pro_id'");
       	       $row = mysql_fetch_array($query);
       	       if($row["pro_id"]==$set_pro_id){
                     mysql_query("update ".$TABLE."set_date set topic_start = '$topic_start',topic_end = '$topic_end',student_start = '$student_start',student_end = '$student_end',teacher_start = '$teacher_start',teacher_end = '$teacher_end' where pro_id = '$set_pro_id'");
                     
       	       }else{
       	             mysql_query("insert into ".$TABLE."set_date(topic_start,topic_end,student_start,student_end,teacher_start,teacher_end,pro_id) values ('$topic_start','$topic_end','$student_start','$student_end','$teacher_start','$teacher_end','$set_pro_id')");
       	       }
       	       $setresult = 0;
       	       if(mysql_affected_rows()>0)  $setresult = 1;
       	       else $setresult = -1;
       	       if($truncateselect=="ON") mysql_query("delete from `".$TABLE."student_select`  where pro_id='$set_pro_id'");
       	  }
      }      
  
         $majiorlist = get_majior_list($com_pro);
	 $curr_pro_id = $set_pro_id;
	 echo "请选择要设置的专业：";
	 $pro_name = "";
	 while(list($k,$v)=each($majiorlist)){
	 	   if(in_array($k,$pro_list)&&$v[open]){
	 	   	   if($curr_pro_id ==0) $curr_pro_id = $k;
	 	   	   if($curr_pro_id == $v["id"]){
	 	   	   	    echo "[<b>".$v["name"]."</b>]";
			 	    $pro_name = $v["name"];
	 	   	   } else echo "[<a href=".$PHP_SELF."?set_pro_id=".$k."><font color=blue><u>".$v["name"]."</u></font></a>]";
	 	   	   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	 	   }
 	 }
      	 
	 $sql = "select * from ".$TABLE."set_date where pro_id = '$curr_pro_id'";
	 $que_sql = mysql_query($sql);
	 $row = mysql_fetch_array($que_sql);
?>

<form name="form1" action="<?php echo $PHP_SELF; ?>" method="post">
 <br>您正在设置 <b><?php echo $pro_name; ?></b> 专业各阶段起止日期<br>
 <?php if($row["student_start"]<10000) echo "<font color=red><b>提示：</b>当前专业尚未设置任何日期。若需设置，请点击“修改选题时段”按钮！</font> <br>"; ?>
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
<tr><td colspan=3 align=center height=38><b>请谨慎选择：</b><input type=checkbox name=truncateselect value='ON'> <b>转入下一轮选题，<font color=red>立即清空</font>学生志愿</b></td></tr>
</table>

<?php
if($pro_name!=""){
?>
 <?php if($row["student_start"]<10000) echo "<br><font color=red><b>提示：</b>当前专业尚未设置任何日期。若需设置，请点击“修改选题时段”按钮！</font> <br>"; ?>
	<br><input type=hidden name=set_pro_id value=<?php echo $curr_pro_id; ?>>	
	<input type="submit" name="submit" value="修改选题时段" onclick="return is_empty()">
<?php
} else {
	 echo "<br><input type=button value=请选择要修改的专业 disabled>";
}
?>
</form>
<?php
       	       if($setresult>0)echo ("<font color=green><b>设置选题日期成功！".($truncateselect=="ON"?"已执行清空志愿指令！":"")."</b></font><br><br>");
       	       else if($setresult<0)  echo("<font color=red>日期没有改变，或修改失败！".($truncateselect=="ON"?"已执行清空志愿指令！":"")."</font><br><br>");
       	       else;
?>
<table width="500">
<tr>
<td align="center">
  <span class="STYLE2">注意：时间的输入格式为：XXXX-XX-XX，如<?php echo date("Y-m-d");?></span></td>
</tr>
</table>


<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>