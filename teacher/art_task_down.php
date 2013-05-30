<?php
$self= $PHP_SELF;//文件相对地址

$filename = $_SERVER["SCRIPT_FILENAME"];//获取文件绝对地址
$loc= strpos($filename,$self);//自己相对地址在绝对地址中出现的位置
$baseDIR = substr($filename,0,$loc);//根本地址
include("../connect_db.php");
include("ART_PHPZip.php");
if($_GET['down_id'])
{

  $original_dir=$baseDIR."/bysj/student_homework/";
  $new_dir=$baseDIR."/bysj/homework/";
  $archive  = new ART_PHPZip();

 $dsql="SELECT title,file_name ,student_num,profession,art_major.name,bysj_student_sheet.NAME  FROM `art_teacher_task`
 LEFT JOIN art_student_task ON art_teacher_task.task_id=art_student_task.task_id
 LEFT JOIN art_major ON art_major.id=art_teacher_task.major_id
 LEFT JOIN bysj_student_sheet ON student_num=number
 where  art_teacher_task.task_id='$_GET[down_id]'";

 $result=mysql_query($dsql);
 $arr=array();
 $arr_2=array();
 $i=0;

 while($row=mysql_fetch_array($result))
 {
 	if($row[NAME]!='')
 	{
 	$arr[$i]=$row[file_name];
 	$val=explode(".",$row[file_name]);
 	$arr_2[$i]=$row[profession].".".$row[name].".".$row[NAME]."-".$row[title]."."."$val[1]";
 	$i++;
 	}
 }

 if(!empty($arr) && !empty($arr_2) )
 	{
 	$archive->select_file($original_dir,$new_dir,$arr,$arr_2);
    $archive->ZipAndDownload($new_dir);
    $archive->delete_file($new_dir);
 	}
 	else
 	{
 		echo "<script>alert('未有学生交作业');</script>";
 	}


}
?>
