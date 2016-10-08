<?php
/***************************************************************
* 파일명: module/member/attendance.php
* 작성일: 2006.11.8
* 작성자: sangsun.Park
* 설  명:  출석체크 
******************************************************************/
//php정보 확인
//phpinfo();exit;
$Today = "20".date(y)."-".date(m)."-".date(d); //입력된 날짜가 오늘날짜인지 체크하기 위해서 오늘날짜 생성

switch (REQUEST_METHOD) {
	case 'POST':
		/************************************************************
		넘어온 변수값 정보
		_REQUEST["USERID"] 아이디
		_REQUEST["NAME"] 이름
		_POST["dt_date"] 날짜: 2006-11-13 형식
		_POST["subtarget"]  구분변수값 (조회경우 attendance넘어옴) 
		_POST["hak_search"] 1학년 3반 (학년반 변수값)
		_POST["ban"] 2 
		_POST["num_oid"] 20056 학교코드번호
		_POST["num_fcode"] 1012  반코드
		************************************************************/
        $DOC_TITLE = 'str:출결관리';
		$tpl->setLayout('@sub');

		$DB = &WebApp::singleton('DB');

		//선생님의 기본정보를 가져오기 
		$sql = "SELECT str_id,str_name,chr_mtype,num_fcode,num_auth, num_oid FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_id='".$USERID."' AND chr_mtype='t'";

		$data = $DB->sqlFetch($sql);

		$Str_name = $data['str_name'];				//이름
		$Str_id = $data['str_id']; //아이디
		$Chr_mtype = $data['chr_mtype'];			//선생,학생 키값: 선생:t 학생:s
		$Num_fcode = $data['num_fcode'];			//반코드
		$Num_oid = $data['num_oid'];
		$dt_date = $_POST["dt_date"];

		//반정보 가져오기
		$sql2 ="select str_fname_full, str_fname from tab_class_formation where num_oid=$Num_oid and num_fcode=$Num_fcode";
		
		$data2 = $DB->sqlFetch($sql2);

		$Str_fname_full = $data2['str_fname_full'];				//반
		$Str_fname = $data2['str_fname'];


		//오늘 어제 총원 가져옴
		$sql_u = "SELECT num_aa FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND str_type1='".$Num_fcode."' AND num_date like '".$dt_date."' ORDER BY num_date DESC";
		
		$data_u = $DB->sqlFetch($sql_u);

		$confirm = $data_u['num_aa']; // 이값이 없으면 새로 출결셋팅해야 하는 날짜

		if($confirm == "" && $Subtarget != "insert")
		{	

			//입력된 적이 있는지.. 없으면 최근 update한 날짜의 재적수를 가져온다. 나머지는 0으로
			$sql_pre = "SELECT num_aa, num_ab, num_ba, num_bb, num_ca, num_cb, num_da, num_db, num_ea, num_eb FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND str_type1='".$Num_fcode."' ORDER BY num_date DESC";
			
			$data_pre = $DB->sqlFetch($sql_pre);
		
			$total_boy_data_pre = $data_pre['num_aa'];
			$total_girl_data_pre = $data_pre['num_ab'];  //총원

			$num_ba = "0";
			$num_bb = "0";
			$num_ca = "0";
			$num_cb = "0";
			$num_da = "0";
			$num_db = "0";
			$num_ea = "0";
			$num_eb = "0";

			//템플릿에 넘겨줄 변수 셋팅, 재적, 날짜, 결석, 조퇴값 등등.........
			$tpl->define('CONTENT', Display::getTemplate('member/attendance.htm'));
			$tpl->assign(array(
				'redir'		=>	$_REQUEST['redir'],
				'num_aa' => "$total_boy_data_pre",
				'num_ab' => "$total_girl_data_pre",
				'num_ba' => "$num_ba",
				'num_bb' => "$num_bb",
				'num_ca' => "$num_ca",
				'num_cb' => "$num_cb",
				'num_da' => "$num_da",
				'num_db' => "$num_db",
				'num_ea' => "$num_ea",
				'num_eb' => "$num_eb",
				'str_name' => "$Str_name",
				'str_fname_full' => "$Str_fname_full",
				'num_date' => "$dt_date"
			));
			break;
			
		}

			// 해당 날짜 검색 출결상황 데이타 가져옴//////////////////////////////////////////////////////////////////////////////////////////
			if ($Subtarget == "search" && $confirm != "")
			{
				$sql3 = "SELECT num_aa, num_ab, num_ba, num_bb, num_ca, num_cb, num_da, num_db, num_ea, num_eb FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND num_date like '".$dt_date."' AND str_type1='".$Num_fcode."'";
				
				$select_data2 = $DB->sqlFetch($sql3);
				$total_boy = $select_data2['num_aa'];
				$total_girl = $select_data2['num_ab'];  //총원
				$num_ba = $select_data2['num_ba'];
				$num_bb = $select_data2['num_bb']; //결석
				$num_ca = $select_data2['num_ca'];
				$num_cb = $select_data2['num_cb']; //조퇴
				$num_da = $select_data2['num_da'];
				$num_db = $select_data2['num_db']; //전입
				$total_man = $select_data2['num_ea'];
				$total_man = $select_data2['num_eb'];
			}
		// 해당 날짜 검색 출결상황 데이타 가져옴 끝////////////////////////////////////////////////////////////////////////////////////////


		//출결상황 DB 인서트//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		if ($Subtarget == "insert") 
		{
			$sql3_1 = "SELECT num_aa, num_ab, num_ba, num_bb, num_ca, num_cb, num_da, num_db, num_ea, num_eb FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND num_date like '".$dt_date."' AND str_type1='".$Num_fcode."'";
			
			$select_data3 = $DB->sqlFetch($sql3_1);
			$total_boy_select_data3 =		$select_data3['num_aa'];
			$total_gir_select_data3l =		$select_data3['num_ab'];  //총원
			$num_ba_select_data3 =		$select_data3['num_ba'];
			$num_bb_select_data3 =		$select_data3['num_bb']; //결석
			$num_ca_select_data3 =		$select_data3['num_ca'];
			$num_cb_select_data3 =		$select_data3['num_cb']; //조퇴
			$num_da_select_data3 =		$select_data3['num_da'];
			$num_db_select_data3 =		$select_data3['num_db']; //전입
			$total_man_select_data3 =	$select_data3['num_ea'];
			$total_man_select_data3 =	$select_data3['num_eb'];

			//오늘 처음인지 중복인지 검사한다. 
			$sql_pre_select1 = "SELECT num_date, num_oid, str_id, str_type1 FROM ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND num_date like '".$dt_date."'";

			$select_data1 = $DB->sqlFetch($sql_pre_select1);
			$select_date = $select_data1['num_date'];
			$select_oid = $select_data1['num_oid'];
			$select_id = $select_data1['str_id'];
			$select_class = $select_data1['str_type1'];

			//값들이 일치하지 않으면 중복이므로 기존 값에 업데이트 시킨다
			if ($select_date == $dt_date & $select_oid == $Num_oid & $Num_fcode == $select_class)
			{
				$str_id = $USERID;
				$str_name = $NAME;
				$str_grade_sub1 = substr($Str_fname_full, 0,1);
				$str_class_sub1 = substr($Str_fname, 0,1);
					if ($str_class_sub1 == "1"){
						$str_class = "a";
					}else if ($str_class_sub2 == "2"){
						$str_class = "b";
					}else if ($str_class_sub2 == "3"){
						$str_class = "b";
					}else if ($str_class_sub2 == "4"){
						$str_class = "b";
					}else if ($str_class_sub2 == "5"){
						$str_class = "b";
					}else if ($str_class_sub2 == "6"){
						$str_class = "b";
					}else if ($str_class_sub2 == "7"){
						$str_class = "b";
					}else if ($str_class_sub2 == "8"){
						$str_class = "b";
					}else if($str_class_sub2 == "9"){
						$str_class = "b";
					}
				$ban_code = $Num_fcode;
				$num_aa = $mjejuk;  //남 재적
				$num_ab = $wjejuk;   // 여 재적
				$num_total = $num_aa+$num_ab;
				$num_ba = $mgyulsuk; //남 결석
				$num_bb = $wgyulsuk; //여 결석
				$num_ca = $mjotoi; //남 조퇴
				$num_cb = $wjotoi; //여 조퇴
				$num_da = $mjunip; //남 전입
				$num_db = $wjunip; //여 전입
				$num_ea = $mjunchul; //남 전출
				$num_eb = $mjunchul; //여 전출
				$num_oid = $Num_oid; // 학교번호
				$num_fcode = $Num_fcode; //반코드

				if ($dt_date == "")
							{
								echo "
								<script>
								alert('날짜를 입력하세요');
								history.go(-1);
								</script>
								";
							}
			
				$sql4_update = "UPDATE TAB_ATTENDANCE SET
								num_oid='$num_oid', str_grade='$str_grade_sub1', str_class='$str_class_sub1', num_total=$num_total, num_aa=$num_aa, num_ab=$num_ab, num_ba=$num_ba, num_bb=$num_bb, num_ca=$num_ca, num_cb=$num_cb, num_da=$num_da, num_db=$num_db, num_ea=$num_ea, num_eb=$num_eb, str_name='$str_name', str_id='$str_id', str_type1='$num_fcode' WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND str_type1='".$Num_fcode."' AND num_date like '".$dt_date."'";

				$DB->query($sql4_update);

				$DB->commit();

				$_url = "member.attendance?Subtarget=complet&set_date=".$dt_date;
				$redir_url = $redir.$_url;
				echo "
						<script>
						alert('출결이 수정 되었습니다.');
						</script>
						";
				WebApp::redirect($redir_url);
	
			}else{

					//인서트 변수값 셋팅
					$str_id = $USERID;
					$str_name = $NAME;
					$str_grade_sub1 = substr($Str_fname_full, 0,1);
					$str_class_sub1 = substr($Str_fname, 0,1);
						if ($str_class_sub1 == "1"){
							$str_class = "a";
						}else if ($str_class_sub2 == "2"){
							$str_class = "b";
						}else if ($str_class_sub2 == "3"){
							$str_class = "b";
						}else if ($str_class_sub2 == "4"){
							$str_class = "b";
						}else if ($str_class_sub2 == "5"){
							$str_class = "b";
						}else if ($str_class_sub2 == "6"){
							$str_class = "b";
						}else if ($str_class_sub2 == "7"){
							$str_class = "b";
						}else if ($str_class_sub2 == "8"){
							$str_class = "b";
						}else if($str_class_sub2 == "9"){
							$str_class = "b";
						}
					$ban_code = $Num_fcode;

					$num_aa = $mjejuk;  //남 재적
					$num_ab = $wjejuk;   // 여 재적
					$num_total = $num_aa+$num_ab;
					$num_ba = $mgyulsuk; //남 결석
					$num_bb = $wgyulsuk; //여 결석
					$num_ca = $mjotoi; //남 조퇴
					$num_cb = $wjotoi; //여 조퇴
					$num_da = $mjunip; //남 전입
					$num_db = $wjunip; //여 전입
					$num_ea = $mjunchul; //남 전출
					$num_eb = $mjunchul; //여 전출
					$num_oid = $Num_oid; // 학교번호
					$num_fcode = $Num_fcode; //반코드

					if ($dt_date == "")
					{
						echo "
						<script>
						alert('날짜를 입력하세요');
						history.go(-1);
						</script>
						";
					}
					
					$sql4 = "INSERT INTO TAB_ATTENDANCE 
								(num_date, num_oid, str_grade, str_class, num_total, num_aa, num_ab, num_ba, num_bb, num_ca, num_cb, num_da, num_db, num_ea, num_eb, str_name, str_id, str_type1)
								VALUES 
								('$dt_date','$num_oid','$str_grade_sub1','$str_class_sub1',$num_total,$num_aa,$num_ab,$num_ba,$num_bb,$num_ca,$num_cb,$num_da,$num_db,$num_ea,$num_eb,'$str_name','$str_id','$num_fcode')
								";
					$DB->query($sql4);

					$DB->commit();

					$_url = "member.attendance?Subtarget=complet&set_date=".$dt_date;
					$redir_url = $redir.$_url;
					 echo "
						<script>
						alert('출결이 셋팅되었습니다.');
						</script>
						";
						WebApp::redirect($redir_url);

			}
					
		}
		//출결상황 DB 인서트 끝///////////////////////////////////////////////////////////////////////////////////////////////////////////

		$tpl->define('CONTENT', Display::getTemplate('member/attendance.htm'));
		$tpl->assign(array(
			'redir'		=>	$_REQUEST['redir']
		));
		$tpl->assign($data); //템플릿에 변수값 넘겨줌
		$tpl->assign($data2); //
		$tpl->assign($_POST); //넘어온 값 
		$tpl->assign($select_data2); //출결값 가져와
		$tpl->assign($select_data3); //인서트 후 그날짜 출결값 가져옴
		$tpl->assign($data_pre);

		break;

	case 'GET':
		$DB = &WebApp::singleton('DB');

		//인서트, 업데이트 완료후 셋팅된 값 가져오기
		if ($Subtarget == "complet")
		{
			$dt_date = $set_date;
			
			$sql_view = "SELECT str_id,str_name,chr_mtype,num_fcode,num_auth, num_oid FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_id='".$USERID."' AND chr_mtype='t'";

			$data_view = $DB->sqlFetch($sql_view);

			$Str_name = $data_view['str_name'];				//이름
			$Str_id = $data_view['str_id']; //아이디
			$Chr_mtype = $data_view['chr_mtype'];			//선생,학생 키값: 선생:t 학생:s
			$Num_fcode = $data_view['num_fcode'];			//반코드
			$Num_oid = $data_view['num_oid'];
	
			$sql3_view = "SELECT num_date, num_aa, num_ab, num_ba, num_bb, num_ca, num_cb, num_da, num_db, num_ea, num_eb FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND num_date like '".$dt_date."' AND str_type1='".$Num_fcode."'";
			
			$select_data2_view = $DB->sqlFetch($sql3_view);
			$total_boy = $select_data2_view['num_aa'];
			$total_girl = $select_data2_view['num_ab'];  //총원
			$num_ba = $select_data2_view['num_ba'];
			$num_bb = $select_data2_view['num_bb']; //결석
			$num_ca = $select_data2_view['num_ca'];
			$num_cb = $select_data2_view['num_cb']; //조퇴
			$num_da = $select_data2_view['num_da'];
			$num_db = $select_data2_view['num_db']; //전입
			$total_man = $select_data2_view['num_ea'];
			$total_man = $select_data2_view['num_eb'];
			$dt_date = $select_data2_view['num_date'];

			$sql2_view ="select str_fname_full from tab_class_formation where num_oid=$Num_oid and num_fcode=$Num_fcode";
		
			$data2_view = $DB->sqlFetch($sql2_view);

			$Str_fname_full = $data2_view['str_fname_full'];	

		}else{

			if($dt_date == "") //날짜값이 없다면
			{
				$sql0 = "SELECT str_id,str_name,chr_mtype,num_fcode,num_auth, num_oid FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_id='".$USERID."' AND chr_mtype='t'";

				$data0 = $DB->sqlFetch($sql0);

				$Str_name = $data0['str_name'];				//이름
				$Str_id = $data0['str_id']; //아이디
				$Chr_mtype = $data0['chr_mtype'];			//선생,학생 키값: 선생:t 학생:s
				$Num_fcode = $data0['num_fcode'];			//반코드
				$Num_oid = $data0['num_oid'];

				$sql00 = "SELECT num_date FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND str_type1='".$Num_fcode."' ORDER BY num_date DESC";
				
				$data_sql00 = $DB->sqlFetch($sql00);
				$check_today = $data_sql00['num_date'];

				if ($check_today == $Today)
				{
					$sql_pre = "SELECT num_aa, num_ab, num_ba, num_bb, num_ca, num_cb, num_da, num_db, num_ea, num_eb FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND str_type1='".$Num_fcode."' ORDER BY num_date DESC";
							
					$data_pre = $DB->sqlFetch($sql_pre);
				

					$total_boy_data_pre = $data_pre['num_aa'];
					$total_girl_data_pre = $data_pre['num_ab'];  //총원
				}else if($check_today != $Today)
				{
					$sql_pre = "SELECT num_aa, num_ab FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND str_type1='".$Num_fcode."' ORDER BY num_date DESC";
							
					$data_pre = $DB->sqlFetch($sql_pre);
				

					$total_boy_data_pre = $data_pre['num_aa'];
					$total_girl_data_pre = $data_pre['num_ab'];  //총원

					$num_ba = "0";
					$num_bb = "0";
					$num_ca = "0";
					$num_cb = "0";
					$num_da = "0";
					$num_db = "0";
					$num_ea = "0";
					$num_eb = "0";
				}

				//템플릿에 넘겨줄 변수 셋팅, 재적, 날짜, 결석, 조퇴값 등등.........
				$tpl->define('CONTENT', Display::getTemplate('member/attendance.htm'));
				$tpl->assign(array(
					'redir'		=>	$_REQUEST['redir'],
					'num_aa' => "$total_boy_data_pre",
					'num_ab' => "$total_girl_data_pre",
					'num_ba' => "$num_ba",
					'num_bb' => "$num_bb",
					'num_ca' => "$num_ca",
					'num_cb' => "$num_cb",
					'num_da' => "$num_da",
					'num_db' => "$num_db",
					'num_ea' => "$num_ea",
					'num_eb' => "$num_eb",
					'str_name' => "$Str_name",
					'str_fname_full' => "$Str_fname_full",
					'num_date' => "$Today"
				));
				//break;
			}

			//인서트, 업데이트가 아니면 
			$sql = "SELECT str_id,str_name,chr_mtype,num_fcode,num_auth, num_oid FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_id='".$USERID."' AND chr_mtype='t'";

			$data = $DB->sqlFetch($sql);

			$Str_name = $data['str_name'];				//이름
			$Str_id = $data['str_id']; //아이디
			$Chr_mtype = $data['chr_mtype'];			//선생,학생 키값: 선생:t 학생:s
			$Num_fcode = $data['num_fcode'];			//반코드
			$Num_oid = $data['num_oid'];

			if ($Str_name == "")									// 선생님인지 체크
			{
				 echo "
					<script>
					alert('선생님만의 공간입니다.');
					history.go(-1);
					</script>
					";
			}
			$sql2 ="select str_fname_full from tab_class_formation where num_oid=$Num_oid and num_fcode=$Num_fcode";
		
			$data2 = $DB->sqlFetch($sql2);

			$Str_fname_full = $data2['str_fname_full'];				//반
		
		}
			
		$DOC_TITLE = 'str:출결관리';
		$tpl->setLayout('@sub');
		$tpl->define('CONTENT', Display::getTemplate('member/attendance.htm'));
        $tpl->assign($data);
		$tpl->assign($data_view);
		$tpl->assign($data2);
		$tpl->assign($select_data2); //출결값 가져와
		$tpl->assign($select_data2_view);
		$tpl->assign($data_pre);
		$tpl->assign($data2_view);
		$tpl->assign($num_ba);
		$tpl->assign($num_bb);
		$tpl->assign($num_ca);
		$tpl->assign($num_cb);
		$tpl->assign($num_da);
		$tpl->assign($num_db);
		$tpl->assign($num_ea);
		$tpl->assign($num_eb);
		$tpl->assign(array(
			'redir'		=>	$_REQUEST['redir']
		));
		break;
		exit;
}

?>