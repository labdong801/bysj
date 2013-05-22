<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "查看意见与建议";
$YM_ZT2 = "查看意见和建议";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 80; //本页访问需要权限:普通教师
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<?php
 function disEnter($content){
   $content = str_replace("\n","<br>",$content);
   return $content;
 }
?>
<table width="700" border="1"  bordercolor=#000000  cellpadding="3">
<?php
 if($page==""){
  $page = 1;
 }
 if(is_numeric($page)){
   $page_size = 5;
   $query = mysql_query("select count(*) as total from ".$TABLE."suggestion order by id desc");
   $total_message = mysql_result($query,0,"total");//总记录条数
   $total_page = ceil($total_message/$page_size);//总页数
   $start_count = ($page-1)*$page_size;////计算下一页从第几条数据开始循环
 }
 $ta = mysql_query("select * from ".$TABLE."suggestion order by id desc limit $start_count,$page_size");
 while($taa = mysql_fetch_array($ta)){
 ?>
 <tr>
  <td bgColor=#5a6e8f><font color=#FFFFFF>提交者帐号：<?php
  	 $id = $taa["account"];
  	 if(strlen($id)>9){
  	 	$iii = mysql_query("select class,name from ".$TABLE."student_sheet where number='$id'");
  	 	$jjj = mysql_fetch_array($iii);
  	 	$name = $jjj["class"].$jjj["name"];
  	}else{
  	 	$iii = mysql_query("select name from ".$TABLE."teacher_information where teacher_id='$id'");
  	 	$jjj = mysql_fetch_array($iii);
  	 	$name = $jjj["name"];
  	}
  	echo "<b>".$name."</b>";
  	 ?></font></td>
 </tr>
 <tr>
  <td height=58><? echo disEnter($taa["advise"])?></td>
 </tr>
 <?php
   if($taa["answer"]=="0"){
 ?>
 <tr>
  <td><a href="answer_suggestion.php?id=<?php echo $taa["id"];?>">回复</a>&nbsp;
      <a href="delete_suggestion.php?id=<?php echo $taa["id"];?>" onclick="return confirm('您确定要删除吗？')"><font color=blue><u>删除</u></font></a></td>
 </tr>
 <tr>
  <td>&nbsp;</td>
 </tr>
 <?php
 }else{
 ?>
 <tr >
  <td>回复：<a href="delete_suggestion.php?id=<?php echo $taa["id"];?>" onclick="return confirm('您确定要删除吗？')"><font color=blue><u>删除</u></font></a></td>
 </tr>
  <tr>
  <td><? echo disEnter($taa["answer"]);?></td>
 </tr>
 <tr>
  <td>&nbsp;</td>
 </tr>
 <?php
 }
 ?>
<?php
}
?>
<tr>
<td align="left">
&nbsp;&nbsp;页次：<?php echo $page;?>/<?php echo $total_page;?>页&nbsp;记录：<?php echo "<font color = 'red'>".$total_message."</font>";?> 条&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
 if($page!=1){  //如果当前页不是首页
 echo  "<a href=watch_suggestion.php?page=1>&nbsp;&nbsp;首页</a>&nbsp;";//显示“首页”超链接
 echo "<a href=watch_suggestion.php?page=".($page-1).">上一页</a>&nbsp;";//显示“上一页”超链接
 if($page==$total_page) {
  echo "下一页&nbsp;"."尾页";
 }
 }
 if($page<$total_page){  //如果当前页不是尾页
  if($page==1) {
   echo "&nbsp;&nbsp;首页&nbsp;"."上一页&nbsp;";
  }
 echo "<a href=watch_suggestion.php?page=".($page+1).">下一页</a>&nbsp;";//显示“下一页”超链接 
 echo  "<a href=watch_suggestion.php?page=".$total_page.">尾页</a>";//显示“尾页”超链接
 }
?>&nbsp;&nbsp;
</td>
</tr>
</table>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>