<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "��ҵ����ĵ����";
$YM_ZT2 = "ָ����ʦ���ѧ���ύ�ı�ҵ����ĵ�";
$YM_MK = "��ҵ��ƴ�����ϵͳ";
$YM_PT = "���ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ�ޣ�ָ����ʦ
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<table width=800 border=1 align=center cellpadding=3 bordercolor=#000000>
<tr align=center height=38>
<td width="50">���</td>
<td>����</td>
<td width="80">��ʦ</td>
<td width="80">ѧ��</td>
<td width="60">�ϴ���</td>
<td width="60">���</td>
<td width="60">����</td>
<td width="50">�޸�</td>
<td width="50">ɾ��</td>
</tr>
<?php
   $sql = "select log.id as mid,log.is_check,log.lock_flag,log.student_id as mnumber,list.name as mlname,list.uploader,list.mission_id as mlid,teacher.name as tiname,student.name as ssname,log.teacher_id as histeacher from ".$TABLE."mission_log as log,".$TABLE."mission_list as list,".$TABLE."teacher_information as teacher,".$TABLE."student_sheet as student where log.teacher_id = teacher.teacher_id && log.student_id = student.number && log.mission_id = list.mission_id &&list.year='$CURR_YEAR'&& log.teacher_id = '$teacher_id' order by log.teacher_id, list.name desc";
   //echo $sql;
   $ab = mysql_query($sql);  
$mission_num = 1;
$arr_uploader = array("0"=>"�����ϴ�","1"=>"��ʦ","2"=>"ѧ��"); 
$arr_check = array("-1"=>"<font color = 'red'>δͨ��</font>","1"=>"�����","0"=>"<font color = 'green'>�����</font>");
$arr_lock = array("0"=>"δ����","1"=>"<font color = 'red'>������</font>");
while($ba = mysql_fetch_array($ab)){
?>
<tr>
<td align="center"><?php echo $mission_num;?></td>
<td><a href="check_suggestion.php?mission_id=<?php echo $ba["mid"]?>" title="�鿴������"><?php echo $ba["mlname"];?></a></td>
<td><?php echo $ba["tiname"];?></td>
<td><?php echo $ba["ssname"];?></td>
<td align="center"><?php echo $arr_uploader["$ba[uploader]"];?></td>
<td align="center"><?php echo $arr_check["$ba[is_check]"];?></td>
<td align="center"><?php echo $arr_lock["$ba[lock_flag]"];?></td>
<?php
 if($ba["uploader"]==1){
?>
<td align="center"><a href="student_m.php?mission_log=<?php echo $ba["mlid"];?>&student_number=<?php echo $ba["mnumber"];?>&histeacher=<?php echo $ba["histeacher"];?>&sname=<?php echo $ba["ssname"];?>">�޸�</a></td>
<?php
} else {
   echo "<td>&nbsp;</td>";
}
?>
<td align="center">
<a href="delete.php?id=<?php echo $ba["mid"];?>&student_id=<?php echo $ba["mnumber"];?>" onclick="return confirm('��ȷ��Ҫɾ����')">ɾ��</a>
</td>
</tr>
<?php
$mission_num = $mission_num+1;
}
?>
</table>
<table width="780" align="center">
<tr>
<td>˵����<br />
<li><b><font color=red>�������״̬��˵��</font></b> �����ڴ��ǰ�����ĵ������ܱ䶯���������ն���֮ǰ���ĵ������ָ����ʦ�Լ��ϸ�ѹأ�ϵ�Ҳ�������ˣ���ʵ�������Ը�ԭ��</li>
<li>ѧԺ����ҵ��ƽ���ʱ����ֱ��ͨ����ϵͳ��ˣ����ٶ����ս��ĵ������Ҽ�ʱ���������ĵ�</li>
<li><font color=red><b>���ڱ��ѡ��</b></font> ԭ���ϣ����ѡ������ѯרҵ���������һ���޸ģ������޸ġ�ѡ��ϵͳ���ж�Ӧ��ѡ����Ϣ����������ĵ�����ȫ�����Ϊ��Ӧ�Ŀ���</li>
<?php
/*
<li>�����ʦ�ϴ��������ĵ�δͨ����ˣ���ʦҪ�������������ĵ������޸ĺ����ϴ��޸ĺ���ĵ���</li>
<li>�������������Ӧ����ĳ����Ӽ��ɲ鿴���������������</li>
<li>���ѧ�����������ĵ�δͨ����ˣ���ָ����ʦ��ϵ��ͬѧ��������������ָ����ͬѧ��</li>
*/
?>
</td>
</tr>
</table>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

