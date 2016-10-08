<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-06-25
* 작성자: 김종태
* 설   명: 첨부파일 탐색기
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
if(!$_SESSION[ADMIN]) {
echo "<meta http-equiv='Refresh' Content=\"0; URL='admin.main'\">";
exit;
}


function byte_convert($bytes){
	$symbol = array('byte', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

	$exp = 0;
	$converted_value = 0;
	if( $bytes > 0 ){
		$exp = floor( log($bytes)/log(1024) );
		$converted_value = ( $bytes/pow(1024,floor($exp)) );
	}
	if($bytes) {
		return sprintf( '%.2f'.$symbol[$exp], $converted_value );		
	}

	//return sprintf( '%d'.$symbol[$exp], $converted_value );
}



switch ($REQUEST_METHOD) {
	case "GET":
	
	//2009-06-25 게시판 뽑아오기
	
	if($type=="class") {
	
		$sql = "select * from TAB_CLASS_MENU where num_oid = $_OID and str_type in ('board#B','board#G') order by num_fcode";
		$row = $DB -> sqlFetchAll($sql);	

		for($i=0; $i<count($row); $i++) {
		$row[$i][size] = $DB -> sqlFetchOne("select sum(num_size) from TAB_FILES where num_oid = $_OID and str_code = '".$row[$i][num_fcode].".".$row[$i][num_mcode]."'  ");

		$row[$i][name] = $DB -> sqlFetchOne("select str_fname_full from TAB_CLASS_FORMATION where num_oid = $_OID and num_fcode = ".$row[$i][num_fcode]."  ");
	
		$row[$i][code] = $row[$i][num_fcode].".".$row[$i][num_mcode];
		}
	
		$tpl->assign(array('LIST'=>$row));
	

	
	}else{
	
		$sql = "select * from TAB_MENU where num_oid = $_OID and str_type = 'board#B'";
		$row = $DB -> sqlFetchAll($sql);
		

		for($i=0; $i<count($row); $i++) {
			$row[$i][size] = $DB -> sqlFetchOne("select sum(num_size) from TAB_FILES where num_oid = $_OID and str_code = '".$row[$i][num_mcode]."'  ");
			
		}
		$tpl->assign(array('LIST'=>$row));
	
	}


if($orderby) {
	$order_ = " order by $orderby desc";
}else{
	$order_ = " order by num_size desc";
}


if(!$page = $_REQUEST['page']) $page = 1;

if(!$listnum)$listnum = 30;
$sql = "SELECT COUNT(*) FROM TAB_FILES where num_oid = $_OID and str_code = '$mcode'";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;

$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;

$sql = "
select a.* from (
         select ROWNUM as RNUM, b.* from (


select * from TAB_FILES where num_oid = $_OID and str_code = '$mcode' $order_


)b)a
                where a.RNUM >=  $seek and a.RNUM <= $offset ";

//echo  $sql;


$frow = $DB -> sqlFetchAll($sql);


	$FH = &WebApp::singleton('FileHost','board',$mcode);

	for($ii=0; $ii<count($frow); $ii++) {
		$frow[$ii][str_url] = $FH->get_real_url($frow[$ii][str_refile]);
	$total_disk  = $total_disk + $frow[$ii][num_size];
	$frow[$ii][num_size_B] = byte_convert($frow[$ii][num_size]);
	}

	$tpl->assign(array(
	'file_LIST'=>$frow,
	'page'=>$page,
	'total'=>$total,
	'total_disk'=>$total_disk,
	'listnum'=>$listnum,
	'type'=>$type,

	));




	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("manage/file_view.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>