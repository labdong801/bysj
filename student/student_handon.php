<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "提交自选题";
if($act=="modify") $YM_ZT2 = "修改提交的自选课题内容";
else $YM_ZT2 = "向指导教师提交自选题";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 1; //本页访问需要权限：普通学生
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
		if($qsql)	echo "<script>alert('修改自选课题成功！');</script>";
		else echo "<script>alert('修改自选课题出错！没有此题或此题修改未授权！');</script>";
	} else {
		$sql = "insert into ".$TABLE."topic (teacher_id,topic,source,student_number,is_select,type,profession,meaning,request,question,time,year) values ('$name','$topic','1','$number','0','$type','$com_pro_id,','$meaning','$request','$question',now(),'$date')";
		$fsql = mysql_query($sql);
 		if($fsql){
 			$aa = mysql_query("select id from ".$TABLE."topic where student_number = '$number'");
 			$bb = mysql_fetch_array($aa);
 			$qsql = mysql_query("insert into ".$TABLE."student_select(number,topic_num,wish,pro_id) values ('$number','$bb[id]','自选','$com_pro_id')");
			if($qsql)	echo "<script>alert('提交自选课题成功，请等候管理员审核该选题！\\r\\n\\r\\n该题通过后，对应的教师才能看见此题！');window.location.href='selecttitle.php'</script>";
			else echo "<script>alert('提交自选课题出错！');</script>";
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
		Show_Message("修改自选课题出错！没有此题或此题修改未授权！");
		@include($baseDIR."/bysj/inc_foot.php");
		exit;
	}
	//print_r($bb);
}

 ?>
 <script language="javascript">
function is_empty(){
  if(myform.topic.value==""){
   alert("提交的题目不能为空！");
   return false;  
  }
}
</script>

<form name="myform" method="post" action="">
  <table width="760" border="1" align="center">
    <tr>  
      <td align=right>指导老师：</td>
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
	   （请选择你希望指导你的老师的名字，你提交的题目会出现在TA的名下）
	  </td>
    </tr>  
    <tr>  
      <td width=160 align=right>题目：</td>
      <td><input name="topic" type="text" id="topic" size="28" maxlength=28  value="<? echo $bb["topic"];?>" />（注：按学校要求，题目不能超过20字符）</td>
    </tr>
    <tr>
      <td align=right>类型：</td>
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
	  <td align=right>课题意义：</td>
      <td>此处填写：是因为什么样的问题导致你提出该课题来解决它，实现该系统，有什么样的现实意义，对你的专业技能有什么样的帮助。请认真填写本课题的设计意义，此为选题表的一部分内容：<br><textarea name="meaning" cols="80" rows="8" wrap="virtual" id="meaning"><? echo $bb["meaning"];?></textarea></td>
    </tr>    
	<tr>
	  <td align=right>课题的具体内容要求：</td>
      <td>此处填写您设想中，该课题将采用哪些关键器件、什么方法，并具备哪些功能和最终的成果形式，<br>此内容将成为选题表内容之一，请认真填写。<br><textarea name="request" cols="80" rows="8" wrap="virtual" id="request"><? echo $bb["request"];?></textarea></td>
    </tr>
	<tr>
	  <td align=right>要重点解决的问题：</td>
      <td>此处填写实现本课题需要重点解决的问题，让老师了解你对该课题的掌握情况<br><textarea name="question" cols="80" rows="5" wrap="virtual" id="question"><? echo $bb["question"];?></textarea></td>
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
	    	
	      <input type="submit" name="submit" value="提交" onclick="return is_empty()"/>
	      &nbsp;&nbsp;&nbsp;&nbsp;
	      <input name="reset" type="reset" id="reset" value="重置"/>
	    </div></td>
    </tr>
  </table>
</form>


<?
  @include($baseDIR."/bysj/inc_foot.php");
?>
