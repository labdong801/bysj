<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "毕业设计成绩修改";
$YM_ZT2 = "修改毕业设计综合成绩（慎用）";
$YM_MK = "毕业设计答辩管理系统";
$YM_PT = "答辩系统";
$YM_DH = 1; //需要导航条
$YM_QX = 80; //本页访问需要权限：管理员
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
<?php
$fz = $_GET["fz"];
if($fz=="") $fz=$CURR_YEAR."A";
$fenzu = array(
   $CURR_YEAR."A",
   $CURR_YEAR."B",
   $CURR_YEAR."C",
   $CURR_YEAR."D",
   $CURR_YEAR."E",
   $CURR_YEAR."F",
   "GOOD",
);

if($_POST["submit"]){
 	$cnt = $_POST["cnt"];
 	for($i=0;$i<$cnt;$i++){
        $s1_1 = $_POST["s1_1_".$i]+0;
        $s1_2 = $_POST["s1_2_".$i]+0;
        $s1_3 = $_POST["s1_3_".$i]+0;
        $s2_1 = $_POST["s2_1_".$i]+0;
        $s2_2 = $_POST["s2_2_".$i]+0;
        $s2_3 = $_POST["s2_3_".$i]+0;
        $s3_1 = $_POST["s3_1_".$i]+0;
        $s3_2 = $_POST["s3_2_".$i]+0;
        $s3_3 = $_POST["s3_3_".$i]+0;
        $s3_4 = $_POST["s3_4_".$i]+0;
        $id = $_POST["sid".$i];
        if($s1_1>100) $s1_1 = 100;  if($s1_1<0) $s1_1 = 0;
        if($s1_2>100) $s1_2 = 100;  if($s1_2<0) $s1_2 = 0;
        if($s1_3>100) $s1_3 = 100;  if($s1_3<0) $s1_3 = 0;
        if($s2_1>100) $s2_1 = 100;  if($s2_1<0) $s2_1 = 0;
        if($s2_2>100) $s2_2 = 100;  if($s2_2<0) $s2_2 = 0;
        if($s2_3>100) $s2_3 = 100;  if($s2_3<0) $s2_3 = 0;
        if($s3_1>100) $s3_1 = 100;  if($s3_1<0) $s3_1 = 0;
        if($s3_2>100) $s3_2 = 100;  if($s3_2<0) $s3_2 = 0;
        if($s3_3>100) $s3_3 = 100;  if($s3_3<0) $s3_3 = 0;
        if($s3_4>100) $s3_4 = 100;  if($s3_4<0) $s3_4 = 0;
        $sql = "update ".$TABLE."ok_topic set 
        score1_1 = '$s1_1',score1_2 = '$s1_2',score1_3 = '$s1_3',
        score2_1 = '$s2_1',score2_2 = '$s2_2',score2_3 = '$s2_3',
        score3_1 = '$s3_1',score3_2 = '$s3_2',score3_3 = '$s3_3',score3_4 = '$s3_4'
         where student_id = '$id'";
        //echo $sql;
       $open = mysql_query($sql);
    }
}
?>
<form id="form1" name="form1" method="post" action="">

<table width="770" border="0" align="center" cellpadding="2" cellspacing="3">
<tr>
<td align=center>
	<font size=+2><strong>毕业设计（论文）成绩修改<font color=green><b><?php echo $fz[4];?>组</b></font>（<b>慎用</b>）</strong></font><br />
	<?php
	echo "选择需要修改的分组：";
	for($i=0;$i<sizeof($fenzu);$i++){
		  echo "[<a href=".$PHP_SELF."?fz=".$fenzu[$i]."><font color=blue><u>".$fenzu[$i]."</u></font></a>]&nbsp;";
	}
	echo "<br><br>";
	?>
<font color=blue><b>分值说明：</b></font>按单项分别给分，<font color=red>每单项均为满分100分</font>。系统会自动计算实际分值。<br>
<table width=800 border=1 align=center cellpadding=3 bordercolor=#000000>
	
<tr bgcolor=#CCCCCC height=28 align=center>
<td rowspan=2><div align=center>序号</div></td>
<td rowspan=2><div align=center>班级</div></td>
<td  rowspan=2 width="80"><div align="center">学生姓名</div></td>
<td colspan=3>指导成绩</td>
<td colspan=3>评阅成绩</td>	
<td colspan=4>答辩成绩</td>
<td rowspan=2>总成绩</td>
</tr>	
<tr bgcolor=#CCCCCC >
<td><div align="center">1</div></td>
<td><div align="center">2</div></td>
<td><div align="center">3</div></td>
<td><div align="center">1</div></td>
<td><div align="center">2</div></td>
<td><div align="center">3</div></td>
<td><div align="center">1</div></td>
<td><div align="center">2</div></td>
<td><div align="center">3</div></td>
<td><div align="center">4</div></td>
</tr>
<?php
 $sql = "select oktopic.student_id,oktopic.type,student.name as sname,oktopic.topic,class,
 score1_1,score1_2,score1_3,
 score2_1,score2_2,score2_3,
 score3_1,score3_2,score3_3,score3_4,
 ceil((score1_1*10+score1_2*10+score1_2*10+score2_1*8+score2_2*6+score2_3*6+score3_1*10+score3_2*10+score3_3*15+score3_4*15)/100) as score,
 ceil((score1_1*10+score1_2*10+score1_2*10+score2_1*8+score2_2*6+score2_3*6+score3_1*15+score3_2*15+score3_3*20)/100) as score2
   from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student where oktopic.student_id=student.number".($fz=="GOOD"?("&&oktopic.year=$CURR_YEAR"):("&&oktopic.fenzu='".$fz."'"))." order by class, score desc";
//echo $sql;
 $result = mysql_query($sql);  //提取相关记录
  $cnt = 0;
$num_rows = mysql_num_rows($result);  

$nn = 1;
$lastclass="";
$colors=array("#FFFFFF","#CCCCCC");
$colori = 1;
while($row = mysql_fetch_array($result)){
 $id = $cnt++;
 $s1_1 = "s1_1_".$id;
 $s1_2 = "s1_2_".$id;
 $s1_3 = "s1_3_".$id;
 $s2_1 = "s2_1_".$id;
 $s2_2 = "s2_2_".$id;
 $s2_3 = "s2_3_".$id;
 $s3_1 = "s3_1_".$id;
 $s3_2 = "s3_2_".$id;
 $s3_3 = "s3_3_".$id;
 $s3_4 = "s3_4_".$id;
 
	if($row["type"]=="科学研究") $typeclass = 1;
	else $typeclass = 0;	
	
 if($lastclass!=$row["class"]){
 	$colori = ($colori+1)%2;
 	$lastclass=$row["class"];
}	
 echo "<tr align=center bgcolor=".$colors[$colori].">";
 echo "<td>".($nn++)."</td>";
 echo "<td>".$row["class"]."</td>";
 ?>
<td><?php
	//echo $row["student_id"]; 
	echo $row["sname"]; 
	echo "<input type=hidden name=sid".$id." value=".$row["student_id"].">";
	?></td>
<td>
<input type=text name=<?php echo $s1_1;?> value=<?php echo $row["score1_1"]>0?$row["score1_1"]:"''";?> size=4 maxlength=4>
</td>
<td>
<input type=text name=<?php echo $s1_2;?> value=<?php echo $row["score1_2"]>0?$row["score1_2"]:"''";?> size=4 maxlength=4>
</td>
<td>
<input type=text name=<?php echo $s1_3;?> value=<?php echo $row["score1_3"]>0?$row["score1_3"]:"''";?> size=4 maxlength=4>
</td><td>
<input type=text name=<?php echo $s2_1;?> value=<?php echo $row["score2_1"]>0?$row["score2_1"]:"''";?> size=4 maxlength=4>
</td>
<td>
<input type=text name=<?php echo $s2_2;?> value=<?php echo $row["score2_2"]>0?$row["score2_2"]:"''";?> size=4 maxlength=4>
</td>
<td>
<input type=text name=<?php echo $s2_3;?> value=<?php echo $row["score2_3"]>0?$row["score2_3"]:"''";?> size=4 maxlength=4>
</td>
<td>
<input type=text name=<?php echo $s3_1;?> value=<?php echo $row["score3_1"]>0?$row["score3_1"]:"''";?> size=4 maxlength=4>
</td>
<?php
if($typeclass!=0){
	echo "<td><input type=hidden name=$s3_4 value=0>论文".$detail["type"]."</td>";
}
?>
<td>
<input type=text name=<?php echo $s3_2;?> value=<?php echo $row["score3_2"]>0?$row["score3_2"]:"''";?> size=4 maxlength=4>
</td>
<td>
<input type=text name=<?php echo $s3_3;?> value=<?php echo $row["score3_3"]>0?$row["score3_3"]:"''";?> size=4 maxlength=4>
</td>
<?php
if($typeclass==0){
?>
<td>
<input type=text name=<?php echo $s3_4;?> value=<?php echo $row["score3_4"]>0?$row["score3_4"]:"''";?> size=4 maxlength=4>
</td>
<?php
}
if($typeclass) echo "<td>".$row["score2"]."</td>";
else echo "<td>".$row["score"]."</td>";
?>
</tr>
<?php
}
?>
</table>
<font color=blue><b>分值说明：</b></font>按单项分别评分，<font color=red>每单项均为满分100分</font>。系统会自动计算实际分值。
</td>
</tr>
<tr>
<td>
  <div align="center">
  	 <input type=hidden name=cnt value=<?php echo $cnt; ?>>
    <input type="submit" name="submit" value="修改【<?php echo $fz[4]; ?>组】的学生成绩" onclick="tb()"/>
  </div></td>
</tr>
</table>
</form>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

