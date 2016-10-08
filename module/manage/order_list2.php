<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 사이트 신청
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");

$FH = &WebApp::singleton('FileHost','main','ogran_data');
$id = $_REQUEST['id'];
$flg = $_REQUEST['flg'];
$del=$_REQUEST['del'];

switch ($REQUEST_METHOD) {
	case "GET":
	

	



$DOC_TITLE = "str:서비스 현황";	

if(!$listnum)$listnum = 30;


if($mcode) {
$total = $DB->sqlFetchOne("select count(*) from tab_organ_order where num_v = '1'");	
}else{
$total = $DB->sqlFetchOne("select count(*) from tab_organ_order");	
}

if(!$total) $total = 0;
if(!$page) $page = 1;
$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;


$key = $_REQUEST['key'];
$search = $_REQUEST['search'];
if ($key && $search) $whereadd = "and $key LIKE '%$search%'";

if($num_step) {

	$whereadd2 = " and num_step = '$num_step' ";

}


if(!$mcode) {


$sql = "
   select 

   num_step, str_name, 
   str_organ
 
 from tab_organ_order 

 order by num_step desc 
 
";

//echo$sql;
$row22 = $DB -> sqlFetchAll($sql);
$tpl->assign(array('LIST_select'=>$row22));


if($whereadd2) {
	



$sql = "
              select 

   num_step, str_end_date, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date, 
   str_home_type, str_design, str_opt1, 
   str_opt2, str_opt3, str_name, 
   str_organ, str_zip, str_addr1, 
   str_addr2, str_tel, str_handtel, 
   str_email, str_memo,str_st,
   str_update_date,
   str_order_set,str_pot,
   num_price, num_order_price,
   num_order_price - num_price as total_price
 
 from tab_organ_order 
 where num_step > 0 
 $whereadd  $whereadd2

 order by num_step desc 
 
";

//echo$sql;
$row = $DB -> sqlFetchAll($sql);












	//	echo "있다";
	$FH = &WebApp::singleton('FileHost','main','ogran_data');
	$files = $FH->get_files_info($row[0][num_step]);
	$total_size = array_pop($files);
	$tpl->assign("FILE_LIST",&$files);







$tpl->assign(array('LIST_organ_setup'=>$row));
$num_s = $row[0][num_step];

$tpl->assign(array('num_step'=> $num_s));

if($row[0][str_home_type] != "B-MART") {
$sql = "select num_oid, str_organ, str_host from tab_organ where str_num_step = '$num_s' ";
$row44 = $DB -> sqlFetchAll($sql);
$tpl->assign(array('ORGAN_inf'=>$row44));	


$sql = "select  
			/*+ INDEX_DESC (TAB_BOARD IDX_TAB_BOARD_MCODE) */
			num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass, str_hak,
			str_title, str_email, num_hit, num_file, num_comment, num_input_pass, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date, str_thumb from tab_board where num_oid = '".$row44[0][num_oid]."'  and num_mcode >= '900000' ";
//echo $sql;
$row = $DB -> sqlFetchAll($sql);
for($ii=0; $ii<count($row); $ii++) {
$row[$ii]['is_recent'] = date('U') - strtotime($row[$ii]['dt_date']) < 241920;
}

$tpl->assign(array('LIST_bbs'=>$row));

}else{

$sql = "select num_oid, str_branch_title, str_dir from bookmart.tab_organ where str_num_step = '$num_s' ";
$row44 = $DB -> sqlFetchAll($sql);
$tpl->assign(array('ORGAN_inf'=>$row44));
}









}
}

if($mcode) {
	


$sql = "select a.* from (
         select ROWNUM as RNUM, b.* from (
              select 

   num_step, str_end_date, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date, 
   str_home_type, str_design, str_opt1, 
   str_opt2, str_opt3, str_name, 
   str_organ, str_zip, str_addr1, 
   str_addr2, str_tel, str_handtel, 
   str_email, str_memo,str_st
 
 from tab_organ_order where 
 num_step > 0 and num_v = '1' $whereadd 

 order by num_step desc 
 
 )b)a
                where a.RNUM >= $seek and a.RNUM <= $offset ";

}else{


$sql = "select a.* from (
         select ROWNUM as RNUM, b.* from (
              select 

   num_step, str_end_date, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date, 
   str_home_type, str_design, str_opt1, 
   str_opt2, str_opt3, str_name, 
   str_organ, str_zip, str_addr1, 
   str_addr2, str_tel, str_handtel, 
   str_email, str_memo,str_st
 
 from tab_organ_order where 
 num_step > 0  $whereadd 

 order by num_step desc 
 
 )b)a
                where a.RNUM >= $seek and a.RNUM <= $offset ";

}

$row = $DB -> sqlFetchAll($sql);


for($ii=0; $ii<count($row); $ii++) {
	                             	
	$row[$ii][str_name2] = substr($row[$ii][str_name],0,4)."*";
}


$tpl->assign(array('LIST_organ'=>$row));





$sql = "select   
sum(num_price) num_price, 
sum(num_order_price) num_order_price
from tab_organ_order ";
$pay = $DB -> sqlFetch($sql);

$total_par = $pay[num_price] - $pay[num_order_price];

$tpl->assign(array('num_price'=>number_format($pay[num_price]),
							'num_order_price'=>number_format($pay[num_order_price]),
							'total_price'=>number_format($total_par) ,	
							));
   

$tpl->assign(array(


	'mcode'=>$mcode,
	'listnum'=>$listnum,
	'total'=>$total,
	'page'=>$page,
    'key'=>$key,
    'search'=>$search
));

if(!$mcode) {
	$tpl->setLayout('in');
	$tpl->define("CONTENT", "html/manage/order_list_setup.htm");	
}else{
	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", "html/manage/order_list.htm");
}	
	




	 break;
	case "POST":
	 
	
	
	if(!$mode) {
		
	
	
				// {{{ 업로드 파일 처리
			$num_file = ($upfiles = trim($_POST['upfiles'])) ? count(explode("\n",$upfiles)) : 0;
			if ($num_file) {
				$FH->upload_process($_POST['timestamp'],$id);
				$FH->rm_tmp_dir($_POST['timestamp']);
			}
			$FH->find_upload($content);
			if($FH->thumb_target && $FH->thumb_target != $_POST['str_thumb']) {
				if($_POST['str_thumb']) $FH->del_thumb($_POST['str_thumb']);
				if($conf['use_thumb']) {
					$sql = "UPDATE ".TAB_MAIN_BOARD." SET STR_THUMB='".$FH->thumb_target."'
							WHERE NUM_OID=$_OID AND STR_CODE='new.$code' AND NUM_SERIAL=$id";
					$DB->query($sql);
					$DB->commit();
				}
			}
			$FH->rm_tmp_dir();
			$FH->close();
			// }}}

			// 캐쉬삭제
			$FTP = &WebApp::singleton("FtpClient",WebApp::getConf("account"));
			$FTP->delete(_DOC_ROOT.'/'.$cache_file);
			$FTP->delete(_DOC_ROOT.'/'.$cache_file2);
			$FTP->close();
	
	
	echo "<script>history.go(-1); </script>";
	exit;

}else{ 



include 'upload.inc';





if($pupfile) {
$file = new FileUpload("pupfile"); // datafile은 form에서의 이름 
$file->Path = "./data/poto/";  // 마지막에 /꼭 붙여야함
//$file->file_mkdir(); 
if(!$file->Ext("gif"))  {
echo '<script>alert("gif 파일만 가능합니다.");   history.go(-1); </script>';
exit;
 }
$file->file_rename($num_step); 
if(!$file->upload()){
echo '<script>alert("업로드에 실패 했습니다.");   history.go(-1); </script>';
exit;
}
$file->upload();
$file->Resize_Image("300","254","./data/poto/"); // 이미지일때 가로 세로 사이즈로 컨버팅


}

echo '<script>alert("저장하였습니다.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/manage.order_list?num_step=$num_step'\">";




}

	break;
	}


?>