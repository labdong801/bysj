<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "����ѡ������";
$YM_ZT2 = "���ñ�ҵ��Ƹ��׶���ֹ����";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 40; //��ҳ������ҪȨ��:רҵ����
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;

function ShowDateHint($dtime)
{
	$now = time(0);
	$now = $now - $now%86400;
	$dtime = $dtime - $dtime%86400;
	$cnt = ($dtime-$now)/86400;
	echo "&nbsp;(";
	if($cnt>330) echo "<font color=red>��Խ�У��뱨��</font>";
	else if($cnt>120) echo "��� $cnt �죡";
	else if($cnt>61)  echo "�����º�";
	else if($cnt>30)  echo "һ���º�";
	else if($cnt>2)  echo "$cnt ���";
	else if($cnt==2) echo "����";
	else if($cnt==1) echo "����";
	else if($cnt==0) echo "����";
	else if($cnt>-7) echo "<font color=blue>����ѹ�ȥ ".(-1*$cnt)." ��</font>";
	else if($cnt>-15) echo "<font color=blue>����ѹ�ȥһ��</font>";
	else if($cnt>-31) echo "<font color=blue>����ѹ������</font>";
	else if($cnt>-61) echo "<font color=blue>����ѹ�һ����</font>";
	else if($cnt>-200) echo "����ѹ�ȥ ".(-1*$cnt)." ��";
	else if($cnt>-560) echo "<font color=red>ȥ������ã�</font>";
	else if($cnt>-860) echo "<font color=red>ǰ������ã�</font>";
	else if($cnt>-15640) echo "<font color=red>�����Զ</font>";
	else echo "ʱ��δ���ã�������";
	echo ")";
}
 ?>
<script language="JavaScript" src="/bysj/images/My97DatePicker/WdatePicker.js" defer="defer"></script>  
<script language="javascript">
function is_empty(){
  if(form1.topic_start.value==""){
    alert("��ʦ�ύѡ����ʼʱ�䲻��Ϊ��");
    form1.topic_start.focus();
	return false;
  } 
  if(form1.topic_end.value==""){
    alert("��ʦ�ύѡ���ֹʱ�䲻��Ϊ��");
    form1.topic_end.focus();
	return false;
  } 
  if(form1.topic_end.value<form1.topic_start.value){
    alert("��ʦ�ύѡ���ֹ���ڱ���ʼ������������");
    form1.topic_end.focus();
	return false;
  } 
  if(form1.student_start.value==""){
    alert("ѧ��ѡ����ʼʱ�䲻��Ϊ��");
    form1.student_start.focus();
	return false;
  } 
  if(form1.student_end.value==""){
    alert("ѧ��ѡ���ֹʱ�䲻��Ϊ��");
    form1.student_end.focus();
	return false;
  }   
  if(form1.student_end.value<form1.student_start.value){
    alert("ѧ��ѡ���ʦ��ֹ���ڱ���ʼ������������");
    form1.student_end.focus();
	return false;
  } 
  if(form1.teacher_start.value==""){
    alert("��ʦѡ��ѧ����ʼʱ�䲻��Ϊ��");
    form1.teacher_start.focus();
	return false;
  } 
  if(form1.teacher_end.value==""){
    alert("��ʦѡ��ѧ������ʱ�䲻��Ϊ��");
    form1.teacher_end.focus();
	return false;
  } 
  if(form1.teacher_end.value<form1.teacher_start.value){
    alert("��ʦѡ��ѧ����ֹ���ڱ���ʼ������������");
    form1.teacher_end.focus();
	return false;
  } 
}
</script>

<?php

      $pro_list = explode(",", $com_pro_id);  
      
      if($_POST["submit"]){
         	$set_pro_id = trim($_POST["set_pro_id"]);
             $truncateselect = $_POST["truncateselect"];
         	if(!in_array($set_pro_id,$pro_list)){
         		Show_Message("�Բ��𣬷���Ȩ�������������ܾ���");  		
          	     @include($baseDIR."/bysj/inc_foot.php");
                 exit;
         	} else {  		
               $topic_start = strtotime(trim($_POST["topic_start"]));
               //echo "\$topic_start = $topic_start , ".date("Y-m-d H:i:s",$topic_start )."<br>";
       	       $topic_end = strtotime(trim($_POST["topic_end"]))+86399;
       	       $student_start = strtotime(trim($_POST["student_start"]));
       	       $student_end = strtotime(trim($_POST["student_end"]))+86399;
       	       $teacher_start = strtotime(trim($_POST["teacher_start"]));
       	       $teacher_end = strtotime(trim($_POST["teacher_end"]))+86399;
       	       $query = mysql_query("select * from ".$TABLE."set_date where pro_id = '$set_pro_id'");
       	       $row = mysql_fetch_array($query);
       	       if($row["pro_id"]==$set_pro_id){
                     mysql_query("update ".$TABLE."set_date set topic_start = '$topic_start',topic_end = '$topic_end',student_start = '$student_start',student_end = '$student_end',teacher_start = '$teacher_start',teacher_end = '$teacher_end' where pro_id = '$set_pro_id'");
                     
       	       }else{
       	             mysql_query("insert into ".$TABLE."set_date(topic_start,topic_end,student_start,student_end,teacher_start,teacher_end,pro_id) values ('$topic_start','$topic_end','$student_start','$student_end','$teacher_start','$teacher_end','$set_pro_id')");
       	       }
       	       $setresult = 0;
       	       if(mysql_affected_rows()>0)  $setresult = 1;
       	       else $setresult = -1;
       	       if($truncateselect=="ON") mysql_query("delete from `".$TABLE."student_select`  where pro_id='$set_pro_id'");
       	  }
      }      
  
         $majiorlist = get_majior_list($com_pro);
	 $curr_pro_id = $set_pro_id;
	 echo "��ѡ��Ҫ���õ�רҵ��";
	 $pro_name = "";
	 while(list($k,$v)=each($majiorlist)){
	 	   if(in_array($k,$pro_list)&&$v[open]){
	 	   	   if($curr_pro_id ==0) $curr_pro_id = $k;
	 	   	   if($curr_pro_id == $v["id"]){
	 	   	   	    echo "[<b>".$v["name"]."</b>]";
			 	    $pro_name = $v["name"];
	 	   	   } else echo "[<a href=".$PHP_SELF."?set_pro_id=".$k."><font color=blue><u>".$v["name"]."</u></font></a>]";
	 	   	   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	 	   }
 	 }
      	 
	 $sql = "select * from ".$TABLE."set_date where pro_id = '$curr_pro_id'";
	 $que_sql = mysql_query($sql);
	 $row = mysql_fetch_array($que_sql);
?>

<form name="form1" action="<?php echo $PHP_SELF; ?>" method="post">
 <br>���������� <b><?php echo $pro_name; ?></b> רҵ���׶���ֹ����<br>
 <?php if($row["student_start"]<10000) echo "<font color=red><b>��ʾ��</b>��ǰרҵ��δ�����κ����ڡ��������ã��������޸�ѡ��ʱ�Ρ���ť��</font> <br>"; ?>
 <br>
<table width="600" border="1" cellpadding="6" bordercolor=#000000>
<tr>
<td rowspan="2" width="128"><div align="center" width><span class="STYLE1"><FONT color=red size=+2 face=����><B>1.</B></FONT>��ʦ�ύѡ��</span></div></td>
<td width="100">��ʼʱ�䣺</td>
<td><input type="text" name="topic_start"  value="<?php echo date("Y-m-d",$row["topic_start"]>0?$row["topic_start"]:time(0));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["topic_start"]); ?></td>
</tr>
<tr>
<td>��ֹʱ�䣺</td>
<td><input type="text" name="topic_end"   value="<?php echo date("Y-m-d",$row["topic_end"]>0?$row["topic_end"]:(time(0)+5*86400));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["topic_end"]); ?></td>
</tr>
<tr>
<td rowspan="2"><div align="center"><span class="STYLE1"><FONT color=red size=+2 face=����><B>2.</B></FONT>ѧ��ѡ�����</span></div></td>
<td width="100">��ʼʱ�䣺</td>
<td><input type="text" name="student_start"  value="<?php echo date("Y-m-d",$row["student_start"]>0?$row["student_start"]:(time(0)+6*86400));?>"   onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["student_start"]); ?></td>
</tr>
<tr>
<td>��ֹʱ�䣺</td>
<td><input type="text" name="student_end"  value="<?php echo date("Y-m-d",$row["student_end"]>0?$row["student_end"]:(time(0)+8*86400));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["student_end"]); ?></td>
</tr>
<tr>
<td rowspan="2"><div align="center"><span class="STYLE1"><FONT color=red size=+2 face=����><B>3.</B></FONT>��ʦѡ��ѧ��</span></div></td>
<td width="100">��ʼʱ�䣺</td>
<td><input type="text" name="teacher_start" value="<?php echo date("Y-m-d",$row["teacher_start"]>0?$row["teacher_start"]:(time(0)+9*86400));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["teacher_start"]); ?></td>
</tr>
<tr>
<td>��ֹʱ�䣺</td>
<td><input type="text" name="teacher_end"  value="<?php echo date("Y-m-d",$row["teacher_end"]>0?$row["teacher_end"]:(time(0)+13*86400));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["teacher_end"]); ?></td>
</tr>
<tr><td colspan=3 align=center height=38><b>�����ѡ��</b><input type=checkbox name=truncateselect value='ON'> <b>ת����һ��ѡ�⣬<font color=red>�������</font>ѧ��־Ը</b></td></tr>
</table>

<?php
if($pro_name!=""){
?>
 <?php if($row["student_start"]<10000) echo "<br><font color=red><b>��ʾ��</b>��ǰרҵ��δ�����κ����ڡ��������ã��������޸�ѡ��ʱ�Ρ���ť��</font> <br>"; ?>
	<br><input type=hidden name=set_pro_id value=<?php echo $curr_pro_id; ?>>	
	<input type="submit" name="submit" value="�޸�ѡ��ʱ��" onclick="return is_empty()">
<?php
} else {
	 echo "<br><input type=button value=��ѡ��Ҫ�޸ĵ�רҵ disabled>";
}
?>
</form>
<?php
       	       if($setresult>0)echo ("<font color=green><b>����ѡ�����ڳɹ���".($truncateselect=="ON"?"��ִ�����־Ըָ�":"")."</b></font><br><br>");
       	       else if($setresult<0)  echo("<font color=red>����û�иı䣬���޸�ʧ�ܣ�".($truncateselect=="ON"?"��ִ�����־Ըָ�":"")."</font><br><br>");
       	       else;
?>
<table width="500">
<tr>
<td align="center">
  <span class="STYLE2">ע�⣺ʱ��������ʽΪ��XXXX-XX-XX����<?php echo date("Y-m-d");?></span></td>
</tr>
</table>


<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>