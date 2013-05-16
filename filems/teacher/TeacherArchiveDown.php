<?php
session_start();
@set_time_limit(0); 
include("../../connect_db.php");
include("../../global_fun.php");
include("../../PHPzip.php");
$teacher_id = $_SESSION["com_id"];
$com_online = $_SESSION["com_online"];

if(!$com_online||!$teacher_id){
	mysql_close($link);
	echo "<script>alert('对不起，请重新登录系统！');history.back();</script>";
	exit;
}
$mission	 	= $_GET["mission"];
$student 		= $_GET["student"];
$pro 		= $_GET["pro"];
$wdyear 		= $_GET["wdyear"];
$teacher 		= $_GET["teacher"];
$obj 			= $_GET["obj"];  // mydoc 自己的文档 ;  demo   参考文档; songping 答辩用论文(送评时，student为分组编号)
$crc 			= $_GET["crc"];
$crcnow 		= md5("tea".$wdyear.$pro.$teacher.$student.$mission.$obj.date("Ymd")."crc");
if($crc!=$crcnow){
	mysql_close($link);
	echo "<script>alert('对不起，当前下载授权码无效，请通过正规途经下载！');history.back();</script>";
	exit;
}
if($teacher=="") $teacher=$teacher_id;
if($wdyear=="") $wdyear = $CURR_YEAR;
if($pro=="") $pro = $CURR_PID;

if($obj=="1"||$obj=="2") { 
	//下载参考文档
	$sql = "select filename1,filename2,address,list.name,major.name as profession from ".$TABLE."mission_list as list,".$TABLE."major as major where list.pro_id=major.id&&major.type=4&&mission_id='$mission'&&year='$wdyear'";
} else if($obj=="songping") {
	//下载答辩分组送评文章
	$fenzu = $student; //这里，student 带入的是分组号
	$sql = "select log.filename,address,list.name,student.profession,class,student.name as studentname,oktopic.topic  from ".$TABLE."mission_list as list,".$TABLE."mission_log  as log,".$TABLE."student_sheet as student,".$TABLE."ok_topic as oktopic where list.mission_id=oktopic.spmissionid &&oktopic.student_id=log.student_id&& log.mission_id=list.mission_id &&student.number=oktopic.student_id&&  oktopic.fenzu = '$fenzu'  ORDER BY sequence, oktopic.student_id";
} else if($obj=="alldoc") {
	//下载一批文档
	$where = "list.year='$wdyear'&&list.mission_id=log.mission_id&&student.number=log.student_id&&log.teacher_id=teacher.teacher_id";
	if($teacher!="allteacher")	$where .= "&&log.teacher_id='$teacher'";
	if($student!="allstudent")	$where .= "&&log.student_id='$student'";
	if($pro!="allpro") $where .= "&&list.pro_id='$pro'";
	if($mission!="allmission") $where .= "&&list.mission_id='$mission'";
	$sql = "select log.filename,address,list.name,student.profession,class,student.name as studentname,teacher.name as teachername from ".$TABLE."mission_list as list,".$TABLE."mission_log  as log,".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher where ".$where;
} else {
	//下载某人、某学生、某文档
	$sql = "select log.filename,address,list.name,profession,class,student.name as studentname from ".$TABLE."mission_list as list,".$TABLE."mission_log  as log,".$TABLE."student_sheet as student where log.student_id='$student'&&log.mission_id='$mission'&&list.mission_id=log.mission_id&&list.year='$wdyear'&&student.number=log.student_id";
}
//echo $sql."<br>";
//exit;
$que = mysql_query($sql);
if(!$que){
	mysql_close($link);
	echo "<script>alert('对不起，找不到您需要下载的文件！');history.back();</script>";
	exit;
}
$canzip = true;

if($obj=="1"||$obj=="2"){
	//下载参考文档
	$wd_fet = mysql_fetch_array($que);
	$filelist =  "../../../Docs/".$wdyear."/".$wd_fet["filename".$obj];
	$namelist = $wdyear."届".$wd_fet[profession]."专业毕业设计《".($wd_fet[name])."》参考文档".($obj==2?"（科学研究类专用）":"");
	$zipfilename = $wd_fet[profession]."专业《".($wd_fet[name])."》参考文档".($obj==2?"（科学研究类专用）":"").".zip";
	if(!file_exists($filelist)||!is_file($filelist)){
		echo "<script>alert('对不起，找不到您需要下载的文件！');history.back();</script>";	
		$canzip = false;
	}
} else if($obj=="songping") {
	//下载一批文档
	$count = 0;
	$cxid = 0;
	while($wd_fet = mysql_fetch_array($que)){
		$cxid ++;
		$filename =  "../../../Docs/".$wdyear."/".$wd_fet[address]."/".$wd_fet[filename];
		if(!file_exists($filename)||!is_file($filename)) continue;
		$filelist[] = $filename;
		$namelist[] = $cxid.".".$wd_fet[studentname]."《".$wd_fet[topic]."》";
		$count ++;
	}
	$zipfilename = $wdyear."届毕业设计".$fenzu."组送评论文打包.zip";
	if($count==0) {
		//echo "<br>$sql<br>";
		//print_r($filelist);
		echo "<script>alert('对不起，当前没有任何符合条件可以打包的文件！');history.back();</script>";	
		$canzip = false;
	}
} else if($obj=="alldoc") {
	//下载一批文档
	$count = 0;
	while($wd_fet = mysql_fetch_array($que)){
		if($teachername==""){
			if($teacher=="allteacher")$teachername = "全体教师";
			else $teachername = $wd_fet[teachername];
			if($student=="allstudent")$studentname = "全体学生";
			else $studentname = $wd_fet[studentname];
			if($pro=="allpro")$proname = "所有";
			else $proname = $wd_fet[profession];
			if($mission=="allmission") $missionname = "所有文档";
			else $missionname = $wd_fet[name];
		}
		$filename =  "../../../Docs/".$wdyear."/".$wd_fet[address]."/".$wd_fet[filename];
		if(!file_exists($filename)||!is_file($filename)) continue;
		$filelist[] = $filename;
		$namelist[] = $wdyear."届毕业设计《".($wd_fet[name])."》（".$wd_fet[studentname]."）";
		$count ++;
	}
	$zipfilename = $wdyear."届".$proname."专业".$teachername."指导的".$studentname."的".$missionname."打包.zip";
	if($count==0) {
		//echo "<br>$sql<br>";
		//print_r($filelist);
		echo "<script>alert('对不起，当前没有任何符合条件可以打包的文件！');history.back();</script>";	
		$canzip = false;
	}
} else {
	//下载某人、某学生、某文档
	$wd_fet = mysql_fetch_array($que);
	$filelist =  "../../../Docs/".$wdyear."/".$wd_fet[address]."/".$wd_fet[filename];
	$namelist = $wdyear."届毕业设计《".($wd_fet[name])."》（".$wd_fet[studentname]."）";
	$zipfilename = $wd_fet[studentname]."毕业设计《".($wd_fet[name])."》.zip";
	if(!file_exists($filelist)||!is_file($filelist)){
		echo "<script>alert('对不起，找不到您需要下载的文件！');history.back();</script>";	
		$canzip = false;
	}
}

mysql_close($link);
if($canzip){
       $archive = new PHPZip();
       ob_end_clean();
       $archive->DownZipfile($filelist,$zipfilename,$namelist);
}
?>