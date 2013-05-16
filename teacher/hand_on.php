<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "提交选题";
$YM_ZT2 = "提交毕业设计选题";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限:普通教师
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<script language="javascript">
function is_value(){
  if(myform.topic.value==""){
   alert("提交的题目不能为空！");
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
   <td align=right>指导老师：</td>
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
      <td width=160 align=right>题目：</td>
      <td><input name="topic" type="text" id="topic" size="28" maxlength=28  onkeydown="if (event.keyCode==27) {return false;}"/> （注：按学校要求，题目不能超过20字符）</td>
    </tr>
    <tr>
      <td align=right>课题类型：</td>
      <td>
	  
       <?php
       //<select name="type" id="type">
	   $query = mysql_query("select * from ".$TABLE."title_sort");
	   $tmpi = 0;
	   while($row = mysql_fetch_array($query)){
	   if($row["open"]==1){
	      //if($row["name"]=="科学研究") $msg = " onclick=alert('系统提示：\\r\\n&nbsp;&nbsp;1、请您尽量指导学生做工程设计类题型；\\r\\n&nbsp;&nbsp;2、每个老师最多指导一项科学研究类课题。\\r\\n\\r\\n&nbsp;&nbsp;3、【非常重要】本类课题需学生公开发表论文！')";
	      //else $msg = "";
	      $msg = "";
	      if($row["name"]=="工程设计") $dsel = " CHECKED";
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
      <td align=right>适用专业：</td>
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
	  <td align=right>课题意义：</td>
      <td>请认真填写本课题的设计意义，此为选题表的一部分内容：<br><textarea name="meaning" cols="80" rows="8" wrap="virtual" id="meaning"  onkeydown="if (event.keyCode==27) {return false;}"></textarea></td>
    </tr>    
	<tr>
	  <td align=right>课题的具体内容要求：</td>
      <td>此处填写您对本课题的具体要求，包括实现的内容、算法和最终的成果，<br>此内容是选题表内容之一，请认真填写。<br><textarea name="request" cols="80" rows="8" wrap="virtual" id="request"   onkeydown="if (event.keyCode==27) {return false;}"></textarea></td>
    </tr>
	<tr>
	  <td align=right>要重点解决的问题：</td>
      <td>此处填写实现本课题需要重点解决的问题，给学生以提示：<br><textarea name="question" cols="80" rows="5" wrap="virtual" id="question" onkeydown="if (event.keyCode==27) {return false;}"></textarea></td>
	</tr>
    <tr>
      <td colspan="2">
	    <div align="center">
	      <input type="submit" name="submit" value="提交新的毕业设计选题" onclick="return is_value()"/>
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
   echo "<script>alert('数据提交成功！');history.back();</script>";
 }else{
   echo "<script>alert('数据提交失败！');history.back();</script>";
 }
}
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>