<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�����ĵ�����";
$YM_ZT2 = "��ҵ����ĵ��������";
$YM_MK = "��ҵ����ĵ�����ϵͳ";
$YM_PT = "�ĵ�ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 40; //��ҳ������ҪȨ�ޣ�רҵ����
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
<script language="JavaScript" src="/bysj/images/My97DatePicker/WdatePicker.js" defer="defer"></script>  

<?php
$now = time(0);
$lockstr = array("����","����","ͣ��");
$needstr = array("��ͨ","����");
if($act=="initlist"){
	if(!file_exists("../../../Docs/")){
		$kk = mkdir("../../../Docs/",0700);
		$kk = mkdir("../../../Docs/".$CURR_YEAR,0700);
	}else if(!file_exists("../../../Docs/".$CURR_YEAR)){
		$kk = mkdir("../../../Docs/".$CURR_YEAR,0700);
	}	
	$sql = "select * from ".$TABLE."mission_list  where pro_id=$CURR_PID&&year = '$CURR_YEAR'";
	$que = mysql_query($sql);
	$n = mysql_affected_rows();
	if($n<1){
		include("inc_init_mission_list.php");
		//echo $sql;
		mysql_query($sql);
	}
}
if($act=="delete"||$act=="focusdelete"){
	$candelete = true;
	$sql = "select list.name,list.address,list.filename1,list.filename2,log.filename from ".$TABLE."mission_log as log,".$TABLE."mission_list as list where list.mission_id=log.mission_id&&list.pro_id=$CURR_PID&&list.mission_id = '$mission_id'";
	$que = mysql_query($sql);
	$n = mysql_affected_rows();
	if($n>0){
		if($act=="focusdelete"){
			$where = "list.year='$CURR_YEAR'&&list.mission_id=log.mission_id&&student.number=log.student_id&&log.teacher_id=teacher.teacher_id&&list.pro_id='$CURR_PID'&&list.mission_id='$mission_id'";
			$sql = "select log.filename,address,list.name,student.profession,class,student.name as studentname,teacher.name as teachername from ".$TABLE."mission_list as list,".$TABLE."mission_log  as log,".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher where ".$where." order by teacher.teacher_id";
			$que = mysql_query($sql);
			$count = 0;
			$deletemsg = "<table border=1 bordercolor=#000000 cellpadding=6><tr align=center><td>ָ����ʦ</td><td>ѧ��</td><td>ɾ������</td><td>ɾ�����</td></tr>";
			while($tmp = mysql_fetch_array($que)){
				$teachername = $tmp[teachername];
				$studentname = $tmp[studentname];
				$missionname = $tmp[name];
				$filename =  "../../../Docs/".$CURR_YEAR."/".$tmp[address]."/".$tmp[filename];
				$count ++;
				if(!file_exists($filename)||!is_file($filename)){
					$deletemsg .= "<tr><td>".$teachername."</td><td>".$studentname."</td><td>".$missionname."</td><td><font color=green>������</font></td></tr>";
					continue;
				}
				$resi = unlink($filename);
				$deletemsg .= "<tr><td>".$teachername."</td><td>".$studentname."</td><td>".$missionname."</td><td>".($resi?"ɾ���ɹ�":"<font color=red>ɾ��ʧ��</font>")."</td></tr>";
			}
			$sql = "delete from ".$TABLE."mission_log where mission_id='$mission_id'";
			$que = mysql_query($sql);
			$n = mysql_affected_rows();
			if($n==-1){
				$candelete = false;
				$deletemsg .= "<tr><td colspan=4 align=center>�ĵ��������ϣ���¼δɾ���ɹ�</td></tr>";
			} else {
				$deletemsg .= "<tr><td colspan=4 align=center>��ɾ�� $n ����¼����Ӧ�ĵ�</td></tr>";
			}
			$deletemsg .= "</table>";
		} else {
			$tmp = mysql_fetch_array($que);
			$deletemsg = "<font color=red><b>����</b></font>��".$tmp[name]."������ $n ���ύ��¼<br>��ȷ��Ҫɾ����ֻ��<a href=".$PHP_SELF."?act=focusdelete&mission_id=$mission_id onclick=\"return confirm('��ע�⣬ɾ�������ɳ����ͻָ���������ɾ�����롰ȡ����������������ҳ����ť��\\r\\n\\r\\n��ȷ��Ҫǿ��ɾ����".$tmp["name"]."����')\"><font color=blue><u>ǿ��ɾ����<font color=red><b>����</b></font>��</u></font></a><br>ǿ��ɾ����ɾ���������������ϴ����ĵ���";
			$candelete = false;
		}
	} else $deletemsg = "";
	if($candelete){
		$sql = "select name,address,filename1,filename2 from ".$TABLE."mission_list where pro_id=$CURR_PID&&mission_id = '$mission_id'";
		$que = mysql_query($sql);
		if(mysql_affected_rows()>0){
			$tmp = @mysql_fetch_array($que);
			if($tmp[filename1]!=""){
				$filename =  "../../../Docs/".$CURR_YEAR."/".$tmp[filename1];
				if(file_exists($filename)&&is_file($filename)) unlink($filename);
			}
			if($tmp[filename2]!=""){
				$filename =  "../../../Docs/".$CURR_YEAR."/".$tmp[filename2];
				if(file_exists($filename)&&is_file($filename)) unlink($filename);
			}
			$sql = "delete from ".$TABLE."mission_list where mission_id = '$mission_id'&&pro_id=$CURR_PID";
			$que = mysql_query($sql);
			if(mysql_affected_rows()>0) $deletemsg .= "�ɹ�ɾ����ҵ����ĵ�����";
			else $deletemsg .= "ɾ����ҵ����ĵ�����ʧ�ܣ�����ɾ����";
			$passit = false;
		} else {
			$passit = true;
		}
	}
	if(!$passit){
		Show_Message($deletemsg);
		@include($baseDIR."/bysj/inc_foot.php");
		exit;
	}
}

if($_POST["submit"]!=""){
         $set_pro_id = trim($_POST["set_pro_id"]);
         if(!in_array($set_pro_id,$pro_list)){
         	Show_Message("�Բ��𣬷���Ȩ�������������ܾ���");  		
          	@include($baseDIR."/bysj/inc_foot.php");
                 exit;
	}
	$uploader = $_POST["uploader"];
	$mission_id = $_POST["mission_id"];
	$mission_name = $_POST["name"];
	$address = $_POST["address"];
	$lockit = $_POST["lockit"];
	$demonstration = $_POST["demonstration"];
	$start_time = $_POST["start_time"];
	$end_time = $_POST["end_time"];
	$print_time = $_POST["print_time"];
	$paper_type = $_POST["paper_type"];
	$paper_num = $_POST["paper_num"];
	$year = $_POST["year"];
	$needdoc = $_POST["needdoc"];
	
	$filename1 = $_POST["filename1"];
	$filename2 = $_POST["filename2"];
	
	$start_time = strtotime(trim($_POST["start_time"]))+$mission_id;
	$end_time = strtotime(trim($_POST["end_time"]))+86399;
	$print_time = strtotime(trim($_POST["print_time"]))+86399;
	
	if(!file_exists("../../../Docs/".$year)){
		$kk = mkdir("../../../Docs/".$year,0700);
	}

	if($act=="modify"){
		$sql = "select filename1,filename2 from ".$TABLE."mission_list  where  mission_id = '$mission_id'";
		$que_sql = @mysql_query($sql);
		$fet_result = @mysql_fetch_array($que_sql);
		$oldfilename1 = $fet_result["filename1"];
		$oldfilename2 = $fet_result["filename2"];
	} else {
		$oldfilename1 = "";
		$oldfilename2 = "";
	}
	
	$uploadret = true;
	if(is_uploaded_file($_FILES["specifications"]["tmp_name"])){
		if($filename1=="") {
			$upfile = $_FILES["specifications"];
			$name_1 = $upfile["name"];
			$tmp_name1 = $upfile["tmp_name"];
			$tmp_type1=".".substr(strrchr($name_1,"."),1);
			$filename1 = $address."_specifications".$tmp_type1;
			
			$destination1 = "../../../Docs/".$year."/".$filename1;
			$uploadret = move_uploaded_file($tmp_name1,$destination1);

			if($filename1!=$oldfilename1 && $oldfilename1!=""){
				$path = "../../../Docs/".$year."/".$oldfilename1;
				$delfile = @unlink($path);
			}
		} 
	}  else {
		if($filename1==""&&$filename1!=$oldfilename1 ){
			$path = "../../../Docs/".$year."/".$oldfilename1;
			$delfile = @unlink($path);
		}
	}
	if(is_uploaded_file($_FILES["reference"]["tmp_name"])){
		if($filename2=="") {
			$upload = $_FILES["reference"];
			$name_2 = $upload["name"];
			$tmp_name2 = $upload["tmp_name"];
			$tmp_type2=".".substr(strrchr($name_2,"."),1);
			$filename2 = $address."_reference".$tmp_type2;
		
			$destination2 = "../../../Docs/".$year."/".$filename2;
			$uploadret2 = move_uploaded_file($tmp_name2,$destination2);
			$uploadret = $uploadret && $uploadret2;

			if($filename2!=$oldfilename2 && $oldfilename2!=""){
				$path = "../../../Docs/".$year."/".$oldfilename2;
				$delfile = @unlink($path);
			} 
		} 
	}  else {
		if($filename2==""&&$filename2!=$oldfilename2 ){
			$path = "../../../Docs/".$year."/".$oldfilename2;
			$delfile = @unlink($path);
		}
	}
	if($act=="modify"){
		$sql = "update ".$TABLE."mission_list set name='$mission_name',uploader='$uploader',demonstration='$demonstration',start_time='$start_time',end_time='$end_time',lockit='$lockit',print_time='$print_time',paper_type='$paper_type',paper_num='$paper_num',filename1='$filename1',filename2='$filename2',year='$year',needdoc='$needdoc' where mission_id='$mission_id'";
	} else {
		$sql = "insert into ".$TABLE."mission_list(pro_id,name,address,uploader,demonstration,start_time,end_time,lockit,print_time,paper_type,paper_num,filename1,filename2,year,needdoc) values ('$set_pro_id','$mission_name','$address','$uploader','$demonstration',$start_time,$end_time,$lockit,$print_time,'$paper_type',$paper_num,'$filename1','$filename2','$year','$needdoc')";
	}
	if(mysql_query($sql)){
		if(!$uploadret) $msg = "���Ӳο��ĵ��ϴ�ʧ��";
		$postmsg = $msg."�ĵ�����".($act=="modify"?"����":"����")."�ɹ���";
		if($act=="add"){
			$mission_id = mysql_insert_id();
			$act = "modify";
		}
	}else{
		$postmsg = $msg."�ĵ�����".($act=="modify"?"����":"����")."ʧ�ܣ�";
	}
	//echo $sql;
}

 
if($act != "add" && $act != "modify"){
	 ShowDocumentList();
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}

?>
<script language="javascript">
function chfile1(){
	if(myform.specifications.disabled ==true){
		myform.specifications.disabled = false;
	} else {
		myform.specifications.disabled = true; 
	}
}
function chfile2(){
	if(myform.reference.disabled ==true){
		myform.reference.disabled = false;
	} else {
		myform.reference.disabled = true; 
	}
}

function is_value(){
  if(myform.name.value==""){
   alert("�����ĵ����Ʋ���Ϊ�գ�");
   myform.name.focus();
   return false;  
  }
  return true;
}
</script>

<?php
if($act=="modify"){
	$sql = "select * from ".$TABLE."mission_list  where  mission_id = '$mission_id'";
	$que_sql = @mysql_query($sql);
	$fet_result = @mysql_fetch_array($que_sql);
	if(!in_array($fet_result["pro_id"],$pro_list)){
		Show_Message("�Բ����������޸�����רҵ�ı�ҵ�������");
		@include($baseDIR."/bysj/inc_foot.php");
		exit;
	}
	$name = $fet_result["name"];
	$uploader = $fet_result["uploader"];
	$demonstration = $fet_result["demonstration"];
	$start_time = $fet_result["start_time"];
	$end_time = $fet_result["end_time"];
	$lockit = $fet_result["lockit"];
	$print_time = $fet_result["print_time"];
	$paper_type = $fet_result["paper_type"];
	$paper_num = $fet_result["paper_num"];
	$filename1 = $fet_result["filename1"];
	$filename2 = $fet_result["filename2"];
	$address = $fet_result["address"];
	$year = $fet_result["year"];
	$spid = $fet_result["pro_id"];
	$needdoc = $fet_result["needdoc"];
} else {
	$name = "";
	$uploader = 1;
	$start_time = $now;
	$end_time = $now + 21*86400;
	$lockit = 0;
	$month = date("m");
	if($month>8) $print_time = strtotime((date(Y)+1)."-06-15 00:00:00");
	else if($month<2) $print_time = strtotime(date(Y)."-06-15 00:00:00");
	else $print_time = strtotime(date(Y)."-06-15 00:00:00");
	$paper_type  = "A4";
	$paper_num = 1;
	$year = $CURR_YEAR;
	$spid = $CURR_PID;
	$needdoc = 0;
	$address = $CURR_PID."_".$CURR_YEAR."_".date("mdHis",$now);
}	

if($postmsg!="")echo "<font color=blue>".$postmsg."</font><br>";
if($act=="add") echo "<b>���һ�����ĵ�</b>";
else echo "<b>�޸ı�ҵ����ĵ�</b>";
?>
<form name="myform" method="post" action="" enctype="multipart/form-data">
<table width="780" align="center" border="1" bordercolor=#000000  cellpadding="6">
<tr>
  <td>����ѧ����</td><td colspan="3">
  <?php
	echo "<input name=year type=hidden value=$year>";
	echo "<input name=set_pro_id type=hidden value=$spid>";
	echo " <font size=+1><b>".$year."�� ".$pro_name."רҵ</b></font>";
  ?></td>
</tr>	
<tr>
  <td>�ĵ����ƣ�</td>
  <td colspan=3><input name="name" type="text" size="16"  value="<?php echo $name; ?>"/>���ĵ����Ʋ����������һ�����8�����֣�</td>
 </tr>
  <tr>
  <td>�ĵ��ϴ��ߣ�</td>
  <td colspan="3">
    	<?php 
  	if($uploader) {
  		$s1 = " checked";
  		$s2 = "";
  	} else {
  		$s1 = "";
  		$s2 = " checked";
  	}
  	?>
  	<input type="radio" name="uploader" value="1" <?php echo $s1; ?>/>�ɽ�ʦ�ϴ�&nbsp;&nbsp;
  	<input type="radio" name="uploader" value="0" <?php echo $s2; ?>/>��ѧ���ϴ�&nbsp;&nbsp;
  </td>
 </tr>
<tr>
  <td rowspan=2>������Ĳο��ĵ���</td>
  <td colspan="3">����ࣺ<input type="file" name="specifications"<?php if($filename1!="")echo " disabled";?>/>
  <?php
  if($filename1!="") echo "<input type=checkbox name=filename1 value='$filename1' checked onclick=chfile1()> �����ϴ��ύ���ĵ�����";
  ?></td>
 </tr>
 <tr>
    <td colspan="3">�о��ࣺ<input type="file" name="reference"<?php if($filename2!="")echo " disabled";?> />
  <?php
  if($filename2!="") echo "<input type=checkbox name=filename2 value='$filename2' checked onclick=chfile2()> �����ϴ��ύ���ĵ�����";
  ?></td>
 </tr>
 <tr>
  <td>�ϴ����ԣ�</td>
  <td colspan="3">
  	<?php 
  	for($i=0;$i<3;$i++){
  		if($lockit==$i) $s = " checked";
  		else $s = "";
  		echo "<input type=radio name=lockit $s value=$i>".$lockstr[$i]."&nbsp;&nbsp;";
  	}
  	?>
  </td>
 </tr>
 <tr>
  <td>�ĵ����ԣ�</td>
  <td colspan="3">
  	<?php 
  	for($i=0;$i<2;$i++){
  		if($needdoc==$i) $s = " checked";
  		else $s = "";
  		echo "<input type=radio name=needdoc $s value=$i>".$needstr[$i]."&nbsp;&nbsp;";
  	}
  	?>�������衱�ĵ���������һ�������衱�ĵ����ϴ�������·����ϴ���
  </td>
 </tr>
  <tr>
  <td>�ĵ����ݣ�<br>ʱ�䡢�ص�����<br>��˵����</td>
  <td colspan="3"><textarea name="demonstration" cols="60" rows="8"  wrap="virtual"><?php echo $demonstration; ?></textarea></td>
 </tr>
 <tr>
  <td>����ʼʱ�䣺</td>
  <td><input name="start_time" type="text" size="12" maxlength=12  value="<?php echo date("Y-m-d",$start_time);?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"></td>
  <td>�����ֹʱ�䣺</td>
  <td><input name="end_time" type="text" size="12" maxlength=12  value="<?php echo date("Y-m-d",$end_time);?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"></td>
 </tr>
 <tr>
 	<td>��ӡҪ��</td>
  <td colspan="3">
  	��ӡʱ�䣺<input name="print_time" type="text" size="12"   maxlength=12 value="<?php echo date("Y-m-d",$print_time); ?>"onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate" />&nbsp;&nbsp;
  	ֽ�ͣ�<select name="paper_type">
  		<option value="A4"<?php if($paper_type=="A4")echo " selected";?>>A4</option>
  		<option value="16K"<?php if($paper_type=="16K")echo " selected";?>>16K</option>
  		</select>&nbsp;&nbsp;
  	������<input type="text" name="paper_num" size="4" maxlength=4   value="<?php echo $paper_num; ?>"></td>
 </tr>
 </table>
<br>
<input type=hidden name=act value=<?php echo $act;?>>
<input type=hidden name=address value=<?php echo $address;?>>
<input type=hidden name=mission_id value=<?php echo $mission_id;?>>
<input type="submit" name="submit" value=<?php echo ($act=="modify")?"�޸ĵ�ǰ�ĵ��ĸ������":"�ύ�µ��ĵ�";?> onclick="return is_value()"/>
</form>
<table width="600" align="center">
 <tr>
  <td>
   ˵����
	<li>�ĵ��ϴ��ߵ�ѡ��ť���У�ѡ�񡾽�ʦ����ʾ������Ҫ���ʦ�ϴ��ĵ���ѡ��ѧ������ʾ������Ҫ��ѧ���ϴ��ĵ���</li>
  </td>
 </tr>
</table>

<?php
function ShowDocumentList()
{
	global $TABLE, $CURR_YEAR,$CURR_PID,$lockstr;
	global $com_from, $teacher_id, $pro_name;
	global $objtime;
	
	if($objtime!="print_time") $objtime = "end_time";
	
	echo "<br><script  type=\"text/javascript\" src=\"ajax_js_teacher.js\"></script>";
	echo "<a href=".$PHP_SELF."?act=add><font color=blue><u>���һ���µı�ҵ�������</u></font></a><br><br>";
?>
<script>
	function ChangeInputDate(obj,cnt,id,value,rel){
      		var s = value+' 08:00:00';
      		var t = s.split(/(?: |-|:)/);
    		t[1]--;
    		eval('var d = new Date('+t.join(',')+');');
    		value =  (d.getTime()/1000)+rel;
		change_item_date(obj+cnt,id,obj,value);
	}
	function chcolor(cnt){
		var   oTable   =   document.all.missiontable; 
		var s = document.getElementById("lockit"+cnt).innerHTML;
		if(/ͣ��/g.test(s)) oTable.rows[cnt].bgColor   =   "#FFFFFF"; 
		if(/����/g.test(s)) oTable.rows[cnt].bgColor   =   "#999999"; 
		if(/����/g.test(s)) oTable.rows[cnt].bgColor   =   "#DDDDDD"; 
	}
</script>
<table width="800" border=1 bordercolor=#000000 align="center" cellpadding="6" id=missiontable>
	<tr align="center" bgColor=#5a6e8f  height=38>
		<td width=30><font color=#FFFFFF>���</font></td>
		<td><font color=#FFFFFF>״̬</font></td>
		<td><font color=#FFFFFF>��ҵ����ĵ���</font></td>
		<td><font color=#FFFFFF>�ϴ���</font></td>
		<td><font color=#FFFFFF>�ĵ�<br>����</font></td>
		<td><font color=#FFFFFF>����</font></td>
		<td><font color=#FFFFFF>����ʼʱ��</font></td>
		<td><font color=#FFFFFF><?php
			if($objtime=="end_time"){
				echo "�ϴ���ֹ����<br>(<a href=".$PHP_SELF."?objtime=print_time><font color=blue size=-1><u>���ô�ӡ����</u></font></a>)";
			} else {
				echo "��ӡ�Ͻ�����<br>(<a href=".$PHP_SELF."?objtime=end_time><font color=blue size=-1><u>���ý�ֹ����</u></font></a>)";
			}
			?></font></td>
		<td><font color=#FFFFFF>����</font></td>
	</tr> 		
<?php			

  $count = 1;
  $sql = "select * from ".$TABLE."mission_list where  year='$CURR_YEAR'&&pro_id=$CURR_PID order by start_time";
  $miss = @mysql_query($sql);
  if($miss) $currrows=mysql_num_rows($miss);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=98 colspan=9 align=center>רҵ������δ�ύ<b> ".$pro_name."רҵ</b> �ı�ҵ����ĵ�����<br><br>������<a href=".$PHP_SLEF."?act=initlist><font color=blue><u>����˴�������ȱʡ���ĵ��б���������޸ģ�</u></font></a></td></tr>";
  }    
while($miss && $arr = mysql_fetch_array($miss)){
	echo "<tr align=center ".($arr["lockit"]>1?"bgcolor=#999999":($arr["lockit"]==1?"bgcolor=#dddddd":"")).">";
	echo "<td>$count</td>";
	echo "<td><a href=# onClick=\"change_item('lockit".$count."','".$arr["mission_id"]."','lockit');chcolor('".$count."');return false;\"><u><span id=lockit".$count.">".$lockstr[$arr["lockit"]]."</span></u></a></td>";
	echo "<td align=left>".$arr["name"]."</td>";
	echo "<td><a href=# onClick=\"change_item('uploader".$count."','".$arr["mission_id"]."','uploader');return false;\"><u><span id=uploader".$count.">".($arr["uploader"]==1?"ָ����ʦ":"ѧ��")."</span></u></a></td>";
	echo "<td>".($arr["filename1"]?"D":"").($arr["filename2"]?"P":"")."</td>";
	echo "<td><a href=# onClick=\"change_item('needdoc".$count."','".$arr["mission_id"]."','needdoc');return false;\"><u><span id=needdoc".$count.">".($arr["needdoc"]?"<font color=blue>����</font>":"��ͨ")."</span></u></a></td>";
	echo "<td><input id=start_time".$count." name=start_time".$count." size=12 onclick=WdatePicker() onchange=\"ChangeInputDate('start_time','".$count."','".$arr["mission_id"]."',start_time".$count.".value,".$arr["mission_id"].");\" class=Wdate value=".date("Y-m-d",$arr["start_time"])."></td>";
	echo "<td><input id=".$objtime.$count." name=".$objtime.$count." size=12 onclick=WdatePicker() onchange=ChangeInputDate('".$objtime."','".$count."','".$arr["mission_id"]."',".$objtime.$count.".value,86399) class=Wdate value=".date("Y-m-d",$arr[$objtime])."></td>";
	echo "<td>";
	echo "<a href =".$PHP_SELF."?mission_id=".$arr["mission_id"]."&act=modify><font color=blue><u>�޸�����</u></font></a>";
	echo "&nbsp;&nbsp;";
	echo "<a href =".$PHP_SELF."?mission_id=".$arr["mission_id"]."&act=delete onclick=\"return confirm('��ȷ��Ҫɾ����".$arr["name"]."����')\" ><font color=blue><u>ɾ��</u></font></a>";
	echo "</td>";
        echo "</tr>";
        $count++;
}
?>
</table>
<table width="800" border=0 bordercolor=#000000 align="center" cellpadding="6">
	<tr><td align=left>
<list align=left>�ĵ�˵����<b>רҵ������֪</b>��������Ļ�������ѯ�������Ǻǣ���
<li>�ĵ�״̬������������ֹͣ�û��ϴ��ļ����ܣ���ͣ�á�����ʾ������һ�������������ݴ��ڵĻ����Ϲرո�����
<li>�ĵ����Ⱥ�����ĵ��Ⱥ�����Կ�ʼʱ��Ϊ�������У����������������������޸ġ���ʼʱ�䡱
<li>�����衱��ǣ�����־Ϊ�����衱���ĵ���ֻ������һ�������衱�ĵ��ɹ��Ͻ�������·����ύ���γ������ĵ���ص�����
<li>��������ĸ���壺D��ʾ�������������P��ʾ����������������Щ�ĵ����������������ĵ���ʽ�б𣬿��Էֱ��ύ
</list>
</td>
</tr>
</table>
<?php
} // ShowDocumentList ��������
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
