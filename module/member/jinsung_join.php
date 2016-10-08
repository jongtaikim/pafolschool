<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/member/join.php
* 작성일: 2005-11-25
* 작성자: 이범민
* 설  명: 회원가입
* 커스터마이징 : 서종석 (2006-02-27)
*****************************************************************
* 
*/
$DOC_TITLE = 'str:회원가입';
$DB = &WebApp::singleton('DB');

//2008-01-21 디비에 저장된 사이트 타입지정
$DB = &WebApp::singleton('DB');
$_HOMETYPE = $DB -> sqlFetchOne("select STR_HOMETYPE from TAB_ORGAN where num_oid = '$_OID' ");

switch (REQUEST_METHOD) {
	case 'GET':
		


	  $MSG = WebApp_Message::fromFile('hosts/'.HOST.'/doc/agreement.claus.msg');
			

		$mem_types = WebApp::get('member',array('key'=>'member_types'));

		
		
		unset($mem_types['n']);
		for( $i=0; list($k,$v) = each( $mem_types ); $i++){
			$row[$i]['call'] = $k;
			$row[$i]['name'] = $v;
		}
		
		$sql = "SELECT num_fcode,str_fname_full FROM ".TAB_CLASS_FORMATION." WHERE num_oid=$_OID AND num_fcode > 99";
		$fmt = $DB -> sqlFetchAll($sql);

		$tpl->setLayout('@sub');
		

		$tpl->define('CONTENT','/html/member/jinsung_join.htm');




		$tpl->assign(array(
			'LIST' => $row,
			'FMT' => $fmt,
			'claus_content'	=> nl2br($MSG->__toString())
		));
		break;
	case 'POST':
		

	
	
	
	$LC = &WebApp::singleton('LunaCal');

		switch($_POST['mode']) {
			// 약관동의
			case 'check':
				$tpl->setLayout('@sub2');
				$tpl->define('CONTENT',Display::getTemplate('member/join2.htm'));
				break;
			// 가입
			case 'join':

				$str_id			= $_POST['str_id'];
				$str_passwd		= $_POST['str_passwd'];
				
				$str_phone			= $_POST['str_phone'];
				$str_handphone		= $_POST['str_handphone'];
								


				$str_name		= $_POST['str_name'];
				$chr_mtype		= $_POST['chr_mtype'];
				$num_fcode		= $_POST['num_fcode'] ? $_POST['num_fcode'] : "''";
				$str_zipcode	= $_POST['chr_zip'];
				$str_addr1		= $_POST['str_addr1'];
				$str_addr2		= $_POST['str_addr2'];
				$str_email		= $_POST['str_email'];
				$num_birth		= $_POST['dt_birth1'].$_POST['dt_birth2'].$_POST['dt_birth3'];
				$chr_birth		= $_POST['str_birthtype'];
				$sun_birth		= $LC->lun2sol($_POST['dt_birth1'], $_POST['dt_birth2'], $_POST['dt_birth3'], 0);
				$birthday		= (!strcasecmp($chr_birth,"s")) ? $num_birth : sprintf('%04u%02u%02u',$sun_birth['year'],$sun_birth['month'],$sun_birth['day']);
				$str_intro		= ($_POST['str_introduct']) ? $_POST['str_introduct'] : "자신을 소개해 주세요!!" ;
				$user_ip		= getenv("REMOTE_ADDR");
        $birthday = $birthday=="" ? "''": $birthday;
        $num_birth = $num_birth=="" ? "''": $num_birth;


			
							$sql =	"
				INSERT INTO TAB_MEMBER 

						(num_oid, str_name, str_id, str_passwd, chr_mtype, num_fcode, str_email, chr_zip, str_addr1, 
						str_addr2, num_birthday, chr_birthday, num_happyday, str_introduct, str_ip,str_icon,num_auth)

				VALUES 
					($_OID,'$str_name','$str_id','$str_passwd','$chr_mtype',$num_fcode,'$str_email','$str_zipcode',
					'$str_addr1','$str_addr2',$num_birth,'$chr_birth',$birthday,'$str_intro','$user_ip','$str_icon','1')
				";
			


				if(!$DB->query($sql)) joinErr();
				$DB->commit();


                echo "<script type='text/javascript'>document.cookie = 'NAME=".$str_name."';</script>";

				WebApp::redirect('','가입되었습니다.');
				break;
		}
		break;
}

function joinErr() {
	WebApp::redirect('member.jinsung_join','가입처리중 오류가 발생했습니다. 관리자에게 문의해주시기 바랍니다.');
}
?>