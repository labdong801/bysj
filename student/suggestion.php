<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�������";
$YM_ZT2 = "��ӭ�ύ��������ͽ���";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 1; //��ҳ������ҪȨ�ޣ���ͨѧ��
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;
 ?>
 <script language="javascript">
function is_empty(){
 if(form1.advise.value==""){
   alert("�ύ������ͽ��鲻��Ϊ�գ�");
   return false;
 }
}
</script>

<table width="600" align="center"    cellpadding=5  bordercolor=#000000 border=0>
<tr>
<td><font color="#FF0000">������Ա�ϵͳ����ʲô����ͽ��飬�������������ԣ����ǻᾡ���Ľ���ϵͳ���ڵĲ��㣬�Ա���õ������ҵ�����</font>
</td>
</tr>
</table>
<p>
<table width="600" border="1" align="center"     cellpadding=5  bordercolor=#000000>
<?php
 function disEnter($str){
   $content = str_replace("\n","<br>",$str);
   return $content;
 }
 $ak = mysql_query("select * from ".$TABLE."suggestion where account = '$number'");
?>
<?php
 while($ka = mysql_fetch_array($ak)){
?>
<tr>
<td bgColor=#5a6e8f><font color=#FFFFFF>����</font></td>
</tr>
<tr>
<td><? echo disEnter($ka["advise"]);?></td>
</tr>
<tr>
<td><a href="../teacher/delete_suggestion.php?id=<?php echo $ka["id"];?>" onclick="return confirm('��ȷ��Ҫɾ����')">ɾ��</a></td>
</tr>
<?php
if($ka["answer"]!="0"){
?>
<tr>
<td bgcolor="#999999">�ظ�:</td>
</tr>
<tr>
<td><? echo disEnter($ka["answer"]);?></td>
</tr>
<?php
}
}
?>
</table>
<form name="form1" action="" method="post">
<table width="600" border="1" align="center"     cellpadding=5  bordercolor=#000000>
<tr>
<td><div align="center" class="STYLE1">��������ͽ���</div></td>
</tr>
<tr>
<td align="center"><textarea name="advise" cols="60" rows="8"  wrap="virtual"></textarea></td>
</tr>
<tr>
<td align="center"><input type="submit" name="submit" value="�ύ" onclick="return is_empty()"/></td>
</tr>
</table>
</form>
<?php
 if($_POST["submit"]){
   $advise = $_POST["advise"];
   $sql = mysql_query("insert into ".$TABLE."suggestion(account,advise,answer) values ('$number','$advise','0')");
   if($sql){
     echo "<script>alert('�����ύ�ɹ�����л��������ͽ��飡');history.back();</script>";
   }else{
     echo "<script>alert('�����ύʧ�ܣ�');history.back();</script>";
   }
 }
?>


<?
  @include($baseDIR."/bysj/inc_foot.php");
?>
