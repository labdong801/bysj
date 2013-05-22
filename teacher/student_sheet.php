<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "导入学生名册";
$YM_ZT2 = "导入专业学生名册";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 40; //本页访问需要权限:专业主任
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 <?php
   $cnt = 0;
 	 $curr_pro_id = $set_pro_id;
         $majiorlist = get_majior_list($com_auth>80?"":$com_pro);
         $pro_list = explode(",", $com_pro_id);  
	 echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请选择操作的专业：";
	 $pro_name = "";
	 //print_r($majiorlist);
	 while(list($k,$v)=each($majiorlist)){
	 	   if((in_array($k,$pro_list)||$com_auth>40)&&$v[open]){
	 	   	   if($cnt && $cnt%4==0) echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;　　　　　　　　　";
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
 		Show_Message("对不起，您的访问被拒绝，请求助管理员解决问题。");
 		@include($baseDIR."/bysj/inc_foot.php");
 		exit;
 	} 	
 ?>
  
 <table width="800">
<tr>
<td><div align="center">
  <h1 class="STYLE1">上传<?php echo $short_name; ?>专业学生名单</h1>
</div></td>
</tr>
<tr>
<td align="center">
<form id="upload" name="upload" enctype="multipart/form-data" method="post" action="">
  上传名单：<input type="file" name="file" />
  <select name=byyear size=1>
  	<?php
  	for($i=$YEAR_S;$i<$YEAR_C+4;$i++) echo "<option value=$i".($i==$YEAR_C?" selected":"")."> $i 届</option>";
  	?>
   </select>（毕业年份）
  <input type="submit" name="handon" value="导入" />
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
<td>学生名单导入说明：</td>
<tr>
<td>1.导入文本格式为教务系统导出的学生名册简要格式（EXCEL）</td>
</tr>
<tr>
<td>2.<font color=red>导入前请用EXCEL打开，删除其中的“Document map”页，并保存。</font></td>
</tr>
<tr>
<td>3.请正确选择学生的毕业年份，且请勿重复导入学生名单。</td>
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
   if($type!='application/vnd.ms-excel'||$error!='0'){  //只允许上传excel文件
      echo "<br><br>";
      Show_Message("抱歉，您上传不是学校规范的学生名册EXCEL导出文档。");
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
   $cnt = 0; //导入学生数量
   $insertlist = array(); //待插入学生
   for($sheet=0;$sheet<sizeof($data->boundsheets);$sheet++){
      for($i = 1; $i <= $data->sheets[$sheet]['numRows']; $i ++) {      	 
         for($j = 1; $j <= $data->sheets[$sheet]['numCols']; $j ++) {
         	  $string = $data->sheets[$sheet]['cells'][$i][$j];
         	  if(ereg("".$short_name."[0-9-]+",$string)){
         	  	 $caninsert = true;
               preg_match_all('/[0-9-]+/',$string,$match);
               $classname = $short_name.$match[0][0];
         	  }
         	  if(preg_match("/广东石油化工学院学生/",$string))$caninsert = false;
         	  if(!$caninsert) continue;
         	  //echo $string."|";
         	  if(preg_match("/^[0-9]{9,13}$/",$string)){
         	  	 $insertlist[$cnt]["num"] = $string;
         	  	 $insertlist[$cnt]["classname"] = $classname."班";
         	  	 $step = 1;
         	  	 $cnt ++;
         	  } else if($step == 1 && $string !="") {
         	  	 $insertlist[$cnt-1]["name"] = $string;
         	  	 $step = 0;
         	  }
	       }	
      }
   }

   if($cnt<1){  //无有效学生名单
      echo "<br><br>";
      Show_Message("抱歉，EXCEL文档中没有学生名单。<br><br>由于直接从教务系统导出的EXCEL文档格式不规范，您必须打开并保存一下方可正常导入。");
      @include($baseDIR."/bysj/inc_foot.php");
      exit;
   }
   
   //print_r($insertlist);
   echo "即将导入 $pro_name $short_name 共 ".($cnt)." 位同学的信息：<br>\n";
   $errcnt = 0;
   for($i=0;$i<$cnt;$i++){   	  
   	  $sql = "select name,number from ".$TABLE."student_sheet where number='".$insertlist[$i]["num"]."'&&class='".$insertlist[$i]["classname"]."'";
   	  //echo $sql."<br>";
   	  $query = mysql_query($sql);
   	  if(mysql_num_rows($query)>0){
   	  	echo ($i+1).". ".$insertlist[$i][classname]."|".$insertlist[$i][num]."|".$insertlist[$i][name]." 已存在，跳过<br>\n";
   	  	$errcnt ++;
   	  	continue;
   	  }
   	  mysql_query("insert into ".$TABLE."student_sheet values ('$pro_name','".$insertlist[$i][classname]."','".$insertlist[$i][num]."','".$insertlist[$i][name]."','".$insertlist[$i][num]."',1, '0', '0', '0', '0', '0', '0', '".$byyear."', 0, '无', 0)");
   }
   echo "名单导入完成".($errcnt>0?"，其中 $errcnt 条记录因重复未导入":"")."请查询<a href=student_account.php?select_year=2013><font color=blue><u>学生名单</u></font></a>是否正确。";
   //if($i == 1){
   //   echo "<script>alert('信息表导入成功！');history.back();</script>";
   //}else{
   //   echo "<script>alert('信息表导入失败！');history.back();</script>";
   // }
}
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>