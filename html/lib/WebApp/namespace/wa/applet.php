<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: namespace/wa/applet.php
* �ۼ���: 2005-07-07
* �ۼ���: ��ģ����
* ��  ��: ����� embed �ϴ� �±�
*****************************************************************
* 
*/

if ($innerHTML) {
    $hash = md5($innerHTML);
    $dynTemplate = 'cache/dynamic/'.$GLOBALS['__html__'].'/'.$hash;
    if (!is_file($dynTemplae)) {
        savetofile($dynTemplate,$innerHTML);
    }
    if (!$attr['template']) $attr['template'] = $dynTemplate;
}
$ret = "<?php\n";
$ret.= "WebApp::call('".$attr['module']."',".array2php($attr).");";
$ret.= "\n?>";
return $ret;
?>
