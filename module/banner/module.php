<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-08
* 작성자: 김종태
* 설  명: 
*****************************************************************
* 사용법 : <wa:applet module="banner.main">템플릿 내용</wa:applet>
*/


$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.banner.htm";

if($del =="y") unlink($cache_file);
if(!is_file($cache_file) || date('Ymd H') > date('Ymd H',filemtime($cache_file))) {

	$DB = &WebApp::singleton('DB');
	$sql = "SELECT /*+ INDEX (".TAB_BANNER." ".IDX_TAB_BANNER.") */ NUM_SERIAL,STR_TITLE,STR_LINK,CHR_OPEN,STR_FILE,STR_P,rownum AS rnum FROM ".TAB_BANNER." WHERE NUM_OID="._OID." and str_p = 'banner'";
	

		$data = $DB->sqlFetchAll($sql);
		$width_att = $param['width'] ? ' width="'.$param['width'].'"' : '';
		$height_att = $param['height'] ? ' height="'.$param['height'].'"' : '';
		for($i=0,$cnt=count($data);$i<$cnt;$i++) {
			$data[$i]['file_url'] = 'hosts/'.HOST.'/files/banner/'.$data[$i]['str_file'];
			if($data[$i]['num_oid'] == _AOID) $data[$i]['file_url'] = 'hosts/'._AOIDHOST.'/files/banner/'.$data[$i]['str_file'];
			
			$imgs = getimagesize(_DOC_ROOT."/".$data[$i]['file_url']);
			if($imgs[0] > 154){
			WebApp::saveThumbImg(_DOC_ROOT."/".$data[$i]['file_url'],_DOC_ROOT."/".$data[$i]['file_url'],154,46,100);
			}


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

		$tpl = &WebApp::singleton('Display');
			
		if($param['cols']) {
			for($i=0;$i<count($data);$i++) {
				$rows[] = $data[$i];
				if(count($rows) >= $param['cols']) {
					$data2[] = array('COLS'=>$rows);
					$rows = array();
				}
			}
			if($rows) $data2[] = array('COLS'=>$rows);

			$tpl->assign("ROWS",$data2);
		} else {
			$tpl->assign("LIST",$data);
		}
		$content = $tpl->fetch("BANNER");
	
	
$make = "y";
} else {
	$fp = fopen($cache_file,'r');
	$content = fread($fp,filesize($cache_file));
	fclose($fp);
}

?>