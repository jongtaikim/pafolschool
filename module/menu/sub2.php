<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/menu/sub.php
* 작성일: 2005-04-01
* 작성자: 이범민
* 설  명: 서브메뉴출력
*****************************************************************
* 
*/
$mcode = $_REQUEST['mcode'] ? $_REQUEST['mcode'] : '';
$fcode = $_REQUEST['fcode'] ? $_REQUEST['fcode'] : '';
$pcode = $_REQUEST['pcode'] ? $_REQUEST['pcode'] : '';
$class = $param['class'];
$class_current = $param['class_current'];

if($fcode) {
    //==-- 학급 홈페이지 메뉴 --==//
    global $CLASS_CONF;
    $DB = &WebApp::singleton('DB');
    $sql = "SELECT * FROM ".TAB_CLASS_MENU." WHERE num_oid="._OID." AND num_fcode=$fcode AND num_view=1 ORDER BY num_step";
    $DB->query($sql);
    $data = array();
    $data[] = array(
        'class' => $class.($GLOBALS['act'] == 'class.member.list' ? ' '.$class_current : ''),
        'str_title' => '급우소개',
        'str_link'  => 'class.member.list?fcode='.$fcode,
        'str_target'=> '_self'
    );
    while($row = $DB->fetch()) {
        $row['class'] = $class.($mcode == $row['num_mcode'] ? ' '.$class_current : '');
        $data[] = $row;
    }
    $data[] = array(
        'str_title' => '<button onclick="window.open(\'class.admin.frame?fcode='.$fcode.'\');"><img src="image/icon/gear.gif" width="16" height="16" border="0" alt="">관리자</button>',
    );

    $tpl = &WebApp::singleton('Display');
    $tpl->define("SUBMENU_AREA",$param['template']);
    $tpl->assign(array(
        "SUBMENU"=>$data,
        'current_menu'=>'<a href="class.main?fcode='.$fcode.'">'.$CLASS_CONF['fname_full'].'</a>',
        'mcode'=>$mcode
    ));
    $tpl->print_("SUBMENU_AREA");
} elseif($pcode) {
    //==-- 동아리 홈페이지 메뉴 --==//
    global $PARTY_CONF;
    $DB = &WebApp::singleton('DB');
    $sql = "SELECT * FROM ".TAB_PARTY_MENU." WHERE num_oid="._OID." AND num_pcode=$pcode AND num_view=1 ORDER BY num_step";
    $DB->query($sql);
    $data = array();
    while($row = $DB->fetch()) {
        $row['class'] = $class.($mcode == $row['num_mcode'] ? ' '.$class_current : '');
        $data[] = $row;
    }
    $data[] = array(
        'str_title' => '<button onclick="window.open(\'party.admin.frame?pcode='.$pcode.'\');"><img src="image/icon/gear.gif" width="16" height="16" border="0" alt="">관리자</button>',
    );

    $tpl = &WebApp::singleton('Display');
    $tpl->define("SUBMENU_AREA",$param['template']);
    $tpl->assign(array(
        "SUBMENU"=>$data,
        'current_menu'=>'<a href="party.main?pcode='.$pcode.'">'.$PARTY_CONF['pname'].'</a>',
        'mcode'=>$mcode
    ));
    $tpl->print_("SUBMENU_AREA");
} elseif($mcode) {
    //==-- 홈페이지 메뉴 --==//
    $DB = &WebApp::singleton('DB');
    switch (strlen($mcode)) {
        case 4: case 6:	case 8:
            // 서브의 서브메뉴가 있는지 검사
            $DB = &WebApp::singleton('DB');
            $subnum = $DB->sqlFetchOne("SELECT COUNT(*) FROM ".TAB_MENU." WHERE num_oid="._OID." AND num_mcode LIKE '".$mcode."__' AND num_view=1");
            if($subnum > 0) {
                $_mcode = $mcode;
            } else {
                $_mcode = substr($mcode,0,-2);
            }
            break;
        case 2: default:
            $_mcode = $mcode;
            break;
    }

    $cache_file = 'hosts/'.HOST.'/menu/'.$_mcode.'.htm';
    if(!is_file($cache_file)) {
        $current_menu = $DB->sqlFetchOne("SELECT STR_TITLE FROM ".TAB_MENU." WHERE num_oid="._OID." AND num_mcode=$_mcode");
        $sql = "SELECT /*+ INDEX(".TAB_MENU." ".PK_TAB_MENU.") */ * FROM ".TAB_MENU." ".
               "WHERE num_oid="._OID." AND num_mcode LIKE '".$_mcode."__' AND num_view=1 ORDER BY num_step";
        $data = $DB->sqlFetchAll($sql);

        $URL = &WebApp::singleton('WebAppURL');
        foreach($data as $key => $row) {
            list($module_name,$module_type) = explode('#',$row['str_type']);
            $mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$row['num_mcode']));
            $row['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];
            $row['str_target'] = $mdata['menu_target'];
            $data[$key] = $row;
        }

        $tpl = &WebApp::singleton('Display');
        $tpl->define("SUBMENU_AREA",$param['template']);
        $tpl->assign(array(
            "SUBMENU"=>$data,
            'current_menu'=>$current_menu,
            'mcode'=>$mcode
        ));
        $content = $tpl->fetch("SUBMENU_AREA");

        $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
        if(!$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST.'/menu')) {
            $FTP->chdir(_DOC_ROOT.'/hosts/'.HOST);
            $FTP->mkdir('menu');
        }
        $FTP->put_string($content,_DOC_ROOT.'/'.$cache_file);

    } else {
        $fp = fopen($cache_file,'r');
        $content = @fread($fp,filesize($cache_file));
        fclose($fp);
    }

    echo $content;
}
?>