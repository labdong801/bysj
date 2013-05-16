<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>删除题目</title>
<link rel="stylesheet" type="text/css" href="../xeasy.css">
</head>

<body>
<?php
include('../connect_db.php');
$id = $_GET["id"];
$student_id = $_GET["student_id"];
$ab = mysql_query("select ".$TABLE."mission_list.address,".$TABLE."mission_log.filename from ".$TABLE."mission_list,".$TABLE."mission_log where ".$TABLE."mission_list.mission_id = ".$TABLE."mission_log.mission_id && ".$TABLE."mission_log.id = $id&&".$TABLE."mission_log.student_id =$student_id");
$ba = mysql_fetch_array($ab);
$path = "../uploadfile/$ba[address]/$ba[filename]";
if($ba[filename]!="") $delfile = @unlink($path);
$sql = mysql_query("delete from ".$TABLE."mission_log where id = $id && student_id =$student_id");
if($sql&&$delfile){
echo "<script>history.back();</script>";
}else{
echo "<script>alert('删除失败！');history.back();</script>";
}
mysql_close($link);
?>
</body>
</html>