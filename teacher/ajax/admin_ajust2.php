<?php
/*
 * Created on 2013-5-31
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 session_start();
header("Content-Type:text/html;charset=GB2312");
$self= $PHP_SELF;
$sc_name = $_SERVER["SCRIPT_FILENAME"];
$sc_loc= strpos($sc_name,$self);
$baseDIR = substr($sc_name,0,$sc_loc);
//链接数据库文件
include($baseDIR."/bysj/connect_db.php");

 if($_SESSION['com_online'])
 {
 	if($_POST['major']&&$_POST['class']&&$_POST['year'])
 	{
 		//echo mb_convert_encoding(teacher("",$_POST['major'],$_POST['class'],$_POST['year']),'gbk','utf-8');;
 		echo teacher("",$_POST['major'],$_POST['class'],$_POST['year']);
 	}
 	else if($_POST['major']&&isset($_POST['teacher'])&&$_POST['year']&&$_POST['student'])
 	{
 		$_POST['student'] = str_replace("t","",$_POST['student']);
 		$sql = "UPDATE  `".$ART_TABLE."instrument_student_select` SET  `finally` =  '".$_POST['major']."',
		`teacher` =  '".$_POST['teacher']."' WHERE  `".$ART_TABLE."instrument_student_select`.`student_number` ='".$_POST['student']."';";
		mysql_query($sql);
		//echo $sql;
 	}
 	
 	
 }
 
 function teacher($teacher,$major,$class,$year)
{
	global $ART_TABLE;
	global $TABLE;
	$sql = "SELECT * FROM  `".$ART_TABLE."teacher_student`  
			LEFT JOIN ".$TABLE."teacher_information ON ".$TABLE."teacher_information.teacher_id = ".$ART_TABLE."teacher_student.teacher_id 
			WHERE year='".$year."' AND value > 0 AND major_id = '".$major."'  AND class = '".$class."'";
	//echo $sql;
	$query = mysql_query($sql);
	if(mysql_num_rows($query))
	{
		$result = "<select style='width:120px; ' class = 'teacher' id='".$major."'>";
		if($teacher!="")
			$result .= "<option value=''></option>";
		else
			$result .= "<option value='' selected></option>";
		while($row=mysql_fetch_array($query))
		{
			if($teacher == $row['teacher_id'])
				$result .="<option value='".$row['teacher_id']."' selected>".$row['name']."</option>";
			else
				$result .= "<option value='".$row['teacher_id']."'>".$row['name']."</option>";
		}
		$result .="</select>";
	}
	return $result;
}
?>
