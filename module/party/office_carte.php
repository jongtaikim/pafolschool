<?



if($pcode < 9){
	$sql = "select count(*) from TAB_PARTY where num_oid = "._OID." and num_pcode = $pcode ";
	$count_pcode1 = $DB -> sqlFetchOne($sql);
	
	

	if($count_pcode1<1){
	 $sql = "Insert into TAB_PARTY
	   (NUM_OID, NUM_PCODE, NUM_STEP, STR_PNAME, STR_MEMO, STR_ID, STR_LAYOUT, STR_SKIN, STR_MTYPE, CAFE_MEMO, CAFE_TITLE, NUM_USER, NUM_BOARD, NUM_CCODE, TOP_MENU_LINE, STR_TYPE)
	 Values
	   ("._OID.", $pcode, $pcode, '�¶��α�����', '�¶��α�����', 'admin', 'tt01', 'A_board', 'w', '�¶��α����ǿ� ���Ű� ȯ���մϴ�.', 'Y', 1, 0, 0, 'y', 'office')";

	$DB->query($sql);



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
						

						//�Խ��� �⺻ ���� ����
						foreach($mem_types as $mem_type => $_value) {
							$sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right)".
								   "VALUES ("._OID.",'party','".$pcode.".".$cafe_defult_menu[$a]['mcode']."','$mem_type','lr')";
							$DB->query($sql);
						}
						

					}


					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET)
					 Values
					   ("._OID.", $pcode, 11, 2, '�����λ�', 'board#B', 1, 'party.board.list?pcode=11&mcode=11', '_self')";
					$DB->query($sql);;

					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_TARGET)
					 Values
					   ("._OID.", $pcode, 12, 3, '------------------', 'separator', 1, '_self')";
					$DB->query($sql);;

					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET)
					 Values
					   ("._OID.", $pcode, 10, 1, '��������', 'board#A', 1, 'party.board.list?pcode=11&mcode=10', '_self')";
					$DB->query($sql);;

					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET, STR_IN)
					 Values
					   ("._OID.", $pcode, 13, 5, '�����Խ���', 'board#B', 1, 'party.board.list?pcode=11&mcode=13', '_self', 'Y')";
					$DB->query($sql);;

					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET, STR_IN)
					 Values
					   ("._OID.", $pcode, 14, 6, 'ȸ��������', 'board#B', 1, 'party.board.list?pcode=11&mcode=14', '_self', 'Y')";
					$DB->query($sql);;

					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_TARGET)
					 Values
					   ("._OID.", $pcode, 15, 4, 'ȸ������', 'title', 1, '_self')";
					$DB->query($sql);;

				
					$DB->commit();
	}


}
?>