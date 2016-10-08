<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/core/rpc.php
* 작성일: 2005-06-18
* 작성자: 거친마루
* 설  명: 원격 명령을 수행하는 모듈
*****************************************************************
* 
*/

require_once "XML/RPC/Server.php";

header('Content-type: text/xml');
$RPCS = new XML_RPC_Server(
    array(
        /* method help */
        'system.listMethods' => array(
            'function' => 'XML_RPC_Server_listMethods',
            'signature' => $GLOBALS['XML_RPC_Server_listMethods_sig'],
            'docstring' => $GLOBALS['XML_RPC_Server_listMethods_doc']
        ),
        'system.methodHelp' => array(
            'function' => 'XML_RPC_Server_methodHelp',
            'signature' => $GLOBALS['XML_RPC_Server_methodHelp_sig'],
            'docstring' => $GLOBALS['XML_RPC_Server_methodHelp_doc']
        ),
        'test.hello' => array(
            'function' => 'hello',
            'docstring' => 'Test function: returns greeting message to $param1'
        ),
        'host.info' => array(
            'function' => 'host_info',
            'docstring' => 'returns host information'
        ),
        'host.create' => array(
            'function' => 'host_create',
            'docstring' => 'creates a new host'
        )
    ),
    true
);

// {{{ Builtin functions
function Response($v,$encode=1)
{
    if ($encode == 1) {
        @array_walk($v,'_encode_utf8');
    }
    return new XML_RPC_Response(XML_RPC_Encode($v,$encode));
}

function _encode_utf8(&$arr)
{
    if (is_array($arr)) {
        @array_walk($arr,'_encode_utf8');
    } elseif (is_string($arr)) {
        $arr = iconv('CP949','UTF-8//ignore',$arr);
    }
}
// }}}

// {{{ Methods
function hello($params)
{
    $p = $params->getParam(0);
    $name = $p->scalarval();
    return new XML_RPC_Response(XML_RPC_Encode('Hello, '.$name));
}

function host_info($params)
{
    $p = $params->getParam(0);
    $name = $p->scalarval();
    return Response(array(
        'name' => '담비초등학교',
        'oid' => '10771',
        'expire' => '2009-12-31'
    ));
}

function host_create($params)
{
}
// }}}
?>
