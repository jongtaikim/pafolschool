<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-10
* 작성자: 김종태
* 설   명: 후보자등록
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	
	$sql = "select * from TAB_VOTE where num_oid = $_OID and num_serial = $serial ";
	$data = $DB -> sqlFetch($sql);
	$tpl->assign($data);
	
	$sql = "select * from TAB_VOTE_USER where num_oid = $_OID and num_serial = $serial order by num_user_number asc  ";
	$row_d = $DB -> sqlFetchAll($sql);
	

	for($ii=0; $ii<$data[num_user]; $ii++) {
         $row[$ii][num_serial] = $serial;
         $row[$ii][num_user_number] = ($ii+1);
         $row[$ii][str_name] = $row_d[$ii][str_name];
		 $ia = $ii+1;
		if(is_file(_DOC_ROOT."/hosts/".HOST."/files/vote/".$serial."_".$ia.".gif_100")) {
		$row[$ii][img] = "/hosts/".HOST."/files/vote/".$serial."_".$ia.".gif_100";
		}

	}

	$tpl->assign(array('LIST'=>$row));
	

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("vote/admin/make2.htm"));
	$tpl->assign(array(
		'serial'=>$serial,
	 ));
	 break;
	
	case "POST":

			for($a=1 ; $a<=$num_user ; $a++){
			$frmnm = "photo".$a;
			if($_FILES[$frmnm]['tmp_name']) {
				$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
				if(!$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST.'/files/vote')) {
					$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST.'/files');
					$FTP->mkdir('vote');
					$FTP->chmod(_DOC_ROOT.'/hosts/'.HOST.'/files/vote/',777);
				}
				$ext = array_pop(explode('.',$_FILES[$frmnm]['name']));
				$str_file = $serial."_".$a.".gif";

				chmod($_FILES[$frmnm]['tmp_name'],0666);
				$FTP->put($_FILES[$frmnm]['tmp_name'],_DOC_ROOT.'/hosts/'.HOST.'/files/vote/'.$str_file);
				WebApp::saveThumbImg($_FILES[$frmnm]['tmp_name'],_DOC_ROOT.'/hosts/'.HOST.'/files/vote/'.$str_file."_100",100,50,100, 1, "");
				
			
			}
		}
		
		 $sql = "delete from TAB_VOTE_USER where num_oid = "._OID." and num_serial = $serial";
		 if($DB->query($sql)){
		 $DB->commit();
		 }else{
		 echo "sql 에러 : ".$sql;
		 exit;
		 }
		
		for($ii=0; $ii<$num_user; $ii++) {
		
		if($str_name[$ii]){
		$max_serial = WebApp::maxSerial("TAB_VOTE_USER","num_user_number"," and num_serial = $serial");

		 $sql = "INSERT INTO ".TAB_VOTE_USER." (
				num_oid, num_serial, num_user_number, str_name,dt_date
				) VALUES (
				"._OID.", $serial, $max_serial, '".$str_name[$ii]."' ,".mktime()."
				) ";

				 if($DB->query($sql)){
				 $DB->commit();
				
				 }else{
				 echo "sql 에러 : ".$sql;
				 exit;
				 }				
		}
		 
			
		}
		WebApp::redirect('/vote.admin.main','적용되었습니다.');
		exit;

	 break;
	}

?>