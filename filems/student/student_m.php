<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "毕业设计文档";
$YM_ZT2 = "毕业设计文档管理";
$YM_MK = "毕业设计文档管理系统";
$YM_PT = "文档系统";
$YM_DH = 1; //需要导航条
$YM_QX = 1; //本页访问需要权限：学生
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;
?>

<?php
$sql = "select student.name,teacher.name as tname,student.tmptime as stmptime,teacher.teacher_id,teacher.mobilephone as phone,techpos  as zhicheng, topic,".$TABLE."title_sort.name as ttype from ".$TABLE."student_sheet as student,".$TABLE."topic as topic ,".$TABLE."title_sort,".$TABLE."teacher_information as teacher where number = '$number' && ".$TABLE."title_sort.id = type && is_select=1 && number = student_number&&teacher.teacher_id=topic.teacher_id";
$sj_que = mysql_query($sql);
$sj_fet = mysql_fetch_array($sj_que);
if(!$sj_fet||$sj_fet["name"]==""){
	Show_Message("对不起，您尚未确定选题，不能进入文档管理模块。");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}

function dispEnter($content){
   $content = str_replace("\n","<br>&nbsp;&nbsp;&nbsp;&nbsp;",$content);
   return $content;
 }
$mission_id = $_GET["mission_id"];
echo "<script  type=\"text/javascript\" src=\"ajax_js_student.js\"></script>";
$tmptime = $sj_fet["stmptime"];
if(!$mission_id){
	 ShowMissionList();
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}
$sql = "select * from ".$TABLE."mission_list where mission_id = $mission_id&&year='$com_bysj' order by start_time";
$yq_que = mysql_query($sql);
$yq_fet = mysql_fetch_array($yq_que);
if(!$yq_fet){
	Show_Message("对不起，目前暂没有毕业设计文档上交需求。");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}

if($_POST["submit"]!=""){
	$uploadret = false;
	if(is_uploaded_file($_FILES["uploadfile"]["tmp_name"])){
		$upfile = $_FILES["uploadfile"];
		$name = $upfile["name"];
		$tmp_name = $upfile["tmp_name"];
		$error = $upfile["error"];
		if(!file_exists("../../../Docs/".$com_bysj."/$yq_fet[address]")){
			mkdir("../../../Docs/".$com_bysj."/$yq_fet[address]",0700);
		}
		$tmp_type1=".".substr(strrchr($name,"."),1);
		$filename = $number.$tmp_type1;
		$destination = "../../../Docs/".$com_bysj."/".$yq_fet["address"]."/".$filename;
		if($error=='0')	$uploadret = move_uploaded_file($tmp_name,$destination);
	}
	if(!$uploadret) 	$filename = "";
	$suggestion = $_POST["suggestion"];
	$now = date("Y-m-d");
	$sql = "select log.id,log.upload_times,filename from ".$TABLE."mission_log as log,".$TABLE."mission_list as list where log.mission_id = list.mission_id && log.student_id = '$number' && log.mission_id = '$mission_id' && list.uploader = 0";
	$chk_que = mysql_query($sql);
	$chk_fet = @mysql_fetch_array($chk_que);
	if(!$chk_fet["id"]){  //新增上传
		$sql = "insert into ".$TABLE."mission_log(mission_id,teacher_id,student_id,first_upload,is_check, student_suggestion,last_uploadtime,upload_times,lock_flag,student_firstwatch,student_lastwatch,filename) values ('$mission_id','$sj_fet[teacher_id]','$number','$now','0','$suggestion','$now','1','0','$now','$now','$filename')"; 
		$sqlquery = mysql_query($sql);
		if($sqlquery) $msg = "数据提交成功！".($uploadret!=true?"<br><br>【注意】本此未上传文件，或本次上传未成功！":"您的文件已成功上传！");
		else	$msg = "数据提交失败！";		
	}else{
		$oldfilename = $chk_fet["filename"];
		$times = $chk_fet["upload_times"];
		if($filename!="") $times ++;
		else $filename = $oldfilename;
		$sql = "update ".$TABLE."mission_log set filename='$filename', student_suggestion = '$suggestion',last_uploadtime = '$now',upload_times = '$times',student_lastwatch = '$now' where student_id = '$number' && mission_id = '$mission_id'";
		$update = mysql_query($sql);
		if($update) $msg = "数据更新成功！".($uploadret!=true?"<br><br>【注意】本此未上传文件，或本次上传未成功！":"您的文件也已经成功更新");
		else	$msg = "数据更新失败！";
		if($filename!=$oldfilename&&$oldfilename!=""){
			$path = "../../../Docs/".$com_bysj."/".$yq_fet["address"]."/".$oldfilename;
			$delfile = @unlink($path);
			$msg .= "<br><font color=blue><b>电子文档更新成功！旧文档已被删除！</b></font>";
		}
	}
	Show_Message($msg);
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}

$sql = "select log.teacher_suggestion,log.student_suggestion,log.lock_flag,log.filename, list.address,needdoc from ".$TABLE."mission_log as log,".$TABLE."mission_list as list where log.mission_id = list.mission_id && log.student_id = '$number' && log.mission_id = '$mission_id'";
$wd_que = mysql_query($sql);
$wd_fet = mysql_fetch_array($wd_que);
?>
<table width=800 align=center border=1 bordercolor=1 cellpadding=6>
   <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>毕设课题</font></td><td colspan=3><?php 
   	   echo $sj_fet["topic"];
   	   echo " (<b>".$sj_fet["ttype"]."</b>)";
   	   echo "&nbsp;&nbsp;&nbsp;";
   	   echo "指导教师：".$sj_fet["tname"]." (".$sj_fet["zhicheng"]."，".$sj_fet["phone"].")";
   	   ?></td>
    </tr>
    <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>当前文档</font></td><td><b><?php echo $yq_fet["name"];?></b></td>
   	  <td align=center bgColor=#5a6e8f><font color=#FFFFFF>参考文档</font></td><td><?php 
   	  	$ReferenceN = 0;
   	  	if($sj_fet["ttype"]=="科学研究") {
   	      		$filename = $yq_fet["filename2"];
   	      		$ReferenceN = 2;
   	      	} else $filename = "";
   	      	if($filename=="") {
   	      		$filename = $yq_fet["filename1"];
   	      		$ReferenceN = 1;
   	      	}
   	      	if($filename=="") {
   	      		echo "本文档未提供参考文档";
   	      		$ReferenceN = 0;
   	      	} else {
   	      		//echo "<a href=\"/Docs/".$com_bysj."/".$filename."\"><font color=blue><u>下载参考文档</u></font></a>";
   	   		$crc = md5("stu".$mission_id.$number.date("Ymd")."crc");
   	   		echo "<a href =StudentArchiveDown.php?mission_id=".$mission_id."&obj=$ReferenceN&crc=$crc title='下载参考文档'><font color = blue><u>下载参考文档</u></font></a>";
   	      		
   	      	}
   	   ?></td>
    </tr>
    <tr>
   	   
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>上交时间</td><td><?php echo date("Y年m月d日",$yq_fet["end_time"]);?>前上交电子稿</td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>打印时间</td><td><?php
   	   	if($yq_fet["paper_num"]<1) echo "本文档暂不需要打印，请另候通知。";
   	   	else {
   	   		echo $yq_fet["paper_type"]." 纸打印 ".$yq_fet["paper_num"]." 份，".date("Y年m月d日",$yq_fet["print_time"])."前交指导教师";
   		}
   	   ?></td>
    </tr>
    <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>文档下载</font></td><td><?php
   	   if($wd_fet[filename]!=""&& file_exists("../../../Docs/".$com_bysj."/$yq_fet[address]/$wd_fet[filename]")){
   	   	//echo "<a href =\"/Docs/".$com_bysj."/$yq_fet[address]/$wd_fet[filename]\" title='下载该文档'><font color = blue><u>下载".($yq_fet["uploader"]!=1?"您":($sj_fet["tname"]."老师"))."上传的《".$yq_fet["name"]."》</u></font></a>";
   	   	$crc = md5("stu".$mission_id.$number.date("Ymd")."crc");
   	   	echo "<a href =StudentArchiveDown.php?mission_id=".$mission_id."&obj=mydoc&crc=$crc title='下载该文档'><font color = blue><u>下载".($yq_fet["uploader"]!=1?"您":($sj_fet["tname"]."老师"))."上传的《".$yq_fet["name"]."》</u></font></a>";
   	   	$upok = true;
   	   } else {
   	   	if($yq_fet[uploader]!=1) echo "<font color=red><b>您尚未上传本文档</b></font>";
   	   	else echo "<font color='green'><b>文档不存在，请联系 <b>".$sj_fet["tname"]."</b> 老师上传</b></font>";
   	   	$upok = false;
   	   }
     	   ?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>任务状态</td><td><?php 
   	   	if($upok) echo $yq_fet[uploader]!=1?"<font color=blue>你已上传，可再次提交</font>":"<font color=green><b>任务已发放</b></font>";
   	   	else echo $yq_fet[uploader]!=1?"<font color=red><b>请在规定时间内上交</b></font>":"<font color=green><b>请联系老师发放任务</b></font>";
   	   	echo "&nbsp;&nbsp;";
   	   	echo $yq_fet[lockit]?"<font color=red>文档已锁定，不能上传</font>":"";
   	   ?></td>
    </tr>
    <tr>
   	   <td colspan=4><?php
   	   	echo "关于《<b>".$yq_fet["name"]."</b>》的要求说明：<p>&nbsp;&nbsp;&nbsp;&nbsp;".dispEnter($yq_fet["demonstration"]);
   	   	?></td>
    </tr>
<?php
if($wd_fet["teacher_suggestion"]!=""){
    echo "<tr><td colspan=4>".$sj_fet["tname"]."老师给你的留言：<br>&nbsp;&nbsp;&nbsp;&nbsp;".dispEnter($wd_fet["teacher_suggestion"])."</td></tr>";
}

$needok = true;
if($yq_fet[needdoc]){
	$sql = "select name,list.mission_id,uploader,log.filename from ".$TABLE."mission_list as list left join (select mission_id,filename from ".$TABLE."mission_log where student_id='$number') as log on log.mission_id =list.mission_id  where lockit<2&&pro_id='$com_pro_id'&&start_time<=".$yq_fet["start_time"]."&&needdoc>0&&year=".$CURR_YEAR."&&list.mission_id<>'$mission_id' order by start_time desc";
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
		echo "<tr><td colspan=4 height=38>".($tmp[uploader]==0?"您":$sj_fet["tname"]."老师")."目前尚未提交《".$tmp[name]."》，请及时".($tmp[uploader]==0?"":"通知<b>".$sj_fet["tname"]."老师（".$sj_fet["phone"]."）</b>")."提交，以免影响本文档的提交。".($tmp[uploader]==0?"[<a href=student_m.php?mission_id=".$tmp[mission_id]."&student_number=".$number."><font color=blue><u>立即提交《".$tmp[name]."》</u></font></a>]":"")."</td></tr>";
	}
}
$now = time(0);
$tmplock = true;
if($now<$yq_fet["end_time"]) $tmplock = false;
if($upok) $tmplock = false;
if($now<$tmptime)	 $tmplock = false;
?>    

</table>

<br>	
<table width="700">
<?php
if($needok &&$yq_fet["uploader"]!=1 && !$yq_fet["lockit"]&&!$tmplock  ){  //学生上传留言
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
 if($now<$tmptime&&$now>$yq_fet["end_time"]&&!$upok){
    echo "<tr><td>&nbsp;</td><td bgcolor=red align=center><font color=yellow>临时上传功能已开启，请在 ".date("Y年m月d日",$tmptime)." 前提交文档</td></tr>";
}
 ?>
 <tr>
  <td>学生留言：</td>
  <td><textarea name="suggestion" cols="60" rows="3"  wrap="virtual"><?php
   echo $wd_fet["student_suggestion"];
  ?></textarea></td>
 </tr>
 <tr align="center">
  <td colspan="2"><input type="submit" name="submit" value="提交我最新的《<?php echo $yq_fet["name"]; ?>》"/></td>
 </tr>
</table>
</form>
</td>
</tr>
<?php  
} else if($needok&&$yq_fet[uploader]==0&& !$yq_fet["lockit"]) {
	echo "<tr><td colspan=4 align=center bgcolor=red height=28><font color=yellow>本文档要求在 ".date("Y年m月d日",$yq_fet["end_time"])." 之前上传，目前已过截止日期！请抓紧时间完成毕业设计工作，谢谢。</font></td></tr>";
	echo "<tr><td height=88 align=center valign=middle>";
	if($tmptime==999){
		echo "<font color=green><b>您已向指导教师申请临时上传权限，请等候指导教师同意！<br>您可致电指导教师，请他尽快审核您的申请（<font color=blue>在教师的“文档系统”中你的名字后面操作</font>）！</b></font>";
	} else {
		echo "<span id=s".$number.">";
		echo "<font color=blue><b>尽快向指导教师申请开启上传权限--></b></font> <input type=button onClick=\"needmoretime('s".$number."','".$number."')\" value=申请临时开启上传> ";
		echo " <font color=blue><b>迟交电子文档将影响您的考核成绩！</b></font>";
		echo "</span>";
	}
	echo "</td></tr>";
}
?>
<tr>
<td><br />说明：<br />
 <li>请及时与指导教师联系，确保课题内容能够按照老师的要求完成</li>
</td>
</tr>
</table>

<?php
function ShowMissionList()
{
	global $com_bysj, $TABLE, $com_pro_id, $number, $tmptime;
	echo "毕业设计文档要求一览表<br><br>";	
	?>
<table width="700" border=1 bordercolor=#000000 align="center" cellpadding="6">
	<tr align="center" bgColor=#5a6e8f  height=38>
		<td><font color=#FFFFFF>序号</font></td>
		<td><font color=#FFFFFF>毕业设计需要上交的电子文档</font></td>
		<td><font color=#FFFFFF>文档属性</font></td>
		<td><font color=#FFFFFF>截止日期</font></td>
		<td><font color=#FFFFFF>上传者</font></td>
		<td><font color=#FFFFFF>文档状态</font></td>
	</tr> 		
<?php			
  $count = 1;
  $sql = "select name,list.mission_id,needdoc,end_time,uploader,lockit,log.filename from ".$TABLE."mission_list as list left join (select mission_id,filename from ".$TABLE."mission_log where student_id='$number') as log on log.mission_id =list.mission_id  where year='$com_bysj'&&`pro_id`=$com_pro_id&&lockit<2 order by start_time";
  //echo $sql;
  $miss = mysql_query($sql);
  if($miss) $currrows=mysql_num_rows($miss);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=168 colspan=6 align=center>暂无文档上传任务</td></tr>";
  }    
$uperstr = array(1=>"指导教师",0=>"学生");
$lockstr = array(0=>"正常",1=>"锁定",2=>"取消");  
$now = time(0);
while($arr = @mysql_fetch_array($miss)){
	echo "<tr align=center>";
	echo "<td>$count</td>";
	echo "<td align=left><a href =".$PHP_SELF."?mission_id=".$arr["mission_id"]."><font color=blue><u>".$arr["name"]."</u></font></a></td>";
	echo "<td>".($arr["needdoc"]?"<font color=blue>重要</font>":"普通")."</td>";
	echo "<td>".date("Y-m-d",$arr["end_time"])."</td>";
	echo "<td>".$uperstr[$arr["uploader"]]."</td>";
	echo "<td>";
	if($arr[filename]==""){
		if($arr["uploader"]) echo "<font color=green>任务未下发</font>";
		else {
			if($now<$arr["end_time"])	echo "<font color=red>您未上交</font>";
			else if($tmptime==999&&$now>$arr["end_time"]) echo "<font color=green><b>已超期，申请上传权限中</b></font><br>";
			else if($now<$tmptime&&$now>$arr["end_time"]) echo "<font color=red><b>尽快上交</b></font>";
			else echo "<span id=s".$arr["mission_id"]."><font color=red><b>已超期！</b></font><input type=button onClick=\"needmoretime('s".$arr["mission_id"]."','".$number."')\" value=申请上交文档></span><br>";
		}
	} else {
		if($arr["uploader"]) echo "任务已发";
		else echo "您已上交";
	}
	if($arr["lockit"]) echo "&nbsp;[<b>已锁定</b>]";
	else if($arr["uploader"]==0) {
		if($now<$arr["end_time"]||$now<$tmptime&&$tmptime>999) echo "&nbsp;[<a href =".$PHP_SELF."?mission_id=".$arr["mission_id"]."><font color=blue><u>立即上传</u></font></a>]";
	}
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
