<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/menu/subget.php
* �ۼ���: 2006-07-05
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
$code = $_REQUEST['code'];
switch($code{0}) {
    case 'f':
        // �б�Ȩ������ �޴�
        break;
    case 'p':
        // ���Ƹ� �޴�
        break;
    default :
        // ���θ޴�
        $mcode = $code;
        $DB = &WebApp::singleton('DB');
        $sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '".$mcode."__' AND num_view=1 ORDER BY num_step";
        $DB->query($sql);
        $data = array();
        while($row = $DB->fetch()) {
            list($module_name,$module_type) = explode('#',$row['str_type']);
            $mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$row['num_mcode']));
            $data[$row['num_mcode']] = array(
                    'mcode' => $row['num_mcode'],
                    'link'  => is_array($mdata['menu_url']) ? $URL->getVar($mdata['menu_url'],false) : $mdata['menu_url'],
                    'target'=> $mdata['menu_target'],
                    'title' => $row['str_title']
                );
        }
        $JSON = WebApp::singleton('JSON');
        echo $JSON->encode($data);
        exit;
        break;
}
?>