<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/admin/xml.php
* �ۼ���: 2006-05-16
* �ۼ���: �̹���
* ��  ��: ���Ƹ� ���� �޴� xml ����
*****************************************************************
* 
*/
header('Content-type: text/xml');
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

echo '<?xml version="1.0" encoding="euc-kr"?'.'>';
?>
<tree>
	<tree icon="image/icon/spinner.gif" text="ī��⺻����" action="party.admin.manage?pcode=<?=$pcode?>" target="padmin_content"/>

	<tree icon="image/icon/datepicker.gif" text="�����ΰ���"  target="padmin_content">
	


	<tree icon="image/icon/htm.gif" text="ī����δ빮" action="party.admin.edit?pcode=<?=$pcode?>" target="padmin_content"/>

	</tree>

	<tree icon="image/icon/member.gif" text="ȸ������"  target="padmin_content">

	<tree icon="image/icon/member.gif" text="ī��ȸ������" action="party.member.admin.list?pcode=<?=$pcode?>" target="padmin_content"/>
	<!--tree icon="image/icon/member.gif" text="ī�䰡�Կ�û�����" action="party.member.admin.in?pcode=<?=$pcode?>" target="padmin_content"/>
	<tree icon="image/icon/member.gif" text="������Ʈ����" action="party.member.admin.black?pcode=<?=$pcode?>" target="padmin_content"/>
	<tree icon="image/icon/member.gif" text="������Ǽ���" action="party.member.admin.mtype?pcode=<?=$pcode?>" target="padmin_content"/-->


	</tree>

	<tree icon="image/icon/madang.png" text="�޴�����" action="party.menu.admin.menutool?pcode=<?=$pcode?>" target="padmin_content"/>


</tree>
<?php
exit;
?>