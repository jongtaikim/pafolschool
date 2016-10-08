<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/board/admin/__init__.php
* �ۼ���: 2006-05-11
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
include_once "module/party/admin/__init__.php";

if(!function_exists('updateConf')) {
    function updateConf($pcode, $mcode, $party_conf_file) {
        //if($party_conf_file == '') $party_conf_file = 'hosts/'.HOST.'/conf/party/'.$pcode.'.conf.php'
        include "module/party/board/table_define.php";
        $INI = &WebApp::singleton('IniFile',$party_conf_file);
        $DB = &WebApp::singleton('DB');
        $sql = "SELECT * FROM $CONFIG_TABLE WHERE num_oid="._OID." AND num_pcode=$pcode AND num_mcode=$mcode";
        if($data = $DB->sqlFetch($sql)) {
            $INI->setVar('title',$data['str_title'],$mcode);
            $INI->setVar('skin',$data['str_skin'],$mcode);
            $INI->setVar('listtype',$data['chr_listtype'],$mcode);
            $INI->setVar('oddcolor',$data['chr_oddcolor'],$mcode);
            $INI->setVar('evencolor',$data['chr_evencolor'],$mcode);
            $INI->setVar('use_comment',$data['chr_comment'],$mcode);
            $INI->setVar('use_upload',$data['chr_upload'],$mcode);
        } else {
            $INI->delSection($mcode);
        }
        $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
        $FTP->put_string($INI->_combine(),_DOC_ROOT.'/'.$party_conf_file);
    }
}
?>