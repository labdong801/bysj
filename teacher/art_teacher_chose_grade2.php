<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "��ʦѡ��ָ�����١�����ѡ�޵�ѧ��";
$YM_ZT2 = "���١�����ѡ��ѧ������";
$YM_MK = "����ϵ�γ�˫��ѡ��ϵͳ";
$YM_PT ="��ʦѡ��";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //����ԱȨ��
include($baseDIR."/bysj/inc_head.php");


$teacher_id = $com_id;



 //������ѡ���
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
 
 if($_GET['major_id'])
 	$instrument = $_GET['major_id'];
 else
 	$instrument = "";
 	
 if($_GET['class'])
 	$major = $_GET['class'];
 else
 	$major = "";
 	
 	
	//ʱ������
	   $sql = "select topic_start,topic_end,student_start,student_end,teacher_start,teacher_end from ".$ART_TABLE."set_date where grade = '2'";
	   $qur_sql = mysql_query($sql);
	   $fet_result = mysql_fetch_array($qur_sql);
	   $now = time(0);
	   $can_select = true;
	
	   if($now>=$fet_result["teacher_start"]&&$now<=$fet_result["teacher_end"]){
	   	  // ��ѧ��Ĳſ����޸�
	   	  if($year == date("Y",mktime(0,0,0,date("m")-8,1,date("Y"))) )
		   	$can_select = true;
		  else
		  	$can_select = false;
	   } else if($now>=$fet_result["student_start"]&&$now<=$fet_result["student_end"]){
	   	   $can_select = false;
	   	   //$show_message = "Ŀǰ����ѧ����־Ը�׶Ρ�";
	   	   Show_Message("Ŀǰ����ѧ����־Ը�׶Ρ�<br>
	           �ý׶ν��� ".date("Y-m-d",$fet_result["student_end"])." ������<br>
	           ���ڴ����ں��ٲ鿴������Ϣ��лл��");
	       @include($baseDIR."/bysj/inc_foot.php");
	       exit;
	   }else {
		   $show_message = "�Բ�������û��ѡ������";
		   $can_select = false;
	   }
 	
 	
 
 ?>


<table width="100%" align="center">
<tr class="align_top">
<td align="left">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
	//���
	echo "<a href=".$PHP_SELF."?select_year=".$YEAR_C."><font color=blue><u>�鿴".$YEAR_C."��(����)ѡ��</u></font></a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   �鿴���������";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) echo "<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$i."��</u></font></a> ";
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	?>
	&nbsp;<br>&nbsp;<br>
	
	
	<?php
	//���ѧ��Ӧ�ô��ļ��ſ�
		//$sql = "SELECT * FROM  `art_teacher_student` WHERE `teacher_id`='".$_SESSION['com_id']."' && `year` = '".$year."' ";
		$sql = "SELECT ".$ART_TABLE."teacher_student.id, major_id, teacher_id, class, YEAR, value, ".$TABLE."major.name AS class_name , ".$ART_TABLE."major.name AS art_name,grade
			FROM ".$ART_TABLE."teacher_student
			LEFT JOIN ".$TABLE."major ON ".$ART_TABLE."teacher_student.class = ".$TABLE."major.id 
			LEFT JOIN ".$ART_TABLE."major ON ".$ART_TABLE."teacher_student.major_id = ".$ART_TABLE."major.id
			WHERE teacher_id =  '".$_SESSION['com_id']."' && year =  '".$year."' && value > 0 && grade =2" ;
			
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ��ѧ�갲�ŵĿγ̣�";
		
		$query = mysql_query($sql);
		if(mysql_num_rows($query))
		{ 
			while($row = mysql_fetch_array($query))
			{ 
				if($instrument == "")
					$instrument = $row['major_id'];
				if($major == "")
					$major          = $row['class'];
					
				if( ($instrument == $row['major_id'])  && ($major == $row['class']) )
					echo "<font><u>".$row['art_name']."[".$row['class_name']."]</u></font>&nbsp;&nbsp;";
				else
					echo "<a href='art_teacher_chose_grade2.php?select_year=".$year."&major_id=".$row['major_id']."&class=".$row['class']."' ><font color=blue><u>".$row['art_name']."[".$row['class_name']."]</u></font></a>&nbsp;&nbsp;";
			}
		}
		else
		{
			echo "����";
			echo "</td></tr>";
			echo "</table>";
 			@include($baseDIR."/bysj/inc_foot.php");
 			exit(0);

		}
		echo "&nbsp;<br>&nbsp;<br>";
	?>
	
	
<?php
	//���㵱ǰ�Ѿ����˶��ٸ�ѧ����һ�����Դ����ٸ�ѧ��
 	$sql = "SELECT * FROM  `".$ART_TABLE."teacher_student` WHERE major_id = '".$instrument."' AND teacher_id ='".$teacher_id."' AND class='".$major."' AND year = '".$year."'  ";
 	if(mysql_num_rows(mysql_query($sql)))
 	{ 
 		$row = mysql_fetch_array(mysql_query($sql));
 		$sum = $row['value'];
 	}
 	else
 	{
 		$sum=0;
 	}
 	
 	if($_GET['major_id'] ==11)
		$instrument = "vocalmusic";
	if($_GET['major_id'] ==12 )
		$instrument = "piano";
	
	$sql = "SELECT * FROM ".$ART_TABLE."vocalmusic_student_select 
			LEFT JOIN ".$TABLE."student_sheet ON  ".$ART_TABLE."vocalmusic_student_select.student_number = ".$TABLE."student_sheet.number 
			LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = ".$TABLE."major.name  
			WHERE ".$instrument."_finally = '".$teacher_id."' AND ".$ART_TABLE."vocalmusic_student_select.year = '".$year."' AND  ".$TABLE."major.id= '".$major."'  ";
 	$select = mysql_num_rows(mysql_query($sql));
 	//echo $sql;
 	
 	if($_POST)
 	{
 		if(!$can_select)
 		{
 			Show_Message("��ѡ��׶Ρ�<br>
	           ��Ҫ�޸ģ�����ϵ����Ա��лл��");
	           echo "</table>";
	       @include($baseDIR."/bysj/inc_foot.php");
	       exit;
 		}
 	}
 	
	//����postʱ��
 	if(isset($_POST['add']))
 	{
 		//$TEST['add'][$teacher_id][1241241]=124124;
 		foreach ($_SESSION[$teacher_id] as $key => $value) {
 			if($value == 1) //���
 			{ 
 				if($select < $sum)
 				{ 
		 			$sql = "UPDATE  `".$ART_TABLE."vocalmusic_student_select` SET  `".$instrument."_finally` =  '".$teacher_id."'  WHERE `student_number` ='".$key."';";
		 			//echo $sql ."<br>";
		 			mysql_query($sql);
		 			$select++;
 				}
 				else
 				{
 					echo "<script>alert('���Ѿ�������ָ��ѧ�����������ޣ�')</script>";
 					break;
 				}
 			}
 		}
 	}
 	if(isset($_POST['remove']))
 	{

 		foreach ($_SESSION[$teacher_id] as $key => $value) {
 		if($value == 2) //���
 			{ 
	 			$sql = "UPDATE  `".$ART_TABLE."vocalmusic_student_select` SET  `".$instrument."_finally` =  '0'  WHERE `student_number` ='".$key."';";
	 			//echo $sql ."<br>";
				mysql_query($sql);
				$select--;
 			}
 		}
 	}
 	
 	//ÿ�ζ�Ҫ�������ѧ����session
 	unset($_SESSION[$teacher_id]);
 	
 	

?>

<?php
//����Ӧ��ѡ��ڼ�־Ը
$sql = "SELECT * FROM  `".$ART_TABLE."vocalmusic_student_select` 
	 		LEFT JOIN ".$TABLE."student_sheet ON ".$ART_TABLE."vocalmusic_student_select.student_number = ".$TABLE."student_sheet.number  
	 		LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = bysj_major.name 
	 		WHERE `".$instrument."_first`='".$teacher_id."' AND `".$instrument."_finally`='0' AND ".$ART_TABLE."vocalmusic_student_select.year = '".$year."' AND  ".$TABLE."major.id='".$major."' ";
	 //		echo $sql;
$first = mysql_num_rows(mysql_query($sql));

$sql = "SELECT * FROM  `".$ART_TABLE."vocalmusic_student_select` 
	 		LEFT JOIN ".$TABLE."student_sheet ON ".$ART_TABLE."vocalmusic_student_select.student_number = ".$TABLE."student_sheet.number  
	 		LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = bysj_major.name 
	 		WHERE `".$instrument."_second`='".$teacher_id."' AND `".$instrument."_finally`='0' AND ".$ART_TABLE."vocalmusic_student_select.year = '".$year."' AND  ".$TABLE."major.id='".$major."' ";
	 //		echo $sql;
$second = mysql_num_rows(mysql_query($sql));

//$sql = "SELECT * FROM  `".$ART_TABLE."instrument_student_select` 
//	 		LEFT JOIN ".$TABLE."student_sheet ON ".$ART_TABLE."instrument_student_select.student_number = ".$TABLE."student_sheet.number  
//	 		LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = bysj_major.name 
//	 		WHERE `third`='".$instrument."' AND `finally`='0' AND ".$ART_TABLE."instrument_student_select.year = '".$year."' AND  ".$TABLE."major.id='".$major."' ";
//$third = mysql_num_rows(mysql_query($sql));

if($first > 0)
	$volunteer = 1;
else if($second > 0)
	$volunteer = 2;
else
	$volunteer = 3;

?>
<table width="800" border="0" align="center" cellpadding="3">
</tr>
<tr>
	<td align=center><font size=+1>��ѡ���ѧ��(<?php echo $select;?>/<?php echo $sum;?>)</font></td><td></td><td  align=center><font size=+1>��<?php echo $volunteer;?>־Ըѧ������</font></td>
</tr>
<tr>
	<td><iframe width=300 height=600 src="./teacher_had_chose2.php?year=<?php echo $year;?>&instrument=<?php echo $instrument;?>&major=<?php echo $major; ?>&volunteer=<?php echo $volunteer;?>"> </iframe></td>
	<td width=200 align=center>
		<form action="" method="post">
		<input type="submit" name="add" value=""  style="background:url('../images/left.png');width:50px;height:50px;border:0px;cursor:pointer" ><br><br><br><br>
		<input type="submit" name="remove" value=""  style="background:url('../images/right.png');width:50px;height:50px;border:0px;cursor:pointer">
		</form>
	</td>
	<td><iframe width=300 height=600 src="./teacher_chose_volunteer2.php?year=<?php echo $year;?>&instrument=<?php echo $instrument;?>&major=<?php echo $major; ?>&volunteer=<?php echo $volunteer;?>"> </iframe></td>
</tr>
</table>
<br>

</td>
</tr>
</table>


<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

<script language=JavaScript >

$(document).ready(function(){
)};

</script>
