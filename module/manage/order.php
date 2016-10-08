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
switch ($REQUEST_METHOD) {
	case "GET":
	$DOC_TITLE = "str:신청하기";	


	$tpl->setLayout();
	$tpl->define("CONTENT", "module/manage/order.htm");
	
	 break;
	case "POST":



		

$max_step = $DB -> sqlFetchOne("select max(num_step) + 1 from tab_organ_order ");
if(!$max_step) $max_step = 1;

$str_tel = $str_tel1."-".$str_tel2."-".$str_tel3;
$str_handtel = $str_handtel1."-".$str_handtel2."-".$str_handtel3;

if(!$str_home_type)  $str_home_type = "SCHOOL";

		$sql = "INSERT INTO ".TAB_ORGAN_ORDER." (
				   NUM_STEP, 
				   STR_END_DATE, 
				   DT_DATE, 
				   STR_HOME_TYPE, 
				   STR_DESIGN, 
				   
				   STR_OPT1, 
				   STR_OPT2, 
				   STR_OPT3, 
				   STR_NAME, 
				   STR_ORGAN, 
				   STR_ZIP, 
				   STR_ADDR1, 
				   STR_ADDR2, 
				   STR_TEL, 
				   STR_HANDTEL, 
				   STR_EMAIL, 
				   STR_MEMO

							) VALUES (
							
					'$max_step',
					'$str_end_date',
					SYSDATE,
					'$str_home_type',
					'$str_design',

					'$str_opt1',
					'$str_opt2',
					'$str_opt3',
					'$str_name',
					'$str_organ',
					'$chr_zip',
					'$str_addr1',
					'$str_addr2',
					'$str_tel',
					'$str_handtel',
					'$str_email',
					'$str_memo' ) ";
		

					if($DB->query($sql)){
					
					
					
					
					
					
					$title="$str_organ 사이트 신청";
					
						$email = "now17@nate.com";
						
						$rmail = "webmaster@hkedu.co.kr";
						$name="$str_organ";
					
						$mail_header = "From: $name <$rmail>\n";
						$mail_header .= "Reply-to: $rmail\n";
						$mail_header .= "MIME-Version: 1.0\n";
						$mail_header .= "Content-Type: text/html; charset=euc-kr\n";
						$mail_header .= "X-Mailer: INNOMEDISYS Mailer\n";
					
					
						
							$cont="
										$str_organ 사이트 신청이 들어왔습니다.

										<br><br>

										<a href = 'http://hkedu.co.kr/manage.order_list?num_step=$max_step'  target='_blank'>바로가기</a>
								";
						
					
						mail($email,$title,$cont,$mail_header);
					
					
					
					$DB->commit();
						
					echo '<script>alert("정상적으로 신청되었습니다.");</script>';
					if($mocde) {
						

					echo "<meta http-equiv='Refresh' Content=\"0; URL='/manage.order_list?mcode=1412'\">";
					}else{
					echo "<meta http-equiv='Refresh' Content=\"0; URL='/manage.order_list?num_step=$max_step'\">";
					}					
					}else{
					
					echo $sql;
					exit;
					}
		
		
		
	 break;
	}
?>