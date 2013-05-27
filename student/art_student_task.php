
<?php
$self= $PHP_SELF;//文件相对地址
$filename = $_SERVER["SCRIPT_FILENAME"];//获取文件绝对地址
$loc= strpos($filename,$self);//自己相对地址在绝对地址中出现的位置
$baseDIR = substr($filename,0,$loc);//根本地址
$YM_ZT = "学生查询";
$YM_ZT2 = "学生任务查询";
$YM_MK = "毕业设计双向选题系统";
$YM_PT ="任务查询";
$YM_DH = 1; //需要导航条
$YM_QX = 1; //管理员权限
include($baseDIR."/bysj/inc_head.php");
$student_id = $com_id;
$Grade=$grade+2000;
$Class=JC($Grade);
 ?>

<table width="100%" align="center">

<tr>
<td >


<table width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td width="100%"><font color=#FFFFFF >学生任务</font></td>
</tr>
</table>
<br>

<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr><td style="font-size:16px;">任务名称</td><td style="font-size:16px;">任务时间</td><td style="font-size:16px;" align="center">是否上交</td><td style="font-size:16px;">操作</td></tr>
<?php


$sql = "select * from ".$ART_TABLE."teacher_task where  class='$Class' order by id desc";
$result=mysql_query($sql);
if($result)
 {
   while($row=mysql_fetch_array($result))
   {
   	?>
  <tr>
  <td width="30%"><a href="?content_id=<?php echo $row[id]?>"><?php echo $row[title];?></a></td>
  <td width="50%"><?php echo $row['start_time']."----".$row['end_time']?></td>
  <td width="10%" align="center"><a href="?edit_id=<?php echo $row[id]?>">是</a></td>
  <td width="5%"><a href="?del_id=<?php echo $row[id]?>">上交</a></td>
  </tr>
   	<?
   }
 }
 else{
 	echo "fail";
 	?>
 	<?
 }
?>
</table>



</td>
</tr>
</table>

<?php
if($_POST['submit'])
{
	//任务设置
   if($_GET['Choice'])
   {
	$sql="insert into ".$ART_TABLE."teacher_task(title,content,start_time,end_time,teacher,class)"."values('$_POST[title]','$_POST[content]','$_POST[start_time]','$_POST[end_time]','$teacher_id','$choice')";
	if(mysql_query($sql))
	{
		echo "<script>alert('设置成功')</script>";
	}
	 else
	{
		echo "<script>alert('设置失败');history.back(1);</script>";
	}
   }
   //编辑
   else if($_GET['edit_id'])
   {
   	$sql="UPDATE $f SET $key_value WHERE $where";
   	$sql="update ".$ART_TABLE."teacher_task set title='$_POST[title]',content='$_POST[content]',start_time='$_POST[start_time]',end_time='$_POST[end_time]' where id='$_GET[edit_id]'";
	if(mysql_query($sql))
	{
		echo "<script>alert('更新成功');history.go(-2);</script>";
	}
	 else
	{
		echo "<script>alert('更新失败');history.back(1);</script>";
	}
   }
}
?>


<?php
//删除
if($_GET['del_id'])
{
	$s="DELETE FROM ".$ART_TABLE."teacher_task where id='$_GET[del_id]'";

	if(mysql_query($s))
	{
		echo "<script>alert('删除成功');history.go(-1);</script>";
	}
	else
	{
		echo "<script>alert('删除失败');</script>";
	}
}

?>

<?
//判断所属 年纪（大一，大二...）
 function JC($year)
{
	$time=date("Y");
   $mothe=date("m");
   $grade=$time-$year;

if($mothe<9)
  {

  }
  else if($mothe>=9)
  {
    $grade=$grade+1;
  }
  return $grade;
}

?>


<?php
 @include($baseDIR."/bysj/inc_foot.php");
?>



