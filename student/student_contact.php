<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "ѧ����ϵ��ʽ";
$YM_ZT2 = "���ø�����Ϣ����ϵ��ʽ";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 1; //��ҳ������ҪȨ�ޣ���ͨѧ��
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;

$sql = "select * from ".$TABLE."student_sheet where number='$number'";
$que_sql = mysql_query($sql);
$bbb = mysql_fetch_array($que_sql);
 ?>
 
 <form id="form1" name="form1" method="post" action="">
<table width="500" border="1"   cellpadding=5  bordercolor=#000000>
<tr>
<td width="120">����ţ�</td>
<td><input type="text" name="dorm" value="<? echo $bbb["dorm"];?>"/></td>
</tr>
<tr>
<td>��ϵ�绰��</td>
<td><input type="text" name="phone" value="<? echo $bbb["phone"];?>"/></td>
</tr>
<tr>
<td>�ֻ����룺</td>
<td><input type="text" name="mobilephone" value="<? echo $bbb["mobilephone"];?>"/></td>
</tr>
<tr>
<td>���룺</td>
<td><input type="text" name="short_number" value="<? echo $bbb["short_number"];?>"/></td>
</tr>
<tr>
<td>QQ���룺</td>
<td><input type="text" name="qq_number" value="<? echo $bbb["qq_number"];?>"/></td>
</tr>
<tr>
<td>�������䣺</td>
<td><input type="text" name="email" value="<? echo $bbb["email"];?>"/></td>
</tr>
<tr>
<td>�ɼ��������ۣ�</td>
<td><?php
	$cj = $bbb["chengji"];
	$cjc = array(0=>"һ��",1=>"�ϲ�",2=>"�ܲ�",3=>"�Ϻ�",4=>"�ܺ�");
	for($i=0;$i<5;$i++){
		if($i==$cj) $s = " checked";
		else $s = "";
		echo "<input type=radio name=chengji  value=".$i.$s."> ".$cjc[$i]."&nbsp;&nbsp;&nbsp;";
	}
	?></td>
</tr>
<tr>
<td>������Ȥ����</td>
<td><input type="text" name="aihao" value="<? echo $bbb["aihao"];?>"/></td>
</tr>
</table>
<br>
<input type="submit" name="submit" value="�ύ�ҵĸ�������" /></td>
</form>
<?php
  if($_POST["submit"]){
    $dorm = trim($_POST["dorm"]);
	$phone = trim($_POST["phone"]);
	$mobilephone = trim($_POST["mobilephone"]);
	$short_number = trim($_POST["short_number"]);
	$qq_number = trim($_POST["qq_number"]);
	$email = trim($_POST["email"]);
	$chengji = trim($_POST["chengji"]);
	$aihao = trim($_POST["aihao"]);
	$sql = mysql_query("update ".$TABLE."student_sheet set dorm='$dorm',phone= '$phone',mobilephone='$mobilephone',short_number='$short_number',qq_number='$qq_number',email='$email',aihao='$aihao',chengji='$chengji' where number = '$number'");
	if($sql){
	 echo "<script>alert('�����ύ�ɹ���');history.back();</script>";
	}else{
	 echo "<script>alert('�����ύʧ�ܣ�');history.back();</script>";
	}
  }
?>

<?
  @include($baseDIR."/bysj/inc_foot.php");
?>
