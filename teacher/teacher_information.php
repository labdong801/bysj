<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "��ʦ�����";
$YM_ZT2 = "ָ����ʦ���������";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��:��ͨ��ʦ
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 <script>
function checkname(){
	if(myform.name.value == ""){
		alert('����д��������');
	}
}
</script>
<script language="JavaScript" src="/bysj/images/My97DatePicker/WdatePicker.js" defer="defer"></script>  
<?php
$aaa = mysql_query("select * from ".$TABLE."teacher_information where teacher_id = '$teacher_id'");
$row = mysql_fetch_array($aaa);
?>
<form name="myform" action="" method="post">
	������Ϣ��ѧ�����ɼ�����ѧ��ѡ��ʱ�ο����� * ���֣����Ҫ���Ͻ����ܡ�<br>
  <table width=820 border="1" align="center" bordercolor="#000000"    cellpadding=5>
    <tr>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>����</font></td>
      <td colspan="1" width=100><input name="name" type="text"size="10" value="<? echo $row["name"];?>"/>*</td>

      <td bgColor=#5a6e8f width=100 align=center><font color=#FFFFFF>����ְ��</font></td>
      <td width=115><? 
      	echo "<select name=techpos size=1>";
      	$zhichenglist = array("��ʦ","������","����","����","ʵ��ʦ","�߼�ʵ��ʦ","����ʵ��ʦ");
      	while(list($k,$v)= each($zhichenglist)){
      		if($row["techpos"]==$v) $s = "selected";
      		else $s = "";
      		echo "<option name=techpos ".$s." value=".$v.">".$v."</option>\n";
      	}
      	echo "</select>*";
      	?></td>
      <td bgColor=#5a6e8f align="center" width=100><font color=#FFFFFF>��ְ��<br>ͨ������</font></td>
      <td width=190><input name="techposdate" type="text" id="techposdate" size="12" value="<? echo $row["techposdate"];?>" onclick="WdatePicker({dateFmt:'yyyy.MM'})" onchange="checkInputDate(this)" class="Wdate"/>*</td>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>����ְ��</font></td>
      <td width=95><input name="officepos" type="text" size="10" value="<? echo $row["officepos"];?>"/></td>
    </tr>
    <tr>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>�Ա�</font></td>
      <td width=80><input name="sex" type="text" size="6" value="<? echo $row["sex"];?>" />*</td>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>��������</font></td>
      <td width=190><input name="birthday" type="text" id="birthday" size="12" value="<? echo $row["birthday"];?>" onclick="WdatePicker({dateFmt:'yyyy.MM'})" onchange="checkInputDate(this)" class="Wdate"/>*</td>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>������</font></td>
      <td width=115><input name="hometown" type="text" size="12" value="<? echo $row["hometown"];?>"/>*</td>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>������ò</font></td>
      <td width=95><input name="zhengzhi" type="text" size="10" value="<? echo $row["zhengzhi"];?>"/>*</td>
    </tr>
    <tr>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>����</font></td>
      <td width=80><input name="minzhu" type="text" size="6" value="<? echo $row["minzhu"];?>" />*</td>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>�Ļ��̶�</font></td>
  <td width=190><input name="educatelevel" type="text" size="12" value="<? echo $row["educatelevel"];?>"/>*</td>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>ѧλ</font></td>
      <td width=115><input name="degree" type="text" size="12" value="<? echo $row["degree"];?>"/>*</td>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>��ҵʱ��</font></td>
      <td width=95><input name="graduate" type="text" size="10" 
      	value="<? echo $row["graduate"];?>" onclick="WdatePicker({dateFmt:'yyyy.MM'})" onchange="checkInputDate(this)" class="Wdate"/>*</td>
    </tr>
    <tr>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>��ҵѧУ</font></td>
      <td colspan="3" width=350><input name="graduateschool" type="text" size="30" value="<? echo $row["graduateschool"];?>" />*</td>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>��ѧרҵ</font></td>
      <td colspan="3" width=290><input name="profession" type="text" size="30" value="<? echo $row["profession"];?>" />*</td>
    </tr>
    <tr>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>����רҵ</font></td>
      <td colspan="3" width=350><input name="jobfield" type="text" size="30" value="<? echo $row["jobfield"];?>" /></td>
      <td bgColor=#5a6e8f align="center" width=80><font color=#FFFFFF>�����ʼ�</font></td>
      <td colspan="3" width=290><input name="email" type="text" size="30" value="<? echo $row["email"];?>"/>*</td>
    </tr>
    <tr>
      <td colspan="8"  width=800>��Ҫ�γ̼��о�����<br />
          <textarea name="research" cols="80" rows="6"><? echo $row["research"];?></textarea></td>
    </tr>
    <tr>
      <td colspan="8"><div align="center">�����</div></td>
    </tr>
    <tr>
      <td colspan="2" width=160><div align="center">��������</div></td>
      <td colspan="3" width=350><div align="center">��Ŀ����</div></td>
      <td width=95><div align="center">�ȼ�</div></td>
      <td width=80><div align="center">����</div></td>
      <td width=95><div align="center">���</div></td>
    </tr>
    <tr align="center">
      <td colspan="2"><input name="prise1" type="text" size="20" value="<? echo $row["prise1"];?>"/></td>
      <td colspan="3"><input name="prisename1" type="text" size="30" value="<? echo $row["prisename1"];?>"/></td>
      <td><input name="level1" type="text" size="10" value="<? echo $row["level1"];?>"/></td>
      <td><input name="grade1" type="text" size="6" value="<? echo $row["grade1"];?>"/></td>
      <td><input name="year1" type="text"  size="12" value="<? echo $row["year1"];?>"/></td>
    </tr>
    <tr align="center">
      <td colspan="2"><input name="prise2" type="text" size="20" value="<? echo $row["prise2"];?>" /></td>
      <td colspan="3"><input name="prisename2" type="text" size="30" value="<? echo $row["prisename2"];?>" /></td>
      <td><input name="level2" type="text" size="10" value="<? echo $row["level2"];?>" /></td>
      <td><input name="grade2" type="text" size="6" value="<? echo $row["grade2"];?>"/></td>
      <td><input name="year2" type="text"  size="12" value="<? echo $row["year2"];?>"/></td>
    </tr>
    <tr align="center">
      <td colspan="2"><input name="prise3" type="text"size="20" value="<? echo $row["prise3"];?>"/></td>
      <td colspan="3"><input name="prisename3" type="text" size="30" value="<? echo $row["prisename3"];?>"/></td>
      <td><input name="level3" type="text" size="10" value="<? echo $row["level3"];?>"/></td>
      <td><input name="grade3" type="text" size="6" value="<? echo $row["grade3"];?>"/></td>
      <td><input name="year3" type="text"  size="12" value="<? echo $row["year3"];?>"/></td>
    </tr>
    <tr>
      <td colspan="8">�������ġ������ͽ̲�</td>
    </tr>
    <tr>
      <td colspan="5"><div align="center">������Ŀ�������ͽ̲�����</div></td>
      <td colspan="3"><div align="center">�����ڿ���������</div></td>
    </tr>
    <tr align="center">
      <td colspan="5"><input name="writing1" type="text" size="50" value="<? echo $row["writing1"];?>"/></td>
      <td colspan="3"><input name="publish1" type="text" size="35" value="<? echo $row["publish1"];?>"/></td>
    </tr>
    <tr align="center">
      <td colspan="5"><input name="writing2" type="text" size="50" value="<? echo $row["writing2"];?>"/></td>
      <td colspan="3"><input name="publish2" type="text" size="35" value="<? echo $row["publish2"];?>"/></td>
    </tr>
    <tr align="center">
      <td colspan="5"><input name="writing3" type="text" size="50" value="<? echo $row["writing3"];?>"/></td>
      <td colspan="3"><input name="publish3" type="text" size="35" value="<? echo $row["publish3"];?>" /></td>
    </tr>
    <tr>
      <td colspan="8">���гɹ�</td>
    </tr>
    <tr>
      <td colspan="5"><div align="center">����</div></td>
      <td colspan="3"><div align="center">�´���������赥λ��</div></td>
    </tr>
    <tr align="center">
      <td colspan="5"><input name="achieve1" type="text" size="50" value="<? echo $row["achieve1"];?>"/></td>
      <td colspan="3"><input name="department1" type="text" size="35" value="<? echo $row["department1"];?>"/></td>
    </tr>
    <tr align="center">
      <td colspan="5"><input name="achieve2" type="text" size="50" value="<? echo $row["achieve2"];?>"/></td>
      <td colspan="3"><input name="department2" type="text" size="35" value="<? echo $row["department2"];?>"/></td>
    </tr>
    <tr align="center">
      <td colspan="5"><input name="achieve3" type="text" size="50" value="<? echo $row[achieve3];?>"/></td>
      <td colspan="3"><input name="department3" type="text" size="35" value="<? echo $row["department3"];?>"/></td>
    </tr>
    <tr>
      <td colspan="8"><div align="center">
          <input type="submit" name="submit" value="�� ��" />
        &nbsp;&nbsp;
        <input type="reset" name="reset" value="�� ��" />
      </div></td>
    </tr>
  </table>
</form>

<?php
if($_POST["submit"]){
	$name = trim($_POST["name"]);
	$update = mysql_query("update ".$TABLE."teacher_information set name='$name',techpos='$_POST[techpos]',officepos='$_POST[officepos]',sex='$_POST[sex]',birthday='$_POST[birthday]',techposdate='$_POST[techposdate]',hometown='$_POST[hometown]',zhengzhi='$_POST[zhengzhi]',minzhu='$_POST[minzhu]',educatelevel='$_POST[educatelevel]',degree='$_POST[degree]',graduate='$_POST[graduate]',graduateschool='$_POST[graduateschool]',profession='$_POST[profession]',jobfield='$_POST[jobfield]',email='$_POST[email]',research='$_POST[research]',prise1='$_POST[prise1]',prisename1='$_POST[prisename1]',level1='$_POST[level1]',grade1='$_POST[grade1]',year1='$_POST[year1]',prise2='$_POST[prise2]',prisename2='$_POST[prisename2]',level2='$_POST[level2]',grade2='$_POST[grade2]',year2='$_POST[year2]',prise3='$_POST[prise3]',prisename3='$_POST[prisename3]',level3='$_POST[level3]',grade3='$_POST[grade3]',year3='$_POST[year3]',writing1='$_POST[writing1]',publish1='$_POST[publish1]',writing2='$_POST[writing2]',publish2='$_POST[publish2]',writing3='$_POST[writing3]',publish3='$_POST[publish3]',achieve1='$_POST[achieve1]',department1='$_POST[department1]',achieve2='$_POST[achieve2]',department2='$_POST[department2]',achieve3='$_POST[achieve3]',department3='$_POST[department3]' where teacher_id = '$teacher_id'");
	if($update){
		echo "<script>alert('�����ύ�ɹ���');history.back();</script>";
	}else{
		echo "<script>alert('�����ύʧ�ܣ�');history.back();</script>";
	}
}
?>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>