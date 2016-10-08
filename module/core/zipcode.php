<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/core/zipcode.php
* 작성일: 2005-07-08
* 작성자: 거친마루
* 설  명: 우편번호 검색 (sqlite버전)
*****************************************************************
* 
*/
$q = $_REQUEST['q'];
$form = $_REQUEST['form'];
$el_addr = $_REQUEST['el_addr'];
$el_zip = $_REQUEST['el_zip'];
$el_zip1 = $_REQUEST['el_zip1'];
$el_zip2 = $_REQUEST['el_zip2'];
$el_focus = $_REQUEST['el_focus'];
$vars = compact('form','el_addr','el_zip','el_zip1','el_zip2','el_focus');

$tpl->setLayout('admin_xhtml');
$tpl->define('CONTENT', Display::getTemplate('core/zipcode.htm'));
$tpl->assign('q',$q);
$tpl->assign($vars);

switch (REQUEST_METHOD) {
	case 'GET':
        // nothing
        break;
    case 'POST':
        $DB = WebApp::singleton('DB');
        $sql = "
            SELECT * FROM
                zipcode
            WHERE
                DONG LIKE '{$q}%' OR
               
                BUNJI LIKE '{$q}%'
        ";
        $data = $DB->sqlFetchAll($sql);
		
        @array_walk($data,'cb_format_address');
        $tpl->assign('LIST', &$data);
        break;
}


// {{{ Functions
function cb_format_address(&$arr) {
    list($arr['zip1'],$arr['zip2']) = explode('-',$arr['zipcode']);
    $arr['addr'] = $arr['sido'].' '.$arr['gugun'].' '.$arr['dong'];
    if (!empty($arr['ri'])) $arr['addr'].= ' '.$arr['ri'];
    if (!empty($arr['bunji'])) $arr['addr'].= ' '.$arr['bunji'];
    $arr['input_addr'] = $arr['addr'];
    if (!empty($arr['st_bunji'])) $arr['addr'].= ' '.$arr['st_bunji'].'~'.$arr['ed_bunji'];
    unset($arr['sido'],$arr['gugun'],$arr['dong'],$arr['ri'],$arr['bldg'],$arr['st_bunji'],$arr['ed_bunji']);
}
// }}}
?>
