<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "��ҵ����ĵ�";
$YM_ZT2 = "��ҵ����ĵ�����";
$YM_MK = "��ҵ����ĵ�����ϵͳ";
$YM_PT = "�ĵ�ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 1; //��ҳ������ҪȨ�ޣ�ѧ��
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;
?>

<?php
$sql = "select student.name,teacher.name as tname,student.tmptime as stmptime,teacher.teacher_id,teacher.mobilephone as phone,techpos  as zhicheng, topic,".$TABLE."title_sort.name as ttype from ".$TABLE."student_sheet as student,".$TABLE."topic as topic ,".$TABLE."title_sort,".$TABLE."teacher_information as teacher where number = '$number' && ".$TABLE."title_sort.id = type && is_select=1 && number = student_number&&teacher.teacher_id=topic.teacher_id";
$sj_que = mysql_query($sql);
$sj_fet = mysql_fetch_array($sj_que);
if(!$sj_fet||$sj_fet["name"]==""){
	Show_Message("�Բ�������δȷ��ѡ�⣬���ܽ����ĵ�����ģ�顣");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}

function dispEnter($content){
   $content = str_replace("\n","<br>&nbsp;&nbsp;&nbsp;&nbsp;",$content);
   return $content;
 }
$mission_id = $_GET["mission_id"];
echo "<script  type=\"text/javascript\" src=\"ajax_js_student.js\"></script>";
$tmptime = $sj_fet["stmptime"];
if(!$mission_id){
	 ShowMissionList();
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}
$sql = "select * from ".$TABLE."mission_list where mission_id = $mission_id&&year='$com_bysj' order by start_time";
$yq_que = mysql_query($sql);
$yq_fet = mysql_fetch_array($yq_que);
if(!$yq_fet){
	Show_Message("�Բ���Ŀǰ��û�б�ҵ����ĵ��Ͻ�����");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}

if($_POST["submit"]!=""){
	$uploadret = false;
	if(is_uploaded_file($_FILES["uploadfile"]["tmp_name"])){
		$upfile = $_FILES["uploadfile"];
		$name = $upfile["name"];
		$tmp_name = $upfile["tmp_name"];
		$error = $upfile["error"];
		if(!file_exists("../../../Docs/".$com_bysj."/$yq_fet[address]")){
			mkdir("../../../Docs/".$com_bysj."/$yq_fet[address]",0700);
		}
		$tmp_type1=".".substr(strrchr($name,"."),1);
		$filename = $number.$tmp_type1;
		$destination = "../../../Docs/".$com_bysj."/".$yq_fet["address"]."/".$filename;
		if($error=='0')	$uploadret = move_uploaded_file($tmp_name,$destination);
	}
	if(!$uploadret) 	$filename = "";
	$suggestion = $_POST["suggestion"];
	$now = date("Y-m-d");
	$sql = "select log.id,log.upload_times,filename from ".$TABLE."mission_log as log,".$TABLE."mission_list as list where log.mission_id = list.mission_id && log.student_id = '$number' && log.mission_id = '$mission_id' && list.uploader = 0";
	$chk_que = mysql_query($sql);
	$chk_fet = @mysql_fetch_array($chk_que);
	if(!$chk_fet["id"]){  //�����ϴ�
		$sql = "insert into ".$TABLE."mission_log(mission_id,teacher_id,student_id,first_upload,is_check, student_suggestion,last_uploadtime,upload_times,lock_flag,student_firstwatch,student_lastwatch,filename) values ('$mission_id','$sj_fet[teacher_id]','$number','$now','0','$suggestion','$now','1','0','$now','$now','$filename')"; 
		$sqlquery = mysql_query($sql);
		if($sqlquery) $msg = "�����ύ�ɹ���".($uploadret!=true?"<br><br>��ע�⡿����δ�ϴ��ļ����򱾴��ϴ�δ�ɹ���":"�����ļ��ѳɹ��ϴ���");
		else	$msg = "�����ύʧ�ܣ�";		
	}else{
		$oldfilename = $chk_fet["filename"];
		$times = $chk_fet["upload_times"];
		if($filename!="") $times ++;
		else $filename = $oldfilename;
		$sql = "update ".$TABLE."mission_log set filename='$filename', student_suggestion = '$suggestion',last_uploadtime = '$now',upload_times = '$times',student_lastwatch = '$now' where student_id = '$number' && mission_id = '$mission_id'";
		$update = mysql_query($sql);
		if($update) $msg = "���ݸ��³ɹ���".($uploadret!=true?"<br><br>��ע�⡿����δ�ϴ��ļ����򱾴��ϴ�δ�ɹ���":"�����ļ�Ҳ�Ѿ��ɹ�����");
		else	$msg = "���ݸ���ʧ�ܣ�";
		if($filename!=$oldfilename&&$oldfilename!=""){
			$path = "../../../Docs/".$com_bysj."/".$yq_fet["address"]."/".$oldfilename;
			$delfile = @unlink($path);
			$msg .= "<br><font color=blue><b>�����ĵ����³ɹ������ĵ��ѱ�ɾ����</b></font>";
		}
	}
	Show_Message($msg);
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}

$sql = "select log.teacher_suggestion,log.student_suggestion,log.lock_flag,log.filename, list.address,needdoc from ".$TABLE."mission_log as log,".$TABLE."mission_list as list where log.mission_id = list.mission_id && log.student_id = '$number' && log.mission_id = '$mission_id'";
$wd_que = mysql_query($sql);
$wd_fet = mysql_fetch_array($wd_que);
?>
<table width=800 align=center border=1 bordercolor=1 cellpadding=6>
   <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�������</font></td><td colspan=3><?php 
   	   echo $sj_fet["topic"];
   	   echo " (<b>".$sj_fet["ttype"]."</b>)";
   	   echo "&nbsp;&nbsp;&nbsp;";
   	   echo "ָ����ʦ��".$sj_fet["tname"]." (".$sj_fet["zhicheng"]."��".$sj_fet["phone"].")";
   	   ?></td>
    </tr>
    <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>��ǰ�ĵ�</font></td><td><b><?php echo $yq_fet["name"];?></b></td>
   	  <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�ο��ĵ�</font></td><td><?php 
   	  	$ReferenceN = 0;
   	  	if($sj_fet["ttype"]=="��ѧ�о�") {
   	      		$filename = $yq_fet["filename2"];
   	      		$ReferenceN = 2;
   	      	} else $filename = "";
   	      	if($filename=="") {
   	      		$filename = $yq_fet["filename1"];
   	      		$ReferenceN = 1;
   	      	}
   	      	if($filename=="") {
   	      		echo "���ĵ�δ�ṩ�ο��ĵ�";
   	      		$ReferenceN = 0;
   	      	} else {
   	      		//echo "<a href=\"/Docs/".$com_bysj."/".$filename."\"><font color=blue><u>���زο��ĵ�</u></font></a>";
   	   		$crc = md5("stu".$mission_id.$number.date("Ymd")."crc");
   	   		echo "<a href =StudentArchiveDown.php?mission_id=".$mission_id."&obj=$ReferenceN&crc=$crc title='���زο��ĵ�'><font color = blue><u>���زο��ĵ�</u></font></a>";
   	      		
   	      	}
   	   ?></td>
    </tr>
    <tr>
   	   
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�Ͻ�ʱ��</td><td><?php echo date("Y��m��d��",$yq_fet["end_time"]);?>ǰ�Ͻ����Ӹ�</td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>��ӡʱ��</td><td><?php
   	   	if($yq_fet["paper_num"]<1) echo "���ĵ��ݲ���Ҫ��ӡ�������֪ͨ��";
   	   	else {
   	   		echo $yq_fet["paper_type"]." ֽ��ӡ ".$yq_fet["paper_num"]." �ݣ�".date("Y��m��d��",$yq_fet["print_time"])."ǰ��ָ����ʦ";
   		}
   	   ?></td>
    </tr>
    <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�ĵ�����</font></td><td><?php
   	   if($wd_fet[filename]!=""&& file_exists("../../../Docs/".$com_bysj."/$yq_fet[address]/$wd_fet[filename]")){
   	   	//echo "<a href =\"/Docs/".$com_bysj."/$yq_fet[address]/$wd_fet[filename]\" title='���ظ��ĵ�'><font color = blue><u>����".($yq_fet["uploader"]!=1?"��":($sj_fet["tname"]."��ʦ"))."�ϴ��ġ�".$yq_fet["name"]."��</u></font></a>";
   	   	$crc = md5("stu".$mission_id.$number.date("Ymd")."crc");
   	   	echo "<a href =StudentArchiveDown.php?mission_id=".$mission_id."&obj=mydoc&crc=$crc title='���ظ��ĵ�'><font color = blue><u>����".($yq_fet["uploader"]!=1?"��":($sj_fet["tname"]."��ʦ"))."�ϴ��ġ�".$yq_fet["name"]."��</u></font></a>";
   	   	$upok = true;
   	   } else {
   	   	if($yq_fet[uploader]!=1) echo "<font color=red><b>����δ�ϴ����ĵ�</b></font>";
   	   	else echo "<font color='green'><b>�ĵ������ڣ�����ϵ <b>".$sj_fet["tname"]."</b> ��ʦ�ϴ�</b></font>";
   	   	$upok = false;
   	   }
     	   ?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>����״̬</td><td><?php 
   	   	if($upok) echo $yq_fet[uploader]!=1?"<font color=blue>�����ϴ������ٴ��ύ</font>":"<font color=green><b>�����ѷ���</b></font>";
   	   	else echo $yq_fet[uploader]!=1?"<font color=red><b>���ڹ涨ʱ�����Ͻ�</b></font>":"<font color=green><b>����ϵ��ʦ��������</b></font>";
   	   	echo "&nbsp;&nbsp;";
   	   	echo $yq_fet[lockit]?"<font color=red>�ĵ��������������ϴ�</font>":"";
   	   ?></td>
    </tr>
    <tr>
   	   <td colspan=4><?php
   	   	echo "���ڡ�<b>".$yq_fet["name"]."</b>����Ҫ��˵����<p>&nbsp;&nbsp;&nbsp;&nbsp;".dispEnter($yq_fet["demonstration"]);
   	   	?></td>
    </tr>
<?php
if($wd_fet["teacher_suggestion"]!=""){
    echo "<tr><td colspan=4>".$sj_fet["tname"]."��ʦ��������ԣ�<br>&nbsp;&nbsp;&nbsp;&nbsp;".dispEnter($wd_fet["teacher_suggestion"])."</td></tr>";
}

$needok = true;
if($yq_fet[needdoc]){
	$sql = "select name,list.mission_id,uploader,log.filename from ".$TABLE."mission_list as list left join (select mission_id,filename from ".$TABLE."mission_log where student_id='$number') as log on log.mission_id =list.mission_id  where lockit<2&&pro_id='$com_pro_id'&&start_time<=".$yq_fet["start_time"]."&&needdoc>0&&year=".$CURR_YEAR."&&list.mission_id<>'$mission_id' order by start_time desc";
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
		echo "<tr><td colspan=4 height=38>".($tmp[uploader]==0?"��":$sj_fet["tname"]."��ʦ")."Ŀǰ��δ�ύ��".$tmp[name]."�����뼰ʱ".($tmp[uploader]==0?"":"֪ͨ<b>".$sj_fet["tname"]."��ʦ��".$sj_fet["phone"]."��</b>")."�ύ������Ӱ�챾�ĵ����ύ��".($tmp[uploader]==0?"[<a href=student_m.php?mission_id=".$tmp[mission_id]."&student_number=".$number."><font color=blue><u>�����ύ��".$tmp[name]."��</u></font></a>]":"")."</td></tr>";
	}
}
$now = time(0);
$tmplock = true;
if($now<$yq_fet["end_time"]) $tmplock = false;
if($upok) $tmplock = false;
if($now<$tmptime)	 $tmplock = false;
?>    

</table>

<br>	
<table width="700">
<?php
if($needok &&$yq_fet["uploader"]!=1 && !$yq_fet["lockit"]&&!$tmplock  ){  //ѧ���ϴ�����
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
 if($now<$tmptime&&$now>$yq_fet["end_time"]&&!$upok){
    echo "<tr><td>&nbsp;</td><td bgcolor=red align=center><font color=yellow>��ʱ�ϴ������ѿ��������� ".date("Y��m��d��",$tmptime)." ǰ�ύ�ĵ�</td></tr>";
}
 ?>
 <tr>
  <td>ѧ�����ԣ�</td>
  <td><textarea name="suggestion" cols="60" rows="3"  wrap="virtual"><?php
   echo $wd_fet["student_suggestion"];
  ?></textarea></td>
 </tr>
 <tr align="center">
  <td colspan="2"><input type="submit" name="submit" value="�ύ�����µġ�<?php echo $yq_fet["name"]; ?>��"/></td>
 </tr>
</table>
</form>
</td>
</tr>
<?php  
} else if($needok&&$yq_fet[uploader]==0&& !$yq_fet["lockit"]) {
	echo "<tr><td colspan=4 align=center bgcolor=red height=28><font color=yellow>���ĵ�Ҫ���� ".date("Y��m��d��",$yq_fet["end_time"])." ֮ǰ�ϴ���Ŀǰ�ѹ���ֹ���ڣ���ץ��ʱ����ɱ�ҵ��ƹ�����лл��</font></td></tr>";
	echo "<tr><td height=88 align=center valign=middle>";
	if($tmptime==999){
		echo "<font color=green><b>������ָ����ʦ������ʱ�ϴ�Ȩ�ޣ���Ⱥ�ָ����ʦͬ�⣡<br>�����µ�ָ����ʦ��������������������루<font color=blue>�ڽ�ʦ�ġ��ĵ�ϵͳ����������ֺ������</font>����</b></font>";
	} else {
		echo "<span id=s".$number.">";
		echo "<font color=blue><b>������ָ����ʦ���뿪���ϴ�Ȩ��--></b></font> <input type=button onClick=\"needmoretime('s".$number."','".$number."')\" value=������ʱ�����ϴ�> ";
		echo " <font color=blue><b>�ٽ������ĵ���Ӱ�����Ŀ��˳ɼ���</b></font>";
		echo "</span>";
	}
	echo "</td></tr>";
}
?>
<tr>
<td><br />˵����<br />
 <li>�뼰ʱ��ָ����ʦ��ϵ��ȷ�����������ܹ�������ʦ��Ҫ�����</li>
</td>
</tr>
</table>

<?php
function ShowMissionList()
{
	global $com_bysj, $TABLE, $com_pro_id, $number, $tmptime;
	echo "��ҵ����ĵ�Ҫ��һ����<br><br>";	
	?>
<table width="700" border=1 bordercolor=#000000 align="center" cellpadding="6">
	<tr align="center" bgColor=#5a6e8f  height=38>
		<td><font color=#FFFFFF>���</font></td>
		<td><font color=#FFFFFF>��ҵ�����Ҫ�Ͻ��ĵ����ĵ�</font></td>
		<td><font color=#FFFFFF>�ĵ�����</font></td>
		<td><font color=#FFFFFF>��ֹ����</font></td>
		<td><font color=#FFFFFF>�ϴ���</font></td>
		<td><font color=#FFFFFF>�ĵ�״̬</font></td>
	</tr> 		
<?php			
  $count = 1;
  $sql = "select name,list.mission_id,needdoc,end_time,uploader,lockit,log.filename from ".$TABLE."mission_list as list left join (select mission_id,filename from ".$TABLE."mission_log where student_id='$number') as log on log.mission_id =list.mission_id  where year='$com_bysj'&&`pro_id`=$com_pro_id&&lockit<2 order by start_time";
  //echo $sql;
  $miss = mysql_query($sql);
  if($miss) $currrows=mysql_num_rows($miss);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=168 colspan=6 align=center>�����ĵ��ϴ�����</td></tr>";
  }    
$uperstr = array(1=>"ָ����ʦ",0=>"ѧ��");
$lockstr = array(0=>"����",1=>"����",2=>"ȡ��");  
$now = time(0);
while($arr = @mysql_fetch_array($miss)){
	echo "<tr align=center>";
	echo "<td>$count</td>";
	echo "<td align=left><a href =".$PHP_SELF."?mission_id=".$arr["mission_id"]."><font color=blue><u>".$arr["name"]."</u></font></a></td>";
	echo "<td>".($arr["needdoc"]?"<font color=blue>��Ҫ</font>":"��ͨ")."</td>";
	echo "<td>".date("Y-m-d",$arr["end_time"])."</td>";
	echo "<td>".$uperstr[$arr["uploader"]]."</td>";
	echo "<td>";
	if($arr[filename]==""){
		if($arr["uploader"]) echo "<font color=green>����δ�·�</font>";
		else {
			if($now<$arr["end_time"])	echo "<font color=red>��δ�Ͻ�</font>";
			else if($tmptime==999&&$now>$arr["end_time"]) echo "<font color=green><b>�ѳ��ڣ������ϴ�Ȩ����</b></font><br>";
			else if($now<$tmptime&&$now>$arr["end_time"]) echo "<font color=red><b>�����Ͻ�</b></font>";
			else echo "<span id=s".$arr["mission_id"]."><font color=red><b>�ѳ��ڣ�</b></font><input type=button onClick=\"needmoretime('s".$arr["mission_id"]."','".$number."')\" value=�����Ͻ��ĵ�></span><br>";
		}
	} else {
		if($arr["uploader"]) echo "�����ѷ�";
		else echo "�����Ͻ�";
	}
	if($arr["lockit"]) echo "&nbsp;[<b>������</b>]";
	else if($arr["uploader"]==0) {
		if($now<$arr["end_time"]||$now<$tmptime&&$tmptime>999) echo "&nbsp;[<a href =".$PHP_SELF."?mission_id=".$arr["mission_id"]."><font color=blue><u>�����ϴ�</u></font></a>]";
	}
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
