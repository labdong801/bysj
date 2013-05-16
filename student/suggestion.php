<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "建议意见";
$YM_ZT2 = "欢迎提交您的意见和建议";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 1; //本页访问需要权限：普通学生
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;
 ?>
 <script language="javascript">
function is_empty(){
 if(form1.advise.value==""){
   alert("提交的意见和建议不能为空！");
   return false;
 }
}
</script>

<table width="600" align="center"    cellpadding=5  bordercolor=#000000 border=0>
<tr>
<td><font color="#FF0000">如果您对本系统存在什么意见和建议，请您给我们留言，我们会尽力改进本系统存在的不足，以便更好地满足大家的需求</font>
</td>
</tr>
</table>
<p>
<table width="600" border="1" align="center"     cellpadding=5  bordercolor=#000000>
<?php
 function disEnter($str){
   $content = str_replace("\n","<br>",$str);
   return $content;
 }
 $ak = mysql_query("select * from ".$TABLE."suggestion where account = '$number'");
?>
<?php
 while($ka = mysql_fetch_array($ak)){
?>
<tr>
<td bgColor=#5a6e8f><font color=#FFFFFF>建议</font></td>
</tr>
<tr>
<td><? echo disEnter($ka["advise"]);?></td>
</tr>
<tr>
<td><a href="../teacher/delete_suggestion.php?id=<?php echo $ka["id"];?>" onclick="return confirm('您确定要删除吗？')">删除</a></td>
</tr>
<?php
if($ka["answer"]!="0"){
?>
<tr>
<td bgcolor="#999999">回复:</td>
</tr>
<tr>
<td><? echo disEnter($ka["answer"]);?></td>
</tr>
<?php
}
}
?>
</table>
<form name="form1" action="" method="post">
<table width="600" border="1" align="center"     cellpadding=5  bordercolor=#000000>
<tr>
<td><div align="center" class="STYLE1">您的意见和建议</div></td>
</tr>
<tr>
<td align="center"><textarea name="advise" cols="60" rows="8"  wrap="virtual"></textarea></td>
</tr>
<tr>
<td align="center"><input type="submit" name="submit" value="提交" onclick="return is_empty()"/></td>
</tr>
</table>
</form>
<?php
 if($_POST["submit"]){
   $advise = $_POST["advise"];
   $sql = mysql_query("insert into ".$TABLE."suggestion(account,advise,answer) values ('$number','$advise','0')");
   if($sql){
     echo "<script>alert('数据提交成功，感谢您的意见和建议！');history.back();</script>";
   }else{
     echo "<script>alert('数据提交失败！');history.back();</script>";
   }
 }
?>


<?
  @include($baseDIR."/bysj/inc_foot.php");
?>
