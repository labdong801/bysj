
<?php
$self= $PHP_SELF;//文件相对地址
$filename = $_SERVER["SCRIPT_FILENAME"];//获取文件绝对地址
$loc= strpos($filename,$self);//自己相对地址在绝对地址中出现的位置
$baseDIR = substr($filename,0,$loc);//根本地址
$YM_ZT = "学生作业";
$YM_ZT2 = "学生任务查询";
$YM_MK = "毕业设计双向选题系统";
$YM_PT ="任务查询";
$YM_DH = 1; //需要导航条
$YM_QX = 1; //管理员权限
include($baseDIR."/bysj/inc_head.php");
$student_id = $com_id;
$Grade=$grade+2000-1;



if($_GET[sel]==3)
{
$SQL="SELECT student_number,finally,art_teacher_task.*,status,art_major.name FROM art_major_student_select LEFT JOIN art_teacher_task ON art_teacher_task.major_id=art_major_student_select.finally LEFT JOIN art_student_task ON art_major_student_select.finally=art_student_task.major_id LEFT JOIN art_major ON art_major.id=art_major_student_select.finally where art_major_student_select.student_number='$student_id' && art_teacher_task.year='$Grade' && art_student_task.status='0' order by  art_teacher_task.task_id desc";

}
else if($_GET[sel]==4)
{
$SQL="SELECT student_number,finally,art_teacher_task.*,status,art_major.name FROM art_major_student_select LEFT JOIN art_teacher_task ON art_teacher_task.major_id=art_major_student_select.finally LEFT JOIN art_student_task ON art_major_student_select.finally=art_student_task.major_id LEFT JOIN art_major ON art_major.id=art_major_student_select.finally where art_major_student_select.student_number='$student_id' && art_student_task.status='1' order by  art_teacher_task.task_id desc";

}
else if($_GET[sel]==2)
{
	$SQL="SELECT student_number,finally,art_teacher_task.*,status,art_major.name FROM art_major_student_select LEFT JOIN art_teacher_task ON art_teacher_task.major_id=art_major_student_select.finally LEFT JOIN art_student_task ON art_major_student_select.finally=art_student_task.major_id LEFT JOIN art_major ON art_major.id=art_major_student_select.finally where art_major_student_select.student_number='$student_id' && art_teacher_task.year='$Grade' order by  art_teacher_task.task_id desc";

}
else
{
	$SQL="SELECT student_number,finally,art_teacher_task.*,status,art_major.name FROM art_major_student_select LEFT JOIN art_teacher_task ON art_teacher_task.major_id=art_major_student_select.finally LEFT JOIN art_student_task ON art_major_student_select.finally=art_student_task.major_id LEFT JOIN art_major ON art_major.id=art_major_student_select.finally where art_major_student_select.student_number='$student_id' && art_teacher_task.year='$Grade' order by  art_teacher_task.task_id desc";
}
 ?>


<?php
if($_GET[sel]!=2 and empty($_GET[sj]))
{

?>

<?php
if($_GET[content_id])
{
 $SQL1="SELECT student_number,finally,art_teacher_task.*,status,art_major.name FROM art_major_student_select LEFT JOIN art_teacher_task ON art_teacher_task.major_id=art_major_student_select.finally LEFT JOIN art_student_task ON art_major_student_select.finally=art_student_task.major_id LEFT JOIN art_major ON art_major.id=art_major_student_select.finally where art_teacher_task.task_id='$_GET[content_id]'";

  $aa=mysql_query($SQL1);
  $row1=mysql_fetch_array($aa);
  $title=$row1[title];
  $content=$row1[content];
  $P_title=$row1[name];
  $start_time=$row1[start_time];
  $end_time=$row1[end_time];

?>
<table width="100%" align="center">
<tr>
<td >
<table width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td width="100%"><font color=#FFFFFF >任务详情</font></td>
</tr>
</table>
<br>
<?
	@include "art_task_content.php";
}
else{
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
<tr><td style="font-size:16px;">课程名称</td><td style="font-size:16px;">任务名称</td><td style="font-size:16px;">任务时间</td><td style="font-size:16px;">任务内容</td><td style="font-size:16px;" align="center">是否上交</td></tr>
<?php
$result=mysql_query($SQL);

if($result)
 {
   while($row=mysql_fetch_array($result))
   {
   	?>
  <tr>
  <td width="10%"><?php echo $row[name];?></a></td>
  <td width="15%"><a href="?content_id=<?php echo $row[task_id]?>"><?php echo $row[title];?></a></td>
  <td width="30%"><?php echo $row['start_time']."----".$row['end_time']?></td>
  <td width="35%"><a href="?content_id=<?php echo $row[task_id]?>"><?php echo $row[content];?></a></td>
  <td width="10%" align="center"><?php if($row[status]==0){echo "否"; }else{echo "是";} ?></td>
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
<?
}
?>
<?
}
else
{

if(!empty($_GET[sj]))
{
  $SQL1="SELECT student_number,finally,art_teacher_task.*,status,art_major.name FROM art_major_student_select LEFT JOIN art_teacher_task ON art_teacher_task.major_id=art_major_student_select.finally LEFT JOIN art_student_task ON art_major_student_select.finally=art_student_task.major_id LEFT JOIN art_major ON art_major.id=art_major_student_select.finally where art_teacher_task.task_id='$_GET[sj]'";
  $bb=mysql_query($SQL1);
  $row2=mysql_fetch_array($bb);
  $title=$row2[title];
  $t_id=$row2[task_id];
  $status=$row2[status];


?>
<table width="100%" align="center">
<tr>
<td >
<table width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td width="100%"><font color=#FFFFFF >学生作业上传</font></td>
</tr>
</table>
<br>
	<?
 @include "art_hand_task.php";
}
else{
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
<tr><td style="font-size:16px;">课程名称</td><td style="font-size:16px;">任务名称</td><td style="font-size:16px;">任务时间</td><td style="font-size:16px;">任务内容</td><td style="font-size:16px;">是否上交</td><td style="font-size:16px;" align="center">操作</td></tr>
<?php
$result=mysql_query($SQL);

if($result)
 {
   while($row=mysql_fetch_array($result))
   {
   	?>
  <tr>
  <td width="10%"><?php echo $row[name];?></a></td>
  <td width="15%"><a href="?content_id=<?php echo $row[task_id]?>"><?php echo $row[title];?></a></td>
  <td width="30%"><?php echo $row['start_time']."----".$row['end_time']?></td>
  <td width="30%"><a href="?content_id=<?php echo $row[task_id]?>"><?php echo $row[content];?></a></td>
  <td width="10%" align="center"><?if ($row[status]==0){ echo "否";}else{ echo "是";}?></td>
  <td width="15%" align="center"><a href="?sj=<?php echo $row[task_id]?>">上交</td>
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
<?}?>
<?
}
?>



</td>
</tr>
</table>

<?

$max_file_size=200000;
$destination_folder=$baseDIR."/bysj/student_homework/";

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $add_time=date("Y-m-d H:i:s");
    $times=strtotime($add_time);
    $file=$_FILES["upfile"];
 	$name=$file["name"];
 	$tmp_name=$file["tmp_name"];
 	$pifo=pathinfo($name);
 	$type=$pifo['extension'];
 	$name1=$pifo['dirname'];
    echo $type;
	 if(!is_uploaded_file($_FILES['upfile']['tmp_name']))
     {
 	     echo"文件不存在";
 	     exit;
     }
     if($max_file_size<$file["size"])
     {
     	echo"文件大小超过规定值的最大值";
     	exit;
     }
     if(!file_exists($destination_folder))
     {
     	mkdir($destination_folder);
     }
     $destination=$destination_folder.$times.".".$type;
     $name=$times.".".$type;

     if(file_exists($destination))
     {
     	echo "同名文件存在";
     	exit;
     }
     if(!move_uploaded_file($tmp_name,$destination))
     {
     	echo "文件移到出错";
     	exit;
     }

     $tt="UPDATE ".$ART_TABLE."student_task SET file_name='$name',status='1' WHERE task_id='$_POST[task_id]'";
      echo $tt;
      $query1=mysql_query($tt);
     if($query1)
     {
   	  echo "上传成功";
     }
     else
     {

      unlink($destination);
   	   echo "上传失败";

   	   exit;
     }
}

?>


<?php
 @include($baseDIR."/bysj/inc_foot.php");
?>



