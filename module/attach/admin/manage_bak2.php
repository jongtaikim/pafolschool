<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: layout/admin/manage.php
* 작성일: 2006-04-25
* 작성자: 이범민
* 설  명: 레이아웃관리
*****************************************************************
* 
*/


if(!$layout) {
	$layout = 'main';
}

$DB = &WebApp::singleton('DB');

switch($REQUEST_METHOD) {
	case "GET":




	
	//2008-06-10 종태 레이아웃 순서

	$sql = "select STR_LAY_ALIGN from TAB_CSS where num_oid = '$_OID' and num_serial = '$_CSS' and str_layout='$layout'";

	if(!$css_align = $DB -> sqlFetchOne($sql)) {
		if($layout=="main") {
		$css_align = "LOGO_TOP|TOP_BUTTON|TOP|LEFT|MAIN|RIGHT|FOOT";
		}else{
		$css_align = "LOGO_TOP_".$layout."|TOP_BUTTON_".$layout."|TOP_".$layout."|LEFT_".$layout."|RIGHT_".$layout."|FOOT";
		}
	}

	$css_align = explode("|",$css_align);

	for($ii=0; $ii<count($css_align); $ii++) {

	$css_align_array[$ii]['layout']=$css_align[$ii];
	}
	$css_align_array[$ii+1]['layout'] = "NONE";
	$tpl->assign(array('CSS_ALIGN_manage' =>$css_align_array));


	

	//2008-05-22 종태 css 가져오기
	$sql = "select str_body_align,str_body_border from TAB_CSS where num_oid = '$_OID' and num_serial = '$_CSS' and str_layout='$layout'  ";
	$css_align = $DB -> sqlFetch($sql);

	$tpl->assign(array(
		'_STR_POS'=>$STR_POS,
		'BODY_ALIGN' => $css_align[str_body_align],
		'BODY_BORDER' => $css_align[str_body_border]
		));
		
	
	
	$THEME_CONF = Display::getThemeConf();


		if(!$THEME_CONF['attach']['use_attach']) WebApp::moveBack('레이아웃 관리가 가능한 디자인 타입이 아닙니다.');
        $manage_file = WebApp::getTemplate($THEME_CONF['attach']['manage_files'][$layout]);
		//echo "manage_file:$manage_file";

        $sql = "SELECT  * FROM TAB_ATTACH_CONFIG WHERE num_oid=$_OID AND str_layout='$layout' ORDER BY num_step";
        //echo $sql;
		$DB->query($sql);
        $i = 0;
        while($row = $DB->fetch()) {
            $row['step'] = ++$i;
            $conf_data[$row['str_name']] = $row;
        }

		$ATT_CONF = Display::getAttachConf();
		/*echo "<xmp>";
		print_r($ATT_CONF);
		exit;*/

       $list = array();
        foreach ($ATT_CONF as $row)
        {
            $name = $row['name'];
            
			$file_t = $row['file'][$layout];
			if(!$row['avail_layer'][$layout]) continue;
            
		
			$row['width'] = $conf_data[$name]['str_width'] ;

		
            $row['layer'] = ($conf_data[$name]['str_layer'] && in_array($conf_data[$name]['str_layer'], $row['avail_layer'][$layout])) ?
                            $conf_data[$name]['str_layer'] : 'NONE';


            $row['height'] = (!$conf_data[$name]['str_height']) ? $row['avail_height'] : $conf_data[$name]['str_height'] ;
	

            $row['bg'] = ($conf_data[$name]['str_bg'] && in_array($conf_data[$name]['str_bg'], $row['avail_bg'])) ?   $conf_data[$name]['str_bg'] : '0';


            if(!$row['removable'] && $row['layer'] == 'NONE') $row['layer'] = $row['avail_layer'][$layout][0];
            $row['avail_layer'] = "'".implode("','",$row['avail_layer'][$layout])."'";
            $row['avail_width'] = "'".implode("','",$row['avail_width'][$layout])."'";
            $row['is_part'] = (strpos($row['modules'],'part_') !== false ? 1 : 0);

			
			$row['type'] = $conf_data[$name]['str_type'] ; //2008-06-16 모듈타입
			$row['line'] = $conf_data[$name]['num_line'] ; //2008-06-16 모듈타입
			$row['len'] = $conf_data[$name]['num_len'] ; //2008-06-16 모듈타입
			$row['max'] = $conf_data[$name]['num_max'] ; //2008-06-16 모듈타입

			$row['line_c'] = $conf_data[$name]['num_line_c'] ; //2008-06-16 모듈타입
			$row['subject'] = $conf_data[$name]['str_subject'] ; //2008-06-16 모듈타입
			$row['img_w'] = $conf_data[$name]['num_img_w'] ; //2008-06-16 모듈타입
			$row['img_h'] = $conf_data[$name]['num_img_h'] ; //2008-06-16 모듈타입

			$data['LIST'][$conf_data[$name]['step']] = $row;
        }
        $data['LIST2'] = $data['LIST'];
		ksort($data['LIST']);

		


		$data['layout'] = $layout;
		$data['LAYOUTS'] = $THEME_CONF['attach']['layouts'];


        $tpl->setLayout('menu2_no');
    	
	
		$tpl->define('CONTENT','html/attach/admin/manage.htm');
	

			

        $tpl->define('MANAGE',$manage_file);
        $tpl->assign($data);
        $tpl->assign('theme', $THEME);

	break;
	case "POST":







if($layout =="main") {
	

 $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	


		  $dellist=array();
		  $dellist[]="inc.main.banner.htm";
		  $dellist[]="inc.main.calendar.htm";
		  $dellist[]="inc.main.latestboard.G.htm";
		  $dellist[]="inc.main.latestboard1.B.htm";
		  $dellist[]="inc.main.lunch.htm";
		  $dellist[]="inc.main.news.com.htm";
		  $dellist[]="inc.main.news.sch.htm";
  		  $dellist[]="inc.main.news.sch2.htm";
		  $dellist[]="inc.main.poll.htm";
		  $dellist[]="left.htm";
		  $dellist[]="copyright.htm";
		  $dellist[]="menu.xml";
		  $dellist[]="main.htm";
		  $dellist[]="right.htm";

		  $dellist[]="logo_top.htm";
		  $dellist[]="top_menu.htm";

		  $dellist[]="foot.htm";
  		  $dellist[]="foot_sub.htm";


		for($ii=0; $ii<count($dellist); $ii++) {
		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$dellist[$ii]);
				
		}


		//deleteCacheFiles($mcode);
			

		
		
}

			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');


		


	$sql = "DELETE FROM ".TAB_ATTACH_CONFIG." WHERE NUM_OID=$_OID AND STR_LAYOUT='$layout'";
        $DB->query($sql);

        $ATT_CONF = Display::getAttachConf();

        $main_conf_path = 'hosts/'.HOST.'/conf/main.conf.php';
		$INI = &WebApp::singleton('IniFile',$main_conf_path);

		$pannels = $_POST['pannels'];
        
		
		$steps = array();
        foreach($pannels as $pannel) {
            $att_conf = $_POST[$pannel];




            $steps[$att_conf['layer']] += 1;

	//$att_conf['width'] = $att_conf['width'] *2;
	//$att_conf['height'] = $att_conf['height'] *2;
    
      $sql = "INSERT INTO ".TAB_ATTACH_CONFIG." (NUM_OID,STR_LAYOUT,STR_NAME,STR_LAYER,NUM_STEP,STR_WIDTH,STR_HEIGHT,STR_TYPE, NUM_LINE,  NUM_MAX, NUM_LEN,NUM_LINE_C, STR_SUBJECT, NUM_IMG_W, NUM_IMG_H,STR_TITLE  ) ".
                   "VALUES ($_OID,'$layout','$pannel','".$att_conf['layer']."',".$steps[$att_conf['layer']].",'".$att_conf['width']."','".$att_conf['height']."','".$att_conf['type']."','".$att_conf['line']."','".$att_conf['max']."','".$att_conf['len']."','".$att_conf['len_c']."','".$att_conf['subject']."','".$att_conf['img_w']."','".$att_conf['img_h']."','".$att_conf['title']."')";

			$DB->query($sql); 

			//모듈전체 설정 종태 2008-07-04
			$att_conf['title'] = str_replace("미니게시판","",$att_conf['title']);
			$INI->setVar("title",$att_conf['title'],$pannel);


			//각레이아웃마다 설정
			$INI->setVar("width",$att_conf['width'],$layout."_".$pannel);
			$INI->setVar("height",$att_conf['height'],$layout."_".$pannel);
		
			/*$INI->setVar("type",$att_conf['type'],$layout."_".$pannel);
			$INI->setVar("col",$att_conf['line'],$layout."_".$pannel);
			$INI->setVar("listnum",$att_conf['max'],$layout."_".$pannel);
			$INI->setVar("len",$att_conf['len'],$layout."_".$pannel);
			$INI->setVar("len_c",$att_conf['len_c'],$layout."_".$pannel);
			$INI->setVar("subject",$att_conf['subject'],$layout."_".$pannel);
			$INI->setVar("img_w",$att_conf['img_w'],$layout."_".$pannel);
			$INI->setVar("img_h",$att_conf['img_h'],$layout."_".$pannel);*/
	

        }


$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');

//exit;


//2008-05-30 종태 for문으로 부풀리기
for($ii=0; $ii<count($lay_be); $ii++) {
if($lay_be[$ii] !="NONE") {

 $lay_be_width = $lay_be[$ii]."_width";
 $lay_be_height = $lay_be[$ii]."_height";

 $lay_be_width =  $$lay_be_width ;
 $lay_be_height =  $$lay_be_height ;

 $layout_css .= "#".$lay_be[$ii]."{width:".$lay_be_width.";height:".$lay_be_height."; border:".$layer_border."px solid #FFCC33;  }" ;
 } 
 }


$sub_center_layout_x_r = "100%" ;

$layout_css .="#sub_main_title_simple{ width:auto; }";
$layout_css .="#sub_main_title_html{ width:auto; }";
$layout_css .="#sub_main_menu{ width:auto; }";
$layout_css .="#sub_main_title{ width:auto; }";

//2008-06-03 종태 사이트 정렬
$layout_css .="#main_frame{ text-align:".$layer_align."; }";
$layout_css .="#sub_main_title{ width:auto; }";

/*
for($ii=1; $ii<11; $ii++) {
	$cook_id = "gaid_w".$ii ;
	$cook_id2 = "gaid_h".$ii ;

	if($HTTP_COOKIE_VARS[$cook_id]){
	if($HTTP_COOKIE_VARS[$cook_id]['gw']) $layout_css .="#".$cook_id."{ width:".$HTTP_COOKIE_VARS[$cook_id]['gw']."; }";
	}
	if($HTTP_COOKIE_VARS[$cook_id2]){
	if($HTTP_COOKIE_VARS[$cook_id2]['gh']) $layout_css .="#".$cook_id2."{ height:".$HTTP_COOKIE_VARS[$cook_id2]['gh']."; }";
	}
}

*/



//2008-05-30 디비 에 적용
$sql = "select count(num_serial) from TAB_CSS where num_oid = '$_OID' and num_serial = '$_CSS' and str_layout='$layout'";
$css_max = $DB -> sqlFetchOne($sql);

if(!$css_max) {
 $sql = "select max(num_serial) from TAB_CSS where num_oid = '$_OID' and num_serial = '$_CSS' and str_layout='$layout'";
 $max_qqq = $DB -> sqlFetchOne($sql) + 1;


 $sql = "INSERT INTO TAB_CSS 
 ( NUM_SERIAL , STR_TITLE , NUM_OID , STR_LAYOUT ,STR_POS,STR_BODY_ALIGN,STR_CSS) 
  VALUES ('$max_qqq', 'layout1', '$_OID', '$layout','$total_pos','$layer_align','$layout_css')";


$DB->query($sql);
 $DB->commit();
 

}else{

 $sql = "UPDATE TAB_CSS SET STR_CSS ='".$layout_css."', STR_POS = '$total_pos',STR_BODY_ALIGN = '$layer_align' ,STR_BODY_BORDER = '$layer_border' WHERE num_oid = '$_OID' and num_serial = '$_CSS' and str_layout='$layout'";

 $DB->query($sql);
 $DB->commit();

}

//2008-06-10 종태 레이아웃 배치 순서
for($ii=0; $ii<count($lay_be); $ii++) {
	if($lay_be[$ii] !="NONE") $end_lay .= $lay_be[$ii]."|";
}
$end_lay = substr($end_lay,0,strlen($end_lay)-1);


	
 $sql = "UPDATE TAB_CSS SET STR_LAY_ALIGN  ='".$end_lay."' WHERE num_oid = '$_OID' and num_serial = '$_CSS' and str_layout='$layout' ";
 $DB->query($sql);
 $DB->commit();



        $FTP = &WebApp::singleton('FtpClient', WebApp::getConf('account'));
		$FTP->put_string($INI->_combine(),_DOC_ROOT.'/'.$main_conf_path);

        include dirname(__FILE__).'/makelayer.php';


		
		makelayer($layout);

		WebApp::moveBack();


        
	break;
}
?>