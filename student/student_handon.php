<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�ύ��ѡ��";
if($act=="modify") $YM_ZT2 = "�޸��ύ����ѡ��������";
else $YM_ZT2 = "��ָ����ʦ�ύ��ѡ��";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 1; //��ҳ������ҪȨ�ޣ���ͨѧ��
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;
?>

<?php
$name = $_POST["teacher"];
$topic = $_POST["topic"];
$type = $_POST["type"];
$meaning = $_POST["meaning"];
$request = $_POST["request"];
$question = $_POST["question"];
$date = $_POST["year"];
$id = $_POST["id"];
$act = $_POST["act"];

if($_POST["submit"]){
	if($act=="modify"){
		$sql = "update ".$TABLE."topic set teacher_id = '$name',topic = '$topic',type = '$type',verify='0',profession = '$com_pro_id,',meaning = '$meaning',request = '$request',question = '$question' where id = $id && source = 1 && student_number = '$number'";
		//echo $sql;
		$qsql = mysql_query($sql);
		if($qsql)	echo "<script>alert('�޸���ѡ����ɹ���');</script>";
		else echo "<script>alert('�޸���ѡ�������û�д��������޸�δ��Ȩ��');</script>";
	} else {
		$sql = "insert into ".$TABLE."topic (teacher_id,topic,source,student_number,is_select,type,profession,meaning,request,question,time,year) values ('$name','$topic','1','$number','0','$type','$com_pro_id,','$meaning','$request','$question',now(),'$date')";
		$fsql = mysql_query($sql);
 		if($fsql){
 			$aa = mysql_query("select id from ".$TABLE."topic where student_number = '$number'");
 			$bb = mysql_fetch_array($aa);
 			$qsql = mysql_query("insert into ".$TABLE."student_select(number,topic_num,wish,pro_id) values ('$number','$bb[id]','��ѡ','$com_pro_id')");
			if($qsql)	echo "<script>alert('�ύ��ѡ����ɹ�����Ⱥ����Ա��˸�ѡ�⣡\\r\\n\\r\\n����ͨ���󣬶�Ӧ�Ľ�ʦ���ܿ������⣡');window.location.href='selecttitle.php'</script>";
			else echo "<script>alert('�ύ��ѡ�������');</script>";
		}
	}
	//echo "<script>;";
}
?>

<?php
$id = $_GET["id"];
$act = $_GET["act"];

if($act == "modify"){
	if($id){
		$sql = "select * from ".$TABLE."topic where id = $id && source = 1 && student_number = $number";		
		$aa = mysql_query($sql);
		$bb = mysql_fetch_array($aa);
	}
	if(!$id ||!$bb) {
		Show_Message("�޸���ѡ�������û�д��������޸�δ��Ȩ��");
		@include($baseDIR."/bysj/inc_foot.php");
		exit;
	}
	//print_r($bb);
}

 ?>
 <script language="javascript">
function is_empty(){
  if(myform.topic.value==""){
   alert("�ύ����Ŀ����Ϊ�գ�");
   return false;  
  }
}
</script>

<form name="myform" method="post" action="">
  <table width="760" border="1" align="center">
    <tr>  
      <td align=right>ָ����ʦ��</td>
	   <?php
	   $hisleadnum = "(0+mid(lead_num,instr(lead_num,',".$com_pro_id."-')+".strlen(",".$com_pro_id."-").",2))";
	   $canleadflag = "instr(lead_num,',".$com_pro_id."-')";
	   $sql = ("SELECT teacher.teacher_id, name, selecttable.selectednum as leadnum, ".$hisleadnum." as hisleadnum
	   FROM ".$TABLE."teacher_information as teacher LEFT JOIN (
	   	SELECT teacher_id, sum(student_pro_id ='$com_pro_id' and is_select='1') AS selectednum
	   	FROM ".$TABLE."topic 
	   	WHERE year='$YEAR_C'
	   	GROUP BY teacher_id
	   ) AS selecttable 
	   ON teacher.teacher_id = selecttable.teacher_id   and ".$canleadflag."
	   WHERE ".$canleadflag." and (".$hisleadnum." > selecttable.selectednum or (".$hisleadnum." > 0 and selecttable.selectednum is NULL)) ORDER BY authority desc");
	   //echo $sql;
	   ?>
      <td><select name="teacher">
	   <?php
	   $arr = mysql_query($sql);
	   while($array = mysql_fetch_array($arr)){
	   ?>
	   <option value="<?php echo $array["teacher_id"]?>"<?php echo $bb["teacher_id"]==$array["teacher_id"]?" selected":"";?>><? echo $array["name"];?></option>
	   <?
	   }
	   ?>
	   </select>
	   ����ѡ����ϣ��ָ�������ʦ�����֣����ύ����Ŀ�������TA�����£�
	  </td>
    </tr>  
    <tr>  
      <td width=160 align=right>��Ŀ��</td>
      <td><input name="topic" type="text" id="topic" size="28" maxlength=28  value="<? echo $bb["topic"];?>" />��ע����ѧУҪ����Ŀ���ܳ���20�ַ���</td>
    </tr>
    <tr>
      <td align=right>���ͣ�</td>
      <td>
	  <select name="type" id="type">
       <?php
	   $query = mysql_query("select * from ".$ART_TABLE."title_sort");
	   while($row = mysql_fetch_array($query)){
	   if($row["open"]==1){
	   ?>
	   <option value="<? echo $row["id"];?>" <?php echo $bb["type"]==$row["id"]?" selected":"";?>><? echo $row["name"];?></option>
	  <?php
	   }
	   }
	  ?>
      </select>
	  </td>
    </tr>
    <tr>
	  <td align=right>�������壺</td>
      <td>�˴���д������Ϊʲô�������⵼��������ÿ������������ʵ�ָ�ϵͳ����ʲô������ʵ���壬�����רҵ������ʲô���İ�������������д�������������壬��Ϊѡ����һ�������ݣ�<br><textarea name="meaning" cols="80" rows="8" wrap="virtual" id="meaning"><? echo $bb["meaning"];?></textarea></td>
    </tr>    
	<tr>
	  <td align=right>����ľ�������Ҫ��</td>
      <td>�˴���д�������У��ÿ��⽫������Щ�ؼ�������ʲô���������߱���Щ���ܺ����յĳɹ���ʽ��<br>�����ݽ���Ϊѡ�������֮һ����������д��<br><textarea name="request" cols="80" rows="8" wrap="virtual" id="request"><? echo $bb["request"];?></textarea></td>
    </tr>
	<tr>
	  <td align=right>Ҫ�ص��������⣺</td>
      <td>�˴���дʵ�ֱ�������Ҫ�ص��������⣬����ʦ�˽���Ըÿ�����������<br><textarea name="question" cols="80" rows="5" wrap="virtual" id="question"><? echo $bb["question"];?></textarea></td>
	</tr>
	<tr>
	  <td colspan="2"><input type="hidden" value="<? echo $bb["year"]?$bb["year"]:$YEAR_C;?>" name="year" /></td>
	</tr>
    <tr>
      <td colspan="2">
	    <div align="center">
      <?php
      if($act=="modify"&&$id){
      	echo "<input type=hidden name=id value=".$bb["id"].">";
      	echo "<input type=hidden name=act value=modify>";
      }
      ?>
	    	
	      <input type="submit" name="submit" value="�ύ" onclick="return is_empty()"/>
	      &nbsp;&nbsp;&nbsp;&nbsp;
	      <input name="reset" type="reset" id="reset" value="����"/>
	    </div></td>
    </tr>
  </table>
</form>


<?
  @include($baseDIR."/bysj/inc_foot.php");
?>
