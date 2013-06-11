<?php
/*
 * Created on 2013-6-10
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
	if($_POST['number']&&$_POST['instrument'])
	{ 
	 	$sql = "UPDATE  `".$ART_TABLE."vocalmusic_student_select` SET  `".$_POST['instrument']."_finally` =  '0'  WHERE student_number = '".$_POST['number']."' ";
	 	mysql_query($sql);
	 	echo $sql;
	}
 }
?>
