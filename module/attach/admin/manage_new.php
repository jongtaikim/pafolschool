<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: layout/admin/manage.php
* 작성일: 2008-10-16
* 작성자: 김종태
* 설   명: 레이아웃관리
* 흠..    : 으악~~ 이걸 내가 왜 만들었지..ㅠㅠ 완전 복잡시려~~~!!!
* js       : /js/attach_core.js <-- 자바스크립트.. 완전무거움.. 압축안함..
*****************************************************************
* 
*/

if(!$layout) {
	$layout = 'main';
}


 

$DB = &WebApp::singleton('DB');

switch($REQUEST_METHOD) {
	case "GET":


	$str_text = file_get_contents(_DOC_ROOT."/hosts/".HOST."/".$layout.".txt");
	$tpl->assign(array('str_text'=>$str_text));


	
	$_LAYOUT_LOCK = WebApp::getConf('layout_lock');
	$tpl->assign(array('lock'=>$_LAYOUT_LOCK[$layout]));




	$css_align = "conf1|conf2|conf3|conf4|conf5|conf6|conf7|conf8";
	$css_align = explode("|",$css_align);

	for($ii=0; $ii<count($css_align); $ii++) {
	$a = explode("_sub",$css_align[$ii]);
		
	$css_align_array[$ii]['layout']=$a[0];
	}
	

	$css_align_array[$ii+1]['layout'] = "none";

	$tpl->assign(array('CSS_ALIGN_manage' =>$css_align_array));
	$tpl->assign(array('BODY_ALIGN' => $css_align_array,));

	

	$THEME_CONF = Display::getThemeConf();



		if(!$THEME_CONF['attach']['use_attach']) WebApp::moveBack('레이아웃 관리가 가능한 디자인 타입이 아닙니다.');
        $manage_file = WebApp::getTemplate($THEME_CONF['attach']['manage_files'][$layout]);

        $sql = "SELECT  * FROM TAB_ATTACH_CONFIG WHERE num_oid=$_OID AND str_layout='$layout' and num_css = '"._CSS."' ORDER BY num_step";
		$DB->query($sql);
        
		$i = 0;
        while($row = $DB->fetch()) {
            $row['step'] = ++$i;
            $conf_data[$row['str_name']] = $row;
        }


		$ATT_CONF = Display::AttachConf();

		$ia = $i + 10;
       $list = array();
        foreach ($ATT_CONF as $row)
        {
            $name = $row['name'];
           
		   $row['conf']=  WebApp::getThemeConf($layout.'_'.$name);
			
			$file_t = $row['file'][$layout];
			if(strpos($row['modules'],'part_')){
			if(!$row['file'][$layout]) continue;
			}
        	$row['width'] = $conf_data[$name]['str_width'] /2 ;
		    $row['layer'] = ($conf_data[$name]['str_layer'] ) ?  $conf_data[$name]['str_layer'] : 'none';
		    $row['height'] = (!$conf_data[$name]['str_height']) ? $row['avail_height'] : $conf_data[$name]['str_height'] /2 ;
            
            if(!$row['removable'] && $row['layer'] == 'none') $row['layer'] = $row['avail_layer'][$layout][0];
            $row['avail_layer'] = "'".implode("','",$row['avail_layer'][$layout])."'";
            $row['avail_width'] = "'".implode("','",$row['avail_width'][$layout])."'";
            $row['is_part'] = (strpos($row['modules'],'part_') !== false ? 1 : 0);
	
			$row['subject'] = $conf_data[$name]['str_subject'] ; //2008-06-16 모듈타입
	
			$row['Ptop'] = $conf_data[$name]['num_p_top'] ; //2008-06-16 모듈타입
			$row['Pleft'] = $conf_data[$name]['num_p_left'] ; //2008-06-16 모듈타입
			$row['Pright'] = $conf_data[$name]['num_p_right'] ; //2008-06-16 모듈타입
			$row['Pbottom'] = $conf_data[$name]['num_p_bottom'] ; //2008-06-16 모듈타입

			$row['num_x'] = $conf_data[$name]['num_x'] ; //2008-06-16 모듈타입
			$row['num_y'] = $conf_data[$name]['num_y'] ; //2008-06-16 모듈타입
			$row['str_lock'] = $conf_data[$name]['str_lock'] ; //2008-06-16 모듈타입

			$row['type'] = $row['conf']['type'] ; //2008-06-16 모듈타입
			$row['bbs_title'] = $row['conf']['bbs_title'] ; //2008-06-16 모듈타입
			$row['bbs_code'] = $row['conf']['bbs_code'] ; //2008-06-16 모듈타입

		if($conf_data[$name]['step']) {
		$data['LIST'][$conf_data[$name]['step']] = $row;	
		}else{
		$data['LIST'][$ia] = $row;	
		}
		

		//$data['LIST'][$conf_data[$name]['step']] = $row;	
		$ia++;
		
		}

		ksort($data['LIST']);


		$data['layout'] = $layout;
		$data['LAYOUTS'] = $THEME_CONF['attach']['layouts'];


        $tpl->setLayout('no');
    	
		$tpl->define('CONTENT','html/attach/admin/manage_new.htm');
        $tpl->define('MANAGE',$manage_file);
        $tpl->assign($data);
        $tpl->assign('theme', $THEME);

	

	break;
	case "POST":




$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->put_string($str_text, _DOC_ROOT."/hosts/".HOST."/".$layout.".txt");

$FTP->delete(_DOC_ROOT.$_css_file);

		  $dellist=array();
		  $dellist[]="inc.".$layout.".out_bbs1.htm";
		  $dellist[]="inc.".$layout.".out_bbs2.htm";
		  $dellist[]="inc.".$layout.".out_bbs3.htm";
		  $dellist[]="inc.".$layout.".out_bbs4.htm";
		  $dellist[]="inc.".$layout.".out_bbs5.htm";
		  $dellist[]=$layout.'_'._CSS.'_css.htm';

		 $dellist[]="menu.xml";
		 $dellist[]="url.xml";

		for($ii=0; $ii<count($dellist); $ii++) {
		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$dellist[$ii]);
		}


		if($layout =="main") {
			

		 $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			
		}

			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/'._CSS.'.conf.php');



	$sql = "DELETE FROM ".TAB_ATTACH_CONFIG." WHERE NUM_OID=$_OID AND STR_LAYOUT='$layout' and num_css = '"._CSS."'";
    $DB->query($sql);

		$pannels = $_POST['pannels'];
        
		
		$steps = array();
        foreach($pannels as $pannel) {
            $att_conf = $_POST[$pannel];




            $steps[$att_conf['layer']] += 1;

	$height = $att_conf['height'] *2;
	$width = $att_conf['width'] *2;
    

      $sql = "INSERT INTO ".TAB_ATTACH_CONFIG." (NUM_OID,STR_LAYOUT,STR_NAME,STR_LAYER,NUM_STEP,STR_WIDTH,STR_HEIGHT,STR_TYPE, NUM_LINE,  NUM_MAX, NUM_LEN,NUM_LINE_C, STR_SUBJECT, NUM_IMG_W, NUM_IMG_H,STR_TITLE,NUM_P_TOP, 
   NUM_P_RIGHT, NUM_P_BOTTOM, NUM_P_LEFT ,NUM_CSS,NUM_X,NUM_Y,STR_LOCK) ".
                   "VALUES ($_OID,'$layout','$pannel','".$att_conf['layer']."',".$steps[$att_conf['layer']].",'".$width."','".$height."','".$att_conf['type']."','".$att_conf['line']."','".$att_conf['max']."','".$att_conf['len']."','".$att_conf['len_c']."','".$att_conf['subject']."','".$att_conf['img_w']."','".$att_conf['img_h']."','".$att_conf['title']."'  ,'".$att_conf['Ptop']."'  ,'".$att_conf['Pright']."'  ,'".$att_conf['Pbottom']."'  ,'".$att_conf['Pleft']."','"._CSS."','".$att_conf['x']."','".$att_conf['y']."','".$att_conf['str_lock']."')";

 $DB->query($sql);
 $DB->commit();



			//모듈전체 설정 종태 2008-07-04
			$att_conf['title'] = str_replace("미니게시판","",$att_conf['title']);
			$INI->setVar("title",$att_conf['title'],$layout."_".$pannel);
			//$INI->setVar("title2",$att_conf['title'],$layout."_".$pannel);


			//각레이아웃마다 설정
		/*		$INI->setVar("width",$width ,$layout."_".$pannel);
			$INI->setVar("height",$height,$layout."_".$pannel);
			$INI->setVar("type",$att_conf['type'],$layout."_".$pannel);
			$INI->setVar("bbs_code",$att_conf['bbs_code'],$layout."_".$pannel);
			$INI->setVar("bbs_title",$att_conf['bbs_title'],$layout."_".$pannel);

		$INI->setVar("col",$att_conf['line'],$layout."_".$pannel);
			$INI->setVar("listnum",$att_conf['max'],$layout."_".$pannel);
			$INI->setVar("len",$att_conf['len'],$layout."_".$pannel);
			$INI->setVar("len_c",$att_conf['len_c'],$layout."_".$pannel);
			$INI->setVar("subject",$att_conf['subject'],$layout."_".$pannel);
			$INI->setVar("img_w",$att_conf['img_w'],$layout."_".$pannel);
			$INI->setVar("img_h",$att_conf['img_h'],$layout."_".$pannel);*/
	
	
			
			if(!is_file(_DOC_ROOT.'/hosts/'.HOST.'/'.$pannel.'_'.$layout.'.css')){
				$FTP->put_string("/**/",_DOC_ROOT.'/hosts/'.HOST.'/'.$pannel.'_'.$layout.'.css');
			}
		//2009-06-19 custom.css 만들기
		
			if($pannel == "bannerZone") {
				$custom_css .=  "#bannerZoneBody {width:".($width-13)."px;}\n";	
			}else if($pannel=="sub_content"){
				$custom_css .=  "#".$pannel." {width:".$width."px; ; float:left;}\n";
			}else if($pannel=="submenuObj"){
				$custom_css .=  "#".$pannel." {width:".$width."px; ; float:left;}\n";
			}else{
				$custom_css .=  "#".$pannel." {width:".$width."px; ; height:".$height."px;  float:left;}\n";
			}
		}


		$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/'._CSS.'.conf.php');

		

		//2008-05-30 종태 for문으로 부풀리기
		for($ii=0; $ii<count($lay_be); $ii++) {
			if($lay_be[$ii] !="none") {

			 $lay_be_width = $lay_be[$ii]."_width";
			 $lay_be_height = $lay_be[$ii]."_height";

			$lay_be_display = $lay_be[$ii]."_chk_layer";

			 $lay_be_width =  $$lay_be_width *2 ;
			 $lay_be_height =  $$lay_be_height  *2 ;

			//if($$lay_be_display != "y") $display_chk[$ii]="display:none";

			 $layout_css .= "
			 #".$lay_be[$ii]."{width:".$lay_be_width."px;text-align:left: ; ".$display_chk[$ii]." }" ;


			 } 
		 }



		

		//2009-06-19 custom.css 만들기
		$FTP->put_string($custom_css, _DOC_ROOT.'/hosts/'.HOST.'/custom_'.$layout.'.css');
		$FTP->put_string($layout_css, _DOC_ROOT.'/hosts/'.HOST.'/custom_layout_'.$layout.'.css');

        include dirname(__FILE__).'/makelayer.php';
		makelayer($layout,$layer_border);



	//WebApp::moveBack();
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/attach.admin.manage_new?layout=$layout&PageNum=050100'\">";


        
	break;
}
?>