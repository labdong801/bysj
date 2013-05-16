<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>删除建议</title>
</head>

<body>
<?php
include('../connect_db.php');
$id = $_GET["id"];
$sql = mysql_query("delete from ".$TABLE."suggestion where id = $id");
if($sql){
echo "<script>history.back();</script>";
}else{
echo "<script>alert('删除失败！');history.back();</script>";
}
mysql_close($link);
?>
</body>
</html>
