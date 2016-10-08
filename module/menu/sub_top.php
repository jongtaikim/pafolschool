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




//2008-04-17 종태 
// 임시 html 체크



	
	//==-- 홈페이지 메뉴 --==//
 	$len = strlen($mcode);

// 기존 홈페이지 서브 메뉴	

    if($len == 0 || $len == 3 || $len == 5) {
        // 추가메뉴
        $_mcode = '_';
        $cache_file = 'hosts/'.HOST.'/menu/smenu.htm';
    } else {
        // 주메뉴
       
		$_mcode = substr($mcode,0,2);
        $cache_file = 'hosts/'.HOST.'/menu/'.$_mcode.'.htm';
    }
    
/* if(is_file($cache_file)  && date('Ymd') == date('Ymd',filemtime($cache_file))) {
  $fp = fopen($cache_file,'r');
        $content = @fread($fp,filesize($cache_file));
        fclose($fp);
  } else {*/
      
	          
		
        $URL = &WebApp::singleton('WebAppURL');
        $DB = &WebApp::singleton('DB');
        

		
		
		if($_mcode != '_') {
            $current_menu = $DB->sqlFetchOne("SELECT STR_TITLE FROM ".TAB_MENU." WHERE num_oid="._OID." AND num_mcode=$_mcode");
        } else {
            
            /*추가메뉴 상단 타이틀 부분 값 삭제 9/13일 author=박종호*/
            $current_menu = '';
        }
      
	
		
		

        $sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
               "WHERE num_oid="._OID." AND num_mcode LIKE '".$_mcode."__' AND num_view=1 $que  ORDER BY num_step";
        if($data = $DB->sqlFetchAll($sql)) {
		



for($ii=0; $ii<count($data); $ii++) {
	

			list($module_name,$module_type) = explode('#',$data[$ii]['str_type']);
            $mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$ii]['num_mcode']));
            $data[$ii]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
            $data[$ii]['str_target'] = $mdata['menu_target'];
            //$data[$ii]['class'] = $extra_data['class'];
            if(strlen($data[$ii]['num_mcode']) < 5) {
                 
					
					
					$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." WHERE ".
                           "num_oid="._OID." AND num_mcode LIKE '".$data[$ii]['num_mcode']."__' AND num_view=1  ORDER BY num_step";
                    if($data_sub =  $DB->sqlFetchAll($sql)) {
                      
					for($i=0; $i<count($data_sub); $i++) {
					
			list($module_name,$module_type) = explode('#',$data_sub[$i]['str_type']);

			$mdata_sub = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data_sub[$i]['num_mcode']));
            
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
            
			$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$data[$iia]['num_mcode']));
            
			$data[$iia]['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url'],false) : $mdata['menu_url'];
            $data[$iia]['str_target'] = $mdata['menu_target'];
			

		}

		
		}
		

		}

		}


        $tpl = &WebApp::singleton('Display');
	

		$mlen = strlen($mcode);

		
		 $template = $param['template'];
		
		$tpl->define("TOPMENU_AREA",$template);
        $tpl->assign(array(
       	

			'TOPMENU'      => $data,
            'M_url'      => "/module/btn/menu",
        ));
        $content = $tpl->fetch("TOPMENU_AREA");

/*    $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
        if(!$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST.'/menu')) {
            $FTP->chdir(_DOC_ROOT.'/hosts/'.HOST);
            $FTP->mkdir('menu');
        }
        $FTP->put_string($content,_DOC_ROOT.'/'.$cache_file);

    }*/

echo $content;

?>
