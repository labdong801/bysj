<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "����ѧ������";
$YM_ZT2 = "����רҵѧ������";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 40; //��ҳ������ҪȨ��:רҵ����
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 <?php
   $cnt = 0;
 	 $curr_pro_id = $set_pro_id;
         $majiorlist = get_majior_list($com_auth>80?"":$com_pro);
         $pro_list = explode(",", $com_pro_id);  
	 echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��ѡ�������רҵ��";
	 $pro_name = "";
	 //print_r($majiorlist);
	 while(list($k,$v)=each($majiorlist)){
	 	   if((in_array($k,$pro_list)||$com_auth>40)&&$v[open]){
	 	   	   if($cnt && $cnt%4==0) echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;������������������";
	 	   	   $cnt ++;
	 	   	   if($curr_pro_id ==0) $curr_pro_id = $k;
	 	   	   if($curr_pro_id == $v["id"]){
	 	   	   	  echo "[<b>".$v["name"]."</b>]";
			 	      $pro_name = $v["name"];
			 	      $short_name = $v["shortname"];
	 	   	   } else echo "[<a href=".$PHP_SELF."?set_pro_id=".$k."><font color=blue><u>".$v["name"]."</u></font></a>]";
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
  
 <table width="800">
<tr>
<td><div align="center">
  <h1 class="STYLE1">�ϴ�<?php echo $short_name; ?>רҵѧ������</h1>
</div></td>
</tr>
<tr>
<td align="center">
<form id="upload" name="upload" enctype="multipart/form-data" method="post" action="">
  �ϴ�������<input type="file" name="file" />
  <select name=byyear size=1>
  	<?php
  	for($i=$YEAR_S;$i<$YEAR_C+4;$i++) echo "<option value=$i".($i==$YEAR_C?" selected":"")."> $i ��</option>";
  	?>
   </select>����ҵ��ݣ�
  <input type="submit" name="handon" value="����" />
</form>
</td>
</tr>
</table>
<br />

<?php
if(!is_uploaded_file($_FILES["file"]["tmp_name"])){
?>
<table width="600" align="center">
<tr>
<td>
<table width="580" class="STYLE2">
<tr>
<td>ѧ����������˵����</td>
<tr>
<td>1.�����ı���ʽΪ����ϵͳ������ѧ�������Ҫ��ʽ��EXCEL��</td>
</tr>
<tr>
<td>2.<font color=red>����ǰ����EXCEL�򿪣�ɾ�����еġ�Document map��ҳ�������档</font></td>
</tr>
<tr>
<td>3.����ȷѡ��ѧ���ı�ҵ��ݣ��������ظ�����ѧ��������</td>
</tr>
</table>
</td>
</tr>
</table>
<?php
}
?>

<?php
if(is_uploaded_file($_FILES["file"]["tmp_name"])){
   $upfile = $_FILES["file"];
   $name = $upfile["name"];
   $type = $upfile["type"];
   $size = $upfile["size"];
   $tmp_name = $upfile["tmp_name"];
   $error = $upfile["error"];
   $destination = "../../uploadfile/".$name;
   if($type!='application/vnd.ms-excel'||$error!='0'){  //ֻ�����ϴ�excel�ļ�
      echo "<br><br>";
      Show_Message("��Ǹ�����ϴ�����ѧУ�淶��ѧ������EXCEL�����ĵ���");
      @include($baseDIR."/bysj/inc_foot.php");
      exit;
   }
   move_uploaded_file($tmp_name,$destination);
   require $baseDIR."/bysj/global/Excel/reader.php";
   $data = new Spreadsheet_Excel_Reader();
   $data->setOutputEncoding('GB2312');
   $data->read($destination);
   
   //print_r($data->boundsheets);      
   //print_r($data);
   
   $caninsert = false;
   $step = 0; 
   $classname = "";
   $cnt = 0; //����ѧ������
   $insertlist = array(); //������ѧ��
   for($sheet=0;$sheet<sizeof($data->boundsheets);$sheet++){
      for($i = 1; $i <= $data->sheets[$sheet]['numRows']; $i ++) {      	 
         for($j = 1; $j <= $data->sheets[$sheet]['numCols']; $j ++) {
         	  $string = $data->sheets[$sheet]['cells'][$i][$j];
         	  if(ereg("".$short_name."[0-9-]+",$string)){
         	  	 $caninsert = true;
               preg_match_all('/[0-9-]+/',$string,$match);
               $classname = $short_name.$match[0][0];
         	  }
         	  if(preg_match("/�㶫ʯ�ͻ���ѧԺѧ��/",$string))$caninsert = false;
         	  if(!$caninsert) continue;
         	  //echo $string."|";
         	  if(preg_match("/^[0-9]{9,13}$/",$string)){
         	  	 $insertlist[$cnt]["num"] = $string;
         	  	 $insertlist[$cnt]["classname"] = $classname."��";
         	  	 $step = 1;
         	  	 $cnt ++;
         	  } else if($step == 1 && $string !="") {
         	  	 $insertlist[$cnt-1]["name"] = $string;
         	  	 $step = 0;
         	  }
	       }	
      }
   }

   if($cnt<1){  //����Чѧ������
      echo "<br><br>";
      Show_Message("��Ǹ��EXCEL�ĵ���û��ѧ��������<br><br>����ֱ�Ӵӽ���ϵͳ������EXCEL�ĵ���ʽ���淶��������򿪲�����һ�·����������롣");
      @include($baseDIR."/bysj/inc_foot.php");
      exit;
   }
   
   //print_r($insertlist);
   echo "�������� $pro_name $short_name �� ".($cnt)." λͬѧ����Ϣ��<br>\n";
   $errcnt = 0;
   for($i=0;$i<$cnt;$i++){   	  
   	  $sql = "select name,number from ".$TABLE."student_sheet where number='".$insertlist[$i]["num"]."'&&class='".$insertlist[$i]["classname"]."'";
   	  //echo $sql."<br>";
   	  $query = mysql_query($sql);
   	  if(mysql_num_rows($query)>0){
   	  	echo ($i+1).". ".$insertlist[$i][classname]."|".$insertlist[$i][num]."|".$insertlist[$i][name]." �Ѵ��ڣ�����<br>\n";
   	  	$errcnt ++;
   	  	continue;
   	  }
   	  mysql_query("insert into ".$TABLE."student_sheet values ('$pro_name','".$insertlist[$i][classname]."','".$insertlist[$i][num]."','".$insertlist[$i][name]."','".$insertlist[$i][num]."',1, '0', '0', '0', '0', '0', '0', '".$byyear."', 0, '��', 0)");
   }
   echo "�����������".($errcnt>0?"������ $errcnt ����¼���ظ�δ����":"")."���ѯ<a href=student_account.php?select_year=2013><font color=blue><u>ѧ������</u></font></a>�Ƿ���ȷ��";
   //if($i == 1){
   //   echo "<script>alert('��Ϣ����ɹ���');history.back();</script>";
   //}else{
   //   echo "<script>alert('��Ϣ����ʧ�ܣ�');history.back();</script>";
   // }
}
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>