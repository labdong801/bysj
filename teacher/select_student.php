<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "��ʦѡ��ѧ��";
$YM_ZT2 = "�鿴ѡ��ѡ����� ѡ��ѧ��";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��:��ͨ��ʦ
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
<?php
//ָ����רҵ���µĻ���
	 $curr_pro_id = $set_pro_id;
//         $majiorlist = get_majior_list();
//         $pro_list = explode(",", $com_pro_id);  
	 echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��ѡ�������רҵ��";
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
		echo "��";
	}
 	 echo "</p>";
 	if($pro_name==""){
 		echo "<br><br>";
 		Show_Message("�Բ������ķ��ʱ��ܾ�������������Ա������⡣");
 		@include($baseDIR."/bysj/inc_foot.php");
 		exit;
 	}

	//ȡ��ָ����������
// 	 $sql = "select (0+mid('$com_pro_num',instr('$com_pro_num',',".$curr_pro_id."-')+".strlen(",".$curr_pro_id."-").",2)) as lead_student"; 
// 	 $que_sql = mysql_query($sql);
// 	 $fet_result = mysql_fetch_array($que_sql); 
// 	 $allow_num = $fet_result["lead_student"];
	//ȡ��ָ����������(��)
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
 			Show_Message("����ָ�����������������ָ������Ϊ $allow_num ��<br>Ŀǰ��ѡ���� $oknum ��ѧ�����ѳ��ޡ�<br><br>�����ύ��Ч��������ѡ��");
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
 					mysql_query("insert into ".$TABLE."student_select(number,topic_num,wish,pro_id) values  ('$ao[student_number]','$id','��ѡ','$ao[student_pro_id]')");
 				}
 			} else if($number!=0&&!in_array($number,$ok)){
 				mysql_query("update ".$TABLE."topic set student_number = '$number',is_select = '1',student_pro_id='$curr_pro_id' where id = $id");
 				mysql_query("delete from ".$TABLE."student_select where number = '$number' or topic_num = '$id'");
	 			$ok[] = $number; 
 			} 
 		}
 	}
 	
 	 //�鿴��ǰ�Ƿ����ѡ��ѧ��
	$sql = "select * from ".$ART_TABLE."set_date where grade = 4";
	//echo $sql;
	$que_sql = mysql_query($sql);
	$fet_result = mysql_fetch_array($que_sql);
	$now = time(0);
	$time_start = $fet_result["teacher_start"];
	$time_end = $fet_result["teacher_end"];
	
	if($now>=$time_end){
		$msg = "<b>".$pro_name."</b> רҵ Ŀǰû�� ��ʦѡ��ѧ�� �׶ΰ��ţ����������֪ͨ�˽������лл��";
		 $can_select = false;
	} else if($now<=$time_start){
		$msg = "<b>".$pro_name."</b> רҵ����ָ�� <font color = 'red' size=+1><b>".$allow_num."</b></font> ��ѧ����ѡ��ѧ������Ϊ��<b>".date("Y-m-d",$time_start)."��".date("Y-m-d",$time_end)."</b>��Ŀǰδ��ʱ�䡣";
		 $can_select = false;
	}  else {
		 $can_select = true;
 	 	//ȡ�õ�ǰָ����
 	 	$sql = "select teacher_id from ".$TABLE."topic where (teacher_id = '$teacher_id') and (is_select = 1) &&year='$YEAR_C'&&student_pro_id='$curr_pro_id' ";
 	 	$que_sql = mysql_query($sql);
 	 	$select_num = mysql_num_rows($que_sql); 
 	 	
 	 	$msg = "<b>".$pro_name."</b> רҵ ѡ��ѧ���������ڣ�<b>".date("Y-m-d",$time_end)."</b>������ָ�� <font color = 'red' size=+1><b>".$allow_num."</b></font> ��ѧ������ǰ��ѡ <b><font color =red size=+1>".$select_num."</font></b> ��ѧ��";
 	 	
 	 	//delete hisselect from `bysj_student_select` as hisselect , `bysj_topic` as topic where hisselect.topic_num=topic.id && topic.teacher_id='zjl102'
 	 	//����ǰ�Ѿ�ѡ���������ѡ��ɾ��������ѡѧ��
 	}
	
?>

<form id="form1" name="form1" method="post" action="<?php echo $PHP_SLF;?>">
<table width="800" border="1"    cellpadding=5 bordercolor=#000000>
	<tr align="center">
		<td colspan="2"><?php echo $msg; ?></td>
	</tr>
	<tr align="center" bgColor=#5a6e8f  height=38>
		<td><font color=#FFFFFF><b>���ύ�ı�ҵ��ƺ�ѡ��Ŀ</b></font></td>
		<td><font color=#FFFFFF><b>��ǰѡ������ѧ������</b></font></td>
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
			echo "<tr><td colspan=2 height=188 align=center>�Բ�����û�б�רҵ�ĺ��ʿ���</td></tr>";
		}
		while($currrows && $row = mysql_fetch_array($que_sql)){
			$id = $row["id"];  //������
			$pupil = "pupil".$i;
			echo "\n<tr align=left>";
			echo "<td width=260>".$row["topic"]."</td>";
			echo "<td width=500>";
			echo "<input type=hidden name=ketiid".$i."[] value=$id>";
			echo "<input type=radio name=xuanze".$i."[] value=1 checked> ȡ��&nbsp;&nbsp;";
			if($row["student_number"]!=0&&$row["is_select"]==1){
				$ik = mysql_query("select name from ".$TABLE."student_sheet where number = '$row[student_number]'");
				$ki = mysql_fetch_array($ik);
				echo "<input type=radio name=xuanze".$i."[] value=".$row["student_number"]." checked> ";
				echo $ki["name"]."(<font color=blue>ѡ��</font>)";
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
					  if(($student["wish"]==$firstwish||$student["wish"]=='��ѡ') && $student["pro_id"]!=$curr_pro_id) {
					   	$disit = " disabled style='border:0'";
					   	$scolor = "gray";
					   	$omsg = "���Ǳ�רҵ��";
					  } else   if($student["wish"]>$firstwish&&$student["wish"]!='��ѡ'){
					   	$disit = " disabled style='border:0'";
					   	$scolor = "gray";
					   	$omsg = "���ǵ�һ־Ը��";
					  }  else {
					   	$scolor = "blue";
					 }
					  $cjc = array(0=>"һ��",1=>"�ϲ�",2=>"�ܲ�",3=>"�Ϻ�",4=>"�ܺ�");
					  $hisname = "<span  onmouseover=\"showTip('".$omsg.$student["name"]."��".$student["class"]."��".$student["mobilephone"]."/".$student["short_number"]."��<br>ѧ���������ۣ��ɼ�".$cjc[$student["chengji"]+0]."����Ʒ���".$student["aihao"]."')\" onmouseout=hideTip() >".$hisname."</span>";
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
		echo "<input type=submit name=submit value=�ύ�ҵ�ѡ����Ը>";
		echo "<p>";
	}
echo "</form>";
?>
<p>
<table width="90%" class="STYLE1" align=center>
<tr>
<td>ע�⣺</td>
</tr>
<tr>
<td>
<li> ѧ��������ġ������֣�����ʾѧ��ѡ�����־Ը�������硱����(2)����ʾ����ͬѧ�ڵ�2־Ը��ѡ����⡣
<li> ѧ��������ġ�����ѡ������ʾѧ���Լ��ύ�˸���Ŀ��ϣ������ָ�����ı�ҵ��ơ�
<li> ��ʦֻ��ѡ�񡰵�һ־Ը��ѧ�����ߡ���ѡ������ѧ��������Ҫѡ������ѧ����������ϵѧ���޸�־Ը��
<li><font color=red>���ر�ע�⡿��ʦȷ��ѡ��ĳѧ���󣬸ÿ��������ѧ�����Զ�ɾ�����޷��ָ����ʣ�������ѡ��ѧ����</font>
<li> ����Ŀδ��������������ˣ���������Ϊ����ѡ��ѧ����ͨ����˺󷽿�ѡ��ѧ����
<li> ÿ����ʦ������ָ�����������ޣ�������ѡ��������ޣ���������Ŀ����Զ�ȡ��ѡ��
</td>
</tr>
</table>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>