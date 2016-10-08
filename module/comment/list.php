<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2010-01-29
* 작성자: 김종태
* 설   명: URL 덧글 위젯용 리스트 이젠 URL에 덧글을 달자
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');
	
	global $mcode,$id,$module;

	$template = "/html/comment/skin/basic/list.html";
	$tpl->define($mou_name.'_W_',$template);
	
	if(!$param[code]){
		echo "wa:applet 값에 code 값이 누락되었습니다.";
		exit;
	}

	if(!$param[idx]){
		echo "wa:applet 값에 idx 값이 누락되었습니다.";
		exit;
	}


	$code = $param[code].".".$param[idx];
	$code = str_replace("&","|",$code);

	// 소스 입력부분
	$sql = "select 
		*
	from TAB_COMMENT where  num_code = '".$code."' order by   num_group asc , num_step asc";
	
	

	$row = $DB -> sqlFetchAll($sql);

	for($ii=0; $ii<count($row); $ii++) {
		$a = explode("-",$row[$ii]['dt_date']);
	
		$row[$ii]['dt_date1']= $a[0];
		
		$row[$ii]['dt_date2']= $a[1];
		$row[$ii]['dt_date3']= $a[2];
		
		if(!$_SESSION[ADMIN]) $row[$ii]['str_ip']= substr(md5($row[$ii]['str_ip']),0,8);

	}
		

	
	

	$tpl->assign(array(
	'comment_LIST'=>$row,
	'code_url'=>$code,
	'prem'=>$param[prem],
	'sect'=>$code,
	
	));
	
	
	// 소스 입력부분
    
    
    $content = $tpl->fetch($mou_name.'_W_');
    echo $content;
?>