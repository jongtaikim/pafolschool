<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-26
* 작성자: 김종태
* 설   명: 디스트 사용량
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$color = "AFD8F8,F6BD0F,8BBA00,FF8E46,FF8E46,008E8E,8E468E,588526,B3AA00,008ED6,9D080D,A186BE";
$color = explode(",",$color);

		$sql = "select * from TAB_ORGAN where str_hometype = 'HOME'";
		$row = $DB -> sqlFetchAll($sql);
		

	

		for($ii=0; $ii<count($row); $ii++) {
			

			

			
			$sql = "select sum(num_size) from TAB_FILES where num_oid = ".$row[$ii][num_oid]." ";
			$tot_file = $DB -> sqlFetchOne($sql);

			
			
			$row[$ii]['tot_file_r'] = $tot_file/(1024*1024);
			$row[$ii]['tot_file'] = number_format($tot_file/(1024*1024));

			$row[$ii]['str_title'] = $row[$ii]['str_organ']." ".number_format($tot_file/(1024*1024))."MB";
			
			
			if($ii % 1 == 0) {
				$row[$ii]['color'] = "AFD8F8";
			}
			if($ii % 2 == 0) {
				$row[$ii]['color'] = "F6BD0F";
			}
			if($ii % 3 == 0) {
			$row[$ii]['color'] = "8BBA00";
			}
			if($ii % 4 == 0) {
			$row[$ii]['color'] = "FF8E46";
			}
			if($ii % 5 == 0) {
			$row[$ii]['color'] = "8BBA00";
			}
			if($ii % 6 == 0) {
			$row[$ii]['color'] = "FF8E46";
			}
			if($ii % 7 == 0) {
			$row[$ii]['color'] = "008E8E";
			}
			if($ii % 8 == 0) {
			$row[$ii]['color'] = "8E468E";
			}
			if($ii % 9 == 0) {
			$row[$ii]['color'] = "588526";
			}
			if($ii % 10 == 0) {
			$row[$ii]['color'] = "B3AA00";
			}
		

			
		}


		
			
	



 echo '<?xml version="1.0" encoding="euc-kr"?>';
	$tpl->assign(array('LIST'=>$row, 'oids'=>$oids,'gtitle'=>$gtitle));
	$tpl->setLayout('blank');
	$tpl->define("CONTENT", Display::getTemplate("manage/total_disk.htm"));
	$content = $tpl->fetch('CONTENT');
	
	
	

?>