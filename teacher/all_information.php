<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "��˱���ѡ��";
$YM_ZT2 = "��˱�ҵ��ƣ����ģ�����";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 40; //��ҳ������ҪȨ��
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<?php
	$shv = array("-1","1","0","all");
	$shs = array("δͨ�����","��ͨ�����","�����","ȫ��ѡ��");

	for($i=0;$i<sizeof($shv);$i++){
		if($shv[$i]==$shenhe) break;
	}
	if($i==sizeof($shv)) $shenhe = "0";
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	
	echo "<a href=".$PHP_SELF."?select_year=".$YEAR_C."&shenhe=".$shenhe."><font color=blue><u>�鿴".$YEAR_C."��(����)ѡ��</u></font></a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   �鿴����ѡ�⣺";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) echo "<a href=".$PHP_SELF."?select_year=".$i."&shenhe=".$shenhe."><font color=blue><u>".$i."��</u></font></a> ";
	?>	
<table width="98%" align="center" border=0 cellpadding=8  >
<?php	
    $verify=$shenhe;
    $tiaojian = "";    	 
    if($shenhe=="all") {
    	;
    } else if($shenhe=="1") {
    	$tiaojian = "&& verify >0 ";
    } else  if($shenhe!=""){
    	$tiaojian = "&& verify = ".$shenhe;
    } 

   echo "<tr><td align=center>";
   echo "�鿴�ض�ѡ�⣺";
	for($i=0;$i<sizeof($shv);$i++){
		if($shenhe == $shv[$i]) echo "[<b>".$shs[$i]."</b>]";
		else echo "[<a href=".$PHP_SELF."?select_year=".$select_year."&shenhe=".$shv[$i]."><font color=blue><u>".$shs[$i]."</u></font></a>]";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
	}
?>	
</table>	
<br>
<table width=98% border="1" align="center"   cellpadding=5 bordercolor=#000000>
<tr align="center"  bgColor=#5a6e8f  height=38>
<td width=38><font color=#FFFFFF><b>���</b></font></td>
<td width=50><font color=#FFFFFF><b>��ʦ</b></font></td>
<td><font color=#FFFFFF size=+1><b> [ <?php echo $select_year; ?> ��] ��ҵ��ƺ�ѡ��Ŀ</b></font></td>
<td width=50><font color=#FFFFFF><b>���</b></font></td>
<td width=50><font color=#FFFFFF><b>��ѡ<br>ѧ��</b></font></td>
<td width=38><font color=#FFFFFF><b>�޸�</b></font></td>
<td width=38><font color=#FFFFFF><b>ɾ��</b></font></td>
</tr>
<?php
         $pro_list = explode(",", $com_pro_id);  
         $checkit = join(",|",$pro_list);
         $checkit = substr($checkit,0,strlen($checkit)-1);

$sql = "select id,name,topic,source,student_number,is_select,verify  from ".$TABLE."topic ,".$TABLE."teacher_information where ".$TABLE."topic.year=$select_year&&".$TABLE."topic.profession REGEXP '$checkit'&&".$TABLE."teacher_information.teacher_id=".$TABLE."topic .teacher_id ".$tiaojian." order by id asc";
$que_sql = mysql_query($sql);
$topic_num = 1;
		if($que_sql) $currrows=mysql_num_rows($que_sql);  
		if($currrows<1){
			$currrows = 0;
			echo "<tr><td colspan=7 height=188 align=center>�Բ���û�з��������ļ�¼</td></tr>";
		}
while($currrows && $array = mysql_fetch_array($que_sql)){
?>
<tr align="center">
<td>
<?php 
 if($array["source"]==1){
  echo "��ѡ";
 }else{
  echo $topic_num;
 }
?>
</td>
<td align="left"><? echo $array["name"];?></td>
<td align="left"><a href="topic_detail.php?orderverify=<?php echo $verify;?>&topic_id=<? echo $array["id"];?>&obj=dept&select_year=<? echo $select_year;?>" title="�鿴�������ϸ��Ϣ"><? echo $array["topic"];?></a></td>
<td align="center"><?
	$shmsg = array(
	      "-1" => "<font color=red>δͨ��</font>",
	      "0" => "<font color=green>�����</font>",
	      "9" => "<font color=blue>ʾ����</font>",
	      "1" => "�����"
	      );
	 echo $shmsg[$array["verify"]];
	 ?></td>
<td>
<?php 
  if($array["is_select"]==1){
?>
<a href="watch_student.php?student=<? echo $array["student_number"];?>" title="�鿴��ѧ������ϵ��ʽ" target=_blank>
<?php
  $student_number = $array["student_number"];
  $ee = mysql_query("select name from ".$TABLE."student_sheet where number = '$student_number'");
  $ff = mysql_fetch_array($ee);
  echo $ff["name"];
  }else{
   echo "&nbsp;";
  }
?>
</a>
</td>
<td>
	<?php
		echo "<a href=revise.php?id=".$array["id"].">�޸�</a>";
	?>
</td>
<td><a href="delete.php?id=<? echo $array["id"]?>" onclick="return confirm('��<? echo $array["name"]?>����ʦ�ı�ҵ�����Ŀ��\r\n��<? echo $array["topic"]?>��\r\n\r\n��ȷ��Ҫɾ����')">ɾ��</a></td>
</tr>
<?php
if($array["source"]==0){
 $topic_num++;
 }
}
?>
</table>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
