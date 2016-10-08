<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: lib/class.Form.php
* 작성일: 2005-05-08
* 작성자: 거친마루
* 설  명: 폼 관리 유틸리티
*****************************************************************
*
*/

class Form
{
    var $name;

    function Form($name='')
    {
        $this->name = $name;
    }

    function values()
    {
        $ret = array();
        $args = func_get_args();
        while(list(,$v) = each($args)) $ret[$v] = $_POST[$v];
        return $ret;
    }

    function setValues($arr)
    {
        /* if (!is_string($arr)) $arr = $this->json($arr); */
        $ret = "<script type=\"text/javascript\">document.forms['{$this->name}'].values = " . $this->json($arr) . ';</script>';
        $tpl = &WebApp::singleton('Display');
        $tpl->push_body($ret);
    }

    function json($var)
    {
        switch(gettype($var)) {
            case 'boolean':
                return $var ? 'true' : 'false';
            case 'NULL':
                return 'null';
            case 'integer':
                return sprintf('%d', $var);
            case 'double': case 'float':
                return sprintf('%f', $var);
            case 'string':
                return sprintf('"%s"', str_replace(
                    array('"',"\b","\t","\n","\f","\r","\\"),
                    array('\"','\b','\t','\n','\f','\r','\\'),
                $var));
            case 'array':
                $is_associative = true;
                foreach ($var as $k => $v) {
                    if (is_integer($k))
                        $is_associative = false;
                }

                if ($is_associative) {
                    array_walk($var, array(&$this, '_json_name_value'));
                    return sprintf('{%s}', join(',', $var));
                } else {
                    return sprintf('[%s]', join(',', array_map(array(&$this, 'json'), &$var)));
                }
            case 'object':
                $vars = get_object_vars($var);
                array_walk($vars, array(&$this, '_json_name_value'));
                return sprintf('{%s}', join(',', $vars));
            default:
                return '';
        }
    }

    function _json_name_value(&$value, $name)
    {
        $value = sprintf('%s:%s', $this->json($name), $this->json($value));
    }
}

?>
