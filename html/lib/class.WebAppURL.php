<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: class.WebAppURL.php
* �ۼ���: 2005-01-16
* �ۼ���: ��ģ����
* ��  ��: QueryString Ŭ���� Ȯ��
*****************************************************************
*/

require_once "class.QueryString.php";

class WebAppURL extends QueryString
{
    var $base;

    function WebAppURL($str="") {
        $this->QueryString($str);
        if (defined(MODULE)) $this->vars['act'] = MODULE;
    }

    function getVar($alter="", $flag = true) {
        if ($flag) $alter = array_merge($this->vars,$alter);
        $buff = array();
        if (ereg('^(\.+)',$alter['act'],&$reg)) {
            $len = $i = strlen($reg[1]);
            $curr = MODULE;
            while ($i-- > 0) {
                $curr = substr($curr,0,strrpos($curr,'.'));
            }
            $alter['act'] = $curr.'.'.substr($alter['act'],$len);
        }

        if (defined('HUMAN_URI')) {
            $this->base = $alter['act'];
            unset($alter['act']);
        }
        foreach ($alter as $_key=>$_val) if ($_val !== '') $buff[] = "$_key=$_val";
        return $this->base . (($qs = implode("&",$buff)) ? "?$qs" : '');
    }
}
?>
