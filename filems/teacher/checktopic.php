<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "��ҵ�����Ŀ�޸�";
$YM_ZT2 = "�޸ı�ҵ�����Ŀ������";
$YM_MK = "��ҵ��ƴ�����ϵͳ";
$YM_PT = "���ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ�ޣ�����Ա
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
 
 <?php
 if($seeall!="yeah") $seeall = "";
 ?>
<table width=800 border=1 align=center cellpadding=3 bordercolor=#000000>
<tr align=center  bgColor=#5a6e8f  height=38>
	<td width=18><font color=#FFFFFF>��ʦ</font></td>
<td width=110><font color=#FFFFFF>�༶</font></td>
<td width=18><font color=#FFFFFF>ѧ��</font></td>
<td width=66><font color=#FFFFFF>ѧ������</font></td>
<td><font color=#FFFFFF>�������� <font size=+1><b><?php echo $CURR_YEAR;?>��</b></font></font></td>
<td width=80><font color=#FFFFFF>��������</font></td>
<td width=60><font color=#FFFFFF>����</font></td>
<?php
    echo "</tr>";
    $tdcnt += 6;  //����ܵ� td ��
    //print_r($mission_list);
    
    $all_doc = array();
    $count = 0;
    $missall = mysql_query("select * from ".$TABLE."mission_log");
    while($madata = mysql_fetch_array($missall)){
      	 $all_doc[$madata["mission_id"]][$madata["student_id"]]["teacherid"] = $madata["teacher_id"];
      	 $all_doc[$madata["mission_id"]][$madata["student_id"]]["filename"] = $madata["filename"];
      	 $all_doc[$madata["mission_id"]][$madata["student_id"]]["first_upload"] = $madata["first_upload"];
    }
   $sql = "select topic,student_number,class,".$TABLE."student_sheet.name as sname,".$TABLE."teacher_information.name as tname, ".$TABLE."topic .teacher_id as tid,".$TABLE."topic .id as did, ".$TABLE."title_sort.name as typename from ".$TABLE."topic ,".$TABLE."teacher_information,".$TABLE."student_sheet,".$TABLE."title_sort where ".$TABLE."student_sheet.number=".$TABLE."topic .student_number && ".$TABLE."teacher_information.teacher_id = ".$TABLE."topic .teacher_id && is_select = 1  && ".$TABLE."title_sort.id = ".$TABLE."topic .type&& ".$TABLE."topic.year=$CURR_YEAR   order by ".$TABLE."topic .teacher_id, ".$TABLE."student_sheet.number";
   $ab = mysql_query($sql);  
   $schedule = array();
   $tcnt = array();
   while($ba = mysql_fetch_array($ab)){
	   $tname = $ba["tname"];
	   $tid = $ba["tid"];
	   $did = $ba["did"];
	   $class = $ba["class"];
	   $sname = $ba["sname"];
	   $topic = $ba["topic"];
	   $typename = $ba["typename"];
	   $snumber = $ba["student_number"];
	   $schedule[$snumber]["teacher"] = $tname;
	   $schedule[$snumber]["tid"] = $tid;
	   $schedule[$snumber]["did"] = $did;
	   $tcnt[$tname] ++ ;
	   $schedule[$snumber]["class"] = $class;
	   $schedule[$snumber]["name"] = $sname;
	   $schedule[$snumber]["topic"] = $topic;
	   $schedule[$snumber]["typename"] = $typename;
   }
$oldteacher = "";   
while(list($k,$v) = each($schedule)){
	if($seeall!="yeah"&&$v["tid"]!=$teacher_id) continue;  //ֻ���Լ���ѧ��
	echo "<tr align=center height=32>";
	if($oldteacher != $v["teacher"]){
		 $oldteacher = $v["teacher"];
		 echo "<td  width=18 rowspan=".$tcnt[$oldteacher].">".$oldteacher."</td>";
	}
	//echo "<td>".$all_doc[$mission_list[0]["id"]][$k]["teacherid"]."</td>";
   echo "<td>".$v["class"]."</td>".
            "<td>".substr($k,strlen($k)-2)."</td>".
            "<td>".$v["name"]."</td>".
            "<td align=left>".$v["topic"]."</td>".
            "<td width=80>".$v["typename"]."</td>".
            "<td width=60>".
            (($bbb["authority"]==99||$v["tid"]==$teacher_id)?("[<a href=/bysj/teacher/revise.php?id=".$v["did"]." target=_blank>�޸�</a>] "):"").
            "</td>";
    echo "</tr>";
}            
      echo    "</table>";
?>
<table width="780" align="center">
<tr align=left>
<td><br>˵����<br />
	<li><font color=red>���ر�ע�⡿</font>��˶Ը��ĵ��Ƿ�����Ŀһ�£��Լ���Ŀ�������Ƿ���ʣ����������޸ģ�</li>
</td>
</tr>
</table>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

