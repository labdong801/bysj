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
if($Grade>4)
{
	$Grade=4;
}

 if($_GET['select_year'])
 {
 	$year = $_GET['select_year'];
 }
 else
 {
 	$year = date("Y",mktime(0,0,0,date("m")-8,1,date("Y"))); //
 	/*
 	 * ��ѧ����� ����ǰ��ݼ�8���£�
 	 * eg:
 	 * ������ 2013��6�� ������2012ѧ��ڶ����ڡ����� $art_select_year = 2012
 	 * ������2013��9�£�����2013���һѧ�ڡ�����$art_select_year =2013
 	 * */
 }
//echo $student_id;

//��ѯ 1
$SQL="SELECT finally, teacher, profession, art_major.name, bysj_major.id, art_teacher_task . *
FROM `art_instrument_student_select`
LEFT JOIN bysj_student_sheet ON number = student_number
LEFT JOIN art_major ON art_major.id = finally
LEFT JOIN bysj_major ON profession = bysj_major.name
LEFT JOIN art_teacher_task ON art_teacher_task.class = bysj_major.id && year_task = art_instrument_student_select.year && teacher_task = art_instrument_student_select.teacher && finally = art_teacher_task.major_id
WHERE student_number = '$student_id' ";

//�����Ͻ� 1
$SQL2="SELECT finally, profession, art_major.name, bysj_major.id, art_teacher_task . * ,
status FROM `art_instrument_student_select`
LEFT JOIN bysj_student_sheet ON number = student_number
LEFT JOIN art_major ON art_major.id = finally
LEFT JOIN bysj_major ON profession = bysj_major.name
LEFT JOIN art_teacher_task ON art_teacher_task.class = bysj_major.id && year_task = art_instrument_student_select.year && teacher_task = art_instrument_student_select.teacher && finally = art_teacher_task.major_id
LEFT JOIN art_student_task ON art_student_task.classes = art_teacher_task.class && art_student_task.year = art_teacher_task.year_task && teacher_id = art_teacher_task.teacher_task && art_teacher_task.major_id = art_student_task.major_id && art_teacher_task.task_id = art_student_task.task_id && student_num=number
WHERE student_number = '$student_id'&& art_teacher_task.grade='$Grade' && art_teacher_task.year_task='$year' ";
//��ѯ2
$SQL3="SELECT art_vocalmusic_student_select.student_number,vocalmusic_finally ,piano_finally ,art_teacher_task.* ,profession,art_major.name
FROM `art_vocalmusic_student_select`
LEFT JOIN bysj_student_sheet ON number = student_number
LEFT JOIN art_teacher_task ON art_teacher_task.year_task=art_vocalmusic_student_select.year &&
(art_teacher_task.teacher_task=art_vocalmusic_student_select.piano_finally ||art_teacher_task.teacher_task=art_vocalmusic_student_select.vocalmusic_finally)
LEFT JOIN art_major ON art_major.id = art_teacher_task.major_id
LEFT JOIN bysj_major ON profession = bysj_major.name
where student_number='$student_id'&& art_teacher_task.grade='$Grade' ";
//����2
$SQL4="SELECT art_vocalmusic_student_select.student_number,vocalmusic_finally ,piano_finally ,art_teacher_task.* ,profession,art_major.name,status
FROM `art_vocalmusic_student_select`
LEFT JOIN bysj_student_sheet ON number = student_number

LEFT JOIN art_teacher_task ON art_teacher_task.year_task=art_vocalmusic_student_select.year &&
(art_teacher_task.teacher_task=art_vocalmusic_student_select.piano_finally ||art_teacher_task.teacher_task=art_vocalmusic_student_select.vocalmusic_finally)
LEFT JOIN art_student_task ON art_student_task.classes = art_teacher_task.class && art_student_task.year = art_teacher_task.year_task && teacher_id = art_teacher_task.teacher_task && art_teacher_task.major_id = art_student_task.major_id && art_teacher_task.task_id = art_student_task.task_id && student_num=number
LEFT JOIN art_major ON art_major.id = art_teacher_task.major_id
LEFT JOIN bysj_major ON profession = bysj_major.name
where student_number='$student_id'&& art_teacher_task.grade='$Grade' && art_teacher_task.year_task='$year' ";

//��ѯ3
$SQL5="SELECT finally, teacher, profession, art_major.name, bysj_major.id, art_teacher_task . *
FROM `art_major_student_select`
LEFT JOIN bysj_student_sheet ON number = student_number
LEFT JOIN art_major ON art_major.id = finally
LEFT JOIN bysj_major ON profession = bysj_major.name
LEFT JOIN art_teacher_task ON art_teacher_task.class = bysj_major.id && year_task = art_major_student_select.year && teacher_task = art_major_student_select.teacher && finally = art_teacher_task.major_id
WHERE student_number = '$student_id'&& art_teacher_task.grade='$Grade'";

//�����Ͻ� 3
$SQL6="SELECT finally, profession, art_major.name, bysj_major.id, art_teacher_task . * ,
status FROM `art_major_student_select`
LEFT JOIN bysj_student_sheet ON number = student_number
LEFT JOIN art_major ON art_major.id = finally
LEFT JOIN bysj_major ON profession = bysj_major.name
LEFT JOIN art_teacher_task ON art_teacher_task.class = bysj_major.id && year_task = art_major_student_select.year && teacher_task = art_major_student_select.teacher && finally = art_teacher_task.major_id
LEFT JOIN art_student_task ON art_student_task.classes = art_teacher_task.class && art_student_task.year = art_teacher_task.year_task && teacher_id = art_teacher_task.teacher_task && art_teacher_task.major_id = art_student_task.major_id && art_teacher_task.task_id = art_student_task.task_id && student_num=number
WHERE student_number = '$student_id'&& art_teacher_task.grade='$Grade' && art_teacher_task.year_task='$year' ";
if(!$_GET[grade])
{
if($Grade==1)
{
	$SQL.="&& art_teacher_task.year_task='$year' && art_teacher_task.grade='$Grade'";
	if($_GET[sel]==3)
  {
  $SQL.="   &&  order by task_id desc";
  }
  else if($_GET[sel]==4)
 {
  $SQL=$SQL2;
  $SQL.="&& status='1' order by task_id desc";

 }
 else if($_GET[sel]==2)
 {
 	$SQL.=" order by ".$ART_TABLE."teacher_task.task_id desc";

 }
 else if($_GET[content_id])
 {
 	 $SQL.=" && ".$ART_TABLE."teacher_task.task_id='$_GET[content_id]'";
 }
 else if(!empty($_GET[sj]))
 {
 	$SQL.=" && ".$ART_TABLE."teacher_task.task_id='$_GET[sj]' order by task_id desc";
 }
 else
 {
 	$SQL.=" order by task_id desc ";
 }
  $result=mysql_query($SQL);
}



else if($Grade==2)
{
	$SQL=$SQL3;
	$SQL.="&& art_teacher_task.year_task='$year' && art_teacher_task.grade='$Grade'";
	if($_GET[sel]==3)
  {
   $SQL.=" &&  order by task_id desc";
  }
  else if($_GET[sel]==4)
 {
  $SQL=$SQL4;
  $SQL.="&& status='1' order by task_id desc";

 }
 else if($_GET[sel]==2)
 {
 	$SQL.=" order by ".$ART_TABLE."teacher_task.task_id desc ";

 }
 else if($_GET[content_id])
 {
 	 $SQL.=" && ".$ART_TABLE."teacher_task.task_id='$_GET[content_id]'";
 }
 else if(!empty($_GET[sj]))
 {
 	$SQL.=" && ".$ART_TABLE."teacher_task.task_id='$_GET[sj]' order by task_id desc";
 }
 else
 {
 	$SQL.=" order by task_id desc ";
 }
  $result=mysql_query($SQL);
}

else if($Grade==3)
{
	$SQL=$SQL5;
	$SQL.="&& art_teacher_task.year_task='$year' && art_teacher_task.grade='$Grade'";
	if($_GET[sel]==3)
  {
   $SQL.=" &&  order by task_id desc";
  }
  else if($_GET[sel]==4)
 {
  $SQL=$SQL6;
  $SQL.=" && status='1' order by task_id desc";

 }
 else if($_GET[sel]==2)
 {
 	$SQL.=" order by ".$ART_TABLE."teacher_task.task_id desc";

 }
 else if($_GET[content_id])
 {
 	 $SQL.=" && ".$ART_TABLE."teacher_task.task_id='$_GET[content_id]'";
 }
 else if(!empty($_GET[sj]))
 {
 	$SQL.=" && ".$ART_TABLE."teacher_task.task_id='$_GET[sj]' order by task_id desc";
 }

 else
 {
   $SQL.=" order by task_id desc ";
 }

  $result=mysql_query($SQL);
}
}
else
{
	if($_GET[grade]==1)
  {
     $SQL=$SQL;
  }
  else if($_GET[grade]==2)
  {
  	$SQL=$SQL3;
  }
  else if($_GET[grade]==3)
  {
  	$SQL=$SQL5;
  }
 // echo $_GET[grade];
  $SQL.=" && art_teacher_task.grade='$_GET[grade]' order by task_id desc ";
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
<tr><td style="font-size:16px;" align="center">�༶</td><td style="font-size:16px;">�γ�����</td><td style="font-size:16px;">��������</td><td style="font-size:16px;">����ʱ��</td><td style="font-size:16px;">��������</td></tr>
<?php


if($result)
 {
   while($row=mysql_fetch_array($result))
   {

   	?>
  <tr>
  <td width="10%" align="center"><?echo $row[profession]?></td>
  <td width="10%"><?php echo $row[name];?></a></td>
  <td width="15%"><a href="?content_id=<?php echo $row[task_id]?>"><?php echo $row[title];?></a></td>
  <td width="30%"><?php echo $row['start_time']."----".$row['end_time']?></td>
  <td width="35%"><a href="?content_id=<?php echo $row[task_id]?>"><?php echo $row[content];?></a></td>

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

  $major=$row[major_id];
  $grade_id=$row[grade];
  $classes=$row['class'];
  $years=$row['year_task'];
  $teacher=$row['teacher_task'];
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

    $sl="select task_id from ".$ART_TABLE."student_task where task_id='$row[task_id]'";
 	 $ss=mysql_query($sl);
 	 $arr=mysql_fetch_array($ss);
 	 //�ж��Ƿ��Ͻ�
 	 if(!empty($arr))
 	 {
 	 	$st=1;
 	 }
 	 else
 	 {
 	 	$st=0;
 	 }
   	?>
  <tr>
  <td width="10%"><?php echo $row[name];?></a></td>
  <td width="15%"><a href="?content_id=<?php echo $row[task_id]?>"><?php echo $row[title];?></a></td>
  <td width="30%"><?php echo $row['start_time']."----".$row['end_time']?></td>
  <td width="30%"><a href="?content_id=<?php echo $row[task_id]?>"><?php echo $row[content];?></a></td>
  <td width="10%" align="center"><?if ($st==1){ echo "��";}else{ echo "��";}?></td>
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

     $jc="select * from ".$ART_TABLE."student_task where task_id='$_POST[task_id]' && student_num='$student_id'";
     $jr=mysql_query($jc);
     if(is_array(mysql_fetch_array($jr)))
     {
     	//echo "����";
     	$tt="UPDATE ".$ART_TABLE."student_task SET file_name='$name',status='1' WHERE task_id='$_POST[task_id]' && student_num='$student_id'";
     }
     else
     {
     $tt="insert into ".$ART_TABLE."student_task(major_id,classes,task_id,file_name,status,year,teacher_id,sd_grade,student_num)"."" .
   	 "values('$_POST[major_id]','$_POST[classes]','$_POST[task_id]','$name','1','$_POST[years]','$_POST[teacher_id]','$_POST[grade_id]','$student_id')";
     // echo "����";
     }

     // echo $tt;
      $query1=mysql_query($tt);
     if($query1)
     {
   	  echo "<script>alert('�ϴ��ɹ�'))</script>";
      }
     else
     {

      unlink($destination);
   	  echo "<script>alert('�ϴ�ʧ��'))</script>";
   	   exit;
     }
}

?>


<?php
 @include($baseDIR."/bysj/inc_foot.php");
?>



