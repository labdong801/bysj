<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�鿴����뽨��";
$YM_ZT2 = "�鿴����ͽ���";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 80; //��ҳ������ҪȨ��:��ͨ��ʦ
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
   $total_message = mysql_result($query,0,"total");//�ܼ�¼����
   $total_page = ceil($total_message/$page_size);//��ҳ��
   $start_count = ($page-1)*$page_size;////������һҳ�ӵڼ������ݿ�ʼѭ��
 }
 $ta = mysql_query("select * from ".$TABLE."suggestion order by id desc limit $start_count,$page_size");
 while($taa = mysql_fetch_array($ta)){
 ?>
 <tr>
  <td bgColor=#5a6e8f><font color=#FFFFFF>�ύ���ʺţ�<?php
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
  <td><a href="answer_suggestion.php?id=<?php echo $taa["id"];?>">�ظ�</a>&nbsp;
      <a href="delete_suggestion.php?id=<?php echo $taa["id"];?>" onclick="return confirm('��ȷ��Ҫɾ����')"><font color=blue><u>ɾ��</u></font></a></td>
 </tr>
 <tr>
  <td>&nbsp;</td>
 </tr>
 <?php
 }else{
 ?>
 <tr >
  <td>�ظ���<a href="delete_suggestion.php?id=<?php echo $taa["id"];?>" onclick="return confirm('��ȷ��Ҫɾ����')"><font color=blue><u>ɾ��</u></font></a></td>
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
&nbsp;&nbsp;ҳ�Σ�<?php echo $page;?>/<?php echo $total_page;?>ҳ&nbsp;��¼��<?php echo "<font color = 'red'>".$total_message."</font>";?> ��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
 if($page!=1){  //�����ǰҳ������ҳ
 echo  "<a href=watch_suggestion.php?page=1>&nbsp;&nbsp;��ҳ</a>&nbsp;";//��ʾ����ҳ��������
 echo "<a href=watch_suggestion.php?page=".($page-1).">��һҳ</a>&nbsp;";//��ʾ����һҳ��������
 if($page==$total_page) {
  echo "��һҳ&nbsp;"."βҳ";
 }
 }
 if($page<$total_page){  //�����ǰҳ����βҳ
  if($page==1) {
   echo "&nbsp;&nbsp;��ҳ&nbsp;"."��һҳ&nbsp;";
  }
 echo "<a href=watch_suggestion.php?page=".($page+1).">��һҳ</a>&nbsp;";//��ʾ����һҳ�������� 
 echo  "<a href=watch_suggestion.php?page=".$total_page.">βҳ</a>";//��ʾ��βҳ��������
 }
?>&nbsp;&nbsp;
</td>
</tr>
</table>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>