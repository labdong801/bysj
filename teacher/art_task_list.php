<?php
include("../connect_db.php");

if(empty($_POST['page'])|| $_POST['page']<0)
{
	$page=1;
}
else
{
	$page=$_POST['page'];
}
$Page_size=6;
$offset=$Page_size*($page-1);
//一览表
if($_POST[mysel]==2)
{
	$sql="SELECT * FROM ".$ART_TABLE."teacher_task LEFT JOIN ".$ART_TABLE."major ON ".$ART_TABLE."teacher_task.major_id=".$ART_TABLE."major.id where ".$ART_TABLE."teacher_task.grade='$_POST[grade]' && ".$ART_TABLE."teacher_task.teacher_task='$_POST[teacher]' && ".$ART_TABLE."teacher_task.year_task='$_POST[Class]' order by ".$ART_TABLE."teacher_task.task_id desc  limit $offset,$Page_size";

}
else if($_POST[mysel]==4)
{
$sql="SELECT * FROM ".$ART_TABLE."teacher_task LEFT JOIN ".$ART_TABLE."major ON ".$ART_TABLE."teacher_task.major_id=".$ART_TABLE."major.id where ".$ART_TABLE."teacher_task.grade='$_POST[grade]' && ".$ART_TABLE."teacher_task.teacher_task='$_POST[teacher]'  order by ".$ART_TABLE."teacher_task.task_id asc  limit $offset,$Page_size";

}

$result=mysql_query($sql);
?>

<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<?php
if($_POST[mysel]==2 ||$_POST[mysel]==4)
{
?>
<tr><td style="font-size:16px;"><?php echo change("任务标题");?></td><td style="font-size:16px;"><?php echo change("任务时间");?></td><td style="font-size:16px;" align="center"><?php echo change("课程名称");?></td><td colspan="2" style="font-size:16px;"><?php echo change("用户操作");?></td></tr>
<?php
if($result)
 {
   while($row=mysql_fetch_array($result))
   {
   	?>
  <tr>
  <td width="20%"><a href="?content_id=<?php echo $row[task_id]?>"><?php echo change($row[title])?></a></td>
  <td width="60%"><?php echo $row['start_time']."----".$row['end_time']?></td>
  <td width="10%" align="center"><?php echo change($row['name'])?></td>
  <td width="5%"><a <?php if($_POST[mysel]!=4){?>href="?edit_id=<?php echo $row[task_id];}?>"><?php echo change("编辑")?></a></td>
  <td width="5%"><a <?php if($_POST[mysel]!=4){?>href="?del_id=<?php echo $row[task_id];}?>"><?php echo change("删除")?></a></td>
  </tr>
   	<?
   }
 }
 else{
 	echo "fail";
     }
 	?>
 <?php
}else if($_POST[mysel]==3)
{
$SQL3="SELECT art_teacher_task.*,art_major.name From art_teacher_task LEFT JOIN art_major ON art_major.id=art_teacher_task.major_id
WHERE art_teacher_task.grade='$_POST[grade]' && art_teacher_task.year_task='$_POST[Class]' && art_teacher_task.teacher_task='$_POST[teacher]'order by ".$ART_TABLE."teacher_task.task_id desc  limit $offset,$Page_size";
$result=mysql_query($SQL3);
?>
<tr><td style="font-size:16px;"><?php echo change("班级");?></td><td style="font-size:16px;"><?php echo change("课程名称");?></td><td align="center"><?php echo change("任务标题");?></td><td style="font-size:16px;" align="center"><?php echo change("用户操作");?></td></tr>

<?php
if($result)
 {
   while($row=mysql_fetch_array($result))
   {
   	?>
  <tr>
  <td width="25%"><?php if($row['class']==20){echo change("音乐学");} else{echo change("音乐表演");}?></td>
  <td width="25%" ><?php echo change($row['name'])?></td>
  <td width="40%"><a href="?content_id=<?php echo $row[task_id]?>"><?php echo change($row[title]);?></a></td>
  <td width="10%" align="center"><a href="?down_id=<?php echo $row[task_id]?>"><?php echo change("下载")?></a></td>
  </tr>
   	<?
   }
 }
 else{
 	echo "fail";
     }

}
 ?>
</table>


<?php
 function change($string)
 {
 	$bb=mb_convert_encoding($string,"UTF-8","GBK");
 	return $bb;
 }
?>
