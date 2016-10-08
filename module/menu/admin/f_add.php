<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-24
* 작성자: 김종태
* 설   명: 바로가기 메뉴 등록
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');

switch ($REQUEST_METHOD) {
	case "GET":

	


			$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
				"WHERE num_oid="._OID." AND num_mcode LIKE '".$_mcode."__' AND num_view=1 $que  ORDER BY num_step";



			if($data = $DB->sqlFetchAll($sql)) {

				$total = count($data);
				$tpl->assign(array('total_sub_menu'=>$total));


				for($ii=0; $ii<count($data); $ii++) {
					
					list($module_name,$module_type) = explode('#',$data[$ii]['str_type']);

					$mk = date("Y-m-d",mktime() - 169200);
					$sql = "select count(dt_date) from TAB_BOARD where num_oid = "._OID."  and num_mcode  = ".$data[$ii]['num_mcode']." and TO_CHAR(dt_date,'YYYY-MM-DD')  >= '".$mk."' ";

					$data[$ii][new_img] = $DB -> sqlFetchOne($sql);

					$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$ii]['num_mcode'],'module_type'=>$module_type));

					
					$data[$ii]['str_link'] = is_array($mdata['menu_url']) ? getVarURL($mdata['menu_url'],false) : $mdata['menu_url'];
					$data[$ii]['str_target'] = $mdata['menu_target'];
				

		

						$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." WHERE ".
						"num_oid="._OID." AND num_mcode LIKE '".$data[$ii]['num_mcode']."__' AND num_view=1  ORDER BY num_step";

						if($data_sub =  $DB->sqlFetchAll($sql)) {

							for($i=0; $i<count($data_sub); $i++) {

								$mk = date("Y-m-d",mktime() - 169200);
								$sql = "select count(dt_date) from TAB_BOARD where num_oid = "._OID."  and num_mcode  = ".$data_sub[$i]['num_mcode']." and TO_CHAR(dt_date,'YYYY-MM-DD')  >= '".$mk."' ";
								$data_sub[$i][new_img] = $DB -> sqlFetchOne($sql);
							

								list($module_name,$module_type) = explode('#',$data_sub[$i]['str_type']);

								$mdata_sub = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data_sub[$i]['num_mcode'],'module_type'=>$module_type));

							
								$data_sub[$i]['str_link'] = is_array($mdata_sub['menu_url']) ? getVarURL($mdata_sub['menu_url'],false) : $mdata_sub['menu_url'];

								$data_sub[$i]['str_target'] = $mdata_sub['menu_target'];
						
							}

							$data[$ii]['SUBMENU_SUB'] = $data_sub;

							$data[$ii]['is_sub'] = true;
						}
					
				}
					
			}



	$sql = "select * from TAB_MENU_F_ADD where num_oid = $_OID";
	$row = $DB -> sqlFetchAll($sql);
 
	
	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("menu/admin/f_add.htm"));
	$tpl->assign(array(
	'SUBMENU'      => $data,
	 'addLIST'=>$row,
	
	));

	
	 break;
	case "POST":
	
	exec("rm -rf "._DOC_ROOT.'/hosts/'.HOST.'/'."inc_menu/*.htm");

	$mdata = explode(";",$capsule);
	

	$sql = "delete from TAB_MENU_F_ADD where num_oid = "._OID." ";

	$DB->query($sql);
	$DB->commit();
	
	for($ii=0; $ii<count($mdata); $ii++) {
		
	
	

	$sql = "select max(num_serial)+1 from TAB_MENU_F_ADD where num_oid = $_OID ";
	$max_num = $DB -> sqlFetchOne($sql);
	if(!$max_num)  $max_num = 1;
	

	$tmpMcode = explode("mcode=",$mdata[$ii]);
	$tmpMcode  = $tmpMcode[1];
	$tmpMcode = explode("&cate",$tmpMcode);
	$tmpMcode  = $tmpMcode[0];

		
	$sql = "select str_title from TAB_MENU where num_oid = $_OID and num_mcode = ".$tmpMcode." ";
	$str_title = $DB -> sqlFetchOne($sql);
	
	if(strlen($tmpMcode) >2){
	$str_title = "ㄴ ".$str_title;

	}
	
	$iiz = $ii + 1;

	 $sql = "INSERT INTO ".TAB_MENU_F_ADD." (	
		  num_oid,
		  num_serial,
		  num_step,
		  str_url,
		  str_title

		   ) VALUES (
		 
		 $_OID,
		 $max_num,
		 ".$iiz.",
		'".$mdata[$ii]."',
		'$str_title'
		 ) ";

		$DB->query($sql);


	}


	$DB->commit();
	
	$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.linkObj.htm";
	unlink($cache_file);
	WebApp::moveBack('적용되었습니다.');
	 
	 break;
	}




function getVarURL($alter="", $flag = true) {
	$buff = array();

	if (ereg('^(\.+)',$alter['act'],&$reg)) {
		$len = $i = strlen($reg[1]);
		$curr = MODULE;

		while ($i-- > 0) {
			$curr = substr($curr,0,strrpos($curr,'.'));
		}
		$alter['act'] = $curr.'.'.substr($alter['act'],$len);
	}

	if (defined('HUMAN_URI')) {
		//unset($alter['act']);
	}

	foreach ($alter as $_key=>$_val){
		if ($_key != 'act') $buff[] = "$_key=$_val";
	}

	return $alter['act'] . (($qs = implode("&",$buff)) ? "?$qs" : '');
}
?>