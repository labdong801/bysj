<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�޸ı���ѡ��";
$YM_ZT2 = "��ҵ��ƣ����ģ������޸�";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<?php
 $id=$_GET["id"];
 $compare = mysql_query("select * from ".$TABLE."topic where id = $id");
 $array = mysql_fetch_array($compare);
?>
<form name="reform" method="post" action="">
  <table width="760" border="1" align="center"  bordercolor=#000000  cellpadding="3">
  	<?php
  	if($com_auth>=40){
  		?>
 <tr>  
   <td align=right>ָ����ʦ��</td>
     <td><select name="teacher">
	 <?php
	  $tmparr = mysql_query("select teacher_id,name from ".$TABLE."teacher_information  where belong='$com_pro'||teacher_id='".$array["teacher_id"]."'");
	  while($tmpdata = mysql_fetch_array($tmparr)){
	    if($tmpdata["teacher_id"]==$array["teacher_id"]) $selstr = " selected";
	    else $selstr = "";
	    echo "<option value=".$tmpdata["teacher_id"].$selstr.">".$tmpdata["name"]."</option>";
	   }
	   ?>
	   </select>
	  </td>
    </tr>  
<?php
}
?>      	
    <tr>
      <td  align=right width=160 >��Ŀ��</td>
      <td>
	  <input name="topic" type="text" id="topic" size="28"  maxlength=28 value="<? echo $array["topic"];?>"  onkeydown="if (event.keyCode==27) {return false;}"/> ��ע����ѧУҪ����Ŀ���ܳ���20�ַ���
	  </td>
    </tr>
    <tr>
      <td align=right>���ͣ�</td>
      <td><select name="type">
       <?php
	   $query = mysql_query("select * from ".$ART_TABLE."title_sort");
	   while($row = mysql_fetch_array($query)){
	   if($array["type"]==$row["id"]){
	   ?>
	   <option value="<? echo $row["id"];?>" selected="selected"><? echo $row["name"];?></option>
	  <?php
	   }else{	   
	   ?>
	   <option value="<? echo $row["id"];?>"><? echo $row["name"];?></option>
	  <?php
	   }
	   }
	  ?>
      </select>
	  </td>
    </tr>
    <tr>
      <td align=right>����רҵ��</td>
      <td>
       <?php
	   $quer = mysql_query("select * from ".$TABLE."major  where open=1 && type=4");
	   $checkbox = "";
	   $pprow = array();
	   $proarr = explode(",",$array["profession"]); 
	   $pro_list = explode(",", $com_pro_id);  
	   $i=0;
	   while($roww = mysql_fetch_array($quer)){
	   	   if(!in_array($roww["id"],$pro_list)) continue;
	   	   $pprow[$i]["id"] = $roww["id"]; 
	   	   $pprow[$i]["name"] = $roww["name"]; 
	   	   for($ppi=0;$ppi<sizeof($proarr);$ppi++){
	   	   	  if($proarr[$ppi]==$roww["id"]){
	   	   	  	   $pprow[$i]["checked"]=true;
	   	   	  	   break;
	   	   	  } else $pprow[$i]["checked"] = false;
	   	  }
	   	  $i++;
	   	}
	   	for($i=0;$i<sizeof($pprow);$i++){
	      $check = "check".$i;
          echo "<input type=checkbox name=$check value=".$pprow[$i]["id"].($pprow[$i]["checked"]?" checked":"").">".$pprow[$i]["name"];
	   	   $checkbox = $checkbox.$_POST["$check"].",";	      
	   }
	  ?>
	  </td>
    </tr>
	<tr>
	  <td align=right>�������壺</td>
      <td>��������д�������������壬��Ϊѡ����һ�������ݣ�<br><textarea name="meaning" cols="80" rows="8" wrap="virtual" id="meaning"  onkeydown="if (event.keyCode==27) {return false;}"><? echo $array["meaning"]?></textarea></td>
    </tr>  
    <tr>
	  <td align=right>������������Ҫ��</td>
      <td>�˴���д���Ա�����ľ���Ҫ�󣬰���ʵ�ֵ����ݡ��㷨�����յĳɹ���<br>��������ѡ�������֮һ����������д��<br><textarea name="request" cols="80" rows="8" wrap="virtual" id="request"  onkeydown="if (event.keyCode==27) {return false;}"><? echo $array["request"];?></textarea></td>
    </tr>
	<tr>
	  <td align=right>Ҫ�ص��������⣺</td>
      <td>�˴���дʵ�ֱ�������Ҫ�ص��������⣬��ѧ������ʾ��<br><textarea name="question" cols="80" rows="5" wrap="virtual" id="question"  onkeydown="if (event.keyCode==27) {return false;}"><? echo $array["question"];?></textarea></td>
	</tr>
	<?php
	if($array["year"]!=$YEAR_C&&$array["is_select"]!=1){
		echo "<tr><td align=right height=58>������Ŀ��</td>
		<td>&nbsp;&nbsp;����Ҫ�ѱ���Ŀ���ڱ����ҵ�������<br>
		&nbsp;<input type=radio name=year value='".$array["year"]."' checked> ���ֲ���
		<input type=radio name=year value='".$YEAR_C."'> ���ڱ��������
		</td></tr>";
	} else echo  "<input type=hidden name=year value='".$array["year"]."'> ";
	if($array["verify"]<0) $vvv = 0;
	else $vvv = $array["verify"];
	echo "<input type=hidden name=verify value='$vvv'>";
	?>
    <tr>
      <td colspan="2">
	    <div align="center">
	      <input type="submit" name="submit" value="�޸ı�ҵ���ѡ��" />
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
  if($bbb["authority"]==99) $teacher = $_POST["teacher"];
  else $teacher = $teacher_id;
 $sql = mysql_query("update ".$TABLE."topic set topic='$topic',type='$type',profession='$checkbox',meaning='$meaning',request='$request',question='$question',year='$year',teacher_id='$teacher',verify='$verify' where id = $id");
 if($sql){
   echo "<script>alert('ѡ����Ϣ�޸ĳɹ���');history.back();</script>";
 }else{
   echo "<script>alert('ѡ����Ϣ�޸�ʧ�ܣ�');window.location.href='revise.php?id=$id';</script>";
 }
}
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>