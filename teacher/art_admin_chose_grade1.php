<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "��ʦѡ��ָ������ѡ�޵�ѧ��";
$YM_ZT2 = "����ѡ��ѧ������";
$YM_MK = "����ϵ˫ѡϵͳ";
$YM_PT ="��ʦѡ��";
$YM_DH = 1; //��Ҫ������
$YM_QX = 90; //����ԱȨ��
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
 

 	
 if($_GET['class'])
 	$major = $_GET['class'];
 else
 	$major = "";
 	
 	
 	
 	
 	
 
 ?>


<table width="100%" align="center">
<tr class="align_top">
<td align="left">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
	echo "<a href=".$PHP_SELF."?select_year=".$YEAR_C."><font color=blue><u>�鿴".$YEAR_C."��(����)ѡ��</u></font></a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   �鿴���������";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) echo "<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$i."��</u></font></a> ";
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	?>
	&nbsp;<br>&nbsp;<br>
	
	
	<?php
		$sql = "SELECT * FROM  `".$TABLE."major` WHERE h_level = 19";
			
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ��ѧ�갲�ŵĿγ̣�";
		
		$query = mysql_query($sql);
		if(mysql_num_rows($query))
		{ 
			while($row = mysql_fetch_array($query))
			{ 
				if($major == "")
					$major          = $row['id'];
						
				if( $major == $row['id']  )
					echo "<font><u>".$row['name']."</u></font>&nbsp;&nbsp;";
				else
					echo "<a href='art_admin_chose_grade1.php?select_year=".$year."&class=".$row['id']."' ><font color=blue><u>".$row['name']."</u></font></a>&nbsp;&nbsp;";
				
			}
		}
		else
		{
			echo "����";
			@include($baseDIR."/bysj/inc_foot.php");
			exit(0);
		}
		echo "&nbsp;<br>&nbsp;<br>";
	?>


<table width="800" border="1" align="center" cellpadding="3">
<tr align=center  bgColor=#5a6e8f  height=38>
	<td>ѧ��</td><td ><font size=+1>ѧ������</font></td><td>ѡ��</td><td>ָ����ʦ</td><td>��ע</td>
</tr>
<?php

	//$sql = "SELECT * FROM ".$ART_TABLE."instrument_student_select ORDER BY student_number ";
	$sql = "SELECT number, ".$TABLE."student_sheet.name AS student_name, finally, teacher, profession FROM ".$ART_TABLE."instrument_student_select 
		LEFT JOIN ".$TABLE."student_sheet ON ".$TABLE."student_sheet.number = ".$ART_TABLE."instrument_student_select.student_number 
		LEFT JOIN ".$TABLE."major ON ".$TABLE."major.name = ".$TABLE."student_sheet.profession
		WHERE ".$ART_TABLE."instrument_student_select.year = '".$year."' AND ".$TABLE."major.id = '".$major."' 
		ORDER BY student_number";
		//echo $sql;
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		echo "<tr height = 35><td>".$row['number']."</td><td>".$row['student_name']."</td><td width='120'>".major($row['finally'],$row['number'])."</td><td width='120'><span id='t".$row['number']."'>".teacher($row['teacher'],$row['finally'],$major,$year)."</span></td><td></td></tr>";
	}

?>
</table>
<br>

</td>
</tr>
</table>


<?php

function major($id,$student)
{
	global $ART_TABLE;
//	$sql = "SELECT *  FROM  `".$ART_TABLE."major` WHERE `id` = '".$id."'";
//	$query = mysql_query($sql);
//	if(mysql_num_rows($query))
//	{
//		$row = mysql_fetch_array($query);
//		$grade = $row['grade'];
		
		$sql = "SELECT *  FROM  `".$ART_TABLE."major` WHERE `grade` = '1' ";
		$query = mysql_query($sql);
		
		if(mysql_num_rows($query))
		{
			$result =  "<select style='width:120px; ' class='major' id='".$student."'>";
			if($id > 0)
				$result .=  "<option value=''></option>";
			else
				$result .=  "<option value='' selected></option>";
			while($row = mysql_fetch_array($query))
			{
				if($id == $row['id'] )
					$result .=  "<option value='".$row['id']."' selected='selected'>".$row['name']."</option>";
				else
					$result .=  "<option value='".$row['id']."'>".$row['name']."</option>";
			}
			$result .=  "</select>";
		}
		
		return $result;
//	}
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


  @include($baseDIR."/bysj/inc_foot.php");
?>

<script language=JavaScript >

$(document).ready(function(){
	$(".major").change( function() {
  		//alert($(this).attr("value"));
  		var s = $(this).attr("id");
  		//alert (s);
  		$.post("./ajax/admin_ajust1.php", { major: $(this).attr("value"), class: "<?php echo $major; ?>" , year: "<?php echo $year; ?>" },
		   function(data){
			     //alert("Data Loaded: " + data);
			     $("#t"+s).html(data);
			     $("#t"+s).empty();
			     $("#t"+s).append(data);
			     $(".teacher").unbind("change");
		  		$(".teacher").change( function() {
		  		//alert($(this).attr("value"));
		  		var s = $(this).attr("id");
		  		var st = $(this).parent().attr("id");
		  		$.post("./ajax/admin_ajust1.php", { teacher: $(this).attr("value"), major: $(this).attr("id") ,  student: $(this).parent().attr("id") , year: "<?php echo $year; ?> " },
				   function(data){
				     //alert("Data Loaded: " + data);
				     //$("#t"+s).html(data);
		  		});
			   });
	    	
		  });
	});
	
	$(".teacher").change( function() {
  		//alert($(this).attr("value"));
  		var s = $(this).attr("id");
  		var st = $(this).parent().attr("id");
  		$.post("./ajax/admin_ajust1.php", { teacher: $(this).attr("value"), major: $(this).attr("id") ,  student: $(this).parent().attr("id") , year: "<?php echo $year; ?> " },
		   function(data){
		     //alert("Data Loaded: " + data);
		     //$("#t"+s).html(data);
		   });
	});
	
	// �������¼�(ʹ��unbind�����ظ���)
	function bindListener(){
 		
	}
});

</script>