<?php
include("../connect_db.php");

?>

<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr><td style="font-size:16px;"><?php echo change("�������");?></td><td style="font-size:16px;"><?php echo change("����ʱ��");?></td><td style="font-size:16px;" align="center"><?php echo change("�γ�����");?></td><td colspan="2" style="font-size:16px;"><?php echo change("�û�����");?></td></tr>
<?php


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

$sql="SELECT * FROM ".$ART_TABLE."teacher_task LEFT JOIN ".$ART_TABLE."major ON ".$ART_TABLE."teacher_task.major_id=".$ART_TABLE."major.id where ".$ART_TABLE."teacher_task.teacher='$_POST[teacher]' && ".$ART_TABLE."teacher_task.year='$_POST[Class]' order by ".$ART_TABLE."teacher_task.task_id desc  limit $offset,$Page_size";
//echo $sql;

//$sql = "select * from ".$ART_TABLE."teacher_task where  teacher='$_POST[teacher]' && year='$_POST[Class]'  order by id desc  limit $offset,$Page_size ";

$result=mysql_query($sql);


if($result)
 {
 	$string="�༭";
 	$string1="ɾ��";
   while($row=mysql_fetch_array($result))
   {

   	?>
  <tr>
  <td width="20%"><a href="?content_id=<?php echo $row[task_id]?>"><?php echo change($row[title])?></a></td>
  <td width="60%"><?php echo $row['start_time']."----".$row['end_time']?></td>
  <td width="10%" align="center"><?php echo change($row['name'])?></td>
  <td width="5%"><a href="?edit_id=<?php echo $row[task_id]?>"><?php echo change($string)?></a></td>
  <td width="5%"><a href="?del_id=<?php echo $row[task_id]?>"><?php echo change($string1)?></a></td>
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
