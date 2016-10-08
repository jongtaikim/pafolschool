<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-06-27
* 작성자: 김종태
* 설   명: 디자인툴 2.0
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

$css_file = _DOC_ROOT."/hosts/".HOST."/".$r_layout."_obj.css";

switch ($REQUEST_METHOD) {
	case "GET":
	
	
	$obj_css =  file_get_contents($css_file);
	
	$obj_css =  explode("/*".$key."시작 */",$obj_css);
	$obj_css =  explode("/*".$key."끝 */",$obj_css[1]);
	$obj_css = $obj_css[0];
	
	$obj_css =  str_replace("#".$key."{","",$obj_css);
	$obj_css =  str_replace("}","",$obj_css);

	//2009-06-27 종태 게시판영역은 예외처리
	if(strstr($key,'out_bbs') || $key=="new_bbs") {
		$key_ = 'out_bbs';
	}else{
		$key_ = $key;
	}

	if(strstr($key,'part_')) {
		$key_ = 'part';
	}
	
	include _DOC_ROOT.'/object/'.$key_.'/config.inc';
	if($key=="new_bbs") $key_ ="new_bbs";
	$data = $objList;
	$conf =  WebApp::getThemeConf($r_layout.'_'.$key);
	
	if($key_ == "out_bbs" || $key_ == "new_bbs") {
	
	list($conf[bbs_code1],$conf[bbs_code2],$conf[bbs_code3],$conf[bbs_code4],$conf[bbs_code5]) = explode(",",$conf[bbs_code]);
	
	list($conf[bbs_title1],$conf[bbs_title2],$conf[bbs_title3],$conf[bbs_title4],$conf[bbs_title5]) =  explode(",",$conf[bbs_title]);

	list($conf[type1],$conf[type2],$conf[type3],$conf[type4],$conf[type5]) =  explode(",",$conf[type]);
	list($conf[listnum1],$conf[listnum2],$conf[listnum3],$conf[listnum4],$conf[listnum5]) =  explode(",",$conf[listnum]);
		
	//print_r($conf);



	$sql = "select str_title,num_mcode,num_cate from TAB_MENU where num_oid = $_OID and str_type in ('board#B','tong_board#B') order by num_cate,num_step asc";
	$bbs_row = $DB -> sqlFetchAll($sql);
	$a=0;
	for($ii=0; $ii<count($bbs_row); $ii++) {
	
		 $bbs_list_[$a] = $bbs_row[$ii];

		
		if(strlen($bbs_row[$ii][num_cate])%2 == 0){
		 $_lens = 2;
		 
		if(strlen($bbs_row[$ii][num_cate]) == 6) {

			 $bbs_list_[$a][stitle] = $DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_cate = ".substr($bbs_list_[$a][num_cate],0,2)." ");
			$bbs_list_[$a][stitle] .= "> ".$DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_cate = ".substr($bbs_list_[$a][num_cate],0,4)." ");
		
		}

		if(strlen($bbs_row[$ii][num_cate]) == 4) {

			 $bbs_list_[$a][stitle] = $DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_cate = ".substr($bbs_list_[$a][num_cate],0,2)." ");
		}
		 
		 }else{
		 $_lens = 3;

 		if(strlen($bbs_row[$ii][num_cate]) == 7) {

			 $bbs_list_[$a][stitle] = $DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_cate = ".substr($bbs_list_[$a][num_cate],0,3)." ");
			$bbs_list_[$a][stitle] .= "> ".$DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_cate = ".substr($bbs_list_[$a][num_cate],0,5)." ");
		
		}

		if(strlen($bbs_row[$ii][num_cate]) == 5) {

			 $bbs_list_[$a][stitle] = $DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_cate = ".substr($bbs_list_[$a][num_cate],0,3)." ");
		}
		 }
			

			


			
			$bbs_list_[$a][counter] = "(".$DB -> sqlFetchOne("select count(str_title) from TAB_BOARD where num_oid = $_OID and num_mcode = ".$bbs_list_[$a][num_mcode]." ").")";


			$a++;
		
	}

	$tpl->assign(array('bbs_LIST_'=>$bbs_list_,));
	}
	
	

	$tpl->assign($conf);

	for($ii=0; $ii<count($_SESSION[tem_ses]); $ii++) {
		if($_SESSION[tem_ses][$ii][name] == $key) {
			
	
			$tpl->assign($_SESSION[tem_ses][$ii]);
			
			if($key_ == "out_bbs") {
			if($_SESSION[tem_ses][$ii][bbs_code]){
			list($conf_[bbs_code1],$conf_[bbs_code2],$conf_[bbs_code3],$conf_[bbs_code4],$conf_[bbs_code5]) = explode(",",$_SESSION[tem_ses][$ii][bbs_code]); }
			
			if($_SESSION[tem_ses][$ii][bbs_title]) {
			list($conf_[bbs_title1],$conf_[bbs_title2],$conf_[bbs_title3],$conf_[bbs_title4],$conf_[bbs_title5]) =  explode(",",$_SESSION[tem_ses][$ii][bbs_title]);}
			
			if($_SESSION[tem_ses][$ii][type]) {
			list($conf_[type1],$conf_[type2],$conf_[type3],$conf_[type4],$conf_[type5]) =  explode(",",$_SESSION[tem_ses][$ii][type]);}

			if($_SESSION[tem_ses][$ii][listnum]) {
			list($conf_[listnum1],$conf_[listnum2],$conf_[listnum3],$conf_[listnum4],$conf_[listnum5]) =  explode(",",$_SESSION[tem_ses][$ii][listnum]);}
			
			//print_r($_SESSION[tem_ses][$ii]);
			if($conf_) {
				$tpl->assign($conf_);
			}
			}
		}
	}





	$tpl->setLayout('admin_xhtml');
	$tpl->define("CONTENT", Display::getTemplate("attach/de_lib.htm"));
	$tpl->assign(array(
		'LIST'=>$data,
		'mcode'=>$mcode,
		'r_layout'=>$r_layout,
		'key'=>$key,
		'key_'=>$key_,
		'obj_css'=>$obj_css,
		));
	
	
	
	 break;
	case "POST":



		if(!$mmode) $mmode = "update";
		switch ($mmode) {
			case "cssupdate":
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$obj_css_ = "/*".$key."시작 */"."#".$key."{".$obj_css."}"."/*".$key."끝 */";
			
			$obj_css =  file_get_contents($css_file);
			$obj_css =  explode("/*".$key."시작 */",$obj_css);
			
			$obj_css_ = $obj_css[0].$obj_css_;

			$obj_css =  explode("/*".$key."끝 */",$obj_css[1]);
			$obj_css_ = $obj_css_.$obj_css[1];
			
			

			$FTP->put_string($obj_css_,$css_file );

			WebApp::moveBack('저장되었습니다.');
			//echo "<script type='text/javascript'>   parent.location.reload();</script>";
			
			break;
			case "size":
			
			//2008-04-17 종태 라이브러리를 위해서
		$HOST = $_SERVER['HTTP_HOST'];

		  session_save_path("/hosts/$HOST/tmp");
		  session_start();

			$max_session_count = count($_SESSION['tem_ses']);
			if($max_session_count) {

			for($ii=0; $ii<count($_SESSION['tem_ses']); $ii++) {
				if($_SESSION['tem_ses'][$ii][name]==$key) {
				$max_session_count  =  $ii;	
				}
			}
			}
			if(!$max_session_count) $max_session_count = 0;
			$_SESSION['tem_ses'][$max_session_count]['name'] = $key;
			if($width_t) $_SESSION['tem_ses'][$max_session_count]['width'] = $width_t;
			if($height_t) $_SESSION['tem_ses'][$max_session_count]['height'] = $height_t;

			if($paddingtop !="") $_SESSION['tem_ses'][$max_session_count]['paddingtop'] = $paddingtop;
			if($paddingright !="") $_SESSION['tem_ses'][$max_session_count]['paddingright'] = $paddingright;
			if($paddingbottom !="") $_SESSION['tem_ses'][$max_session_count]['paddingbottom'] = $paddingbottom;
			if($paddingleft !="") $_SESSION['tem_ses'][$max_session_count]['paddingleft'] = $paddingleft;

			print_r($_SESSION['tem_ses']);
			//unset($_SESSION[tem_ses]);
			break;
		//////////////////////////////////////////////////////////////////////////////////////////
			case "upload":
			
			if($upfile1) {
			$file = new FileUpload("upfile1"); // datafile은 form에서의 이름 
			$file->Path = "./hosts/".HOST."/";  // 마지막에 /꼭 붙여야함

			if(!$file->Ext("gif,jpg,png"))  {
			echo '<script>alert("이미지 파일만 가능합니다.");   history.go(-1); </script>';
			exit;
			 }

			$file->file_rename2("main_web.gif"); 
			$file->upload();
			$file->Resize_Image($img_w_t,$img_h_t,"./hosts/".HOST."/"); // 이미지일때 가로 세로 사이즈로 컨버팅

			}
			?>
			<script language="Javascript">
			parent.document.getElementById('main_web_content').innerHTML = '<img src = "/hosts/<?=HOST?>/main_web.gif"  onerror = "this.src=\'/image/no279.gif\'" style="border:2 solid f9925a">'
			</script>
			<?
			WebApp::moveBack();
			 
			break;
			case "del":
			unlink("./hosts/".HOST."/main_web.gif");
			?>
			<script language="Javascript">
			parent.document.getElementById('main_web_content').innerHTML = '<img src = "/image/no279.gif" style="border:2 solid f9925a">';
			
			</script>
			<?
			WebApp::moveBack('삭제되었습니다.');
			break;

		//////////////////////////////////////////////////////////////////////////////////////////

			
		case "update":

		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));


		$_CSS2 = _CSS;
		


		$_SESSION['key_r'] = $key;
		
		
		$INI = &WebApp::singleton("IniFile");
		$INI->load('hosts/'.HOST.'/conf/'._CSS.'.conf.php');

		for($ii=0; $ii<count($_SESSION[tem_ses]); $ii++) {


		if($_SESSION[tem_ses][$ii][skin]) $INI->setVar("skin",$_SESSION[tem_ses][$ii][skin],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		if($_SESSION[tem_ses][$ii][type]) $INI->setVar("type",$_SESSION[tem_ses][$ii][type],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		if($_SESSION[tem_ses][$ii][listnum]) $INI->setVar("listnum",$_SESSION[tem_ses][$ii][listnum],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		if($_SESSION[tem_ses][$ii][col]) $INI->setVar("col",$_SESSION[tem_ses][$ii][col],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		if($_SESSION[tem_ses][$ii][len]) $INI->setVar("len",$_SESSION[tem_ses][$ii][len],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		if($_SESSION[tem_ses][$ii][subject]) $INI->setVar("subject",$_SESSION[tem_ses][$ii][subject],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		if($_SESSION[tem_ses][$ii][img_w]) $INI->setVar("img_w",$_SESSION[tem_ses][$ii][img_w],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		if($_SESSION[tem_ses][$ii][img_h]) $INI->setVar("img_h",$_SESSION[tem_ses][$ii][img_h],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		if($_SESSION[tem_ses][$ii][color1]) $INI->setVar("color1",$_SESSION[tem_ses][$ii][color1],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		if($_SESSION[tem_ses][$ii][color2]) $INI->setVar("color2",$_SESSION[tem_ses][$ii][color2],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		if($_SESSION[tem_ses][$ii][font]) $INI->setVar("font", iconv("utf-8","euc-kr",$_SESSION[tem_ses][$ii][font]),$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		if($_SESSION[tem_ses][$ii][font_size]) $INI->setVar("font_size",$_SESSION[tem_ses][$ii][font_size],$r_layout."_".$_SESSION[tem_ses][$ii][name]);

		if($_SESSION[tem_ses][$ii][text_len]) $INI->setVar("text_len",$_SESSION[tem_ses][$ii][text_len],$r_layout."_".$_SESSION[tem_ses][$ii][name]);

	
		if($_SESSION[tem_ses][$ii][title2]) {
		$INI->setVar("title2", $_SESSION[tem_ses][$ii][title2],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		}

		if($_SESSION[tem_ses][$ii][bbs_title]) {
		$INI->setVar("bbs_title", $_SESSION[tem_ses][$ii][bbs_title],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		}
		
		if($_SESSION[tem_ses][$ii][bbs_code]) {
		$INI->setVar("bbs_code", $_SESSION[tem_ses][$ii][bbs_code],$r_layout."_".$_SESSION[tem_ses][$ii][name]);
		}


		if($_SESSION[tem_ses][$ii][width]) {
		$css_w .= "#".$_SESSION[tem_ses][$ii][name]." {width:".$_SESSION[tem_ses][$ii][width]."px}";
		 
		  $sql = "
			UPDATE ".TAB_ATTACH_CONFIG." SET
				str_width='".$_SESSION[tem_ses][$ii][width]."'
			WHERE num_oid=$_OID and str_layout = '".$r_layout."'  and str_name = '".$_SESSION[tem_ses][$ii][name]."'";


		if ($DB->query($sql)) {$DB->commit();}
		
		}
		
		if($_SESSION[tem_ses][$ii][height]) {
		$css_w .= "#".$_SESSION[tem_ses][$ii][name]." {height:".$_SESSION[tem_ses][$ii][height]."px}";

		  $sql = "
			UPDATE ".TAB_ATTACH_CONFIG." SET
				str_height='".$_SESSION[tem_ses][$ii][height]."'
			WHERE num_oid=$_OID and str_layout = '".$r_layout."'  and str_name = '".$_SESSION[tem_ses][$ii][name]."'";


		if ($DB->query($sql)) {$DB->commit();}
		}


			
	


		}		
	
		$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/'.$_CSS2.'.conf.php');
		
		
		$tmp_css1 =  file_get_contents('hosts/'.HOST.'/custom_'.$r_layout.'.css').$css_w;
	
		$FTP->put_string($tmp_css1,_DOC_ROOT.'/hosts/'.HOST.'/custom_'.$r_layout.'.css');
	

		unset($_SESSION[tem_ses]);
		unset($_SESSION[mk_ses][tmp_css]);
		unset($_SESSION[mk_ses][tmp_css2]);
		

		
	
		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
		


	   include _DOC_ROOT.'/module/attach/admin/makelayer.php';
	   makelayer2($r_layout);



		if($r_layout =="main"){
			echo "<meta http-equiv='Refresh' Content=\"0; URL='/'\">";
		}else{
			WebApp::moveBack();
		}

			 break;

		}
				


	 break;
	}

?>