<?php
$self= $PHP_SELF;//�ļ���Ե�ַ

$filename = $_SERVER["SCRIPT_FILENAME"];//��ȡ�ļ����Ե�ַ
$loc= strpos($filename,$self);//�Լ���Ե�ַ�ھ��Ե�ַ�г��ֵ�λ��
$baseDIR = substr($filename,0,$loc);//������ַ

$YM_ZT = "��ʦ����";
$YM_ZT2 = "��ʦָ��ѧ����������";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_PT ="��ʦ�����´�";
$YM_DH = 1; //��Ҫ������
$YM_QX = 90; //����ԱȨ��
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
	 	$Class="��һ�����´�";
	 }
	 else if($choice==2)
	 {
	 	$Class="��������´�";
	 }
	  else if($choice==3)
	 {
	 	$Class="���������´�";
	 }
	  else if($choice==4)
	 {
	 	$Class="���������´�";
	 }
}
if($_GET['Choice_1'])
{

   $choice=$_GET['Choice_2'];
	if($choice=='1')
	 {
	 	$Class="��һ�����´�";
	 }
	 else if($choice==2)
	 {
	 	$Class="��������´�";
	 }
	  else if($choice==3)
	 {
	 	$Class="���������´�";
	 }
	  else if($choice==4)
	 {
	 	$Class="���������´�";
	 }
}
else
{
	$Class="δѡ���꼶";
}
?>
<script language="JavaScript" src="/bysj/images/My97DatePicker/WdatePicker.js" defer="defer"></script>
<script language="javascript">
function is_empty(){
	if(taskform.title.value=="")
	{
		alert("��ʦ�ύ������ⲻ��Ϊ��");
		taskform.title.focus();
		return false;
	}

    if(taskform.content.value=="")
    {
    	alert("��ʦ�ύ�������ݲ���Ϊ��");
    	taskform.content.focus();
    	return false;
    }


    if(taskform.start_time.value==""){
       alert("��ʦ�ύ������ʼʱ���ܲ�Ϊ��");
       taskform.start_time.focus();
	   return false;
     }
     if(taskform.end_time.value==""){
       alert("��ʦ�ύ�����ֹʱ�䲻��Ϊ��");
       taskform.end_time.focus();
	   return false;
     }

  if(taskform.end_time.value<taskform.start_time.value){
    alert("��ʦ�ύ����ʼʱ�����ڽ�ֹʱ�䣬������");
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
	echo "<a href=".$PHP_SELF."?select_year=".$YEAR_C."><font color=blue><u>�鿴".$YEAR_C."��(����)ѡ��</u></font></a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   �鿴���������";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) echo "<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$i."��</u></font></a> ";
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	?>
	&nbsp;<br>&nbsp;<br>


<table width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<?php
 if($choice !="")
 {
 ?>

<tr align="center" bgColor=#5a6e8f  height=38>

<td width="20%"><font color=#FFFFFF ><?PHP echo $Class?></font></td><td><font color=#FFFFFF size=+1>ָ����ʦ�����´�</font></td>
</tr>
<?php
 //������ѡ���
 if($_GET['select_year'])
 {
 	$year = $_GET['select_year'];
 }
 else
 {
 	$year = date("Y",mktime(0,0,0,date("m")-8,1,date("Y"))); //
 	/*
 	 * ��ѧ����� ����ǰ��ݼ�8���£�
 	 * eg:
 	 * ������ 2013��6�� ������2012ѧ��ڶ����ڡ����� $art_select_year = 2012
 	 * ������2013��9�£�����2013���һѧ�ڡ�����$art_select_year =2013
 	 * */
 }
?>

 <?php
 } else
 {
 	?>
 <tr align="center" bgColor=#5a6e8f  height=38>
<td><font color=#FFFFFF size=+1>��ѡ����Ĳ���</font></td>
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
<td>�������:</td><td><input type="text" name="title"></td>
</tr>

<tr>
<td>��������:</td><td><textarea name="content" rows="6"cols="80"></textarea></td>
</tr>

<tr>
<td>����ʱ��:</td>
<td>
<table width="100%" border="0">
<tr>
<td>��ʼʱ��:<input type="text" name="start_time"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"></td>
</tr>
<tr>
<td>��ֹʱ��:<input type="text" name="end_time"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"></td>
</tr>
</table>
</td>
</tr>

<tr>
<td colspan="2">
<input type="submit" value="�ύ" name="submit">
<input type="reset" value="����" name="reset">
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
		echo "<script>alert('���óɹ�')</script>";
	}
	 else
	{
		echo "<script>alert('����ʧ��');history.back(1);</script>";
	}

}
?>
<?php
 @include($baseDIR."/bysj/inc_foot.php");
?>

