<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�鿴�����ĵ�";
$YM_ZT2 = "��ҵ����ĵ�";
$YM_MK = "��ҵ����ĵ�����ϵͳ";
$YM_PT = "�ĵ�ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<?php
function dispEnter($content){
   $content = str_replace("\n","<br>&nbsp;&nbsp;&nbsp;&nbsp;",$content);
   return $content;
 }
$mission_id = $_GET["mission_id"];
if(!$mission_id){
	 ShowMissionList();
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}
$sql = "select * from ".$TABLE."mission_list where mission_id = $mission_id && `year`='$CURR_YEAR'&&`pro_id`=$CURR_PID order by start_time";
$que = mysql_query($sql);
$wd_fet = mysql_fetch_array($que);
if(!$wd_fet){
	ShowMissionList();
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
} 

echo "<script  type=\"text/javascript\" src=\"ajax_js_teacher.js\"></script>";
?>

<table width="800" border=0 align="center" cellpadding="3">
<tr align="center">
<td><b>�ĵ�����<?PHP echo $wd_fet["name"];?>��<b></td>
</tr>
<tr>
<td>
<p align=left>
	<?php
	$filename1 = $wd_fet["filename1"];
	$filename2 = $wd_fet["filename2"];
	echo "&nbsp;&nbsp;&nbsp;&nbsp;";
	if($filename1!=""||$filename2!=""){
	echo "����<b>".$wd_fet["name"]."</b>�Ĳο��ĵ���Ҫ�����أ�";
	TeacherArchiveDown($CURR_YEAR,$CURR_PID,$teacher_id,$xs_fet["number"],$mission_id,"1","�ο��ĵ�");
	echo "&nbsp;&nbsp;";
	if($filename2!="") {
		echo "&nbsp;&nbsp;��ע��<u>��ѧ�о���</u>������ο���";
		TeacherArchiveDown($CURR_YEAR,$CURR_PID,$teacher_id,$xs_fet["number"],$mission_id,"2","���ĵ�");
	}
}
	?>
</p>
</td>
</tr>
<tr>
  <td>
<table width="96%" border="1" align="center" bordercolor=#000000  cellpadding="6">
 <tr align="center"  bgColor=#5a6e8f  height=38>
 	<td><font color=#FFFFFF>���</font></td>
 	<td><font color=#FFFFFF>�༶</font></td>
  <td width="80"><font color=#FFFFFF>ѧ������</font></td>
  <td><font color=#FFFFFF>�ļ�״̬</font></td>
  <td><font color=#FFFFFF>ѧ������</font></td>
  <td><font color=#FFFFFF>����</font></td>
 </tr>
<?php
 $sql = "select student.class, student.name,student.number,student.tmptime as stmptime,student.mobilephone,student.short_number,log.filename,log.teacher_suggestion,log.student_suggestion  from ".$TABLE."topic as topic, ".$TABLE."student_sheet as student left join (select student_id,mission_id,filename,teacher_suggestion,student_suggestion from ".$TABLE."mission_log where mission_id='$mission_id') as log on log.student_id = student.number where student.number = topic.student_number && topic.teacher_id = '$teacher_id' && is_select = 1 && student.year=$CURR_YEAR&&student.profession='$pro_name' order by student.number";
$que = mysql_query($sql);
if($que) $currrows=mysql_num_rows($que);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=6 height=138 align=center>�Բ�����Ŀǰû��ָ�� <b>".$CURR_YEAR."�� $pro_name רҵ</b> ��ѧ��</td></tr>";
}
 $scnt = 1;
 while($xs_fet = mysql_fetch_array($que)){ 
?>
 <tr align="center">
 	<td><?php echo $scnt ++; ?></td>
 	<td><?php echo $xs_fet["class"]; ?></td>
  <td><a href="student_m.php?mission_id=<? echo $wd_fet["mission_id"]?>&student_number=<?php echo $xs_fet["number"]?>"><font color=blue><u><?php echo $xs_fet["name"]?></u></font></a>
  </td>
  <td>
  <?php 
  $uploader = $wd_fet["uploader"];
  $filename = $xs_fet[filename];
  if($filename=="") $candown = false;
  else    $candown = file_exists("../../../Docs/".$CURR_YEAR."/".$wd_fet[address]."/".$filename);
   if($candown){
	TeacherArchiveDown($CURR_YEAR,$CURR_PID,$teacher_id,$xs_fet["number"],$mission_id,"mydoc","���ظ��ĵ�");
   }else{
   	if($wd_fet["lockit"]) echo "<font color=red><b>������</b></font>";
   	else if($uploader==1) echo "<font color=red><b>���ϴ�</b></font>";
	else echo "��δ�ϴ�";
   }
  ?>    
  </td>
  <td align=left>
  <?php 
  if($xs_fet["student_suggestion"]!="") echo "<span title='".$xs_fet[student_suggestion]."'><font color=green>".substr($xs_fet[student_suggestion],0,50)." ...</font></span>";    
  else{
	 if($uploader==1) {
	 	if($candown) echo "���и��£����ش�";
	 	else echo "�뼰ʱ��ѧ��ָ�����·�����";
	 }else {
	 	if($xs_fet["stmptime"]==999) echo "<span id=s".$xs_fet["number"]."><font color=red><b>����ʦ���ҿ����ĵ��ϴ����ܡ�</b></font><input type=button onClick=\"makemoretime('s".$xs_fet["number"]."','".$xs_fet["number"]."','student')\" value=ͬ��></span>";
	 	else echo "�ֻ���".$xs_fet["mobilephone"]." (".$xs_fet["short_number"].")"; 
	 }
   }
  ?>    
  </td>
  <td><a href="student_m.php?mission_id=<? echo $wd_fet["mission_id"]?>&student_number=<?php echo $xs_fet["number"]?>"><font color=blue><u><?php
  if($uploader!=1) echo "�鿴";
  else if($candown) echo "�ش�";
  else echo "�ϴ�";
   ?></u></font></a>
  </td>
   </tr>
<?php
}
?>
</table>
</td>
</tr>
<tr>
<td height=38>
 	<?php
 	echo "&nbsp;&nbsp;&nbsp;�����������".($uploader==1?"��":"ѧ��")."��ǰ���ϴ��ĵ���";
 	TeacherArchiveDown($CURR_YEAR,$CURR_PID,$teacher_id,"allstudent",$mission_id,"alldoc","������ء�".$wd_fet["name"]."��");
 	?>
</td>
</tr>
<tr>
<td>
 <table width="96%" border=1 bordercolor=#000000 align="center" cellpadding="6">
<tr>
<td bgcolor="#FFFFFF">
<?php
 echo "���ڡ�<b>".$wd_fet["name"]."</b>����Ҫ��˵����<p>";
 echo "&nbsp;&nbsp;&nbsp;&nbsp;<font color=red>��&nbsp;�ϴ�˵�������ĵ���<b>".($wd_fet[uploader]?"��ʦ":"ѧ��")."</b>�����ϴ���".($wd_fet["lockit"]?"��ǰ����������ֹ�ϴ���":"")."��ֹ���ڣ�".date("Y��m��d��",$wd_fet["end_time"])."</font>���ĵ���С���ܳ���2M����Ҫʱѹ�����ϴ���<br>";
if($wd_fet["paper_num"]<1){
	echo "&nbsp;&nbsp;&nbsp;&nbsp;<font color=blue>��&nbsp;���ĵ��ݲ���Ҫѧ���ύֽ�ʴ�ӡ�壬�����ӡ�������ӡ�������֪ͨ��</font><br>";
} else {
	echo "&nbsp;&nbsp;&nbsp;&nbsp;<font color=blue>��&nbsp;��ӡ˵��������".$wd_fet["paper_type"]."ֽ��ӡ".$wd_fet["paper_num"]."�ݣ���ӡ��ֹ���ڣ�".date("Y��m��d��",$wd_fet["print_time"])."��</font><br>";
}
echo "&nbsp;&nbsp;&nbsp;&nbsp;".dispEnter($wd_fet["demonstration"]);
?>
</td>
</tr>
</table>
<br>
</td>
</tr>
</table>

<?php
function ShowMissionList()
{
	global $TABLE,$CURR_YEAR,$CURR_PID,$pro_name;
	echo "<b>".$CURR_YEAR."�� ".$pro_name." רҵ</b> ��ҵ����ĵ�Ҫ��һ����<br><br>";
	?>	
<table width="700" border=1 bordercolor=#000000 align="center" cellpadding="6">
	<tr align="center" bgColor=#5a6e8f  height=38>
		<td><font color=#FFFFFF>���</font></td>
		<td><font color=#FFFFFF>��ҵ�����Ҫ�Ͻ��ĵ����ĵ�</font></td>
		<td><font color=#FFFFFF>�ĵ�����</font></td>
		<td><font color=#FFFFFF>��ֹ����</font></td>
		<td><font color=#FFFFFF>�ϴ���</font></td>
 		<td><font color=#FFFFFF>����</font></td>
	</tr> 		
<?php			
  $count = 1;
  $sql = "select name,mission_id,needdoc,end_time,uploader,lockit from ".$TABLE."mission_list as list where year='$CURR_YEAR'&&`pro_id`=$CURR_PID&&lockit<2 order by start_time";
  //echo $sql;
  $miss = mysql_query($sql);
  if($miss) $currrows=mysql_num_rows($miss);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=168 colspan=6 align=center><b>".$CURR_YEAR."�� $pro_name רҵ</b><br>���ޱ�ҵ����ĵ��Ͻ�Ҫ��</td></tr>";
  }    
$uperstr = array(1=>"ָ����ʦ",0=>"ѧ��");
$lockstr = array(0=>"����",1=>"����",2=>"ȡ��");  
while($arr = @mysql_fetch_array($miss)){
	echo "<tr align=center>";
	echo "<td>$count</td>";
	echo "<td align=left><a href =teacher_m.php?mission_id=".$arr["mission_id"]."><font color=blue><u>".$arr["name"]."</u></font></a></td>";
	echo "<td>".($arr[needdoc]?"<font color=blue>��Ҫ</font>":"��ͨ")."</td>";
	echo "<td>".date("Y-m-d",$arr["end_time"])."</td>";
	echo "<td>".$uperstr[$arr["uploader"]]."</td>";
	echo "<td>";
	echo "[<a href =teacher_m.php?mission_id=".$arr["mission_id"]."><font color=blue><u>�鿴</u></font></a>]";
	if($arr["lockit"]) echo "&nbsp;[<b>������</b>]";
	echo "</td>";
        echo "</tr>";
        $count++;
}
?>
</table>
<br>
<?
}   //ShowMissionList ��������
?>


<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
