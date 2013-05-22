<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "添加文档要求";
$YM_ZT2 = "添加毕业设计文档";
$YM_MK = "毕业设计文档管理系统";
$YM_PT = "文档系统";
$YM_DH = 1; //需要导航条
$YM_QX = 80; //本页访问需要权限：管理员
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
<script language="javascript">
function is_value(){
  if(myform.name.value==""){
   alert("任务文档名称不能为空！");
   return false;  
  }
  if(myform.address.value==""){
   alert("保存地址不能为空！");
   return false;  
  }  
  if(myform.start_time.value==""){
   alert("任务开始时间不能为空！");
   return false;  
  }  
  if(myform.end_time.value==""){
   alert("任务截止时间不能为空！");
   return false;  
  }  
}
</script>

<form name="myform" method="post" action="" enctype="multipart/form-data">
<table width="700" align="center" border="1" bordercolor=#000000  cellpadding="6">
<tr>
  <td colspan="4">您将添加任务到：
  <?php
  for($i=$YEAR_C;$i>=$YEAR_S;$i--){
  	if($i==$CURR_YEAR){
  		$s1 = " checked";
  		$s2 = "<font size=+1><b>".$i."年度</b></font>";
  	} else {
  		$s1 = "";
  		$s2 = $i."年度";
  	}
  	echo "&nbsp;&nbsp;<input name=year type=radio $s1 value='$i'> ".$s2;
  }
  ?></td>
 </tr>	
 <tr>
  <td>文档名称：</td>
  <td><input name="name" type="text" size="20" /></td>
  <td align=right>保存目录名（拼音）</td>
  <td><input name="address" type="text" size="20" /></td>
 </tr>
 <tr>
  <td>文档上传者：</td>
  <td colspan="3">
  	<input type="radio" name="target" value="1" />由教师上传&nbsp;&nbsp;
  	<input type="radio" name="target" value="0" checked />由学生上传&nbsp;&nbsp;
  </td>
 </tr>
 <tr>
  <td rowspan=2>本文档的<br>标准格式参考：</td>
  <td colspan="3">设计类：<input type="file" name="design" /></td>
 </tr>
 <tr>
    <td colspan="3">若科学研究类毕业论文格式有区别，请补充论文类参考文档：<br>论文类：<input type="file" name="paper" /></td>
 </tr>
 <tr>
  <td>文档内容，<br>时间、重点问题<br>等说明：</td>
  <td colspan="3"><textarea name="demonstration" cols="60" rows="8"  wrap="virtual"></textarea></td>
 </tr>
 <tr>
  <td>任务开始时间：</td>
  <td><input name="start_time" type="text" size="20" / value="<?php echo date("Y-m-d");?>"></td>
  <td>任务截止时间：</td>
  <td><input name="end_time" type="text" size="20" / value="<?php echo date("Y-m-d",time(0)+7*86400);?>"></td>
 </tr>
 <tr>
  <td>参考文档查看权根：</td>
  <td colspan="3"><input type="radio" name="allow" value="1" />仅教师可看&nbsp;&nbsp;<input type="radio" name="allow" value="2" />仅学生可看&nbsp;&nbsp;<input type="radio" name="allow" value="0" checked="checked"/>两者均可看
  </td>
 </tr>
 <tr>
  <td colspan="7">打印时间：<input name="print_time" type="text" size="20" />&nbsp;&nbsp;纸型：<select name="paper_type"><option value="A4">A4</option><option value="16K">16K</option></select>&nbsp;&nbsp;份数：<input type="text" name="paper_num" size="20" /></td>
 </tr>
</table>
<input type="submit" name="submit" value="提交新的文档" onclick="return is_value()"/>
</form>
<table width="600" align="center">
 <tr>
  <td>
   说明：
    <li>如果要提交的当前任务为第i个任务的话，保存地址应为【mission_logi】，如第1个任务，保存的地址为【mission_log1】</li>
	<li>文档上传者单选按钮栏中，选择【教师】表示该任务要求教师上传文档，选择【学生】表示该任务要求学生上传文档；</li>
	<li>参考文档单选按钮栏中，选择【教师】表示教师有权查看参考文档，选择【学生】表示学生有权查看参考文档，选择【两者均可看】表示教师和学生都有权查看参考文档；</li>
    <li><font color="#FF0000">时间的输入格式为：XXXX-XX-XX，如2009-01-01。</font></li>
  </td>
 </tr>
</table>

<?php
 if($_POST["submit"]!=""){
   $mission_name = $_POST["name"];
   $address = $_POST["address"];
   $target = $_POST["target"];
   $demonstration = $_POST["demonstration"];
   $start_time = $_POST["start_time"];
   $end_time = $_POST["end_time"];
   $allow = $_POST["allow"];
   $print_time = $_POST["print_time"];
   $paper_type = $_POST["paper_type"];
   $paper_num = $_POST["paper_num"];
   $year = $_POST["year"];
   $filename1 = "";
   $filename2 = "";

         if(!file_exists("../../../Docs/".$year)){
             $kk = mkdir("../../../Docs/".$year,0700);
         }
   
   if(is_uploaded_file($_FILES["design"]["tmp_name"]) or is_uploaded_file($_FILES["paper"]["tmp_name"])){
      $error1 = $upfile["error"];
      $error2 = $upload["error"];
      if($error1==0){ 
         $upfile = $_FILES["design"];
         $name_1 = $upfile["name"];
         $tmp_name1 = $upfile["tmp_name"];
         $tmp_type1=".".substr(strrchr($name_1,"."),1);
         $filename1 = $address."_design".$tmp_type1;

         $destination1 = "../../../Docs/".$year."/".$filename1;
          move_uploaded_file($tmp_name1,$destination1);
      }
      if($error2==0){ 
         $upload = $_FILES["paper"];
         $name_2 = $upload["name"];
         $tmp_name2 = $upload["tmp_name"];
         $tmp_type2=".".substr(strrchr($name_2,"."),1);
         $filename2 = $address."_pager".$tmp_type2;
         $destination2 = "../../../Docs/".$year."/".$filename2;
          move_uploaded_file($tmp_name2,$destination2);
      }
   }
   $sql = "insert into ".$TABLE."mission_list(
           name,address,uploader,demonstration,start_time,end_time,watch_authority,
           print_time,paper_type,paper_num,filename1,filename2,year
        ) values (
           '$mission_name','$address','$target','$demonstration','$start_time','$end_time','$allow',
           '$print_time','$paper_type','$paper_num','$filename1','$filename2','$year'
        )";
   if(mysql_query($sql)){
   	  if($filename1!=""||$filename2!=""){
   	     $msg = "成功上传《".$mission_name."》的参考文档";
   	  }
   	  echo "<script>alert('".$msg."\\n\\n新的文档任务提交成功！');history.back();</script>";
   }else{
      echo "<script>alert('文档任务提交失败！');history.back();</script>";
   }
   //echo $sql;
 }
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
