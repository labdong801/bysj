<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "学生帐号一览";
$YM_ZT2 = "查看学生的帐号、选题情况";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 40; //本页访问需要权限:专业主任
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;

	 $curr_pro_id = $set_pro_id;

	if($select_year==$YEAR_C) echo  "[<b>".$YEAR_C."届(本届)</b>]";
	else echo "[<a href=".$PHP_SELF."?select_year=".$YEAR_C."&set_pro_id=$curr_pro_id&select_class=$select_class><font color=blue><u>".$YEAR_C."届(本届)</u></font></a>]";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   往届：";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) {
		if($i==$select_year) echo "[<b>".$i."届</b>] ";
		else echo "[<a href=".$PHP_SELF."?select_year=".$i."&set_pro_id=$curr_pro_id&select_class=$select_class><font color=blue><u>".$i."届</u></font></a>] ";
	}
	if($com_auth>80){
		if($select_year=="none") echo "[<b>非毕业生</b>] ";
		else {
			echo "[<a href=".$PHP_SELF."?select_year=none&set_pro_id=$curr_pro_id&select_class=$select_class><font color=blue><u>非毕业生</u></font></a>] ";
			if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
		}
	} else {
		if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	}

         $majiorlist = get_majior_list();
         $pro_list = explode(",", $com_pro_id);  
	 echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;选择专业：";
	 $pro_name = "";
	 while(list($k,$v)=each($majiorlist)){
	 	   if(in_array($k,$pro_list)&&$v[open]){
	 	   	   if($curr_pro_id ==0) $curr_pro_id = $k;
	 	   	   if($curr_pro_id == $v["id"]){
	 	   	   	    echo "[<b>".$select_year."届 ".$v["name"]."</b>]";
			 	    $pro_name = $v["name"];
	 	   	   } else echo "[<a href=".$PHP_SELF."?set_pro_id=".$k."&select_year=$select_year&select_class=$select_class><font color=blue><u>".$select_year."届 ".$v["name"]."</u></font></a>]";
	 	   	   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	 	   }
 	 }
 	 echo "<br>";
 	if($pro_name==""){
 		echo "<br><br>";
 		Show_Message("对不起，您的访问被拒绝，请求助管理员解决问题。");
 		@include($baseDIR."/bysj/inc_foot.php");
 		exit;
 	}
?>

<?php
 $sql = "select max(number),class from ".$TABLE."student_sheet where year='".$select_year."'&&profession='".$pro_name."' group by class";
 $qsql = mysql_query($sql);
 if($qsql) $currrows=mysql_num_rows($qsql);  
else $currrows = 0;
if($currrows<1){
	$noclass = "<tr><td colspan=8 height=138 align=center>对不起，当前没有 <b>".$select_year."届 ".$pro_name."专业</b> 的毕业生记录。</td></tr>";
} else $noclass = "";
 $classlist = array();
 $classcnt = 0 ;
$tindex = 0;
while($fsql = mysql_fetch_array($qsql)){
 	$classlist[$classcnt++]  = $fsql["class"];
}
if(!in_array($select_class,$classlist)) $select_class = $classlist[0];
if($classcnt>0) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;班级列表：";
 for($i=0;$i<$classcnt;$i++){
	if($classlist[$i]==$select_class) echo "[<b>".$classlist[$i]."</b>] ";
    else echo "[<a href=".$PHP_SELF."?select_year=".$select_year."&select_class=".$classlist[$i]."&set_pro_id=$curr_pro_id><font color=blue><u>".$classlist[$i]."</u></font></a>] ";
}
echo "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<font color=green><b>注1</b></font>] 点击<b>学生姓名</b>可设置学生为“<b>班干</b>”（该学生可查看全班的选题情况）；再次点击可取消该属性";
echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<font color=green><b>注2</b></font>] 若看不到某专业学生名单，请先在“<a href=authority.php><font color=blue><u>指导教师授权</u></font></a>”中<font color=green><b>对应专业</b></font>添加您的指导权限，重新登录即可。";
echo "</p>";
?>
<script  type="text/javascript" src="teacher_ajax.js"></script>
<script>
function newpass(e, id,tt){
	var s = confirm("您确定需要重置该学生的登录密码吗？\n\n重置后，密码为该学生的学号。");
	if(!s) return false;
	rebuildpass('pass'+e, id,tt);
}
</script>
<table width="800" border="1" bordercolor=0 cellpadding=5>
  <tr align=center  bgColor=#5a6e8f  height=38>
    <td><font color=#FFFFFF>序号</font></td>
    <td><font color=#FFFFFF>学生帐号</font></td>
    <td><font color=#FFFFFF>学生姓名</font></td>
    <td><font color=#FFFFFF>联系电话</font></td>
    <td><font color=#FFFFFF>短号</font></td>
    <td><font color=#FFFFFF>密码</font></td>
	<td><font color=#FFFFFF>选题情况</font></td>
    <td><font color=#FFFFFF>志愿情况</font></td>
  </tr>
<?php
 $sql = "select class,name, student.number,password,wish.zhiyuannum,mobilephone,short_number,authority from ".$TABLE."student_sheet as student left join (select  number, GROUP_CONCAT(wish SEPARATOR  ', ') as zhiyuannum from ".$TABLE."student_select group by number order by wish) as wish on wish.number = student.number  where (year='$select_year'&&class='$select_class') order by student.number ";
 //echo $sql;
 $sql = mysql_query($sql);
 while($row = mysql_fetch_array($sql)){
?>
  <tr align=center>
    <td><?php echo $tindex+1; ?></td>
    <td><? echo $row["number"];?></td>
    <td align=left><? 
    	echo "<a href=# onClick=\"student_auth('bg".$tindex."','".$row["number"]."','student');return false;\">".$row["name"]."</a>";
    	echo "<span id='bg".$tindex."'>";
    	if($row["authority"]>1) echo "[<font color=blue>班干</font>]";
    	echo "</span>";
    	?></td>
    <td><? echo $row["mobilephone"];?></td>
    <td><? echo $row["short_number"];?></td>
    <td><?php
         echo "<span id='pass".$tindex."'>";
	if($showpass=="yeah"||$row["password"]==$row["number"])echo $row["password"]; else echo "*****";
	if($com_auth>=40&&$row["password"]!=$row["number"])
		echo " <input type=button value=重置 onClick=\"newpass('".$tindex."','".$row["number"]."','student')\">";
	echo "</span>";
    	 ?></td>
	<td><? 
	 $sd = mysql_query("select is_select,teacher_id from ".$TABLE."topic where student_number = '$row[number]'&&verify>0&&is_select=1");
	 $ds = mysql_fetch_array($sd);
	 $es = mysql_query("select name from ".$TABLE."teacher_information where teacher_id = '$ds[teacher_id]'");
	 $se = mysql_fetch_array($es);
	 $ol = mysql_query("select number from ".$TABLE."student_select where number = '$row[number]'");
	 $lo = mysql_fetch_array($ol);
    	if($ds["is_select"]==1) echo "<font color=blue>$se[name]</font>";
		elseif($lo["number"]) echo "已提交选题";
    	else echo "<font color=red>未选题或需再选题</font>";
    	?></td>
    <td>&nbsp;<? 
    	if($ds["is_select"]==1) echo "已选定";
    	else echo $row["zhiyuannum"];
    	?></td>
  </tr>
<?php
    $tindex ++;

}
echo $noclass;  //如果没有班级信息，则提示无学生记录。
?>
</table>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
