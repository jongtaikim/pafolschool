<?



if($pcode < 9){
	$sql = "select count(*) from TAB_PARTY where num_oid = "._OID." and num_pcode = $pcode ";
	$count_pcode1 = $DB -> sqlFetchOne($sql);
	
	

	if($count_pcode1<1){
	 $sql = "Insert into TAB_PARTY
	   (NUM_OID, NUM_PCODE, NUM_STEP, STR_PNAME, STR_MEMO, STR_ID, STR_LAYOUT, STR_SKIN, STR_MTYPE, CAFE_MEMO, CAFE_TITLE, NUM_USER, NUM_BOARD, NUM_CCODE, TOP_MENU_LINE, STR_TYPE)
	 Values
	   ("._OID.", $pcode, $pcode, '온라인교무실', '온라인교무실', 'admin', 'tt01', 'A_board', 'w', '온라인교무실에 오신걸 환영합니다.', 'Y', 1, 0, 0, 'y', 'office')";

	$DB->query($sql);



					$mem_types = WebApp::get('party.member',array('key'=>'member_types'));

					$cafe_defult_menu[] = array("mcode"=>11, "str_title"=>"가입인사", "type"=>"B", "mainview"=>"N");
					$cafe_defult_menu[] = array("mcode"=>10, "str_title"=>"공지사항", "type"=>"A", "mainview"=>"Y");
					$cafe_defult_menu[] = array("mcode"=>13, "str_title"=>"자유게시판", "type"=>"B", "mainview"=>"Y");
					$cafe_defult_menu[] = array("mcode"=>14, "str_title"=>"회원갤러리", "type"=>"B", "mainview"=>"Y");
			

					for($a=0 ; $a<sizeof($cafe_defult_menu) ; $a++){
						//디폴트 게시판 추가
						$sql = "Insert into TAB_PARTY_BOARD_CONFIG
									(NUM_OID, NUM_PCODE, NUM_MCODE, STR_TITLE, STR_SKIN, CHR_LISTTYPE, CHR_ODDCOLOR, CHR_EVENCOLOR, 
									CHR_COMMENT, CHR_RECENT, CHR_UPLOAD, STR_MAIN_VIEW)
									Values
									("._OID.", $pcode, ".$cafe_defult_menu[$a]['mcode'].", '".$cafe_defult_menu[$a]['str_title']."', 'board', '".$cafe_defult_menu[$a]['type']."', '#FFFFFF', '#FFFFFF', 'Y', 'N', 'Y', '".$cafe_defult_menu[$a]['mainview']."')";
						$DB->query($sql);
						

						//게시판 기본 권한 설정
						foreach($mem_types as $mem_type => $_value) {
							$sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right)".
								   "VALUES ("._OID.",'party','".$pcode.".".$cafe_defult_menu[$a]['mcode']."','$mem_type','lr')";
							$DB->query($sql);
						}
						

					}


					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET)
					 Values
					   ("._OID.", $pcode, 11, 2, '가입인사', 'board#B', 1, 'party.board.list?pcode=11&mcode=11', '_self')";
					$DB->query($sql);;

					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_TARGET)
					 Values
					   ("._OID.", $pcode, 12, 3, '------------------', 'separator', 1, '_self')";
					$DB->query($sql);;

					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET)
					 Values
					   ("._OID.", $pcode, 10, 1, '공지사항', 'board#A', 1, 'party.board.list?pcode=11&mcode=10', '_self')";
					$DB->query($sql);;

					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET, STR_IN)
					 Values
					   ("._OID.", $pcode, 13, 5, '자유게시판', 'board#B', 1, 'party.board.list?pcode=11&mcode=13', '_self', 'Y')";
					$DB->query($sql);;

					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_LINK, STR_TARGET, STR_IN)
					 Values
					   ("._OID.", $pcode, 14, 6, '회원갤러리', 'board#B', 1, 'party.board.list?pcode=11&mcode=14', '_self', 'Y')";
					$DB->query($sql);;

					$sql = "Insert into TAB_PARTY_MENU
					   (NUM_OID, NUM_PCODE, NUM_MCODE, NUM_STEP, STR_TITLE, STR_TYPE, NUM_VIEW, STR_TARGET)
					 Values
					   ("._OID.", $pcode, 15, 4, '회원공간', 'title', 1, '_self')";
					$DB->query($sql);;

				
					$DB->commit();
	}


}
?>