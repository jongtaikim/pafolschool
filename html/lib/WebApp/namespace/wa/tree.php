<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: namespace/wa/tree.php
* �ۼ���: 2005-07-07
* �ۼ���: ��ģ����
* ��  ��: Ʈ�� ������Ʈ
*****************************************************************
* 
*/
if (!$attr['src']) {
    $hash = md5($innerHTML);
    $dynSrc = 'cache/dynamic/'.$GLOBALS['__html__'].'/'.$hash.'.xml';
    if (!is_file($dynSrc)) {
        $_treexml = '<'.'?xml version="1.0" encoding="euc-kr"?'.'>';
        $_treexml.= $innerHTML;
        savetofile($dynSrc,$_treexml);
    }
    $attr['src'] = $dynSrc;
}
if (!$attr['var']) $attr['var'] = 'tree';

return <<<__EOS__
<link rel="stylesheet" type="text/css" href="css/xtree.css" />
<script type="text/javascript" src="js/xmlextras.js"></script>
<script type="text/javascript" src="js/xtree.js"></script>
<script type="text/javascript" src="js/xloadtree.js"></script>
<script type="text/javascript">
var {$attr['var']} = new WebFXLoadTree("{$attr['text']}","{$attr['src']}","{$attr['action']}","explorer","{$attr['icon']}");
document.write({$attr['var']});
</script>
__EOS__;
?>
