<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "���������������";
$YM_ZT2 = "���ñ�ҵ��ƿ��������б�";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 80; //��ҳ������ҪȨ�ޣ�����Ա
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<script language="javascript">
function is_empty(){
 if(form1.name.value==""){
   alert("��������Ҫ��ӵ�������ƣ�");
   return false;
 }
}
function is_empty2(){
 if(form1.new_name.value==""){
   alert("��������Ҫ�༭��������ƣ�"); 
   return false;
 }
}
</script>
<form name="form1" action="" method="post">
<table width="500" border="1" align="center">
<tr>
<td colspan="2"><div align="center"><strong>�������</strong></div></td>
</tr>
<tr align="center">
<td>������ѡ�����</td>
<td><input name="name" type="text" />&nbsp;&nbsp;
<input type="submit"  name="add" value="���" onclick="return is_empty()"/></td>
</tr>
</table>
<br />
<table width="500" border="1" align="center">
<tr align="center">
<td>�������</td>
<td>����</td>
</tr>
<?php
 $cc = mysql_query("select * from ".$ART_TABLE."title_sort");
 while($dd = mysql_fetch_array($cc)){
 $id = $dd["id"];
 $check = "check".$id;
?>
<tr align="center">
<td width="400"><? echo $dd["name"];?></td>
<td>
<?php
if($dd["open"]==1){
?>
<input type="checkbox" name="<?php echo $check;?>" value="1" checked="checked"/>
<?php
}else{
?>
<input type="checkbox" name="<?php echo $check;?>" value="1" />
<?php
}
?>
</td>
</tr>
<?php
if($_POST["start"]){
   if($_POST["$check"]){
     $start = 1;
   }else{
     $start = 0;
   }
  $open = mysql_query("update ".$ART_TABLE."title_sort set open = '$start' where id = $id");
  if($open){
    echo "<script>alert('�����ɹ���');history.back();</script>";
  }else{
    echo "<script>alert('����ʧ�ܣ�');history.back();</script>";
  }
}
}
?>
<tr align="center">
<td colspan="2"><input type="submit" name="start" value="����" /></td>
</tr>
</table>
<br />
<?php
if($_POST["add"]){
$name = trim($_POST["name"]);
$cd = mysql_query("select name from ".$ART_TABLE."title_sort");
$de = 0;
while($dc = mysql_fetch_array($cd)){
if($dc["name"]==$name) {
$de = 1;
echo "<script>alert('������Ѿ����ڣ�');history.back();</script>";
}
}
if($de==0){
$sql = mysql_query("insert into ".$ART_TABLE."title_sort(name,open) values ('$name','1')");
if($sql){
 echo "<script>alert('�����ӳɹ���');history.back();</script>";
}
}
}
?>
<?php
 if($_POST["revise"]){
   $select_class = $_POST["type"];
   $new_name = $_POST["new_name"];
   $update = mysql_query("update ".$ART_TABLE."title_sort set name = '$new_name' where id = '$select_class'");
   if($update){
    echo "<script>alert('����޸ĳɹ���');history.back();</script>";
   }
 }
?>
<table width="500" border="1" align="center">
<tr>
<td colspan="3"><div align="center"><strong>�޸��������</strong></div></td>
</tr>
<tr>
 <td>
 <select name="type" id="type">
   <?php    
	$query = mysql_query("select * from ".$ART_TABLE."title_sort");
	  while($row = mysql_fetch_array($query)){
	?>
  <option value="<? echo $row["id"];?>"><? echo $row["name"];?></option>
   <?php
	 }
   ?>
   </select>
  </td>
  <td>
  �µ��������<input type="text" name="new_name" />
  </td>
  <td>
  <input type="submit" name="revise" value="�༭" onclick="return is_empty2()" />
  </td>
</tr>
</table>
</form>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
