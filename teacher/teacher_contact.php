<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "��ʦ��ϵ��ʽ";
$YM_ZT2 = "ָ����ʦ������ϵ��ʽ";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��:��ͨ��ʦ
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 
 <?php
 $aaa = mysql_query("select * from ".$TABLE."teacher_information where teacher_id = '$teacher_id'");
$row = mysql_fetch_array($aaa);
?>

ע������Ϣ����������ָ����ѧ���鿴���������д��
<form id="form1" name="form1" method="post" action="">
<table width="500" border="1"    cellpadding=5 bordercolor=#000000>
<tr>
<td width="120">�������䣺</td>
<td><input type="text" name="email" value="<? echo $row["email"];?>"/></td>
</tr>
<tr>
<td width="120">�칫�绰��</td>
<td><input type="text" name="officephone" value="<? echo $row["officephone"];?>"/></td>
</tr>
<tr>
<td>��ͥ�绰��</td>
<td><input type="text" name="homephone" value="<? echo $row["homephone"];?>"/></td>
</tr>
<tr>
<td>�ֻ����룺</td>
<td><input type="text" name="mobilephone" value="<? echo $row["mobilephone"];?>"/></td>
</tr>
<tr>
<td>���룺</td>
<td><input type="text" name="short_number" value="<? echo $row["short_number"];?>"/></td>
</tr>
<tr>
<td>QQ���룺</td>
<td><input type="text" name="qq_number" value="<? echo $row["qq_number"];?>"/></td>
</tr>
</table>
<br>
<input type="submit" name="submit" value="�ύ�ҵĸ�����ϵ��Ϣ" />
</form>

<?php
  if($_POST["submit"]){
    	$email = trim($_POST["email"]);
    	$officephone = trim($_POST["officephone"]);
	$homephone = trim($_POST["homephone"]);
	$mobilephone = trim($_POST["mobilephone"]);
	$short_number = trim($_POST["short_number"]);
	$qq_number = trim($_POST["qq_number"]);
	$sql = mysql_query("update ".$TABLE."teacher_information set email='$email',officephone='$officephone',homephone= '$homephone',mobilephone='$mobilephone',short_number='$short_number',qq_number='$qq_number' where teacher_id = '$teacher_id'");
	if($sql){
	 echo "<script>alert('�����ύ�ɹ���');history.back();</script>";
	}else{
	 echo "<script>alert('�����ύʧ�ܣ�');history.back();</script>";
	}
  }
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>