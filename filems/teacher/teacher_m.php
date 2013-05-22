<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "查看毕设文档";
$YM_ZT2 = "毕业设计文档";
$YM_MK = "毕业设计文档管理系统";
$YM_PT = "文档系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<?php
function dispEnter($content){
   $content = str_replace("\n","<br>&nbsp;&nbsp;&nbsp;&nbsp;",$content);
   return $content;
 }
$mission_id = $_GET["mission_id"];
if(!$mission_id){
	 ShowMissionList();
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}
$sql = "select * from ".$TABLE."mission_list where mission_id = $mission_id && `year`='$CURR_YEAR'&&`pro_id`=$CURR_PID order by start_time";
$que = mysql_query($sql);
$wd_fet = mysql_fetch_array($que);
if(!$wd_fet){
	ShowMissionList();
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
} 

echo "<script  type=\"text/javascript\" src=\"ajax_js_teacher.js\"></script>";
?>

<table width="800" border=0 align="center" cellpadding="3">
<tr align="center">
<td><b>文档：《<?PHP echo $wd_fet["name"];?>》<b></td>
</tr>
<tr>
<td>
<p align=left>
	<?php
	$filename1 = $wd_fet["filename1"];
	$filename2 = $wd_fet["filename2"];
	echo "&nbsp;&nbsp;&nbsp;&nbsp;";
	if($filename1!=""||$filename2!=""){
	echo "关于<b>".$wd_fet["name"]."</b>的参考文档或要求下载：";
	TeacherArchiveDown($CURR_YEAR,$CURR_PID,$teacher_id,$xs_fet["number"],$mission_id,"1","参考文档");
	echo "&nbsp;&nbsp;";
	if($filename2!="") {
		echo "&nbsp;&nbsp;【注】<u>科学研究类</u>论文需参考：";
		TeacherArchiveDown($CURR_YEAR,$CURR_PID,$teacher_id,$xs_fet["number"],$mission_id,"2","本文档");
	}
}
	?>
</p>
</td>
</tr>
<tr>
  <td>
<table width="96%" border="1" align="center" bordercolor=#000000  cellpadding="6">
 <tr align="center"  bgColor=#5a6e8f  height=38>
 	<td><font color=#FFFFFF>序号</font></td>
 	<td><font color=#FFFFFF>班级</font></td>
  <td width="80"><font color=#FFFFFF>学生姓名</font></td>
  <td><font color=#FFFFFF>文件状态</font></td>
  <td><font color=#FFFFFF>学生留言</font></td>
  <td><font color=#FFFFFF>操作</font></td>
 </tr>
<?php
 $sql = "select student.class, student.name,student.number,student.tmptime as stmptime,student.mobilephone,student.short_number,log.filename,log.teacher_suggestion,log.student_suggestion  from ".$TABLE."topic as topic, ".$TABLE."student_sheet as student left join (select student_id,mission_id,filename,teacher_suggestion,student_suggestion from ".$TABLE."mission_log where mission_id='$mission_id') as log on log.student_id = student.number where student.number = topic.student_number && topic.teacher_id = '$teacher_id' && is_select = 1 && student.year=$CURR_YEAR&&student.profession='$pro_name' order by student.number";
$que = mysql_query($sql);
if($que) $currrows=mysql_num_rows($que);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=6 height=138 align=center>对不起，您目前没有指导 <b>".$CURR_YEAR."届 $pro_name 专业</b> 的学生</td></tr>";
}
 $scnt = 1;
 while($xs_fet = mysql_fetch_array($que)){ 
?>
 <tr align="center">
 	<td><?php echo $scnt ++; ?></td>
 	<td><?php echo $xs_fet["class"]; ?></td>
  <td><a href="student_m.php?mission_id=<? echo $wd_fet["mission_id"]?>&student_number=<?php echo $xs_fet["number"]?>"><font color=blue><u><?php echo $xs_fet["name"]?></u></font></a>
  </td>
  <td>
  <?php 
  $uploader = $wd_fet["uploader"];
  $filename = $xs_fet[filename];
  if($filename=="") $candown = false;
  else    $candown = file_exists("../../../Docs/".$CURR_YEAR."/".$wd_fet[address]."/".$filename);
   if($candown){
	TeacherArchiveDown($CURR_YEAR,$CURR_PID,$teacher_id,$xs_fet["number"],$mission_id,"mydoc","下载该文档");
   }else{
   	if($wd_fet["lockit"]) echo "<font color=red><b>已锁定</b></font>";
   	else if($uploader==1) echo "<font color=red><b>请上传</b></font>";
	else echo "尚未上传";
   }
  ?>    
  </td>
  <td align=left>
  <?php 
  if($xs_fet["student_suggestion"]!="") echo "<span title='".$xs_fet[student_suggestion]."'><font color=green>".substr($xs_fet[student_suggestion],0,50)." ...</font></span>";    
  else{
	 if($uploader==1) {
	 	if($candown) echo "若有更新，请重传";
	 	else echo "请及时给学生指导，下发任务";
	 }else {
	 	if($xs_fet["stmptime"]==999) echo "<span id=s".$xs_fet["number"]."><font color=red><b>请老师帮我开启文档上传功能。</b></font><input type=button onClick=\"makemoretime('s".$xs_fet["number"]."','".$xs_fet["number"]."','student')\" value=同意></span>";
	 	else echo "手机：".$xs_fet["mobilephone"]." (".$xs_fet["short_number"].")"; 
	 }
   }
  ?>    
  </td>
  <td><a href="student_m.php?mission_id=<? echo $wd_fet["mission_id"]?>&student_number=<?php echo $xs_fet["number"]?>"><font color=blue><u><?php
  if($uploader!=1) echo "查看";
  else if($candown) echo "重传";
  else echo "上传";
   ?></u></font></a>
  </td>
   </tr>
<?php
}
?>
</table>
</td>
</tr>
<tr>
<td height=38>
 	<?php
 	echo "&nbsp;&nbsp;&nbsp;批量打包下载".($uploader==1?"您":"学生")."当前已上传文档：";
 	TeacherArchiveDown($CURR_YEAR,$CURR_PID,$teacher_id,"allstudent",$mission_id,"alldoc","打包下载《".$wd_fet["name"]."》");
 	?>
</td>
</tr>
<tr>
<td>
 <table width="96%" border=1 bordercolor=#000000 align="center" cellpadding="6">
<tr>
<td bgcolor="#FFFFFF">
<?php
 echo "关于《<b>".$wd_fet["name"]."</b>》的要求说明：<p>";
 echo "&nbsp;&nbsp;&nbsp;&nbsp;<font color=red>★&nbsp;上传说明：本文档由<b>".($wd_fet[uploader]?"教师":"学生")."</b>负责上传。".($wd_fet["lockit"]?"当前已锁定，禁止上传。":"")."截止日期：".date("Y年m月d日",$wd_fet["end_time"])."</font>。文档大小不能超过2M，必要时压缩后上传。<br>";
if($wd_fet["paper_num"]<1){
	echo "&nbsp;&nbsp;&nbsp;&nbsp;<font color=blue>★&nbsp;本文档暂不需要学生提交纸质打印稿，请勿打印。若需打印，请另候通知。</font><br>";
} else {
	echo "&nbsp;&nbsp;&nbsp;&nbsp;<font color=blue>★&nbsp;打印说明：请用".$wd_fet["paper_type"]."纸打印".$wd_fet["paper_num"]."份，打印截止日期：".date("Y年m月d日",$wd_fet["print_time"])."。</font><br>";
}
echo "&nbsp;&nbsp;&nbsp;&nbsp;".dispEnter($wd_fet["demonstration"]);
?>
</td>
</tr>
</table>
<br>
</td>
</tr>
</table>

<?php
function ShowMissionList()
{
	global $TABLE,$CURR_YEAR,$CURR_PID,$pro_name;
	echo "<b>".$CURR_YEAR."届 ".$pro_name." 专业</b> 毕业设计文档要求一览表<br><br>";
	?>	
<table width="700" border=1 bordercolor=#000000 align="center" cellpadding="6">
	<tr align="center" bgColor=#5a6e8f  height=38>
		<td><font color=#FFFFFF>序号</font></td>
		<td><font color=#FFFFFF>毕业设计需要上交的电子文档</font></td>
		<td><font color=#FFFFFF>文档属性</font></td>
		<td><font color=#FFFFFF>截止日期</font></td>
		<td><font color=#FFFFFF>上传者</font></td>
 		<td><font color=#FFFFFF>操作</font></td>
	</tr> 		
<?php			
  $count = 1;
  $sql = "select name,mission_id,needdoc,end_time,uploader,lockit from ".$TABLE."mission_list as list where year='$CURR_YEAR'&&`pro_id`=$CURR_PID&&lockit<2 order by start_time";
  //echo $sql;
  $miss = mysql_query($sql);
  if($miss) $currrows=mysql_num_rows($miss);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=168 colspan=6 align=center><b>".$CURR_YEAR."届 $pro_name 专业</b><br>暂无毕业设计文档上交要求</td></tr>";
  }    
$uperstr = array(1=>"指导教师",0=>"学生");
$lockstr = array(0=>"正常",1=>"锁定",2=>"取消");  
while($arr = @mysql_fetch_array($miss)){
	echo "<tr align=center>";
	echo "<td>$count</td>";
	echo "<td align=left><a href =teacher_m.php?mission_id=".$arr["mission_id"]."><font color=blue><u>".$arr["name"]."</u></font></a></td>";
	echo "<td>".($arr[needdoc]?"<font color=blue>重要</font>":"普通")."</td>";
	echo "<td>".date("Y-m-d",$arr["end_time"])."</td>";
	echo "<td>".$uperstr[$arr["uploader"]]."</td>";
	echo "<td>";
	echo "[<a href =teacher_m.php?mission_id=".$arr["mission_id"]."><font color=blue><u>查看</u></font></a>]";
	if($arr["lockit"]) echo "&nbsp;[<b>已锁定</b>]";
	echo "</td>";
        echo "</tr>";
        $count++;
}
?>
</table>
<br>
<?
}   //ShowMissionList 函数结束
?>


<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
