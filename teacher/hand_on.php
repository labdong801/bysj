<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�ύѡ��";
$YM_ZT2 = "�ύ��ҵ���ѡ��";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��:��ͨ��ʦ
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<script language="javascript">
function is_value(){
  if(myform.topic.value==""){
   alert("�ύ����Ŀ����Ϊ�գ�");
   return false;  
  }
}
</script>

<form name="myform" method="post" action="">
  <table width="760" border="1" align="center"     cellpadding=5 bordercolor=#000000>
<?php
 if($com_auth>=40){
?>
 <tr>  
   <td align=right>ָ����ʦ��</td>
     <td><select name="teacher">
	 <?php
	  $arr = mysql_query("select teacher_id,name from ".$TABLE."teacher_information where belong='$com_pro'");
	  while($array = mysql_fetch_array($arr)){
	    if($array["teacher_id"]==$teacher_id){
	  ?>
	   <option value="<?php echo $array["teacher_id"]?>" selected="selected"><? echo $array["name"];?></option>
	   <?php
	   }else{
	   ?>
	   <option value="<?php echo $array["teacher_id"]?>"><? echo $array["name"];?></option>
	   <?php
	   }
	   }
	   ?>
	   </select>
	  </td>
    </tr>  
<?php
}
?>
    <tr>
      <td width=160 align=right>��Ŀ��</td>
      <td><input name="topic" type="text" id="topic" size="28" maxlength=28  onkeydown="if (event.keyCode==27) {return false;}"/> ��ע����ѧУҪ����Ŀ���ܳ���20�ַ���</td>
    </tr>
    <tr>
      <td align=right>�������ͣ�</td>
      <td>
	  
       <?php
       //<select name="type" id="type">
	   $query = mysql_query("select * from ".$TABLE."title_sort");
	   $tmpi = 0;
	   while($row = mysql_fetch_array($query)){
	   if($row["open"]==1){
	      //if($row["name"]=="��ѧ�о�") $msg = " onclick=alert('ϵͳ��ʾ��\\r\\n&nbsp;&nbsp;1����������ָ��ѧ����������������ͣ�\\r\\n&nbsp;&nbsp;2��ÿ����ʦ���ָ��һ���ѧ�о�����⡣\\r\\n\\r\\n&nbsp;&nbsp;3�����ǳ���Ҫ�����������ѧ�������������ģ�')";
	      //else $msg = "";
	      $msg = "";
	      if($row["name"]=="�������") $dsel = " CHECKED";
	      else $dsel = "";
	      $tmpi ++;
	      if($tmpi%3==0) echo "<br>";
	     ?>
	   <input type=radio name=type value="<? echo $row["id"];?>" <?echo $msg.$dsel;?>><? echo $row["name"];?>&nbsp;
	  <?php
	   }
	   }
	  ?>
      
	  </td>
    </tr>
    <tr>
      <td align=right>����רҵ��</td>
      <td>
       <?php
           $pro_list = explode(",", $com_pro_id);  
	   $quer = mysql_query("select * from ".$TABLE."major where open=1 && type=4");
	   $i = 0;
	   $checkbox = "";
	   while($roww = mysql_fetch_array($quer)){
	   	$check = "check".$i;
	   	if(in_array($roww["id"],$pro_list)){
            		echo "\n<input type=checkbox name=$check value=".$roww["id"]." checked> ".$roww["name"]."\n";
	   		$checkbox = $checkbox.$_POST["$check"].",";
	   	}
	   	$i++;
	   }
	  ?>
	  </td>
    </tr>
    <tr>
	  <td align=right>�������壺</td>
      <td>��������д�������������壬��Ϊѡ����һ�������ݣ�<br><textarea name="meaning" cols="80" rows="8" wrap="virtual" id="meaning"  onkeydown="if (event.keyCode==27) {return false;}"></textarea></td>
    </tr>    
	<tr>
	  <td align=right>����ľ�������Ҫ��</td>
      <td>�˴���д���Ա�����ľ���Ҫ�󣬰���ʵ�ֵ����ݡ��㷨�����յĳɹ���<br>��������ѡ�������֮һ����������д��<br><textarea name="request" cols="80" rows="8" wrap="virtual" id="request"   onkeydown="if (event.keyCode==27) {return false;}"></textarea></td>
    </tr>
	<tr>
	  <td align=right>Ҫ�ص��������⣺</td>
      <td>�˴���дʵ�ֱ�������Ҫ�ص��������⣬��ѧ������ʾ��<br><textarea name="question" cols="80" rows="5" wrap="virtual" id="question" onkeydown="if (event.keyCode==27) {return false;}"></textarea></td>
	</tr>
    <tr>
      <td colspan="2">
	    <div align="center">
	      <input type="submit" name="submit" value="�ύ�µı�ҵ���ѡ��" onclick="return is_value()"/>
	    </div></td>
    </tr>
  </table>
</form>
<?php
if($_POST["submit"]){
$topic = $_POST["topic"];
$type = $_POST["type"];
$meaning = $_POST["meaning"];
$request = $_POST["request"];
$question = $_POST["question"];
$year = $YEAR_C;
if($com_auth>=40){
	$teacher = $_POST["teacher"];
	$sql = mysql_query("insert into ".$TABLE."topic (teacher_id,topic,source,student_number,is_select,type,profession,meaning,request,question,time,year) values ('$teacher','$topic','0','0','0','$type','$checkbox','$meaning','$request','$question',now(),'$year')");
}else{
	$sql = mysql_query("insert into ".$TABLE."topic (teacher_id,topic,source,student_number,is_select,type,profession,meaning,request,question,time,year) values ('$teacher_id','$topic','0','0','0','$type','$checkbox','$meaning','$request','$question',now(),'$year')");
}
 if($sql){
   echo "<script>alert('�����ύ�ɹ���');history.back();</script>";
 }else{
   echo "<script>alert('�����ύʧ�ܣ�');history.back();</script>";
 }
}
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>