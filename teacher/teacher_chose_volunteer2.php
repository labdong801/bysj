<?php
/*
 * Created on 2013-5-24
 * Designed by �̰ؽ�   linux.c@foxmail.com
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 session_start();
$self= $PHP_SELF;
$sc_name = $_SERVER["SCRIPT_FILENAME"];
$sc_loc= strpos($sc_name,$self);
$baseDIR = substr($sc_name,0,$sc_loc);
//�������ݿ��ļ�
include($baseDIR."/bysj/connect_db.php");

//������������CSS
$day512 = date("md");  //�Ĵ��봨����� 2008��5��12��
if($day512==512) $day512 = true;
else $day512 = false;
if($day512) echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
?>

<html>
<head>
<title><?php echo $YM_ZT;if($com_from)echo "��".$com_from; ?></title>
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
<!-- �Լ�д��js���������� -->
<script language=JavaScript src=/bysj/js/myjs.js></script>

<!-- ������ӽ�ȥ��CSS -->
<link rel="stylesheet" type="text/css" href="/bysj/css/mycss.css">
<link rel="stylesheet" type="text/css" href="/bysj/css/art.css">
</head>

<script language=JavaScript src=/bysj/images/rsTipBox.js></script>
<body leftMargin=0 topMargin=0 marginwidth=0 marginheight=0>
<font size=+1>

<?php

if($_SESSION['com_id']) //����Ƿ��¼
 {
 	$teacher_id = $_SESSION['com_id'];
 	
 	
	//��Ҫ�ṩ������Ϣ
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
		
	//��Ҫ�ṩ���
	if($_GET['year'])
		$year = $_GET['year'];
	else
		exit(0);
		
	//�ڼ�־Ը
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
			//���Ѿ�ѡ�õ�����
//			$sql = "UPDATE  `".$ART_TABLE."instrument_student_select` SET  `lock` =  '1' WHERE  `lock` = 0 AND teacher = '".$teacher_id."' ";
//			//echo $sql;
//			mysql_query($sql);
		}
		else
		{
			$volunteer = $instrument."_third";
//			//���Ѿ�ѡ�õ�����
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
	 		 	$sum = 0; //��һ־Ը��ʦ���Դ�������
	 		 	$chose_sum = 0; //��һ־Ը��ѡ�������
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
	 		 	//��ʽ����һ־Ը��ʣ���ٸ����� = ��һ־Ը��ʦ���Դ������� - ��һ־Ը��ѡ���������
	 		 	//��� ��һ־Ը��ʣ���ٸ����� ���� 0 ��û����ʦ���Դ��ˣ��� ����ѧ����һ־Ը�Ѿ���������
	 		 	
	 		 }
	 		 if($volunteer == $instrument."_third")
	 		 {
	 		 	$sql_check = "SELECT * FROM  `".$ART_TABLE."teacher_student` WHERE major_id = '".$major_id."' AND teacher_id ='".$row[$instrument."_second"]."'  AND year = '".$year."' AND  class ='".$major."' ";
	 		 	//echo $sql_check;
	 		 	$query_check = mysql_query($sql_check);
	 		 	$sum = 0; //��һ־Ը��ʦ���Դ�������
	 		 	$chose_sum = 0; //��һ־Ը��ѡ�������
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
	 		 	//��ʽ����һ־Ը��ʣ���ٸ����� = ��һ־Ը��ʦ���Դ������� - ��һ־Ը��ѡ���������
	 		 	//��� ��һ־Ը��ʣ���ٸ����� ���� 0 ��û����ʦ���Դ��ˣ��� ����ѧ����һ־Ը�Ѿ���������
	 		 	
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
	 	echo "û�п���ѡ���ѧ����";
	 }
 
 
 }	
 else
 {
 	echo "���¼";
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
			$(this).find('span').html("��");
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