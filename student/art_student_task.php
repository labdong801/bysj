
<?php
$self= $PHP_SELF;//�ļ���Ե�ַ
$filename = $_SERVER["SCRIPT_FILENAME"];//��ȡ�ļ����Ե�ַ
$loc= strpos($filename,$self);//�Լ���Ե�ַ�ھ��Ե�ַ�г��ֵ�λ��
$baseDIR = substr($filename,0,$loc);//������ַ
$YM_ZT = "ѧ����ѯ";
$YM_ZT2 = "ѧ�������ѯ";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_PT ="�����ѯ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 1; //����ԱȨ��
include($baseDIR."/bysj/inc_head.php");
$student_id = $com_id;
$Grade=$grade+2000;
$Class=JC($Grade);
 ?>

<table width="100%" align="center">

<tr>
<td >


<table width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td width="100%"><font color=#FFFFFF >ѧ������</font></td>
</tr>
</table>
<br>

<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr><td style="font-size:16px;">��������</td><td style="font-size:16px;">����ʱ��</td><td style="font-size:16px;" align="center">�Ƿ��Ͻ�</td><td style="font-size:16px;">����</td></tr>
<?php


$sql = "select * from ".$ART_TABLE."teacher_task where  class='$Class' order by id desc";
$result=mysql_query($sql);
if($result)
 {
   while($row=mysql_fetch_array($result))
   {
   	?>
  <tr>
  <td width="30%"><a href="?content_id=<?php echo $row[id]?>"><?php echo $row[title];?></a></td>
  <td width="50%"><?php echo $row['start_time']."----".$row['end_time']?></td>
  <td width="10%" align="center"><a href="?edit_id=<?php echo $row[id]?>">��</a></td>
  <td width="5%"><a href="?del_id=<?php echo $row[id]?>">�Ͻ�</a></td>
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



</td>
</tr>
</table>

<?php
if($_POST['submit'])
{
	//��������
   if($_GET['Choice'])
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
   //�༭
   else if($_GET['edit_id'])
   {
   	$sql="UPDATE $f SET $key_value WHERE $where";
   	$sql="update ".$ART_TABLE."teacher_task set title='$_POST[title]',content='$_POST[content]',start_time='$_POST[start_time]',end_time='$_POST[end_time]' where id='$_GET[edit_id]'";
	if(mysql_query($sql))
	{
		echo "<script>alert('���³ɹ�');history.go(-2);</script>";
	}
	 else
	{
		echo "<script>alert('����ʧ��');history.back(1);</script>";
	}
   }
}
?>


<?php
//ɾ��
if($_GET['del_id'])
{
	$s="DELETE FROM ".$ART_TABLE."teacher_task where id='$_GET[del_id]'";

	if(mysql_query($s))
	{
		echo "<script>alert('ɾ���ɹ�');history.go(-1);</script>";
	}
	else
	{
		echo "<script>alert('ɾ��ʧ��');</script>";
	}
}

?>

<?
//�ж����� ��ͣ���һ�����...��
 function JC($year)
{
	$time=date("Y");
   $mothe=date("m");
   $grade=$time-$year;

if($mothe<9)
  {

  }
  else if($mothe>=9)
  {
    $grade=$grade+1;
  }
  return $grade;
}

?>


<?php
 @include($baseDIR."/bysj/inc_foot.php");
?>



