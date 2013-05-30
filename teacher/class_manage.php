<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "毕设课题类型设置";
$YM_ZT2 = "设置毕业设计课题类型列表";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 80; //本页访问需要权限：管理员
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<script language="javascript">
function is_empty(){
 if(form1.name.value==""){
   alert("请输入您要添加的类别名称！");
   return false;
 }
}
function is_empty2(){
 if(form1.new_name.value==""){
   alert("请输入您要编辑的类别名称！"); 
   return false;
 }
}
</script>
<form name="form1" action="" method="post">
<table width="500" border="1" align="center">
<tr>
<td colspan="2"><div align="center"><strong>增加类别</strong></div></td>
</tr>
<tr align="center">
<td>请输入选题类别：</td>
<td><input name="name" type="text" />&nbsp;&nbsp;
<input type="submit"  name="add" value="添加" onclick="return is_empty()"/></td>
</tr>
</table>
<br />
<table width="500" border="1" align="center">
<tr align="center">
<td>类别名称</td>
<td>开启</td>
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
    echo "<script>alert('开启成功！');history.back();</script>";
  }else{
    echo "<script>alert('开启失败！');history.back();</script>";
  }
}
}
?>
<tr align="center">
<td colspan="2"><input type="submit" name="start" value="开启" /></td>
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
echo "<script>alert('该类别已经存在！');history.back();</script>";
}
}
if($de==0){
$sql = mysql_query("insert into ".$ART_TABLE."title_sort(name,open) values ('$name','1')");
if($sql){
 echo "<script>alert('类别添加成功！');history.back();</script>";
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
    echo "<script>alert('类别修改成功！');history.back();</script>";
   }
 }
?>
<table width="500" border="1" align="center">
<tr>
<td colspan="3"><div align="center"><strong>修改类别名称</strong></div></td>
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
  新的类别名：<input type="text" name="new_name" />
  </td>
  <td>
  <input type="submit" name="revise" value="编辑" onclick="return is_empty2()" />
  </td>
</tr>
</table>
</form>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
