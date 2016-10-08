<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/admin/menu/option.php
* 작성일: 2008-10-21
* 작성자: 김종태
* 설   명: 서브페이지 옵션변경
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$_OID = WebApp::getConf('oid');
$mcode = $_REQUEST['mcode'];

function byte_convert($bytes){
	$symbol = array('byte', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

	$exp = 0;
	$converted_value = 0;
	if( $bytes > 0 ){
		$exp = floor( log($bytes)/log(1024) );
		$converted_value = ( $bytes/pow(1024,floor($exp)) );
	}
	if($bytes) {
		return sprintf( '%.2f'.$symbol[$exp], $converted_value );		
	}

	//return sprintf( '%d'.$symbol[$exp], $converted_value );
}




switch (REQUEST_METHOD) {

	case "GET":
		$env = array('showopt' => true);
		$data = $DB->sqlFetch("SELECT * FROM ".TAB_MENU." WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode");


		 list($module_name,$module_type) = explode('#',$data['str_type']);

		$ext_data = WebApp::get($module_name,array('key'=>'menu','mcode'=>$mcode,'cate'=>$data[num_cate],'module_type'=>$module_type));
		if(is_array($ext_data['admin_url'])) $ext_data['admin_url'] = $URL->setVar($ext_data['admin_url']);
		if(is_array($ext_data['menu_url'])) $ext_data['menu_url'] = $URL->setVar($ext_data['menu_url']);
		

		// {{{ 메뉴위치 로케이션바 만들기
		$_cate = $cate;
		while(strlen($_cate = substr($_cate,0,-2)) > 1) {
			$_location[] = $DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE NUM_OID=$_OID AND NUM_cate=$_cate");
		}
		$_location[] = '메인';
		$menu_location = implode(' > ',array_reverse($_location));
		// }}}

        $sub_cnt = $DB->sqlFetchOne("SELECT COUNT(*) FROM ".TAB_MENU." WHERE NUM_OID=$_OID AND NUM_cate LIKE '".$cate."__'");


		switch ($module_name) {
			case "doc":
			$sql = "select * from TAB_PDS where NUM_OID = $_OID and NUM_MCODE = $mcode ";
			$module_data = $DB -> sqlFetch($sql);
			$tpl->assign($module_data);
			
			

			break;
			case "board":
			
			$sql = "select * from TAB_BOARD_CONFIG where NUM_OID = $_OID and NUM_MCODE = $mcode ";
			$module_data = $DB -> sqlFetch($sql);
			
			$sql = "select str_name from TAB_MEMBER where num_oid = $_OID and str_id  = '".$module_data[str_admin_id]."' ";
			$module_data[str_admin_name] = $DB -> sqlFetchOne($sql);

			
			

			$skinlist = array();
			foreach (glob('html/board/skin/*',GLOB_ONLYDIR) as $str_skin) {
				$str_skin = array_pop(explode('/',$str_skin));
				$skininfo = @parse_ini_file("html/board/skin/{$str_skin}/skin.conf.php");
				$skinlist[] = array(
					'str_skin' => $str_skin,
					'skin_name' => $skininfo['name']
				);
			}
			
			$sql = "select sum(num_size) from TAB_FILES where num_oid = $_OID and str_sect = 'menu' and str_code='".$mcode."'";
			$max_disk = $DB -> sqlFetchOne($sql);

			


			$data[max_disk] = byte_convert($max_disk);
			
			
			
			 break;
			case "link":
			$sql = "select * from TAB_CONTENT_URL where num_oid = $_OID and num_mcode = $mcode";
			$module_data = $DB -> sqlFetch($sql);
			$module_data[menu_url] = $module_data[str_url];
			 break;

 			case "ifr":
			$sql = "select * from TAB_CONTENT_URL where num_oid = $_OID and num_mcode = $mcode";
			$module_data = $DB -> sqlFetch($sql);
			$module_data[menu_url] = $module_data[str_url];
			 break;
			}
		
		$tpl->assign($module_data);
		$tpl->assign(array('m_type'=>$module_name));
		
		$tpl->setLayout('admin');
		$tpl->define('CONTENT', Display::getTemplate('menu/admin/option.htm'));
		
		
		if(is_file(_DOC_ROOT."/hosts/".HOST."/title/".$mcode.".gif")){
			$data[title_img] = "y";
		}
		
		
		$tpl->assign('TABS',&$ext_data['admin_tabs']);
		$tpl->assign($data);
		$tpl->assign($ext_data);
		$tpl->assign(array(
             'bbs_skin' => $skinlist,
			'menu_location' => $menu_location,
			'env'           => $env,
            'mcode'         => $mcode,
            'sub_cnt'       => $sub_cnt
        ));

		$tpl->assign('MENU_TYPE',$VAR_MENUTYPE);
		$tpl->assign('MENU_TYPE2',$VAR_MENUTYPE2);
		$tpl->assign('MENU_TYPE3',$VAR_MENUTYPE3);
		$tpl->assign();
		
		


		break;
/// {{{ 저장하는 부분
	case "POST":

		exec("rm -rf "._DOC_ROOT.'/hosts/'.HOST.'/'."inc_menu/*.htm");
		
        $what = $_POST['what'];
        $mcode = $URL->vars['mcode'];
        $new_title = $_POST['str_title'];



        $menu_type = $DB->sqlFetchOne("SELECT STR_TYPE FROM TAB_MENU WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode");
        
        $sql = "UPDATE TAB_MENU SET STR_TITLE='$new_title', STR_SUBTITLEBAR = '".$str_subtitlebar."' , STR_TITLE2='$str_title2', STR_LAYOUT='$str_layout',NUM_VIEW=$num_view,  str_type='$str_type' , str_w='$str_w' ,str_text='$str_text' WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
	

	  $DB->query($sql);
        $DB->commit();
		
			
			
			
			switch ($m_type) {
			case"doc":
			
			require_once _DOC_ROOT.'/module/file.php';

			/*$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$FTP->mkdir(_DOC_ROOT."/hosts/".HOST."/doc/pds");
			$FTP->chmod(_DOC_ROOT."/hosts/".HOST."/doc/pds",777);
			$FTP->mkdir(_DOC_ROOT."/hosts/".HOST."/doc/pds/".$mcode);
			$FTP->chmod(_DOC_ROOT."/hosts/".HOST."/doc/pds/".$mcode,777);*/

			exec("mkdir "._DOC_ROOT."/hosts/".HOST."/doc/pds");
			exec("chmod 777 "._DOC_ROOT."/hosts/".HOST."/doc/pds ");
			exec("mkdir "._DOC_ROOT."/hosts/".HOST."/doc/pds/".$mcode);
			exec("chmod 777 "._DOC_ROOT."/hosts/".HOST."/doc/pds/".$mcode);


			
			

			if($upfile1_del){
				
				unlink(_DOC_ROOT."/hosts/".HOST."/doc/pds/".$mcode."/".$upfile1_del_name);
				$datas[num_oid] = _OID;
				$datas[num_mcode] = $mcode;
				$DB->deleteQuery("TAB_PDS"," num_oid = '"._OID."' and num_mcode = '".$mcode."' ");
				$DB->commit();
			}
			
			if($upfile1) {
			
				$file = new FileUpload("upfile1"); // datafile은 form에서의 이름 
				$file->Path = _DOC_ROOT."/hosts/".HOST."/doc/pds/".$mcode."/";  // 마지막에 /꼭 붙여야함

			//$file->file_mkdir(); 
			if(!$file->Ext("gif,png,jpg,hwp,doc,docx,ppt,pptx,xls.xlsx,pdf"))  {
				echo '<script>alert("업로드 가능한 파일이 아닙니다.\n(gif,png,jpg,hwp,doc,docx,ppt,pptx,xls.xlsx,pdf) 파일 가능");   history.go(-1); </script>';
				exit;
			 }
			$file->file_renameExp($mcode); 
			if(!$file->upload()){
				echo '<script>alert("업로드에 실패 했습니다.");   history.go(-1); </script>';
				exit;
			}
			$file->upload();
			
			$no = "y";
			$DB->deleteQuery("TAB_PDS"," num_oid = '"._OID."' and num_mcode = ".$mcode."");
			$DB->commit();

			$datas[num_oid] = _OID;
			$datas[num_mcode] = $mcode;
			$datas[str_title] = $str_title."의 추가 자료";
			$datas[str_text] = $str_text;
			$datas[str_file] = $file->SaveName;
			$datas[str_refile] = $file->Name;
			$datas[num_date] = date("Ymd");

		

			$DB->insertQuery("TAB_PDS",$datas);
			$DB->commit();
			}
			
			

			break;
			case "board":
		
			if(!$chr_comment) $chr_comment = "N";
			if(!$chr_upload) $chr_upload = "N";
		

			//2008-04-15 종태 게시판 명까지
			$sql = "UPDATE TAB_BOARD_CONFIG SET 
			str_title='$str_title', 
			str_skin='$str_skin',
			chr_stats = '$chr_stats',
			str_top = '$str_top',
			num_listnum  = '$num_listnum',
			chr_hak = '$chr_hak',
			chr_comment  = '$chr_comment',
			chr_upload  = '$chr_upload',
			str_download   = '$str_download',
			str_admin_id = '$str_admin_id',
			chr_listtype = '$chr_listtype',
			chr_listtype = '$chr_listtype',
			num_rss_count = '$num_rss_count',
			str_iconv = '$str_iconv',
			str_rss_cate = '$str_rss_cate',
			str_rss_url = '$str_rss_url'
			
			
			WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
			
			$DB->query($sql);
            $DB->commit();
			


			break;
			case "link":
					
			//링크메뉴에도 서브메뉴코드를 자동으로 붙이자~ 종태
			if($str_url && strlen($str_url) >3){
			if(!strstr($str_url,"mcode")) {
				if(strstr($str_url,"?")) {
				$str_url = $str_url."&mcode={$mcode}";
				}else{
				$str_url = $str_url."?mcode={$mcode}";
				}
			}
			}else{
			$str_url = "#";
			}
			
			if(!strstr($str_url,"cate")) {
				if(strstr($str_url,"?")) {
				$str_url = $str_url."&cate={$cate}";
				}else{
				$str_url = $str_url."?cate={$cate}";
				}
			}
			
			//
			$datass[num_oid] = _OID;
			$datass[num_mcode] = $mcode;
			$datass[num_cate] = $cate;
			$datass[str_url] = $str_url;
			$datass[str_target] = $str_target;
			$DB->insertQuery("TAB_CONTENT_URL",$datass);
			$DB->commit();

			$sql = "
				UPDATE TAB_CONTENT_URL SET
				    str_url='{$str_url}', str_target='{$str_target}'
				WHERE
				    num_oid="._OID." AND num_mcode='{$mcode}'
			  ";
			if ($DB->query($sql)) {
				$DB->commit();

				//$FTP = &WebApp::singleton("FtpClient",WebApp::getConf('account'));
				unlink($_DOC_ROOT.'/hosts/'.$HOST.'/menu.xml');
				//$FTP->close();
			} 
			break;

			case "ifr":
					
			
			$sql = "
            UPDATE TAB_CONTENT_URL SET
                str_url='{$str_url}', str_target='self_', str_height='{$str_height}', dt_date=SYSDATE
            WHERE
                num_oid="._OID." AND num_mcode='{$mcode}'
			  ";
	
			if ($DB->query($sql)) {
				$DB->commit();

				///$FTP = &WebApp::singleton("FtpClient",WebApp::getConf('account'));
				unlink($_DOC_ROOT.'/hosts/'.$HOST.'/menu.xml');
				//$FTP->close();
			} 
			break;


			}	
		


		//2008-04-15 종태 게시판 명까지
			$sql = "UPDATE TAB_BOARD_CONFIG SET STR_TITLE='$new_title', str_width='$str_width',str_skin='$str_skin' WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
			$DB->query($sql);
            $DB->commit();
		

		if($title_img_del){
			unlink(_DOC_ROOT."/hosts/".HOST."/title/".$mcode.".gif");
		}
		
		if($title_img) {
		
			$file = new FileUpload("title_img"); // datafile은 form에서의 이름 
			$file->Path = _DOC_ROOT."/hosts/".HOST."/title/";  // 마지막에 /꼭 붙여야함

		//$file->file_mkdir(); 
		if(!$file->Ext("gif,png,jpg"))  {
			echo '<script>alert("업로드 가능한 파일이 아닙니다.\n(gif,png,jpg,hwp,doc,docx,ppt,pptx,xls.xlsx,pdf) 파일 가능");   history.go(-1); </script>';
			exit;
		 }
		$file->file_rename2_tmp($mcode); 
		if(!$file->upload()){
			echo '<script>alert("업로드에 실패 했습니다.");   </script>';
			exit;
		}
		$file->upload();
		}



            //$FTP = &WebApp::singleton("FtpClient",WebApp::getConf('account'));
            unlink($_DOC_ROOT.'/hosts/'.$HOST.'/menu.xml');

            
			
		$menu_name = $_POST['str_title'];


			list($module_name,$module_type) = explode('#',$str_type);
			include 'module/'.$module_name.'/admin/__add.php';
			

            $menu_data = WebApp::get($module_name,array('key'=>'menu','mcode'=>$mcode,'module_type'=>$module_type));
           
			if ($menu_data['default_rights']) {
            $sql = "select count(*) from TAB_MENU_RIGHT where num_oid = $_OID and str_code='$mcode' ";
            $right_count = $DB -> sqlFetchOne($sql);

            
            if(!$right_count) {
				$mem_types = WebApp::get('member',array('key'=>'member_types'));
                foreach($mem_types as $mem_type => $_value) {
                    $sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right)".
                           "VALUES ($_OID,'menu','$mcode','$mem_type','".$menu_data['default_rights']."')";
                    $DB->query($sql);
                }
                $DB->commit();
            }
				
            }
			


		





            echo "<script type='text/javascript'>try { parent.frames['menu'].reloadParent(); } catch(e) { };</script>";
            WebApp::redirect('menu.admin.option?mcode='.$mcode); //,'저장하였습니다');
     



///////////////////////////////////////////////////////////////////////////




            



			//$FTP = &WebApp::singleton("FtpClient",WebApp::getConf('account'));
            unlink(_DOC_ROOT.'/hosts/'.HOST.'/menu.xml');
			unlink(_DOC_ROOT.'/hosts/'.HOST.'/url.xml');
			unlink(_DOC_ROOT.'/hosts/'.HOST.'/url2.xml');

            deleteCacheFiles($mcode);




		break;
// }}}

// {{{ Functions
function cb_admin_tabs(&$arr,$key,$mcode) {
    $arr = sprintf($arr,$mcode);
}
// }}}
}

?>
