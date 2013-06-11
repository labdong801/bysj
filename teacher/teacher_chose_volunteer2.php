<?php
/*
 * Created on 2013-5-24
 * Designed by 翁柏杰   linux.c@foxmail.com
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

//大地震载入相关CSS
$day512 = date("md");  //四川汶川大地震 2008年5月12日
if($day512==512) $day512 = true;
else $day512 = false;
if($day512) echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
?>

<html>
<head>
<title><?php echo $YM_ZT;if($com_from)echo "－".$com_from; ?></title>
<?php
if($day512) echo "<style>
html { filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1); }
</style>\n";
?>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="/bysj/images/allbig.css">
<!-- jQuery -->
<script language=JavaScript src=/bysj/js/jquery-1.7.1.js></script>
<script language=JavaScript src=/bysj/js/jquery.cookie.js></script>
<!-- 自己写的js都放在这里 -->
<script language=JavaScript src=/bysj/js/myjs.js></script>

<!-- 后来添加进去的CSS -->
<link rel="stylesheet" type="text/css" href="/bysj/css/mycss.css">
<link rel="stylesheet" type="text/css" href="/bysj/css/art.css">
</head>

<script language=JavaScript src=/bysj/images/rsTipBox.js></script>
<body leftMargin=0 topMargin=0 marginwidth=0 marginheight=0>
<font size=+1>

<?php

if($_SESSION['com_id']) //检查是否登录
 {
 	$teacher_id = $_SESSION['com_id'];
 	
 	
	//需要提供乐器信息
	if($_GET['instrument'])
		$instrument = $_GET['instrument'];
	else
		exit(0);
		
	if($_GET['instrument'] == "piano")
	{
		$major_id = 12;
	}
	else if($_GET['instrument'] == "vocalmusic")
	{
		$major_id = 11;
	}
		
	//需要提供年份
	if($_GET['year'])
		$year = $_GET['year'];
	else
		exit(0);
		
	//第几志愿
	if($_GET['volunteer'])
	{ 
		$volunteer = $_GET['volunteer'];
		if($volunteer==1)
		{
			$volunteer = $instrument."_first";
		}
		else if($volunteer == 2)
		{
			$volunteer = $instrument."_second";
			//将已经选好的锁定
//			$sql = "UPDATE  `".$ART_TABLE."instrument_student_select` SET  `lock` =  '1' WHERE  `lock` = 0 AND teacher = '".$teacher_id."' ";
//			//echo $sql;
//			mysql_query($sql);
		}
		else
		{
			$volunteer = $instrument."_third";
//			//将已经选好的锁定
//			$sql = "UPDATE  `".$ART_TABLE."instrument_student_select` SET  `lock` =  '1' WHERE  `lock` = 0 AND teacher = '".$teacher_id."' ";
//			mysql_query($sql);
		}
	}
	else
		exit(0);

 	 
	 $sql = "SELECT ".$TABLE."student_sheet.name , ".$ART_TABLE."vocalmusic_student_select.student_number, ".$TABLE."student_sheet.class, ".$ART_TABLE."vocalmusic_student_select.".$instrument."_lock,".$ART_TABLE."vocalmusic_student_select.".$instrument."_first,".$ART_TABLE."vocalmusic_student_select.".$instrument."_second,".$ART_TABLE."vocalmusic_student_select.".$instrument."_third  FROM  `".$ART_TABLE."vocalmusic_student_select` 
	 		LEFT JOIN ".$TABLE."student_sheet ON ".$ART_TABLE."vocalmusic_student_select.student_number = ".$TABLE."student_sheet.number  
	 		LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = ".$TABLE."major.name 
	 		WHERE `".$volunteer."`='".$teacher_id."' AND `".$instrument."_finally`='0' AND ".$ART_TABLE."vocalmusic_student_select.year = '".$year."' AND  ".$TABLE."major.id='".$major."' ";
	 		//echo $sql;
	 $query = mysql_query($sql);
	 if(mysql_num_rows($query))
	 {
	 	//echo $sql;
	 	
	 	while($row = mysql_fetch_array($query))
	 	{ 
	 		if($volunteer == $instrument."_second")
	 		 {
	 		 	$sql_check = "SELECT * FROM  `".$ART_TABLE."teacher_student` WHERE major_id = '".$major_id."' AND teacher_id ='".$row[$instrument."_first"]."'  AND year = '".$year."' AND  class ='".$major."' ";
	 		 	//echo $sql_check;
	 		 	$query_check = mysql_query($sql_check);
	 		 	$sum = 0; //上一志愿教师可以带的人数
	 		 	$chose_sum = 0; //上一志愿已选择的人数
	 		 	if(mysql_num_rows($query_check))
	 		 		while($row_check = mysql_fetch_array($query_check))
	 		 			$sum += $row_check['value'];
	 		 	//echo $sum;
	 		 	$sql_check = "SELECT * FROM  `".$ART_TABLE."vocalmusic_student_select` 
	 		 			LEFT JOIN ".$TABLE."student_sheet ON ".$ART_TABLE."vocalmusic_student_select.student_number = ".$TABLE."student_sheet.number  
	 					LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = ".$TABLE."major.name
	 		 			WHERE ".$instrument."_finally = '".$row[$instrument."_first"]."'  AND ".$ART_TABLE."vocalmusic_student_select.year = '".$year."' AND  ".$TABLE."major.id='".$major."' ";
	 		 	//echo $sql_check;
	 		 	$query_check = mysql_query($sql_check);
	 		 	$chose_sum = mysql_num_rows($query_check);
	 		 	//echo $chose_sum;
	 		 	//公式：上一志愿还剩多少个名额 = 上一志愿教师可以带的人数 - 上一志愿已选择的人数；
	 		 	//如果 上一志愿还剩多少个名额 等于 0 （没有老师可以带了）， 即该学生上一志愿已经被放弃。
	 		 	
	 		 }
	 		 if($volunteer == $instrument."_third")
	 		 {
	 		 	$sql_check = "SELECT * FROM  `".$ART_TABLE."teacher_student` WHERE major_id = '".$major_id."' AND teacher_id ='".$row[$instrument."_second"]."'  AND year = '".$year."' AND  class ='".$major."' ";
	 		 	//echo $sql_check;
	 		 	$query_check = mysql_query($sql_check);
	 		 	$sum = 0; //上一志愿教师可以带的人数
	 		 	$chose_sum = 0; //上一志愿已选择的人数
	 		 	if(mysql_num_rows($query_check))
	 		 		while($row_check = mysql_fetch_array($query_check))
	 		 			$sum += $row_check['value'];
	 		 	//echo $sum;
	 		 	$sql_check = "SELECT * FROM  `".$ART_TABLE."vocalmusic_student_select` 
	 		 			LEFT JOIN ".$TABLE."student_sheet ON ".$ART_TABLE."vocalmusic_student_select.student_number = ".$TABLE."student_sheet.number  
	 					LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = ".$TABLE."major.name
	 		 			WHERE ".$instrument."_finally = '".$row[$instrument."_second"]."'  AND ".$ART_TABLE."vocalmusic_student_select.year = '".$year."' AND  ".$TABLE."major.id='".$major."' ";
	 		 	//echo $sql_check;
	 		 	$query_check = mysql_query($sql_check);
	 		 	$chose_sum = mysql_num_rows($query_check);
	 		 	//echo $chose_sum;
	 		 	//公式：上一志愿还剩多少个名额 = 上一志愿教师可以带的人数 - 上一志愿已选择的人数；
	 		 	//如果 上一志愿还剩多少个名额 等于 0 （没有老师可以带了）， 即该学生上一志愿已经被放弃。
	 		 	
	 		 }
	 		 if($sum - $chose_sum > 0)
	 		 { 
	 		 	echo "<div id='".$row['student_number']."' class='lock'  style='background:#ccc;padding-left:20px;padding-top:10px;padding-bottom:10px;cursor:pointer;list-style-type:none;' align=left><span> </span>".$row['name']."[".$row['class']."]</div>";
	 		 }
	 		 else
	 		 { 
	 			echo "<div id='".$row['student_number']."' class='chose'  style='padding-left:20px;padding-top:10px;padding-bottom:10px;cursor:pointer;list-style-type:none;' align=left><span> </span>".$row['name']."[".$row['class']."]</div>";
	 		 }
	 	}
	 }
	 else
	 {
	 	echo "没有可以选择的学生！";
	 }
 
 
 }	
 else
 {
 	echo "请登录";
 }
?>
</font>
</body>
</html>

<script language=JavaScript >

$(document).ready(function(){
	$(".chose").toggle(
		function () {
			$(this).css({ color: "#ffffff", background: "#5a6e8f" });
			$(this).find('span').html("√");
			var id = $(this).attr("id");
			$.post("./ajax/jquery_session_ctl.php", { add: id} );
		},
		function () {
			$(this).css({ color: "#000000", background: "#ffffff" });
			$(this).find('span').html("");
			var id = $(this).attr("id");
			$.post("./ajax/jquery_session_ctl.php", { clean: id} );
		});
});
</script>