<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/attach/admin/makelayer.php
* 작성일: 2006-05-08
* 작성자: 이범민
* 설  명: 순서에 맞게 모듈 배치하여 파일로 내린다.
*****************************************************************
* 
*/
unset($_SESSION[$layout][_attach_list]);
function makelayer($layout = 'main',$border='0',$oid = _OID, $_css = _CSS, $theme = THEME, $host = HOST) {
    $DB = &WebApp::singleton('DB');
    $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
    $tpl = &WebApp::singleton('Display');
    $FH = &WebApp::singleton('FileHost','main','part');

	$THEME_CONF = Display::getThemeConf($theme);
    $ATT_CONF = Display::AttachConf(false,true,$theme,$host);
    $layout_conf = parse_ini_file(Display::getTemplate('conf/layout.conf.php',$theme,$host),true);

	$layer_files = array();
    foreach($layout_conf[$layout] as $layer => $layer_file) {
        $layer_files[$layer] = 'hosts/'.$host.'/'.ereg_replace('^@/','',$layer_file);
    }

    foreach($THEME_CONF['attach']['layers'][$layout] as $layer) {
        $sql = "SELECT * FROM ".TAB_ATTACH_CONFIG." WHERE num_oid=$oid AND str_layout='$layout' AND str_layer='$layer' and num_css='"._CSS."' ORDER BY num_step";
        $data = $DB->sqlFetchAll($sql);
        $data2 = array();
		$ii = 0;
        foreach($data as $row) {
            $row['file'] = Display::getTemplate($ATT_CONF[$row['str_name']]['file'][$layout], $theme, $host);
            if(strpos($ATT_CONF[$row['str_name']]['modules'],'part_') !== false) {
             


			/* $sql = "select str_text1,str_text2,str_text3 from TAB_ATTACH_PART where num_oid = '$oid'  and str_name = '".$row['str_name']."' and num_css = '".$_css."'";


			$dataa = $DB -> sqlFetch($sql);
			$row['content'] = $dataa[str_text1].$dataa[str_text2].$dataa[str_text3];*/

			  $row['content'] = '<wa:applet module="attach.view_part" name="'.$row['str_name'].'" />';

			} else {
                $row['content'] = @file_get_contents($row['file']);
            }

 		   $row['content'] = $FH->set_content($row['content']);
			$row['border'] = $border;
			

			$row['Ptop'] =  $data[$ii][num_p_top];
			$row['Pright'] =  $data[$ii][num_p_right];
			$row['Pleft'] =  $data[$ii][num_p_left];
			$row['Pbottom'] =  $data[$ii][num_p_bottom];
            
			$row['lay_out'] =  $layout;

			if($layer == "MAIN_TOP" || $layer == "MAIN_FOOT") {
			$row['bak'] = "on";
			}

			if(strstr($row['str_name'],'bbs_')) {
			$row['cc'] = "Y";
                
            } else {
            $row['cc'] = "";
            }
            $data2[] = $row;
        $ii++;
		}
        $tpl->define('MAKELAYER_'.$layer,Display::getTemplate('attach/admin/makelayer_new.htm', $theme, $host));
        $tpl->assign('LIST',$data2);

		//echo _DOC_ROOT.'/'.$layer_files[$layer]."<br><br>";

		$FTP->delete(_DOC_ROOT.'/'.$layer_files[$layer]);	
        $FTP->put_string($tpl->fetch('MAKELAYER_'.$layer),_DOC_ROOT.'/'.$layer_files[$layer]);

	}
	//exit;
}

function makelayer2($layout = 'main',$border='0',$oid = _OID, $_css = _CSS, $theme = THEME, $host = HOST) {
    $DB = &WebApp::singleton('DB');
    $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
    $tpl = &WebApp::singleton('Display');
	$FH = &WebApp::singleton('FileHost','main','part');
   
	$THEME_CONF = Display::getThemeConf($theme);
    $ATT_CONF = Display::AttachConf(false,true,$theme,$host);
    $layout_conf = @parse_ini_file(Display::getTemplate('conf/layout.conf.php',$theme,$host),true);

	$layer_files = array();
    foreach($layout_conf[$layout] as $layer => $layer_file) {
        $layer_files[$layer] = 'hosts/'.$host.'/'.ereg_replace('^@/','',$layer_file);
    }

    foreach($THEME_CONF['attach']['layers'][$layout] as $layer) {
        $sql = "SELECT * FROM ".TAB_ATTACH_CONFIG." WHERE num_oid=$oid AND str_layout='$layout' AND str_layer='$layer' and num_css='"._CSS."' ORDER BY num_step";
        $data = $DB->sqlFetchAll($sql);
        $data2 = array();
		$ii = 0;
        foreach($data as $row) {
            $row['file'] = Display::getTemplate($ATT_CONF[$row['str_name']]['file'][$layout], $theme, $host);
            if(strpos($ATT_CONF[$row['str_name']]['modules'],'part_') !== false) {
                //$row['content'] = @file_get_contents($row['file']);
				
			$sql = "select str_text1,str_text2,str_text3 from TAB_ATTACH_PART where num_oid = '$oid'  and str_name = '".$row['str_name']."' and num_css = '".$_css."'";
			$dataa = $DB -> sqlFetch($sql);
			$row['content'] = $dataa[str_text1].$dataa[str_text2].$dataa[str_text3];
				
//				$row['content'] = '<wa:applet module="attach.view_part" name="'.$row['str_name'].'"/>';
            } else {
                $row['content'] = @file_get_contents($row['file']);
            }
			$row['border'] = $border;
			

			$row['content'] = $FH->set_content($row['content']);

			$row['Ptop'] =  $data[$ii][num_p_top];
			$row['Pright'] =  $data[$ii][num_p_right];
			$row['Pleft'] =  $data[$ii][num_p_left];
			$row['Pbottom'] =  $data[$ii][num_p_bottom];
            
			$row['lay_out'] =  $layout;
			if($layer == "MAIN_TOP" || $layer == "MAIN_FOOT") {
			$row['bak'] = "on";
			}


			if(strstr($row['str_name'],'bbs_')) {
			$row['cc'] = "Y";
                
            } else {
            $row['cc'] = "";
            }
            $data2[] = $row;
        $ii++;
		}
        $tpl->define('MAKELAYER_'.$layer,Display::getTemplate('attach/admin/makelayer_new.htm', $theme, $host));
        $tpl->assign('LIST',$data2);

	

		$FTP->delete(_DOC_ROOT.'/'.$layer_files[$layer]);	
        $FTP->put_string($tpl->fetch('MAKELAYER_'.$layer),_DOC_ROOT.'/'.$layer_files[$layer]);

	}
	
}



function bbsreset($layout = 'main',$border='0',$oid = _OID, $_css = _CSS, $theme = THEME, $host = HOST,$DB,$FTP,$tpl){
 $DB = &WebApp::singleton('DB');
  $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
  $tpl = &WebApp::singleton('Display');
   
//2008-03-24 종태 별도의 최근게시물을 메인 모듈로 만든다
$sql = "UPDATE TAB_BOARD_CONFIG SET num_main_view='1' WHERE num_oid=$_OID  and chr_listtype != 'D'  ";
$DB->query($sql);
$DB->commit();

$sql = "select * from TAB_BOARD_CONFIG where num_oid = '$oid'  and chr_listtype != 'D' ";
$bbs_list = $DB -> sqlFetchAll($sql);



for($ii=0; $ii<count($bbs_list); $ii++) {
	

			
	$id = $bbs_list[$ii]['num_mcode'];
    $str_title = $bbs_list[$ii]['str_title'];
		
	
	$name = "bbs_".$id;

$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$attach_conf_file = 'hosts/'.HOST.'/conf/'._CSS.'.attach.conf.php';
$FTP->put_string("",_DOC_ROOT.'/hosts/'.HOST.'/'.$attach_conf_file);

        $attach_file = 'attach/attach.bbs'.$id.'.msg';
       
		$content = "
		<wa:applet module=\"out_bbs.main\" code=\"".$id."\">
		<table align='center' width=100% height=100% border=0 cellspacing=0 cellpadding=0>
		 <tr>
		  <td style = 'border:1px solid #1261E4'>
			$str_title 
		  </td>
		 </tr>
		</table>
		</wa:applet>
		";
		$THEME_CONF = Display::getThemeConf();
		
		
		
        $FTP->put_string($content,_DOC_ROOT.'/hosts/'.HOST.'/'.$attach_file);

        $attach_file_arr = array();
        foreach($THEME_CONF['attach']['layouts'] as $_layout => $_layout_name) $attach_file_arr[] = "'".$_layout."'=>'".$attach_file."'";
        $attach_file_str = 'array('.implode(',',$attach_file_arr).')';
        
        $attach_conf_file = 'hosts/'.HOST.'/conf/'._CSS.'.attach.conf.php';
			

		$INI = &WebApp::singleton('IniFile',$attach_conf_file);
        $INI->setVar('name',$name,$name);
        $INI->setVar('title',$str_title,$name);
        $INI->setVar('modules',$name,$name);
        $INI->setVar('file',$attach_file_str,$name);
        $INI->setVar('avail_width',"array('main'=>array('635'),'sub'=>array('635'),'sub2'=>array('635'),'sub3'=>array('635'),'sub4'=>array('635'),'sub5'=>array('635'))",$name);
		$INI->setVar('avail_height',"100",$name);
        $INI->setVar('avail_layer',"array('main'=>array('MAIN','LEFT','RIGHT','TOP','LOGO_TOP','FOOT','MAIN_TOP','MAIN_FOOT','TOP_BUTTON'),'sub'=>array('MAIN','LEFT','RIGHT','TOP','LOGO_TOP','FOOT','MAIN_TOP','MAIN_FOOT','TOP_BUTTON'),'sub2'=>array('MAIN','LEFT','RIGHT','TOP','LOGO_TOP','FOOT','MAIN_TOP','MAIN_FOOT','TOP_BUTTON'),'sub3'=>array('MAIN','LEFT','RIGHT','TOP','LOGO_TOP','FOOT','MAIN_TOP','MAIN_FOOT','TOP_BUTTON'),'sub4'=>array('MAIN','LEFT','RIGHT','TOP','LOGO_TOP','FOOT','MAIN_TOP','MAIN_FOOT','TOP_BUTTON'),'sub5'=>array('MAIN','LEFT','RIGHT','TOP','LOGO_TOP','FOOT','MAIN_TOP','MAIN_FOOT','TOP_BUTTON'))",$name);
        $INI->setVar('attachable',1,$name);
        $INI->setVar('removable',1,$name);
        $FTP->put_string($INI->_combine(),_DOC_ROOT.'/'.$attach_conf_file);	
		

		$sql = "INSERT INTO ".TAB_ATTACH_CONFIG." (num_oid,str_layout,str_name,str_layer,num_step,str_width,num_css) ".
                   "VALUES ($_OID,'$layout)','$name','NONE',1,'100%','".$_oid."')";
        $DB->query($sql);
        $DB->commit();
		}
		makelayer($layout);
}


function partreset($layout = 'main',$border='0',$oid = _OID, $_css = _CSS, $theme = THEME, $host = HOST,$DB,$FTP,$tpl){
 $DB = &WebApp::singleton('DB');
  $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
  $tpl = &WebApp::singleton('Display');
   

$sql = "select * from TAB_ATTACH_PART where num_oid = '$oid' ";
$bbs_list = $DB -> sqlFetchAll($sql);



for($ii=0; $ii<count($bbs_list); $ii++) {
	

			
	$id = $bbs_list[$ii]['num_mcode'];
    $str_title = $bbs_list[$ii]['str_title'];
		
	
	$name = $bbs_list[$ii][str_name];


$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$attach_conf_file = 'hosts/'.HOST.'/conf/'._CSS.'.attach.conf.php';
$FTP->put_string("",_DOC_ROOT.'/hosts/'.HOST.'/'.$attach_conf_file);

     
		$THEME_CONF = Display::getThemeConf();
		

        $attach_file_arr = array();
        foreach($THEME_CONF['attach']['layouts'] as $_layout => $_layout_name) $attach_file_arr[] = "'".$_layout."'=>'".$attach_file."'";
        $attach_file_str = 'array('.implode(',',$attach_file_arr).')';
        
        $attach_conf_file = 'hosts/'.HOST.'/conf/'._CSS.'.attach.conf.php';
			

		$INI = &WebApp::singleton('IniFile',$attach_conf_file);
        $INI->setVar('name',$name,$name);
        $INI->setVar('title',$str_title,$name);
        $INI->setVar('modules',$name,$name);
        $INI->setVar('file',$attach_file_str,$name);
        $INI->setVar('avail_width',"array('main'=>array('635'),'sub'=>array('635'),'sub2'=>array('635'),'sub3'=>array('635'),'sub4'=>array('635'),'sub5'=>array('635'))",$name);
		$INI->setVar('avail_height',"100",$name);
        $INI->setVar('avail_layer',"array('main'=>array('MAIN','LEFT','RIGHT','TOP','LOGO_TOP','FOOT','MAIN_TOP','MAIN_FOOT','TOP_BUTTON'),'sub'=>array('MAIN','LEFT','RIGHT','TOP','LOGO_TOP','FOOT','MAIN_TOP','MAIN_FOOT','TOP_BUTTON'),'sub2'=>array('MAIN','LEFT','RIGHT','TOP','LOGO_TOP','FOOT','MAIN_TOP','MAIN_FOOT','TOP_BUTTON'),'sub3'=>array('MAIN','LEFT','RIGHT','TOP','LOGO_TOP','FOOT','MAIN_TOP','MAIN_FOOT','TOP_BUTTON'),'sub4'=>array('MAIN','LEFT','RIGHT','TOP','LOGO_TOP','FOOT','MAIN_TOP','MAIN_FOOT','TOP_BUTTON'),'sub5'=>array('MAIN','LEFT','RIGHT','TOP','LOGO_TOP','FOOT','MAIN_TOP','MAIN_FOOT','TOP_BUTTON'))",$name);
        $INI->setVar('attachable',1,$name);
        $INI->setVar('removable',1,$name);
        $FTP->put_string($INI->_combine(),_DOC_ROOT.'/'.$attach_conf_file);	
		

		$sql = "INSERT INTO ".TAB_ATTACH_CONFIG." (num_oid,str_layout,str_name,str_layer,num_step,str_width,num_css) ".
                   "VALUES ($_OID,'$layout','$name','NONE',1,'100%','".$_oid."')";
        $DB->query($sql);
        $DB->commit();
		}
		makelayer($layout);
}

?>