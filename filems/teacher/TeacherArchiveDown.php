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
	echo "<script>alert('�Բ��������µ�¼ϵͳ��');history.back();</script>";
	exit;
}
$mission	 	= $_GET["mission"];
$student 		= $_GET["student"];
$pro 		= $_GET["pro"];
$wdyear 		= $_GET["wdyear"];
$teacher 		= $_GET["teacher"];
$obj 			= $_GET["obj"];  // mydoc �Լ����ĵ� ;  demo   �ο��ĵ�; songping ���������(����ʱ��studentΪ������)
$crc 			= $_GET["crc"];
$crcnow 		= md5("tea".$wdyear.$pro.$teacher.$student.$mission.$obj.date("Ymd")."crc");
if($crc!=$crcnow){
	mysql_close($link);
	echo "<script>alert('�Բ��𣬵�ǰ������Ȩ����Ч����ͨ������;�����أ�');history.back();</script>";
	exit;
}
if($teacher=="") $teacher=$teacher_id;
if($wdyear=="") $wdyear = $CURR_YEAR;
if($pro=="") $pro = $CURR_PID;

if($obj=="1"||$obj=="2") { 
	//���زο��ĵ�
	$sql = "select filename1,filename2,address,list.name,major.name as profession from ".$TABLE."mission_list as list,".$TABLE."major as major where list.pro_id=major.id&&major.type=4&&mission_id='$mission'&&year='$wdyear'";
} else if($obj=="songping") {
	//���ش�������������
	$fenzu = $student; //���student ������Ƿ����
	$sql = "select log.filename,address,list.name,student.profession,class,student.name as studentname,oktopic.topic  from ".$TABLE."mission_list as list,".$TABLE."mission_log  as log,".$TABLE."student_sheet as student,".$TABLE."ok_topic as oktopic where list.mission_id=oktopic.spmissionid &&oktopic.student_id=log.student_id&& log.mission_id=list.mission_id &&student.number=oktopic.student_id&&  oktopic.fenzu = '$fenzu'  ORDER BY sequence, oktopic.student_id";
} else if($obj=="alldoc") {
	//����һ���ĵ�
	$where = "list.year='$wdyear'&&list.mission_id=log.mission_id&&student.number=log.student_id&&log.teacher_id=teacher.teacher_id";
	if($teacher!="allteacher")	$where .= "&&log.teacher_id='$teacher'";
	if($student!="allstudent")	$where .= "&&log.student_id='$student'";
	if($pro!="allpro") $where .= "&&list.pro_id='$pro'";
	if($mission!="allmission") $where .= "&&list.mission_id='$mission'";
	$sql = "select log.filename,address,list.name,student.profession,class,student.name as studentname,teacher.name as teachername from ".$TABLE."mission_list as list,".$TABLE."mission_log  as log,".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher where ".$where;
} else {
	//����ĳ�ˡ�ĳѧ����ĳ�ĵ�
	$sql = "select log.filename,address,list.name,profession,class,student.name as studentname from ".$TABLE."mission_list as list,".$TABLE."mission_log  as log,".$TABLE."student_sheet as student where log.student_id='$student'&&log.mission_id='$mission'&&list.mission_id=log.mission_id&&list.year='$wdyear'&&student.number=log.student_id";
}
//echo $sql."<br>";
//exit;
$que = mysql_query($sql);
if(!$que){
	mysql_close($link);
	echo "<script>alert('�Բ����Ҳ�������Ҫ���ص��ļ���');history.back();</script>";
	exit;
}
$canzip = true;

if($obj=="1"||$obj=="2"){
	//���زο��ĵ�
	$wd_fet = mysql_fetch_array($que);
	$filelist =  "../../../Docs/".$wdyear."/".$wd_fet["filename".$obj];
	$namelist = $wdyear."��".$wd_fet[profession]."רҵ��ҵ��ơ�".($wd_fet[name])."���ο��ĵ�".($obj==2?"����ѧ�о���ר�ã�":"");
	$zipfilename = $wd_fet[profession]."רҵ��".($wd_fet[name])."���ο��ĵ�".($obj==2?"����ѧ�о���ר�ã�":"").".zip";
	if(!file_exists($filelist)||!is_file($filelist)){
		echo "<script>alert('�Բ����Ҳ�������Ҫ���ص��ļ���');history.back();</script>";	
		$canzip = false;
	}
} else if($obj=="songping") {
	//����һ���ĵ�
	$count = 0;
	$cxid = 0;
	while($wd_fet = mysql_fetch_array($que)){
		$cxid ++;
		$filename =  "../../../Docs/".$wdyear."/".$wd_fet[address]."/".$wd_fet[filename];
		if(!file_exists($filename)||!is_file($filename)) continue;
		$filelist[] = $filename;
		$namelist[] = $cxid.".".$wd_fet[studentname]."��".$wd_fet[topic]."��";
		$count ++;
	}
	$zipfilename = $wdyear."���ҵ���".$fenzu."���������Ĵ��.zip";
	if($count==0) {
		//echo "<br>$sql<br>";
		//print_r($filelist);
		echo "<script>alert('�Բ��𣬵�ǰû���κη����������Դ�����ļ���');history.back();</script>";	
		$canzip = false;
	}
} else if($obj=="alldoc") {
	//����һ���ĵ�
	$count = 0;
	while($wd_fet = mysql_fetch_array($que)){
		if($teachername==""){
			if($teacher=="allteacher")$teachername = "ȫ���ʦ";
			else $teachername = $wd_fet[teachername];
			if($student=="allstudent")$studentname = "ȫ��ѧ��";
			else $studentname = $wd_fet[studentname];
			if($pro=="allpro")$proname = "����";
			else $proname = $wd_fet[profession];
			if($mission=="allmission") $missionname = "�����ĵ�";
			else $missionname = $wd_fet[name];
		}
		$filename =  "../../../Docs/".$wdyear."/".$wd_fet[address]."/".$wd_fet[filename];
		if(!file_exists($filename)||!is_file($filename)) continue;
		$filelist[] = $filename;
		$namelist[] = $wdyear."���ҵ��ơ�".($wd_fet[name])."����".$wd_fet[studentname]."��";
		$count ++;
	}
	$zipfilename = $wdyear."��".$proname."רҵ".$teachername."ָ����".$studentname."��".$missionname."���.zip";
	if($count==0) {
		//echo "<br>$sql<br>";
		//print_r($filelist);
		echo "<script>alert('�Բ��𣬵�ǰû���κη����������Դ�����ļ���');history.back();</script>";	
		$canzip = false;
	}
} else {
	//����ĳ�ˡ�ĳѧ����ĳ�ĵ�
	$wd_fet = mysql_fetch_array($que);
	$filelist =  "../../../Docs/".$wdyear."/".$wd_fet[address]."/".$wd_fet[filename];
	$namelist = $wdyear."���ҵ��ơ�".($wd_fet[name])."����".$wd_fet[studentname]."��";
	$zipfilename = $wd_fet[studentname]."��ҵ��ơ�".($wd_fet[name])."��.zip";
	if(!file_exists($filelist)||!is_file($filelist)){
		echo "<script>alert('�Բ����Ҳ�������Ҫ���ص��ļ���');history.back();</script>";	
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