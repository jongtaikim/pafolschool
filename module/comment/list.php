<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2010-01-29
* �ۼ���: ������
* ��   ��: URL ���� ������ ����Ʈ ���� URL�� ������ ����
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');
	
	global $mcode,$id,$module;

	$template = "/html/comment/skin/basic/list.html";
	$tpl->define($mou_name.'_W_',$template);
	
	if(!$param[code]){
		echo "wa:applet ���� code ���� �����Ǿ����ϴ�.";
		exit;
	}

	if(!$param[idx]){
		echo "wa:applet ���� idx ���� �����Ǿ����ϴ�.";
		exit;
	}


	$code = $param[code].".".$param[idx];
	$code = str_replace("&","|",$code);

	// �ҽ� �Էºκ�
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
	
	
	// �ҽ� �Էºκ�
    
    
    $content = $tpl->fetch($mou_name.'_W_');
    echo $content;
?>