<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-09-04
* 작성자: 김종태
* 설   명: 클릭한 메뉴 세션으로 저장
*****************************************************************
* 
*/


if(!$reset){


if($cate){
$_SESSION[num_cate_ses][$cate][set] = $set;
}

echo $_SESSION[num_cate_ses];
}else{
		unset($_SESSION[num_cate_ses]);
}



?>