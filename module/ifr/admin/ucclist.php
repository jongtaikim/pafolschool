<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/link/admin/seturl.php
* 작성일: 2005-04-01
* 작성자: 거친마루
* 설  명: 링크형 메뉴의 URL을 설정하는 다이얼로그
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch (REQUEST_METHOD) {
    case 'GET':
		
		$where = "
			a.num_member_cp_code = "._UCC."  and
			a.chr_category_id in ('259','251','188','189','190','191','193','194','220') and
			b.num_category_seq = a.chr_category_id  and
			LENGTH(b.num_mcode)=4
		";
		
		if($str_main_view) $where .= " and a.str_main_view='".$str_main_view."'";
		if($searchvalue) $where .= " and a.".$searchkey." like '%".$searchvalue."%'";
		
		$sql = "SELECT COUNT(*) FROM EZFLV.TB_CONTENT a , EZFLV.TB_CATEGORY b WHERE $where";
		$total = $DB->sqlFetchOne($sql);

		if(!$listnum)$listnum = 30;
		if(!$total) $total = 0;
		$page = $_REQUEST['page'];
		if (!$page) $page = 1;
		$seek = $listnum * ($page - 1);
		$offset = $seek + $listnum;
		$fno = $total-($listnum * ($page-1));

		$sql = "
		select a.* from (
				 select ROWNUM as RNUM, b.* from (
		SELECT 
		 a.STR_CONTENT_ID,
		 a.STR_CONTENT_NAME,
		 a.STR_CONTENT_TYPE_CODE,
		 a.STR_CONTENT_DESC,
		 a.STR_REG_CH_ID,
		 a.DT_REG_MP_DATE,
		 a.STR_MOD_CH_ID,
		 a.DT_MOD_MP_DATE,
		 a.STR_TAG,
		 a.CHR_SERVICE_STATE,
		 a.CHR_CONTENT_SHARE,
		 a.CHR_CONTENT_STATE,
		 a.DT_SERVICE_S_DATE,
		 a.DT_SERVOCE_E_DATE,
		 a.STR_COPYRIGHT,
		 a.STR_CREATOR,
		 a.DT_CREATE_DATE,
		 a.CHR_DELETE_FLAG,
		 a.CHR_CATEGORY_ID,
		 a.CHR_CONTENT_VERSION,
		 a.NUM_MEMBER_CP_CODE,
		 a.DT_REG_DATE,
		 a.STR_DURATION,
		 a.STR_FILE_SIZE,
		 a.STR_REAL_FILENAME,
		 a.NUM_DATA_RATE,
		 a.STR_IMAGE_NAME,
		 a.STR_IMAGE_PATH,
		 a.STR_THUMB_1_NAME,
		 a.STR_THUMB_1_PATH,
		 a.STR_THUMB_2_NAME,
		 a.STR_THUMB_2_PATH,
		 a.STR_THUMB_3_NAME,
		 a.STR_THUMB_3_PATH,
		 a.STR_THUMB_4_NAME,
		 a.STR_THUMB_4_PATH,
		 a.STR_FILE_NAME,
		 a.STR_FILE_PATH,
		 a.STR_SERVICE_URL,
		 a.STR_ID,
		 a.STR_MAIN_VIEW,

		 b.num_mcode

		from

		EZFLV.TB_CONTENT a , EZFLV.TB_CATEGORY b

		where 
			$where
		order by STR_CONTENT_ID desc

		)b)a
		where a.RNUM >=$seek and a.RNUM <= $offset ";

		$data = $DB -> sqlFetchAll($sql);

		for($ii=0; $ii<count($data); $ii++) {
			$duration_h = (int)($data[$ii]['str_duration'] / 3600); 
			$duration_m = (int)(($data[$ii]['str_duration'] % 3600) / 60); 
			$duration_s = (int)(($data[$ii]['str_duration'] % 3600) % 60);
			if($duration_h < 10)
			$duration_h = "0".$duration_h;
			if($duration_m < 10)
			$duration_m = "0".$duration_m;
			if($duration_s < 10)
			$duration_s = "0".$duration_s;

			$data[$ii]['str_duration'] = $duration_h.":".$duration_m.":".$duration_s;
			//$data[$ii]['str_content_desc'] = cut_str($data[$ii]['str_content_desc'],100);
			$data[$ii]['str_content_desc'] = $data[$ii]['str_content_desc'];
		}

		$tpl->assign(array(
		'LIST'=>$data,
		'fno'=>$fno,
		'page'=>$page,
		'total'=>$total,
		'listnum'=>$listnum,
		'str_main_view'=>$str_main_view,
		'searchvalue'=>$searchvalue,
		'searchkey'=>$searchkey,
		));

        $tpl->setLayout('no2');
        $tpl->define('CONTENT', Display::getTemplate('ifr/admin/ucclist.htm'));
        $tpl->assign($data);
        break;
    case 'POST':

		$sql = "
            UPDATE TAB_CONTENT_URL SET
                str_url='{$str_url}', str_target='{$str_target}',  str_height='{$str_height}', dt_date=SYSDATE
            WHERE
                num_oid="._OID." AND num_mcode='{$mcode}'
        ";
        if ($DB->query($sql)) {
            $DB->commit();

            $FTP = &WebApp::singleton("FtpClient",WebApp::getConf('account'));
            $FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/menu.xml');
            $FTP->close();

            WebApp::redirect($URL->setVar('act','menu.admin.option'));
        } else {
            WebApp::raiseError('링크의 URL을 설정할 수 없습니다');
        }
        break;
}

function cut_str($str,$len,$tail="...") {
	if(strlen($str) > $len) {
		for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
		$str=substr($str,0,$i).$tail;
	}
	return $str;
}
?>
