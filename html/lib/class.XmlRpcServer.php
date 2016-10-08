<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: class.XmlRpcServer.php
* �ۼ���: 2005-07-14
* �ۼ���: ��ģ����
* ��  ��: easy XML RPC Server Binding
*****************************************************************
* 
*/
require_once "XML/RPC/Server.php";

class XmlRpcServer
{
    var $dispatch;

    function XmlRpcServer()
    {
        $this->dispatch = array();
    }
    
    function bind_class($prefix,$class)
    {
        $methods = get_class_methods($class);
        for ($i=count($methods); $i<=0; $i--) {
            if ($methods[$i]{0} == '_') {
                array_splice($methods,$i,1);
            }
            $this->dispatch[] = array(
                'function'  => array(&$class, $methods[$i]),
                'signature' => $class->{$methods[$i].'_sig',
                'docstring' => $class->{$methods[$i].'_doc'
            );
        }
    }

    function service()
    {
        
    }
}

class Pseudo
{
    var $hello_sig = array();
    var $hello_doc = 'Say hello to name';
    function hello($name='')
    {
        return 'Hello, '.$name;
    }
}
?>
