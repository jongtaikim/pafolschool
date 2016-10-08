<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: namespace/wa/applet.php
* 작성일: 2005-07-07
* 작성자: 거친마루
* 설  명: 모듈을 embed 하는 태그
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
