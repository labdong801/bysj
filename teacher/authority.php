<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�޸��ʺ�Ȩ��";
$YM_ZT2 = "ָ����ʦȨ�����á�ָ��������������";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 40; //��ҳ������ҪȨ�ޣ�רҵ����
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 <?php
 	 $curr_pro_id = $set_pro_id;
 	 $sql = "SELECT * FROM  `".$TABLE."major` WHERE h_level = 19";
//         $majiorlist = get_majior_list($com_auth>80?"":$com_pro);
//         $pro_list = explode(",", $com_pro_id);  
	 echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��ѡ�������רҵ��";
//	 $pro_name = "";
//	 //print_r($majiorlist);
//	 while(list($k,$v)=each($majiorlist)){
//	 	   if((in_array($k,$pro_list)||$com_auth>40)&&$v[open]){
//	 	   	   if($curr_pro_id ==0) $curr_pro_id = $k;
//	 	   	   if($curr_pro_id == $v["id"]){
//	 	   	   	    echo "[<b>".$v["name"]."</b>]";
//			 	    $pro_name = $v["name"];
//	 	   	   } else echo "[<a href=".$PHP_SELF."?set_pro_id=".$k."><font color=blue><u>".$v["name"]."</u></font></a>]";
//	 	   	   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//	 	   }
// 	 }
	$query = mysql_query($sql);
		if(mysql_num_rows($query))
		{ 
			while($row = mysql_fetch_array($query))
			{ 
				if($curr_pro_id == "")
					$curr_pro_id          = $row['id'];
						
				if( $curr_pro_id == $row['id']  )
				{ 
					echo "<font><u>".$row['name']."</u></font>&nbsp;&nbsp;";
					$pro_name = $row['name'];
				}
				else
					echo "<a href='".$PHP_SELF."?set_pro_id=".$row['id']."' ><font color=blue><u>".$row['name']."</u></font></a>&nbsp;&nbsp;";
				
			}
		}
 	 echo "</p>";
 	if($pro_name==""){
 		echo "<br><br>";
 		Show_Message("�Բ������ķ��ʱ��ܾ�������������Ա������⡣");
 		@include($baseDIR."/bysj/inc_foot.php");
 		exit;
 	}
 	$allleadnum = 0;
 ?>

<?php
 if($_POST["submit"]){
 	$addcnt = sizeof($newteacher);
 	for($i=0;$i<($cnt+$addcnt);$i++){
 		if($i<$cnt){
 			$tid = "tid".$i;
 			$open = "open".$i;
 			$level = "level".$i;
 			$lnum = "lnum".$i;
 			$tid_value = $$tid;
 			$open_value = $$open;
 			$level_value = $$level;
 			$lnum_value = $$lnum;
 			$mk_teacher = $tid_value[0];
 			$mk_open = $open_value[0];
 			$mk_num = $lnum_value[0];
 			$mk_level = $level_value[0];
 		} else {
 			$mk_teacher = $newteacher[$i-$cnt];
 			$mk_open = "ON";
 			$mk_num = 0;
 			$mk_level = "keepit";
 		}
 		
 		$sql = "select teacher_id,name,authority,lead_num from ".$TABLE."teacher_information where teacher_id='".$mk_teacher."'";
 		$que_sql = mysql_query($sql);
 		$fet_result = mysql_fetch_array($que_sql);
 		if($fet_result["teacher_id"]!=$mk_teacher){
 			echo "<table width=70% boder=0 align=center><tr><td>���棺�û� ".$mk_teacher." ��Ϣδ�ҵ���������޸Ĳ����Ѻ��ԡ�</td></tr></table>";
 			continue;
 		}
 		if($mk_level == "keepit") $mk_level = $fet_result["authority"];
 		$lead = explode(",",$fet_result["lead_num"]);
         	$pro_list = "";
             	while(list($k,$v)=each($lead)){
             	   	if($v=="") continue;
             	   	$s = explode("-",$v);
             	   	if($mk_open!="ON"&&$s[0]==$curr_pro_id)continue;
             	   	if($mk_open=="ON"&&$s[0]==$curr_pro_id) $s[1] = $mk_num;
             	   	$pro_list .= (",".$s[0]."-".$s[1].",");
             	}
             	if($i>=$cnt) $pro_list .= (",".$curr_pro_id."-".$mk_num.",");
             	if($fet_result["lead_num"]==$pro_list&&$mk_level==$fet_result["authority"]){
 			//echo "<table width=70% boder=0 align=center><tr><td>��ʾ���û� ".$mk_teacher." ��Ϣδ�䶯��������޸Ĳ����Ѻ��ԡ�</td></tr></table>";
 			continue;
             	}
             	//echo "[$mk_teacher] [$mk_level] [$pro_list] <br>";
             	mysql_query("update ".$TABLE."teacher_information set authority = '".$mk_level."',lead_num = '".$pro_list."' where teacher_id = '".$mk_teacher."'");
 	}
 }
?>

<script  type="text/javascript" src="teacher_ajax.js"></script>
<script>
function checkit(e){
	var s;
	if(!e.checked ){
   		s = confirm('��ȷ������Ҫ�ý�ʦָ����רҵ�ı�ҵ�����');
   		if(!s) e.checked = true;
 	}
}
</script>
 <form id="form1" name="form1" method="post" action="<?php echo $PHP_SELF; ?>">

<table width="660" border="1" align="center"  cellpadding=5 bordercolor=#000000>
<tr  bgColor=#5a6e8f  height=38 align=center>
<td width="32"><font color=#FFFFFF><b>���</b></font></td>
<td><font color=#FFFFFF><b>��ʦ�ʺ�</b></font></td>
<td><font color=#FFFFFF><b>��ʦ����</b></font></td>
<td width="50"><font color=#FFFFFF><b>ָ��Ȩ</b></font></td>
<td width="100" ><font color=#FFFFFF ><b>Ȩ������</b></font></td>
</tr>
<?php
$hisleadnum = "(0+mid(lead_num,instr(lead_num,',".$curr_pro_id."-')+".strlen(",".$curr_pro_id."-").",2)) as hisleadnum";
 $sql = "select teacher_id,name,password,authority,belong,lead_num,$hisleadnum from ".$TABLE."teacher_information  where lead_num REGEXP ',".$curr_pro_id."-' order by authority desc, belong";
 //echo $sql;
 $que_sql = mysql_query($sql);
 krsort($com_level);
 $tindex = 0;
 while($row = mysql_fetch_array($que_sql)){
?>
<tr align="center">
<td><?php echo $tindex+1; ?></td>
<td><?php echo "<input type=hidden name=tid".$tindex."[] value=".$row["teacher_id"].">".$row["teacher_id"];?></td>

<td><?php echo $row["name"]; ?></td>
<td>
<input type="checkbox" name=open<?php echo $tindex;?>[] value="ON" onclick='checkit(this)' checked="checked"/>
</td>
<td>
	<?php
	echo "<select name=level".$tindex."[] size=1>";
	reset($com_level);
	while(list($k,$v)=each($com_level)){
		if($k<10) continue;
		if($k==$row["authority"]) $s = " selected";
		else $s = "";
		if($k>=$com_auth&&$k!=$row["authority"]) continue;
		if($row["teacher_id"]==$teacher_id&&$k!=$row["authority"])break;
		while(strlen($v)<8) $v .= " ";
		$v = str_replace(" ","&nbsp;",$v);
		echo "<option ".$s." value=".$k.">".$v."</option>";
		if($row["authority"]>$com_auth)break;
	}
	echo "</select>";
?>
<input name=lnum<? echo $tindex;?>[] type="hidden" size="2" maxlength=2 value="<?php echo $row["hisleadnum"];?>"/>
</td>
</tr>
<?php
    $tindex ++;
    $allleadnum += $row["hisleadnum"];
}
   $sql = "select count(*) as studentnum from ".$TABLE."student_sheet,".$TABLE."major where ".$TABLE."student_sheet.profession = ".$TABLE."major.name && ".$TABLE."major.id = $curr_pro_id && ".$TABLE."major.type = 4&&".$TABLE."student_sheet.year='$YEAR_C'";
   $que_sql = mysql_query($sql);
   $fet_result = mysql_fetch_array($que_sql);
   if($fet_result["studentnum"]!=$allleadnum) {
   	echo "<tr><td colspan=6 align=center bgcolor=yellow>���ѣ�<b>".$pro_name."</b> רҵѧ���� <b>".$fet_result["studentnum"]."</b> �ˣ�������ָ�������� <b>".$allleadnum."</b> �˲�һ�£���˲�</td></tr>";
   } else {
   	echo "<tr><td colspan=6 align=center><b>".$pro_name."</b> רҵѧ��������<b>".$fet_result["studentnum"]."</b> �ˣ���ǰ�����ָ����������<b>".$allleadnum."</b> ��</td></tr>";
  }
?>
</table>
<?php
if($addteacher == "yeah"){
	$sql = "select teacher_id,".$TABLE."teacher_information.name as tname,".$TABLE."major.name as pname, authority from ".$TABLE."teacher_information,".$TABLE."major  where ".$TABLE."teacher_information.belong = ".$TABLE."major.id && not lead_num REGEXP ',".$curr_pro_id."-' order by belong,authority desc";
 	$que_sql = mysql_query($sql);	
	echo "<br><table width=660 border=1 align=center  cellpadding=5 bordercolor=#000000>";
	echo "<tr  bgColor=#5a6e8f  height=38 align=center>";
	echo "<td width=130><font color=#FFFFFF><b>���ڵ�λ</b></font></td>";
	echo "<td width=520><font color=#FFFFFF><b>�����ָ����ʦ����</b></font></td>";
	echo "</tr>";
	$lastname = "";
 	$cnt = 0;
 	$maxnum = 5;
	 while($row = mysql_fetch_array($que_sql)){
	 	if($lastname!=$row["pname"]) {
	 		$lastname=$row["pname"];
	 		$newxi = true;
			$ss = $cnt%$maxnum;
	 	} else {
	 		$newxi = false;
	 	}
	 	if($newxi){
			if($ss)for($i=$ss;$i<$maxnum;$i++)echo "<td width=".(100/$maxnum)."%>&nbsp;</td>";
	 		if($cnt){
				$cnt = $maxnum;
				echo "</tr>";
				echo "</table>";
				echo "</td></tr>";
			}
	 		echo "<tr><td>".$row["pname"]."</td><td>";
	 		echo "<table border=0 width=100% align=center cellpadding=3>";
	 		echo "<tr>";
	 	}
		if(!$newxi && $cnt && $cnt%$maxnum==0) echo "</tr><tr>";
		echo "<td width=".(100/$maxnum)."%><input type=checkbox name=newteacher[] value=".$row["teacher_id"]."> ".$row["tname"]."</td>";
		$cnt ++;
	}
	if($cnt%$maxnum!=0){
		for($i=$cnt%$maxnum;$i<$maxnum;$i++)echo "<td width=".(100/$maxnum)."%>&nbsp;</td>";
	}
	echo "</tr>";
	echo "</table>";
	echo "</td></tr>";
	echo "</table>";
}
?>
<br>
    <input type=hidden name=set_pro_id value=<?php echo $curr_pro_id; ?>>
    <input type=hidden name=cnt value=<?php echo $tindex; ?>>
    <input type=hidden name=addteacher value=<?php echo $addteacher; ?>>
    <input type="submit" name="submit" value="���ñ�ҵ���ָ����ʦȨ��" />
    &nbsp;&nbsp;&nbsp;
    <?php 
    if($addteacher=="yeah")echo "[<a href=".$PHP_SELF."?set_pro_id=".$curr_pro_id."><font color=blue><u>������ӽ���</u></font></a>]";
    else echo "[<a href=".$PHP_SELF."?addteacher=yeah&set_pro_id=".$curr_pro_id."><font color=blue><u>�����ָ����ʦ</u></font></a>]";
    ?>
</form>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>