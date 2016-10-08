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
$FH = &WebApp::singleton('FileHost','menu',$mcode);

$DB->deleteQuery("TAB_BOARD"," num_oid = '"._OID."' and num_mcode = $mcode ");
$DB->commit();

for($ii=2; $ii<244; $ii++) {
	$ia = $ii+1;

			$data[$i][num_oid] = _OID;
			$data[$i][num_mcode] = $mcode;
			$urls = "http://www.ecosian.com/app/bbs/notice/notice.ds?commonCmd=view&writeNo=".$ii;
			$curl->url= $urls;
			$res = $curl->curl_login();
			
			$data[$i][str_title] = trim($curl->cut3('<td class="text_p_notic_03">','</td>',$res));
			
			
			$datas[$i][str_title] = explode("</span>",$data[$i][str_title]);

			$data[$i][str_category] = strip_tags($datas[$i][str_title][0]);
			$data[$i][str_category] = explode("\n",$data[$i][str_category]);
			$data[$i][str_category] = $data[$i][str_category][4];
			$data[$i][str_category] = str_replace('[','',$data[$i][str_category]);
			$data[$i][str_category] = trim(str_replace(']','',$data[$i][str_category]));

			$data[$i][str_title] = strip_tags(trim($datas[$i][str_title][1]));
			$data[$i][num_serial] = $ia;
			$data[$i][num_group] = $ia;
			$data[$i][num_step] = $ia;
			$data[$i][num_depth] = 0;

			//if($data[$i][str_category] == "공지") $data[$i][num_notice] = 1; else $data[$i][num_notice] = 0;
			
			$data[$i][dt_date] = trim($curl->cut3('등록일 :','</td>',$res));
			$data[$i][dt_date] = str_replace('/','-',$data[$i][dt_date]);
			$data[$i][dt_date] = WebApp::mkday($data[$i][dt_date]);
			$data[$i][num_hit] = 0;
			$data[$i][str_user] = "ecosian";
			$data[$i][str_pass] = "lca55344";
			$data[$i][str_name] = "에코시안";
			$data[$i][str_ip] = "1.0.0.1";

			
			
			$data[$i][str_text] = nl2br(strip_tags($curl->cut3('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_p_notic_05">','</table>',$res)));

			
	
	
			$data[$i][str_text] = addslashes($data[$i][str_text]);
			
			if($data[$i][str_title]){
				$DB->insertQuery("TAB_BOARD",$data[$i]);
				$DB->commit();
				print_r($data[$i]);
			}

}



?>