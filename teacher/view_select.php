<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "ѧ��ѡ��һ��";
$YM_ZT2 = "�����רҵȫ��ѧ����ѡ�����";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 40; //��ҳ������ҪȨ��:רҵ����
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
		<?php
	 $curr_pro_id = $set_pro_id;

	if($select_year==$YEAR_C) echo  "[<b>".$YEAR_C."��(����)</b>]";
	else echo "[<a href=".$PHP_SELF."?select_year=".$YEAR_C."&set_pro_id=$curr_pro_id><font color=blue><u>".$YEAR_C."��(����)</u></font></a>]";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   ���죺";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) {
		if($i==$select_year) echo "[<b>".$i."��</b>] ";
		else echo "[<a href=".$PHP_SELF."?select_year=".$i."&set_pro_id=$curr_pro_id><font color=blue><u>".$i."��</u></font></a>] ";
	}
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	
         $majiorlist = get_majior_list();
         $pro_list = explode(",", $com_pro_id);  
	 echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��ѡ�������רҵ��";
	 $pro_name = "";
	 while(list($k,$v)=each($majiorlist)){
	 	   if(in_array($k,$pro_list)&&$v[open]){
	 	   	   if($curr_pro_id ==0) $curr_pro_id = $k;
	 	   	   if($curr_pro_id == $v["id"]){
	 	   	   	    echo "[<b>".$select_year."�� ".$v["name"]."</b>]";
			 	    $pro_name = $v["name"];
	 	   	   } else echo "[<a href=".$PHP_SELF."?set_pro_id=".$k."&select_year=$select_year><font color=blue><u>".$select_year."�� ".$v["name"]."</u></font></a>]";
	 	   	   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	 	   }
 	 }
 	 echo "</p>";
 	if($pro_name==""){
 		echo "<br><br>";
 		Show_Message("�Բ������ķ��ʱ��ܾ�������������Ա������⡣");
 		@include($baseDIR."/bysj/inc_foot.php");
 		exit;
 	}
	
	?>	
<table width="780" border="1"  bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td><font color=#FFFFFF>��ʦ</font></td>
<td><font color=#FFFFFF><?php echo "<b>".$select_year."�� ".$pro_name." רҵ</b>"; ?> ��Ŀ</font></td>
<td><font color=#FFFFFF>��һ־Ըѡ�����ͬѧ</font></td>
</tr>
<?php
$lastname = "";
$sql = mysql_query("select id,topic,source,student_number,is_select,verify,name from ".$TABLE."topic as topic ,".$TABLE."teacher_information as teacher where teacher.teacher_id = topic.teacher_id&&topic.year=$select_year&&topic.profession REGEXP '^".$curr_pro_id.",|,".$curr_pro_id.",|,".$curr_pro_id."$|^".$curr_pro_id."$'&&(is_select!=1||student_pro_id=".$curr_pro_id.") order by topic.teacher_id");
if($sql) $currrows=mysql_num_rows($sql);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=3 height=138 align=center>�Բ��𣬵�ǰû�� <b>".$select_year."�� ".$pro_name."רҵ</b> �ı�ҵ��ƿ���</td></tr>";
}
$i = 0;
while($row = mysql_fetch_array($sql)){
$id = $row["id"];
$pupil = "pupil".$i;
$query = mysql_query("select * from ".$TABLE."student_select where topic_num = '$id'");
if($lastname != $row["name"]){
	$lastname = $row["name"];
	$kk = !$kk;
	if($kk) $newcolor="#FFFFFF";
	else $newcolor="#DDDDDD";
} 
?>
<tr align="left" bgcolor=<?php echo $newcolor;?>>
	<td width="80"><? echo $row["name"];?></td>
<td width="360"><? echo $row["topic"];?></td>
<td >
<?php
if($row["student_number"]!=0&&$row["is_select"]==1){
?>
 &nbsp;<input type="radio" name="<? echo $pupil;?>" value="<? echo $row["student_number"];?>" checked="checked"/>
<?php
$ik = mysql_query("select name from ".$TABLE."student_sheet where number = '$row[student_number]'");
$ki = mysql_fetch_array($ik);
echo $ki["name"]."(<font color=blue>ѡ��</font>)";
}
?>
<?php
while($student = mysql_fetch_array($query)){
   $aa = mysql_query("select name,class,profession from ".$TABLE."student_sheet where number = '$student[number]'");
   $bb = mysql_fetch_array($aa);
   $hisname =  $bb["name"]."(".$student["wish"].")"." ";
   $hisname = "<span title=".$bb["class"].">".$hisname."</span>";
   if($bb["profession"]!=$pro_name)continue;
   if($student["wish"]==1 || $student["wish"]=="��ѡ"){   	  
      echo "&nbsp;<input type=radio name=".$pupil." value=".$student["number"]." /> $hisname ";
    }
}
echo "&nbsp;";
?>
</td>
</tr>
<?php
}
?>
</table>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>