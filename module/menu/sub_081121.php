<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-04-16
* 작성자: 김종태
* 설  명: 공지사항 라이브러리 생성 파일
*****************************************************************
* 
*/
$mcode = $_REQUEST['mcode'] ? $_REQUEST['mcode'] : '';
$fcode = $_REQUEST['fcode'] ? $_REQUEST['fcode'] : '';
$pcode = $_REQUEST['pcode'] ? $_REQUEST['pcode'] : '';
$class = $param['class'];
$class_current = $param['class_current'];




$mou_name = "submenu";
	
$DB = &WebApp::singleton("DB");
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name);
$tpl->assign($conf);
$tpl->assign($conf_main);


//echo _LAYOUT_R.'_'.$mou_name;

	//2008-04-17 종태 라이브러리를 위해서
	if($conf['skin']) $theme_name = $conf['skin']; else $theme_name = $conf_main['skin'];
	$template = $param['template'];
    if ($theme_name) $template = "/theme_lib/".$mou_name."/".$theme_name."/attach.".$mou_name."_no.htm";



/*
//2008-10-03 실시간 강좌 시간인지 체크합니다. 종태
$r_time = date("H:i",mktime());

$week_num = date("w",mktime());
$week = array('일', '월', '화', '수', '목', '금', '토');
$day = date("$week[$week_num]",mktime());

$sql = "select num_ccode from TAB_MEDIA_CONFIG where num_oid = '"._OID."'  and num_chk_mcode = '".substr(_MCODE,0,2)."'  
and num_view = '2'";
$ccode = $DB -> sqlFetchOne($sql);



$sql = "select count(*) from TAB_MEDIA_TIME where num_oid = '"._OID."' and num_ccode = '".$ccode."' and 
str_start_time1 < '".$r_time."' and str_end_time1 > '".$r_time."' and str_day = '".$day."'  
";
$time1 = $DB -> sqlFetchOne($sql);


$sql = "select count(*) from TAB_MEDIA_TIME where num_oid = '"._OID."' and num_ccode = '".$ccode."' and 
str_start_time2 < '".$r_time."' and str_end_time2 > '".$r_time."'  and str_day = '".$day."'  
";
$time2 = $DB -> sqlFetchOne($sql);

$sql = "select count(*) from TAB_MEDIA_TIME where num_oid = '"._OID."' and num_ccode = '".$ccode."' and 
str_start_time3 < '".$r_time."' and str_end_time3 > '".$r_time."' and str_day = '".$day."'  
";
$time3 = $DB -> sqlFetchOne($sql);

$total_time = $time1 + $time2 + $time3;



if($total_time > 0) {
$tpl->assign(array('media_con'=>$total_time,'ccode'=>$ccode));	
}


*/



if(strlen($mcode) %2 == 0) {

$sql = "SELECT * FROM (SELECT * FROM ".TAB_MENU." WHERE num_oid="._OID." AND num_mcode LIKE '".substr($mcode,0,2)."'  ORDER BY num_step) WHERE ROWNUM=1";

}else{
$sql = "SELECT * FROM (SELECT * FROM ".TAB_MENU." WHERE num_oid="._OID." AND num_mcode LIKE '".substr($mcode,0,1)."'  ORDER BY num_step) WHERE ROWNUM=1";
}

$data = $DB->sqlFetch($sql);





	list($module_name,$module_type) = explode('#',$data['str_type']);
    $mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data['num_mcode'],'module_type'=>$module_type));
    $link = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];


	$tpl->assign(array('backlink'=>$link));



	
	//==-- 홈페이지 메뉴 --==//
 	$len = strlen($mcode);

       if(strlen($mcode) %2 == 0) {
		$_mcode = substr($mcode,0,2);
	   }else{
	   $_mcode = substr($mcode,0,3);
	   }
		
		$cache_file = 'hosts/'.HOST.'/menu/'.$_mcode.'.htm';

    
		
        $URL = &WebApp::singleton('WebAppURL');
        $DB = &WebApp::singleton('DB');
        

		
		
		if($_mcode != '_') {
            $current_menu = $DB->sqlFetchOne("SELECT STR_TITLE FROM ".TAB_MENU." WHERE num_oid="._OID." AND num_mcode=$_mcode");
			 $current_menu2 = $DB->sqlFetchOne("SELECT STR_TITLE2 FROM ".TAB_MENU." WHERE num_oid="._OID." AND num_mcode=$_mcode");
        } else {
            
            /*추가메뉴 상단 타이틀 부분 값 삭제 9/13일 author=박종호*/
            $current_menu = '';
        }
      
	
		
		

        $sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
               "WHERE num_oid="._OID." AND num_mcode LIKE '".$_mcode."__' AND num_view=1 $que  ORDER BY num_step";
        if($data = $DB->sqlFetchAll($sql)) {
		


$total = count($data);
$tpl->assign(array('total_sub_menu'=>$total));


for($ii=0; $ii<count($data); $ii++) {
	
	list($module_name,$module_type) = explode('#',$data[$ii]['str_type']);

	

	$mk = date("Y-m-d",mktime() - 169200);
	//echo $mk;
	$sql = "select count(dt_date) from TAB_BOARD where num_oid = "._OID."  and num_mcode  = ".$data[$ii]['num_mcode']." and TO_CHAR(dt_date,'YYYY-MM-DD')  >= '".$mk."' ";

	$data[$ii][new_img] = $DB -> sqlFetchOne($sql);

	/*$sql = "select count(dt_date) from TAB_BOARD_COMMENT where num_oid = '"._OID."'  and num_mcode  = '".$data[$ii]['num_mcode']."' and TO_CHAR(dt_date,'YYYY-MM-DD')  >= '".$mk."' ";

	$data[$ii][new_img] = $DB -> sqlFetchOne($sql);*/


	
	//$data[$ii][new_img] = "Y";





            $mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$ii]['num_mcode'],'module_type'=>$module_type));
		
			
			$data[$ii]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
            $data[$ii]['str_target'] = $mdata['menu_target'];
            //$data[$ii]['class'] = $extra_data['class'];
            if(strlen($data[$ii]['num_mcode']) <= 5) {
                 
					
					
					$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." WHERE ".
                           "num_oid="._OID." AND num_mcode LIKE '".$data[$ii]['num_mcode']."__' AND num_view=1  ORDER BY num_step";
                    if($data_sub =  $DB->sqlFetchAll($sql)) {
                      
					for($i=0; $i<count($data_sub); $i++) {



	$mk = date("Y-m-d",mktime() - 169200);
	//echo $mk;
	$sql = "select count(dt_date) from TAB_BOARD where num_oid = "._OID."  and num_mcode  = ".$data_sub[$i]['num_mcode']." and TO_CHAR(dt_date,'YYYY-MM-DD')  >= '".$mk."' ";
	$data_sub[$i][new_img] = $DB -> sqlFetchOne($sql);

	/*$sql = "select count(dt_date) from TAB_BOARD_COMMENT where num_oid = '"._OID."'  and num_mcode  = '".$data_sub[$i]['num_mcode']."' and TO_CHAR(dt_date,'YYYY-MM-DD')  >= '".$mk."' ";

	$data_sub[$i][new_img2] = $DB -> sqlFetchOne($sql);*/


					
			list($module_name,$module_type) = explode('#',$data_sub[$i]['str_type']);

			$mdata_sub = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data_sub[$i]['num_mcode'],'module_type'=>$module_type));
            
			$data_sub[$i]['str_link'] = is_array($mdata_sub['menu_url']) ? $URL->setVar($mdata_sub['menu_url'],false) : $mdata_sub['menu_url'];

			$data_sub[$i]['str_target'] = $mdata_sub['menu_target'];
            //$data[$ii]['class'] = $extra_data['class'];
						
					}
					


                        $data[$ii]['SUBMENU_SUB'] = $data_sub;
						
						$data[$ii]['is_sub'] = true;
                    }
            }

		}



		
		}else{
		
		if(!$mcode) {
			
	
		 $sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
               "WHERE num_oid="._OID." AND LENGTH(num_mcode)=2 AND num_view=1 $que  ORDER BY num_step";
        if($data = $DB->sqlFetchAll($sql)) {
		
		for($iia=0; $iia<count($data); $iia++) {

		list($module_name,$module_type) = explode('#',$data[$iia]['str_type']);
            
			$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$iia]['num_mcode'],'module_type'=>$module_type));
            
			$data[$iia]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
            $data[$iia]['str_target'] = $mdata['menu_target'];
			

		}

		
		}
		

		}

		}


        $tpl = &WebApp::singleton('Display');
	
		if(count($data) == 0) $data=1;
		$is_total = (count($data) * 27) + 84;

		$tpl->assign(array('is_total'=>$is_total));

		$mlen = strlen($mcode);
		
		$tpl->define("SUBMENU_AREA",$template);
        $tpl->assign(array(
       	

		'SUBMENU'      => $data,
            'current_menu' => $current_menu,
			'current_menu2' => $current_menu2,
            'mcode__1'        => $mcode,
			'mcode_2'        => substr($mcode,0,$mlen-2),
            'class'        => $class,
            'class_current'=> $class_current,
			'mcode'=> _MCODE,
        ));
        $content = $tpl->fetch("SUBMENU_AREA");

/*    $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
        if(!$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST.'/menu')) {
            $FTP->chdir(_DOC_ROOT.'/hosts/'.HOST);
            $FTP->mkdir('menu');
        }
        $FTP->put_string($content,_DOC_ROOT.'/'.$cache_file);

    }*/

echo $content;

?>
