<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "教师上传文档";
$YM_ZT2 = "指导教师给学生上传毕业设计文档";
$YM_MK = "毕业设计文档管理系统";
$YM_PT = "文档系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
<?php
$now = time(0);
$mission_id = $_GET["mission_id"];
$number = $_GET["student_number"];
if(!$number){
	 ShowMissionList();
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}

$sql = "select student.name, topic,title.name as ttype,student.mobilephone,student.tmptime as stmptime,short_number,student.email,list.name as wdname,list.address,filename1,filename2,uploader,demonstration,start_time,end_time,print_time,needdoc,paper_type,paper_num,lockit,list.year from ".$TABLE."student_sheet as student,".$TABLE."topic as topic ,".$ART_TABLE."title_sort as title,".$TABLE."mission_list as list,".$TABLE."major as major where number = '$number' && mission_id='$mission_id'&&list.year=student.year&&title.id = topic.type && is_select=1 &&topic.student_number='$number'&& topic.teacher_id='$teacher_id'&&list.pro_id=major.id&&major.name=student.profession&&number=number";
//echo $sql;
$sj_que = mysql_query($sql);
$sj_fet = mysql_fetch_array($sj_que);
if(!$sj_fet||$sj_fet["name"]==""){
	Show_Message("对不起，参数匹配错误，不能进入文档管理模块。");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}

function dispEnter($content){
   $content = str_replace("\n","<br>&nbsp;&nbsp;&nbsp;&nbsp;",$content);
   return $content;
 }


if($_POST["submit"]!=""){
	$uploadret = false;
	if(is_uploaded_file($_FILES["uploadfile"]["tmp_name"])){
		$upfile = $_FILES["uploadfile"];
		$name = $upfile["name"];
		$tmp_name = $upfile["tmp_name"];
		$error = $upfile["error"];
		if(!file_exists("../../../Docs/".$sj_fet["year"]."/$sj_fet[address]")){
			mkdir("../../../Docs/".$sj_fet["year"]."/$sj_fet[address]",0700);
		}
		$tmp_type1=".".substr(strrchr($name,"."),1);
		$filename = $number.$tmp_type1;
		$destination = "../../../Docs/".$sj_fet["year"]."/".$sj_fet["address"]."/".$filename;
		if($error=='0')	$uploadret = move_uploaded_file($tmp_name,$destination);
	}
	if(!$uploadret) 	$filename = "";
	$suggestion = $_POST["suggestion"];
	$now = date("Y-m-d");
	$sql = "select log.id,log.upload_times,filename from ".$TABLE."mission_log as log,".$TABLE."mission_list as list where log.mission_id = list.mission_id && log.student_id = '$number' && log.mission_id = '$mission_id' && list.uploader = 1";
	$chk_que = mysql_query($sql);
	$chk_fet = @mysql_fetch_array($chk_que);
	if(!$chk_fet["id"]){  //新增上传
		$sql = "insert into ".$TABLE."mission_log(mission_id,teacher_id,student_id,first_upload,is_check, teacher_suggestion,last_uploadtime,upload_times,lock_flag,teacher_firstwatch,teacher_lastwatch,filename) values ('$mission_id','$teacher_id','$number','$now','0','$suggestion','$now','1','0','$now','$now','$filename')"; 
		$sqlquery = mysql_query($sql);
		if($sqlquery) $msg = "数据提交成功！".($uploadret!=true?"<br><br>【注意】本此未上传文件，或本次上传未成功！":"您的文件已成功上传！");
		else	$msg = "数据提交失败！";		
	}else{
		$oldfilename = $chk_fet["filename"];
		$times = $chk_fet["upload_times"];
		if($filename!="") $times ++;
		else $filename = $oldfilename;
		$sql = "update ".$TABLE."mission_log set filename='$filename', teacher_suggestion = '$suggestion',last_uploadtime = '$now',upload_times = '$times',teacher_lastwatch = '$now' where student_id = '$number' && mission_id = '$mission_id'";
		$update = mysql_query($sql);
		if($update) $msg = "数据更新成功！".($uploadret!=true?"<br><br>【注意】本此未上传文件，或本次上传未成功！":"您的文件也已经成功更新");
		else	$msg = "数据更新失败！";
		if($filename!=$oldfilename&&$oldfilename!=""){
			$path = "../../../Docs/".$sj_fet["year"]."/".$sj_fet["address"]."/".$oldfilename;
			$delfile = @unlink($path);
			$msg .= "<br><font color=blue><b>电子文档更新成功！旧文档已被删除！</b></font>";
		}
	}
	Show_Message($msg);
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}

//增加文档人员导航条
 $sql = "select student.class, student.name,student.number,student.mobilephone,student.short_number,log.filename,log.teacher_suggestion,log.student_suggestion  from ".$TABLE."topic as topic, ".$TABLE."student_sheet as student left join (select student_id,mission_id,filename,teacher_suggestion,student_suggestion from ".$TABLE."mission_log where mission_id='$mission_id') as log on log.student_id = student.number where student.number = topic.student_number && topic.teacher_id = '$teacher_id' && is_select = 1 && student.year=$CURR_YEAR&&student.profession='$pro_name' order by student.number";
$que = mysql_query($sql);
$currrows=@mysql_num_rows($que);  
if($currrows>1){
	echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;《".$mission_name."》快速链接：";
	while($xs_fet = mysql_fetch_array($que)){ 
		if($number==$xs_fet[number]) echo "[<b>".$xs_fet[name]."</b>]&nbsp;";
		else echo "[<a href=student_m.php?mission_id=".$mission_id."&student_number=".$xs_fet["number"]."><font color=blue><u>".$xs_fet["name"]."</u></font>(".($xs_fet[filename]!=""?"<font color=green>√</font>":"<font color=red>⊙</font>").")</a>]&nbsp;";
	}
	echo "</p>";
}
//增加文档人员导航条结束


//增加文档导航条
$sql = "select * from ".$TABLE."mission_list where `year`='$CURR_YEAR'&&pro_id='$CURR_PID'&&lockit<2&&uploader=1 order by start_time";
$que = mysql_query($sql);
$currrows=@mysql_num_rows($que);  
if($currrows>1){
	echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;您上传给<b>".$sj_fet["name"]."</b>的快速链接：";
	while($tmp_fet = mysql_fetch_array($que)){ 
		if($mission_id==$tmp_fet[mission_id]) echo "[<b>".$tmp_fet[name]."</b>]&nbsp;";
		else echo "[<a href=student_m.php?mission_id=".$tmp_fet[mission_id]."&student_number=".$number."><font color=blue><u>".$tmp_fet["name"]."</u></font></a>]&nbsp;";
	}
	echo "</p>";
}
//增加文档导航条结束



$sql = "select teacher_suggestion,student_suggestion,lock_flag,filename from ".$TABLE."mission_log where student_id = '$number' && mission_id = '$mission_id'";
$wd_que = mysql_query($sql);
$wd_fet = mysql_fetch_array($wd_que);

echo "<script  type=\"text/javascript\" src=\"ajax_js_teacher.js\"></script>";
?>
<table width=800 align=center border=1 bordercolor=1 cellpadding=6>
   <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>毕设课题</font></td><td colspan=3><?php 
   	   echo $sj_fet["topic"];
   	   echo " (<b>".$sj_fet["ttype"]."</b>)";
   	   echo "&nbsp;&nbsp;&nbsp;";
   	   echo "学生姓名：<b>".$sj_fet["name"]."</b> (<span title=".$sj_fet["short_number"].">".$sj_fet["mobilephone"]."</span>，<a href=mailto://".$sj_fet["email"]."?subject=".$sj_fet["name"]."，“".$sj_fet["topic"]."”毕业设计的《".$sj_fet["wdname"]."》的问题><font color=blue><u>发邮件</u></font>)";
   	   ?></td>
    </tr>
    <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>当前文档</font></td><td><b><?php if($sj_fet["needdoc"]) echo "（<font color=blue><b>重要</b></font>）"; echo $sj_fet["wdname"];?></b></td>
   	  <td align=center bgColor=#5a6e8f><font color=#FFFFFF>参考文档</font></td><td><?php 
   	  	if($sj_fet["ttype"]=="科学研究"){
   	  		$filename = $sj_fet["filename2"];
   	      		$ReferenceN = 2;
   	  	} else $filename = "";
   	  	if($filename=="") {
   	  		$filename = $sj_fet["filename1"];
   	      		$ReferenceN = 1;
   	  	}
   	  	if($filename==""){
   	  		echo "本文档未提供参考文档";
   	      		$ReferenceN = 0;
   	  	} else {
   	   		TeacherArchiveDown($CURR_YEAR,$CURR_PID,$teacher_id,"",$mission_id,$ReferenceN,"下载参考文档");
   	  	}
   	   ?></td>
    </tr>
    <tr>
   	   
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>上交时间</td><td><?php echo date("Y年m月d日",$sj_fet["end_time"]);?>前上交电子稿</td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>打印时间</td><td><?php
   	   	if($sj_fet["paper_num"]<1) echo "本文档暂不需要打印，请另候通知。";
   	   	else {
   	   		echo "用 ".$sj_fet["paper_type"]." 纸打印 ".$sj_fet["paper_num"]." 份，".date("Y年m月d日",$sj_fet["print_time"])."前交";
   		}
   	   ?></td>
    </tr>
    <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>文档下载</font></td><td><?php
   	   if($wd_fet[filename]!=""&& file_exists("../../../Docs/".$sj_fet["year"]."/$sj_fet[address]/$wd_fet[filename]")){
   	   	TeacherArchiveDown($CURR_YEAR,$CURR_PID,$teacher_id,$number,$mission_id,"mydoc","下载".($sj_fet["uploader"]==1?"您":($sj_fet["name"]))."上传的《".$sj_fet["wdname"]."》");
   	   	$upok = true;
   	   } else {
   	   	if($sj_fet[uploader]==1) echo "<font color=red><b>您尚未上传本文档</b></font>";
   	   	else echo "<font color='green'><b>文档不存在，请联系 <b>".$sj_fet["name"]."</b> 上传</b></font>";
   	   	$upok = false;
   	   }
     	   ?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>任务状态</td><td><?php 
   	   	if($upok) echo $sj_fet[uploader]==1?"<font color=blue>你已上传，可再次提交</font>":"<font color=green><b>学生已上交</b></font>";
   	   	else{
   	   		 if($sj_fet[uploader]==1) echo "<font color=red><b>请在规定时间内上交</b></font>";
   	   		 else {
   	   		 	if($sj_fet["stmptime"]==999) echo "<span id=s".$number."><font color=red><b>请老师帮我开启文档上传功能。</b></font><input type=button onClick=\"makemoretime('s".$number."','".$number."','student')\" value=同意></span>";
   	   		 	else echo "<font color=green><b>请联系学生上交毕设文档</b></font>";
   	   		 }
   	   	}
   	   	echo "&nbsp;&nbsp;";
   	   	echo $sj_fet[lockit]?"<font color=red>文档已锁定，不能上传</font>":"";
   	   ?></td>
    </tr>
    <tr>
   	   <td colspan=4><?php
   	   	echo "关于《<b>".$sj_fet["wdname"]."</b>》的要求说明：<p>&nbsp;&nbsp;&nbsp;&nbsp;".dispEnter($sj_fet["demonstration"]);
   	   	?></td>
    </tr>
<?php
if($wd_fet["student_suggestion"]!=""){
    echo "<tr><td colspan=4>".$sj_fet["name"]."给您的留言：<br>&nbsp;&nbsp;&nbsp;&nbsp;".dispEnter($wd_fet["student_suggestion"])."</td></tr>";
}

$needok = true;
if($sj_fet[needdoc]){
	$sql = "select name,list.mission_id,uploader,log.filename from ".$TABLE."mission_list as list left join (select mission_id,filename from ".$TABLE."mission_log where student_id='$number') as log on log.mission_id =list.mission_id  where lockit<2&&pro_id='$CURR_PID'&&start_time<=".$sj_fet["start_time"]."&&needdoc>0&&year=$CURR_YEAR&&list.mission_id<>'$mission_id' order by start_time desc";
	//echo $sql;
	$que = mysql_query($sql);
	while($tmp = @mysql_fetch_array($que)){
		if(!$tmp[filename]){
			$needok = false;
			break;
		}
	}
	if(!$needok){
		echo "<tr><td colspan=4 align=center bgcolor=red><font color=yellow>重要提醒：本文档必须在 《".$tmp[name]."》已提交的情况下方可提交，请先完成上一个文档提交任务。</font></td></tr>";
		echo "<tr><td colspan=4 height=38>".($tmp[uploader]?"您":$sj_fet["name"])."目前尚未提交《".$tmp[name]."》，请及时".($tmp[uploader]?"":"通知<b>".$sj_fet["name"]."(<span title=".$sj_fet["short_number"].">".$sj_fet["mobilephone"]."</span>，<a href=mailto://".$sj_fet["email"]."?subject=".$sj_fet["name"]."，“".$sj_fet["topic"]."”毕业设计的《".$tmp["name"]."》的问题><font color=blue><u>发邮件</u></font></a>)</b>")."提交，以免影响本文档的提交。".($tmp[uploader]?"[<a href=student_m.php?mission_id=".$tmp[mission_id]."&student_number=".$number."><font color=blue><u>立即为".$sj_fet[name]."提交《".$tmp[name]."》</u></font></a>]":"")."</td></tr>";
	}
}

$tmplock = true;
if($now<$sj_fet["end_time"]) $tmplock = false;
if($upok) $tmplock = false;
$sql = "select tmptime from ".$TABLE."teacher_information where teacher_id='$teacher_id'";
$que = mysql_query($sql);
$tt = mysql_fetch_array($que);
$tmptime = $tt[tmptime]+0;
if($now<$tmptime)	 $tmplock = false;
?>    
</table>

<br>	
<table width="700">
<?php
if($needok && $sj_fet["uploader"]==1 && !$sj_fet["lockit"]&&!$tmplock ){  //教师上传留言
?>
<tr>
<td>
<form name="myform" method="post" action="" enctype="multipart/form-data">
<table width="650" align="center" border="0">
 <tr>
  <td colspan="2" align="center">请上传您的文档（<font color=blue>文档大小不能超过2M，必要时压缩后上传</font>）</td>
 </tr>
 <tr>
  <td>上传文档：</td>
  <td><input type="file" name="uploadfile" />&nbsp;&nbsp;
  </td>
 </tr>
 <?php
 if($now<$tmptime&&$now>$sj_fet["end_time"]&&!$upok){
    echo "<tr><td>&nbsp;</td><td bgcolor=red align=center><font color=yellow>临时上传功能已开启，请在 ".date("Y年m月d日",$tmptime)." 前提交文档</td></tr>";
}
 ?>
 <tr>
  <td>给学生留言：</td>
  <td><textarea name="suggestion" cols="60" rows="3"  wrap="virtual"><?php
   echo $wd_fet["teacher_suggestion"];
  ?></textarea></td>
 </tr>
 <tr align="center">
  <td colspan="2"><input type="submit" name="submit" value="给<?php echo $sj_fet[name];?>提交最新的《<?php echo $sj_fet["wdname"]; ?>》"/></td>
 </tr>
</table>
</form>
</td>
</tr>
<?php  
} else if($needok&&$sj_fet[uploader]==1&& !$sj_fet["lockit"]) {
	echo "<tr><td colspan=4 align=center bgcolor=red height=28><font color=yellow>本文档要求在 ".date("Y年m月d日",$sj_fet["end_time"])." 之前上传，目前已过截止日期！请及时辅导学生完成毕业设计工作，谢谢。</font></td></tr>";
	echo "<tr><td height=88 align=center valign=middle>";
	echo "<span id=mmt>";
	echo "<font color=blue><b>您可以申请临时开启上传权限。请点击 --></b></font> <input type=button onClick=\"makemoretime('mmt','".$teacher_id."','teacher')\" value=申请临时开启上传>";
	echo "</span>";
	echo "</td></tr>";
}
?>
<tr>
<td><br />说明：<br />
 <li>为了确保毕业设计指导质量，系统会记录您的毕业设计文档处理情况，请及时与学生联系，完成文档</li>
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
