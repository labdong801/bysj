<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "��ʦ�ϴ��ĵ�";
$YM_ZT2 = "ָ����ʦ��ѧ���ϴ���ҵ����ĵ�";
$YM_MK = "��ҵ����ĵ�����ϵͳ";
$YM_PT = "�ĵ�ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
<?php
$now = time(0);
$mission_id = $_GET["mission_id"];
$number = $_GET["student_number"];
if(!$number){
	 ShowMissionList();
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}

$sql = "select student.name, topic,title.name as ttype,student.mobilephone,student.tmptime as stmptime,short_number,student.email,list.name as wdname,list.address,filename1,filename2,uploader,demonstration,start_time,end_time,print_time,needdoc,paper_type,paper_num,lockit,list.year from ".$TABLE."student_sheet as student,".$TABLE."topic as topic ,".$ART_TABLE."title_sort as title,".$TABLE."mission_list as list,".$TABLE."major as major where number = '$number' && mission_id='$mission_id'&&list.year=student.year&&title.id = topic.type && is_select=1 &&topic.student_number='$number'&& topic.teacher_id='$teacher_id'&&list.pro_id=major.id&&major.name=student.profession&&number=number";
//echo $sql;
$sj_que = mysql_query($sql);
$sj_fet = mysql_fetch_array($sj_que);
if(!$sj_fet||$sj_fet["name"]==""){
	Show_Message("�Բ��𣬲���ƥ����󣬲��ܽ����ĵ�����ģ�顣");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}

function dispEnter($content){
   $content = str_replace("\n","<br>&nbsp;&nbsp;&nbsp;&nbsp;",$content);
   return $content;
 }


if($_POST["submit"]!=""){
	$uploadret = false;
	if(is_uploaded_file($_FILES["uploadfile"]["tmp_name"])){
		$upfile = $_FILES["uploadfile"];
		$name = $upfile["name"];
		$tmp_name = $upfile["tmp_name"];
		$error = $upfile["error"];
		if(!file_exists("../../../Docs/".$sj_fet["year"]."/$sj_fet[address]")){
			mkdir("../../../Docs/".$sj_fet["year"]."/$sj_fet[address]",0700);
		}
		$tmp_type1=".".substr(strrchr($name,"."),1);
		$filename = $number.$tmp_type1;
		$destination = "../../../Docs/".$sj_fet["year"]."/".$sj_fet["address"]."/".$filename;
		if($error=='0')	$uploadret = move_uploaded_file($tmp_name,$destination);
	}
	if(!$uploadret) 	$filename = "";
	$suggestion = $_POST["suggestion"];
	$now = date("Y-m-d");
	$sql = "select log.id,log.upload_times,filename from ".$TABLE."mission_log as log,".$TABLE."mission_list as list where log.mission_id = list.mission_id && log.student_id = '$number' && log.mission_id = '$mission_id' && list.uploader = 1";
	$chk_que = mysql_query($sql);
	$chk_fet = @mysql_fetch_array($chk_que);
	if(!$chk_fet["id"]){  //�����ϴ�
		$sql = "insert into ".$TABLE."mission_log(mission_id,teacher_id,student_id,first_upload,is_check, teacher_suggestion,last_uploadtime,upload_times,lock_flag,teacher_firstwatch,teacher_lastwatch,filename) values ('$mission_id','$teacher_id','$number','$now','0','$suggestion','$now','1','0','$now','$now','$filename')"; 
		$sqlquery = mysql_query($sql);
		if($sqlquery) $msg = "�����ύ�ɹ���".($uploadret!=true?"<br><br>��ע�⡿����δ�ϴ��ļ����򱾴��ϴ�δ�ɹ���":"�����ļ��ѳɹ��ϴ���");
		else	$msg = "�����ύʧ�ܣ�";		
	}else{
		$oldfilename = $chk_fet["filename"];
		$times = $chk_fet["upload_times"];
		if($filename!="") $times ++;
		else $filename = $oldfilename;
		$sql = "update ".$TABLE."mission_log set filename='$filename', teacher_suggestion = '$suggestion',last_uploadtime = '$now',upload_times = '$times',teacher_lastwatch = '$now' where student_id = '$number' && mission_id = '$mission_id'";
		$update = mysql_query($sql);
		if($update) $msg = "���ݸ��³ɹ���".($uploadret!=true?"<br><br>��ע�⡿����δ�ϴ��ļ����򱾴��ϴ�δ�ɹ���":"�����ļ�Ҳ�Ѿ��ɹ�����");
		else	$msg = "���ݸ���ʧ�ܣ�";
		if($filename!=$oldfilename&&$oldfilename!=""){
			$path = "../../../Docs/".$sj_fet["year"]."/".$sj_fet["address"]."/".$oldfilename;
			$delfile = @unlink($path);
			$msg .= "<br><font color=blue><b>�����ĵ����³ɹ������ĵ��ѱ�ɾ����</b></font>";
		}
	}
	Show_Message($msg);
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}

//�����ĵ���Ա������
 $sql = "select student.class, student.name,student.number,student.mobilephone,student.short_number,log.filename,log.teacher_suggestion,log.student_suggestion  from ".$TABLE."topic as topic, ".$TABLE."student_sheet as student left join (select student_id,mission_id,filename,teacher_suggestion,student_suggestion from ".$TABLE."mission_log where mission_id='$mission_id') as log on log.student_id = student.number where student.number = topic.student_number && topic.teacher_id = '$teacher_id' && is_select = 1 && student.year=$CURR_YEAR&&student.profession='$pro_name' order by student.number";
$que = mysql_query($sql);
$currrows=@mysql_num_rows($que);  
if($currrows>1){
	echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;��".$mission_name."���������ӣ�";
	while($xs_fet = mysql_fetch_array($que)){ 
		if($number==$xs_fet[number]) echo "[<b>".$xs_fet[name]."</b>]&nbsp;";
		else echo "[<a href=student_m.php?mission_id=".$mission_id."&student_number=".$xs_fet["number"]."><font color=blue><u>".$xs_fet["name"]."</u></font>(".($xs_fet[filename]!=""?"<font color=green>��</font>":"<font color=red>��</font>").")</a>]&nbsp;";
	}
	echo "</p>";
}
//�����ĵ���Ա����������


//�����ĵ�������
$sql = "select * from ".$TABLE."mission_list where `year`='$CURR_YEAR'&&pro_id='$CURR_PID'&&lockit<2&&uploader=1 order by start_time";
$que = mysql_query($sql);
$currrows=@mysql_num_rows($que);  
if($currrows>1){
	echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;���ϴ���<b>".$sj_fet["name"]."</b>�Ŀ������ӣ�";
	while($tmp_fet = mysql_fetch_array($que)){ 
		if($mission_id==$tmp_fet[mission_id]) echo "[<b>".$tmp_fet[name]."</b>]&nbsp;";
		else echo "[<a href=student_m.php?mission_id=".$tmp_fet[mission_id]."&student_number=".$number."><font color=blue><u>".$tmp_fet["name"]."</u></font></a>]&nbsp;";
	}
	echo "</p>";
}
//�����ĵ�����������



$sql = "select teacher_suggestion,student_suggestion,lock_flag,filename from ".$TABLE."mission_log where student_id = '$number' && mission_id = '$mission_id'";
$wd_que = mysql_query($sql);
$wd_fet = mysql_fetch_array($wd_que);

echo "<script  type=\"text/javascript\" src=\"ajax_js_teacher.js\"></script>";
?>
<table width=800 align=center border=1 bordercolor=1 cellpadding=6>
   <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�������</font></td><td colspan=3><?php 
   	   echo $sj_fet["topic"];
   	   echo " (<b>".$sj_fet["ttype"]."</b>)";
   	   echo "&nbsp;&nbsp;&nbsp;";
   	   echo "ѧ��������<b>".$sj_fet["name"]."</b> (<span title=".$sj_fet["short_number"].">".$sj_fet["mobilephone"]."</span>��<a href=mailto://".$sj_fet["email"]."?subject=".$sj_fet["name"]."����".$sj_fet["topic"]."����ҵ��Ƶġ�".$sj_fet["wdname"]."��������><font color=blue><u>���ʼ�</u></font>)";
   	   ?></td>
    </tr>
    <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>��ǰ�ĵ�</font></td><td><b><?php if($sj_fet["needdoc"]) echo "��<font color=blue><b>��Ҫ</b></font>��"; echo $sj_fet["wdname"];?></b></td>
   	  <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�ο��ĵ�</font></td><td><?php 
   	  	if($sj_fet["ttype"]=="��ѧ�о�"){
   	  		$filename = $sj_fet["filename2"];
   	      		$ReferenceN = 2;
   	  	} else $filename = "";
   	  	if($filename=="") {
   	  		$filename = $sj_fet["filename1"];
   	      		$ReferenceN = 1;
   	  	}
   	  	if($filename==""){
   	  		echo "���ĵ�δ�ṩ�ο��ĵ�";
   	      		$ReferenceN = 0;
   	  	} else {
   	   		TeacherArchiveDown($CURR_YEAR,$CURR_PID,$teacher_id,"",$mission_id,$ReferenceN,"���زο��ĵ�");
   	  	}
   	   ?></td>
    </tr>
    <tr>
   	   
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�Ͻ�ʱ��</td><td><?php echo date("Y��m��d��",$sj_fet["end_time"]);?>ǰ�Ͻ����Ӹ�</td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>��ӡʱ��</td><td><?php
   	   	if($sj_fet["paper_num"]<1) echo "���ĵ��ݲ���Ҫ��ӡ�������֪ͨ��";
   	   	else {
   	   		echo "�� ".$sj_fet["paper_type"]." ֽ��ӡ ".$sj_fet["paper_num"]." �ݣ�".date("Y��m��d��",$sj_fet["print_time"])."ǰ��";
   		}
   	   ?></td>
    </tr>
    <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�ĵ�����</font></td><td><?php
   	   if($wd_fet[filename]!=""&& file_exists("../../../Docs/".$sj_fet["year"]."/$sj_fet[address]/$wd_fet[filename]")){
   	   	TeacherArchiveDown($CURR_YEAR,$CURR_PID,$teacher_id,$number,$mission_id,"mydoc","����".($sj_fet["uploader"]==1?"��":($sj_fet["name"]))."�ϴ��ġ�".$sj_fet["wdname"]."��");
   	   	$upok = true;
   	   } else {
   	   	if($sj_fet[uploader]==1) echo "<font color=red><b>����δ�ϴ����ĵ�</b></font>";
   	   	else echo "<font color='green'><b>�ĵ������ڣ�����ϵ <b>".$sj_fet["name"]."</b> �ϴ�</b></font>";
   	   	$upok = false;
   	   }
     	   ?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>����״̬</td><td><?php 
   	   	if($upok) echo $sj_fet[uploader]==1?"<font color=blue>�����ϴ������ٴ��ύ</font>":"<font color=green><b>ѧ�����Ͻ�</b></font>";
   	   	else{
   	   		 if($sj_fet[uploader]==1) echo "<font color=red><b>���ڹ涨ʱ�����Ͻ�</b></font>";
   	   		 else {
   	   		 	if($sj_fet["stmptime"]==999) echo "<span id=s".$number."><font color=red><b>����ʦ���ҿ����ĵ��ϴ����ܡ�</b></font><input type=button onClick=\"makemoretime('s".$number."','".$number."','student')\" value=ͬ��></span>";
   	   		 	else echo "<font color=green><b>����ϵѧ���Ͻ������ĵ�</b></font>";
   	   		 }
   	   	}
   	   	echo "&nbsp;&nbsp;";
   	   	echo $sj_fet[lockit]?"<font color=red>�ĵ��������������ϴ�</font>":"";
   	   ?></td>
    </tr>
    <tr>
   	   <td colspan=4><?php
   	   	echo "���ڡ�<b>".$sj_fet["wdname"]."</b>����Ҫ��˵����<p>&nbsp;&nbsp;&nbsp;&nbsp;".dispEnter($sj_fet["demonstration"]);
   	   	?></td>
    </tr>
<?php
if($wd_fet["student_suggestion"]!=""){
    echo "<tr><td colspan=4>".$sj_fet["name"]."���������ԣ�<br>&nbsp;&nbsp;&nbsp;&nbsp;".dispEnter($wd_fet["student_suggestion"])."</td></tr>";
}

$needok = true;
if($sj_fet[needdoc]){
	$sql = "select name,list.mission_id,uploader,log.filename from ".$TABLE."mission_list as list left join (select mission_id,filename from ".$TABLE."mission_log where student_id='$number') as log on log.mission_id =list.mission_id  where lockit<2&&pro_id='$CURR_PID'&&start_time<=".$sj_fet["start_time"]."&&needdoc>0&&year=$CURR_YEAR&&list.mission_id<>'$mission_id' order by start_time desc";
	//echo $sql;
	$que = mysql_query($sql);
	while($tmp = @mysql_fetch_array($que)){
		if(!$tmp[filename]){
			$needok = false;
			break;
		}
	}
	if(!$needok){
		echo "<tr><td colspan=4 align=center bgcolor=red><font color=yellow>��Ҫ���ѣ����ĵ������� ��".$tmp[name]."�����ύ������·����ύ�����������һ���ĵ��ύ����</font></td></tr>";
		echo "<tr><td colspan=4 height=38>".($tmp[uploader]?"��":$sj_fet["name"])."Ŀǰ��δ�ύ��".$tmp[name]."�����뼰ʱ".($tmp[uploader]?"":"֪ͨ<b>".$sj_fet["name"]."(<span title=".$sj_fet["short_number"].">".$sj_fet["mobilephone"]."</span>��<a href=mailto://".$sj_fet["email"]."?subject=".$sj_fet["name"]."����".$sj_fet["topic"]."����ҵ��Ƶġ�".$tmp["name"]."��������><font color=blue><u>���ʼ�</u></font></a>)</b>")."�ύ������Ӱ�챾�ĵ����ύ��".($tmp[uploader]?"[<a href=student_m.php?mission_id=".$tmp[mission_id]."&student_number=".$number."><font color=blue><u>����Ϊ".$sj_fet[name]."�ύ��".$tmp[name]."��</u></font></a>]":"")."</td></tr>";
	}
}

$tmplock = true;
if($now<$sj_fet["end_time"]) $tmplock = false;
if($upok) $tmplock = false;
$sql = "select tmptime from ".$TABLE."teacher_information where teacher_id='$teacher_id'";
$que = mysql_query($sql);
$tt = mysql_fetch_array($que);
$tmptime = $tt[tmptime]+0;
if($now<$tmptime)	 $tmplock = false;
?>    
</table>

<br>	
<table width="700">
<?php
if($needok && $sj_fet["uploader"]==1 && !$sj_fet["lockit"]&&!$tmplock ){  //��ʦ�ϴ�����
?>
<tr>
<td>
<form name="myform" method="post" action="" enctype="multipart/form-data">
<table width="650" align="center" border="0">
 <tr>
  <td colspan="2" align="center">���ϴ������ĵ���<font color=blue>�ĵ���С���ܳ���2M����Ҫʱѹ�����ϴ�</font>��</td>
 </tr>
 <tr>
  <td>�ϴ��ĵ���</td>
  <td><input type="file" name="uploadfile" />&nbsp;&nbsp;
  </td>
 </tr>
 <?php
 if($now<$tmptime&&$now>$sj_fet["end_time"]&&!$upok){
    echo "<tr><td>&nbsp;</td><td bgcolor=red align=center><font color=yellow>��ʱ�ϴ������ѿ��������� ".date("Y��m��d��",$tmptime)." ǰ�ύ�ĵ�</td></tr>";
}
 ?>
 <tr>
  <td>��ѧ�����ԣ�</td>
  <td><textarea name="suggestion" cols="60" rows="3"  wrap="virtual"><?php
   echo $wd_fet["teacher_suggestion"];
  ?></textarea></td>
 </tr>
 <tr align="center">
  <td colspan="2"><input type="submit" name="submit" value="��<?php echo $sj_fet[name];?>�ύ���µġ�<?php echo $sj_fet["wdname"]; ?>��"/></td>
 </tr>
</table>
</form>
</td>
</tr>
<?php  
} else if($needok&&$sj_fet[uploader]==1&& !$sj_fet["lockit"]) {
	echo "<tr><td colspan=4 align=center bgcolor=red height=28><font color=yellow>���ĵ�Ҫ���� ".date("Y��m��d��",$sj_fet["end_time"])." ֮ǰ�ϴ���Ŀǰ�ѹ���ֹ���ڣ��뼰ʱ����ѧ����ɱ�ҵ��ƹ�����лл��</font></td></tr>";
	echo "<tr><td height=88 align=center valign=middle>";
	echo "<span id=mmt>";
	echo "<font color=blue><b>������������ʱ�����ϴ�Ȩ�ޡ����� --></b></font> <input type=button onClick=\"makemoretime('mmt','".$teacher_id."','teacher')\" value=������ʱ�����ϴ�>";
	echo "</span>";
	echo "</td></tr>";
}
?>
<tr>
<td><br />˵����<br />
 <li>Ϊ��ȷ����ҵ���ָ��������ϵͳ���¼���ı�ҵ����ĵ�����������뼰ʱ��ѧ����ϵ������ĵ�</li>
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
