<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "ɾ��ѡ��";
$YM_ZT2 = "ɾ����ҵ���ѡ��";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��:��ͨ��ʦ
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<?php
$id = $_GET["id"];
$sql = mysql_query("delete from ".$TABLE."topic where id = $id  && source = 0 && teacher_id = '$teacher_id'");
if($sql){
echo "<script>history.back();</script>";
}else{
echo "<script>alert('ɾ��ʧ�ܣ�');history.back();</script>";
}
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>