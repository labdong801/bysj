
<?php
$self= $PHP_SELF;//�ļ���Ե�ַ
$filename = $_SERVER["SCRIPT_FILENAME"];//��ȡ�ļ����Ե�ַ
$loc= strpos($filename,$self);//�Լ���Ե�ַ�ھ��Ե�ַ�г��ֵ�λ��
$baseDIR = substr($filename,0,$loc);//������ַ
$YM_ZT = "ѧ����ҵ";
$YM_ZT2 = "ѧ�������ѯ";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_PT ="�����ѯ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 1; //����ԱȨ��
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
<td width="100%"><font color=#FFFFFF >��������</font></td>
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
<td width="100%"><font color=#FFFFFF >ѧ������</font></td>
</tr>
</table>
<br>
<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr><td style="font-size:16px;">�γ�����</td><td style="font-size:16px;">��������</td><td style="font-size:16px;">����ʱ��</td><td style="font-size:16px;">��������</td><td style="font-size:16px;" align="center">�Ƿ��Ͻ�</td></tr>
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
  <td width="10%" align="center"><?php if($row[status]==0){echo "��"; }else{echo "��";} ?></td>
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
<td width="100%"><font color=#FFFFFF >ѧ����ҵ�ϴ�</font></td>
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
<td width="100%"><font color=#FFFFFF >ѧ������</font></td>
</tr>
</table>
<br>
<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr><td style="font-size:16px;">�γ�����</td><td style="font-size:16px;">��������</td><td style="font-size:16px;">����ʱ��</td><td style="font-size:16px;">��������</td><td style="font-size:16px;">�Ƿ��Ͻ�</td><td style="font-size:16px;" align="center">����</td></tr>
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
  <td width="10%" align="center"><?if ($row[status]==0){ echo "��";}else{ echo "��";}?></td>
  <td width="15%" align="center"><a href="?sj=<?php echo $row[task_id]?>">�Ͻ�</td>
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
 	     echo"�ļ�������";
 	     exit;
     }
     if($max_file_size<$file["size"])
     {
     	echo"�ļ���С�����涨ֵ�����ֵ";
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
     	echo "ͬ���ļ�����";
     	exit;
     }
     if(!move_uploaded_file($tmp_name,$destination))
     {
     	echo "�ļ��Ƶ�����";
     	exit;
     }

     $tt="UPDATE ".$ART_TABLE."student_task SET file_name='$name',status='1' WHERE task_id='$_POST[task_id]'";
      echo $tt;
      $query1=mysql_query($tt);
     if($query1)
     {
   	  echo "�ϴ��ɹ�";
     }
     else
     {

      unlink($destination);
   	   echo "�ϴ�ʧ��";

   	   exit;
     }
}

?>


<?php
 @include($baseDIR."/bysj/inc_foot.php");
?>



