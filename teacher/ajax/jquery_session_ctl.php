<?php
/*
 * Created on 2013-5-28
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 session_start();
 
 if($_SESSION['com_id'])
 {
 	$teacher_id = $_SESSION['com_id'];
 	if($_POST['clean'])
 	{
 		//unset($_SESSION[$teacher_id]);
 		$clean = $_POST['clean'];
 		$_SESSION[$teacher_id][$clean] = 0;
 	}
 	else if($_POST['add'])
 	{
 		$add = $_POST['add'];
 		if($_POST['remove'])
 		{ 
 			$_SESSION[$teacher_id][$add] = 2;
 			echo 2;
 		}
 		else
 		{ 
 			$_SESSION[$teacher_id][$add] = 1;
 			echo 3;
 		}
 	}
 }
 else
 {
 	echo "error";
 }
?>
