<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�鿴����</title>
<style>
.align_top{vertical-align:top}
</style>
<link rel="stylesheet" type="text/css" href="../xeasy.css">
</head>

<body>
<?php
include("../head.html");
?>
<?php
include("../connect_db.php");
$teacher_id = $_SESSION["teacher_id"];
$aa = mysql_query("select authority from ".$TABLE."teacher_information where teacher_id = '$teacher_id'");
$bb = mysql_fetch_array($aa);
if($bb["authority"] == 99){
?>
<table width="960" align="center">
<tr class="align_top">
<td align="center">
<?php
include("navigation.php");
?>
</td>
<td>
<table width="780">
<tr>
<td align="center">�鿴�ض�ѡ�⣺<a href="all_m.php?is_check=-1">δͨ��</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="all_m.php?is_check=1">�����</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="all_m.php?is_check=0">�����</a>
</td>
</tr>
</table>
<br /><br />
<table width="780" align="center" border="1">
<tr align="center">
<td width="50">���</td>
<td>����</td>
<td width="80">��ʦ</td>
<td width="80">ѧ��</td>
<td width="60">�ϴ���</td>
<td width="60">���</td>
<td width="60">����</td>
<td width="50">�޸�</td>
<td width="50">ɾ��</td>
</tr>
<?php
$is_check = $_GET["is_check"];
$ab = mysql_query("select ".$TABLE."mission_log.id as mid,".$TABLE."mission_log.is_check,".$TABLE."mission_log.lock_flag,".$TABLE."mission_log.student_id as mnumber,".$TABLE."mission_list.name as mlname,".$TABLE."mission_list.uploader,".$TABLE."mission_list.mission_id as mlid,".$TABLE."teacher_information.name as tiname,".$TABLE."student_sheet.name as ssname from ".$TABLE."mission_log,".$TABLE."mission_list,".$TABLE."teacher_information,".$TABLE."student_sheet where ".$TABLE."mission_log.teacher_id = ".$TABLE."teacher_information.teacher_id && ".$TABLE."mission_log.student_id = ".$TABLE."student_sheet.number && ".$TABLE."mission_log.mission_id = ".$TABLE."mission_list.mission_id && ".$TABLE."mission_log.is_check = $is_check order by ".$TABLE."mission_log.id desc");
$mission_num = 1;
$arr_uploader = array("0"=>"�����ϴ�","1"=>"��ʦ","2"=>"ѧ��"); 
$arr_check = array("-1"=>"<font color = 'red'>δͨ��</font>","1"=>"�����","0"=>"<font color = 'green'>�����</font>");
$arr_lock = array("0"=>"δ����","1"=>"<font color = 'red'>������</font>");
while($ba = mysql_fetch_array($ab)){
?>
<tr>
<td align="center"><?php echo $mission_num;?></td>
<td><a href="detail_m.php?mission_id=<?php echo $ba["mid"];?>" title="��˻�����������"><?php echo $ba["mlname"];?></a></td>
<td><?php echo $ba["tiname"];?></td>
<td><?php echo $ba["ssname"];?></td>
<td align="center"><?php echo $arr_uploader["$ba[uploader]"];?></td>
<td align="center"><?php echo $arr_check["$ba[is_check]"];?></td>
<td align="center"><?php echo $arr_lock["$ba[lock_flag]"];?></td>
<td align="center"><a href="revise.php?mission_log=<?php echo $ba["mlid"];?>">�޸�</a></td>
<td align="center"><a href="delete.php?id=<?php echo $ba["mid"];?>&student_id=<?php echo $ba["mnumber"];?>" onclick="return confirm('��ȷ��Ҫɾ����')">ɾ��</a></td>
</tr>
<?php
$mission_num = $mission_num+1;
}
?>
</table>
<table width="780" align="center">
<tr>
<td>˵����<br />
<li>�ɵ����δͨ������������ˡ��򡾴���ˡ����������鿴�ض���ѡ�⣻</li>
<li>���������������ĳ���������˺�����ѡ�⣻</li>
</td>
</tr>
</table>
</td>
</tr>
</table>
<?php
}else{
 echo "<script>alert('�Բ�����ûȨ���ʸ�ҳ�棡');history.back();</script>";
}
?>
<?php
include("../tail.html");
mysql_close($link);
?>
</body>
</html>