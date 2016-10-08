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


	$sql = "select * from TAB_CSS_CONFIG where num_oid = $_OID and str_layout = '".$layout."' order by dt_date desc";
	$backup = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('BACKUP'=>$backup));



	$str_text = file_get_contents(_DOC_ROOT."/hosts/".$_SERVER[HTTP_HOST]."/".$layout.".txt");
	$tpl->assign(array('str_text'=>$str_text));


	
	$_LAYOUT_LOCK = WebApp::getConf('layout_lock');
	$tpl->assign(array('lock'=>$_LAYOUT_LOCK[$layout]));

     include dirname(__FILE__).'/makelayer.php';
	//bbsreset();
    partreset();
    
$sql = "select str_title,num_mcode from TAB_MENU where num_oid = $_OID and str_type like 'board%' order by num_mcode,num_step asc";
$bbs_row = $DB -> sqlFetchAll($sql);
$a=0;
	for($ii=0; $ii<count($bbs_row); $ii++) {
		if(strlen($bbs_row[$ii][num_mcode])%2 == 0 || strlen($bbs_row[$ii][num_mcode])%4 == 0 || strlen($bbs_row[$ii][num_mcode])%6 == 0 ||((strlen($bbs_row[$ii][num_mcode])%3 == 0 || strlen($bbs_row[$ii][num_mcode])%5 == 0 ) && substr($bbs_row[$ii][num_mcode],0,1) == 1)){
			$bbs_list[$a] = $bbs_row[$ii];

			
			if(strlen($bbs_row[$ii][num_mcode]) == 6) {
			$bbs_list[$a][stitle] = $DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_mcode = ".substr($bbs_list[$a][num_mcode],0,2)." ");
			$bbs_list[$a][stitle] .= "> ".$DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_mcode = ".substr($bbs_list[$a][num_mcode],0,4)." ");
			}

			
			$bbs_list[$a][counter] = "(".$DB -> sqlFetchOne("select count(str_title) from TAB_BOARD where num_oid = $_OID and num_mcode = ".$bbs_list[$a][num_mcode]." ").")";


			$a++;
		}
	}
	$tpl->assign(array('bbs_LIST'=>$bbs_list));

	//2008-06-10 종태 레이아웃 순서
	$sql = "select STR_LAY_ALIGN from TAB_CSS where num_oid = $_OID and num_serial = $_CSS and str_layout='$layout'";

	if(!$css_align = $DB -> sqlFetchOne($sql)) {
			$css_align = "LOGO_TOP|TOP_BUTTON|TOP|LEFT|MAIN|RIGHT|FOOT";
	}

	$css_align = explode("|",$css_align);

	for($ii=0; $ii<count($css_align); $ii++) {
	$a = explode("_sub",$css_align[$ii]);
		
	$css_align_array[$ii]['layout']=$a[0];
	}
	
	if(count($css_align_array)==6) {
	$css_align_array[$ii+1]['layout'] = "MAIN";		
	$css_align_array[$ii+2]['layout'] = "NONE";
	}else{
	$css_align_array[$ii+1]['layout'] = "NONE";
	}
	$tpl->assign(array('CSS_ALIGN_manage' =>$css_align_array));



	//2008-05-22 종태 css 가져오기
	$sql = "select str_body_align from TAB_CSS where num_oid = $_OID and num_serial = $_CSS and str_layout='$layout'  ";
	$css_align = $DB -> sqlFetchOne($sql);
	$tpl->assign(array(	'BODY_ALIGN' => $css_align,));

	
	//2008-05-22 종태 퀵메뉴
	$sql = "select STR_QMENU, STR_QMENU_BODY, 
   STR_QMENU_W, STR_QMENU_TOP_P, STR_QMENU_LEFT_P from TAB_CSS where num_oid = $_OID and num_serial = $_CSS and str_layout='$layout'  ";
	$str_qmenu = $DB -> sqlFetch($sql);
	$tpl->assign($str_qmenu);

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
		    $row['layer'] = ($conf_data[$name]['str_layer'] ) ?  $conf_data[$name]['str_layer'] : 'NONE';
		    $row['height'] = (!$conf_data[$name]['str_height']) ? $row['avail_height'] : $conf_data[$name]['str_height'] /2 ;
            
            if(!$row['removable'] && $row['layer'] == 'NONE') $row['layer'] = $row['avail_layer'][$layout][0];
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
    	
		$tpl->define('CONTENT','html/attach/admin/manage5.htm');
        $tpl->define('MANAGE',$manage_file);
        $tpl->assign($data);
        $tpl->assign('theme', $THEME);

	

	break;
	case "POST":


$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->put_string($str_text, _DOC_ROOT."/hosts/".$_SERVER[HTTP_HOST]."/".$layout.".txt");

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


	$mk = mktime();	//2009-01-17 종태 백업을 위한 날짜


	$sql = "DELETE FROM ".TAB_ATTACH_CONFIG." WHERE NUM_OID=$_OID AND STR_LAYOUT='$layout' and num_css = '"._CSS."'";
    $DB->query($sql);

       // $ATT_CONF = Display::getAttachConf();

       /* $main_conf_path = 'hosts/'.HOST.'/conf/main.conf.php';
		$INI = &WebApp::singleton('IniFile',$main_conf_path);*/

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

	//2009-01-17 css 백업 종태
   $sql = "INSERT INTO ".TAB_ATTACH_CONFIG_TEM." (NUM_OID,STR_LAYOUT,STR_NAME,STR_LAYER,NUM_STEP,STR_WIDTH,STR_HEIGHT,STR_TYPE, NUM_LINE,  NUM_MAX, NUM_LEN,NUM_LINE_C, STR_SUBJECT, NUM_IMG_W, NUM_IMG_H,STR_TITLE,NUM_P_TOP, 
   NUM_P_RIGHT, NUM_P_BOTTOM, NUM_P_LEFT ,NUM_CSS,NUM_X,NUM_Y,STR_LOCK,NUM_DATE) ".
                   "VALUES ($_OID,'$layout','$pannel','".$att_conf['layer']."',".$steps[$att_conf['layer']].",'".$width."','".$height."','".$att_conf['type']."','".$att_conf['line']."','".$att_conf['max']."','".$att_conf['len']."','".$att_conf['len_c']."','".$att_conf['subject']."','".$att_conf['img_w']."','".$att_conf['img_h']."','".$att_conf['title']."'  ,'".$att_conf['Ptop']."'  ,'".$att_conf['Pright']."'  ,'".$att_conf['Pbottom']."'  ,'".$att_conf['Pleft']."','"._CSS."','".$att_conf['x']."','".$att_conf['y']."','".$att_conf['str_lock']."',".$mk.")";

 $DB->query($sql);
 $DB->commit();


			//모듈전체 설정 종태 2008-07-04
			$att_conf['title'] = str_replace("미니게시판","",$att_conf['title']);
			$INI->setVar("title",$att_conf['title'],$layout."_".$pannel);
			//$INI->setVar("title2",$att_conf['title'],$layout."_".$pannel);


			//각레이아웃마다 설정
			$INI->setVar("width",$width ,$layout."_".$pannel);
			$INI->setVar("height",$height,$layout."_".$pannel);
			$INI->setVar("type",$att_conf['type'],$layout."_".$pannel);
			$INI->setVar("bbs_code",$att_conf['bbs_code'],$layout."_".$pannel);
			$INI->setVar("bbs_title",$att_conf['bbs_title'],$layout."_".$pannel);

		/*	$INI->setVar("col",$att_conf['line'],$layout."_".$pannel);
			$INI->setVar("listnum",$att_conf['max'],$layout."_".$pannel);
			$INI->setVar("len",$att_conf['len'],$layout."_".$pannel);
			$INI->setVar("len_c",$att_conf['len_c'],$layout."_".$pannel);
			$INI->setVar("subject",$att_conf['subject'],$layout."_".$pannel);
			$INI->setVar("img_w",$att_conf['img_w'],$layout."_".$pannel);
			$INI->setVar("img_h",$att_conf['img_h'],$layout."_".$pannel);*/
	

        }


$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/'._CSS.'.conf.php');

//2009-01-17 css 백업 종태
$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/'._CSS.'.conf.php_'.$mk);
//exit;


//2008-05-30 종태 for문으로 부풀리기
for($ii=0; $ii<count($lay_be); $ii++) {
if($lay_be[$ii] !="NONE") {

 $lay_be_width = $lay_be[$ii]."_width";
 $lay_be_height = $lay_be[$ii]."_height";

$lay_be_display = $lay_be[$ii]."_chk_layer";

 $lay_be_width =  $$lay_be_width *2 ;
 $lay_be_height =  $$lay_be_height  *2 ;

if($$lay_be_display != "y") $display_chk[$ii]="display:none";

 $layout_css .= "#".$lay_be[$ii]."{width:".$lay_be_width.";height:".$lay_be_height.";text-align:left: border:0px solid #FFCC33; ".$display_chk[$ii]." }" ;


 } 
 }
$main_layout_width = $main_layout_width *2 ;
$layout_css = "#main_layout { width:$main_layout_width; border:0px solid #FFCC33 }".$layout_css;


$sub_center_layout_x_r = "100%" ;

$layout_css .="#sub_main_title_simple{ width:auto; }";
$layout_css .="#sub_main_title_html{ width:auto; }";
$layout_css .="#sub_main_menu{ width:auto; }";
$layout_css .="#sub_main_title{ width:auto; }";

//2008-06-03 종태 사이트 정렬
$layout_css .="#main_frame{ text-align:".$layer_align."; }";
$layout_css .="#sub_main_title{ width:auto; }";



$sql = "select STR_CSS from TAB_CSS where num_oid = $_OID and num_serial = $_CSS and str_layout='$layout' ";
$tmp_css = $DB -> sqlFetchOne($sql);


if(strstr($tmp_css,"/*aa*/")) {
$tmp_css = explode("/*aa*/",$tmp_css);
$layout_css = $layout_css."/*aa*/".$tmp_css[1];

}
if(strstr($tmp_css,"/*레이아웃영역*/")) {
$tmp_css = explode("/*레이아웃영역*/",$tmp_css);
$layout_css = $layout_css."/*레이아웃영역*/".$tmp_css[1];

}


//2008-05-30 디비 에 적용
$sql = "select count(num_serial) from TAB_CSS where num_oid = $_OID and num_serial = $_CSS and str_layout='$layout'";
$css_max = $DB -> sqlFetchOne($sql);

if(!$css_max) {

 $sql = "INSERT INTO TAB_CSS 
 ( NUM_SERIAL , STR_TITLE , NUM_OID , STR_LAYOUT ,STR_POS,STR_BODY_ALIGN,STR_CSS) 
  VALUES ("._CSS.", 'layout1', $_OID, '$layout','$total_pos','$layer_align','$layout_css')";


$DB->query($sql);
 $DB->commit();
 

}else{

 $sql = "UPDATE TAB_CSS SET STR_CSS ='".$layout_css."', STR_POS = '$total_pos',STR_BODY_ALIGN = '$layer_align' ,STR_BODY_BORDER = '$layer_border' WHERE num_oid = $_OID and num_serial = $_CSS and str_layout='$layout'";

 $DB->query($sql);
 $DB->commit();

}

//2009-01-17  백업 종태


 $sql = "INSERT INTO TAB_CSS_TEM 
 ( NUM_SERIAL , STR_TITLE , NUM_OID , STR_LAYOUT ,STR_POS,STR_BODY_ALIGN,STR_CSS, NUM_DATE) 
  VALUES ("._CSS.", 'layout1', $_OID, '$layout','$total_pos','$layer_align','$layout_css',".$mk.")";


$DB->query($sql);
 $DB->commit();

//2008-06-10 종태 레이아웃 배치 순서
for($ii=0; $ii<count($lay_be); $ii++) {
	if($lay_be[$ii] !="NONE") $end_lay .= $lay_be[$ii]."|";
}
$end_lay = substr($end_lay,0,strlen($end_lay)-1);


	
 $sql = "UPDATE TAB_CSS SET STR_LAY_ALIGN  ='".$end_lay."',
 
 str_qmenu = '$str_qmenu',
  str_qmenu_w = '$str_qmenu_w',
   str_qmenu_top_p = '$str_qmenu_top_p',
    str_qmenu_left_p = '$str_qmenu_left_p'

 
 WHERE num_oid = $_OID and num_serial = $_CSS and str_layout='$layout' and num_serial = $_CSS  ";
 $DB->query($sql);
 $DB->commit();



//2009-01-17 css 백업 종태
  $sql = "UPDATE TAB_CSS_TEM SET STR_LAY_ALIGN  ='".$end_lay."',
 str_qmenu = '$str_qmenu',
  str_qmenu_w = '$str_qmenu_w',
   str_qmenu_top_p = '$str_qmenu_top_p',
    str_qmenu_left_p = '$str_qmenu_left_p'
 WHERE num_oid = $_OID and num_serial = $_CSS and str_layout='$layout' and num_serial = $_CSS and num_date = ".$mk."  ";
 $DB->query($sql);
 $DB->commit();


$_css_file = '/hosts/'.HOST.'/'.$layout.'_'._CSS.'_css.htm';
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.$_css_file);
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$layout.'_'._CSS.'_align.htm');
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$layout.'_'._CSS.'_Pcss.htm');


$sql = "Insert into TAB_CSS_CONFIG
   (NUM_CSS, NUM_OID, STR_TITLE, STR_GONGU, DT_DATE, NUM_SET_COUNT, NUM_VOLL,STR_LAYOUT)
 Values
   ("._CSS.", "._OID.", '".date("ymd H:i:s")." 백업', 'N', '".$mk."', 0, 0,'".$layout."')";

 $DB->query($sql);
 $DB->commit();



        include dirname(__FILE__).'/makelayer.php';
		makelayer($layout,$layer_border);



	WebApp::moveBack();
	//echo "<meta http-equiv='Refresh' Content=\"0; URL='/attach.admin.select'\">";


        
	break;
}
?>