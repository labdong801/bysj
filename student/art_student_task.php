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
$Grade=$grade-3;
echo $student_id;
$SQL="SELECT finally, teacher, profession, art_major.name, bysj_major.id, art_teacher_task . * ,
STATUS FROM `art_instrument_student_select`
LEFT JOIN bysj_student_sheet ON number = student_number
LEFT JOIN art_major ON art_major.id = finally
LEFT JOIN bysj_major ON profession = bysj_major.name
LEFT JOIN art_teacher_task ON art_teacher_task.class = bysj_major.id && year_task = art_instrument_student_select.year && teacher_task = art_instrument_student_select.teacher && finally = art_teacher_task.major_id
LEFT JOIN art_student_task ON art_student_task.classes = art_teacher_task.class && art_student_task.year = art_teacher_task.year_task && teacher_id = art_teacher_task.teacher_task && art_teacher_task.major_id = art_student_task.major_id && art_teacher_task.task_id = art_student_task.task_id
WHERE student_number = '$student_id'";
 //echo $Grade;






/*
 *
 *
 *
 *
$SQL="SELECT finally, teacher, profession, art_major.name, bysj_major.id, art_teacher_task . * ,
STATUS FROM `art_instrument_student_select`
LEFT JOIN bysj_student_sheet ON number = student_number
LEFT JOIN art_major ON art_major.id = finally
LEFT JOIN bysj_major ON profession = bysj_major.name
LEFT JOIN art_teacher_task ON art_teacher_task.class = bysj_major.id && year_task = art_instrument_student_select.year && teacher_task = art_instrument_student_select.teacher && finally = art_teacher_task.major_id
LEFT JOIN art_student_task ON art_student_task.classes = bysj_major.id && art_student_task.year = art_instrument_student_select.year && teacher_id = art_instrument_student_select.teacher && finally = art_student_task.major_id
WHERE student_number = '$student_id'";
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
*/
if($Grade==1)
{
	if($_GET[sel]==3)
  {
  $SQL.=" && status='0' order by task_id desc";
  }
  else if($_GET[sel]==4)
 {
  $SQL.=" && status='1' order by task_id desc"	;

 }
 else if($_GET[sel]==2)
 {
 	$SQL.=" order by ".$ART_TABLE."student_task.status asc";
 }
 else if($_GET[content_id])
 {
 	 $SQL.=" && ".$ART_TABLE."teacher_task.task_id='$_GET[content_id]'";
 }
 else if(!empty($_GET[sj]))
 {
 	$SQL.=" && ".$ART_TABLE."teacher_task.task_id='$_GET[sj]' order by status desc";
 }
 else if($_GET[grade]==1)
 {
   $SQL.=" order by task_id desc ";
 }
 else
 {
 	$SQL.=" order by task_id desc ";
 }
  $result=mysql_query($SQL);
}
?>

<table width="100%" align="center" >

<tr>
<td >
<table width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td width="100%"><font color=#FFFFFF >��������</font></td>
</tr>
</table>
</td>
</tr>

<tr>
<td>
<br>
<?php
if($_GET[sel]!=2 and empty($_GET[sj]))
{

?>

<?php
if($_GET[content_id])
{
// $SQL1="SELECT student_number,finally,art_teacher_task.*,status,art_major.name FROM art_major_student_select LEFT JOIN art_teacher_task ON art_teacher_task.major_id=art_major_student_select.finally LEFT JOIN art_student_task ON art_major_student_select.finally=art_student_task.major_id LEFT JOIN art_major ON art_major.id=art_major_student_select.finally where art_teacher_task.task_id='$_GET[content_id]'";


 $row=mysql_fetch_array($result);

  $title=$row[title];
  $content=$row[content];
  $P_title=$row[name];
  $start_time=$row[start_time];
  $end_time=$row[end_time];

?>

<br>
<?
	@include "art_task_content.php";
}
else{
?>

<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr><td style="font-size:16px;">�γ�����</td><td style="font-size:16px;">��������</td><td style="font-size:16px;">����ʱ��</td><td style="font-size:16px;">��������</td><td style="font-size:16px;" align="center">�Ƿ��Ͻ�</td></tr>
<?php


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
  <td width="10%" align="center"><?php if($row[STATUS]==0){echo "��"; }else{echo "��";} ?></td>
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

  $row=mysql_fetch_array($result);
  $title=$row[title];
  $t_id=$row[task_id];
  $status=$row[STATUS];

?>

	<?
 @include "art_hand_task.php";
}
else{

?>

<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr><td style="font-size:16px;">�γ�����</td><td style="font-size:16px;">��������</td><td style="font-size:16px;">����ʱ��</td><td style="font-size:16px;">��������</td><td style="font-size:16px;">�Ƿ��Ͻ�</td><td style="font-size:16px;" align="center">����</td></tr>
<?php
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
  <td width="10%" align="center"><?if ($row['STATUS']==0){ echo "��";}else{ echo "��";}?></td>
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



