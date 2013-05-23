<?php
$self= $PHP_SELF;//文件相对地址

$filename = $_SERVER["SCRIPT_FILENAME"];//获取文件绝对地址
$loc= strpos($filename,$self);//自己相对地址在绝对地址中出现的位置
$baseDIR = substr($filename,0,$loc);//根本地址

$YM_ZT = "教师设置";
$YM_ZT2 = "教师指导学生任务设置";
$YM_MK = "毕业设计双向选题系统";
$YM_PT ="教师任务下达";
$YM_DH = 1; //需要导航条
$YM_QX = 90; //管理员权限
include($baseDIR."/bysj/inc_head.php");
$teacher_id = $com_id;

$choice="";
 ?>
 <?php
if($_GET['Choice'])
{

   $choice=$_GET['Choice'];
	if($choice=='1')
	 {
	 	$Class="大一任务下达";
	 }
	 else if($choice==2)
	 {
	 	$Class="大二任务下达";
	 }
	  else if($choice==3)
	 {
	 	$Class="大三任务下达";
	 }
	  else if($choice==4)
	 {
	 	$Class="大四任务下达";
	 }
}
if($_GET['Choice_1'])
{

   $choice=$_GET['Choice_2'];
	if($choice=='1')
	 {
	 	$Class="大一任务下达";
	 }
	 else if($choice==2)
	 {
	 	$Class="大二任务下达";
	 }
	  else if($choice==3)
	 {
	 	$Class="大三任务下达";
	 }
	  else if($choice==4)
	 {
	 	$Class="大四任务下达";
	 }
}
else
{
	$Class="未选择年级";
}
?>
<script language="JavaScript" src="/bysj/images/My97DatePicker/WdatePicker.js" defer="defer"></script>
<script language="javascript">
function is_empty(){
	if(taskform.title.value=="")
	{
		alert("教师提交任务标题不能为空");
		taskform.title.focus();
		return false;
	}

    if(taskform.content.value=="")
    {
    	alert("教师提交任务内容不能为空");
    	taskform.content.focus();
    	return false;
    }


    if(taskform.start_time.value==""){
       alert("教师提交任务起始时间能不为空");
       taskform.start_time.focus();
	   return false;
     }
     if(taskform.end_time.value==""){
       alert("教师提交任务截止时间不能为空");
       taskform.end_time.focus();
	   return false;
     }

  if(taskform.end_time.value<taskform.start_time.value){
    alert("教师提交中起始时间晚于截止时间，不合理！");
    taskform.end_time.focus();
	return false;
  }

}
</script>


<table width="100%" align="center">
<tr class="align_top">
<td align="left">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
	echo "<a href=".$PHP_SELF."?select_year=".$YEAR_C."><font color=blue><u>查看".$YEAR_C."年(本届)选题</u></font></a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   查看往年情况：";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) echo "<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$i."年</u></font></a> ";
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	?>
	&nbsp;<br>&nbsp;<br>


<table width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<?php
 if($choice !="")
 {
 ?>

<tr align="center" bgColor=#5a6e8f  height=38>

<td width="20%"><font color=#FFFFFF ><?PHP echo $Class?></font></td><td><font color=#FFFFFF size=+1>指导老师任务下达</font></td>
</tr>
<?php
 //设置所选年份
 if($_GET['select_year'])
 {
 	$year = $_GET['select_year'];
 }
 else
 {
 	$year = date("Y",mktime(0,0,0,date("m")-8,1,date("Y"))); //
 	/*
 	 * 本学期年份 （当前年份减8个月）
 	 * eg:
 	 * 现在是 2013年6月 ，属于2012学年第二个期。所以 $art_select_year = 2012
 	 * 现在是2013年9月，属于2013年第一学期。所以$art_select_year =2013
 	 * */
 }
?>

 <?php
 } else
 {
 	?>
 <tr align="center" bgColor=#5a6e8f  height=38>
<td><font color=#FFFFFF size=+1>请选择你的操作</font></td>
</tr>
 <?php
 }
?>

</table>
<br>
</td>
</tr>

<tr>
<td >
<?php
 if($choice!="")
 {
?>
<form name="taskform" method="post"  action="<?php $PHP_SELF?>" onsubmit="return is_empty();">
<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr>
<td>任务标题:</td><td><input type="text" name="title"></td>
</tr>

<tr>
<td>任务内容:</td><td><textarea name="content" rows="6"cols="80"></textarea></td>
</tr>

<tr>
<td>任务时间:</td>
<td>
<table width="100%" border="0">
<tr>
<td>起始时间:<input type="text" name="start_time"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"></td>
</tr>
<tr>
<td>截止时间:<input type="text" name="end_time"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"></td>
</tr>
</table>
</td>
</tr>

<tr>
<td colspan="2">
<input type="submit" value="提交" name="submit">
<input type="reset" value="重设" name="reset">
</td>
</tr>
</table>
</form>
<?php
 }
?>

</td>
</tr>
</table>

<?php
if($_POST['submit'])
{

	$sql="insert into ".$ART_TABLE."teacher_task(title,content,start_time,end_time,teacher,class)"."values('$_POST[title]','$_POST[content]','$_POST[start_time]','$_POST[end_time]','$teacher_id','$choice')";
	if(mysql_query($sql))
	{
		echo "<script>alert('设置成功')</script>";
	}
	 else
	{
		echo "<script>alert('设置失败');history.back(1);</script>";
	}

}
?>
<?php
 @include($baseDIR."/bysj/inc_foot.php");
?>

