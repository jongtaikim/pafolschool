<?
//2008-01-04 ����
/**********************************
���ο� �б� ������

���α׷� : ���� 
������ : ��ȭ
**********************************/


	
	$tpl->setLayout('menu1'); // ���̾ƿ��� ����
	$tpl->define("CONTENT", WebApp::getTemplate("admin2/sub.htm"));
        $tpl->assign(array(
			'aa'=>$aa,
			));

?>