<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "ѧ��ǩ��";
$YM_MK = "��ҵ��ƹ���ϵͳ";
$YM_DH = 0; //��Ҫ������
$YM_QX = 1; //��ҳ������ҪȨ�ޣ�ѧ��
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;
?>

<?php
$sql = "select student.name,teacher.name as tname,student.tmptime as stmptime,teacher.teacher_id,teacher.mobilephone as phone,techpos  as zhicheng, topic,".$ART_TABLE."title_sort.name as ttype from ".$TABLE."student_sheet as student,".$TABLE."topic as topic ,".$ART_TABLE."title_sort,".$TABLE."teacher_information as teacher where number = '$number' && ".$ART_TABLE."title_sort.id = type && is_select=1 && number = student_number&&teacher.teacher_id=topic.teacher_id";
$sj_que = mysql_query($sql);
$sj_fet = mysql_fetch_array($sj_que);
if(!$sj_fet||$sj_fet["name"]==""){
	Show_Message("�Բ���Ŀǰֻ��Ӧ���ҵ���ṩǩ�����ܡ�");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}
$teacher_id = $sj_fet["teacher_id"];


$sql = "select * from ".$TABLE."checkin where student_id = '$number' order by checktime desc";
$que = mysql_query($sql);
$res = @mysql_fetch_array($que);

echo "<br><br><font size=+2 face=����><b>��ҵ��ƹ���ϵͳ ѧ��ǩ��</b></font><br><br>";

$now = time(0);
if($_POST["submit"]){
	if($res["checktime"]+180>$now){
		Show_Message("�������ڲ����ظ�ǩ��Ŷ��");
	} else {
		$mobile = $_POST["mobile"];
		$progress = $_POST["progress"];
		$work = $_POST["work"];
		$backtime = $_POST["backtime"];
		$city = $_POST["city"];
		$company = $_POST["company"];
		$memo = $_POST["memo"];
		$sql = "insert into ".$TABLE."checkin(checktime,student_id,teacher_id,work,city,company,mobile,backtime,progress,memo) values ('$now','$number','$teacher_id','$work','$city','$company','$mobile','$backtime','$progress','$memo')";
		$act = mysql_query($sql);
		if($act) Show_Message("�������Ѿ��ɹ�ǩ�����ǵ�ÿ����ǩ��Ŷ��");
		else Show_Message("ǩ��ʧ�ܣ����غ�����һ�ΰɣ�");
		@include($baseDIR."/bysj/inc_foot.php");
		exit;
	}
}
?>

<form id="checkinform" name="checkinform" method="post" action="">
<?php
if($res["checktime"]<1000) echo "����δ�ڴ�ǩ���������ھ�ǩ����лл��";
else {
	$cnt = (($now-$now%86400 - $res["checktime"]+$res["checktime"]%86400)/86400);
	if($cnt<0) echo "��ϲ����Խʱ�գ�����δ��ĳ��ʱ���Ѿ�ǩ�����ˡ�����ʱ�չ���ֹ涨��������ص�δ��ȥǩ����";
	else if($cnt==0) echo "�������Ѿ�ǩ�����ˡ����״̬�б仯���ǵù���ǩ��Ŷ��лл��";
	else if($cnt<10) echo "������ $cnt ��ǰǩ�������״̬�б仯����ǩ����лл��";
	else echo "������ $cnt ��û��ǩ��Ŷ���뼰ʱǩ�����Ա�ָ����ʦ֪�����ĵ�ǰ�����лл��";
}
?>
  <table width="700" height="206" border="1" cellpadding="8" cellspacing="0" bordercolor="#000000">
  	<tr>
  		<td width="700" colspan=2 bgColor=#5a6e8f align=middle>
  			<font color=#FFFFFF>ǩ��˵��������ÿ����ָ����ʦǩ�����Ա���ʦ֪�����ȥ��<br>
  				�ر����ڵ绰���롢����״̬�����ڵط����仯������£�����ؼǵ�ǩ����лл��</font>
  		</td>
  	</tr>  	
    <tr>
      <td width="340">��ǰʹ���ֻ���
        <input name="mobile" type="text" id="mobile" value="<?php echo $res["mobile"];?>"/>
        <br />
        ����ظ���Ϊ���º��룬�Ա��Ҫʱ������ϵ�㣩      </td>
      <td width="360"><p>��ҵ��ƽ��ȣ�<br />
        <label>
        <input name="progress" type="radio" value="0" <?php echo $res["progress"]==""||$res["progress"]=="0"?" checked":"";?>/>
        δ��ʼ</label>
        <input type="radio" name="progress" value="1"  <?php echo $res["progress"]=="1"?" checked":"";?> />
        �������
        <input type="radio" name="progress" value="2" <?php echo $res["progress"]=="2"?" checked":"";?> />
        ��ɴ󲿷�
        <input type="radio" name="progress" value="3" <?php echo $res["progress"]=="3"?" checked":"";?> />
����� </p>      </td>
    </tr>
    <tr>
      <td><p>����״̬��<br />
          <input name="work" type="radio" value="0"  <?php echo $res["work"]==""||$res["work"]=="0"?" checked":"";?> />
        ��У��δ�ҹ���<br />
        <input type="radio" name="work" value="2"<?php echo $res["work"]=="2"?" checked":"";?> />
��У��������ȷ����δǩԼ<br />
      <input type="radio" name="work" value="3"<?php echo $res["work"]=="3"?" checked":"";?> />
��У��������ȷ����ǩԼ����¼ȡ�о�����<br />
      <input type="radio" name="work" value="4"<?php echo $res["work"]=="4"?" checked":"";?> />
�����У���ǩԼ<br />
      <input type="radio" name="work" value="5"<?php echo $res["work"]=="5"?" checked":"";?> />
�����У�δǩԼ<br />
      <input type="radio" name="work" value="1"<?php echo $res["work"]=="1"?" checked":"";?> /> 
      �����ҹ���<br />      
      </p>      </td>
      <td>��ʱ��У��
        <br />
        <input name="backtime" type="radio" value="0"  <?php echo $res["backtime"]==""||$res["backtime"]=="0"?" checked":"";?> /> 
        ����У<br />
<input type="radio" name="backtime" value="1" <?php echo $res["backtime"]=="1"?" checked":"";?> />
һ���ڻ�У<br />
<input type="radio" name="backtime" value="2" <?php echo $res["backtime"]=="2"?" checked":"";?> />
�����ڻ�У<br />
<input type="radio" name="rdlocation" value="3" <?php echo $res["backtime"]=="3"?" checked":"";?> />
һ���ڻ�У<br />
<input type="radio" name="backtime" value="4" <?php echo $res["backtime"]=="4"?" checked":"";?> />
��Уʱ��δ��<br />
<br />
��ǰ���ڵ� ��
<input name="city" type="text" id="city" size="16" maxlength="30"  value="<?php echo $res["city"];?>" />������ʡ�����У�
<br /></td>
    </tr>
<tr><td colspan=2>
������ǩԼ����λ���ơ���¼ȡ�о���ѧУ���ƣ�
<input name="company" type="text" id="city" size="40" maxlength="60"  value="<?php echo $res["company"];?>" />��ȫ�ƣ�    
</td></tr>
<tr>
      <td colspan="2">��Ҫ��ָ����ʦ����˵���Ļ���
        <input name="memo" type="text" id="memo" size="50" maxlength="48"  value="<?php echo $res["memo"];?>" />
        ��50�ַ����ڣ�</td>
    </tr>
  </table>
  <br>
<?php
	if($res["checktime"]+180>$now)  echo "<input type=submit name=submit disabled onclick='return false' value='�������Ӻ���ǩ��'/>";
	else echo "<input type=submit name=submit onclick='return checkit()' value='���ھ�ǩ��'/>";
?>
</form>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
