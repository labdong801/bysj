<?php
session_start();
include("../../connect_db.php");
include("../../global_fun.php");
include("../../PHPzip.php");
$number = $_SESSION["com_id"];
$com_online = $_SESSION["com_online"];

if(!$com_online||!$number){
	mysql_close($link);
	echo "<script>alert('�Բ��������µ�¼ϵͳ��');history.back();</script>";
	exit;
}
$mission_id = $_GET["mission_id"];
$obj = $_GET["obj"];  // mydoc �Լ����ĵ�;   demo   �ο��ĵ� ; pingyue ���ķ���
$crc = $_GET["crc"];
$crcnow = md5("stu".$mission_id.$number.date("Ymd")."crc");
if($crc!=$crcnow){
	mysql_close($link);
	echo "<script>alert('�Բ��𣬵�ǰ����������ʧЧ�����������أ�');history.back();</script>";
	exit;
}

if($obj == "pingyue")
	$sql = "select pyfilename as filename,year from ".$TABLE."ok_topic where student_id='$number'";
else 
	$sql = "select list.filename1,list.filename2,log.filename,address,list.name from ".$TABLE."mission_list as list left join(select mission_id,filename from ".$TABLE."mission_log where student_id='$number') as log on list.mission_id=log.mission_id where list.year='$com_bysj'&&list.mission_id='$mission_id'";
//echo $sql."<br>";
$que = mysql_query($sql);
if(!$que){
	mysql_close($link);
	echo "<script>alert('�Բ����Ҳ�������Ҫ���ص��ļ���');history.back();</script>";
	exit;
}
$wd_fet = mysql_fetch_array($que);
if($obj=="1"||$obj=="2"){
	$filelist =  "../../../Docs/".$com_bysj."/".$wd_fet["filename".$obj];
	$zipfilename = $com_bysj."���ҵ��ơ�".($wd_fet[name])."���ο��ĵ�";
} else if($obj=="pingyue"){
	$filelist =  "../../../Docs/".$com_bysj."/LunWenPingYue/".$wd_fet[filename];
	$zipfilename = "���Ľ�ʦ���ķ���";
} else {
	$filelist =  "../../../Docs/".$com_bysj."/".$wd_fet[address]."/".$wd_fet[filename];
	$zipfilename = $com_bysj."���ҵ��ơ�".($wd_fet[name])."��";
}

mysql_close($link);

if(!file_exists($filelist)||!is_file($filelist)){
	echo "<script>alert('�Բ����Ҳ�������Ҫ���ص��ļ���');history.back();</script>";
} else {       
       $archive = new PHPZip();
       ob_end_clean();
       $archive->DownZipfile($filelist,$zipfilename.".zip",$zipfilename);
       //echo $filelist."<br>".$zipfilename."<br>".$obj."<br>".$wd_fet["filename".$obj];
}
?>