<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-07-17
* �ۼ���: ������
* ��  ��:  ���̵�� Ÿ�Ը� ���� ī�� ����� 
*****************************************************************
* 
*/

function addCafe($str_cafe_id,$cate_type,$str_id,$title,$cafe_memo){
global $_OID;
if($str_cafe_id ) {
		
		//ĳ�� ����~~
		$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.clubObj.htm";
		 unlink($cache_file);


		$DB = &WebApp::singleton('DB');
        
		$pcode = $str_cafe_id;

		$sql = "SELECT  MAX(num_step)+1 FROM ".TAB_PARTY." WHERE num_oid=$_OID";
		$step = $DB->sqlFetchOne($sql);
        if(!$step) $step = 1;


		if(mktime() >$cafe_data[num_update]) {
		$mk = mktime() + (86400*180);
		$usql   = "num_ccode='$num_ccode' ,num_update = ".$mk." ";
		}



        $sql = "INSERT INTO ".TAB_PARTY." (
                    num_oid, num_pcode, num_step, str_pname, num_ccode , str_memo,str_mtype,str_id,str_date,str_type, cafe_memo
                ) VALUES (
                    $_OID, $pcode, $step, '$title', '$num_ccode','$str_memo','$mtype','nobody','".mktime()."','".$cate_type."','".$cafe_memo."'
                )";
		

        if($DB->query($sql)) {
    
            $DB->commit();
			
		
			/*$sql = "Insert into TAB_PARTY_MEMBER
			   (NUM_OID, NUM_PCODE, STR_ID, STR_MTYPE,  STR_IP, STR_DATE)
			 Values
			   ($_OID, $pcode, 'nobody', 'a',  '".$_SERVER[REMOTE_ADDR]."', '".mktime()."' )";
			$DB->query($sql);
			$DB->commit();
			*/
			define('_CAFETYPE', $cate_type);
			
			switch ($cate_type) {
					case "class":
				
					
					
					//2009-04-14 ���� �Խ��� �⺻ ���Ѽ����߰�
					$mem_types = WebApp::get('party.member',array('key'=>'member_types'));
				
					$cafe_defult_menu[] = array("mcode"=>11, "str_title"=>"�˸���", "type"=>"A", "mainview"=>"Y");
					$cafe_defult_menu[] = array("mcode"=>10, "str_title"=>"��������", "type"=>"A", "mainview"=>"Y");
					$cafe_defult_menu[] = array("mcode"=>13, "str_title"=>"�����Խ���", "type"=>"B", "mainview"=>"Y");
					$cafe_defult_menu[] = array("mcode"=>14, "str_title"=>"������", "type"=>"B", "mainview"=>"Y");


					for($a=0 ; $a<sizeof($cafe_defult_menu) ; $a++){
						//����Ʈ �Խ��� �߰�
						$sql = "Insert into TAB_PARTY_BOARD_CONFIG
									(NUM_OID, NUM_PCODE, NUM_MCODE, STR_TITLE, STR_SKIN, CHR_LISTTYPE, CHR_ODDCOLOR, CHR_EVENCOLOR, 
									CHR_COMMENT, CHR_RECENT, CHR_UPLOAD, STR_MAIN_VIEW)
									Values
									("._OID.", $pcode, ".$cafe_defult_menu[$a]['mcode'].", '".$cafe_defult_menu[$a]['str_title']."', 'board', '".$cafe_defult_menu[$a]['type']."', '#FFFFFF', '#FFFFFF', 'Y', 'N', 'Y', '".$cafe_defult_menu[$a]['mainview']."')";
						$DB->query($sql);
						$DB->commit();

						//�Խ��� �⺻ ���� ����
						foreach($mem_types as $mem_type => $_value) {
							$sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right)".
								   "VALUES ("._OID.",'party','".$pcode.".".$cafe_defult_menu[$a]['mcode']."','$mem_type','lr')";
							$DB->query($sql);
						}
						$DB->commit();

					}




					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET)
					 Values
					   ("._OID.", $pcode, 11, 2, '�˸���', 'board#B', 1, 'party.board.list?pcode=11&mcode=11', '_self')";
					  
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
					   ("._OID.", $pcode, 14, 6, '������', 'board#B', 1, 'party.board.list?pcode=11&mcode=14', '_self', 'Y')";
					$DB->query($sql);$DB->commit();

					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_TARGET)
					 Values
					   ("._OID.", $pcode, 15, 4, '�л�����', 'title', 1, '_self')";
					$DB->query($sql);$DB->commit();


	
						
						 
				 
				 
				 
				 
				 break;
				case "cafe":
				

					//2009-04-14 ���� �Խ��� �⺻ ���Ѽ����߰�
					$mem_types = WebApp::get('party.member',array('key'=>'member_types'));
				
					$cafe_defult_menu[] = array("mcode"=>11, "str_title"=>"�����λ�", "type"=>"B", "mainview"=>"N");
					$cafe_defult_menu[] = array("mcode"=>10, "str_title"=>"��������", "type"=>"A", "mainview"=>"Y");
					$cafe_defult_menu[] = array("mcode"=>13, "str_title"=>"�����Խ���", "type"=>"B", "mainview"=>"Y");
					$cafe_defult_menu[] = array("mcode"=>14, "str_title"=>"ȸ��������", "type"=>"B", "mainview"=>"Y");


					for($a=0 ; $a<sizeof($cafe_defult_menu) ; $a++){
						//����Ʈ �Խ��� �߰�
						$sql = "Insert into TAB_PARTY_BOARD_CONFIG
									(NUM_OID, NUM_PCODE, NUM_MCODE, STR_TITLE, STR_SKIN, CHR_LISTTYPE, CHR_ODDCOLOR, CHR_EVENCOLOR, 
									CHR_COMMENT, CHR_RECENT, CHR_UPLOAD, STR_MAIN_VIEW)
									Values
									("._OID.", $pcode, ".$cafe_defult_menu[$a]['mcode'].", '".$cafe_defult_menu[$a]['str_title']."', 'board', '".$cafe_defult_menu[$a]['type']."', '#FFFFFF', '#FFFFFF', 'Y', 'N', 'Y', '".$cafe_defult_menu[$a]['mainview']."')";
						$DB->query($sql);
						$DB->commit();

						//�Խ��� �⺻ ���� ����
						foreach($mem_types as $mem_type => $_value) {
							$sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right)".
								   "VALUES ("._OID.",'party','".$pcode.".".$cafe_defult_menu[$a]['mcode']."','$mem_type','lr')";
							$DB->query($sql);
						}
						$DB->commit();

					}


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
					   ("._OID.", $pcode, 14, 6, 'ȸ��������', 'board#B', 1, 'party.board.list?pcode=11&mcode=14', '_self', 'Y')";
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

				

				
				break;
				
				case "office":


					//2009-04-14 ���� �Խ��� �⺻ ���Ѽ����߰�
					$mem_types = WebApp::get('party.member',array('key'=>'member_types'));

					$cafe_defult_menu[] = array("mcode"=>11, "str_title"=>"�����λ�", "type"=>"B", "mainview"=>"N");
					$cafe_defult_menu[] = array("mcode"=>10, "str_title"=>"��������", "type"=>"A", "mainview"=>"Y");
					$cafe_defult_menu[] = array("mcode"=>13, "str_title"=>"�����Խ���", "type"=>"B", "mainview"=>"Y");
					$cafe_defult_menu[] = array("mcode"=>14, "str_title"=>"ȸ��������", "type"=>"B", "mainview"=>"Y");
					

					for($a=0 ; $a<sizeof($cafe_defult_menu) ; $a++){
						//����Ʈ �Խ��� �߰�
						$sql = "Insert into TAB_PARTY_BOARD_CONFIG
									(NUM_OID, NUM_PCODE, NUM_MCODE, STR_TITLE, STR_SKIN, CHR_LISTTYPE, CHR_ODDCOLOR, CHR_EVENCOLOR, 
									CHR_COMMENT, CHR_RECENT, CHR_UPLOAD, STR_MAIN_VIEW)
									Values
									("._OID.", $pcode, ".$cafe_defult_menu[$a]['mcode'].", '".$cafe_defult_menu[$a]['str_title']."', 'board', '".$cafe_defult_menu[$a]['type']."', '#FFFFFF', '#FFFFFF', 'Y', 'N', 'Y', '".$cafe_defult_menu[$a]['mainview']."')";
						$DB->query($sql);
						$DB->commit();

						//�Խ��� �⺻ ���� ����
						foreach($mem_types as $mem_type => $_value) {
							$sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right)".
								   "VALUES ("._OID.",'party','".$pcode.".".$cafe_defult_menu[$a]['mcode']."','$mem_type','lr')";
							$DB->query($sql);
						}
						$DB->commit();

					}


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
					   ("._OID.", $pcode, 14, 6, 'ȸ��������', 'board#B', 1, 'party.board.list?pcode=11&mcode=14', '_self', 'Y')";
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
				 break;

				}


			



        } 
    }

}
?>