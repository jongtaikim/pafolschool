<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-09-04
* �ۼ���: ������
* ��   ��: Ŭ���� �޴� �������� ����
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