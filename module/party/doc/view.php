<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/doc/view.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 웹문서 출력
*****************************************************************
* 
*/
$PERM = WebApp::singleton('Permission');
$PERM->apply('party',$pcode.'.'.$mcode,'r');
$mcode = $_REQUEST['mcode'];
$FH = WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);

$MSG = WebApp_Message::fromFile(Display::getTemplate('doc/party.'.$pcode.'.'.$mcode.'.msg'));
$GLOBALS['DOC_TITLE'] = $MSG->header['Title-Decorator'].':'.$MSG->header['Title'];
$body = $FH->set_content($MSG->__toString());
if (!$body) $body = '<center>내용이 없습니다. 내용을 입력해주세요</center>';




if(!$pcode) WebApp::moveBack('잘못된 요청입니다.');


$DB = &WebApp::singleton("DB");

$data_one = $DB -> sqlFetch("select * from TAB_PARTY where num_oid = '$_OID' and num_pcode = '$pcode' ");
$tpl->assign(array(
			'pname'=>$data_one[str_pname],
			'off'=>$data_one[str_officer],
			'pcode'=>$pcode,
					'str_img1'=>$data_one[str_img1],
			'str_img2'=>$data_one[str_img2],
			'str_img3'=>$data_one[str_img3],
			'str_memo'=>$data_one[str_memo],

			));

$sql = "select num_pcode,str_pname from TAB_PARTY where num_oid = '$_OID' ";
$row = $DB -> sqlFetchAll($sql);
$tpl->assign(array('URL_LIST'=>$row));



//동아리 메뉴
if ($pcode) {
    //==-- 동아리 홈페이지 메뉴 --==//
     global $PARTY_CONF;
    $DB = &WebApp::singleton('DB');
    $sql = "SELECT * FROM ".TAB_PARTY_MENU." WHERE num_oid="._OID." AND num_pcode=$pcode AND num_view=1 ORDER BY num_step";
    $DB->query($sql);
    $data = array();


    while($row = $DB->fetch()) {
        $row['class'] = $class.($mcode == $row['num_mcode'] ? ' '.$class_current : '');
       	$row['str_title'] = Display::text_cut($row['str_title'],22,".."); 
		$data[] = $row;
			
			
    }
 

} 

$tpl->setLayout('p');

$tpl->assign(array(
  'SUBMENU2'=>$data,
));


$tpl->setLayout('p');
$tpl->define('#CONTENT',$body);

// {{{ Functions
// }}}
?>
