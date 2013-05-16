<?php
/*
 * Created on 2013-4-16
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
	if($_POST['select']&&$_POST['number'])
	{
		$sql = "UPDATE  `".$ART_TABLE."major_student_select` SET  `".$_POST['select']."` =  '".$_POST['value']."' WHERE  `student_number` =".$_POST['number'];
		mysql_query($sql);
	}
 }
 else
 {
 	echo "请登录";
 }
?>
