<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-01-07
* 작성자: 이현민
* 설   명: 카테고리추가
*****************************************************************
* 
*/
$PERM->apply('menu',$mcode,'w');
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":

		$sql = "select num_serial, str_category from TAB_BOARD_CATEGORY where num_oid = '$_OID' and num_mcode = '$mcode' ";
		$row = $DB -> sqlFetchAll($sql);
		$tpl->assign(array('cate_LIST'=>$row,'noresize'=>$noresize));

		$tpl->setLayout('admin');
		$tpl->define("CONTENT", WebApp::getTemplate("board/categorypop.htm"));
		
	 break;
	case "POST":
		$sql = "select count(*) from TAB_BOARD_CATEGORY where num_oid = '$_OID' and num_mcode=$mcode and str_category='$str_category_text'";
		$cat_count = $DB -> sqlFetchOne($sql);

		if($mode == 'add'){	//카테고리 추가,수정
			if($str_category_text && ($str_category_text != '일반')){
				if(!$cat_count){

					if($str_category){
						//카테고리수정
						$sql = "update tab_board_category set str_category='$str_category_text' where num_oid='$_OID' and num_mcode=$mcode and str_category='$str_category'";
						$DB->query($sql);
						$DB->commit();
						WebApp::moveBack('수정되었습니다.');
					}else{
						//카테고리추가
						$sql = "
							SELECT
								/*+ INDEX_DESC (TAB_BOARD_CATEGORY PK_BOARD_CATEGORY) */
									max(NUM_SERIAL) + 1
							FROM
								TAB_BOARD_CATEGORY
							WHERE
								 num_oid = $_OID and num_mcode=$mcode
						";
						$cat_serial = $DB -> sqlFetchOne($sql);
						if (!$cat_serial) $cat_serial = 1;

						$sql = "INSERT INTO TAB_BOARD_CATEGORY(num_oid, num_mcode, num_serial, str_category) VALUES($_OID, $mcode, $cat_serial, '$str_category_text')";
						$DB->query($sql);
						$DB->commit();
						WebApp::moveBack();
					}
				}else{
					WebApp::moveBack('동일한 카테고리가 있습니다.');
				}
			}else{
				WebApp::moveBack('카테고리를 입력해주세요.');
			}

		}elseif($mode == 'del'){	//카테고리 삭제
			if($cat_count){
				$sql = "delete from tab_board_category where num_oid='$_OID' and num_mcode=$mcode and str_category='$str_category_text'";
				if($DB->query($sql)){
					$DB->commit();

					$sql = "UPDATE TAB_BOARD set str_category='일반' WHERE num_oid=$_OID AND num_mcode=$mcode and str_category='$str_category_text'";
                    $DB->query($sql);
                    $DB->commit();

					/*
                    // 게시판 게시물 삭제
                    $FH = &WebApp::singleton('FileHost');
                    $sql = "SELECT num_mcode,num_serial,
								str_text1,str_text2,str_text3,str_text4,str_text5,str_text6,str_text7,str_text8,str_text9,str_text10,
								str_text11,str_text12,str_text13,str_text14,str_text15,str_text16,str_text17,str_text18,str_text19,str_text20,
								str_thumb 
								FROM ".TAB_BOARD." 
								WHERE num_oid=$_OID AND num_mcode=$mcode and str_category='$str_category_text'";
                    if(!$data = $DB->sqlFetchAll($sql)) {
                        foreach ($data as $row) {
							$str_text = $row['str_text1'].$row['str_text2'].$row['str_text3'].$row['str_text4'].$row['str_text5'].$row['str_text6'].$row['str_text7'].$row['str_text8'].$row['str_text9'].$row['str_text10'].$row['str_text11'].$row['str_text12'].$row['str_text13'].$row['str_text14'].$row['str_text15'].$row['str_text16'].$row['str_text17'].$row['str_text18'].$row['str_text19'].$row['str_text20'];
                            $FH->set_code('menu',$row['num_mcode']);
                            if($row['str_thumb']) $FH->del_thumb($row['str_thumb']);
                            $FH->delete_as_html($str_text);
                            $FH->delete_as_main($row['num_serial']);

							$sql = "DELETE FROM ".TAB_BOARD_COMMENT." WHERE num_oid=$_OID AND num_mcode=$mcode and num_main=".$row[num_serial];
							$DB->query($sql);
							$DB->commit();

                        }
                    }

					$sql = "DELETE FROM ".TAB_BOARD." WHERE num_oid=$_OID AND num_mcode=$mcode and str_category='$str_category_text'";
                    $DB->query($sql);
                    $DB->commit();
					*/

					WebApp::moveBack('삭제되었습니다.');
				}else{
					WebApp::moveBack('Error!!!');
				}
			}
		}

	break;
}
?>