<table width="148" border="1" cellpadding="3" bordercolor=#000000>
 <tr align="center">
<td bgColor=#4a5e7f height=28><font color=#FFFFFF>��&nbsp;&nbsp;��</font></td>
 </tr>
 <tr align="center">
  <td align=left bgColor=#5a6e8f height=28><a href=teacher_m.php><font color=#FFFFFF>&nbsp;
  	<b>��ҵ����ĵ��б�</b>
  </FONT></a></td>
 </tr>
<?php
  $count = 1;
  $mission_list = array();
  $miss = mysql_query("select * from ".$TABLE."mission_list where `year`='$CURR_YEAR'&&pro_id='$CURR_PID'&&lockit<2 order by start_time");

  if($miss) $currrows=mysql_num_rows($miss);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=68 align=center>����Ա��δ<br>�ύ�ĵ�����</td></tr>";
  } 
  $mission_name = ""; 
  while($arr = mysql_fetch_array($miss)){
  	if($mission_name==""&&$mission_id==$arr["mission_id"]) $mission_name = $arr["name"];
  	$mission_list[$count-1]["id"] = $arr["mission_id"];
  	$mission_list[$count-1]["name"] = $arr["name"];
  	$mission_list[$count-1]["uploader"] = $arr["uploader"];
  	$mission_list[$count-1]["address"] = $arr["address"];
?>
 <tr align=left>
  <td>&nbsp;<?php echo ($mission_id==$arr["mission_id"]?"<font color=red>��</font>&nbsp;<b>":($count."."))."<a href =teacher_m.php?mission_id=".$arr["mission_id"].">".$arr["name"]."</a></b>"?></td>
 </tr>
<?php
 $count++;
}
?>
 <tr>
  <td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;��ʦ����</fon></td>
 </tr>
 <tr align="center">
  <td><a href="mission_schedule.php">ѧ���Ͻ����һ��</a></td>
 </tr> 
<?
if($com_auth>=40){
?>
 <tr>
  <td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;����Ա����</font></td>
 </tr>
 <tr align="center">
  <td><a href="mission_m.php">��ҵ����ĵ�����</a></td>
 </tr>
 <?php
}
?>

<?
if($com_auth>=100){
?>
 <tr>
  <td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;��������Ա����</font></td>
 </tr>
 <tr align="center">
  <td><a href="all_m.php?is_check=0">����鿴���ĵ����</a></td>
 </tr>
 <tr align="center">
  <td><a href="own_m.php">�ĵ���ˣ����ã�</a></td>
 </tr>
<?php
}
?>
</table>
