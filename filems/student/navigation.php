<table width="148" border="1" cellpadding="3" bordercolor=#000000>
 <tr align="center">
  <td>��&nbsp;&nbsp;��</td>
 </tr>
 <tr align="center">
  <td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��ҵ����ĵ�һ��</font></td>
 </tr>
<?php
  $count = 1;
  $miss = mysql_query("select * from ".$TABLE."mission_list where `year`='$com_bysj'&&`pro_id`=$com_pro_id&&lockit<2 order by start_time");
  if($miss) $currrows=mysql_num_rows($miss);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=68 align=center>�����ĵ��ύ����</td></tr>";
  }    
  while($arr = mysql_fetch_array($miss)){
  	   if(strpos($arr["name"],"����")){
  	   	   $spmissionid = $arr["mission_id"]; //��������������
  	   	   $spaddress = $arr["address"];
  	   	   $spname = $arr["name"];
  	   }
?>
 <tr align=left>
  <td>&nbsp;<?php echo $count.".<a href =student_m.php?mission_id=".$arr["mission_id"].">".$arr["name"]."</a>"?></td>
 </tr>
<?php
 $count++;
}
?>
 <tr>
  <td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;��������</font></td>
 </tr>
 <tr align="center">
  <td><a href="mygroup.php">�ҵĴ����Ϣ</a></td>
 </tr> 
</table>