<?php
header ("P3P: CP='ALL IND DSP COR ADM CONo CUR CUSo IVAo IVDo PSA PSD TAI TELo OUR SAMo CNT COM INT NAV ONL PHY PRE PUR UNI'");

$DB = &WebApp::singleton("DB");

switch (_STYPE) {
	case "E":
	$psql = " and str_e = 'Y' ";
	 break;
	case "M":
	$psql = " and str_m = 'Y' ";
	break;
	case "H":
	$psql = " and str_h = 'Y' ";
	break;

	}
	switch ($organdb[str_school]) {
			case "E":
			$psql = " and str_e = 'Y' ";
			 break;
			case "M":
			$psql = " and str_m = 'Y' ";
			break;
			case "H":
			$psql = " and str_h = 'Y' ";
			break;

			}




		$sql = "select * from TAB_POPUP where num_oid = "._OID."  and str_open = 'B' and str_view ='Y' order by num_setp asc";
		$row = $DB -> sqlFetchAll($sql);
		$tpl->assign(array('LIST'=>$row));
		

		if(_AOID != _OID){
		$sql = "select * from TAB_POPUP where num_oid = "._AOID." and    str_open = 'B' and str_view ='Y' and str_a_view='Y' $psql ";
		$row2 = $DB -> sqlFetchAll($sql);

		$tpl->assign(array('LIST_g'=>$row2));
		}




		$tpl->setLayout('blank');
		$tpl->define("CONTENT","html/popup/list.htm");
		$tpl->assign(array(
			'listnum'=>$listnum,
			'total'=>$total,
			'mk'=>mktime(),

		));

function list_format(&$arr) {
	global $total,$page,$URL;
	static $num;

	$arr['num'] = $total - (($page-1)*$listnum) - $num-- ;
	if($arr['chr_open'] == 'Y') $arr['open_checked'] = 'checked';
	$arr['modifylink'] = $URL->setVar(array('act'=>'.write','id'=>$arr['num_serial']));
	
}
?>