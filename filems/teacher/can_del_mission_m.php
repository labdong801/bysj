<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "����ĵ�Ҫ��";
$YM_ZT2 = "��ӱ�ҵ����ĵ�";
$YM_MK = "��ҵ����ĵ�����ϵͳ";
$YM_PT = "�ĵ�ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 80; //��ҳ������ҪȨ�ޣ�����Ա
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
<script language="javascript">
function is_value(){
  if(myform.name.value==""){
   alert("�����ĵ����Ʋ���Ϊ�գ�");
   return false;  
  }
  if(myform.address.value==""){
   alert("�����ַ����Ϊ�գ�");
   return false;  
  }  
  if(myform.start_time.value==""){
   alert("����ʼʱ�䲻��Ϊ�գ�");
   return false;  
  }  
  if(myform.end_time.value==""){
   alert("�����ֹʱ�䲻��Ϊ�գ�");
   return false;  
  }  
}
</script>

<form name="myform" method="post" action="" enctype="multipart/form-data">
<table width="700" align="center" border="1" bordercolor=#000000  cellpadding="6">
<tr>
  <td colspan="4">����������񵽣�
  <?php
  for($i=$YEAR_C;$i>=$YEAR_S;$i--){
  	if($i==$CURR_YEAR){
  		$s1 = " checked";
  		$s2 = "<font size=+1><b>".$i."���</b></font>";
  	} else {
  		$s1 = "";
  		$s2 = $i."���";
  	}
  	echo "&nbsp;&nbsp;<input name=year type=radio $s1 value='$i'> ".$s2;
  }
  ?></td>
 </tr>	
 <tr>
  <td>�ĵ����ƣ�</td>
  <td><input name="name" type="text" size="20" /></td>
  <td align=right>����Ŀ¼����ƴ����</td>
  <td><input name="address" type="text" size="20" /></td>
 </tr>
 <tr>
  <td>�ĵ��ϴ��ߣ�</td>
  <td colspan="3">
  	<input type="radio" name="target" value="1" />�ɽ�ʦ�ϴ�&nbsp;&nbsp;
  	<input type="radio" name="target" value="0" checked />��ѧ���ϴ�&nbsp;&nbsp;
  </td>
 </tr>
 <tr>
  <td rowspan=2>���ĵ���<br>��׼��ʽ�ο���</td>
  <td colspan="3">����ࣺ<input type="file" name="design" /></td>
 </tr>
 <tr>
    <td colspan="3">����ѧ�о����ҵ���ĸ�ʽ�������벹��������ο��ĵ���<br>�����ࣺ<input type="file" name="paper" /></td>
 </tr>
 <tr>
  <td>�ĵ����ݣ�<br>ʱ�䡢�ص�����<br>��˵����</td>
  <td colspan="3"><textarea name="demonstration" cols="60" rows="8"  wrap="virtual"></textarea></td>
 </tr>
 <tr>
  <td>����ʼʱ�䣺</td>
  <td><input name="start_time" type="text" size="20" / value="<?php echo date("Y-m-d");?>"></td>
  <td>�����ֹʱ�䣺</td>
  <td><input name="end_time" type="text" size="20" / value="<?php echo date("Y-m-d",time(0)+7*86400);?>"></td>
 </tr>
 <tr>
  <td>�ο��ĵ��鿴Ȩ����</td>
  <td colspan="3"><input type="radio" name="allow" value="1" />����ʦ�ɿ�&nbsp;&nbsp;<input type="radio" name="allow" value="2" />��ѧ���ɿ�&nbsp;&nbsp;<input type="radio" name="allow" value="0" checked="checked"/>���߾��ɿ�
  </td>
 </tr>
 <tr>
  <td colspan="7">��ӡʱ�䣺<input name="print_time" type="text" size="20" />&nbsp;&nbsp;ֽ�ͣ�<select name="paper_type"><option value="A4">A4</option><option value="16K">16K</option></select>&nbsp;&nbsp;������<input type="text" name="paper_num" size="20" /></td>
 </tr>
</table>
<input type="submit" name="submit" value="�ύ�µ��ĵ�" onclick="return is_value()"/>
</form>
<table width="600" align="center">
 <tr>
  <td>
   ˵����
    <li>���Ҫ�ύ�ĵ�ǰ����Ϊ��i������Ļ��������ַӦΪ��mission_logi�������1�����񣬱���ĵ�ַΪ��mission_log1��</li>
	<li>�ĵ��ϴ��ߵ�ѡ��ť���У�ѡ�񡾽�ʦ����ʾ������Ҫ���ʦ�ϴ��ĵ���ѡ��ѧ������ʾ������Ҫ��ѧ���ϴ��ĵ���</li>
	<li>�ο��ĵ���ѡ��ť���У�ѡ�񡾽�ʦ����ʾ��ʦ��Ȩ�鿴�ο��ĵ���ѡ��ѧ������ʾѧ����Ȩ�鿴�ο��ĵ���ѡ�����߾��ɿ�����ʾ��ʦ��ѧ������Ȩ�鿴�ο��ĵ���</li>
    <li><font color="#FF0000">ʱ��������ʽΪ��XXXX-XX-XX����2009-01-01��</font></li>
  </td>
 </tr>
</table>

<?php
 if($_POST["submit"]!=""){
   $mission_name = $_POST["name"];
   $address = $_POST["address"];
   $target = $_POST["target"];
   $demonstration = $_POST["demonstration"];
   $start_time = $_POST["start_time"];
   $end_time = $_POST["end_time"];
   $allow = $_POST["allow"];
   $print_time = $_POST["print_time"];
   $paper_type = $_POST["paper_type"];
   $paper_num = $_POST["paper_num"];
   $year = $_POST["year"];
   $filename1 = "";
   $filename2 = "";

         if(!file_exists("../../../Docs/".$year)){
             $kk = mkdir("../../../Docs/".$year,0700);
         }
   
   if(is_uploaded_file($_FILES["design"]["tmp_name"]) or is_uploaded_file($_FILES["paper"]["tmp_name"])){
      $error1 = $upfile["error"];
      $error2 = $upload["error"];
      if($error1==0){ 
         $upfile = $_FILES["design"];
         $name_1 = $upfile["name"];
         $tmp_name1 = $upfile["tmp_name"];
         $tmp_type1=".".substr(strrchr($name_1,"."),1);
         $filename1 = $address."_design".$tmp_type1;

         $destination1 = "../../../Docs/".$year."/".$filename1;
          move_uploaded_file($tmp_name1,$destination1);
      }
      if($error2==0){ 
         $upload = $_FILES["paper"];
         $name_2 = $upload["name"];
         $tmp_name2 = $upload["tmp_name"];
         $tmp_type2=".".substr(strrchr($name_2,"."),1);
         $filename2 = $address."_pager".$tmp_type2;
         $destination2 = "../../../Docs/".$year."/".$filename2;
          move_uploaded_file($tmp_name2,$destination2);
      }
   }
   $sql = "insert into ".$TABLE."mission_list(
           name,address,uploader,demonstration,start_time,end_time,watch_authority,
           print_time,paper_type,paper_num,filename1,filename2,year
        ) values (
           '$mission_name','$address','$target','$demonstration','$start_time','$end_time','$allow',
           '$print_time','$paper_type','$paper_num','$filename1','$filename2','$year'
        )";
   if(mysql_query($sql)){
   	  if($filename1!=""||$filename2!=""){
   	     $msg = "�ɹ��ϴ���".$mission_name."���Ĳο��ĵ�";
   	  }
   	  echo "<script>alert('".$msg."\\n\\n�µ��ĵ������ύ�ɹ���');history.back();</script>";
   }else{
      echo "<script>alert('�ĵ������ύʧ�ܣ�');history.back();</script>";
   }
   //echo $sql;
 }
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
