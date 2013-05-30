<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "教师选择学生";
$YM_ZT2 = "查看选题选择情况 选择学生";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限:普通教师
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
<?php
//指导的专业用新的机制
	 $curr_pro_id = $set_pro_id;
//         $majiorlist = get_majior_list();
//         $pro_list = explode(",", $com_pro_id);  
	 echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请选择操作的专业：";
//	 $pro_name = "";
//	 while(list($k,$v)=each($majiorlist)){
//	 	   if(in_array($k,$pro_list)&&$v[open]){
//	 	   	   if($curr_pro_id ==0) $curr_pro_id = $k;
//	 	   	   if($curr_pro_id == $v["id"]){
//	 	   	   	    echo "[<b>".$v["name"]."</b>]";
//			 	    $pro_name = $v["name"];
//	 	   	   } else echo "[<a href=".$PHP_SELF."?set_pro_id=".$k."><font color=blue><u>".$v["name"]."</u></font></a>]";
//	 	   	   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//	 	   }
// 	 }
	$sql = "SELECT ".$ART_TABLE."teacher_student.id, major_id, teacher_id, class, YEAR, value, ".$TABLE."major.name AS class_name , ".$ART_TABLE."major.name AS art_name,grade
			FROM ".$ART_TABLE."teacher_student
			LEFT JOIN ".$TABLE."major ON ".$ART_TABLE."teacher_student.class = ".$TABLE."major.id 
			LEFT JOIN ".$ART_TABLE."major ON ".$ART_TABLE."teacher_student.major_id = ".$ART_TABLE."major.id
			WHERE teacher_id =  '".$_SESSION['com_id']."' && year =  '".$year."' && value > 0 && grade =4" ;
			//echo $sql;
	$query = mysql_query($sql);
//	mysql_fetch_array($query);
	if(mysql_num_rows($query))
	{
		while($row = mysql_fetch_array($query))
		{
			if($curr_pro_id ==0) $curr_pro_id = $row['class'];
	 	   	if($curr_pro_id == $row['class']){
	 	   		echo "[<b>".$row['class_name']."</b>]";
				$pro_name = $row['class_name'];
	 	   	} else echo "[<a href=".$PHP_SELF."?set_pro_id=".$row['class']."><font color=blue><u>".$row['class_name']."</u></font></a>]";
		}
			
	}
	else
	{
		echo "无";
	}
 	 echo "</p>";
 	if($pro_name==""){
 		echo "<br><br>";
 		Show_Message("对不起，您的访问被拒绝，请求助管理员解决问题。");
 		@include($baseDIR."/bysj/inc_foot.php");
 		exit;
 	}

	//取得指导人数上限
// 	 $sql = "select (0+mid('$com_pro_num',instr('$com_pro_num',',".$curr_pro_id."-')+".strlen(",".$curr_pro_id."-").",2)) as lead_student"; 
// 	 $que_sql = mysql_query($sql);
// 	 $fet_result = mysql_fetch_array($que_sql); 
// 	 $allow_num = $fet_result["lead_student"];
	//取得指导人数上限(新)
	$sql = "SELECT ".$ART_TABLE."teacher_student.id, major_id, teacher_id, class, YEAR, value, ".$TABLE."major.name AS class_name , ".$ART_TABLE."major.name AS art_name,grade
			FROM ".$ART_TABLE."teacher_student
			LEFT JOIN ".$TABLE."major ON ".$ART_TABLE."teacher_student.class = ".$TABLE."major.id 
			LEFT JOIN ".$ART_TABLE."major ON ".$ART_TABLE."teacher_student.major_id = ".$ART_TABLE."major.id
			WHERE teacher_id =  '".$_SESSION['com_id']."' && year =  '".$year."' && class = '".$curr_pro_id."' && grade =4" ;
	//echo $sql;
	$que_sql = mysql_query($sql);
	$fet_result = mysql_fetch_array($que_sql); 
	$allow_num = $fet_result['value'];
 	
 	if($_POST["submit"]){
		$ok = array();
 		$selectlist = array();
 		$oknum = 0;
 		for($i=0;$i<$cnt;$i++){
 			$xz = "xuanze".$i;
 			$kt = "ketiid".$i;
 			$selected = $$xz;
 			$id = $$kt;
 			$number = $selected[0];
 			$selectlist[$i][id]=$id[0];
 			$selectlist[$i][number]=$number;
 			if($number == 1) continue; 
 			if(!in_array($number,$ok)){
 				$oknum ++;
 				$ok[] = $number;
 			} 
 		}
 		if($oknum > $allow_num){
 			echo "<br><br>";
 			Show_Message("根据指导名额分配结果，您的指导上限为 $allow_num 人<br>目前您选择了 $oknum 名学生，已超限。<br><br>本次提交无效，请重新选择！");
 			@include($baseDIR."/bysj/inc_foot.php");
 			exit;
 		}
 		unset($ok);
 		$ok = array();
 		for($i=0;$i<$cnt;$i++){
 			$id = $selectlist[$i][id];
 			$number = $selectlist[$i][number];
 			if($number == 1||in_array($number,$ok)){
 				$oa = mysql_query("select source,is_select,student_pro_id,student_number from ".$TABLE."topic where id = $id");
 				$ao = mysql_fetch_array($oa);
 				if($ao["source"]==0&&$ao["is_select"]==1){
 					mysql_query("update ".$TABLE."topic set student_number = '0',is_select = '0',student_pro_id='0'  where id = $id");
 				} else if ($ao["source"]==1&&$ao["is_select"]==1){  
 					mysql_query("update ".$TABLE."topic set is_select = '0',student_pro_id='0' where id = $id");
 					mysql_query("insert into ".$TABLE."student_select(number,topic_num,wish,pro_id) values  ('$ao[student_number]','$id','自选','$ao[student_pro_id]')");
 				}
 			} else if($number!=0&&!in_array($number,$ok)){
 				mysql_query("update ".$TABLE."topic set student_number = '$number',is_select = '1',student_pro_id='$curr_pro_id' where id = $id");
 				mysql_query("delete from ".$TABLE."student_select where number = '$number' or topic_num = '$id'");
	 			$ok[] = $number; 
 			} 
 		}
 	}
 	
 	 //查看当前是否可以选择学生
	$sql = "select * from ".$ART_TABLE."set_date where grade = 4";
	//echo $sql;
	$que_sql = mysql_query($sql);
	$fet_result = mysql_fetch_array($que_sql);
	$now = time(0);
	$time_start = $fet_result["teacher_start"];
	$time_end = $fet_result["teacher_end"];
	
	if($now>=$time_end){
		$msg = "<b>".$pro_name."</b> 专业 目前没有 教师选择学生 阶段安排，请留意相关通知了解情况，谢谢。";
		 $can_select = false;
	} else if($now<=$time_start){
		$msg = "<b>".$pro_name."</b> 专业您可指导 <font color = 'red' size=+1><b>".$allow_num."</b></font> 名学生；选择学生日期为：<b>".date("Y-m-d",$time_start)."～".date("Y-m-d",$time_end)."</b>，目前未到时间。";
		 $can_select = false;
	}  else {
		 $can_select = true;
 	 	//取得当前指导数
 	 	$sql = "select teacher_id from ".$TABLE."topic where (teacher_id = '$teacher_id') and (is_select = 1) &&year='$YEAR_C'&&student_pro_id='$curr_pro_id' ";
 	 	$que_sql = mysql_query($sql);
 	 	$select_num = mysql_num_rows($que_sql); 
 	 	
 	 	$msg = "<b>".$pro_name."</b> 专业 选择学生截至日期：<b>".date("Y-m-d",$time_end)."</b>，您可指导 <font color = 'red' size=+1><b>".$allow_num."</b></font> 名学生，当前已选 <b><font color =red size=+1>".$select_num."</font></b> 名学生";
 	 	
 	 	//delete hisselect from `bysj_student_select` as hisselect , `bysj_topic` as topic where hisselect.topic_num=topic.id && topic.teacher_id='zjl102'
 	 	//若当前已经选满，则可以选择删除其他候选学生
 	}
	
?>

<form id="form1" name="form1" method="post" action="<?php echo $PHP_SLF;?>">
<table width="800" border="1"    cellpadding=5 bordercolor=#000000>
	<tr align="center">
		<td colspan="2"><?php echo $msg; ?></td>
	</tr>
	<tr align="center" bgColor=#5a6e8f  height=38>
		<td><font color=#FFFFFF><b>您提交的毕业设计候选题目</b></font></td>
		<td><font color=#FFFFFF><b>当前选择该题的学生名单</b></font></td>
	</tr>
	<?php
		$sql = "select id,topic,source,student_number,is_select  from ".$TABLE."topic where verify>0&&teacher_id = '$teacher_id' &&year='$YEAR_C'&&profession REGEXP '^".$curr_pro_id.",|,".$curr_pro_id.",|,".$curr_pro_id."$|^".$curr_pro_id."$'&&(is_select!=1||student_pro_id=".$curr_pro_id.")";
		$que_sql = mysql_query($sql);
		$i = 0;
		$currrows = 0;
		if($que_sql) $currrows=mysql_num_rows($que_sql);  
		if($currrows<1){
			$can_select = false;
			$currrows = 0;
			echo "<tr><td colspan=2 height=188 align=center>对不起，您没有本专业的合适课题</td></tr>";
		}
		while($currrows && $row = mysql_fetch_array($que_sql)){
			$id = $row["id"];  //课题编号
			$pupil = "pupil".$i;
			echo "\n<tr align=left>";
			echo "<td width=260>".$row["topic"]."</td>";
			echo "<td width=500>";
			echo "<input type=hidden name=ketiid".$i."[] value=$id>";
			echo "<input type=radio name=xuanze".$i."[] value=1 checked> 取消&nbsp;&nbsp;";
			if($row["student_number"]!=0&&$row["is_select"]==1){
				$ik = mysql_query("select name from ".$TABLE."student_sheet where number = '$row[student_number]'");
				$ki = mysql_fetch_array($ik);
				echo "<input type=radio name=xuanze".$i."[] value=".$row["student_number"]." checked> ";
				echo $ki["name"]."(<font color=blue>选定</font>)";
			} else {
				$sql2 = "select student.number,pro_id,wish,name,class,mobilephone,short_number,aihao,chengji from ".$TABLE."student_select as selectit,".$TABLE."student_sheet as student where topic_num = '$id' &&student.number=selectit.number ORDER BY wish,rand(time(0)%10)";
				//echo $sql2;
				$que_sql2  = mysql_query($sql2);
				while($student = mysql_fetch_array($que_sql2)){
					  $hisname =  $student["name"]."(".$student["wish"].")"." ";
					  $omsg = "";
					  $scolor = "black";  
					  $disit = "";  
					  $sql3 = "select min(wish) as firstwish from ".$TABLE."student_select where number=".$student["number"]." order by wish;";
					  $que_sql3 = mysql_query($sql3);
					  $wishlist = mysql_fetch_array($que_sql3);
					  $firstwish = $wishlist["firstwish"];
					  //echo "<br>".$firstwish."</br>";
					  if($firstwish<1) $firstwish = 1;
					  if(($student["wish"]==$firstwish||$student["wish"]=='自选') && $student["pro_id"]!=$curr_pro_id) {
					   	$disit = " disabled style='border:0'";
					   	$scolor = "gray";
					   	$omsg = "【非本专业】";
					  } else   if($student["wish"]>$firstwish&&$student["wish"]!='自选'){
					   	$disit = " disabled style='border:0'";
					   	$scolor = "gray";
					   	$omsg = "【非第一志愿】";
					  }  else {
					   	$scolor = "blue";
					 }
					  $cjc = array(0=>"一般",1=>"较差",2=>"很差",3=>"较好",4=>"很好");
					  $hisname = "<span  onmouseover=\"showTip('".$omsg.$student["name"]."：".$student["class"]."，".$student["mobilephone"]."/".$student["short_number"]."！<br>学生自我评价：成绩".$cjc[$student["chengji"]+0]."，设计方向：".$student["aihao"]."')\" onmouseout=hideTip() >".$hisname."</span>";
					  echo "<input type=radio ".$disit."  name=xuanze".$i."[] value=".$student["number"]."> <font color=".$scolor.">".$hisname."</font>&nbsp;&nbsp;";
				}
			}
			echo "&nbsp;";
			echo "</td>";
			echo "</tr>";
			$i++;
		}
	echo "</table>";
	if($can_select){
		echo "<p align=center>";
		echo "<input type=hidden name=cnt value=$i>";
		echo "<input type=hidden name=set_pro_id value=$curr_pro_id>";
		//echo "<input type=checkbox name=";
		echo "<input type=submit name=submit value=提交我的选择意愿>";
		echo "<p>";
	}
echo "</form>";
?>
<p>
<table width="90%" class="STYLE1" align=center>
<tr>
<td>注意：</td>
</tr>
<tr>
<td>
<li> 学生姓名后的”（数字）”表示学生选该题的志愿次序。例如”张三(2)“表示张三同学在第2志愿上选择该题。
<li> 学生姓名后的”（自选）”表示学生自己提交了该题目，希望由您指导他的毕业设计。
<li> 教师只能选择“第一志愿”学生或者“自选”课题学生。若需要选择其他学生，必须联系学生修改志愿。
<li><font color=red>【特别注意】教师确认选择某学生后，该课题的其他学生将自动删除，无法恢复，故，请慎重选择学生。</font>
<li> 若题目未经教研室主任审核，您将不能为该题选择学生，通过审核后方可选择学生。
<li> 每个老师均设有指导人数的上限，若您的选择大于上限，则最后多余的课题自动取消选择。
</td>
</tr>
</table>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>