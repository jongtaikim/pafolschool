<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-01-15
* �ۼ���: ������
* ��  ��:  ī�� �����
*****************************************************************
* 
*/
$DOC_TITLE = "str:ī�丸���";

switch($REQUEST_METHOD) {
	case "GET":
        $tpl->setLayout();
        $tpl->define('CONTENT','html/party/cafe_add.htm');

	break;
	case "POST":

		$DB = &WebApp::singleton('DB');
        
		$sql = "SELECT  MAX(num_pcode)+1 FROM ".TAB_PARTY." WHERE num_oid=$_OID";
		$pcode = $DB->sqlFetchOne($sql);
        if(!$pcode) $pcode = 10;

		$sql = "SELECT  MAX(num_step)+1 FROM ".TAB_PARTY." WHERE num_oid=$_OID";
		$step = $DB->sqlFetchOne($sql);
        if(!$step) $step = 1;


		if(mktime() >$cafe_data[num_update]) {
		$mk = mktime() + (86400*180);
		$usql   = "num_ccode='$num_ccode' ,num_update = ".$mk." ";
		}



        $sql = "INSERT INTO ".TAB_PARTY." (
                    num_oid, num_pcode, num_step, str_pname, num_ccode , str_memo,str_mtype,str_id,str_date
                ) VALUES (
                    $_OID, $pcode, $step, '$str_pname', '$num_ccode','$str_memo','$mtype','".$_SESSION[USERID]."','".mktime()."'
                )";

        if($DB->query($sql)) {
    
            $DB->commit();

			$sql = "Insert into TAB_PARTY_MEMBER
			   (NUM_OID, NUM_PCODE, STR_ID, STR_MTYPE,  STR_IP, STR_DATE)
			 Values
			   ($_OID, $pcode, 'now17', 'a',  '".$_SERVER[REMOTE_ADDR]."', '".mktime()."' )";
			$DB->query($sql);
			$DB->commit();

			







			$sql = "Insert into TAB_PARTY_BOARD_CONFIG
			   (NUM_OID, NUM_PCODE, NUM_MCODE, STR_TITLE, STR_SKIN, CHR_LISTTYPE, CHR_ODDCOLOR, CHR_EVENCOLOR, CHR_COMMENT, CHR_RECENT, CHR_UPLOAD, STR_MAIN_VIEW)
			 Values
			   ("._OID.", $pcode, 11, '�����λ�', 'board', 'B', '#FFFFFF', '#FFFFFF', 'Y', 'N', 'Y', 'N')";
			$DB->query($sql);$DB->commit();

			$sql = "Insert into TAB_PARTY_BOARD_CONFIG
			   (NUM_OID, NUM_PCODE, NUM_MCODE, STR_TITLE, STR_SKIN, CHR_LISTTYPE, CHR_ODDCOLOR, CHR_EVENCOLOR, CHR_COMMENT, CHR_RECENT, CHR_UPLOAD, STR_MAIN_VIEW)
			 Values
			   ("._OID.", $pcode, 10, '��������', 'board', 'A', '#FFFFFF', '#FFFFFF', 'Y', 'N', 'Y', 'Y')";
			$DB->query($sql);$DB->commit();

			$sql = "Insert into TAB_PARTY_BOARD_CONFIG
			   (NUM_OID, NUM_PCODE, NUM_MCODE, STR_TITLE, STR_SKIN, CHR_LISTTYPE, CHR_ODDCOLOR, CHR_EVENCOLOR, CHR_COMMENT, CHR_RECENT, CHR_UPLOAD, STR_MAIN_VIEW)
			 Values
			   ("._OID.", $pcode, 13, '�����Խ���', 'board', 'B', '#FFFFFF', '#FFFFFF', 'Y', 'N', 'Y', 'Y')";
			$DB->query($sql);$DB->commit();

			$sql = "Insert into TAB_PARTY_BOARD_CONFIG
			   (NUM_OID, NUM_PCODE, NUM_MCODE, STR_TITLE, STR_SKIN, CHR_LISTTYPE, CHR_ODDCOLOR, CHR_EVENCOLOR, CHR_COMMENT, CHR_RECENT, CHR_UPLOAD, STR_MAIN_VIEW)
			 Values
			   ("._OID.", $pcode, 14, 'ȸ���ַ���', 'gallery', 'B', '#FFFFFF', '#FFFFFF', 'Y', 'N', 'Y', 'Y')";
			$DB->query($sql);$DB->commit();

			$sql = "Insert into TAB_PARTY_BOARD_CONFIG
			   (NUM_OID, NUM_PCODE, NUM_MCODE, STR_TITLE, STR_SKIN, CHR_LISTTYPE, CHR_ODDCOLOR, CHR_EVENCOLOR, CHR_COMMENT, CHR_RECENT, CHR_UPLOAD, STR_MAIN_VIEW)
			 Values
			   ("._OID.", $pcode, 17, '�޸���', 'memo', 'B', '#FFFFFF', '#FFFFFF', 'Y', 'N', 'Y', 'N')";
			$DB->query($sql);$DB->commit();






			$sql = "Insert into TAB_PARTY_MENU
			   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET)
			 Values
			   ("._OID.", $pcode, 11, 2, '�����λ�', 'board#B', 1, 'party.board.list?pcode=11&mcode=11', '_self')";
			$DB->query($sql);$DB->commit();

			$sql = "Insert into TAB_PARTY_MENU
			   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_TARGET)
			 Values
			   ("._OID.", $pcode, 12, 3, '------------------', 'separator', 1, '_self')";
			$DB->query($sql);$DB->commit();

			$sql = "Insert into TAB_PARTY_MENU
			   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET)
			 Values
			   ("._OID.", $pcode, 10, 1, '��������', 'board#A', 1, 'party.board.list?pcode=11&mcode=10', '_self')";
			$DB->query($sql);$DB->commit();

			$sql = "Insert into TAB_PARTY_MENU
			   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET, STR_IN)
			 Values
			   ("._OID.", $pcode, 13, 5, '�����Խ���', 'board#B', 1, 'party.board.list?pcode=11&mcode=13', '_self', 'Y')";
			$DB->query($sql);$DB->commit();

			$sql = "Insert into TAB_PARTY_MENU
			   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET, STR_IN)
			 Values
			   ("._OID.", $pcode, 14, 6, 'ȸ���ַ���', 'board#B', 1, 'party.board.list?pcode=11&mcode=14', '_self', 'Y')";
			$DB->query($sql);$DB->commit();

			$sql = "Insert into TAB_PARTY_MENU
			   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_TARGET)
			 Values
			   ("._OID.", $pcode, 15, 4, 'ȸ������', 'title', 1, '_self')";
			$DB->query($sql);$DB->commit();

			$sql = "Insert into TAB_PARTY_MENU
			   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_TARGET)
			 Values
			   ("._OID.", $pcode, 16, 7, '------------------', 'separator', 1, '_self')";
			$DB->query($sql);$DB->commit();

			$sql = "Insert into TAB_PARTY_MENU
			   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET)
			 Values
			   ("._OID.", $pcode, 17, 8, '�޸���', 'board#B', 1, 'party.board.list?pcode=11&mcode=17', '_self')";
			$DB->query($sql);$DB->commit();





            WebApp::redirect("cafe?no=$pcode",'�����Ǿ����ϴ�.');
        } else {

            WebApp::moveBack('�������� : DB �����Դϴ�.');
        }
	break;
}
?>