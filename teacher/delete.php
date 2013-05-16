<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "删除选题";
$YM_ZT2 = "删除毕业设计选题";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限:普通教师
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<?php
$id = $_GET["id"];
$sql = mysql_query("delete from ".$TABLE."topic where id = $id  && source = 0 && teacher_id = '$teacher_id'");
if($sql){
echo "<script>history.back();</script>";
}else{
echo "<script>alert('删除失败！');history.back();</script>";
}
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>