<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "查看学生签到情况";
$YM_MK = "毕业设计管理系统";
$YM_DH = 0; //需要导航条
$YM_QX = 10; //本页访问需要权限：指导教师
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
<?php
if($view == "all") $viewurl = " (<a href=".$PHP_SELF."><font color=blue><u>只看最新的</u></font></a>)";
else $viewurl = " (<a href=".$PHP_SELF."?view=all><font color=blue><u>签到历史记录</u></font></a>)";
if($com_auth<80){
	$show = "";
	$showallurl = "";
} else {
	if($show == "all") {
		$showallurl = " (<a href=".$PHP_SELF."><font color=blue><u>只看自己的</u></font></a>)";
		$viewurl  = "";
	} else $showallurl = " (<a href=".$PHP_SELF."?show=all><font color=blue><u>全部签到信息</u></font></a>)";
}
?>
	<br><br><font size=+2 face=黑体><b>毕业设计管理系统 学生签到情况</b></font><?php echo $showallurl."  ".$viewurl;?><br><br>
  <table width=<?php echo $show=="all"?980:900;?> height="206" border="1" cellpadding="8" cellspacing="0" bordercolor="#000000">
  	<tr  bgColor=#5a6e8f align=center>
  		<td width=30><font color=#FFFFFF>序号</font></td>
  		<td width=90><font color=#FFFFFF>班级</font></td>
  		<td width=60><font color=#FFFFFF>学生姓名</font></td>
  		<td width=90><font color=#FFFFFF>最新签到时间</font></td>
  		<td width=100><font color=#FFFFFF>最新联系电话</font></td>
  		<td width=90><font color=#FFFFFF>所在地</font></td>
  		<td width=60><font color=#FFFFFF>回校时间</font></td>
<?php  		
if($show=="all") echo "<td width=60><font color=#FFFFFF>工作情况</font></td><td><font color=#FFFFFF>单位名称</font></td>";
else echo "<td><font color=#FFFFFF>学生留言</font></td>";
?>  		
  	</tr>  	
<?php
if($show=="all"){
   $sql = "select teacher.name as tname,work,company,class,student.name,checktime,checkin.mobile,city,memo,backtime from ".$TABLE."student_sheet as student,".$TABLE."checkin as checkin,".$TABLE."teacher_information as teacher where teacher.teacher_id=checkin.teacher_id&&student.number=checkin.student_id && id in(select SUBSTRING_INDEX(group_concat(id order by `checktime` desc),',',1) from ".$TABLE."checkin group by student_id) order by `tname`,`checktime` desc";
} else {
	if($view=="all")
   		$sql = "select class,student.name,checktime,checkin.mobile,city,memo,backtime from ".$TABLE."student_sheet as student,".$TABLE."checkin as checkin where teacher_id='$teacher_id'&&student.number=checkin.student_id  order by `student_id`,`checktime` desc";
	else 
   		$sql = "select class,student.name,checktime,checkin.mobile,city,memo,backtime from ".$TABLE."student_sheet as student,".$TABLE."checkin as checkin where teacher_id='$teacher_id'&&student.number=checkin.student_id && id in(select SUBSTRING_INDEX(group_concat(id order by `checktime` desc),',',1) from ".$TABLE."checkin group by student_id) order by `checktime` desc";
}
$que = mysql_query($sql);
if($que) $currrows=mysql_num_rows($que);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=168 colspan=".($show=="all"?9:8)." align=center><b>当前没有您的学生的签到信息，请通知他们及时签到，谢谢！</td></tr>";
}    
$bt = array("已回校","一周内","<font color=green>两周内</font>","<font color=blue>一月内</font>","<font color=red>还未定</font>");
$gz = array("学习中","找工中","<font color=green>未签约</font>","<font color=blue>已签约</font>","<font color=red>正式工作</font>","<font color=red>工作中</font>");
$cnt = 0;
$lastname = "";
while($res = @mysql_fetch_array($que)){
	$cnt ++;
	$class = $res["class"];
	$studentname = $res[name];
	if($lastname==$studentname) $samecolor = "#EEEEEE";
	else $samecolor = "";
	$lastname = $studentname;
	$teachername = $res[tname];
	$checktime = date("Y-m-d",$res[checktime]);
	$mobile = substr($res[mobile],0,11);
	$city = $res[city];
	$city = str_replace("广东","",$city);
	$city = str_replace("省","",$city);
	$city = str_replace("市","",$city);
	$memo = $res[memo];
	$backtime = $bt[$res[backtime]];
	$gongzuo = $gz[$res[work]];
	$company = $res[company];
	echo "<tr align=center bgcolor=$samecolor>";
	echo "<td>".$cnt."</td>";
	echo "<td>".$class."</td>";
	echo "<td>".$studentname."</td>";
	echo "<td>".$checktime."</td>";
	echo "<td>".$mobile."</td>";
	echo "<td>".$city."</td>";
	echo "<td>".$backtime."</td>";
	if($show=="all") echo "<td>$gongzuo</td><td>$company</td>";
	else echo "<td align=left>".($teachername?("[<font color=blue>".$teachername."</font>] "):"").$memo."</td>";
	echo "</tr>";
}
?>
  </table>
  <br>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
