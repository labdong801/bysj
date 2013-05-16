<?php
/*
 * Created on 2013-4-21
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
  session_start();
$self= $PHP_SELF;
$sc_name = $_SERVER["SCRIPT_FILENAME"];
$sc_loc= strpos($sc_name,$self);
$baseDIR = substr($sc_name,0,$sc_loc);
//链接数据库文件
include($baseDIR."/bysj/connect_db.php");

 if($_SESSION['com_online'])
 {
	if($_POST['teacher_id']&&$_POST['major_id']&&$_POST['class_id']&&$_POST['year'])
	{
		$sql = "SELECT * FROM  `".$ART_TABLE."teacher_student` WHERE `teacher_id` = '".$_POST['teacher_id']."' && `major_id` = '".$_POST['major_id']."' && `class` = '".$_POST['class_id']."' && `year` = '".$_POST['year']."'";

		$query = mysql_query($sql);
		if(mysql_num_rows($query))
		{
			$sql = "UPDATE  `".$ART_TABLE."teacher_student` SET  `value` =  '".$_POST['value']."' WHERE `teacher_id` = '".$_POST['teacher_id']."' " .
				"&& `major_id` = '".$_POST['major_id']."' && `class` = '".$_POST['class_id']."'" .
						"&& `year` = '".$_POST['year']."'";
			mysql_query($sql);
		}
		else
		{
			$sql = "INSERT INTO  `".$ART_TABLE."teacher_student` (`id` ,`major_id` ,`teacher_id` ,`class` ,`year` ,`value`)VALUES (
				NULL ,  '".$_POST['major_id']."',  '".$_POST['teacher_id']."',  '".$_POST['class_id']."',  '".$_POST['year']."',  '".$_POST['value']."');";
			mysql_query($sql);
		}
	}
 }
 else
 {
 	echo "请登录";
 }
?>
