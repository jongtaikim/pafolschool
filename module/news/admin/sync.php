<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$curl = &WebApp::singleton('Curl');
$FH = &WebApp::singleton('FileHost','main','news.'.$code);
$id = $_REQUEST['id'];
$flg = $_REQUEST['flg'];
$del=$_REQUEST['del'];


for($ii=1; $ii<11; $ii++) {
	$curl->url="http://www.ecosian.com/app/html/customer/cu_newsletterTemp_page".$ii."_l.jsp";
	$res = $curl->curl_login();
	$res = $curl->cut3("<span><strong>뉴스레터로 1개월 2회 제공</strong></span>합니다.</td>",'<td height="2" valign="top" bgcolor="c7def5"></td>',$res);
	$res = strip_tags($res,"<A><TD>");
	$res = explode("발행일</td>",$res);
	$res = $res[1];

	$res_array[$ii] = explode('<td height="1" colspan="5" bgcolor="dedede"></td>',$res);
	
	
		for($i=0; $i<count($res_array[$ii]); $i++) {
			$data[$i][num_oid] = _OID;
			$data[$i][str_code] = "news";
			$datas[$i][links] = "http://www.ecosian.com".$curl->cut3("window.open('","','pop1'",$res_array[$ii][$i]);

			$data[$i][num_serial] = $curl->cut3('class="board_num01">','</td>',$res_array[$ii][$i]);
			$data[$i][str_title] = $curl->cut3(')">','</a>',$res_array[$ii][$i]);
			$data[$i][dt_date] = $curl->cut3('class="board_num01">','</td>',$res_array[$ii][$i],2);
			$data[$i][dt_date] = WebApp::mkday($data[$i][dt_date]);
			$data[$i][num_hit] = 0;
			
			$curl->url= $datas[$i][links];
			$data[$i][str_text] = $curl->curl_login();
			$data[$i][str_text] = $curl->cut3("<!-- 컨텐츠 start -->","<!-- 컨텐츠 end -->",$data[$i][str_text]);
			//$data[$i][str_text] = WebApp::ImgChaneDe($data[$i][str_text], $data[$i][num_serial]);

			$data[$i][str_text] = addslashes($data[$i][str_text]);
			
			if($data[$i][str_title]){
				$DB->insertQuery("TAB_MAIN_BOARD",$data[$i]);
				$DB->commit();
			}

		}
		



	
}








?>