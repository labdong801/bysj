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
		
	//��Ҫ�ṩ���
	if($_GET['year'])
		$year = $_GET['year'];
	else
		exit(0);
		
	//��Ҫ�ṩרҵ
	if($_GET['major'])
		$major = $_GET['major'];
	else
		exit(0);

	//�ڼ�־Ը
	if($_GET['volunteer'])
	{ 
		$volunteer = $_GET['volunteer'];
		if($volunteer==1)
		{
			$volunteer = "first";
		}
		else if($volunteer == 2)
		{
			$volunteer = "second";
			//���Ѿ�ѡ�õ�����
			$sql = "UPDATE  `".$ART_TABLE."instrument_student_select` SET  `lock` =  '1' WHERE  `lock` = 0 AND teacher = '".$teacher_id."' AND `year` = '".$year."' ";
			//echo $sql;
			mysql_query($sql);
		}
		else
		{
			$volunteer = "third";
			//���Ѿ�ѡ�õ�����
			$sql = "UPDATE  `".$ART_TABLE."instrument_student_select` SET  `lock` =  '1' WHERE  `lock` = 0 AND teacher = '".$teacher_id."' AND `year` = '".$year."'  ";
			mysql_query($sql);
		}
	}


	 $sql = "SELECT ".$TABLE."student_sheet.name , ".$ART_TABLE."instrument_student_select.student_number, ".$TABLE."student_sheet.class, ".$ART_TABLE."instrument_student_select.lock  FROM  `".$ART_TABLE."instrument_student_select` 
	 		LEFT JOIN ".$TABLE."student_sheet ON ".$ART_TABLE."instrument_student_select.student_number = ".$TABLE."student_sheet.number 
	 		LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = bysj_major.name 
	 		WHERE `teacher`= '".$teacher_id."' AND ".$ART_TABLE."instrument_student_select.year = '".$year."' AND ".$TABLE."major.id='".$major."' ORDER BY  `lock` DESC  ";
	 		//echo $sql;
	 $query = mysql_query($sql);
	 if(mysql_num_rows($query))
	 {
	 	//echo $sql;
	 	
	 	while($row = mysql_fetch_array($query))
	 	{ 
	 		if($row['lock']==1)
	 			echo "<div id='".$row['student_number']."' class='lock'  style='padding-left:20px;padding-top:10px;padding-bottom:10px;cursor:pointer;list-style-type:none;background:#ccc' align=left><span> </span>".$row['name']."[".$row['class']."]</div>";
	 		else
	 			echo "<div id='".$row['student_number']."' class='chose'  style='padding-left:20px;padding-top:10px;padding-bottom:10px;cursor:pointer;list-style-type:none;' align=left><span> </span>".$row['name']."[".$row['class']."]</div>";
	 	}
	 }
	 else
	 {
	 	echo "��û��ѡ��ѧ����";
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
			$.post("./ajax/jquery_session_ctl.php", { add: id,remove:'2'} );
		},
		function () {
			$(this).css({ color: "#000000", background: "#ffffff" });
			$(this).find('span').html("");
			var id = $(this).attr("id");
			$.post("./ajax/jquery_session_ctl.php", { clean: id} );
		});
});

</script>