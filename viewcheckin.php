<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�鿴ѧ��ǩ�����";
$YM_MK = "��ҵ��ƹ���ϵͳ";
$YM_DH = 0; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ�ޣ�ָ����ʦ
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
<?php
if($view == "all") $viewurl = " (<a href=".$PHP_SELF."><font color=blue><u>ֻ�����µ�</u></font></a>)";
else $viewurl = " (<a href=".$PHP_SELF."?view=all><font color=blue><u>ǩ����ʷ��¼</u></font></a>)";
if($com_auth<80){
	$show = "";
	$showallurl = "";
} else {
	if($show == "all") {
		$showallurl = " (<a href=".$PHP_SELF."><font color=blue><u>ֻ���Լ���</u></font></a>)";
		$viewurl  = "";
	} else $showallurl = " (<a href=".$PHP_SELF."?show=all><font color=blue><u>ȫ��ǩ����Ϣ</u></font></a>)";
}
?>
	<br><br><font size=+2 face=����><b>��ҵ��ƹ���ϵͳ ѧ��ǩ�����</b></font><?php echo $showallurl."  ".$viewurl;?><br><br>
  <table width=<?php echo $show=="all"?980:900;?> height="206" border="1" cellpadding="8" cellspacing="0" bordercolor="#000000">
  	<tr  bgColor=#5a6e8f align=center>
  		<td width=30><font color=#FFFFFF>���</font></td>
  		<td width=90><font color=#FFFFFF>�༶</font></td>
  		<td width=60><font color=#FFFFFF>ѧ������</font></td>
  		<td width=90><font color=#FFFFFF>����ǩ��ʱ��</font></td>
  		<td width=100><font color=#FFFFFF>������ϵ�绰</font></td>
  		<td width=90><font color=#FFFFFF>���ڵ�</font></td>
  		<td width=60><font color=#FFFFFF>��Уʱ��</font></td>
<?php  		
if($show=="all") echo "<td width=60><font color=#FFFFFF>�������</font></td><td><font color=#FFFFFF>��λ����</font></td>";
else echo "<td><font color=#FFFFFF>ѧ������</font></td>";
?>  		
  	</tr>  	
<?php
if($show=="all"){
   $sql = "select teacher.name as tname,work,company,class,student.name,checktime,checkin.mobile,city,memo,backtime from ".$TABLE."student_sheet as student,".$TABLE."checkin as checkin,".$TABLE."teacher_information as teacher where teacher.teacher_id=checkin.teacher_id&&student.number=checkin.student_id && id in(select SUBSTRING_INDEX(group_concat(id order by `checktime` desc),',',1) from ".$TABLE."checkin group by student_id) order by `tname`,`checktime` desc";
} else {
	if($view=="all")
   		$sql = "select class,student.name,checktime,checkin.mobile,city,memo,backtime from ".$TABLE."student_sheet as student,".$TABLE."checkin as checkin where teacher_id='$teacher_id'&&student.number=checkin.student_id  order by `student_id`,`checktime` desc";
	else 
   		$sql = "select class,student.name,checktime,checkin.mobile,city,memo,backtime from ".$TABLE."student_sheet as student,".$TABLE."checkin as checkin where teacher_id='$teacher_id'&&student.number=checkin.student_id && id in(select SUBSTRING_INDEX(group_concat(id order by `checktime` desc),',',1) from ".$TABLE."checkin group by student_id) order by `checktime` desc";
}
$que = mysql_query($sql);
if($que) $currrows=mysql_num_rows($que);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=168 colspan=".($show=="all"?9:8)." align=center><b>��ǰû������ѧ����ǩ����Ϣ����֪ͨ���Ǽ�ʱǩ����лл��</td></tr>";
}    
$bt = array("�ѻ�У","һ����","<font color=green>������</font>","<font color=blue>һ����</font>","<font color=red>��δ��</font>");
$gz = array("ѧϰ��","�ҹ���","<font color=green>δǩԼ</font>","<font color=blue>��ǩԼ</font>","<font color=red>��ʽ����</font>","<font color=red>������</font>");
$cnt = 0;
$lastname = "";
while($res = @mysql_fetch_array($que)){
	$cnt ++;
	$class = $res["class"];
	$studentname = $res[name];
	if($lastname==$studentname) $samecolor = "#EEEEEE";
	else $samecolor = "";
	$lastname = $studentname;
	$teachername = $res[tname];
	$checktime = date("Y-m-d",$res[checktime]);
	$mobile = substr($res[mobile],0,11);
	$city = $res[city];
	$city = str_replace("�㶫","",$city);
	$city = str_replace("ʡ","",$city);
	$city = str_replace("��","",$city);
	$memo = $res[memo];
	$backtime = $bt[$res[backtime]];
	$gongzuo = $gz[$res[work]];
	$company = $res[company];
	echo "<tr align=center bgcolor=$samecolor>";
	echo "<td>".$cnt."</td>";
	echo "<td>".$class."</td>";
	echo "<td>".$studentname."</td>";
	echo "<td>".$checktime."</td>";
	echo "<td>".$mobile."</td>";
	echo "<td>".$city."</td>";
	echo "<td>".$backtime."</td>";
	if($show=="all") echo "<td>$gongzuo</td><td>$company</td>";
	else echo "<td align=left>".($teachername?("[<font color=blue>".$teachername."</font>] "):"").$memo."</td>";
	echo "</tr>";
}
?>
  </table>
  <br>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
