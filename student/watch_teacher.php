<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�鿴��ʦ��Ϣ";
$YM_ZT2 = "���ָ����ʦ��ϸ������Ϣ";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 1; //��ҳ������ҪȨ�ޣ���ͨѧ��
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;

$teacher_id = $_GET["teacher_id"];

$query = mysql_query("select * from ".$TABLE."teacher_information where teacher_id = '$teacher_id'");
$row = mysql_fetch_array($query);
?>

<table width="730" border="3" align="center" bordercolor="#333333"   cellpadding=6>
    <tr>
      <td><div align="center">������</div></td>
      <td colspan="2"><? echo $row["name"];?></td>
      <td><div align="center" class="STYLE6">����ְ�ƣ�</div></td>
      <td><? echo $row["techpos"];?></td>
      <td><div align="center">����ְ��</div></td>
      <td colspan="2"><? echo $row["officepos"];?></td>
    </tr>
    <tr>
      <td><div align="center">�Ա�</div></td>
      <td><? echo $row["sex"];?></td>
      <td><div align="center">�������ڣ�</div></td>
      <td><? echo $row["birthday"];?></td>
      <td><div align="center">�����أ�</div></td>
      <td><? echo $row["hometown"];?></td>
      <td><div align="center">������ò��</div></td>
      <td><? echo $row["zhengzhi"];?></td>
    </tr>
    <tr>
      <td><div align="center">���壺</div></td>
      <td><? echo $row["minzhu"];?></td>
      <td><div align="center">�Ļ��̶ȣ�</div></td>
      <td><? echo $row["educatelevel"];?></td>
      <td><div align="center">ѧ &nbsp;λ��</div></td>
      <td><? echo $row["degree"];?></td>
      <td><div align="center">��ҵʱ�䣺</div></td>
      <td><? echo $row["graduate"];?></td>
    </tr>
    <tr>
      <td><div align="center">��ҵѧУ��</div></td>
      <td colspan="3"><? echo $row["graduateschool"];?></td>
      <td><div align="center">��ѧרҵ��</div></td>
      <td colspan="3"><? echo $row["profession"];?></td>
    </tr>
    <tr>
      <td><div align="center">����רҵ��</div></td>
      <td colspan="3"><? echo $row["jobfield"];?></td>
      <td><div align="center">�����ʼ���</div></td>
      <td colspan="3"><? echo $row["email"];?></td>
    </tr>
    <tr>
      <td colspan="8">��Ҫ�γ̼��о�����<p>
	  <? echo $row["research"];?>
	  <p>  
	  </td>
    </tr>
    <tr>
      <td colspan="8"><div align="center">�����</div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">��������</div></td>
      <td colspan="3"><div align="center">��Ŀ����</div></td>
      <td><div align="center">�ȼ�</div></td>
      <td><div align="center">����</div></td>
      <td><div align="center">���</div></td>
    </tr>
    <tr align="center">
      <td colspan="2"><? echo $row["prise1"];?></td>
      <td colspan="3"><? echo $row["prisename1"];?></td>
      <td><? echo $row["level1"];?></td>
      <td><? echo $row["grade1"];?></td>
      <td><? echo $row["year1"];?></td>
    </tr>
    <tr align="center">
      <td colspan="2"><? echo $row["prise2"];?></td>
      <td colspan="3"><? echo $row["prisename2"];?></td>
      <td><? echo $row["level2"];?></td>
      <td><? echo $row["grade2"];?></td>
      <td><? echo $row["year2"];?></td>
    </tr>
    <tr align="center">
      <td colspan="2"><? echo $row["prise3"];?></td>
      <td colspan="3"><? echo $row["prisename3"];?></td>
      <td><? echo $row["level3"];?></td>
      <td><? echo $row["grade3"];?></td>
      <td><? echo $row["year3"];?></td>
    </tr>
    <tr>
      <td colspan="8">�������ġ������ͽ̲�</td>
    </tr>
    <tr>
      <td colspan="4"><div align="center">������Ŀ�������ͽ̲�����</div></td>
      <td colspan="4"><div align="center">�����ڿ���������</div></td>
    </tr>
    <tr align="center">
      <td colspan="4" width="50%"><? echo $row["writing1"];?></td>
      <td colspan="4"><? echo $row["publish1"];?></td>
    </tr>
    <tr align="center">
      <td colspan="4"><? echo $row["writing2"];?></td>
      <td colspan="4"><? echo $row["publish2"];?></td>
    </tr>
    <tr align="center">
      <td colspan="4"><? echo $row["writing3"];?></td>
      <td colspan="4"><? echo $row["publish3"];?></td>
    </tr>
    <tr>
      <td colspan="8">���гɹ�</td>
    </tr>
    <tr>
      <td colspan="4"><div align="center">����</div></td>
      <td colspan="4"><div align="center">�´���������赥λ��</div></td>
    </tr>
    <tr align="center">
      <td colspan="4" width="50%"><? echo $row["achieve1"];?></td>
      <td colspan="4"><? echo $row["department1"];?></td>
    </tr>
    <tr align="center">
      <td colspan="4"><? echo $row["achieve2"];?></td>
      <td colspan="4"><? echo $row["department2"];?></td>
    </tr>
    <tr align="center">
      <td colspan="4"><? echo $row["achieve3"];?></td>
      <td colspan="4"><? echo $row["department3"];?></td>
    </tr>
</table>
<?
  @include($baseDIR."/bysj/inc_foot.php");
?>
