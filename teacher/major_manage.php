<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "院系专业设置";
$YM_ZT2 = "设置各级院系、专业列表";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 80; //本页访问需要权限：管理员
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
//固定只能修改艺术系的
$xueyuan = 18;
 ?>
 
 <?php
if($_POST["act"]){
	$id = trim($_POST["id"]);
	$open = trim($_POST["open"]);
	$short = trim($_POST["short"]);
	$type = trim($_POST["type"]);
	$h_level = trim($_POST["h_level"]);
	$act = trim($_POST["act"]);
	$sql = "select name from ".$TABLE."major where name='$long' && type='$type'";
	$que_sql = mysql_query($sql);
	if($que_sql) $fet_result = mysql_fetch_array($que_sql);
	if($type==2) $s = "二级学院";
	else if($type==3) $s = "系（中心）";
	else $s = "专业";
	if($fet_result["name"]==$long) {
		$postmsg = "存在同名的".$s."名称，".($act=="add"?"添加":"修改")."取消。";
	} else {
		if($act=="add") $sql = "insert into ".$TABLE."major(name,shortname,type,h_level,open) values ('$long','$short','$type','$h_level','$open')";
		else $sql = "update ".$TABLE."major set name='$long',shortname='$short',type='$type',h_level='$h_level',open='$open' where id = $id";
		$que_sql = mysql_query($sql);
		if($que_sql) $postmsg = ($act=="add"?"添加":"修改").$s."成功！";
		else $postmsg = ($act=="add"?"添加":"修改").$s."失败！";
	}
}
 ?>
 
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function set_value(id,lt, st, t, hl,act,o){
	var fm = document.majorform;
	var  s;
	if(t==4) s = '专业';
	else s = '系（中心）';
	if(lt.value==''){
		alert(s+'的名称不能为空，请填写后提交！');
		lt.focus();
		return false;
	}
	if(st.value==''){
		alert(s+'的简称不能为空，请填写后提交！');
		st.focus();
		return false;
	}
	fm.id.value=id;
	fm.open.value=o;
	fm.long.value=lt.value;
	fm.short.value=st.value;
	fm.type.value=t;
	fm.h_level.value=hl;
	fm.act.value=act;
	fm.submit();
}
</script>
<?php
$sql = "select * from ".$TABLE."major";
$que_sql = mysql_query($sql);
$majorlist = array();
while($ret = @mysql_fetch_array($que_sql)){
	unset($m);
	$m[id] = $ret[id];
	$m[name] = $ret[name];
	$m[shortname] = $ret[shortname];
	$m[type] = $ret[type];
	$m[h_level] = $ret[h_level];
	$m[open] = $ret[open];
	if(!$majorlist[hl.$ret[h_level]]) $majorlist[hl.$ret[h_level]] = array();
	$hl[$ret[h_level]] = array_push($majorlist[hl.$ret[h_level]],$m)."<br>";
}
$m1 = $majorlist;
$m2 = $majorlist;
$m3 = $majorlist;
echo "<form name=majorform method=post action=$PHP_SELF>";
echo "<input type=hidden name=long value='a'>";
echo "<input type=hidden name=short value=''>";
echo "<input type=hidden name=type value=''>";
echo "<input type=hidden name=h_level value=''>";
echo "<input type=hidden name=open value=''>";
echo "<input type=hidden name=id value=''>";
echo "<input type=hidden name=xueyuan value='$xueyuan'>";
echo "<input type=hidden name=act value='add'>";
//echo "<input type=hidden name=submit value='submit'>";

echo "<table width=800 border=0 align=center bordercolor=#000000>";
$v1 = $majorlist[hl0];
$ccc = 1;

if(sizeof($v1)<1) {
	echo "<tr><td height=80>";
	echo "【请添加学校信息】\n";
	echo "学校全称：<input type=text  name=long".$ccc." size=20>&nbsp;&nbsp;&nbsp;";
	echo "学校简称：<input type=text name=short".$ccc." size=8>）&nbsp;&nbsp;<input type=button  onclick=\"return set_value($ccc,long".$ccc.",short".$ccc.",1,0,'add','1')\" value=提交>";
	$ccc ++;
	echo "</td></tr>";
}  else {
	$i1 = 0;  //只显示第一所学校
	//echo "<tr><td  height=38 align=center>".$v1[$i1][name]."</td></tr>";
	reset($m1);
	$id2 = $v1[$i1][id];
	while(list($k2,$v2)=each($m1)){
		if($k2!="hl".$id2) continue;
		//echo "<tr height=50><td >请选择要操作的学院：<select name=xueyuan size=+1 onchange=\"MM_jumpMenu('parent',this,1)\" >";
		$xy = false;
		for($i2=0;$i2<sizeof($v2);$i2++){
			if($v2[$i2][id]==$xueyuan) {
				$s = " selected";
				$xy = true;
			} else $s = "";
			echo "<option value=".$PHP_SELF."?xueyuan=".$v2[$i2][id].$s.">".$v2[$i2][name]."</option>";
		}
		echo "</select>";
		echo "</td></tr>";
		if(!$xy) $xueyuan = $v2[0][id];
		echo "<tr><td align=center>";
		if($postmsg) echo "<font color=blue><b>".$postmsg."</b></font><br>";
		echo "<table width=680 border=1 align=center bordercolor=#000000  cellpadding=6>";
		echo "<tr align=center bgColor=#5a6e8f  height=38>
			<td width=190><font color=#FFFFFF>下属系、中心</font></td>
			<td width=380><font color=#FFFFFF>专业</font></td>
			<td><font color=#FFFFFF>开启</font></td></tr>";
		for($i2=0;$i2<sizeof($v2);$i2++){
			if($xueyuan!=$v2[$i2][id]) continue;
			reset($m2);
			$id3 = $v2[$i2][id];
			while(list($k3,$v3)=each($m2)){
				if($k3!="hl".$id3) continue;
				for($i3=0;$i3<sizeof($v3);$i3++){
					reset($m3);
					$id4 = $v3[$i3][id];
					echo "<tr><td height=38 rowspan=".($hl[$v3[$i3][id]]+1).">&nbsp;&nbsp;";
					echo ($i3+1).") ".$v3[$i3][name]."</td>";
					echo "<td colspan=2>新增专业：\n<input type=text name=long".$ccc." size=20>（简称：<input type=text name=short".$ccc." size=8>）&nbsp;&nbsp;<input type=button name=button".$ccc." onclick=\"return set_value($ccc,long".$ccc.",short".$ccc.",4,'$id4','add',1)\"  value=新增专业></td></tr>";
					$ccc ++;
					while(list($k4,$v4)=each($m3)){
						if($k4!="hl".$id4) continue;
						for($i4=0;$i4<sizeof($v4);$i4++){
							echo "<tr><td>";
							echo "(".($i4+1).") ".$v4[$i4][name]."</td><td align=center><input type=checkbox></td></tr>";
						}
					}
				}
			}
//			echo "<tr><td height=38 colspan=3>&nbsp;&nbsp;增加一个系或中心：\n";
//			echo "<input type=text  name=long".$ccc." size=20>（简称：<input type=text name=short".$ccc." size=8>）&nbsp;&nbsp;<input type=button  onclick=\"return set_value($ccc,long".$ccc.",short".$ccc.",3,'$id3','add',1)\" value=新增系></td></tr>";
			$ccc ++;
		}
		echo "</table>";
		echo "</td></tr>";
	}
//		echo "<tr height=50><td>";
//		echo "增加二级学院：\n";
//		echo "<input type=text  name=long".$ccc." size=20>（简称：<input type=text name=short".$ccc." size=8>）&nbsp;&nbsp;<input type=button  onclick=\"return set_value($ccc,long".$ccc.",short".$ccc.",2,'$id2','add',1)\" value=新增二级学院>";
//		$ccc ++;
//		echo "</td></tr>";
}
echo "</form>";
echo "</table>";

?>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
