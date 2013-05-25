
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


$choice="";//导航条选择
$Class=""//相应字符
 ?>




<script type="text/javascript" src="../js/jquery-1.7.1.js"></script>
<script type="text/javascript">
var i=1;
var teacher;
var cls
function pass(max,th,choice)
{

   i++;
   teacher=th;
   cls=choice;
  if(i>max)
  {
  	i=max;
  }
}

function pass2(th,choice)
{
	i--;
	if(i<1)
	{
		i=1;
	}
	teacher=th;
	cls=choice;
}



$(document).ready(function(){

   $("#next1").click(function(){
        document.getElementById("page").innerHTML=i;

           $("#replace").fadeOut(100,function(){
        	$("#replace").fadeIn(1000);
        });

   		$.post("art_task_list.php",{page:i,teacher:teacher,Class:cls},function(data){
        $("#replace").html(data);
     });



   	});

   $("#pre").click(function(){
        document.getElementById("page").innerHTML=i;
        $("#replace").fadeOut(100,function(){
        $("#replace").fadeIn(1000);
        });

   		$.post("art_task_list.php",{page:i,teacher:teacher,Class:cls},function(data){
        $("#replace").html(data);
     });

   	});


});
</script>



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
 else if($_GET['Choice_2'])
{

   $choice=$_GET['Choice_2'];
	if($choice=='1')
	 {
	 	$Class="大一一览表";
	 }
	 else if($choice==2)
	 {
	 	$Class="大二一览表";
	 }
	  else if($choice==3)
	 {
	 	$Class="大三一览表";
	 }
	  else if($choice==4)
	 {
	 	$Class="大四一览表";
	 }
}
else if($_GET['Choice_3'])
{
	  $choice=$_GET['Choice_3'];
	if($choice=='1')
	 {
	 	$Class="大一汇总";
	 }
	 else if($choice==2)
	 {
	 	$Class="大二汇总";
	 }
	  else if($choice==3)
	 {
	 	$Class="大三汇总";
	 }
	  else if($choice==4)
	 {
	 	$Class="大四汇总";
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

<br>
</td>
</tr>

<tr>
<td >

<?php

if($_GET['Choice'] || $_GET['edit_id'] ||$_GET['content_id'])
{    //编辑
	 if($_GET['edit_id'])
	{
		$result=mysql_query("select * from ".$ART_TABLE."teacher_task where id='$_GET[edit_id]'");
		$row=mysql_fetch_array($result);

	}//查看内容
	 if($_GET['content_id'] )
	{
		$result=mysql_query("select * from ".$ART_TABLE."teacher_task where id='$_GET[content_id]'");
		$row=mysql_fetch_array($result);
	}
		$title=$row['title'];
		$content=$row['content'];
		$start_time=$row['start_time'];
		$end_time=$row['end_time'];
	@include "art_set_task.php";
}
//任务一览表
else if($_GET['Choice_2'])
{
$Page_size=6;
if($page==0)
{
	$page=1;
}
$offset=$Page_size*($page-1);
$result=mysql_query("select * from ".$ART_TABLE."teacher_task where teacher='$teacher_id' && class='$choice'");
//echo "select * from ".$ART_TABLE."teacher_task where teacher='$teacher_id' && class='$choice'";
//计算总数
$count = mysql_num_rows($result);
$page_count = ceil($count/$Page_size);
$pages=$page_count;

//分页初始化
?>

<table width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td width="100%"><font color=#FFFFFF ><?PHP echo $Class?></font></td>
</tr>
</table>
<br>
<div id="replace">
<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr><td style="font-size:16px;">任务标题</td><td style="font-size:16px;">任务时间</td><td colspan="2" style="font-size:16px;">用户操作</td></tr>
<?php


$sql = "select * from ".$ART_TABLE."teacher_task where  teacher='$teacher_id' && class='$_GET[Choice_2]' order by id desc  limit $offset,$Page_size";

$result=mysql_query($sql);

if($result)
 {
   while($row=mysql_fetch_array($result))
   {

   	?>
  <tr>
  <td width="30%"><a href="?content_id=<?php echo $row[id]?>"><?php echo $row[title];?></a></td>
  <td width="60%"><?php echo $row['start_time']."----".$row['end_time']?></td>
  <td width="5%"><a href="?edit_id=<?php echo $row[id]?>">编辑</a></td>
  <td width="5%"><a href="?del_id=<?php echo $row[id]?>">删除</a></td>
  </tr>
   	<?
   }
 }
 else{
 	echo "fail";
 	?>
 	<?
 }
?>
</table>
</div>
<?
//分页导航
$key="<div align=\"center\">";
$key.="<span>共 $pages  页</span>";
$key.="<span style='margin-left:20px;'>第 <span id='page'>1</span>  页</span>";
$key.="<span style='margin-left:20px;'><a href='#'id='pre' onclick=\"javascript: pass2('$teacher_id','$choice');\">上一页</a></span>";
$key.="<span style='margin-left:20px;'><a href='#' id='next1' onclick=\"javascript: pass($pages,'$teacher_id','$choice');\">下一页</a></span>";
$key.="</div>";
?>

<?
echo $key;
}
?>


</td>
</tr>
</table>

<?php
if($_POST['submit'])
{
	//任务设置
   if($_GET['Choice'])
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
   //编辑
   else if($_GET['edit_id'])
   {
   	$sql="UPDATE $f SET $key_value WHERE $where";
   	$sql="update ".$ART_TABLE."teacher_task set title='$_POST[title]',content='$_POST[content]',start_time='$_POST[start_time]',end_time='$_POST[end_time]' where id='$_GET[edit_id]'";
	if(mysql_query($sql))
	{
		echo "<script>alert('更新成功');history.go(-2);</script>";
	}
	 else
	{
		echo "<script>alert('更新失败');history.back(1);</script>";
	}
   }
}
?>


<?php
//删除
if($_GET['del_id'])
{
	$s="DELETE FROM ".$ART_TABLE."teacher_task where id='$_GET[del_id]'";

	if(mysql_query($s))
	{
		echo "<script>alert('删除成功');history.go(-1);</script>";
	}
	else
	{
		echo "<script>alert('删除失败');</script>";
	}
}
?>
<?php
 @include($baseDIR."/bysj/inc_foot.php");
?>



