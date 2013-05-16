<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "毕业设计文档审核";
$YM_ZT2 = "指导教师审核学生提交的毕业设计文档";
$YM_MK = "毕业设计答辩管理系统";
$YM_PT = "答辩系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限：指导教师
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<table width=800 border=1 align=center cellpadding=3 bordercolor=#000000>
<tr align=center height=38>
<td width="50">序号</td>
<td>任务</td>
<td width="80">教师</td>
<td width="80">学生</td>
<td width="60">上传者</td>
<td width="60">审核</td>
<td width="60">锁定</td>
<td width="50">修改</td>
<td width="50">删除</td>
</tr>
<?php
   $sql = "select log.id as mid,log.is_check,log.lock_flag,log.student_id as mnumber,list.name as mlname,list.uploader,list.mission_id as mlid,teacher.name as tiname,student.name as ssname,log.teacher_id as histeacher from ".$TABLE."mission_log as log,".$TABLE."mission_list as list,".$TABLE."teacher_information as teacher,".$TABLE."student_sheet as student where log.teacher_id = teacher.teacher_id && log.student_id = student.number && log.mission_id = list.mission_id &&list.year='$CURR_YEAR'&& log.teacher_id = '$teacher_id' order by log.teacher_id, list.name desc";
   //echo $sql;
   $ab = mysql_query($sql);  
$mission_num = 1;
$arr_uploader = array("0"=>"无需上传","1"=>"教师","2"=>"学生"); 
$arr_check = array("-1"=>"<font color = 'red'>未通过</font>","1"=>"已审核","0"=>"<font color = 'green'>待审核</font>");
$arr_lock = array("0"=>"未锁定","1"=>"<font color = 'red'>已锁定</font>");
while($ba = mysql_fetch_array($ab)){
?>
<tr>
<td align="center"><?php echo $mission_num;?></td>
<td><a href="check_suggestion.php?mission_id=<?php echo $ba["mid"]?>" title="查看审核意见"><?php echo $ba["mlname"];?></a></td>
<td><?php echo $ba["tiname"];?></td>
<td><?php echo $ba["ssname"];?></td>
<td align="center"><?php echo $arr_uploader["$ba[uploader]"];?></td>
<td align="center"><?php echo $arr_check["$ba[is_check]"];?></td>
<td align="center"><?php echo $arr_lock["$ba[lock_flag]"];?></td>
<?php
 if($ba["uploader"]==1){
?>
<td align="center"><a href="student_m.php?mission_log=<?php echo $ba["mlid"];?>&student_number=<?php echo $ba["mnumber"];?>&histeacher=<?php echo $ba["histeacher"];?>&sname=<?php echo $ba["ssname"];?>">修改</a></td>
<?php
} else {
   echo "<td>&nbsp;</td>";
}
?>
<td align="center">
<a href="delete.php?id=<?php echo $ba["mid"];?>&student_id=<?php echo $ba["mnumber"];?>" onclick="return confirm('您确定要删除吗？')">删除</a>
</td>
</tr>
<?php
$mission_num = $mission_num+1;
}
?>
</table>
<table width="780" align="center">
<tr>
<td>说明：<br />
<li><b><font color=red>关于审核状态的说明</font></b> 由于在答辩前各项文档均可能变动，所以最终定稿之前的文档审核由指导教师自己严格把关，系室不额外审核，并实行文责自负原则。</li>
<li>学院检查毕业设计进程时，将直接通过本系统查核，不再额外收缴文档，请大家及时更新所有文档</li>
<li><font color=red><b>关于变更选题</b></font> 原则上，变更选题需征询专业主任意见。一旦修改，必须修改“选题系统”中对应的选题信息，再逐个将文档进行全面更新为对应的课题</li>
<?php
/*
<li>如果教师上传的任务文档未通过审核，教师要根据审核意见对文档进行修改后，再上传修改后的文档；</li>
<li>点击任务栏中相应任务的超链接即可查看该任务的审核意见；</li>
<li>如果学生传的任务文档未通过审核，请指导教师联系该同学，并根据审核意见指导该同学。</li>
*/
?>
</td>
</tr>
</table>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

