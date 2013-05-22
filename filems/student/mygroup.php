<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "答辩信息";
$YM_ZT2 = "我的毕业设计（论文）答辩信息查询";
$YM_MK = "毕业设计文档管理系统";
$YM_PT = "文档系统";
$YM_DH = 1; //需要导航条
$YM_QX = 1; //本页访问需要权限：学生
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;
?>

<?php
echo "<script  type=\"text/javascript\" src=\"ajax_js_student.js\"></script>";
$sql = "select fenzu,teacher2_id,spmissionid,year from ".$TABLE."ok_topic  where student_id = '$number'";
$aa = mysql_query($sql);
$bb = mysql_fetch_array($aa);
if($bb["fenzu"]==""){
	Show_Message("对不起，目前未进入答辩环节，或没有你的分组信息");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}


$sql = "select filename from ".$TABLE."mission_log as log where log.mission_id = $spmissionid && log.student_id = '$number'";
$que = mysql_query($sql);
$fet = mysql_fetch_array($que);
$spfilename = $fet["filename"];

if($bb["spmissionid"]<1){
	echo "<table width=700 border=1 bordercolor=#00000000>";
	echo "<tr><td>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;
	根据学校规定，毕业设计答辩由三个环节组成：指导教师考核、评阅教师评阅、答辩小组评审。毕业设计成绩由三个环节独立得分相加而得，并且三个环节属于层进关系，上一环节未通过，则不能参加下一环节的考核。</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;
	您需要将您上传到《<b>".$spname."</b>》中的文档作为送评论文，供评阅教师评阅，评阅教师将以该文档的撰写情况对您的毕业设计（论文）进行评阅和评分。您需确保已经上传了正确的送评论文，以便评阅教师的评分符合实际情况。</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;
	<b><font color=red>请点击下方的“申请论文送评”按钮，提交论文送评申请。</font></b><b>不提交申请或未在指定时间前提交申请，表示您放弃毕业设计评阅和答辩机会。</b>提交申请后，您将在此处查看自己的答辩分组安排等信息。<p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;
	当然，提交申请后，在论文正式评阅前，您还可以重复提交论文到《".$spname."》中，评阅教师将以你最后一次提交的论文主依据进行评审！</p>
	</td></tr>";
	echo "</table><br>";
}

if($spfilename==""||!file_exists("../../../Docs/".$com_bysj."/$spaddress/$spfilename")){
	Show_Message("因论文初稿未提交，你无法进入答辩环节。<br><a href=student_m.php?mission_id=$spmissionid><font color=blue><u>请尽快提交你的论文初稿</u></font></a>");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}


if($bb["spmissionid"]<1){
	echo "<span id=s".$number.">";
	echo "<input type=button onClick=\"lunwensongshen('s".$number."','".$number."','".$spmissionid."')\" value=申请论文送评> ";
	echo "</span>";
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}
?>
<?php
	echo "<table width=780 border=0 bordercolor=#00000000>";
	echo "<tr><td>";

$pysql = "select pyfilename as filename,teacher.name as tname from ".$TABLE."ok_topic as oktopic,".$TABLE."teacher_information as teacher where oktopic.teacher2_id=teacher.teacher_id&&oktopic.student_id = '$number';";
$pyque = mysql_query($pysql);
$pyfet = @mysql_fetch_array($pyque);
echo "<p align=left><font color=red size=+1><b>请注意：</b></font>";
if($pyfet[filename]!=""&& file_exists("../../../Docs/".$com_bysj."/LunWenPingYue/".$pyfet[filename])){
   	   	$crc = md5("stu".$number.date("Ymd")."crc");
   	   	echo $pyfet["tname"]."老师已经上传评阅意见，请<a href =StudentArchiveDown.php?obj=pingyue&crc=$crc title='下载该文档'><font color = blue><u>下载评阅意见</u></font></a>，按意见修订论文，并在答辩时向老师汇报修订情况。";
} else {   
	echo "<font color=blue><b><u>【在论文正式评阅日期之前，您可以随时更新最新论文电子稿到”".$spname."“中！】</u></b></font>";
}
echo "<br><font size=+1>所在小组：<b>".$bb["fenzu"][4]."组</b>";
$dbsql = "select name,mobilephone,short_number from ".$TABLE."teacher_information  where fenzu = '".$bb["fenzu"]."'&&authority=20";
//echo $dbsql;
$dbq = mysql_query($dbsql);
$dbf = mysql_fetch_array($dbq);
if($dbf["name"]!=""){
	echo " (答辩秘书：".$dbf["name"]."老师，电话：".$dbf["mobilephone"].($dbf["short_number"]?("，短号：".$dbf[short_number]):"").")";
}
echo "<br>答辩时间：<b>".$dabian[$bb["fenzu"]][0]."</b><br>答辩地点：<b>".$dabian[$bb["fenzu"]][1]."（请提前到实验室做必要准备）</b><br>请本小组同学相互转达！[<font color=green>答辩之前可能随时调整，请关注本页更新信息</font>]</font><br>
<font color=blue size=+1><b>公开答辩时间：".$gooddabian[$CURR_YEAR][0]."，地点：".$gooddabian[$CURR_YEAR][1]."！</b></font>";
?>

<table width="660" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor=#000000>
<tr bgColor=#5a6e8f height=38>
<td width="60"><font color=#FFFFFF><b><div align=center>答辩次序</div></b></font></td>
<td width="90"><font color=#FFFFFF><b><div align="center">学生班级</div></b></font></td>
<td width="80"><font color=#FFFFFF><b><div align="center">学生姓名</div></b></font></td>
<td><font color=#FFFFFF><b><div align="center">毕业设计题目</div></b></font></td>
<td width="60"><font color=#FFFFFF><b><div align="center">所在分组</div></b></font></td>
</tr>

<?php
 $sql = "SELECT oktopic.fenzu, topic,student.name as sname,class,oktopic.student_id as sid
FROM ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student
WHERE oktopic.fenzu = '".$bb["fenzu"]."'&&oktopic.student_id=student.number&&teacher2_id!=''
ORDER BY sequence, student_id";

//echo $sql;
 $sql = mysql_query($sql);
  $cnt = 1;
if($sql) $currrows=mysql_num_rows($sql);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=168 colspan=5 align=center><b>答辩次序和答辩名册尚未准备好，请稍后查看。</td></tr>";
  }      
while($row = mysql_fetch_array($sql)){
	if($row["sid"]==$number)$bgcolor="#EEEEEE";
	else $bgcolor="";
 echo "<tr align=center bgcolor=$bgcolor>";
    echo "<td>".($cnt++)."</td>";
   echo "<td>".$row["class"]."</td>";
   echo "<td>".$row["sname"]."</td>";
   echo "<td align=left>&nbsp;".$row["topic"]."</td>";
   echo "<td>".$row["fenzu"][4]."组</td>";
   echo "</tr>";
}
 echo "</table>";
 echo "</td></tr></table>";
?>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
