<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: lib/Template_/prefilter.webapp.php
* �ۼ���: 2004.
* �ۼ���: ��ģ����
* ��  ��: webapp�� ���ڿ� ġȯ 
*****************************************************************
* 
*/
function webapp($source,$tpl) {
    //$source = preg_replace('%((?:"@(?:\\\\\\\\|\\\\"|[^"])*")|(?:\'@(?:\\\\\\\\|\\\\\'|[^\'])*\'))%i','hosts/'.HOST,$source);
    $source = preg_replace('%(["\'])@([^\\1]+?)\\1%e','"<?php echo \"hosts/\".HOST;?>$2"',$source);
    $source = preg_replace('@\${([^}]+)}@ie','"<?php echo _(\"".addslashes("$1")."\");?>"',$source);
    $source = preg_replace('/<html([^>]*)>/i','<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wa\\1>',$source);
    //$source = eregi_replace('</head>','<meta http-equiv="content-type" content="text/html; charset=UTF-8">'."\n".'</head>',$soruce);
    return eregi_replace('</head>','<script type="text/javascript" src="js/WebApp.js"/></script>'."\n".'</head>',$source);
}
?>
