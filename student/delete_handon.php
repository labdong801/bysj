<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>删除学生自选题</title>
</head>

<body>
<?
include('../connect_db.php');
$id = $_GET["id"];
$sql = mysql_query("delete from ".$TABLE."topic where id = $id && source = 1");
if($sql){
   $query = mysql_query("delete from ".$TABLE."student_select where topic_num = $id");
}
if($sql&&$query){
echo "<script>window.location.href='selecttitle.php';</script>";
}else{
echo "<script>alert('删除失败！');window.location.href='selecttitle.php';</script>";
}
mysql_close($link);
?>
</body>
</html>
