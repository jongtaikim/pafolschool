<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/admin/xml.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 동아리 관리 메뉴 xml 파일
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
	<tree icon="image/icon/spinner.gif" text="카페기본설정" action="party.admin.manage?pcode=<?=$pcode?>" target="padmin_content"/>

	<tree icon="image/icon/datepicker.gif" text="디자인관리"  target="padmin_content">
	


	<tree icon="image/icon/htm.gif" text="카페메인대문" action="party.admin.edit?pcode=<?=$pcode?>" target="padmin_content"/>

	</tree>

	<tree icon="image/icon/member.gif" text="회원관리"  target="padmin_content">

	<tree icon="image/icon/member.gif" text="카페회원관리" action="party.member.admin.list?pcode=<?=$pcode?>" target="padmin_content"/>
	<!--tree icon="image/icon/member.gif" text="카페가입요청사승인" action="party.member.admin.in?pcode=<?=$pcode?>" target="padmin_content"/>
	<tree icon="image/icon/member.gif" text="블랙리스트관리" action="party.member.admin.black?pcode=<?=$pcode?>" target="padmin_content"/>
	<tree icon="image/icon/member.gif" text="등업조건설정" action="party.member.admin.mtype?pcode=<?=$pcode?>" target="padmin_content"/-->


	</tree>

	<tree icon="image/icon/madang.png" text="메뉴관리" action="party.menu.admin.menutool?pcode=<?=$pcode?>" target="padmin_content"/>


</tree>
<?php
exit;
?>