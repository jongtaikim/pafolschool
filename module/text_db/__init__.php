<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/

$index_word = array(
"ㄱ", "ㄴ", "ㄷ", "ㄹ", "ㅁ", "ㅂ", "ㅅ", "ㅇ", "ㅈ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "1", "2", "3", "4", "5", "6", "7", "8", "9" 
);
for($ii=0; $ii<count($index_word); $ii++) {
	$idx_word[$ii][word] = $index_word[$ii];
}

$tpl->assign(array('index_word'=>$idx_word));



$PERM = &WebApp::singleton('Permission');
$env['writable'] = (($oid == $_OID) && ($_SESSION['ADMIN'] || $PERM->check('menu',$mcode,'w')));
$env['admin'] = (($oid == $_OID) && $_SESSION['ADMIN']);

//==-- 레이아웃 설정하기 --==//

if(!$env['writable']){
	if((($PERM->check('menu',$mcode,'a')) && $_SESSION[USERID]) || $_SESSION[ADMIN]) {
		$_SESSION[ADMIN_sub] = true;
		$env['writable'] = 'y';
	}else{
		unset($_SESSION[ADMIN_sub]);
		unset($env['writable']);
	}
}
$tpl->assign($env);


?>