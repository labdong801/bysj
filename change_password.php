<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�޸ĵ�¼����";
$YM_MK = "��ҵ��ƹ���ϵͳ";
$YM_DH = 0; //����Ҫ������
$YM_QX = 0; //��ҳ������ҪȨ��
include($baseDIR."/bysj/inc_head.php");

if(!$_POST["submit"]){
 ?>

<script language="javascript">
function text_value(){
  if(pwd.password.value==""){
    alert('����дԭ�������룡');
	pwd.password.focus();
	return false;
  }
  if(pwd.newpassword.value==""){
    alert('����д�µ����룡');
	pwd.newpassword.focus();
	return false;
  }
  if(pwd.renewpassword.value==""){
    alert('��һ�����������룡');
	pwd.renewpassword.focus();
	return false;
  }
  if(pwd.newpassword.value!=pwd.renewpassword.value){
    alert('����д�������벻һ�£���������д');
	pwd.newpassword.value="";
	pwd.renewpassword.value="";
	pwd.newpassword.focus();
	return false;
  }
  if(pwd.newpassword.value!=pwd.Password.value){
    alert('����д��������ԭ����һ�£���������д');
	pwd.newpassword.value="";
	pwd.renewpassword.value="";
	pwd.newpassword.focus();
	return false;
  }
  return true;
}
 function new_id_test(obj){
 		obj.value=obj.value.replace(/[^\u4E00-\u9FA50-9a-zA-Z_]*$/g,"")
 		obj.value=obj.value.replace(/^[0-9]*$/g,"")
 		newidres.innerHTML='2��10�ַ�';
 }
</script>
<script  type="text/javascript" src="teacher/teacher_ajax.js"></script>
<br>&nbsp;<br>
<form id="pwd" name="pwd" method="post" action="<?php echo $PHP_SELF;?>">
<table width="600" border="0" align="center">
 <tr>
  <td colspan="2" height=38 bgcolor=#4A5E7F align=center><font color=#FFFFFF size=+1><b>�޸�����</b></font></td>
 </tr>
<?php
if($com_type=="teacher") echo "<tr>
<td height=58 align=right>�޸ĵ�¼�ʺţ�</td><td><input type=text onblur=\"changealias('newidres',this.value)\" maxlength=10 onkeyUp=new_id_test(this) name=new_id value=".$com_id."> (<span id=newidres>2��10�ַ�</span>)<br>��֧�ֺ��֡���ĸ�����֣���һ�ַ������֣�
</td>	
</tr>";
?>

 <tr>
  <td height=38 align=right>
   ������ԭ�������룺
  </td>
  <td>
   <input type="password" name="password" />
  </td>
 </tr>
  <tr>
  <td height=38 align=right>
   �������µ����룺
  </td>
  <td>
   <input type="password" name="newpassword" />
  </td>
 </tr>
  <tr>
  <td height=38 align=right>
   ��һ�������µ����룺
  </td>
  <td>
   <input type="password" name="renewpassword" />
  </td>
 </tr>
 <tr>
 <td colspan="2" align="center" height=46>
 	<input type=hidden name=histype value=<?php echo $com_type;?>>
  <input type="submit" name="submit" value="�޸��ҵ�����" onclick="return text_value()"  style="BACKGROUND-COLOR: #333D66; COLOR: #ffffff; HEIGHT: 36px; FONT-SIZE: 16px"/> 
 </td>
 </tr>
 </table>
</form>
<?
} else {
$password = trim($_POST["password"]);
$newpassword = trim($_POST["newpassword"]);
if($com_type=="student")  $sql = "update ".$TABLE."student_sheet set password = '$newpassword' where number = '$com_id' && password='$password'";
else $sql = "update ".$TABLE."teacher_information set password = '$newpassword' where teacher_id = '$com_id' && password='$password'";
 $query = mysql_query($sql);
 if(mysql_affected_rows()>0){
  show_message("�����޸ĳɹ���");
 }else{
  show_message("�����޸�ʧ�ܣ�");
 }
}
?>
<?php
@include($baseDIR."/bysj/inc_foot.php");
?>
