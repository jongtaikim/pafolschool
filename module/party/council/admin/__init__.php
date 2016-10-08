<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/council/admin/__init__.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
include_once "module/party/admin/__init__.php";

if(!function_exists('updateConf')) {
    function updateConf($pcode, $mcode, $party_conf_file) {
        //if($party_conf_file == '') $party_conf_file = 'hosts/'.HOST.'/conf/party/'.$pcode.'.conf.php';
        $INI = &WebApp::singleton('IniFile',$party_conf_file);
        $DB = &WebApp::singleton('DB');
        $sql = "SELECT * FROM ".TAB_PARTY_COUNCIL_CONFIG." WHERE num_oid="._OID." AND num_pcode=$pcode AND num_mcode=$mcode";
        if($data = $DB->sqlFetch($sql)) {
            $INI->setVar('title',$data['str_title'],$mcode);
            $INI->setVar('skin',$data['str_skin'],$mcode);
            $INI->setVar('oddcolor',$data['chr_oddcolor'],$mcode);
            $INI->setVar('evencolor',$data['chr_evencolor'],$mcode);
            $INI->setVar('use_upload',$data['chr_upload'],$mcode);
        } else {
            $INI->delSection($mcode);
        }
        $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
        $FTP->put_string($INI->_combine(),_DOC_ROOT.'/'.$party_conf_file);
    }
}
?>