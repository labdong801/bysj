<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "导入教师名册";
$YM_ZT2 = "导入专业教师名册";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 90; //本页访问需要权限:专业主任
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<?php

      $pro_list = explode(",", $com_pro_id);  
      
      if($_POST["submit"]){
         	$set_pro_id = trim($_POST["set_pro_id"]);
         	if(!in_array($set_pro_id,$pro_list)){
         		Show_Message("对不起，非授权操作，操作被拒绝。");  		
          	     @include($baseDIR."/bysj/inc_foot.php");
                 exit;
         	} else {  		
       	       //$teacher_start = strtotime(trim($_POST["teacher_start"]));
       	       //if(mysql_affected_rows()>0)  $setresult = 1;
       	  }
      }      
  
	 $sql = "select id, name, shortname from ".$TABLE."major where type=4 && open = 1";
	 $que_sql = mysql_query($sql);
	 
	 $curr_pro_id = $set_pro_id;
         $majiorlist = get_majior_list();
	 echo "请选择需要导入指导老师的专业：<br>";
	 $pro_name = "";
	 while(list($k,$v)=each($majiorlist)){
	 	   if(in_array($k,$pro_list)){
	 	   	   if($curr_pro_id ==0) $curr_pro_id = $k;
	 	   	   if($curr_pro_id == $v["id"]){
	 	   	   	    echo "[<b>".$v["name"]."</b>]";
			 	    $pro_name = $v["name"];
	 	   	   } else echo "[<a href=".$PHP_SELF."?set_pro_id=".$k."><font color=blue><u>".$v["name"]."</u></font></a>]";
	 	   	   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	 	   }
 	 }
?>


<table width="600">
<tr>
<td align="center">
<form id="upload" name="upload" enctype="multipart/form-data" method="post" action="">
  上传名单：<input type="file" name="file" />
  <input type="submit" name="handon" value="导入" />
</form>
</td>
</tr>
</table>
<br />
<table width="600" align="center">
<tr>
<td>
<table width="580" class="STYLE2">
<tr>
<td>
教师名单导入说明：
</td>
<tr>
<td>
1.教师名单导入必须按照如下格式：
</td>
</tr>
<tr>
<td>
帐号;姓名;指导人数
</td>
</tr>
<td>
<tr>
<td>
2.每次导入的教师名单不能重复
</td>
</tr>
</table>
</td>
</tr>
</table>
<?php
if(is_uploaded_file($_FILES["file"]["tmp_name"])){
 $upfile = $_FILES["file"];
 $name = $upfile["name"];
 $type = $upfile["type"];
 $size = $upfile["size"];
 $tmp_name = $upfile["tmp_name"];
 $error = $upfile["error"];
 $destination = "../uploadfile/".$name;
 if($type=='text/plain'&&$error=='0'){ //只允许上传text文件
 move_uploaded_file($tmp_name,$destination);
 }
 $fp = fopen($destination,"r");
 while(!feof($fp)){
 $line = trim(fgets($fp));
 $array = explode(";",$line);
 $sql = mysql_query("insert into ".$TABLE."teacher_information values   
('$array[0]','$array[1]','$array[2]','$array[3]','$array[4]','$array[5]','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0')");
 if($sql){
  $i = 1;
 }
 }
 if($i == 1){
  echo "<script>alert('信息表导入成功！');history.back();</script>";
 }else{
 echo "<script>alert('信息表导入失败！');history.back();</script>";
 }
 fclose($fp);
}
?>
</td>
</tr>
</table>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>