<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "ָ������ͳ��";
$YM_ZT2 = "��ҵ���ָ������ͳ������һ����";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 40; //��ҳ������ҪȨ�ޣ�רҵ����
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
if($select_year<$YEAR_S) $select_year = $CURR_YEAR;
 ?>
 
 <?php
	echo "�������ʾͳ�����ݣ�";
	for($i=$YEAR_C;$i>=$YEAR_S;$i--){
		if($select_year==$i) echo "[<b>".$i."��</b>]&nbsp;";
		else echo "[<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$i."��</u></font></a>]&nbsp;";
	}
	echo "<br>";

	$pro_list = explode(",", $com_pro_id);
	$majiorlist = get_majior_list($com_pro);
	$curr_pro_id = $set_pro_id;
	echo "��ѡ��Ҫ�鿴��רҵ��";
	$pro_name = "";
	$tj = "(0";
	while(list($k,$v)=each($majiorlist)){
		$tj .= "||student_pro_id='$k'";
		if(in_array($k,$pro_list)&&$v[open]){
			if($curr_pro_id ==0&&$set_pro_id!="allpro") $curr_pro_id = $k;
			if($curr_pro_id == $v["id"]){
				echo "[<b>".$select_year."��".$v["name"]."רҵ</b>]";
				$pro_name = $v["name"];
			} else {
				echo "[<a href=".$PHP_SELF."?select_year=$select_year&set_pro_id=".$k."><font color=blue><u>".$select_year."��".$v["name"]."רҵ</u></font></a>]";
			}
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}
	$tj .= ")";
	if($pro_name==""||$set_pro_id=="allpro"){
				echo "[<b>".$select_year."��".$com_from."</b>]<br><br>";
				$set_pro_id="allpro";
	} else {
				echo "[<a href=".$PHP_SELF."?select_year=$select_year&set_pro_id=allpro><font color=blue><u>".$select_year."�� ".$com_from."</u></font></a>]<br><br>";
	}
       
?>

<?php
	if($set_pro_id=="allpro"){
		$proidstr = $tj;
	} else {
		$proidstr = "student_pro_id='$curr_pro_id'";
	}
	$sql = "select class ,teacher.name as tname from ".$TABLE."topic as topic ,".$TABLE."teacher_information as teacher,".$TABLE."student_sheet as student where student.number=topic .student_number && teacher.teacher_id = topic .teacher_id && is_select = 1&&student.year='".$select_year."'&&$proidstr group by class order by class";
	//echo $sql;
	$que = mysql_query($sql);
	$classlist = array();
	$zylist = array();
	while($fet = @mysql_fetch_array($que)){
		$classlist[] =$fet["class"];
		$zyname = preg_replace("/^(.*)[0-9]{2,2}.*$/","\\1",$fet["class"]);
		if(!in_array($zyname,$zylist)) $zylist[]=$zyname;
	}
	$classnum = sizeof($classlist);
	$zynum = sizeof($zylist);
	echo "<table width=780 align=center border=1 bordercolor=#000000  cellpadding=3>";
	echo "<tr align=center  bgColor=#5a6e8f  height=30><td rowspan=2><font color=#FFFFFF>��ʦ����</font></td><td colspan=$classnum><font color=#FFFFFF><b>���༶ͳ��</b></font></td><td colspan=$zynum><font color=#FFFFFF><b>��רҵͳ��</b></font></td><td rowspan=2><font color=#FFFFFF>С��</font></td></tr>";
	echo "<tr align=center bgColor=#5a6e8f  height=30>";
	if($classnum>0){
		for($i=0;$i<$classnum;$i++) echo "<td><font color=#FFFFFF>".$classlist[$i]."</font></td>";
		for($i=0;$i<$zynum;$i++) echo "<td><font color=#FFFFFF>".$zylist[$i]."</font></td>";
	} else {
		echo "<td><font color=#FFFFFF>/</font></td>";
		echo "<td><font color=#FFFFFF>/</font></td>";
		echo "</tr><tr align=center height=138><td colspan=4>�Բ���û�� ".$select_year."�� ѧ�����������</td>";
	}
	echo "</tr>";
	$sql = "select class ,teacher.name as tname,teacher.teacher_id as tid,student_pro_id,lead_num from ".$TABLE."topic as topic ,".$TABLE."teacher_information as teacher,".$TABLE."student_sheet as student where student.number=topic .student_number && teacher.teacher_id = topic .teacher_id && is_select = 1&&student.year='".$select_year."'&&$proidstr order by teacher.teacher_id";
	//echo $sql."<br>";
	$ab = mysql_query($sql);
	$statistics = array();
	$ok_topic = array();
	while($ba = mysql_fetch_array($ab)){
		$tname = $ba["tname"];
		$class = $ba["class"];
		$pid   = $ba["student_pro_id"];
		$lead_num = $ba["lead_num"];
		$zyname = preg_replace("/^(.*)[0-9]{2,2}.*$/","\\1",$ba["class"]);
		$statistics[$tname][tid] = $ba["tid"];
		$num = array_search($zyname,$zylist);
		if(!$statistics[$tname][$num][$zyname]){			
			$nsql = "select (0+mid('$lead_num',instr('$lead_num',',".$pid."-')+".strlen(",".$pid."-").",2)) as lead_student";
			//echo $nsql."<br>"; 
			$nque = mysql_query($nsql);
			$n = mysql_fetch_array($nque);
			$allow_num = $n["lead_student"];
			$statistics[$tname][$num][$zyname] = $allow_num;
			//echo $tname.".".$num.".".$zyname.".".$allow_num."<br>";
		}
		$statistics[$tname][$zyname] ++;
		$statistics[$tname][$class] ++;
	}
	//print_r($statistics);
	$kk = array();
	while(list($k,$v) = each($statistics)){
		echo "<tr align=center><td>".$k."</td>";
		for($i=0;$i<$classnum;$i++) {
			echo "<td>".($v[$classlist[$i]]+0)."</td>";
			$kk[$i] += $v[$classlist[$i]];
		}
		$tnum = 0;
		for($i=0;$i<$zynum;$i++){
			$n1 = ($v[$zylist[$i]]+0);
			$n2 = $statistics[$k][$i][$zylist[$i]]; 
			echo "<td bgcolor=#DDDDDD>".$n1;
			if($n1<$n2) echo "<font color=red>/".$n2."</font>";
			echo "</td>";
			$tnum += $v[$zylist[$i]];
			$kk[$i+$classnum] += $v[$zylist[$i]];
			$kk[$zynum+$classnum] += $v[$zylist[$i]];
		}
		echo "<td>$tnum</td>";
		echo "</tr>\n";
	}
	echo "<tr align=center height=28><td><b>�ܼ�</b></td>";
	for($i=0;$i<$classnum+$zynum;$i++) echo "<td bgcolor=#DDDDDD><b>".$kk[$i]."</b></td>";
	for($i=0;$i<$classnum;$i++)$cnt += $kk[$i];
	echo "<td><b>$cnt</b></td>";
	echo "</tr>";
	echo "</table>";
?>

<br>
<table width="90%" class="STYLE1" align=center>
<tr align=left>
<td>��ʾ��</td>
</tr>
<tr align=left>
<td>�����ֱ�Ӹ��ƣ�ճ����EXCEL���к󣬼�����Ϊ��ҵ���ָ��������ͳ�ѧУ��</td>
</tr>
</tr>
</table>


<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
