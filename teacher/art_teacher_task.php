
<script type="text/javascript" src="../js/jquery-1.7.1.js"></script>
<script type="text/javascript">
var i=1;
var teacher;
var cls
var sel;
var gra;
var gra_2;
function pass(max,th,choice,aa,g_aa)
{

   i++;
   teacher=th;
   cls=choice;
   sel=aa;
   gra=g_aa;
  if(i>max)
  {
  	i=max;
  }
}

function pass2(th,choice,bb,g_aa)
{
	i--;
	if(i<1)
	{
		i=1;
	}
	teacher=th;
	cls=choice;
	sel=bb;
	gra=g_aa;
}

function pass3(cc)
{
   gra_2=cc;
}


$(document).ready(function(){

   $("#next1").click(function(){
        document.getElementById("page").innerHTML=i;

           $("#replace").fadeOut(100,function(){
        	$("#replace").fadeIn(1000);
        });

   		$.post("art_task_list.php",{page:i,teacher:teacher,Class:cls,mysel:sel,grade:gra},function(data){
        $("#replace").html(data);
     });



   	});

   $("#pre").click(function(){
        document.getElementById("page").innerHTML=i;
        $("#replace").fadeOut(100,function(){
        $("#replace").fadeIn(1000);
        });

   		$.post("art_task_list.php",{page:i,teacher:teacher,Class:cls,mysel:sel,grade:gra},function(data){
        $("#replace").html(data);
     });

   	});


////////////

  $('#lab1:radio').each(function(){

     if(this.checked)
     {
     	 var a= document.getElementById("lab1").value;
        $.post("art_ybcl.php",{value:a,grade:gra_2},function(data){
        $("#pro_id").html(data);
     });
     }

    });

  $("#lab1").click(function(){
     var a= document.getElementById("lab1").value;
     $.post("art_ybcl.php",{value:a,grade:gra_2},function(data){
        $("#pro_id").html(data);
     });
  });

    $("#lab2").click(function(){
     var a= document.getElementById("lab2").value;
     $.post("art_ybcl.php",{value:a,grade:gra_2},function(data){
        $("#pro_id").html(data);
     });
  });


    $("#submit").click(function(){
   	 var val=$('input:radio[name=RadioGroup2]:checked').val();
   	 if(val==null)
   	 {
   	 	alert("��ѡ����Ŀγ�");
   	 	return false;
   	 }
   });
});
</script>
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
$choice="";//������ѡ��
$Class="";//��Ӧ�ַ�


 ?>





 <?php

$SQL="SELECT * FROM ".$ART_TABLE."teacher_task LEFT JOIN ".$ART_TABLE."major ON ".$ART_TABLE."teacher_task.major_id=".$ART_TABLE."major.id where ".$ART_TABLE."teacher_task.teacher_task='$teacher_id' ";
$SQL3="SELECT art_teacher_task.*,art_major.name From art_teacher_task LEFT JOIN art_major ON art_major.id=art_teacher_task.major_id
WHERE art_teacher_task.grade='$_GET[Choice_3]'  && art_teacher_task.year_task='$year' && art_teacher_task.teacher_task='$teacher_id' ";


if($_GET['Choice'])
{

   $choice=$_GET['Choice'];
   $_SESSION[years]=$year;
	if($choice==1)
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
 else if($_GET['Choice_2'])
{

   $choice=$_GET['Choice_2'];
	if($choice==1)
	 {
	 	$Class="��һһ����";
	 }
	 else if($choice==2)
	 {
	 	$Class="���һ����";
	 }
	  else if($choice==3)
	 {
	 	$Class="����һ����";
	 }
	  else if($choice==4)
	 {
	 	$Class="����һ����";
	 }
	 $SQL.="  && ".$ART_TABLE."teacher_task.year_task='$year' && ".$ART_TABLE."teacher_task.grade='$choice'";

}
else if($_GET['Choice_3'])
{
	  $choice=$_GET['Choice_3'];
	if($choice==1)
	 {
	 	$Class="��һ���ջ���";
	 }
	 else if($choice==2)
	 {
	 	$Class="������ջ���";
	 }
	  else if($choice==3)
	 {
	 	$Class="�������ջ���";
	 }
	  else if($choice==4)
	 {
	 	$Class="�������ջ���";
	 }
	 $result=mysql_query($SQL3);


}
else if($_GET['Choice_4'])
{
	$choice=$_GET['Choice_4'];
	if($choice==1)
	 {
	 	$Class="�����һ������ܱ�";
	 }
	 else if($choice==2)
	 {
	 	$Class="������������ܱ�";
	 }
	  else if($choice==3)
	 {
	 	$Class="�������������ܱ�";
	 }
	  else if($choice==4)
	 {
	 	$Class="�������������ܱ�";
	 }
	$SQL.="  && ".$ART_TABLE."teacher_task.grade='$choice'";
}
else if($_GET['edit_id'])
{
	$SQL.=" && ".$ART_TABLE."teacher_task.task_id='$_GET[edit_id]'";
}
else if($_GET['content_id'])
{
	$SQL.=" && ".$ART_TABLE."teacher_task.task_id='$_GET[content_id]'";
}
else
{
	$Class="δѡ���꼶";
}

?>

<script language="JavaScript" src="/bysj/images/My97DatePicker/WdatePicker.js" defer="defer"></script>
<script language="javascript">
function is_empty(){
	var result=false;
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

<br>
</td>
</tr>

<tr>
<td >

<?php

//echo $SQL3;
if($_GET['Choice'] || $_GET['edit_id'] ||$_GET['content_id'])
{       if(!$_GET['Choice'])
	 {
		$result=mysql_query($SQL);
		$row=mysql_fetch_array($result);

	 }

		$title=$row['title'];
		$content=$row['content'];
		$start_time=$row['start_time'];
		$end_time=$row['end_time'];
		$ZY=$row['class'];
		$pro_id=$row['major_id'];

	@include "art_set_task.php";
}
//����һ����
else
{
$Page_size=6;
if($page==0)
{
	$page=1;
}
$offset=$Page_size*($page-1);

//��ҳ��ʼ��
?>

<table width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td width="100%"><font color=#FFFFFF ><?PHP echo $Class?></font></td>
</tr>
</table>
<br>
<div id="replace">
<?php
if($_GET['Choice_2'] || $_GET['Choice_4'])
{
$result=mysql_query($SQL);
//��������
$count = mysql_num_rows($result);
$page_count = ceil($count/$Page_size);
$pages=$page_count;
if($_GET['Choice_2'])
{
	$sel='2';
	$SQL.=" order by ".$ART_TABLE."teacher_task.task_id desc limit $offset,$Page_size ";
}
else if($_GET['Choice_4'])
{
	$sel='4';
	$SQL.=" order by ".$ART_TABLE."teacher_task.task_id asc limit $offset,$Page_size ";
}

?>
<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr><td style="font-size:16px;">�������</td><td style="font-size:16px;">����ʱ��</td><td align="center">�γ�����</td><td colspan="2" style="font-size:16px;">�û�����</td></tr>
<?php

$result=mysql_query($SQL);
if($result)
 {
   while($row=mysql_fetch_array($result))
   {
   	?>
  <tr>
  <td width="20%"><a href="?content_id=<?php echo $row[task_id]?>"><?php echo $row[title];?></a></td>
  <td width="60%"><?php echo $row['start_time']."----".$row['end_time']?></td>
  <td width="10%" align="center"><?php echo $row['name']?></td>
  <td width="5%"><a <?php if(!$_GET['Choice_4']){?>href="?edit_id=<?php echo $row[task_id];}?>">�༭</a></td>
  <td width="5%"><a <?php if(!$_GET['Choice_4']){?>href="?del_id=<?php echo $row[task_id]; }?>">ɾ��</a></td>
  </tr>
   	<?
   }
 }
 else{
 	echo "fail";
     }
 	?>
</table>
<?php
}
else if($_GET['Choice_3'])
{
	$sel="3";
	$result=mysql_query($SQL3);
//��������
$count = mysql_num_rows($result);
$page_count = ceil($count/$Page_size);
$pages=$page_count;

?>
<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr><td style="font-size:16px;">�༶</td><td style="font-size:16px;">�γ�����</td><td align="center">�������</td><td style="font-size:16px;" align="center">�û�����</td></tr>
<?php
$SQL3.=" order by ".$ART_TABLE."teacher_task.task_id desc limit $offset,$Page_size ";
 $result=mysql_query($SQL3);
if($result)
 {
   while($row=mysql_fetch_array($result))
   {
   	?>
  <tr>
  <td width="25%"><?php if($row['class']==20){echo "����ѧ";} else{echo "���ֱ���";}?></td>
  <td width="25%" ><?php echo $row['name']?></td>
  <td width="40%"><a href="?content_id=<?php echo $row[task_id]?>"><?php echo $row[title];?></a></td>
  <td width="10%" align="center"><a href="?down_id=<?php echo $row[task_id]?>">����</a></td>
  </tr>
   	<?
   }
 }
 else{
 	echo "fail";
     }
 	?>
</table>
<?php
}

?>
</div>
<?
//��ҳ����
$key="<div align=\"center\">";
$key.="<span>�� $pages  ҳ</span>";
$key.="<span style='margin-left:20px;'>�� <span id='page'>1</span>  ҳ</span>";
$key.="<span style='margin-left:20px;'><a href='#'id='pre' onclick=\"javascript: pass2('$teacher_id','$year','$sel','$choice');\">��һҳ</a></span>";
$key.="<span style='margin-left:20px;'><a href='#' id='next1' onclick=\"javascript: pass($pages,'$teacher_id','$year','$sel','$choice');\">��һҳ</a></span>";
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
if($_POST['submit'] ||$_POST['submit1'])
{
	//��������
   if($_GET['Choice'])
   {

	$sql="insert into ".$ART_TABLE."teacher_task(title,content,start_time,end_time,teacher_task,year_task,class,major_id,grade)"."values('$_POST[title]','$_POST[content]','$_POST[start_time]','$_POST[end_time]','$teacher_id','$year','$_POST[RadioGroup1]','$_POST[RadioGroup2]','$choice')";

     $result=mysql_query($sql);

    // $id=mysql_insert_id();
	if($result)
	{

		echo "<script>alert('���óɹ�')</script>";
	}
		else
	{
			//$s="DELETE FROM ".$ART_TABLE."teacher_task where task_id='$id'";
			//mysql_query($s);
			echo "<script>alert('����ʧ��');history.back(1);</script>";
	}
	}
	 else
	{
		echo "<script>alert('����ʧ��');history.back(1);</script>";
	}

   }
   //�༭
   else if($_GET['edit_id'])
   {

   	$sql="update ".$ART_TABLE."teacher_task set title='$_POST[title]',content='$_POST[content]',start_time='$_POST[start_time]',end_time='$_POST[end_time]' where task_id='$_GET[edit_id]'";

	if(mysql_query($sql))
	{
		echo "<script>alert('���³ɹ�');history.go(-2);</script>";
	}
	 else
	{
		echo "<script>alert('����ʧ��');history.back(1);</script>";
	}
   }

?>


<?php
//ɾ��
if($_GET['del_id'])
{
	$s="DELETE FROM ".$ART_TABLE."teacher_task where task_id='$_GET[del_id]'";

	if(mysql_query($s))
	{
		echo "<script>alert('ɾ���ɹ�');history.go(-1);</script>";
	}
	else
	{
		echo "<script>alert('ɾ��ʧ��');</script>";
	}
}
if($_GET[aa])
{


	$original_dir="./zip/";
	$new_dir="./art/";
    $arr=array("�½��ı��ĵ�.txt","��Ӱ.txt");

    $archive  = new PHPZip();
    $archive->select_file($original_dir,$new_dir,$arr);
    $archive->ZipAndDownload($new_dir);
    $archive->delete_file($new_dir);
}
if($_GET['down_id'])
{
	$dsql="SELECT title,file_name ,student_num,profession,art_major.name,bysj_student_sheet.NAME  FROM `art_teacher_task`
 LEFT JOIN art_student_task ON art_teacher_task.task_id=art_student_task.task_id
 LEFT JOIN art_major ON art_major.id=art_teacher_task.major_id
 LEFT JOIN bysj_student_sheet ON student_num=number
 where  art_teacher_task.task_id='5'";
 $result=mysql_query($dsql);
 $row=mysql_fetch_array($result);
 echo $row[name].$row[NAME];
 /*
  include("ART_PHPZip.php");
  $original_dir=$baseDIR."/bysj/student_homework/";
  $new_dir=$baseDIR."/bysj/homework/";
  $archive  = new ART_PHPZip();
  */
}
?>
<?php
 @include($baseDIR."/bysj/inc_foot.php");
?>



