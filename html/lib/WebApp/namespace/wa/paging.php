<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: namespace/wa/paging.php
* 작성일: 2005-07-07
* 작성자: 거친마루
* 설  명: 페이지 네비게이션 바
*****************************************************************
* 
*/
if (strtolower($attr['runat']) == 'server') {
    //$attr['total'] = (int)$attr['total'];
    if (empty($attr['listnum'])) $attr['listnum'] = 10;
    if (empty($attr['navnum'])) $attr['navnum'] = 10;
	$ret = "<?php\n";
	$ret.= "WebApp::import('Paging');\n";
	if($attr['qs']) {
		if(ereg('^{(.*)}$',$attr['qs'])) {
			$ret.= '$PG = new Paging('.$attr['total'].($attr['qs'] ? ','.$attr['qs'] : '').");\n";
		} else {
			$ret.= '$PG = new Paging('.$attr['total'].($attr['qs'] ? ',"'.$attr['qs'].'"' : '').");\n";
		}
	} else {
		$ret.= '$PG = new Paging('.$attr['total'].');'."\n";
	}
	if ($attr['numberformat']) $ret.= '$PG->setConf("numberFormat","'.$attr['numberformat'].'");'."\n";
	if ($attr['listnum']) $ret.= '$PG->setConf("itemPerPage",'.$attr['listnum'].');'."\n";
	if ($attr['navnum']) $ret.= '$PG->setConf("listPerPage",'.$attr['navnum'].');'."\n";
	if ($attr['previcon']) $ret.= '$PG->setConf("prevIcon","'.$attr['previcon'].'");'."\n";
	if ($attr['nexticon']) $ret.= '$PG->setConf("nextIcon","'.$attr['nexticon'].'");'."\n";
	if ($attr['firsticon']) $ret.= '$PG->setConf("firstIcon","'.$attr['firsticon'].'");'."\n";
	if ($attr['lasticon']) $ret.= '$PG->setConf("lastIcon","'.$attr['lasticon'].'");'."\n";
	$ret.= '$PG->output();'."\n";
	$ret.= '?'.'>';
} else {
    $ret = "<script type=\"text/javascript\" src=\"js/lib.paging.js\"></script>\n";
    $ret.= "<script type=\"text/javascript\">\nvar PG = new Paging(".$attr['total'].");\n";
    if ($attr['numberformat']) $ret.= 'PG.config.numberFormat = "'.$attr['numberformat'].'";'."\n";
	if ($attr['listnum']) $ret.= 'PG.config.itemPerPage = '.$attr['listnum'].';'."\n";
	if ($attr['navnum']) $ret.= 'PG.config.pagePerView='.$attr['navnum'].';'."\n";
	if ($attr['previcon']) $ret.= 'PG.config.prevIcon="'.$attr['previcon'].'";'."\n";
	if ($attr['nexticon']) $ret.= 'PG.config.nextIcon="'.$attr['nexticon'].'";'."\n";
	if ($attr['firsticon']) $ret.= 'PG.config.firstIcon="'.$attr['firsticon'].'";'."\n";
	if ($attr['lasticon']) $ret.= 'PG.config.lastIcon="'.$attr['lasticon'].'";'."\n";
    $ret.="document.write(PG);\n</script>";
}
return $ret;

?>
