<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	

if(_STYPE == 'E') $str_school="Y__";
elseif(_STYPE == 'M') $str_school="_Y_";
elseif(_STYPE == 'H') $str_school="__Y";
else $str_school="XXX"; //통합관리자

if($types){
	$psql = " and str_p = '".$types."' ";
}

if(!$mode){
	$table = "TAB_BANNER";
}else{
	$table = "TAB_BANNER2";
}


//학교관리자가 등록한 통합배너
$sql = "SELECT
			NUM_OID, NUM_SERIAL,STR_TITLE,STR_LINK,CHR_OPEN,STR_FILE,STR_P FROM ".$table." 
			WHERE NUM_OID="._OID." $psql ";
$data = $DB->sqlFetchAll($sql);



		

	
			$width_att = $param['width'] ? ' width="'.$param['width'].'"' : '';
			$height_att = $param['height'] ? ' height="'.$param['height'].'"' : '';
		
			for($i=0,$cnt=count($data);$i<$cnt;$i++) {
				$data[$i]['file_url'] = 'hosts/'.HOST.'/files/banner/'.$data[$i]['str_file'];
				if($data[$i]['num_oid'] == _AOID) $data[$i]['file_url'] = 'hosts/'._AOIDHOST.'/files/banner/'.$data[$i]['str_file'];
				if(substr($data[$i]['str_file'],-3) == 'swf') {
					$data[$i]['banner_tag'] = '
					<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0"'.
						$width_att.$height_att.'>
						<param name="movie" value="'.$data[$i]['file_url'].'">
						<param name="quality" value="high">
						<embed src="'.$data[$i]['file_url'].'"'.$width_att.$height_att.
						' quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
					</object>';
				} else {
					$data[$i]['banner_tag'] = '<img src="'.$data[$i]['file_url'].'"'.$width_att.$height_att.' border="0">';
				}
			}




	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("banner_sub/main.htm"));
	$tpl->assign(array(
            'LIST'  => $data,
            'width' => $conf['width'],
            'height'=> $conf['height']
        ));
		

	 break;
	case "POST":
	 break;
	}

?>