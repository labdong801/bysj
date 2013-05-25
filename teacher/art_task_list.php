<?php
include("../connect_db.php");

?>

<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr><td style="font-size:16px;"><?php echo change("任务标题");?></td><td style="font-size:16px;"><?php echo change("任务时间");?></td><td colspan="2" style="font-size:16px;"><?php echo change("用户操作");?></td></tr>
<?php


if(empty($_POST['page'])|| $_POST['page']<0)
{
	$page=1;
}
else
{
	$page=$_POST['page'];
}
$Page_size=2;
$offset=$Page_size*($page-1);
$sql = "select * from ".$ART_TABLE."teacher_task where  teacher='$_POST[teacher]' && class='$_POST[Class]'  order by id desc  limit $offset,$Page_size ";
$result=mysql_query($sql);


if($result)
 {
 	$string="编辑";
 	$string1="删除";
   while($row=mysql_fetch_array($result))
   {

   	?>
  <tr>
  <td width="30%"><a href="?content_id=<?php echo $row[id]?>"><?php echo change($row[title])?></a></td>
  <td width="60%"><?php echo $row['start_time']."----".$row['end_time']?></td>
  <td width="5%"><a href="?edit_id=<?php echo $row[id]?>"><?php echo change($string)?></a></td>
  <td width="5%"><a href="?del_id=<?php echo $row[id]?>"><?php echo change($string1)?></a></td>
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


<?php
 function change($string)
 {
 	$bb=mb_convert_encoding($string,"UTF-8","GBK");
 	return $bb;
 }
?>
