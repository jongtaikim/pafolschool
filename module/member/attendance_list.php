<?php
/***************************************************************
* 파일명: module/member/attendance.php
* 작성일: 2006.11.8
* 작성자: 
* 설  명:  출석체크 
******************************************************************/
//php정보 확인
//phpinfo();exit;

//echo "dt_date:$dt_date";
$num_date = "20".date(y)."-".date(m)."-".date(d); //입력된 날짜가 오늘날짜인지 체크하기 위해서 오늘날짜 생성

switch (REQUEST_METHOD) {
	case 'POST':
		$DB = &WebApp::singleton('DB');
		//$dt_date; //검색날짜
		
		//학년 변수셋팅
		$STR_GRADE1 = "1";
		$STR_GRADE2 = "2";
		$STR_GRADE3 = "3";
		$STR_GRADE4 = "4";
		$STR_GRADE5 = "5";
		$STR_GRADE6 = "6";

		//반 변수셋팅
		$STR_CLASS1 = "1";
		$STR_CLASS2 = "2";
		$STR_CLASS3 = "3";
		$STR_CLASS4 = "4";
		$STR_CLASS5 = "5";
		$STR_CLASS6 = "6";
		$STR_CLASS7 = "7";
		$STR_CLASS8 = "8";
		$STR_CLASS9 = "9";
		$STR_CLASS10 = "10";
		$STR_CLASS11 = "11";
		$STR_CLASS12 = "12";
		$STR_CLASS13 = "13";
		$STR_CLASS14 = "14";
		$STR_CLASS15 = "15";
		$STR_CLASS16 = "16";
		$STR_CLASS17 = "17";
		$STR_CLASS18 = "18";


		//1학년1반
		$sql_1_1 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE1."' AND str_class='".$STR_CLASS1."'";


		//echo "sql_1_1:$sql_1_1";exit;

		$data_1_1 = $DB->sqlFetch($sql_1_1);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_1_1 = $data_1_1['num_aa'];
		$num_ab_1_1 = $data_1_1['num_ab'];
		$num_ba_1_1 = $data_1_1['num_ba'];
		$num_bb_1_1 = $data_1_1['num_bb'];
		$num_ca_1_1 = $data_1_1['num_ca'];
		$num_cb_1_1 = $data_1_1['num_cb'];
		$num_da_1_1 = $data_1_1['num_da'];
		$num_db_1_1 = $data_1_1['num_db'];
		$num_ea_1_1 = $data_1_1['num_ea'];
		$num_eb_1_1 = $data_1_1['num_eb'];

		if ($num_aa_1_1 == "")
		{
			$num_aa_1_1 = "-";
		}
		if ($num_ab_1_1 == "")
		{
			$num_ab_1_1 = "-";
		}
		if ($num_ba_1_1 == "")
		{
			$num_ba_1_1 = "-";
		}
		if ($num_bb_1_1 == "")
		{
			$num_bb_1_1 = "-";
		}
		if ($num_ca_1_1 == "")
		{
			$num_ca_1_1 = "-";
		}
		if ($num_cb_1_1 == "")
		{
			$num_cb_1_1 = "-";
		}
		if ($num_da_1_1 == "")
		{
			$num_da_1_1 = "-";
		}
		if ($num_db_1_1 == "")
		{
			$num_db_1_1 = "-";
		}
		if ($num_ea_1_1 == "")
		{
			$num_ea_1_1 = "-";
		}
		if ($num_eb_1_1 == "")
		{
			$num_eb_1_1 = "-";
		}


	
		/*
		echo "num_aa_1_1:$num_aa_1_1<br>";
		echo "num_ab_1_1:$num_ab_1_1<br>";
		echo "num_ba_1_1:$num_ba_1_1<br>";
		echo "num_bb_1_1:$num_bb_1_1<br>";
		echo "num_ca_1_1:$num_ca_1_1<br>";
		echo "num_cb_1_1:$num_cb_1_1<br>";
		echo "num_da_1_1:$num_da_1_1<br>";
		echo "num_db_1_1:$num_db_1_1<br>";
		echo "num_ea_1_1:$num_ea_1_1<br>";
		echo "num_eb_1_1:$num_eb_1_1<br>";
		*/

		//exit;

		
		//1학년2반
		$sql_1_2 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE1."' AND str_class='".$STR_CLASS2."'";


		//echo "sql_1_2:$sql_1_2";exit;

		$data_1_2 = $DB->sqlFetch($sql_1_2);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_1_2 = $data_1_2['num_aa'];
		$num_ab_1_2 = $data_1_2['num_ab'];
		$num_ba_1_2 = $data_1_2['num_ba'];
		$num_bb_1_2 = $data_1_2['num_bb'];
		$num_ca_1_2 = $data_1_2['num_ca'];
		$num_cb_1_2 = $data_1_2['num_cb'];
		$num_da_1_2 = $data_1_2['num_da'];
		$num_db_1_2 = $data_1_2['num_db'];
		$num_ea_1_2 = $data_1_2['num_ea'];
		$num_eb_1_2 = $data_1_2['num_eb'];

		if ($num_aa_1_2 == "")
		{
			$num_aa_1_2 = "-";
		}
		if ($num_ab_1_2 == "")
		{
			$num_ab_1_2 = "-";
		}
		if ($num_ba_1_2 == "")
		{
			$num_ba_1_2 = "-";
		}
		if ($num_bb_1_2 == "")
		{
			$num_bb_1_2 = "-";
		}
		if ($num_ca_1_2 == "")
		{
			$num_ca_1_2 = "-";
		}
		if ($num_cb_1_2 == "")
		{
			$num_cb_1_2 = "-";
		}
		if ($num_da_1_2 == "")
		{
			$num_da_1_2 = "-";
		}
		if ($num_db_1_2 == "")
		{
			$num_db_1_2 = "-";
		}
		if ($num_ea_1_2 == "")
		{
			$num_ea_1_2 = "-";
		}
		if ($num_eb_1_2 == "")
		{
			$num_eb_1_2 = "-";
		}

		//1학년3반
		$sql_1_3 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE1."' AND str_class='".$STR_CLASS3."'";


		//echo "sql_1:$sql_1";exit;

		$data_1_3 = $DB->sqlFetch($sql_1_3);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_1_3 = $data_1_3['num_aa'];
		$num_ab_1_3 = $data_1_3['num_ab'];
		$num_ba_1_3 = $data_1_3['num_ba'];
		$num_bb_1_3 = $data_1_3['num_bb'];
		$num_ca_1_3 = $data_1_3['num_ca'];
		$num_cb_1_3 = $data_1_3['num_cb'];
		$num_da_1_3 = $data_1_3['num_da'];
		$num_db_1_3 = $data_1_3['num_db'];
		$num_ea_1_3 = $data_1_3['num_ea'];
		$num_eb_1_3 = $data_1_3['num_eb'];

		if ($num_aa_1_3 == "")
		{
			$num_aa_1_3 = "-";
		}
		if ($num_ab_1_3 == "")
		{
			$num_ab_1_3 = "-";
		}
		if ($num_ba_1_3 == "")
		{
			$num_ba_1_3 = "-";
		}
		if ($num_bb_1_3 == "")
		{
			$num_bb_1_3 = "-";
		}
		if ($num_ca_1_3 == "")
		{
			$num_ca_1_3 = "-";
		}
		if ($num_cb_1_3 == "")
		{
			$num_cb_1_3 = "-";
		}
		if ($num_da_1_3 == "")
		{
			$num_da_1_3 = "-";
		}
		if ($num_db_1_3 == "")
		{
			$num_db_1_3 = "-";
		}
		if ($num_ea_1_3 == "")
		{
			$num_ea_1_3 = "-";
		}
		if ($num_eb_1_3 == "")
		{
			$num_eb_1_3 = "-";
		}


		//1학년4반
		$sql_1_4 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE1."' AND str_class='".$STR_CLASS4."'";


		//echo "sql_1:$sql_1";exit;

		$data_1_4 = $DB->sqlFetch($sql_1_4);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_1_4 = $data_1_4['num_aa'];
		$num_ab_1_4 = $data_1_4['num_ab'];
		$num_ba_1_4 = $data_1_4['num_ba'];
		$num_bb_1_4 = $data_1_4['num_bb'];
		$num_ca_1_4 = $data_1_4['num_ca'];
		$num_cb_1_4 = $data_1_4['num_cb'];
		$num_da_1_4 = $data_1_4['num_da'];
		$num_db_1_4 = $data_1_4['num_db'];
		$num_ea_1_4 = $data_1_4['num_ea'];
		$num_eb_1_4 = $data_1_4['num_eb'];

		if ($num_aa_1_4 == "")
		{
			$num_aa_1_4 = "-";
		}
		if ($num_ab_1_4 == "")
		{
			$num_ab_1_4 = "-";
		}
		if ($num_ba_1_4 == "")
		{
			$num_ba_1_4 = "-";
		}
		if ($num_bb_1_4 == "")
		{
			$num_bb_1_4 = "-";
		}
		if ($num_ca_1_4 == "")
		{
			$num_ca_1_4 = "-";
		}
		if ($num_cb_1_4 == "")
		{
			$num_cb_1_4 = "-";
		}
		if ($num_da_1_4 == "")
		{
			$num_da_1_4 = "-";
		}
		if ($num_db_1_4 == "")
		{
			$num_db_1_4 = "-";
		}
		if ($num_ea_1_4 == "")
		{
			$num_ea_1_4 = "-";
		}
		if ($num_eb_1_4 == "")
		{
			$num_eb_1_4 = "-";
		}

		//1학년5반
		$sql_1_5 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE1."' AND str_class='".$STR_CLASS5."'";


		//echo "sql_1:$sql_1";exit;

		$data_1_5 = $DB->sqlFetch($sql_1_5);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_1_5 = $data_1_5['num_aa'];
		$num_ab_1_5 = $data_1_5['num_ab'];
		$num_ba_1_5 = $data_1_5['num_ba'];
		$num_bb_1_5 = $data_1_5['num_bb'];
		$num_ca_1_5 = $data_1_5['num_ca'];
		$num_cb_1_5 = $data_1_5['num_cb'];
		$num_da_1_5 = $data_1_5['num_da'];
		$num_db_1_5 = $data_1_5['num_db'];
		$num_ea_1_5 = $data_1_5['num_ea'];
		$num_eb_1_5 = $data_1_5['num_eb'];

		if ($num_aa_1_5 == "")
		{
			$num_aa_1_5 = "-";
		}
		if ($num_ab_1_5 == "")
		{
			$num_ab_1_5 = "-";
		}
		if ($num_ba_1_5 == "")
		{
			$num_ba_1_5 = "-";
		}
		if ($num_bb_1_5 == "")
		{
			$num_bb_1_5 = "-";
		}
		if ($num_ca_1_5 == "")
		{
			$num_ca_1_5 = "-";
		}
		if ($num_cb_1_5 == "")
		{
			$num_cb_1_5 = "-";
		}
		if ($num_da_1_5 == "")
		{
			$num_da_1_5 = "-";
		}
		if ($num_db_1_5 == "")
		{
			$num_db_1_5 = "-";
		}
		if ($num_ea_1_5 == "")
		{
			$num_ea_1_5 = "-";
		}
		if ($num_eb_1_5 == "")
		{
			$num_eb_1_5 = "-";
		}


			//1학년6반
		$sql_1_6 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE1."' AND str_class='".$STR_CLASS6."'";


		//echo "sql_1:$sql_1";exit;

		$data_1_6 = $DB->sqlFetch($sql_1_6);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_1_6 = $data_1_6['num_aa'];
		$num_ab_1_6 = $data_1_6['num_ab'];
		$num_ba_1_6 = $data_1_6['num_ba'];
		$num_bb_1_6 = $data_1_6['num_bb'];
		$num_ca_1_6 = $data_1_6['num_ca'];
		$num_cb_1_6 = $data_1_6['num_cb'];
		$num_da_1_6 = $data_1_6['num_da'];
		$num_db_1_6 = $data_1_6['num_db'];
		$num_ea_1_6 = $data_1_6['num_ea'];
		$num_eb_1_6 = $data_1_6['num_eb'];

		if ($num_aa_1_6 == "")
		{
			$num_aa_1_6 = "-";
		}
		if ($num_ab_1_6 == "")
		{
			$num_ab_1_6 = "-";
		}
		if ($num_ba_1_6 == "")
		{
			$num_ba_1_6 = "-";
		}
		if ($num_bb_1_6 == "")
		{
			$num_bb_1_6 = "-";
		}
		if ($num_ca_1_6 == "")
		{
			$num_ca_1_6 = "-";
		}
		if ($num_cb_1_6 == "")
		{
			$num_cb_1_6 = "-";
		}
		if ($num_da_1_6 == "")
		{
			$num_da_1_6 = "-";
		}
		if ($num_db_1_6 == "")
		{
			$num_db_1_6 = "-";
		}
		if ($num_ea_1_6 == "")
		{
			$num_ea_1_6 = "-";
		}
		if ($num_eb_1_6 == "")
		{
			$num_eb_1_6 = "-";
		}


		//1학년7반
		$sql_1_7 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE1."' AND str_class='".$STR_CLASS7."'";


		//echo "sql_1:$sql_1";exit;

		$data_1_7 = $DB->sqlFetch($sql_1_7);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_1_7 = $data_1_7['num_aa'];
		$num_ab_1_7 = $data_1_7['num_ab'];
		$num_ba_1_7 = $data_1_7['num_ba'];
		$num_bb_1_7 = $data_1_7['num_bb'];
		$num_ca_1_7 = $data_1_7['num_ca'];
		$num_cb_1_7 = $data_1_7['num_cb'];
		$num_da_1_7 = $data_1_7['num_da'];
		$num_db_1_7 = $data_1_7['num_db'];
		$num_ea_1_7 = $data_1_7['num_ea'];
		$num_eb_1_7 = $data_1_7['num_eb'];

		if ($num_aa_1_7 == "")
		{
			$num_aa_1_7 = "-";
		}
		if ($num_ab_1_7 == "")
		{
			$num_ab_1_7 = "-";
		}
		if ($num_ba_1_7 == "")
		{
			$num_ba_1_7 = "-";
		}
		if ($num_bb_1_7 == "")
		{
			$num_bb_1_7 = "-";
		}
		if ($num_ca_1_7 == "")
		{
			$num_ca_1_7 = "-";
		}
		if ($num_cb_1_7 == "")
		{
			$num_cb_1_7 = "-";
		}
		if ($num_da_1_7 == "")
		{
			$num_da_1_7 = "-";
		}
		if ($num_db_1_7 == "")
		{
			$num_db_1_7 = "-";
		}
		if ($num_ea_1_7 == "")
		{
			$num_ea_1_7 = "-";
		}
		if ($num_eb_1_7 == "")
		{
			$num_eb_1_7 = "-";
		}


		//1학년8반
		$sql_1_8 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE1."' AND str_class='".$STR_CLASS8."'";


		//echo "sql_1:$sql_1";exit;

		$data_1_8 = $DB->sqlFetch($sql_1_8);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_1_8 = $data_1_8['num_aa'];
		$num_ab_1_8 = $data_1_8['num_ab'];
		$num_ba_1_8 = $data_1_8['num_ba'];
		$num_bb_1_8 = $data_1_8['num_bb'];
		$num_ca_1_8 = $data_1_8['num_ca'];
		$num_cb_1_8 = $data_1_8['num_cb'];
		$num_da_1_8 = $data_1_8['num_da'];
		$num_db_1_8 = $data_1_8['num_db'];
		$num_ea_1_8 = $data_1_8['num_ea'];
		$num_eb_1_8 = $data_1_8['num_eb'];

		if ($num_aa_1_8 == "")
		{
			$num_aa_1_8 = "-";
		}
		if ($num_ab_1_8 == "")
		{
			$num_ab_1_8 = "-";
		}
		if ($num_ba_1_8 == "")
		{
			$num_ba_1_8 = "-";
		}
		if ($num_bb_1_8 == "")
		{
			$num_bb_1_8 = "-";
		}
		if ($num_ca_1_8 == "")
		{
			$num_ca_1_8 = "-";
		}
		if ($num_cb_1_8 == "")
		{
			$num_cb_1_8 = "-";
		}
		if ($num_da_1_8 == "")
		{
			$num_da_1_8 = "-";
		}
		if ($num_db_1_8 == "")
		{
			$num_db_1_8 = "-";
		}
		if ($num_ea_1_8 == "")
		{
			$num_ea_1_8 = "-";
		}
		if ($num_eb_1_8 == "")
		{
			$num_eb_1_8 = "-";
		}


		//1학년9반
		$sql_1_9 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE1."' AND str_class='".$STR_CLASS9."'";


		//echo "sql_1:$sql_1";exit;

		$data_1_9 = $DB->sqlFetch($sql_1_9);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_1_9 = $data_1_9['num_aa'];
		$num_ab_1_9 = $data_1_9['num_ab'];
		$num_ba_1_9 = $data_1_9['num_ba'];
		$num_bb_1_9 = $data_1_9['num_bb'];
		$num_ca_1_9 = $data_1_9['num_ca'];
		$num_cb_1_9 = $data_1_9['num_cb'];
		$num_da_1_9 = $data_1_9['num_da'];
		$num_db_1_9 = $data_1_9['num_db'];
		$num_ea_1_9 = $data_1_9['num_ea'];
		$num_eb_1_9 = $data_1_9['num_eb'];

		if ($num_aa_1_9 == "")
		{
			$num_aa_1_9 = "-";
		}
		if ($num_ab_1_9 == "")
		{
			$num_ab_1_9 = "-";
		}
		if ($num_ba_1_9 == "")
		{
			$num_ba_1_9 = "-";
		}
		if ($num_bb_1_9 == "")
		{
			$num_bb_1_9 = "-";
		}
		if ($num_ca_1_9 == "")
		{
			$num_ca_1_9 = "-";
		}
		if ($num_cb_1_9 == "")
		{
			$num_cb_1_9 = "-";
		}
		if ($num_da_1_9 == "")
		{
			$num_da_1_9 = "-";
		}
		if ($num_db_1_9 == "")
		{
			$num_db_1_9 = "-";
		}
		if ($num_ea_1_9 == "")
		{
			$num_ea_1_9 = "-";
		}
		if ($num_eb_1_9 == "")
		{
			$num_eb_1_9 = "-";
		}


		//1학년10반
		$sql_1_10 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE2."' AND str_class='".$STR_CLASS10."'";


		//echo "sql_1:$sql_1";exit;

		$data_1_10 = $DB->sqlFetch($sql_1_10);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_1_10 = $data_1_10['num_aa'];
		$num_ab_1_10 = $data_1_10['num_ab'];
		$num_ba_1_10 = $data_1_10['num_ba'];
		$num_bb_1_10 = $data_1_10['num_bb'];
		$num_ca_1_10 = $data_1_10['num_ca'];
		$num_cb_1_10 = $data_1_10['num_cb'];
		$num_da_1_10 = $data_1_10['num_da'];
		$num_db_1_10 = $data_1_10['num_db'];
		$num_ea_1_10 = $data_1_10['num_ea'];
		$num_eb_1_10 = $data_1_10['num_eb'];

		if ($num_aa_1_10 == "")
		{
			$num_aa_1_10 = "-";
		}
		if ($num_ab_1_10 == "")
		{
			$num_ab_1_10 = "-";
		}
		if ($num_ba_1_10 == "")
		{
			$num_ba_1_10 = "-";
		}
		if ($num_bb_1_10 == "")
		{
			$num_bb_1_10 = "-";
		}
		if ($num_ca_1_10 == "")
		{
			$num_ca_1_10 = "-";
		}
		if ($num_cb_1_10 == "")
		{
			$num_cb_1_10 = "-";
		}
		if ($num_da_1_10 == "")
		{
			$num_da_1_10 = "-";
		}
		if ($num_db_1_10 == "")
		{
			$num_db_1_10 = "-";
		}
		if ($num_ea_1_10 == "")
		{
			$num_ea_1_10 = "-";
		}
		if ($num_eb_1_10 == "")
		{
			$num_eb_1_10 = "-";
		}


		##################### 2 학 년 ########################	
		//2학년1반
		$sql_2_1 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE2."' AND str_class='".$STR_CLASS1."'";


		//echo "sql_1:$sql_1";exit;

		$data_2_1 = $DB->sqlFetch($sql_2_1);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_2_1 = $data_2_1['num_aa'];
		$num_ab_2_1 = $data_2_1['num_ab'];
		$num_ba_2_1 = $data_2_1['num_ba'];
		$num_bb_2_1 = $data_2_1['num_bb'];
		$num_ca_2_1 = $data_2_1['num_ca'];
		$num_cb_2_1 = $data_2_1['num_cb'];
		$num_da_2_1 = $data_2_1['num_da'];
		$num_db_2_1 = $data_2_1['num_db'];
		$num_ea_2_1 = $data_2_1['num_ea'];
		$num_eb_2_1 = $data_2_1['num_eb'];

		if ($num_aa_2_1 == "")
		{
			$num_aa_2_1 = "-";
		}
		if ($num_ab_2_1 == "")
		{
			$num_ab_2_1 = "-";
		}
		if ($num_ba_2_1 == "")
		{
			$num_ba_2_1 = "-";
		}
		if ($num_bb_2_1 == "")
		{
			$num_bb_2_1 = "-";
		}
		if ($num_ca_2_1 == "")
		{
			$num_ca_2_1 = "-";
		}
		if ($num_cb_2_1 == "")
		{
			$num_cb_2_1 = "-";
		}
		if ($num_da_2_1 == "")
		{
			$num_da_2_1= "-";
		}
		if ($num_db_2_1 == "")
		{
			$num_db_2_1 = "-";
		}
		if ($num_ea_2_1 == "")
		{
			$num_ea_2_1 = "-";
		}
		if ($num_eb_2_1 == "")
		{
			$num_eb_2_1 = "-";
		}

		//2학년2반
		$sql_2_2 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE2."' AND str_class='".$STR_CLASS2."'";


		//echo "sql_1:$sql_1";exit;

		$data_2_2 = $DB->sqlFetch($sql_2_2);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_2_2 = $data_2_2['num_aa'];
		$num_ab_2_2 = $data_2_2['num_ab'];
		$num_ba_2_2 = $data_2_2['num_ba'];
		$num_bb_2_2 = $data_2_2['num_bb'];
		$num_ca_2_2 = $data_2_2['num_ca'];
		$num_cb_2_2 = $data_2_2['num_cb'];
		$num_da_2_2 = $data_2_2['num_da'];
		$num_db_2_2 = $data_2_2['num_db'];
		$num_ea_2_2 = $data_2_2['num_ea'];
		$num_eb_2_2 = $data_2_2['num_eb'];

		if ($num_aa_2_2 == "")
		{
			$num_aa_2_2 = "-";
		}
		if ($num_ab_2_2 == "")
		{
			$num_ab_2_2 = "-";
		}
		if ($num_ba_2_2 == "")
		{
			$num_ba_2_2 = "-";
		}
		if ($num_bb_2_2 == "")
		{
			$num_bb_2_2 = "-";
		}
		if ($num_ca_2_2 == "")
		{
			$num_ca_2_2 = "-";
		}
		if ($num_cb_2_2 == "")
		{
			$num_cb_2_2 = "-";
		}
		if ($num_da_2_2 == "")
		{
			$num_da_2_2= "-";
		}
		if ($num_db_2_2 == "")
		{
			$num_db_2_2 = "-";
		}
		if ($num_ea_2_2 == "")
		{
			$num_ea_2_2 = "-";
		}
		if ($num_eb_2_2 == "")
		{
			$num_eb_2_2 = "-";
		}

	
		//2학년3반
		$sql_2_3 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE2."' AND str_class='".$STR_CLASS3."'";


		//echo "sql_1:$sql_1";exit;

		$data_2_3 = $DB->sqlFetch($sql_2_3);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_2_3 = $data_2_3['num_aa'];
		$num_ab_2_3 = $data_2_3['num_ab'];
		$num_ba_2_3 = $data_2_3['num_ba'];
		$num_bb_2_3 = $data_2_3['num_bb'];
		$num_ca_2_3 = $data_2_3['num_ca'];
		$num_cb_2_3 = $data_2_3['num_cb'];
		$num_da_2_3 = $data_2_3['num_da'];
		$num_db_2_3 = $data_2_3['num_db'];
		$num_ea_2_3 = $data_2_3['num_ea'];
		$num_eb_2_3 = $data_2_3['num_eb'];

		if ($num_aa_2_3 == "")
		{
			$num_aa_2_3 = "-";
		}
		if ($num_ab_2_3 == "")
		{
			$num_ab_2_3 = "-";
		}
		if ($num_ba_2_3 == "")
		{
			$num_ba_2_3 = "-";
		}
		if ($num_bb_2_3 == "")
		{
			$num_bb_2_3 = "-";
		}
		if ($num_ca_2_3 == "")
		{
			$num_ca_2_3 = "-";
		}
		if ($num_cb_2_3 == "")
		{
			$num_cb_2_3 = "-";
		}
		if ($num_da_2_3 == "")
		{
			$num_da_2_3= "-";
		}
		if ($num_db_2_3 == "")
		{
			$num_db_2_3 = "-";
		}
		if ($num_ea_2_3 == "")
		{
			$num_ea_2_3 = "-";
		}
		if ($num_eb_2_3 == "")
		{
			$num_eb_2_3 = "-";
		}

		//2학년4반
		$sql_2_4 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE2."' AND str_class='".$STR_CLASS4."'";


		//echo "sql_1:$sql_1";exit;

		$data_2_4 = $DB->sqlFetch($sql_2_4);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_2_4 = $data_2_4['num_aa'];
		$num_ab_2_4 = $data_2_4['num_ab'];
		$num_ba_2_4 = $data_2_4['num_ba'];
		$num_bb_2_4 = $data_2_4['num_bb'];
		$num_ca_2_4 = $data_2_4['num_ca'];
		$num_cb_2_4 = $data_2_4['num_cb'];
		$num_da_2_4 = $data_2_4['num_da'];
		$num_db_2_4 = $data_2_4['num_db'];
		$num_ea_2_4 = $data_2_4['num_ea'];
		$num_eb_2_4 = $data_2_4['num_eb'];

		if ($num_aa_2_4 == "")
		{
			$num_aa_2_4 = "-";
		}
		if ($num_ab_2_4 == "")
		{
			$num_ab_2_4 = "-";
		}
		if ($num_ba_2_4 == "")
		{
			$num_ba_2_4 = "-";
		}
		if ($num_bb_2_4 == "")
		{
			$num_bb_2_4 = "-";
		}
		if ($num_ca_2_4 == "")
		{
			$num_ca_2_4 = "-";
		}
		if ($num_cb_2_4 == "")
		{
			$num_cb_2_4 = "-";
		}
		if ($num_da_2_4 == "")
		{
			$num_da_2_4= "-";
		}
		if ($num_db_2_4 == "")
		{
			$num_db_2_4 = "-";
		}
		if ($num_ea_2_4 == "")
		{
			$num_ea_2_4 = "-";
		}
		if ($num_eb_2_4 == "")
		{
			$num_eb_2_4 = "-";
		}

		//2학년5반
		$sql_2_5 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE2."' AND str_class='".$STR_CLASS5."'";


		//echo "sql_1:$sql_1";exit;

		$data_2_5 = $DB->sqlFetch($sql_2_5);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_2_5 = $data_2_5['num_aa'];
		$num_ab_2_5 = $data_2_5['num_ab'];
		$num_ba_2_5 = $data_2_5['num_ba'];
		$num_bb_2_5 = $data_2_5['num_bb'];
		$num_ca_2_5 = $data_2_5['num_ca'];
		$num_cb_2_5 = $data_2_5['num_cb'];
		$num_da_2_5 = $data_2_5['num_da'];
		$num_db_2_5 = $data_2_5['num_db'];
		$num_ea_2_5 = $data_2_5['num_ea'];
		$num_eb_2_5 = $data_2_5['num_eb'];

		if ($num_aa_2_5 == "")
		{
			$num_aa_2_5 = "-";
		}
		if ($num_ab_2_5 == "")
		{
			$num_ab_2_5 = "-";
		}
		if ($num_ba_2_5 == "")
		{
			$num_ba_2_5 = "-";
		}
		if ($num_bb_2_5 == "")
		{
			$num_bb_2_5 = "-";
		}
		if ($num_ca_2_5 == "")
		{
			$num_ca_2_5 = "-";
		}
		if ($num_cb_2_5 == "")
		{
			$num_cb_2_5 = "-";
		}
		if ($num_da_2_5 == "")
		{
			$num_da_2_5= "-";
		}
		if ($num_db_2_5 == "")
		{
			$num_db_2_5 = "-";
		}
		if ($num_ea_2_5 == "")
		{
			$num_ea_2_5 = "-";
		}
		if ($num_eb_2_5 == "")
		{
			$num_eb_2_5 = "-";
		}

		//2학년6반
		$sql_2_6 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE2."' AND str_class='".$STR_CLASS6."'";


		//echo "sql_1:$sql_1";exit;

		$data_2_6 = $DB->sqlFetch($sql_2_6);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_2_6 = $data_2_6['num_aa'];
		$num_ab_2_6 = $data_2_6['num_ab'];
		$num_ba_2_6 = $data_2_6['num_ba'];
		$num_bb_2_6 = $data_2_6['num_bb'];
		$num_ca_2_6 = $data_2_6['num_ca'];
		$num_cb_2_6 = $data_2_6['num_cb'];
		$num_da_2_6 = $data_2_6['num_da'];
		$num_db_2_6 = $data_2_6['num_db'];
		$num_ea_2_6 = $data_2_6['num_ea'];
		$num_eb_2_6 = $data_2_6['num_eb'];

		if ($num_aa_2_6 == "")
		{
			$num_aa_2_6 = "-";
		}
		if ($num_ab_2_6 == "")
		{
			$num_ab_2_6 = "-";
		}
		if ($num_ba_2_6 == "")
		{
			$num_ba_2_6 = "-";
		}
		if ($num_bb_2_6 == "")
		{
			$num_bb_2_6 = "-";
		}
		if ($num_ca_2_6 == "")
		{
			$num_ca_2_6 = "-";
		}
		if ($num_cb_2_6 == "")
		{
			$num_cb_2_6 = "-";
		}
		if ($num_da_2_6 == "")
		{
			$num_da_2_6= "-";
		}
		if ($num_db_2_6 == "")
		{
			$num_db_2_6 = "-";
		}
		if ($num_ea_2_6 == "")
		{
			$num_ea_2_6 = "-";
		}
		if ($num_eb_2_6 == "")
		{
			$num_eb_2_6 = "-";
		}

	
		//2학년7반
		$sql_2_7 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE2."' AND str_class='".$STR_CLASS7."'";


		//echo "sql_1:$sql_1";exit;

		$data_2_7 = $DB->sqlFetch($sql_2_7);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_2_7 = $data_2_7['num_aa'];
		$num_ab_2_7 = $data_2_7['num_ab'];
		$num_ba_2_7 = $data_2_7['num_ba'];
		$num_bb_2_7 = $data_2_7['num_bb'];
		$num_ca_2_7 = $data_2_7['num_ca'];
		$num_cb_2_7 = $data_2_7['num_cb'];
		$num_da_2_7 = $data_2_7['num_da'];
		$num_db_2_7 = $data_2_7['num_db'];
		$num_ea_2_7 = $data_2_7['num_ea'];
		$num_eb_2_7 = $data_2_7['num_eb'];

		if ($num_aa_2_7 == "")
		{
			$num_aa_2_7 = "-";
		}
		if ($num_ab_2_7 == "")
		{
			$num_ab_2_7 = "-";
		}
		if ($num_ba_2_7 == "")
		{
			$num_ba_2_7 = "-";
		}
		if ($num_bb_2_7 == "")
		{
			$num_bb_2_7 = "-";
		}
		if ($num_ca_2_7 == "")
		{
			$num_ca_2_7 = "-";
		}
		if ($num_cb_2_7 == "")
		{
			$num_cb_2_7 = "-";
		}
		if ($num_da_2_7 == "")
		{
			$num_da_2_7= "-";
		}
		if ($num_db_2_7 == "")
		{
			$num_db_2_7 = "-";
		}
		if ($num_ea_2_7 == "")
		{
			$num_ea_2_7 = "-";
		}
		if ($num_eb_2_7 == "")
		{
			$num_eb_2_7 = "-";
		}

		//2학년8반
		$sql_2_8 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE2."' AND str_class='".$STR_CLASS8."'";


		//echo "sql_1:$sql_1";exit;

		$data_2_8 = $DB->sqlFetch($sql_2_8);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_2_8 = $data_2_8['num_aa'];
		$num_ab_2_8 = $data_2_8['num_ab'];
		$num_ba_2_8 = $data_2_8['num_ba'];
		$num_bb_2_8 = $data_2_8['num_bb'];
		$num_ca_2_8 = $data_2_8['num_ca'];
		$num_cb_2_8 = $data_2_8['num_cb'];
		$num_da_2_8 = $data_2_8['num_da'];
		$num_db_2_8 = $data_2_8['num_db'];
		$num_ea_2_8 = $data_2_8['num_ea'];
		$num_eb_2_8 = $data_2_8['num_eb'];

		if ($num_aa_2_8 == "")
		{
			$num_aa_2_8 = "-";
		}
		if ($num_ab_2_8 == "")
		{
			$num_ab_2_8 = "-";
		}
		if ($num_ba_2_8 == "")
		{
			$num_ba_2_8 = "-";
		}
		if ($num_bb_2_8 == "")
		{
			$num_bb_2_8 = "-";
		}
		if ($num_ca_2_8 == "")
		{
			$num_ca_2_8 = "-";
		}
		if ($num_cb_2_8 == "")
		{
			$num_cb_2_8 = "-";
		}
		if ($num_da_2_8 == "")
		{
			$num_da_2_8= "-";
		}
		if ($num_db_2_8 == "")
		{
			$num_db_2_8 = "-";
		}
		if ($num_ea_2_8 == "")
		{
			$num_ea_2_8 = "-";
		}
		if ($num_eb_2_8 == "")
		{
			$num_eb_2_8 = "-";
		}

		//2학년9반
		$sql_2_9 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE2."' AND str_class='".$STR_CLASS9."'";


		//echo "sql_1:$sql_1";exit;

		$data_2_9 = $DB->sqlFetch($sql_2_9);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_2_9 = $data_2_9['num_aa'];
		$num_ab_2_9 = $data_2_9['num_ab'];
		$num_ba_2_9 = $data_2_9['num_ba'];
		$num_bb_2_9 = $data_2_9['num_bb'];
		$num_ca_2_9 = $data_2_9['num_ca'];
		$num_cb_2_9 = $data_2_9['num_cb'];
		$num_da_2_9 = $data_2_9['num_da'];
		$num_db_2_9 = $data_2_9['num_db'];
		$num_ea_2_9 = $data_2_9['num_ea'];
		$num_eb_2_9 = $data_2_9['num_eb'];

		if ($num_aa_2_9 == "")
		{
			$num_aa_2_9 = "-";
		}
		if ($num_ab_2_9 == "")
		{
			$num_ab_2_9 = "-";
		}
		if ($num_ba_2_9 == "")
		{
			$num_ba_2_9 = "-";
		}
		if ($num_bb_2_9 == "")
		{
			$num_bb_2_9 = "-";
		}
		if ($num_ca_2_9 == "")
		{
			$num_ca_2_9 = "-";
		}
		if ($num_cb_2_9 == "")
		{
			$num_cb_2_9 = "-";
		}
		if ($num_da_2_9 == "")
		{
			$num_da_2_9= "-";
		}
		if ($num_db_2_9 == "")
		{
			$num_db_2_9 = "-";
		}
		if ($num_ea_2_9 == "")
		{
			$num_ea_2_9 = "-";
		}
		if ($num_eb_2_9 == "")
		{
			$num_eb_2_9 = "-";
		}
	
							
		//2학년10반
		$sql_2_10 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE2."' AND str_class='".$STR_CLASS10."'";


		//echo "sql_1:$sql_1";exit;

		$data_2_10 = $DB->sqlFetch($sql_2_10);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_2_10 = $data_2_10['num_aa'];
		$num_ab_2_10 = $data_2_10['num_ab'];
		$num_ba_2_10 = $data_2_10['num_ba'];
		$num_bb_2_10 = $data_2_10['num_bb'];
		$num_ca_2_10 = $data_2_10['num_ca'];
		$num_cb_2_10 = $data_2_10['num_cb'];
		$num_da_2_10 = $data_2_10['num_da'];
		$num_db_2_10 = $data_2_10['num_db'];
		$num_ea_2_10 = $data_2_10['num_ea'];
		$num_eb_2_10 = $data_2_10['num_eb'];

		if ($num_aa_2_10 == "")
		{
			$num_aa_2_10 = "-";
		}
		if ($num_ab_2_10 == "")
		{
			$num_ab_2_10 = "-";
		}
		if ($num_ba_2_10 == "")
		{
			$num_ba_2_10 = "-";
		}
		if ($num_bb_2_10 == "")
		{
			$num_bb_2_10 = "-";
		}
		if ($num_ca_2_10 == "")
		{
			$num_ca_2_10 = "-";
		}
		if ($num_cb_2_10 == "")
		{
			$num_cb_2_10 = "-";
		}
		if ($num_da_2_10 == "")
		{
			$num_da_2_10= "-";
		}
		if ($num_db_2_10 == "")
		{
			$num_db_2_10 = "-";
		}
		if ($num_ea_2_10 == "")
		{
			$num_ea_2_10 = "-";
		}
		if ($num_eb_2_10 == "")
		{
			$num_eb_2_10 = "-";
		}
	

		################    3 학  년 ######################
		//3학년1반
		$sql_3_1 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE3."' AND str_class='".$STR_CLASS1."'";


		//echo "sql_1:$sql_1";exit;

		$data_3_1 = $DB->sqlFetch($sql_3_1);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_3_1 = $data_3_1['num_aa'];
		$num_ab_3_1 = $data_3_1['num_ab'];
		$num_ba_3_1 = $data_3_1['num_ba'];
		$num_bb_3_1 = $data_3_1['num_bb'];
		$num_ca_3_1 = $data_3_1['num_ca'];
		$num_cb_3_1 = $data_3_1['num_cb'];
		$num_da_3_1 = $data_3_1['num_da'];
		$num_db_3_1 = $data_3_1['num_db'];
		$num_ea_3_1 = $data_3_1['num_ea'];
		$num_eb_3_1 = $data_3_1['num_eb'];

		if ($num_aa_3_1 == "")
		{
			$num_aa_3_1 = "-";
		}
		if ($num_ab_3_1 == "")
		{
			$num_ab_3_1 = "-";
		}
		if ($num_ba_3_1 == "")
		{
			$num_ba_3_1 = "-";
		}
		if ($num_bb_3_1 == "")
		{
			$num_bb_3_1 = "-";
		}
		if ($num_ca_3_1 == "")
		{
			$num_ca_3_1 = "-";
		}
		if ($num_cb_3_1 == "")
		{
			$num_cb_3_1 = "-";
		}
		if ($num_da_3_1 == "")
		{
			$num_da_3_1= "-";
		}
		if ($num_db_3_1 == "")
		{
			$num_db_3_1 = "-";
		}
		if ($num_ea_3_1 == "")
		{
			$num_ea_3_1 = "-";
		}
		if ($num_eb_3_1 == "")
		{
			$num_eb_3_1 = "-";
		}
	
		//3학년2반
		$sql_3_2 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE3."' AND str_class='".$STR_CLASS2."'";


		//echo "sql_1:$sql_1";exit;

		$data_3_2 = $DB->sqlFetch($sql_3_2);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_3_2 = $data_3_2['num_aa'];
		$num_ab_3_2 = $data_3_2['num_ab'];
		$num_ba_3_2 = $data_3_2['num_ba'];
		$num_bb_3_2 = $data_3_2['num_bb'];
		$num_ca_3_2 = $data_3_2['num_ca'];
		$num_cb_3_2 = $data_3_2['num_cb'];
		$num_da_3_2 = $data_3_2['num_da'];
		$num_db_3_2 = $data_3_2['num_db'];
		$num_ea_3_2 = $data_3_2['num_ea'];
		$num_eb_3_2 = $data_3_2['num_eb'];

		if ($num_aa_3_2 == "")
		{
			$num_aa_3_2 = "-";
		}
		if ($num_ab_3_2 == "")
		{
			$num_ab_3_2 = "-";
		}
		if ($num_ba_3_2 == "")
		{
			$num_ba_3_2 = "-";
		}
		if ($num_bb_3_2 == "")
		{
			$num_bb_3_2 = "-";
		}
		if ($num_ca_3_2 == "")
		{
			$num_ca_3_2 = "-";
		}
		if ($num_cb_3_2 == "")
		{
			$num_cb_3_2 = "-";
		}
		if ($num_da_3_2 == "")
		{
			$num_da_3_2= "-";
		}
		if ($num_db_3_2 == "")
		{
			$num_db_3_2 = "-";
		}
		if ($num_ea_3_2 == "")
		{
			$num_ea_3_2 = "-";
		}
		if ($num_eb_3_2 == "")
		{
			$num_eb_3_2 = "-";
		}
	
		//3학년3반
		$sql_3_3 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE3."' AND str_class='".$STR_CLASS3."'";


		//echo "sql_1:$sql_1";exit;

		$data_3_3 = $DB->sqlFetch($sql_3_3);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_3_3 = $data_3_3['num_aa'];
		$num_ab_3_3 = $data_3_3['num_ab'];
		$num_ba_3_3 = $data_3_3['num_ba'];
		$num_bb_3_3 = $data_3_3['num_bb'];
		$num_ca_3_3 = $data_3_3['num_ca'];
		$num_cb_3_3 = $data_3_3['num_cb'];
		$num_da_3_3 = $data_3_3['num_da'];
		$num_db_3_3 = $data_3_3['num_db'];
		$num_ea_3_3 = $data_3_3['num_ea'];
		$num_eb_3_3 = $data_3_3['num_eb'];

		if ($num_aa_3_3 == "")
		{
			$num_aa_3_3 = "-";
		}
		if ($num_ab_3_3 == "")
		{
			$num_ab_3_3 = "-";
		}
		if ($num_ba_3_3 == "")
		{
			$num_ba_3_3 = "-";
		}
		if ($num_bb_3_3 == "")
		{
			$num_bb_3_3 = "-";
		}
		if ($num_ca_3_3 == "")
		{
			$num_ca_3_3 = "-";
		}
		if ($num_cb_3_3 == "")
		{
			$num_cb_3_3 = "-";
		}
		if ($num_da_3_3 == "")
		{
			$num_da_3_3= "-";
		}
		if ($num_db_3_3 == "")
		{
			$num_db_3_3 = "-";
		}
		if ($num_ea_3_3 == "")
		{
			$num_ea_3_3 = "-";
		}
		if ($num_eb_3_3 == "")
		{
			$num_eb_3_3 = "-";
		}
	
		//3학년4반
		$sql_3_4 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE3."' AND str_class='".$STR_CLASS4."'";


		//echo "sql_1:$sql_1";exit;

		$data_3_4 = $DB->sqlFetch($sql_3_4);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_3_4 = $data_3_4['num_aa'];
		$num_ab_3_4 = $data_3_4['num_ab'];
		$num_ba_3_4 = $data_3_4['num_ba'];
		$num_bb_3_4 = $data_3_4['num_bb'];
		$num_ca_3_4 = $data_3_4['num_ca'];
		$num_cb_3_4 = $data_3_4['num_cb'];
		$num_da_3_4 = $data_3_4['num_da'];
		$num_db_3_4 = $data_3_4['num_db'];
		$num_ea_3_4 = $data_3_4['num_ea'];
		$num_eb_3_4 = $data_3_4['num_eb'];

		if ($num_aa_3_4 == "")
		{
			$num_aa_3_4 = "-";
		}
		if ($num_ab_3_4 == "")
		{
			$num_ab_3_4 = "-";
		}
		if ($num_ba_3_4 == "")
		{
			$num_ba_3_4 = "-";
		}
		if ($num_bb_3_4 == "")
		{
			$num_bb_3_4 = "-";
		}
		if ($num_ca_3_4 == "")
		{
			$num_ca_3_4 = "-";
		}
		if ($num_cb_3_4 == "")
		{
			$num_cb_3_4 = "-";
		}
		if ($num_da_3_4 == "")
		{
			$num_da_3_4= "-";
		}
		if ($num_db_3_4 == "")
		{
			$num_db_3_4 = "-";
		}
		if ($num_ea_3_4 == "")
		{
			$num_ea_3_4 = "-";
		}
		if ($num_eb_3_4 == "")
		{
			$num_eb_3_4 = "-";
		}
	
		//3학년5반
		$sql_3_5 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE3."' AND str_class='".$STR_CLASS5."'";


		//echo "sql_1:$sql_1";exit;

		$data_3_5 = $DB->sqlFetch($sql_3_5);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_3_5 = $data_3_5['num_aa'];
		$num_ab_3_5 = $data_3_5['num_ab'];
		$num_ba_3_5 = $data_3_5['num_ba'];
		$num_bb_3_5 = $data_3_5['num_bb'];
		$num_ca_3_5 = $data_3_5['num_ca'];
		$num_cb_3_5 = $data_3_5['num_cb'];
		$num_da_3_5 = $data_3_5['num_da'];
		$num_db_3_5 = $data_3_5['num_db'];
		$num_ea_3_5 = $data_3_5['num_ea'];
		$num_eb_3_5 = $data_3_5['num_eb'];

		if ($num_aa_3_5 == "")
		{
			$num_aa_3_5 = "-";
		}
		if ($num_ab_3_5 == "")
		{
			$num_ab_3_5 = "-";
		}
		if ($num_ba_3_5 == "")
		{
			$num_ba_3_5 = "-";
		}
		if ($num_bb_3_5 == "")
		{
			$num_bb_3_5 = "-";
		}
		if ($num_ca_3_5 == "")
		{
			$num_ca_3_5 = "-";
		}
		if ($num_cb_3_5 == "")
		{
			$num_cb_3_5 = "-";
		}
		if ($num_da_3_5 == "")
		{
			$num_da_3_5= "-";
		}
		if ($num_db_3_5 == "")
		{
			$num_db_3_5 = "-";
		}
		if ($num_ea_3_5 == "")
		{
			$num_ea_3_5 = "-";
		}
		if ($num_eb_3_5 == "")
		{
			$num_eb_3_5 = "-";
		}
	
		//3학년6반
		$sql_3_6 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE3."' AND str_class='".$STR_CLASS6."'";


		//echo "sql_1:$sql_1";exit;

		$data_3_6 = $DB->sqlFetch($sql_3_6);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_3_6 = $data_3_6['num_aa'];
		$num_ab_3_6 = $data_3_6['num_ab'];
		$num_ba_3_6 = $data_3_6['num_ba'];
		$num_bb_3_6 = $data_3_6['num_bb'];
		$num_ca_3_6 = $data_3_6['num_ca'];
		$num_cb_3_6 = $data_3_6['num_cb'];
		$num_da_3_6 = $data_3_6['num_da'];
		$num_db_3_6 = $data_3_6['num_db'];
		$num_ea_3_6 = $data_3_6['num_ea'];
		$num_eb_3_6 = $data_3_6['num_eb'];

		if ($num_aa_3_6 == "")
		{
			$num_aa_3_6 = "-";
		}
		if ($num_ab_3_6 == "")
		{
			$num_ab_3_6 = "-";
		}
		if ($num_ba_3_6 == "")
		{
			$num_ba_3_6 = "-";
		}
		if ($num_bb_3_6 == "")
		{
			$num_bb_3_6 = "-";
		}
		if ($num_ca_3_6 == "")
		{
			$num_ca_3_6 = "-";
		}
		if ($num_cb_3_6 == "")
		{
			$num_cb_3_6 = "-";
		}
		if ($num_da_3_6 == "")
		{
			$num_da_3_6= "-";
		}
		if ($num_db_3_6 == "")
		{
			$num_db_3_6 = "-";
		}
		if ($num_ea_3_6 == "")
		{
			$num_ea_3_6 = "-";
		}
		if ($num_eb_3_6 == "")
		{
			$num_eb_3_6 = "-";
		}
	
		//3학년7반
		$sql_3_7 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE3."' AND str_class='".$STR_CLASS7."'";


		//echo "sql_1:$sql_1";exit;

		$data_3_7 = $DB->sqlFetch($sql_3_7);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_3_7 = $data_3_7['num_aa'];
		$num_ab_3_7 = $data_3_7['num_ab'];
		$num_ba_3_7 = $data_3_7['num_ba'];
		$num_bb_3_7 = $data_3_7['num_bb'];
		$num_ca_3_7 = $data_3_7['num_ca'];
		$num_cb_3_7 = $data_3_7['num_cb'];
		$num_da_3_7 = $data_3_7['num_da'];
		$num_db_3_7 = $data_3_7['num_db'];
		$num_ea_3_7 = $data_3_7['num_ea'];
		$num_eb_3_7 = $data_3_7['num_eb'];

		if ($num_aa_3_7 == "")
		{
			$num_aa_3_7 = "-";
		}
		if ($num_ab_3_7 == "")
		{
			$num_ab_3_7 = "-";
		}
		if ($num_ba_3_7 == "")
		{
			$num_ba_3_7 = "-";
		}
		if ($num_bb_3_7 == "")
		{
			$num_bb_3_7 = "-";
		}
		if ($num_ca_3_7 == "")
		{
			$num_ca_3_7 = "-";
		}
		if ($num_cb_3_7 == "")
		{
			$num_cb_3_7 = "-";
		}
		if ($num_da_3_7 == "")
		{
			$num_da_3_7= "-";
		}
		if ($num_db_3_7 == "")
		{
			$num_db_3_7 = "-";
		}
		if ($num_ea_3_7 == "")
		{
			$num_ea_3_7 = "-";
		}
		if ($num_eb_3_7 == "")
		{
			$num_eb_3_7 = "-";
		}
	
													
		//3학년8반
		$sql_3_8 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE3."' AND str_class='".$STR_CLASS8."'";


		//echo "sql_1:$sql_1";exit;

		$data_3_8 = $DB->sqlFetch($sql_3_8);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_3_8 = $data_3_8['num_aa'];
		$num_ab_3_8 = $data_3_8['num_ab'];
		$num_ba_3_8 = $data_3_8['num_ba'];
		$num_bb_3_8 = $data_3_8['num_bb'];
		$num_ca_3_8 = $data_3_8['num_ca'];
		$num_cb_3_8 = $data_3_8['num_cb'];
		$num_da_3_8 = $data_3_8['num_da'];
		$num_db_3_8 = $data_3_8['num_db'];
		$num_ea_3_8 = $data_3_8['num_ea'];
		$num_eb_3_8 = $data_3_8['num_eb'];

		if ($num_aa_3_8 == "")
		{
			$num_aa_3_8 = "-";
		}
		if ($num_ab_3_8 == "")
		{
			$num_ab_3_8 = "-";
		}
		if ($num_ba_3_8 == "")
		{
			$num_ba_3_8 = "-";
		}
		if ($num_bb_3_8 == "")
		{
			$num_bb_3_8 = "-";
		}
		if ($num_ca_3_8 == "")
		{
			$num_ca_3_8 = "-";
		}
		if ($num_cb_3_8 == "")
		{
			$num_cb_3_8 = "-";
		}
		if ($num_da_3_8 == "")
		{
			$num_da_3_8= "-";
		}
		if ($num_db_3_8 == "")
		{
			$num_db_3_8 = "-";
		}
		if ($num_ea_3_8 == "")
		{
			$num_ea_3_8 = "-";
		}
		if ($num_eb_3_8 == "")
		{
			$num_eb_3_8 = "-";
		}
	
		//3학년9반
		$sql_3_9 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE3."' AND str_class='".$STR_CLASS9."'";


		//echo "sql_1:$sql_1";exit;

		$data_3_9 = $DB->sqlFetch($sql_3_9);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_3_9 = $data_3_9['num_aa'];
		$num_ab_3_9 = $data_3_9['num_ab'];
		$num_ba_3_9 = $data_3_9['num_ba'];
		$num_bb_3_9 = $data_3_9['num_bb'];
		$num_ca_3_9 = $data_3_9['num_ca'];
		$num_cb_3_9 = $data_3_9['num_cb'];
		$num_da_3_9 = $data_3_9['num_da'];
		$num_db_3_9 = $data_3_9['num_db'];
		$num_ea_3_9 = $data_3_9['num_ea'];
		$num_eb_3_9 = $data_3_9['num_eb'];

		if ($num_aa_3_9 == "")
		{
			$num_aa_3_9 = "-";
		}
		if ($num_ab_3_9 == "")
		{
			$num_ab_3_9 = "-";
		}
		if ($num_ba_3_9 == "")
		{
			$num_ba_3_9 = "-";
		}
		if ($num_bb_3_9 == "")
		{
			$num_bb_3_9 = "-";
		}
		if ($num_ca_3_9 == "")
		{
			$num_ca_3_9 = "-";
		}
		if ($num_cb_3_9 == "")
		{
			$num_cb_3_9 = "-";
		}
		if ($num_da_3_9 == "")
		{
			$num_da_3_9= "-";
		}
		if ($num_db_3_9 == "")
		{
			$num_db_3_9 = "-";
		}
		if ($num_ea_3_9 == "")
		{
			$num_ea_3_9 = "-";
		}
		if ($num_eb_3_9 == "")
		{
			$num_eb_3_9 = "-";
		}
														

		//3학년10반
		$sql_3_10 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE3."' AND str_class='".$STR_CLASS10."'";


		//echo "sql_1:$sql_1";exit;

		$data_3_10 = $DB->sqlFetch($sql_3_10);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_3_10 = $data_3_10['num_aa'];
		$num_ab_3_10 = $data_3_10['num_ab'];
		$num_ba_3_10 = $data_3_10['num_ba'];
		$num_bb_3_10 = $data_3_10['num_bb'];
		$num_ca_3_10 = $data_3_10['num_ca'];
		$num_cb_3_10 = $data_3_10['num_cb'];
		$num_da_3_10 = $data_3_10['num_da'];
		$num_db_3_10 = $data_3_10['num_db'];
		$num_ea_3_10 = $data_3_10['num_ea'];
		$num_eb_3_10 = $data_3_10['num_eb'];

		if ($num_aa_3_10 == "")
		{
			$num_aa_3_10 = "-";
		}
		if ($num_ab_3_10 == "")
		{
			$num_ab_3_10 = "-";
		}
		if ($num_ba_3_10 == "")
		{
			$num_ba_3_10 = "-";
		}
		if ($num_bb_3_10 == "")
		{
			$num_bb_3_10 = "-";
		}
		if ($num_ca_3_10 == "")
		{
			$num_ca_3_10 = "-";
		}
		if ($num_cb_3_10 == "")
		{
			$num_cb_3_10 = "-";
		}
		if ($num_da_3_10 == "")
		{
			$num_da_3_10= "-";
		}
		if ($num_db_3_10 == "")
		{
			$num_db_3_10 = "-";
		}
		if ($num_ea_3_10 == "")
		{
			$num_ea_3_10 = "-";
		}
		if ($num_eb_3_10 == "")
		{
			$num_eb_3_10 = "-";
		}
														
		############### 4 학  년 ####################		  														
		//4학년1반
		$sql_4_1 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE4."' AND str_class='".$STR_CLASS1."'";


		//echo "sql_1:$sql_1";exit;

		$data_4_1 = $DB->sqlFetch($sql_4_1);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_4_1 = $data_4_1['num_aa'];
		$num_ab_4_1 = $data_4_1['num_ab'];
		$num_ba_4_1 = $data_4_1['num_ba'];
		$num_bb_4_1 = $data_4_1['num_bb'];
		$num_ca_4_1 = $data_4_1['num_ca'];
		$num_cb_4_1 = $data_4_1['num_cb'];
		$num_da_4_1 = $data_4_1['num_da'];
		$num_db_4_1 = $data_4_1['num_db'];
		$num_ea_4_1 = $data_4_1['num_ea'];
		$num_eb_4_1 = $data_4_1['num_eb'];

		if ($num_aa_4_1 == "")
		{
			$num_aa_4_1 = "-";
		}
		if ($num_ab_4_1 == "")
		{
			$num_ab_4_1 = "-";
		}
		if ($num_ba_4_1 == "")
		{
			$num_ba_4_1 = "-";
		}
		if ($num_bb_4_1 == "")
		{
			$num_bb_4_1 = "-";
		}
		if ($num_ca_4_1 == "")
		{
			$num_ca_4_1 = "-";
		}
		if ($num_cb_4_1 == "")
		{
			$num_cb_4_1 = "-";
		}
		if ($num_da_4_1 == "")
		{
			$num_da_4_1= "-";
		}
		if ($num_db_4_1 == "")
		{
			$num_db_4_1 = "-";
		}
		if ($num_ea_4_1 == "")
		{
			$num_ea_4_1 = "-";
		}
		if ($num_eb_4_1 == "")
		{
			$num_eb_4_1 = "-";
		}
																		
		//4학년2반
		$sql_4_2 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE4."' AND str_class='".$STR_CLASS2."'";


		//echo "sql_1:$sql_1";exit;

		$data_4_2 = $DB->sqlFetch($sql_4_2);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_4_2 = $data_4_2['num_aa'];
		$num_ab_4_2 = $data_4_2['num_ab'];
		$num_ba_4_2 = $data_4_2['num_ba'];
		$num_bb_4_2 = $data_4_2['num_bb'];
		$num_ca_4_2 = $data_4_2['num_ca'];
		$num_cb_4_2 = $data_4_2['num_cb'];
		$num_da_4_2 = $data_4_2['num_da'];
		$num_db_4_2 = $data_4_2['num_db'];
		$num_ea_4_2 = $data_4_2['num_ea'];
		$num_eb_4_2 = $data_4_2['num_eb'];

		if ($num_aa_4_2 == "")
		{
			$num_aa_4_2 = "-";
		}
		if ($num_ab_4_2 == "")
		{
			$num_ab_4_2 = "-";
		}
		if ($num_ba_4_2 == "")
		{
			$num_ba_4_2 = "-";
		}
		if ($num_bb_4_2 == "")
		{
			$num_bb_4_2 = "-";
		}
		if ($num_ca_4_2 == "")
		{
			$num_ca_4_2 = "-";
		}
		if ($num_cb_4_2 == "")
		{
			$num_cb_4_2 = "-";
		}
		if ($num_da_4_2 == "")
		{
			$num_da_4_2= "-";
		}
		if ($num_db_4_2 == "")
		{
			$num_db_4_2 = "-";
		}
		if ($num_ea_4_2 == "")
		{
			$num_ea_4_2 = "-";
		}
		if ($num_eb_4_2 == "")
		{
			$num_eb_4_2 = "-";
		}

		//4학년3반
		$sql_4_3 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE4."' AND str_class='".$STR_CLASS3."'";


		//echo "sql_1:$sql_1";exit;

		$data_4_3 = $DB->sqlFetch($sql_4_3);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_4_3 = $data_4_3['num_aa'];
		$num_ab_4_3 = $data_4_3['num_ab'];
		$num_ba_4_3 = $data_4_3['num_ba'];
		$num_bb_4_3 = $data_4_3['num_bb'];
		$num_ca_4_3 = $data_4_3['num_ca'];
		$num_cb_4_3 = $data_4_3['num_cb'];
		$num_da_4_3 = $data_4_3['num_da'];
		$num_db_4_3 = $data_4_3['num_db'];
		$num_ea_4_3 = $data_4_3['num_ea'];
		$num_eb_4_3 = $data_4_3['num_eb'];

		if ($num_aa_4_3 == "")
		{
			$num_aa_4_3 = "-";
		}
		if ($num_ab_4_3 == "")
		{
			$num_ab_4_3 = "-";
		}
		if ($num_ba_4_3 == "")
		{
			$num_ba_4_3 = "-";
		}
		if ($num_bb_4_3 == "")
		{
			$num_bb_4_3 = "-";
		}
		if ($num_ca_4_3 == "")
		{
			$num_ca_4_3 = "-";
		}
		if ($num_cb_4_3 == "")
		{
			$num_cb_4_3 = "-";
		}
		if ($num_da_4_3 == "")
		{
			$num_da_4_3= "-";
		}
		if ($num_db_4_3 == "")
		{
			$num_db_4_3 = "-";
		}
		if ($num_ea_4_3 == "")
		{
			$num_ea_4_3 = "-";
		}
		if ($num_eb_4_3 == "")
		{
			$num_eb_4_3 = "-";
		}
														
		//4학년4반
		$sql_4_4 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE4."' AND str_class='".$STR_CLASS4."'";


		//echo "sql_1:$sql_1";exit;

		$data_4_4 = $DB->sqlFetch($sql_4_4);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_4_4 = $data_4_4['num_aa'];
		$num_ab_4_4 = $data_4_4['num_ab'];
		$num_ba_4_4 = $data_4_4['num_ba'];
		$num_bb_4_4 = $data_4_4['num_bb'];
		$num_ca_4_4 = $data_4_4['num_ca'];
		$num_cb_4_4 = $data_4_4['num_cb'];
		$num_da_4_4 = $data_4_4['num_da'];
		$num_db_4_4 = $data_4_4['num_db'];
		$num_ea_4_4 = $data_4_4['num_ea'];
		$num_eb_4_4 = $data_4_4['num_eb'];

		if ($num_aa_4_4 == "")
		{
			$num_aa_4_4 = "-";
		}
		if ($num_ab_4_4 == "")
		{
			$num_ab_4_4 = "-";
		}
		if ($num_ba_4_4 == "")
		{
			$num_ba_4_4 = "-";
		}
		if ($num_bb_4_4 == "")
		{
			$num_bb_4_4 = "-";
		}
		if ($num_ca_4_4 == "")
		{
			$num_ca_4_4 = "-";
		}
		if ($num_cb_4_4 == "")
		{
			$num_cb_4_4 = "-";
		}
		if ($num_da_4_4 == "")
		{
			$num_da_4_4= "-";
		}
		if ($num_db_4_4 == "")
		{
			$num_db_4_4 = "-";
		}
		if ($num_ea_4_4 == "")
		{
			$num_ea_4_4 = "-";
		}
		if ($num_eb_4_4 == "")
		{
			$num_eb_4_4 = "-";
		}	
	   
	    //4학년5반
		$sql_4_5 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE4."' AND str_class='".$STR_CLASS5."'";


		//echo "sql_1:$sql_1";exit;

		$data_4_5 = $DB->sqlFetch($sql_4_5);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_4_5 = $data_4_5['num_aa'];
		$num_ab_4_5 = $data_4_5['num_ab'];
		$num_ba_4_5 = $data_4_5['num_ba'];
		$num_bb_4_5 = $data_4_5['num_bb'];
		$num_ca_4_5 = $data_4_5['num_ca'];
		$num_cb_4_5 = $data_4_5['num_cb'];
		$num_da_4_5 = $data_4_5['num_da'];
		$num_db_4_5 = $data_4_5['num_db'];
		$num_ea_4_5 = $data_4_5['num_ea'];
		$num_eb_4_5 = $data_4_5['num_eb'];

		if ($num_aa_4_5 == "")
		{
			$num_aa_4_5 = "-";
		}
		if ($num_ab_4_5 == "")
		{
			$num_ab_4_5 = "-";
		}
		if ($num_ba_4_5 == "")
		{
			$num_ba_4_5 = "-";
		}
		if ($num_bb_4_5 == "")
		{
			$num_bb_4_5 = "-";
		}
		if ($num_ca_4_5 == "")
		{
			$num_ca_4_5 = "-";
		}
		if ($num_cb_4_5 == "")
		{
			$num_cb_4_5 = "-";
		}
		if ($num_da_4_5 == "")
		{
			$num_da_4_5= "-";
		}
		if ($num_db_4_5 == "")
		{
			$num_db_4_5 = "-";
		}
		if ($num_ea_4_5 == "")
		{
			$num_ea_4_5 = "-";
		}
		if ($num_eb_4_5 == "")
		{
			$num_eb_4_5 = "-";
		}	

       //4학년6반
		$sql_4_6 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE4."' AND str_class='".$STR_CLASS6."'";


		//echo "sql_1:$sql_1";exit;

		$data_4_6 = $DB->sqlFetch($sql_4_6);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_4_6 = $data_4_6['num_aa'];
		$num_ab_4_6 = $data_4_6['num_ab'];
		$num_ba_4_6 = $data_4_6['num_ba'];
		$num_bb_4_6 = $data_4_6['num_bb'];
		$num_ca_4_6 = $data_4_6['num_ca'];
		$num_cb_4_6 = $data_4_6['num_cb'];
		$num_da_4_6 = $data_4_6['num_da'];
		$num_db_4_6 = $data_4_6['num_db'];
		$num_ea_4_6 = $data_4_6['num_ea'];
		$num_eb_4_6 = $data_4_6['num_eb'];

		if ($num_aa_4_6 == "")
		{
			$num_aa_4_6 = "-";
		}
		if ($num_ab_4_6 == "")
		{
			$num_ab_4_6 = "-";
		}
		if ($num_ba_4_6 == "")
		{
			$num_ba_4_6 = "-";
		}
		if ($num_bb_4_6 == "")
		{
			$num_bb_4_6 = "-";
		}
		if ($num_ca_4_6 == "")
		{
			$num_ca_4_6 = "-";
		}
		if ($num_cb_4_6 == "")
		{
			$num_cb_4_6 = "-";
		}
		if ($num_da_4_6 == "")
		{
			$num_da_4_6= "-";
		}
		if ($num_db_4_6 == "")
		{
			$num_db_4_6 = "-";
		}
		if ($num_ea_4_6 == "")
		{
			$num_ea_4_6 = "-";
		}
		if ($num_eb_4_6 == "")
		{
			$num_eb_4_6 = "-";
		}	

		 //4학년7반
		$sql_4_7 = "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE4."' AND str_class='".$STR_CLASS7."'";


		//echo "sql_1:$sql_1";exit;

		$data_4_7 = $DB->sqlFetch($sql_4_7);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_4_7 = $data_4_7['num_aa'];
		$num_ab_4_7 = $data_4_7['num_ab'];
		$num_ba_4_7 = $data_4_7['num_ba'];
		$num_bb_4_7 = $data_4_7['num_bb'];
		$num_ca_4_7 = $data_4_7['num_ca'];
		$num_cb_4_7 = $data_4_7['num_cb'];
		$num_da_4_7 = $data_4_7['num_da'];
		$num_db_4_7 = $data_4_7['num_db'];
		$num_ea_4_7 = $data_4_7['num_ea'];
		$num_eb_4_7 = $data_4_7['num_eb'];

		if ($num_aa_4_7 == "")
		{
			$num_aa_4_7 = "-";
		}
		if ($num_ab_4_7 == "")
		{
			$num_ab_4_7 = "-";
		}
		if ($num_ba_4_7 == "")
		{
			$num_ba_4_7 = "-";
		}
		if ($num_bb_4_7 == "")
		{
			$num_bb_4_7 = "-";
		}
		if ($num_ca_4_7 == "")
		{
			$num_ca_4_7 = "-";
		}
		if ($num_cb_4_7 == "")
		{
			$num_cb_4_7 = "-";
		}
		if ($num_da_4_7 == "")
		{
			$num_da_4_7= "-";
		}
		if ($num_db_4_7 == "")
		{
			$num_db_4_7 = "-";
		}
		if ($num_ea_4_7 == "")
		{
			$num_ea_4_7 = "-";
		}
		if ($num_eb_4_7 == "")
		{
			$num_eb_4_7 = "-";
		}	

		 //4학년8반
		$sql_4_8= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE4."' AND str_class='".$STR_CLASS8."'";


		//echo "sql_1:$sql_1";exit;

		$data_4_8 = $DB->sqlFetch($sql_4_8);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_4_8 = $data_4_8['num_aa'];
		$num_ab_4_8 = $data_4_8['num_ab'];
		$num_ba_4_8 = $data_4_8['num_ba'];
		$num_bb_4_8 = $data_4_8['num_bb'];
		$num_ca_4_8 = $data_4_8['num_ca'];
		$num_cb_4_8 = $data_4_8['num_cb'];
		$num_da_4_8 = $data_4_8['num_da'];
		$num_db_4_8 = $data_4_8['num_db'];
		$num_ea_4_8 = $data_4_8['num_ea'];
		$num_eb_4_8 = $data_4_8['num_eb'];

		if ($num_aa_4_8 == "")
		{
			$num_aa_4_8 = "-";
		}
		if ($num_ab_4_8 == "")
		{
			$num_ab_4_8 = "-";
		}
		if ($num_ba_4_8 == "")
		{
			$num_ba_4_8 = "-";
		}
		if ($num_bb_4_8 == "")
		{
			$num_bb_4_8 = "-";
		}
		if ($num_ca_4_8 == "")
		{
			$num_ca_4_8 = "-";
		}
		if ($num_cb_4_8 == "")
		{
			$num_cb_4_8 = "-";
		}
		if ($num_da_4_8 == "")
		{
			$num_da_4_8= "-";
		}
		if ($num_db_4_8 == "")
		{
			$num_db_4_8 = "-";
		}
		if ($num_ea_4_8 == "")
		{
			$num_ea_4_8 = "-";
		}
		if ($num_eb_4_8 == "")
		{
			$num_eb_4_8 = "-";
		}	

	    //4학년9반
		$sql_4_9= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE4."' AND str_class='".$STR_CLASS9."'";


		//echo "sql_1:$sql_1";exit;

		$data_4_9 = $DB->sqlFetch($sql_4_9);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_4_9 = $data_4_9['num_aa'];
		$num_ab_4_9 = $data_4_9['num_ab'];
		$num_ba_4_9 = $data_4_9['num_ba'];
		$num_bb_4_9 = $data_4_9['num_bb'];
		$num_ca_4_9 = $data_4_9['num_ca'];
		$num_cb_4_9 = $data_4_9['num_cb'];
		$num_da_4_9 = $data_4_9['num_da'];
		$num_db_4_9 = $data_4_9['num_db'];
		$num_ea_4_9 = $data_4_9['num_ea'];
		$num_eb_4_9 = $data_4_9['num_eb'];

		if ($num_aa_4_9 == "")
		{
			$num_aa_4_9 = "-";
		}
		if ($num_ab_4_9 == "")
		{
			$num_ab_4_9 = "-";
		}
		if ($num_ba_4_9 == "")
		{
			$num_ba_4_9 = "-";
		}
		if ($num_bb_4_9 == "")
		{
			$num_bb_4_9 = "-";
		}
		if ($num_ca_4_9 == "")
		{
			$num_ca_4_9 = "-";
		}
		if ($num_cb_4_9 == "")
		{
			$num_cb_4_9 = "-";
		}
		if ($num_da_4_9 == "")
		{
			$num_da_4_9= "-";
		}
		if ($num_db_4_9 == "")
		{
			$num_db_4_9 = "-";
		}
		if ($num_ea_4_9 == "")
		{
			$num_ea_4_9 = "-";
		}
		if ($num_eb_4_9 == "")
		{
			$num_eb_4_9 = "-";
		}	

       //4학년10반
		$sql_4_10= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE4."' AND str_class='".$STR_CLASS10."'";


		//echo "sql_4_10:$sql_4_10";exit;

		$data_4_10 = $DB->sqlFetch($sql_4_10);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_4_10 = $data_4_10['num_aa'];
		$num_ab_4_10 = $data_4_10['num_ab'];
		$num_ba_4_10 = $data_4_10['num_ba'];
		$num_bb_4_10 = $data_4_10['num_bb'];
		$num_ca_4_10 = $data_4_10['num_ca'];
		$num_cb_4_10 = $data_4_10['num_cb'];
		$num_da_4_10 = $data_4_10['num_da'];
		$num_db_4_10 = $data_4_10['num_db'];
		$num_ea_4_10 = $data_4_10['num_ea'];
		$num_eb_4_10 = $data_4_10['num_eb'];

		if ($num_aa_4_10 == "")
		{
			$num_aa_4_10 = "-";
		}
		if ($num_ab_4_10 == "")
		{
			$num_ab_4_10 = "-";
		}
		if ($num_ba_4_10 == "")
		{
			$num_ba_4_10 = "-";
		}
		if ($num_bb_4_10 == "")
		{
			$num_bb_4_10 = "-";
		}
		if ($num_ca_4_10 == "")
		{
			$num_ca_4_10 = "-";
		}
		if ($num_cb_4_10 == "")
		{
			$num_cb_4_10 = "-";
		}
		if ($num_da_4_10 == "")
		{
			$num_da_4_10= "-";
		}
		if ($num_db_4_10 == "")
		{
			$num_db_4_10 = "-";
		}
		if ($num_ea_4_10 == "")
		{
			$num_ea_4_10 = "-";
		}
		if ($num_eb_4_10 == "")
		{
			$num_eb_4_10 = "-";
		}	

		#######################    5   학   년   ###########################
        //5학년1반
		$sql_5_1= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE5."' AND str_class='".$STR_CLASS1."'";


		//echo "sql_1:$sql_1";exit;

		$data_5_1 = $DB->sqlFetch($sql_5_1);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_5_1 = $data_5_1['num_aa'];
		$num_ab_5_1 = $data_5_1['num_ab'];
		$num_ba_5_1 = $data_5_1['num_ba'];
		$num_bb_5_1 = $data_5_1['num_bb'];
		$num_ca_5_1 = $data_5_1['num_ca'];
		$num_cb_5_1 = $data_5_1['num_cb'];
		$num_da_5_1 = $data_5_1['num_da'];
		$num_db_5_1 = $data_5_1['num_db'];
		$num_ea_5_1 = $data_5_1['num_ea'];
		$num_eb_5_1 = $data_5_1['num_eb'];

		if ($num_aa_5_1 == "")
		{
			$num_aa_5_1 = "-";
		}
		if ($num_ab_5_1 == "")
		{
			$num_ab_5_1 = "-";
		}
		if ($num_ba_5_1 == "")
		{
			$num_ba_5_1 = "-";
		}
		if ($num_bb_5_1 == "")
		{
			$num_bb_5_1 = "-";
		}
		if ($num_ca_5_1 == "")
		{
			$num_ca_5_1 = "-";
		}
		if ($num_cb_5_1 == "")
		{
			$num_cb_5_1 = "-";
		}
		if ($num_da_5_1 == "")
		{
			$num_da_5_1= "-";
		}
		if ($num_db_5_1 == "")
		{
			$num_db_5_1 = "-";
		}
		if ($num_ea_5_1 == "")
		{
			$num_ea_5_1 = "-";
		}
		if ($num_eb_5_1 == "")
		{
			$num_eb_5_1 = "-";
		}	

   //5학년2반
		$sql_5_2= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE5."' AND str_class='".$STR_CLASS2."'";


		//echo "sql_1:$sql_1";exit;

		$data_5_2 = $DB->sqlFetch($sql_5_2);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_5_2 = $data_5_2['num_aa'];
		$num_ab_5_2 = $data_5_2['num_ab'];
		$num_ba_5_2 = $data_5_2['num_ba'];
		$num_bb_5_2 = $data_5_2['num_bb'];
		$num_ca_5_2 = $data_5_2['num_ca'];
		$num_cb_5_2 = $data_5_2['num_cb'];
		$num_da_5_2 = $data_5_2['num_da'];
		$num_db_5_2 = $data_5_2['num_db'];
		$num_ea_5_2 = $data_5_2['num_ea'];
		$num_eb_5_2 = $data_5_2['num_eb'];

		if ($num_aa_5_2 == "")
		{
			$num_aa_5_2 = "-";
		}
		if ($num_ab_5_2 == "")
		{
			$num_ab_5_2 = "-";
		}
		if ($num_ba_5_2 == "")
		{
			$num_ba_5_2 = "-";
		}
		if ($num_bb_5_2 == "")
		{
			$num_bb_5_2 = "-";
		}
		if ($num_ca_5_2 == "")
		{
			$num_ca_5_2 = "-";
		}
		if ($num_cb_5_2 == "")
		{
			$num_cb_5_2 = "-";
		}
		if ($num_da_5_2 == "")
		{
			$num_da_5_2= "-";
		}
		if ($num_db_5_2 == "")
		{
			$num_db_5_2 = "-";
		}
		if ($num_ea_5_2 == "")
		{
			$num_ea_5_2 = "-";
		}
		if ($num_eb_5_2 == "")
		{
			$num_eb_5_2 = "-";
		}	

        //5학년3반
		$sql_5_3= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE5."' AND str_class='".$STR_CLASS3."'";


		//echo "sql_1:$sql_1";exit;

		$data_5_3 = $DB->sqlFetch($sql_5_3);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_5_3 = $data_5_3['num_aa'];
		$num_ab_5_3 = $data_5_3['num_ab'];
		$num_ba_5_3 = $data_5_3['num_ba'];
		$num_bb_5_3 = $data_5_3['num_bb'];
		$num_ca_5_3 = $data_5_3['num_ca'];
		$num_cb_5_3 = $data_5_3['num_cb'];
		$num_da_5_3 = $data_5_3['num_da'];
		$num_db_5_3 = $data_5_3['num_db'];
		$num_ea_5_3 = $data_5_3['num_ea'];
		$num_eb_5_3 = $data_5_3['num_eb'];

		if ($num_aa_5_3 == "")
		{
			$num_aa_5_3 = "-";
		}
		if ($num_ab_5_3 == "")
		{
			$num_ab_5_3 = "-";
		}
		if ($num_ba_5_3 == "")
		{
			$num_ba_5_3 = "-";
		}
		if ($num_bb_5_3 == "")
		{
			$num_bb_5_3 = "-";
		}
		if ($num_ca_5_3 == "")
		{
			$num_ca_5_3 = "-";
		}
		if ($num_cb_5_3 == "")
		{
			$num_cb_5_3 = "-";
		}
		if ($num_da_5_3 == "")
		{
			$num_da_5_3= "-";
		}
		if ($num_db_5_3 == "")
		{
			$num_db_5_3 = "-";
		}
		if ($num_ea_5_3 == "")
		{
			$num_ea_5_3 = "-";
		}
		if ($num_eb_5_3 == "")
		{
			$num_eb_5_3 = "-";
		}	

        //5학년4반
		$sql_5_4= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE5."' AND str_class='".$STR_CLASS4."'";


		//echo "sql_1:$sql_1";exit;

		$data_5_4 = $DB->sqlFetch($sql_5_4);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_5_4 = $data_5_4['num_aa'];
		$num_ab_5_4 = $data_5_4['num_ab'];
		$num_ba_5_4 = $data_5_4['num_ba'];
		$num_bb_5_4 = $data_5_4['num_bb'];
		$num_ca_5_4 = $data_5_4['num_ca'];
		$num_cb_5_4 = $data_5_4['num_cb'];
		$num_da_5_4 = $data_5_4['num_da'];
		$num_db_5_4 = $data_5_4['num_db'];
		$num_ea_5_4 = $data_5_4['num_ea'];
		$num_eb_5_4 = $data_5_4['num_eb'];

		if ($num_aa_5_4 == "")
		{
			$num_aa_5_4 = "-";
		}
		if ($num_ab_5_4 == "")
		{
			$num_ab_5_4 = "-";
		}
		if ($num_ba_5_4 == "")
		{
			$num_ba_5_4 = "-";
		}
		if ($num_bb_5_4 == "")
		{
			$num_bb_5_4 = "-";
		}
		if ($num_ca_5_4 == "")
		{
			$num_ca_5_4 = "-";
		}
		if ($num_cb_5_4 == "")
		{
			$num_cb_5_4 = "-";
		}
		if ($num_da_5_4 == "")
		{
			$num_da_5_4= "-";
		}
		if ($num_db_5_4 == "")
		{
			$num_db_5_4 = "-";
		}
		if ($num_ea_5_4 == "")
		{
			$num_ea_5_4 = "-";
		}
		if ($num_eb_5_4 == "")
		{
			$num_eb_5_4 = "-";
		}	

        //5학년5반
		$sql_5_5= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE5."' AND str_class='".$STR_CLASS5."'";


		//echo "sql_1:$sql_1";exit;

		$data_5_5 = $DB->sqlFetch($sql_5_5);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_5_5 = $data_5_5['num_aa'];
		$num_ab_5_5 = $data_5_5['num_ab'];
		$num_ba_5_5 = $data_5_5['num_ba'];
		$num_bb_5_5 = $data_5_5['num_bb'];
		$num_ca_5_5 = $data_5_5['num_ca'];
		$num_cb_5_5 = $data_5_5['num_cb'];
		$num_da_5_5 = $data_5_5['num_da'];
		$num_db_5_5 = $data_5_5['num_db'];
		$num_ea_5_5 = $data_5_5['num_ea'];
		$num_eb_5_5 = $data_5_5['num_eb'];

		if ($num_aa_5_5 == "")
		{
			$num_aa_5_5 = "-";
		}
		if ($num_ab_5_5 == "")
		{
			$num_ab_5_5 = "-";
		}
		if ($num_ba_5_5 == "")
		{
			$num_ba_5_5 = "-";
		}
		if ($num_bb_5_5 == "")
		{
			$num_bb_5_5 = "-";
		}
		if ($num_ca_5_5 == "")
		{
			$num_ca_5_5 = "-";
		}
		if ($num_cb_5_5 == "")
		{
			$num_cb_5_5 = "-";
		}
		if ($num_da_5_5 == "")
		{
			$num_da_5_5= "-";
		}
		if ($num_db_5_5 == "")
		{
			$num_db_5_5 = "-";
		}
		if ($num_ea_5_5 == "")
		{
			$num_ea_5_5 = "-";
		}
		if ($num_eb_5_5 == "")
		{
			$num_eb_5_5 = "-";
		}	

       //5학년6반
		$sql_5_6= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE5."' AND str_class='".$STR_CLASS6."'";


		//echo "sql_1:$sql_1";exit;

		$data_5_6 = $DB->sqlFetch($sql_5_6);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_5_6 = $data_5_6['num_aa'];
		$num_ab_5_6 = $data_5_6['num_ab'];
		$num_ba_5_6 = $data_5_6['num_ba'];
		$num_bb_5_6 = $data_5_6['num_bb'];
		$num_ca_5_6 = $data_5_6['num_ca'];
		$num_cb_5_6 = $data_5_6['num_cb'];
		$num_da_5_6 = $data_5_6['num_da'];
		$num_db_5_6 = $data_5_6['num_db'];
		$num_ea_5_6 = $data_5_6['num_ea'];
		$num_eb_5_6 = $data_5_6['num_eb'];

		if ($num_aa_5_6 == "")
		{
			$num_aa_5_6 = "-";
		}
		if ($num_ab_5_6 == "")
		{
			$num_ab_5_6 = "-";
		}
		if ($num_ba_5_6 == "")
		{
			$num_ba_5_6 = "-";
		}
		if ($num_bb_5_6 == "")
		{
			$num_bb_5_6 = "-";
		}
		if ($num_ca_5_6 == "")
		{
			$num_ca_5_6 = "-";
		}
		if ($num_cb_5_6 == "")
		{
			$num_cb_5_6 = "-";
		}
		if ($num_da_5_6 == "")
		{
			$num_da_5_6= "-";
		}
		if ($num_db_5_6 == "")
		{
			$num_db_5_6 = "-";
		}
		if ($num_ea_5_6 == "")
		{
			$num_ea_5_6 = "-";
		}
		if ($num_eb_5_6 == "")
		{
			$num_eb_5_6 = "-";
		}	

  //5학년7반
		$sql_5_7= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE5."' AND str_class='".$STR_CLASS7."'";


		//echo "sql_1:$sql_1";exit;

		$data_5_7 = $DB->sqlFetch($sql_5_7);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_5_7 = $data_5_7['num_aa'];
		$num_ab_5_7 = $data_5_7['num_ab'];
		$num_ba_5_7 = $data_5_7['num_ba'];
		$num_bb_5_7 = $data_5_7['num_bb'];
		$num_ca_5_7 = $data_5_7['num_ca'];
		$num_cb_5_7 = $data_5_7['num_cb'];
		$num_da_5_7 = $data_5_7['num_da'];
		$num_db_5_7 = $data_5_7['num_db'];
		$num_ea_5_7 = $data_5_7['num_ea'];
		$num_eb_5_7 = $data_5_7['num_eb'];

		if ($num_aa_5_7 == "")
		{
			$num_aa_5_7 = "-";
		}
		if ($num_ab_5_7 == "")
		{
			$num_ab_5_7 = "-";
		}
		if ($num_ba_5_7 == "")
		{
			$num_ba_5_7 = "-";
		}
		if ($num_bb_5_7 == "")
		{
			$num_bb_5_7 = "-";
		}
		if ($num_ca_5_7 == "")
		{
			$num_ca_5_7 = "-";
		}
		if ($num_cb_5_7 == "")
		{
			$num_cb_5_7 = "-";
		}
		if ($num_da_5_7 == "")
		{
			$num_da_5_7= "-";
		}
		if ($num_db_5_7 == "")
		{
			$num_db_5_7 = "-";
		}
		if ($num_ea_5_7 == "")
		{
			$num_ea_5_7 = "-";
		}
		if ($num_eb_5_7 == "")
		{
			$num_eb_5_7 = "-";
		}	


  //5학년8반
		$sql_5_8= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE5."' AND str_class='".$STR_CLASS8."'";


		//echo "sql_1:$sql_1";exit;

		$data_5_8 = $DB->sqlFetch($sql_5_8);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_5_8 = $data_5_8['num_aa'];
		$num_ab_5_8 = $data_5_8['num_ab'];
		$num_ba_5_8 = $data_5_8['num_ba'];
		$num_bb_5_8 = $data_5_8['num_bb'];
		$num_ca_5_8 = $data_5_8['num_ca'];
		$num_cb_5_8 = $data_5_8['num_cb'];
		$num_da_5_8 = $data_5_8['num_da'];
		$num_db_5_8 = $data_5_8['num_db'];
		$num_ea_5_8 = $data_5_8['num_ea'];
		$num_eb_5_8 = $data_5_8['num_eb'];

		if ($num_aa_5_8 == "")
		{
			$num_aa_5_8 = "-";
		}
		if ($num_ab_5_8 == "")
		{
			$num_ab_5_8 = "-";
		}
		if ($num_ba_5_8 == "")
		{
			$num_ba_5_8 = "-";
		}
		if ($num_bb_5_8 == "")
		{
			$num_bb_5_8 = "-";
		}
		if ($num_ca_5_8 == "")
		{
			$num_ca_5_8 = "-";
		}
		if ($num_cb_5_8 == "")
		{
			$num_cb_5_8 = "-";
		}
		if ($num_da_5_8 == "")
		{
			$num_da_5_8= "-";
		}
		if ($num_db_5_8 == "")
		{
			$num_db_5_8 = "-";
		}
		if ($num_ea_5_8 == "")
		{
			$num_ea_5_8 = "-";
		}
		if ($num_eb_5_8 == "")
		{
			$num_eb_5_8 = "-";
		}	


  //5학년9반
		$sql_5_9= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE5."' AND str_class='".$STR_CLASS9."'";


		//echo "sql_1:$sql_1";exit;

		$data_5_9 = $DB->sqlFetch($sql_5_9);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_5_9 = $data_5_9['num_aa'];
		$num_ab_5_9 = $data_5_9['num_ab'];
		$num_ba_5_9 = $data_5_9['num_ba'];
		$num_bb_5_9 = $data_5_9['num_bb'];
		$num_ca_5_9 = $data_5_9['num_ca'];
		$num_cb_5_9 = $data_5_9['num_cb'];
		$num_da_5_9 = $data_5_9['num_da'];
		$num_db_5_9 = $data_5_9['num_db'];
		$num_ea_5_9 = $data_5_9['num_ea'];
		$num_eb_5_9 = $data_5_9['num_eb'];

		if ($num_aa_5_9 == "")
		{
			$num_aa_5_9 = "-";
		}
		if ($num_ab_5_9 == "")
		{
			$num_ab_5_9 = "-";
		}
		if ($num_ba_5_9 == "")
		{
			$num_ba_5_9 = "-";
		}
		if ($num_bb_5_9 == "")
		{
			$num_bb_5_9 = "-";
		}
		if ($num_ca_5_9 == "")
		{
			$num_ca_5_9 = "-";
		}
		if ($num_cb_5_9 == "")
		{
			$num_cb_5_9 = "-";
		}
		if ($num_da_5_9 == "")
		{
			$num_da_5_9= "-";
		}
		if ($num_db_5_9 == "")
		{
			$num_db_5_9 = "-";
		}
		if ($num_ea_5_9 == "")
		{
			$num_ea_5_9 = "-";
		}
		if ($num_eb_5_9 == "")
		{
			$num_eb_5_9 = "-";
		}	



        //5학년10반
		$sql_5_10= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE5."' AND str_class='".$STR_CLASS10."'";


		//echo "sql_1:$sql_1";exit;

		$data_5_10 = $DB->sqlFetch($sql_5_10);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_5_10 = $data_5_10['num_aa'];
		$num_ab_5_10 = $data_5_10['num_ab'];
		$num_ba_5_10 = $data_5_10['num_ba'];
		$num_bb_5_10 = $data_5_10['num_bb'];
		$num_ca_5_10 = $data_5_10['num_ca'];
		$num_cb_5_10 = $data_5_10['num_cb'];
		$num_da_5_10 = $data_5_10['num_da'];
		$num_db_5_10 = $data_5_10['num_db'];
		$num_ea_5_10 = $data_5_10['num_ea'];
		$num_eb_5_10 = $data_5_10['num_eb'];

		if ($num_aa_5_10 == "")
		{
			$num_aa_5_10 = "-";
		}
		if ($num_ab_5_10 == "")
		{
			$num_ab_5_10 = "-";
		}
		if ($num_ba_5_10 == "")
		{
			$num_ba_5_10 = "-";
		}
		if ($num_bb_5_10 == "")
		{
			$num_bb_5_10 = "-";
		}
		if ($num_ca_5_10 == "")
		{
			$num_ca_5_10 = "-";
		}
		if ($num_cb_5_10 == "")
		{
			$num_cb_5_10 = "-";
		}
		if ($num_da_5_10 == "")
		{
			$num_da_5_10= "-";
		}
		if ($num_db_5_10 == "")
		{
			$num_db_5_10 = "-";
		}
		if ($num_ea_5_10 == "")
		{
			$num_ea_5_10 = "-";
		}
		if ($num_eb_5_10 == "")
		{
			$num_eb_5_10 = "-";
		}	

		###################   6   학   년 #############################
       //6학년1반
		$sql_6_1= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE6."' AND str_class='".$STR_CLASS1."'";


		//echo "sql_1:$sql_1";exit;

		$data_6_1 = $DB->sqlFetch($sql_6_1);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_6_1 = $data_6_1['num_aa'];
		$num_ab_6_1 = $data_6_1['num_ab'];
		$num_ba_6_1 = $data_6_1['num_ba'];
		$num_bb_6_1 = $data_6_1['num_bb'];
		$num_ca_6_1 = $data_6_1['num_ca'];
		$num_cb_6_1 = $data_6_1['num_cb'];
		$num_da_6_1 = $data_6_1['num_da'];
		$num_db_6_1 = $data_6_1['num_db'];
		$num_ea_6_1 = $data_6_1['num_ea'];
		$num_eb_6_1 = $data_6_1['num_eb'];

		if ($num_aa_6_1 == "")
		{
			$num_aa_6_1 = "-";
		}
		if ($num_ab_6_1 == "")
		{
			$num_ab_6_1 = "-";
		}
		if ($num_ba_6_1 == "")
		{
			$num_ba_6_1 = "-";
		}
		if ($num_bb_6_1 == "")
		{
			$num_bb_6_1 = "-";
		}
		if ($num_ca_6_1 == "")
		{
			$num_ca_6_1 = "-";
		}
		if ($num_cb_6_1 == "")
		{
			$num_cb_6_1 = "-";
		}
		if ($num_da_6_1 == "")
		{
			$num_da_6_1= "-";
		}
		if ($num_db_6_1 == "")
		{
			$num_db_6_1 = "-";
		}
		if ($num_ea_6_1 == "")
		{
			$num_ea_6_1 = "-";
		}
		if ($num_eb_6_1 == "")
		{
			$num_eb_6_1 = "-";
		}	

		//6학년2반
		$sql_6_2= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE6."' AND str_class='".$STR_CLASS2."'";


		//echo "sql_1:$sql_1";exit;

		$data_6_2 = $DB->sqlFetch($sql_6_2);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_6_2 = $data_6_2['num_aa'];
		$num_ab_6_2 = $data_6_2['num_ab'];
		$num_ba_6_2 = $data_6_2['num_ba'];
		$num_bb_6_2 = $data_6_2['num_bb'];
		$num_ca_6_2 = $data_6_2['num_ca'];
		$num_cb_6_2 = $data_6_2['num_cb'];
		$num_da_6_2 = $data_6_2['num_da'];
		$num_db_6_2 = $data_6_2['num_db'];
		$num_ea_6_2 = $data_6_2['num_ea'];
		$num_eb_6_2 = $data_6_2['num_eb'];

		if ($num_aa_6_2 == "")
		{
			$num_aa_6_2 = "-";
		}
		if ($num_ab_6_2 == "")
		{
			$num_ab_6_2 = "-";
		}
		if ($num_ba_6_2 == "")
		{
			$num_ba_6_2 = "-";
		}
		if ($num_bb_6_2 == "")
		{
			$num_bb_6_2 = "-";
		}
		if ($num_ca_6_2 == "")
		{
			$num_ca_6_2 = "-";
		}
		if ($num_cb_6_2 == "")
		{
			$num_cb_6_2 = "-";
		}
		if ($num_da_6_2 == "")
		{
			$num_da_6_2= "-";
		}
		if ($num_db_6_2 == "")
		{
			$num_db_6_2 = "-";
		}
		if ($num_ea_6_2 == "")
		{
			$num_ea_6_2 = "-";
		}
		if ($num_eb_6_2 == "")
		{
			$num_eb_6_2 = "-";
		}	


		//6학년3반
		$sql_6_3= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE6."' AND str_class='".$STR_CLASS3."'";


		//echo "sql_1:$sql_1";exit;

		$data_6_3 = $DB->sqlFetch($sql_6_3);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_6_3 = $data_6_3['num_aa'];
		$num_ab_6_3 = $data_6_3['num_ab'];
		$num_ba_6_3 = $data_6_3['num_ba'];
		$num_bb_6_3 = $data_6_3['num_bb'];
		$num_ca_6_3 = $data_6_3['num_ca'];
		$num_cb_6_3 = $data_6_3['num_cb'];
		$num_da_6_3 = $data_6_3['num_da'];
		$num_db_6_3 = $data_6_3['num_db'];
		$num_ea_6_3 = $data_6_3['num_ea'];
		$num_eb_6_3 = $data_6_3['num_eb'];

		if ($num_aa_6_3 == "")
		{
			$num_aa_6_3 = "-";
		}
		if ($num_ab_6_3 == "")
		{
			$num_ab_6_3 = "-";
		}
		if ($num_ba_6_3 == "")
		{
			$num_ba_6_3 = "-";
		}
		if ($num_bb_6_3 == "")
		{
			$num_bb_6_3 = "-";
		}
		if ($num_ca_6_3 == "")
		{
			$num_ca_6_3 = "-";
		}
		if ($num_cb_6_3 == "")
		{
			$num_cb_6_3 = "-";
		}
		if ($num_da_6_3 == "")
		{
			$num_da_6_3= "-";
		}
		if ($num_db_6_3 == "")
		{
			$num_db_6_3 = "-";
		}
		if ($num_ea_6_3 == "")
		{
			$num_ea_6_3 = "-";
		}
		if ($num_eb_6_3 == "")
		{
			$num_eb_6_3 = "-";
		}	

		//6학년4반
		$sql_6_4= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE6."' AND str_class='".$STR_CLASS4."'";


		//echo "sql_1:$sql_1";exit;

		$data_6_4 = $DB->sqlFetch($sql_6_4);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_6_4 = $data_6_4['num_aa'];
		$num_ab_6_4 = $data_6_4['num_ab'];
		$num_ba_6_4 = $data_6_4['num_ba'];
		$num_bb_6_4 = $data_6_4['num_bb'];
		$num_ca_6_4 = $data_6_4['num_ca'];
		$num_cb_6_4 = $data_6_4['num_cb'];
		$num_da_6_4 = $data_6_4['num_da'];
		$num_db_6_4 = $data_6_4['num_db'];
		$num_ea_6_4 = $data_6_4['num_ea'];
		$num_eb_6_4 = $data_6_4['num_eb'];

		if ($num_aa_6_4 == "")
		{
			$num_aa_6_4 = "-";
		}
		if ($num_ab_6_4 == "")
		{
			$num_ab_6_4 = "-";
		}
		if ($num_ba_6_4 == "")
		{
			$num_ba_6_4 = "-";
		}
		if ($num_bb_6_4 == "")
		{
			$num_bb_6_4 = "-";
		}
		if ($num_ca_6_4 == "")
		{
			$num_ca_6_4 = "-";
		}
		if ($num_cb_6_4 == "")
		{
			$num_cb_6_4 = "-";
		}
		if ($num_da_6_4 == "")
		{
			$num_da_6_4= "-";
		}
		if ($num_db_6_4 == "")
		{
			$num_db_6_4 = "-";
		}
		if ($num_ea_6_4 == "")
		{
			$num_ea_6_4 = "-";
		}
		if ($num_eb_6_4 == "")
		{
			$num_eb_6_4 = "-";
		}	


       //6학년5반
		$sql_6_5= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE6."' AND str_class='".$STR_CLASS5."'";


		//echo "sql_1:$sql_1";exit;

		$data_6_5 = $DB->sqlFetch($sql_6_5);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_6_5 = $data_6_5['num_aa'];
		$num_ab_6_5 = $data_6_5['num_ab'];
		$num_ba_6_5 = $data_6_5['num_ba'];
		$num_bb_6_5 = $data_6_5['num_bb'];
		$num_ca_6_5 = $data_6_5['num_ca'];
		$num_cb_6_5 = $data_6_5['num_cb'];
		$num_da_6_5 = $data_6_5['num_da'];
		$num_db_6_5 = $data_6_5['num_db'];
		$num_ea_6_5 = $data_6_5['num_ea'];
		$num_eb_6_5 = $data_6_5['num_eb'];

		if ($num_aa_6_5 == "")
		{
			$num_aa_6_5 = "-";
		}
		if ($num_ab_6_5 == "")
		{
			$num_ab_6_5 = "-";
		}
		if ($num_ba_6_5 == "")
		{
			$num_ba_6_5 = "-";
		}
		if ($num_bb_6_5 == "")
		{
			$num_bb_6_5 = "-";
		}
		if ($num_ca_6_5 == "")
		{
			$num_ca_6_5 = "-";
		}
		if ($num_cb_6_5 == "")
		{
			$num_cb_6_5 = "-";
		}
		if ($num_da_6_5 == "")
		{
			$num_da_6_5= "-";
		}
		if ($num_db_6_5 == "")
		{
			$num_db_6_5 = "-";
		}
		if ($num_ea_6_5 == "")
		{
			$num_ea_6_5 = "-";
		}
		if ($num_eb_6_5 == "")
		{
			$num_eb_6_5 = "-";
		}	


		//6학년6반
		$sql_6_6= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE6."' AND str_class='".$STR_CLASS6."'";


		//echo "sql_1:$sql_1";exit;

		$data_6_6 = $DB->sqlFetch($sql_6_6);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_6_6 = $data_6_6['num_aa'];
		$num_ab_6_6 = $data_6_6['num_ab'];
		$num_ba_6_6 = $data_6_6['num_ba'];
		$num_bb_6_6 = $data_6_6['num_bb'];
		$num_ca_6_6 = $data_6_6['num_ca'];
		$num_cb_6_6 = $data_6_6['num_cb'];
		$num_da_6_6 = $data_6_6['num_da'];
		$num_db_6_6 = $data_6_6['num_db'];
		$num_ea_6_6 = $data_6_6['num_ea'];
		$num_eb_6_6 = $data_6_6['num_eb'];

		if ($num_aa_6_6 == "")
		{
			$num_aa_6_6 = "-";
		}
		if ($num_ab_6_6 == "")
		{
			$num_ab_6_6 = "-";
		}
		if ($num_ba_6_6 == "")
		{
			$num_ba_6_6 = "-";
		}
		if ($num_bb_6_6 == "")
		{
			$num_bb_6_6 = "-";
		}
		if ($num_ca_6_6 == "")
		{
			$num_ca_6_6 = "-";
		}
		if ($num_cb_6_6 == "")
		{
			$num_cb_6_6 = "-";
		}
		if ($num_da_6_6 == "")
		{
			$num_da_6_6= "-";
		}
		if ($num_db_6_6 == "")
		{
			$num_db_6_6 = "-";
		}
		if ($num_ea_6_6 == "")
		{
			$num_ea_6_6 = "-";
		}
		if ($num_eb_6_6 == "")
		{
			$num_eb_6_6 = "-";
		}	

		//6학년7반
		$sql_6_7= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE6."' AND str_class='".$STR_CLASS7."'";


		//echo "sql_1:$sql_1";exit;

		$data_6_7 = $DB->sqlFetch($sql_6_7);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_6_7 = $data_6_7['num_aa'];
		$num_ab_6_7 = $data_6_7['num_ab'];
		$num_ba_6_7 = $data_6_7['num_ba'];
		$num_bb_6_7 = $data_6_7['num_bb'];
		$num_ca_6_7 = $data_6_7['num_ca'];
		$num_cb_6_7 = $data_6_7['num_cb'];
		$num_da_6_7 = $data_6_7['num_da'];
		$num_db_6_7 = $data_6_7['num_db'];
		$num_ea_6_7 = $data_6_7['num_ea'];
		$num_eb_6_7 = $data_6_7['num_eb'];

		if ($num_aa_6_7 == "")
		{
			$num_aa_6_7 = "-";
		}
		if ($num_ab_6_7 == "")
		{
			$num_ab_6_7 = "-";
		}
		if ($num_ba_6_7 == "")
		{
			$num_ba_6_7 = "-";
		}
		if ($num_bb_6_7 == "")
		{
			$num_bb_6_7 = "-";
		}
		if ($num_ca_6_7 == "")
		{
			$num_ca_6_7 = "-";
		}
		if ($num_cb_6_7 == "")
		{
			$num_cb_6_7 = "-";
		}
		if ($num_da_6_7 == "")
		{
			$num_da_6_7= "-";
		}
		if ($num_db_6_7 == "")
		{
			$num_db_6_7 = "-";
		}
		if ($num_ea_6_7 == "")
		{
			$num_ea_6_7 = "-";
		}
		if ($num_eb_6_7 == "")
		{
			$num_eb_6_7 = "-";
		}	

		//6학년8반
		$sql_6_8= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE6."' AND str_class='".$STR_CLASS8."'";


		//echo "sql_1:$sql_1";exit;

		$data_6_8 = $DB->sqlFetch($sql_6_8);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_6_8 = $data_6_8['num_aa'];
		$num_ab_6_8 = $data_6_8['num_ab'];
		$num_ba_6_8 = $data_6_8['num_ba'];
		$num_bb_6_8 = $data_6_8['num_bb'];
		$num_ca_6_8 = $data_6_8['num_ca'];
		$num_cb_6_8 = $data_6_8['num_cb'];
		$num_da_6_8 = $data_6_8['num_da'];
		$num_db_6_8 = $data_6_8['num_db'];
		$num_ea_6_8 = $data_6_8['num_ea'];
		$num_eb_6_8 = $data_6_8['num_eb'];

		if ($num_aa_6_8 == "")
		{
			$num_aa_6_8 = "-";
		}
		if ($num_ab_6_8 == "")
		{
			$num_ab_6_8 = "-";
		}
		if ($num_ba_6_8 == "")
		{
			$num_ba_6_8 = "-";
		}
		if ($num_bb_6_8 == "")
		{
			$num_bb_6_8 = "-";
		}
		if ($num_ca_6_8 == "")
		{
			$num_ca_6_8 = "-";
		}
		if ($num_cb_6_8 == "")
		{
			$num_cb_6_8 = "-";
		}
		if ($num_da_6_8 == "")
		{
			$num_da_6_8= "-";
		}
		if ($num_db_6_8 == "")
		{
			$num_db_6_8 = "-";
		}
		if ($num_ea_6_8 == "")
		{
			$num_ea_6_8 = "-";
		}
		if ($num_eb_6_8 == "")
		{
			$num_eb_6_8 = "-";
		}	



	//6학년9반
		$sql_6_9= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE6."' AND str_class='".$STR_CLASS9."'";


		//echo "sql_1:$sql_1";exit;

		$data_6_9 = $DB->sqlFetch($sql_6_9);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_6_9 = $data_6_9['num_aa'];
		$num_ab_6_9 = $data_6_9['num_ab'];
		$num_ba_6_9 = $data_6_9['num_ba'];
		$num_bb_6_9 = $data_6_9['num_bb'];
		$num_ca_6_9 = $data_6_9['num_ca'];
		$num_cb_6_9 = $data_6_9['num_cb'];
		$num_da_6_9 = $data_6_9['num_da'];
		$num_db_6_9 = $data_6_9['num_db'];
		$num_ea_6_9 = $data_6_9['num_ea'];
		$num_eb_6_9 = $data_6_9['num_eb'];

		if ($num_aa_6_9 == "")
		{
			$num_aa_6_9 = "-";
		}
		if ($num_ab_6_9 == "")
		{
			$num_ab_6_9 = "-";
		}
		if ($num_ba_6_9 == "")
		{
			$num_ba_6_9 = "-";
		}
		if ($num_bb_6_9 == "")
		{
			$num_bb_6_9 = "-";
		}
		if ($num_ca_6_9 == "")
		{
			$num_ca_6_9 = "-";
		}
		if ($num_cb_6_9 == "")
		{
			$num_cb_6_9 = "-";
		}
		if ($num_da_6_9 == "")
		{
			$num_da_6_9= "-";
		}
		if ($num_db_6_9 == "")
		{
			$num_db_6_9 = "-";
		}
		if ($num_ea_6_9 == "")
		{
			$num_ea_6_9 = "-";
		}
		if ($num_eb_6_9 == "")
		{
			$num_eb_6_9 = "-";
		}	

	    //6학년10반
		$sql_6_10= "SELECT NUM_DATE, NUM_OID, STR_GRADE, STR_CLASS, NUM_TOTAL, NUM_AA, NUM_AB, NUM_BA, NUM_BB, NUM_CA, NUM_CB, NUM_DA, NUM_DB, NUM_EA, NUM_EB, STR_NAME, STR_ID, STR_TYPE1 FROM ".TAB_ATTENDANCE." WHERE num_oid=$_OID AND num_date='".$dt_date."' AND str_grade='".$STR_GRADE6."' AND str_class='".$STR_CLASS10."'";


		//echo "sql_1:$sql_1";exit;

		$data_6_10 = $DB->sqlFetch($sql_6_10);

		//$Num_oid = $data1['num_oid'];
		//$Str_grade = $data1['str_grade'];
		$num_aa_6_10 = $data_6_10['num_aa'];
		$num_ab_6_10 = $data_6_10['num_ab'];
		$num_ba_6_10 = $data_6_10['num_ba'];
		$num_bb_6_10 = $data_6_10['num_bb'];
		$num_ca_6_10 = $data_6_10['num_ca'];
		$num_cb_6_10 = $data_6_10['num_cb'];
		$num_da_6_10 = $data_6_10['num_da'];
		$num_db_6_10 = $data_6_10['num_db'];
		$num_ea_6_10 = $data_6_10['num_ea'];
		$num_eb_6_10 = $data_6_10['num_eb'];

		if ($num_aa_6_10 == "")
		{
			$num_aa_6_10 = "-";
		}
		if ($num_ab_6_10 == "")
		{
			$num_ab_6_10 = "-";
		}
		if ($num_ba_6_10 == "")
		{
			$num_ba_6_10 = "-";
		}
		if ($num_bb_6_10 == "")
		{
			$num_bb_6_10 = "-";
		}
		if ($num_ca_6_10 == "")
		{
			$num_ca_6_10 = "-";
		}
		if ($num_cb_6_10 == "")
		{
			$num_cb_6_10 = "-";
		}
		if ($num_da_6_10 == "")
		{
			$num_da_6_10= "-";
		}
		if ($num_db_6_10 == "")
		{
			$num_db_6_10 = "-";
		}
		if ($num_ea_6_10 == "")
		{
			$num_ea_6_10 = "-";
		}
		if ($num_eb_6_10 == "")
		{
			$num_eb_6_10 = "-";
		}	

		//출석인수 구하기
		//1학년1반
		$TotalA_1_1 = $num_aa_1_1 - $num_ba_1_1 - $num_ca_1_1 - $num_da_1_1 - $num_ea_1_1; 
		$TotalB_1_1 = $num_ab_1_1 - $num_bb_1_1 - $num_cb_1_1 - $num_db_1_1 - $num_eb_1_1; 
		
		if($TotalA_1_1 == "")
		{	
			$TotalA_1_1 = "-";
		}
		if($TotalB_1_1 == "")
		{	
			$TotalB_1_1 = "-";
		}

	    //1학년2반
		$TotalA_1_2 = $num_aa_1_2 - $num_ba_1_2 - $num_ca_1_2 - $num_da_1_2 - $num_ea_1_2; 
		$TotalB_1_2 = $num_ab_1_2 - $num_bb_1_2 - $num_cb_1_2 - $num_db_1_2 - $num_eb_1_2; 

		if($TotalA_1_2 == "")
		{	
			$TotalA_1_2 = "-";
		}
		if($TotalB_1_2 == "")
		{	
			$TotalB_1_2 = "-";
		}

	    //1학년3반
		$TotalA_1_3 = $num_aa_1_3 - $num_ba_1_3 - $num_ca_1_3 - $num_da_1_3 - $num_ea_1_3; 
		$TotalB_1_3 = $num_ab_1_3 - $num_bb_1_3 - $num_cb_1_3 - $num_db_1_3 - $num_eb_1_3; 

		if($TotalA_1_3 == "")
		{	
			$TotalA_1_3 = "-";
		}
		if($TotalB_1_3 == "")
		{	
			$TotalB_1_3 = "-";
		}
		
		//1학년4반
		$TotalA_1_4 = $num_aa_1_4 - $num_ba_1_4 - $num_ca_1_4 - $num_da_1_4 - $num_ea_1_4; 
		$TotalB_1_4 = $num_ab_1_4 - $num_bb_1_4 - $num_cb_1_4 - $num_db_1_4 - $num_eb_1_4; 

		if($TotalA_1_4 == "")
		{	
			$TotalA_1_4 = "-";
		}
		if($TotalB_1_4 == "")
		{	
			$TotalB_1_4 = "-";
		}
	    //1학년5반
		$TotalA_1_5 = $num_aa_1_5 - $num_ba_1_5 - $num_ca_1_5 - $num_da_1_5 - $num_ea_1_5; 
		$TotalB_1_5 = $num_ab_1_5 - $num_bb_1_5 - $num_cb_1_5 - $num_db_1_5 - $num_eb_1_5; 
		###############################
		if($TotalA_1_5 == "")
		{	
			$TotalA_1_5 = "-";
		}
		if($TotalB_1_5 == "")
		{	
			$TotalB_1_5 = "-";
		}
	    //1학년6반
		$TotalA_1_6 = $num_aa_1_6 - $num_ba_1_6 - $num_ca_1_6 - $num_da_1_6 - $num_ea_1_6; 
		$TotalB_1_6 = $num_ab_1_6 - $num_bb_1_6 - $num_cb_1_6 - $num_db_1_6 - $num_eb_1_6; 
		if($TotalA_1_6 == "")
		{	
			$TotalA_1_6 = "-";
		}
		if($TotalB_1_6 == "")
		{	
			$TotalB_1_6 = "-";
		}

	    //1학년7반
		$TotalA_1_7 = $num_aa_1_7 - $num_ba_1_7 - $num_ca_1_7 - $num_da_1_7 - $num_ea_1_7; 
		$TotalB_1_7 = $num_ab_1_7 - $num_bb_1_7 - $num_cb_1_7 - $num_db_1_7 - $num_eb_1_7; 
		if($TotalA_1_7 == "")
		{	
			$TotalA_1_7 = "-";
		}
		if($TotalB_1_7 == "")
		{	
			$TotalB_1_7 = "-";
		}
	    //1학년8반
		$TotalA_1_8 = $num_aa_1_8 - $num_ba_1_8 - $num_ca_1_8 - $num_da_1_8 - $num_ea_1_8; 
		$TotalB_1_8 = $num_ab_1_8 - $num_bb_1_8 - $num_cb_1_8 - $num_db_1_8 - $num_eb_1_8; 
		if($TotalA_1_8 == "")
		{	
			$TotalA_1_8 = "-";
		}
		if($TotalB_1_8 == "")
		{	
			$TotalB_1_8 = "-";
		}

	    //1학년9반
		$TotalA_1_9 = $num_aa_1_9 - $num_ba_1_9 - $num_ca_1_9 - $num_da_1_9 - $num_ea_1_9; 
		$TotalB_1_9 = $num_ab_1_9 - $num_bb_1_9 - $num_cb_1_9 - $num_db_1_9 - $num_eb_1_9; 
		if($TotalA_1_9 == "")
		{	
			$TotalA_1_9 = "-";
		}
		if($TotalB_1_9 == "")
		{	
			$TotalB_1_9 = "-";
		}

	    //1학년10반
		$TotalA_1_10 = $num_aa_1_10 - $num_ba_1_10 - $num_ca_1_10 - $num_da_1_10 - $num_ea_1_10; 
		$TotalB_1_10 = $num_ab_1_10 - $num_bb_1_10 - $num_cb_1_10 - $num_db_1_10 - $num_eb_1_10; 
		if($TotalA_1_10 == "")
		{	
			$TotalA_1_10 = "-";
		}
		if($TotalB_1_10 == "")
		{	
			$TotalB_1_10 = "-";
		}

	    //2학년1반
		$TotalA_2_1 = $num_aa_2_1 - $num_ba_2_1 - $num_ca_2_1 - $num_da_2_1 - $num_ea_2_1; 
		$TotalB_2_1 = $num_ab_2_1 - $num_bb_2_1 - $num_cb_2_1 - $num_db_2_1 - $num_eb_2_1; 

		if($TotalA_2_1 == "")
		{	
			$TotalA_2_1 = "-";
		}
		if($TotalB_2_1 == "")
		{	
			$TotalB_2_1 = "-";
		}

	    //2학년2반
		$TotalA_2_2 = $num_aa_2_2 - $num_ba_2_2 - $num_ca_2_2 - $num_da_2_2 - $num_ea_2_2; 
		$TotalB_2_2 = $num_ab_2_2 - $num_bb_2_2 - $num_cb_2_2 - $num_db_2_2 - $num_eb_2_2; 

		if($TotalA_2_2 == "")
		{	
			$TotalA_2_2 = "-";
		}
		if($TotalB_2_2 == "")
		{	
			$TotalB_2_2 = "-";
		}

	    //2학년3반
		$TotalA_2_3 = $num_aa_2_3 - $num_ba_2_3 - $num_ca_2_3 - $num_da_2_3 - $num_ea_2_3; 
		$TotalB_2_3 = $num_ab_2_3 - $num_bb_2_3 - $num_cb_2_3 - $num_db_2_3 - $num_eb_2_3; 
		if($TotalA_2_3 == "")
		{	
			$TotalA_2_3 = "-";
		}
		if($TotalB_2_3 == "")
		{	
			$TotalB_2_3 = "-";
		}
	    //2학년4반
		$TotalA_2_4 = $num_aa_2_4 - $num_ba_2_4 - $num_ca_2_4 - $num_da_2_4 - $num_ea_2_4; 
		$TotalB_2_4 = $num_ab_2_4 - $num_bb_2_4 - $num_cb_2_4 - $num_db_2_4 - $num_eb_2_4; 
		if($TotalA_2_4 == "")
		{	
			$TotalA_2_4 = "-";
		}
		if($TotalB_2_4 == "")
		{	
			$TotalB_2_4 = "-";
		}
		$TotalA_2_5 = $num_aa_2_5 - $num_ba_2_5 - $num_ca_2_5 - $num_da_2_5 - $num_ea_2_5; 
		$TotalB_2_5 = $num_ab_2_5 - $num_bb_2_5 - $num_cb_2_5 - $num_db_2_5 - $num_eb_2_5; 
		if($TotalA_2_5 == "")
		{	
			$TotalA_2_5 = "-";
		}
		if($TotalB_2_5 == "")
		{	
			$TotalB_2_5 = "-";
		}
		$TotalA_2_6 = $num_aa_2_6 - $num_ba_2_6 - $num_ca_2_6 - $num_da_2_6 - $num_ea_2_6; 
		$TotalB_2_6 = $num_ab_2_6 - $num_bb_2_6 - $num_cb_2_6 - $num_db_2_6 - $num_eb_2_6; 
		if($TotalA_2_6 == "")
		{	
			$TotalA_2_6 = "-";
		}
		if($TotalB_2_6 == "")
		{	
			$TotalB_2_6 = "-";
		}
		$TotalA_2_7 = $num_aa_2_7 - $num_ba_2_7 - $num_ca_2_7 - $num_da_2_7 - $num_ea_2_7; 
		$TotalB_2_7 = $num_ab_2_7 - $num_bb_2_7 - $num_cb_2_7 - $num_db_2_7 - $num_eb_2_7; 
		if($TotalA_2_7 == "")
		{	
			$TotalA_2_7 = "-";
		}
		if($TotalB_2_7 == "")
		{	
			$TotalB_2_7 = "-";
		}
		$TotalA_2_8 = $num_aa_2_8 - $num_ba_2_8 - $num_ca_2_8 - $num_da_2_8 - $num_ea_2_8; 
		$TotalB_2_8 = $num_ab_2_8 - $num_bb_2_8 - $num_cb_2_8 - $num_db_2_8 - $num_eb_2_8; 
		if($TotalA_2_8 == "")
		{	
			$TotalA_2_8 = "-";
		}
		if($TotalB_2_8 == "")
		{	
			$TotalB_2_8 = "-";
		}
		$TotalA_2_9 = $num_aa_2_9 - $num_ba_2_9 - $num_ca_2_9 - $num_da_2_9 - $num_ea_2_9; 
		$TotalB_2_9 = $num_ab_2_9 - $num_bb_2_9 - $num_cb_2_9 - $num_db_2_9 - $num_eb_2_9; 
		if($TotalA_2_9 == "")
		{	
			$TotalA_2_9 = "-";
		}
		if($TotalB_2_9 == "")
		{	
			$TotalB_2_9 = "-";
		}
		$TotalA_2_10 = $num_aa_2_10 - $num_ba_2_10 - $num_ca_2_10 - $num_da_2_10 - $num_ea_2_10; 
		$TotalB_2_10 = $num_ab_2_10 - $num_bb_2_10 - $num_cb_2_10 - $num_db_2_10 - $num_eb_2_10; 
		if($TotalA_2_10 == "")
		{	
			$TotalA_2_10 = "-";
		}
		if($TotalB_2_10 == "")
		{	
			$TotalB_2_10 = "-";
		}
		$TotalA_3_1 = $num_aa_3_1 - $num_ba_3_1 - $num_ca_3_1 - $num_da_3_1 - $num_ea_3_1; 
		$TotalB_3_1 = $num_ab_3_1 - $num_bb_3_1 - $num_cb_3_1 - $num_db_3_1 - $num_eb_3_1; 
		if($TotalA_3_1 == "")
		{	
			$TotalA_3_1 = "-";
		}
		if($TotalB_3_1 == "")
		{	
			$TotalB_3_1 = "-";
		}
		$TotalA_3_2 = $num_aa_3_2 - $num_ba_3_2 - $num_ca_3_2 - $num_da_3_2 - $num_ea_3_2; 
		$TotalB_3_2 = $num_ab_3_2 - $num_bb_3_2 - $num_cb_3_2 - $num_db_3_2 - $num_eb_3_2; 
		if($TotalA_3_2 == "")
		{	
			$TotalA_3_2 = "-";
		}
		if($TotalB_3_2 == "")
		{	
			$TotalB_3_2 = "-";
		}

		$TotalA_3_3 = $num_aa_3_3 - $num_ba_3_3 - $num_ca_3_3 - $num_da_3_3 - $num_ea_3_3; 
		$TotalB_3_3 = $num_ab_3_3 - $num_bb_3_3 - $num_cb_3_3 - $num_db_3_3 - $num_eb_3_3; 
		if($TotalA_3_3 == "")
		{	
			$TotalA_3_3 = "-";
		}
		if($TotalB_3_3 == "")
		{	
			$TotalB_3_3 = "-";
		}
		$TotalA_3_4 = $num_aa_3_4 - $num_ba_3_4 - $num_ca_3_4 - $num_da_3_4 - $num_ea_3_4; 
		$TotalB_3_4 = $num_ab_3_4 - $num_bb_3_4 - $num_cb_3_4 - $num_db_3_4 - $num_eb_3_4; 
		if($TotalA_3_4 == "")
		{	
			$TotalA_3_4 = "-";
		}
		if($TotalB_3_4 == "")
		{	
			$TotalB_3_4 = "-";
		}
		$TotalA_3_5 = $num_aa_3_5 - $num_ba_3_5 - $num_ca_3_5 - $num_da_3_5 - $num_ea_3_5; 
		$TotalB_3_5 = $num_ab_3_5 - $num_bb_3_5 - $num_cb_3_5 - $num_db_3_5 - $num_eb_3_5; 
		if($TotalA_3_5 == "")
		{	
			$TotalA_3_5 = "-";
		}
		if($TotalB_3_5 == "")
		{	
			$TotalB_3_5 = "-";
		}
		$TotalA_3_6 = $num_aa_3_6 - $num_ba_3_6 - $num_ca_3_6 - $num_da_3_6 - $num_ea_3_6; 
		$TotalB_3_6 = $num_ab_3_6 - $num_bb_3_6 - $num_cb_3_6 - $num_db_3_6 - $num_eb_3_6; 
		if($TotalA_3_6 == "")
		{	
			$TotalA_3_6 = "-";
		}
		if($TotalB_3_6 == "")
		{	
			$TotalB_3_6 = "-";
		}
		$TotalA_3_7 = $num_aa_3_7 - $num_ba_3_7 - $num_ca_3_7 - $num_da_3_7 - $num_ea_3_7; 
		$TotalB_3_7 = $num_ab_3_7 - $num_bb_3_7 - $num_cb_3_7 - $num_db_3_7 - $num_eb_3_7; 
		if($TotalA_3_7 == "")
		{	
			$TotalA_3_7 = "-";
		}
		if($TotalB_3_7 == "")
		{	
			$TotalB_3_7 = "-";
		}
		$TotalA_3_8 = $num_aa_3_8 - $num_ba_3_8 - $num_ca_3_8 - $num_da_3_8 - $num_ea_3_8; 
		$TotalB_3_8 = $num_ab_3_8 - $num_bb_3_8 - $num_cb_3_8 - $num_db_3_8 - $num_eb_3_8; 
		if($TotalA_3_8 == "")
		{	
			$TotalA_3_8 = "-";
		}
		if($TotalB_3_8 == "")
		{	
			$TotalB_3_8 = "-";
		}
		$TotalA_3_9 = $num_aa_3_9 - $num_ba_3_9 - $num_ca_3_9 - $num_da_3_9 - $num_ea_3_9; 
		$TotalB_3_9 = $num_ab_3_9 - $num_bb_3_9 - $num_cb_3_9 - $num_db_3_9 - $num_eb_3_9; 
		if($TotalA_3_9 == "")
		{	
			$TotalA_3_9 = "-";
		}
		if($TotalB_3_9 == "")
		{	
			$TotalB_3_9 = "-";
		}
		$TotalA_3_10 = $num_aa_3_10 - $num_ba_3_10 - $num_ca_3_10 - $num_da_3_10 - $num_ea_3_10; 
		$TotalB_3_10 = $num_ab_3_10 - $num_bb_3_10 - $num_cb_3_10 - $num_db_3_10 - $num_eb_3_10; 
		if($TotalA_3_10 == "")
		{	
			$TotalA_3_10 = "-";
		}
		if($TotalB_3_10 == "")
		{	
			$TotalB_3_10 = "-";
		}
		$TotalA_4_1 = $num_aa_4_1 - $num_ba_4_1 - $num_ca_4_1 - $num_da_4_1 - $num_ea_4_1; 
		$TotalB_4_1 = $num_ab_4_1 - $num_bb_4_1 - $num_cb_4_1 - $num_db_4_1 - $num_eb_4_1; 
		if($TotalA_4_1 == "")
		{	
			$TotalA_4_1 = "-";
		}
		if($TotalB_4_1 == "")
		{	
			$TotalB_4_1 = "-";
		}

		$TotalA_4_2 = $num_aa_4_2 - $num_ba_4_2 - $num_ca_4_2 - $num_da_4_2 - $num_ea_4_2; 
		$TotalB_4_2 = $num_ab_4_2 - $num_bb_4_2 - $num_cb_4_2 - $num_db_4_2 - $num_eb_4_2; 
		if($TotalA_4_2 == "")
		{	
			$TotalA_4_2 = "-";
		}
		if($TotalB_4_2 == "")
		{	
			$TotalB_4_2 = "-";
		}
		$TotalA_4_3 = $num_aa_4_3 - $num_ba_4_3 - $num_ca_4_3 - $num_da_4_3 - $num_ea_4_3; 
		$TotalB_4_3 = $num_ab_4_3 - $num_bb_4_3 - $num_cb_4_3 - $num_db_4_3 - $num_eb_4_3; 
				if($TotalA_4_3 == "")
		{	
			$TotalA_4_3 = "-";
		}
		if($TotalB_4_3 == "")
		{	
			$TotalB_4_3 = "-";
		}
		$TotalA_4_4 = $num_aa_4_4 - $num_ba_4_4 - $num_ca_4_4 - $num_da_4_4 - $num_ea_4_4; 
		$TotalB_4_4 = $num_ab_4_4 - $num_bb_4_4 - $num_cb_4_4 - $num_db_4_4 - $num_eb_4_4; 
		if($TotalA_4_4 == "")
		{	
			$TotalA_4_4 = "-";
		}
		if($TotalB_4_4 == "")
		{	
			$TotalB_4_4 = "-";
		}
		$TotalA_4_5 = $num_aa_4_5 - $num_ba_4_5 - $num_ca_4_5 - $num_da_4_5 - $num_ea_4_5; 
		$TotalB_4_5 = $num_ab_4_5 - $num_bb_4_5 - $num_cb_4_5 - $num_db_4_5 - $num_eb_4_5; 
		if($TotalA_4_5 == "")
		{	
			$TotalA_4_5 = "-";
		}
		if($TotalB_4_5 == "")
		{	
			$TotalB_4_5 = "-";
		}
		$TotalA_4_6 = $num_aa_4_6 - $num_ba_4_6 - $num_ca_4_6 - $num_da_4_6 - $num_ea_4_6; 
		$TotalB_4_6 = $num_ab_4_6 - $num_bb_4_6 - $num_cb_4_6 - $num_db_4_6 - $num_eb_4_6; 
		if($TotalA_4_6 == "")
		{	
			$TotalA_4_6 = "-";
		}
		if($TotalB_4_6 == "")
		{	
			$TotalB_4_6 = "-";
		}
		$TotalA_4_7 = $num_aa_4_7 - $num_ba_4_7 - $num_ca_4_7 - $num_da_4_7 - $num_ea_4_7; 
		$TotalB_4_7 = $num_ab_4_7 - $num_bb_4_7 - $num_cb_4_7 - $num_db_4_7 - $num_eb_4_7; 
		if($TotalA_4_7 == "")
		{	
			$TotalA_4_7 = "-";
		}
		if($TotalB_4_7 == "")
		{	
			$TotalB_4_7 = "-";
		}
		$TotalA_4_8 = $num_aa_4_8 - $num_ba_4_8 - $num_ca_4_8 - $num_da_4_8 - $num_ea_4_8; 
		$TotalB_4_8 = $num_ab_4_8 - $num_bb_4_8 - $num_cb_4_8 - $num_db_4_8 - $num_eb_4_8; 
		if($TotalA_4_8 == "")
		{	
			$TotalA_4_8 = "-";
		}
		if($TotalB_4_8 == "")
		{	
			$TotalB_4_8 = "-";
		}
		$TotalA_4_9 = $num_aa_4_9 - $num_ba_4_9 - $num_ca_4_9 - $num_da_4_9 - $num_ea_4_9; 
		$TotalB_4_9 = $num_ab_4_9 - $num_bb_4_9 - $num_cb_4_9 - $num_db_4_9 - $num_eb_4_9; 
		if($TotalA_4_9 == "")
		{	
			$TotalA_4_9 = "-";
		}
		if($TotalB_4_9 == "")
		{	
			$TotalB_4_9 = "-";
		}
		$TotalA_4_10 = $num_aa_4_10 - $num_ba_4_10 - $num_ca_4_10 - $num_da_4_10 - $num_ea_4_10; 
		$TotalB_4_10 = $num_ab_4_10 - $num_bb_4_10 - $num_cb_4_10 - $num_db_4_10 - $num_eb_4_10; 
		if($TotalA_4_10 == "")
		{	
			$TotalA_4_10 = "-";
		}
		if($TotalB_4_10 == "")
		{	
			$TotalB_4_10 = "-";
		}
		$TotalA_5_1 = $num_aa_5_1 - $num_ba_5_1 - $num_ca_5_1 - $num_da_5_1 - $num_ea_5_1; 
		$TotalB_5_1 = $num_ab_5_1 - $num_bb_5_1 - $num_cb_5_1 - $num_db_5_1 - $num_eb_5_1; 
		if($TotalA_5_1 == "")
		{	
			$TotalA_5_1 = "-";
		}
		if($TotalB_5_1 == "")
		{	
			$TotalB_5_1 = "-";
		}
		$TotalA_5_2 = $num_aa_5_2 - $num_ba_5_2 - $num_ca_5_2 - $num_da_5_2 - $num_ea_5_2; 
		$TotalB_5_2 = $num_ab_5_2 - $num_bb_5_2 - $num_cb_5_2 - $num_db_5_2 - $num_eb_5_2; 
		if($TotalA_5_2 == "")
		{	
			$TotalA_5_2 = "-";
		}
		if($TotalB_5_2 == "")
		{	
			$TotalB_5_2 = "-";
		}
		$TotalA_5_3 = $num_aa_5_3 - $num_ba_5_3 - $num_ca_5_3 - $num_da_5_3 - $num_ea_5_3; 
		$TotalB_5_3 = $num_ab_5_3 - $num_bb_5_3 - $num_cb_5_3 - $num_db_5_3 - $num_eb_5_3; 
		if($TotalA_5_3 == "")
		{	
			$TotalA_5_3 = "-";
		}
		if($TotalB_5_3 == "")
		{	
			$TotalB_5_3 = "-";
		}
		$TotalA_5_4 = $num_aa_5_4 - $num_ba_5_4 - $num_ca_5_4 - $num_da_5_4 - $num_ea_5_4; 
		$TotalB_5_4 = $num_ab_5_4 - $num_bb_5_4 - $num_cb_5_4 - $num_db_5_4 - $num_eb_5_4; 
		if($TotalA_5_4 == "")
		{	
			$TotalA_5_4 = "-";
		}
		if($TotalB_5_4 == "")
		{	
			$TotalB_5_4 = "-";
		}
		$TotalA_5_5 = $num_aa_5_5 - $num_ba_5_5 - $num_ca_5_5 - $num_da_5_5 - $num_ea_5_5; 
		$TotalB_5_5 = $num_ab_5_5 - $num_bb_5_5 - $num_cb_5_5 - $num_db_5_5 - $num_eb_5_5; 
		if($TotalA_5_5 == "")
		{	
			$TotalA_5_5 = "-";
		}
		if($TotalB_5_5 == "")
		{	
			$TotalB_5_5 = "-";
		}
		$TotalA_5_6 = $num_aa_5_6 - $num_ba_5_6 - $num_ca_5_6 - $num_da_5_6 - $num_ea_5_6; 
		$TotalB_5_6 = $num_ab_5_6 - $num_bb_5_6 - $num_cb_5_6 - $num_db_5_6 - $num_eb_5_6; 
		if($TotalA_5_6 == "")
		{	
			$TotalA_5_6 = "-";
		}
		if($TotalB_5_6 == "")
		{	
			$TotalB_5_6 = "-";
		}
		$TotalA_5_7 = $num_aa_5_7 - $num_ba_5_7 - $num_ca_5_7 - $num_da_5_7 - $num_ea_5_7; 
		$TotalB_5_7 = $num_ab_5_7 - $num_bb_5_7 - $num_cb_5_7 - $num_db_5_7 - $num_eb_5_7; 
		if($TotalA_5_7 == "")
		{	
			$TotalA_5_7 = "-";
		}
		if($TotalB_5_7 == "")
		{	
			$TotalB_5_7 = "-";
		}
		$TotalA_5_8 = $num_aa_5_8 - $num_ba_5_8 - $num_ca_5_8 - $num_da_5_8 - $num_ea_5_8; 
		$TotalB_5_8 = $num_ab_5_8 - $num_bb_5_8 - $num_cb_5_8 - $num_db_5_8 - $num_eb_5_8; 
		if($TotalA_5_8 == "")
		{	
			$TotalA_5_8 = "-";
		}
		if($TotalB_5_8 == "")
		{	
			$TotalB_5_8 = "-";
		}
		$TotalA_5_9 = $num_aa_5_9 - $num_ba_5_9 - $num_ca_5_9 - $num_da_5_9 - $num_ea_5_9; 
		$TotalB_5_9 = $num_ab_5_9 - $num_bb_5_9 - $num_cb_5_9 - $num_db_5_9 - $num_eb_5_9; 
		if($TotalA_5_9 == "")
		{	
			$TotalA_5_9 = "-";
		}
		if($TotalB_5_9 == "")
		{	
			$TotalB_5_9 = "-";
		}
		$TotalA_5_10 = $num_aa_5_10 - $num_ba_5_10 - $num_ca_5_10 - $num_da_5_10 - $num_ea_5_10; 
		$TotalB_5_10 = $num_ab_5_10 - $num_bb_5_10 - $num_cb_5_10 - $num_db_5_10 - $num_eb_5_10; 
		if($TotalA_5_10 == "")
		{	
			$TotalA_5_10 = "-";
		}
		if($TotalB_5_10 == "")
		{	
			$TotalB_5_10 = "-";
		}
		$TotalA_6_1 = $num_aa_6_1 - $num_ba_6_1 - $num_ca_6_1 - $num_da_6_1 - $num_ea_6_1; 
		$TotalB_6_1 = $num_ab_6_1 - $num_bb_6_1 - $num_cb_6_1 - $num_db_6_1 - $num_eb_6_1; 
		if($TotalA_6_1 == "")
		{	
			$TotalA_6_1 = "-";
		}
		if($TotalB_6_1 == "")
		{	
			$TotalB_6_1 = "-";
		}
		$TotalA_6_2 = $num_aa_6_2 - $num_ba_6_2 - $num_ca_6_2 - $num_da_6_2 - $num_ea_6_2; 
		$TotalB_6_2 = $num_ab_6_2 - $num_bb_6_2 - $num_cb_6_2 - $num_db_6_2 - $num_eb_6_2; 
		if($TotalA_6_2 == "")
		{	
			$TotalA_6_2 = "-";
		}
		if($TotalB_6_2 == "")
		{	
			$TotalB_6_2 = "-";
		}
		$TotalA_6_3 = $num_aa_6_3 - $num_ba_6_3 - $num_ca_6_3 - $num_da_6_3 - $num_ea_6_3; 
		$TotalB_6_3 = $num_ab_6_3 - $num_bb_6_3 - $num_cb_6_3 - $num_db_6_3 - $num_eb_6_3; 
		if($TotalA_6_3 == "")
		{	
			$TotalA_6_3 = "-";
		}
		if($TotalB_6_3 == "")
		{	
			$TotalB_6_3 = "-";
		}
		$TotalA_6_4 = $num_aa_6_4 - $num_ba_6_4 - $num_ca_6_4 - $num_da_6_4 - $num_ea_6_4; 
		$TotalB_6_4 = $num_ab_6_4 - $num_bb_6_4 - $num_cb_6_4 - $num_db_6_4 - $num_eb_6_4; 
		if($TotalA_6_4 == "")
		{	
			$TotalA_6_4 = "-";
		}
		if($TotalB_6_4 == "")
		{	
			$TotalB_6_4 = "-";
		}
		$TotalA_6_5 = $num_aa_6_5 - $num_ba_6_5 - $num_ca_6_5 - $num_da_6_5 - $num_ea_6_5; 
		$TotalB_6_5 = $num_ab_6_5 - $num_bb_6_5 - $num_cb_6_5 - $num_db_6_5 - $num_eb_6_5; 
		if($TotalA_6_5 == "")
		{	
			$TotalA_6_5 = "-";
		}
		if($TotalB_6_5 == "")
		{	
			$TotalB_6_5 = "-";
		}
		$TotalA_6_6 = $num_aa_6_6 - $num_ba_6_6 - $num_ca_6_6 - $num_da_6_6 - $num_ea_6_6; 
		$TotalB_6_6 = $num_ab_6_6 - $num_bb_6_6 - $num_cb_6_6 - $num_db_6_6 - $num_eb_6_6; 
		if($TotalA_6_6 == "")
		{	
			$TotalA_6_6 = "-";
		}
		if($TotalB_6_6 == "")
		{	
			$TotalB_6_6 = "-";
		}
		$TotalA_6_7 = $num_aa_6_7 - $num_ba_6_7 - $num_ca_6_7 - $num_da_6_7 - $num_ea_6_7; 
		$TotalB_6_7 = $num_ab_6_7 - $num_bb_6_7 - $num_cb_6_7 - $num_db_6_7 - $num_eb_6_7; 
		if($TotalA_6_7 == "")
		{	
			$TotalA_6_7 = "-";
		}
		if($TotalB_6_7 == "")
		{	
			$TotalB_6_7 = "-";
		}
		$TotalA_6_8 = $num_aa_6_8 - $num_ba_6_8 - $num_ca_6_8 - $num_da_6_8 - $num_ea_6_8; 
		$TotalB_6_8 = $num_ab_6_8 - $num_bb_6_8 - $num_cb_6_8 - $num_db_6_8 - $num_eb_6_8; 
		if($TotalA_6_8 == "")
		{	
			$TotalA_6_8 = "-";
		}
		if($TotalB_6_8 == "")
		{	
			$TotalB_6_8 = "-";
		}

		$TotalA_6_9 = $num_aa_6_9 - $num_ba_6_9 - $num_ca_6_9 - $num_da_6_9 - $num_ea_6_9; 
		$TotalB_6_9 = $num_ab_6_9 - $num_bb_6_9 - $num_cb_6_9 - $num_db_6_9 - $num_eb_6_9; 
		if($TotalA_6_9 == "")
		{	
			$TotalA_6_9 = "-";
		}
		if($TotalB_6_9 == "")
		{	
			$TotalB_6_9 = "-";
		}
		$TotalA_6_10 = $num_aa_6_10 - $num_ba_6_10 - $num_ca_6_10 - $num_da_6_10 - $num_ea_6_10; 
		$TotalB_6_10 = $num_ab_6_10 - $num_bb_6_10 - $num_cb_6_10 - $num_db_6_10 - $num_eb_6_10; 
		if($TotalA_6_10 == "")
		{	
			$TotalA_6_10 = "-";
		}
		if($TotalB_6_10 == "")
		{	
			$TotalB_6_10 = "-";
		}

		//1학년 남 재적 총원
		$Total_num_a_1_boy = $num_aa_1_1+$num_aa_1_2+$num_aa_1_3+$num_aa_1_4+$num_aa_1_5+$num_aa_1_6+$num_aa_1_7+$num_aa_1_8+$num_aa_1_9+$num_aa_1_10;
		//1학년 여 재적 총원
		$Total_num_a_1_girl = $num_ab_1_1+$num_ab_1_2+$num_ab_1_3+$num_ab_1_4+$num_ab_1_5+$num_ab_1_6+$num_ab_1_7+$num_ab_1_8+$num_ab_1_9+$num_ab_1_10;
		$Total_num_a_1 = $Total_num_a_1_boy+$Total_num_a_1_girl;
		
		//2학년 남 재적 총원
		$Total_num_a_2_boy = $num_aa_2_1+$num_aa_2_2+$num_aa_2_3+$num_aa_2_4+$num_aa_2_5+$num_aa_2_6+$num_aa_2_7+$num_aa_2_8+$num_aa_2_9+$num_aa_2_10;
		//2학년 여 재적 총원
		$Total_num_a_2_girl = $num_ab_2_1+$num_ab_2_2+$num_ab_2_3+$num_ab_2_4+$num_ab_2_5+$num_ab_2_6+$num_ab_2_7+$num_ab_2_8+$num_ab_2_9+$num_ab_2_10;
		$Total_num_a_2 = $Total_num_a_2_boy+$Total_num_a_2_girl;

		//3학년 남 재적 총원
		$Total_num_a_3_boy = $num_aa_3_1+$num_aa_3_2+$num_aa_3_3+$num_aa_3_4+$num_aa_3_5+$num_aa_3_6+$num_aa_3_7+$num_aa_3_8+$num_aa_3_9+$num_aa_3_10;
		//3학년 여 재적 총원
		$Total_num_a_3_girl = $num_ab_3_1+$num_ab_3_2+$num_ab_3_3+$num_ab_3_4+$num_ab_3_5+$num_ab_3_6+$num_ab_3_7+$num_ab_3_8+$num_ab_3_9+$num_ab_3_10;
		$Total_num_a_3 = $Total_num_a_3_boy+$Total_num_a_3_girl;

		//4학년 남 재적 총원
		$Total_num_a_4_boy = $num_aa_4_1+$num_aa_4_2+$num_aa_4_3+$num_aa_4_4+$num_aa_4_5+$num_aa_4_6+$num_aa_4_7+$num_aa_4_8+$num_aa_4_9+$num_aa_4_10;
		//4학년 여 재적 총원
		$Total_num_a_4_girl = $num_ab_4_1+$num_ab_4_2+$num_ab_4_3+$num_ab_4_4+$num_ab_4_5+$num_ab_4_6+$num_ab_4_7+$num_ab_4_8+$num_ab_4_9+$num_ab_4_10;
		$Total_num_a_4 = $Total_num_a_4_boy+$Total_num_a_4_girl;

		//5학년 남 재적 총원
		$Total_num_a_5_boy = $num_aa_5_1+$num_aa_5_2+$num_aa_5_3+$num_aa_5_4+$num_aa_5_5+$num_aa_5_6+$num_aa_5_7+$num_aa_5_8+$num_aa_5_9+$num_aa_5_10;
		//5학년 여 재적 총원
		$Total_num_a_5_girl = $num_ab_5_1+$num_ab_5_2+$num_ab_5_3+$num_ab_5_4+$num_ab_5_5+$num_ab_5_6+$num_ab_5_7+$num_ab_5_8+$num_ab_5_9+$num_ab_5_10;
		$Total_num_a_5 = $Total_num_a_5_boy+$Total_num_a_5_girl;

		//6학년 남 재적 총원
		$Total_num_a_6_boy = $num_aa_6_1+$num_aa_6_2+$num_aa_6_3+$num_aa_6_4+$num_aa_6_5+$num_aa_6_6+$num_aa_6_7+$num_aa_6_8+$num_aa_6_9+$num_aa_6_10;
		//6학년 여 재적 총원
		$Total_num_a_6_girl = $num_ab_6_1+$num_ab_6_2+$num_ab_6_3+$num_ab_6_4+$num_ab_6_5+$num_ab_6_6+$num_ab_6_7+$num_ab_6_8+$num_ab_6_9+$num_ab_6_10;
		$Total_num_a_6 = $Total_num_a_6_boy+$Total_num_a_6_girl;

		//전체 남 / 여 재적총원
		$Boy_total_A = $Total_num_a_1_boy+$Total_num_a_2_boy+$Total_num_a_3_boy+$Total_num_a_4_boy+$Total_num_a_5_boy+$Total_num_a_6_boy;
		$Girl_total_A = $Total_num_a_1_girl+$Total_num_a_2_girl+$Total_num_a_3_girl+$Total_num_a_4_girl+$Total_num_a_5_bgirl+$Total_num_a_6_girl;
		$TotalA1 = $Boy_total_A+$Girl_total_A;


		//1학년 남 출석 총원
		$Total_TotalA_1 = $TotalA_1_1+$TotalA_1_2+$TotalA_1_3+$TotalA_1_4+$TotalA_1_5+$TotalA_1_6+$TotalA_1_7+$TotalA_1_8+$TotalA_1_9+$TotalA_1_10;
		//1학년 여 출석 총원
		$Total_TotalB_1 = $TotalB_1_1+$TotalB_1_2+$TotalB_1_3+$TotalB_1_4+$TotalB_1_5+$TotalB_1_6+$TotalA_1_7+$TotalB_1_8+$TotalB_1_9+$TotalB_1_10;
		//1학년 남녀 출석 총원
		$Total_Total1 = $Total_TotalA_1+$Total_TotalB_1;

		//2학년 남 출석 총원
		$Total_TotalA_2 = $TotalA_2_1+$TotalA_2_2+$TotalA_2_3+$TotalA_2_4+$TotalA_2_5+$TotalA_2_6+$TotalA_2_7+$TotalA_2_8+$TotalA_2_9+$TotalA_2_10;
		//2학년 여 출석 총원
		$Total_TotalB_2 = $TotalB_2_1+$TotalB_2_2+$TotalB_2_3+$TotalB_2_4+$TotalB_2_5+$TotalB_2_6+$TotalA_2_7+$TotalB_2_8+$TotalB_2_9+$TotalB_2_10;
		$Total_Total2 = $Total_TotalA_2+$Total_TotalB_2;

		//3학년 남 출석 총원
		$Total_TotalA_3 = $TotalA_3_1+$TotalA_3_2+$TotalA_3_3+$TotalA_3_4+$TotalA_3_5+$TotalA_3_6+$TotalA_3_7+$TotalA_3_8+$TotalA_3_9+$TotalA_3_10;
		//3학년 여 출석 총원
		$Total_TotalB_3 = $TotalB_3_1+$TotalB_3_2+$TotalB_3_3+$TotalB_3_4+$TotalB_3_5+$TotalB_3_6+$TotalA_3_7+$TotalB_3_8+$TotalB_3_9+$TotalB_3_10;
		$Total_Total3 = $Total_TotalA_3+$Total_TotalB_3;

		//4학년 남 출석 총원
		$Total_TotalA_4 = $TotalA_4_1+$TotalA_4_2+$TotalA_4_3+$TotalA_4_4+$TotalA_4_5+$TotalA_4_6+$TotalA_4_7+$TotalA_4_8+$TotalA_4_9+$TotalA_4_10;
		//4학년 여 출석 총원
		$Total_TotalB_4 = $TotalB_4_1+$TotalB_4_2+$TotalB_4_3+$TotalB_4_4+$TotalB_4_5+$TotalB_4_6+$TotalA_4_7+$TotalB_4_8+$TotalB_4_9+$TotalB_4_10;
		$Total_Total4 = $Total_TotalA_4+$Total_TotalB_4;

		//5학년 남 출석 총원
		$Total_TotalA_5 = $TotalA_5_1+$TotalA_5_2+$TotalA_5_3+$TotalA_5_4+$TotalA_5_5+$TotalA_5_6+$TotalA_5_7+$TotalA_5_8+$TotalA_5_9+$TotalA_5_10;
		//5학년 여 출석 총원
		$Total_TotalB_5 = $TotalB_5_1+$TotalB_5_2+$TotalB_5_3+$TotalB_5_4+$TotalB_5_5+$TotalB_5_6+$TotalA_5_7+$TotalB_5_8+$TotalB_5_9+$TotalB_5_10;
		$Total_Total5 = $Total_TotalA_5+$Total_TotalB_5;

		//6학년 남 출석 총원
		$Total_TotalA_6 = $TotalA_6_1+$TotalA_6_2+$TotalA_6_3+$TotalA_6_4+$TotalA_6_5+$TotalA_6_6+$TotalA_6_7+$TotalA_6_8+$TotalA_6_9+$TotalA_6_10;
		//6학년 여 출석 총원
		$Total_TotalB_6 = $TotalB_6_1+$TotalB_6_2+$TotalB_6_3+$TotalB_6_4+$TotalB_6_5+$TotalB_6_6+$TotalA_6_7+$TotalB_6_8+$TotalB_6_9+$TotalB_6_10;
		$Total_Total6 = $Total_TotalA_6+$Total_TotalB_6;

		//전체 남 / 여 출석총원
		$culsuk_A = $Total_TotalA_1+$Total_TotalA_2+$Total_TotalA_3+$Total_TotalA_4+$Total_TotalA_5+$Total_TotalA_6;
		$culsuk_B = $Total_TotalB_1+$Total_TotalB_2+$Total_TotalB_3+$Total_TotalB_4+$Total_TotalB_5+$Total_TotalB_6;
		$Total_culsuk = $culsuk_A+$culsuk_B;

		//1학년 남 결석 총원
		$Total_num_b_1_boy = $num_ba_1_1+$num_ba_1_2+$num_ba_1_3+$num_ba_1_4+$num_ba_1_5+$num_ba_1_6+$num_ba_1_7+$num_ba_1_8+$num_ba_1_9+$num_ba_1_10;
		//1학년 여 결석총원
		$Total_num_b_1_girl = $num_bb_1_1+$num_bb_1_2+$num_bb_1_3+$num_bb_1_4+$num_bb_1_5+$num_bb_1_6+$num_bb_1_7+$num_bb_1_8+$num_bb_1_9+$num_bb_1_10;
		$Total_num_b_1 = $Total_num_b_1_boy+$Total_num_b_1_girl;


		//2학년 남 결석 총원
		$Total_num_b_2_boy = $num_ba_2_1+$num_ba_2_2+$num_ba_2_3+$num_ba_2_4+$num_ba_2_5+$num_ba_2_6+$num_ba_2_7+$num_ba_2_8+$num_ba_2_9+$num_ba_2_10;
		//2학년 여 결석총원
		$Total_num_b_2_girl = $num_bb_2_1+$num_bb_2_2+$num_bb_2_3+$num_bb_2_4+$num_bb_2_5+$num_bb_2_6+$num_bb_2_7+$num_bb_2_8+$num_bb_2_9+$num_bb_2_10;
		$Total_num_b_2 = $Total_num_b_2_boy+$Total_num_b_2_girl;


		//3학년 남 결석 총원
		$Total_num_b_3_boy = $num_ba_3_1+$num_ba_3_2+$num_ba_3_3+$num_ba_3_4+$num_ba_3_5+$num_ba_3_6+$num_ba_3_7+$num_ba_3_8+$num_ba_3_9+$num_ba_3_10;
		//2학년 여 결석총원
		$Total_num_b_3_girl = $num_bb_3_1+$num_bb_3_2+$num_bb_3_3+$num_bb_3_4+$num_bb_3_5+$num_bb_3_6+$num_bb_3_7+$num_bb_3_8+$num_bb_3_9+$num_bb_3_10;
		$Total_num_b_3 = $Total_num_b_3_boy+$Total_num_b_3_girl;


		//4학년 남 결석 총원
		$Total_num_b_4_boy = $num_ba_4_1+$num_ba_4_2+$num_ba_4_3+$num_ba_4_4+$num_ba_4_5+$num_ba_4_6+$num_ba_4_7+$num_ba_4_8+$num_ba_4_9+$num_ba_4_10;
		//4학년 여 결석총원
		$Total_num_b_4_girl = $num_bb_4_1+$num_bb_4_2+$num_bb_4_3+$num_bb_4_4+$num_bb_4_5+$num_bb_4_6+$num_bb_4_7+$num_bb_4_8+$num_bb_4_9+$num_bb_4_10;
		$Total_num_b_4 = $Total_num_b_4_boy+$Total_num_b_4_girl;


		//5학년 남 결석 총원
		$Total_num_b_5_boy = $num_ba_5_1+$num_ba_5_2+$num_ba_5_3+$num_ba_5_4+$num_ba_5_5+$num_ba_5_6+$num_ba_5_7+$num_ba_5_8+$num_ba_5_9+$num_ba_5_10;
		//5학년 여 결석총원
		$Total_num_b_5_girl = $num_bb_5_1+$num_bb_5_2+$num_bb_5_3+$num_bb_5_4+$num_bb_5_5+$num_bb_5_6+$num_bb_5_7+$num_bb_5_8+$num_bb_5_9+$num_bb_5_10;
		$Total_num_b_5 = $Total_num_b_5_boy+$Total_num_b_5_girl;


		//6학년 남 결석 총원
		$Total_num_b_6_boy = $num_ba_6_1+$num_ba_6_2+$num_ba_6_3+$num_ba_6_4+$num_ba_6_5+$num_ba_6_6+$num_ba_6_7+$num_ba_6_8+$num_ba_6_9+$num_ba_6_10;
		//5학년 여 결석총원
		$Total_num_b_6_girl = $num_bb_6_1+$num_bb_6_2+$num_bb_6_3+$num_bb_6_4+$num_bb_6_5+$num_bb_6_6+$num_bb_6_7+$num_bb_6_8+$num_bb_6_9+$num_bb_6_10;
		$Total_num_b_6 = $Total_num_b_6_boy+$Total_num_b_6_girl;


		//전체 남 / 여 결석총원
		$Boy_total_B = $Total_num_b_1_boy+$Total_num_b_2_boy+$Total_num_b_3_boy+$Total_num_b_4_boy+$Total_num_b_5_boy+$Total_num_b_6_boy;
		$Girl_total_B = $Total_num_b_1_girl+$Total_num_b_2_girl+$Total_num_b_3_girl+$Total_num_b_4_girl+$Total_num_b_5_bgirl+$Total_num_b_6_girl;
		$TotalB1 = $Boy_total_B+$Girl_total_B;

		//1학년 남 조퇴 총원
		$Total_num_c_1_boy=
		$num_ca_1_1+$num_ca_1_2+$num_ca_1_3+$num_ca_1_4+$num_ca_1_5+$num_ca_1_6+$num_ca_1_7+$num_ca_1_8+$num_ca_1_9+$num_ca_1_10;
		//1학년 여 조퇴 총원
		$Total_num_c_1_girl=
		$num_cb_1_1+$num_cb_1_2+$num_cb_1_3+$num_cb_1_4+$num_cb_1_5+$num_cb_1_6+$num_cb_1_7+$num_cb_1_8+$num_cb_1_9+$num_cb_1_10;
		$Total_num_c_1 = $Total_num_c_1_boy+$Total_num_c_1_girl;


		//2학년 남 조퇴 총원
		$Total_num_c_2_boy=
		$num_ca_2_1+$num_ca_2_2+$num_ca_2_3+$num_ca_2_4+$num_ca_2_5+$num_ca_2_6+$num_ca_2_7+$num_ca_2_8+$num_ca_2_9+$num_ca_2_10;
		//2학년 여 조퇴 총원
		$Total_num_c_2_girl=
		$num_cb_2_1+$num_cb_2_2+$num_cb_2_3+$num_cb_2_4+$num_cb_2_5+$num_cb_2_6+$num_cb_2_7+$num_cb_2_8+$num_cb_2_9+$num_cb_2_10;
		$Total_num_c_2 = $Total_num_c_2_boy+$Total_num_c_2_girl;

		//3학년 남 조퇴 총원
		$Total_num_c_3_boy=
		$num_ca_3_1+$num_ca_3_2+$num_ca_3_3+$num_ca_3_4+$num_ca_3_5+$num_ca_3_6+$num_ca_3_7+$num_ca_3_8+$num_ca_3_9+$num_ca_3_10;
		//3학년 여 조퇴 총원
		$Total_num_c_3_girl=
		$num_cb_3_1+$num_cb_3_2+$num_cb_3_3+$num_cb_3_4+$num_cb_3_5+$num_cb_3_6+$num_cb_3_7+$num_cb_3_8+$num_cb_3_9+$num_cb_3_10;
		$Total_num_c_3 = $Total_num_c_3_boy+$Total_num_c_3_girl;

		//4학년 남 조퇴 총원
		$Total_num_c_4_boy=
		$num_ca_4_1+$num_ca_4_2+$num_ca_4_3+$num_ca_4_4+$num_ca_4_5+$num_ca_4_6+$num_ca_4_7+$num_ca_4_8+$num_ca_4_9+$num_ca_4_10;
		//4학년 여 조퇴 총원
		$Total_num_c_4_girl=
		$num_cb_4_1+$num_cb_4_2+$num_cb_4_3+$num_cb_4_4+$num_cb_4_5+$num_cb_4_6+$num_cb_4_7+$num_cb_4_8+$num_cb_4_9+$num_cb_4_10;
		$Total_num_c_4 = $Total_num_c_4_boy+$Total_num_c_4_girl;

		//5학년 남 조퇴 총원
		$Total_num_c_5_boy=
		$num_ca_5_1+$num_ca_5_2+$num_ca_5_3+$num_ca_5_4+$num_ca_5_5+$num_ca_5_6+$num_ca_5_7+$num_ca_5_8+$num_ca_5_9+$num_ca_5_10;
		//1학년 여 조퇴 총원
		$Total_num_c_5_girl=
		$num_cb_5_1+$num_cb_5_2+$num_cb_5_3+$num_cb_5_4+$num_cb_5_5+$num_cb_5_6+$num_cb_5_7+$num_cb_5_8+$num_cb_5_9+$num_cb_5_10;
		$Total_num_c_5 = $Total_num_c_5_boy+$Total_num_c_5_girl;

		//6학년 남 조퇴 총원
		$Total_num_c_6_boy=
		$num_ca_6_1+$num_ca_6_2+$num_ca_6_3+$num_ca_6_4+$num_ca_6_5+$num_ca_6_6+$num_ca_6_7+$num_ca_6_8+$num_ca_6_9+$num_ca_6_10;
		//6학년 여 조퇴 총원
		$Total_num_c_6_girl=
		$num_cb_6_1+$num_cb_6_2+$num_cb_6_3+$num_cb_6_4+$num_cb_6_5+$num_cb_6_6+$num_cb_6_7+$num_cb_6_8+$num_cb_6_9+$num_cb_6_10;
		$Total_num_c_6 = $Total_num_c_6_boy+$Total_num_c_6_girl;

		//전체 남 / 여 조퇴총원
		$Boy_total_C = $Total_num_c_1_boy+$Total_num_c_2_boy+$Total_num_c_3_boy+$Total_num_c_4_boy+$Total_num_c_5_boy+$Total_num_c_6_boy;
		$Girl_total_C = $Total_num_c_1_girl+$Total_num_c_2_girl+$Total_num_c_3_girl+$Total_num_c_4_girl+$Total_num_c_5_bgirl+$Total_num_c_6_girl;
		$TotalC1 = $Boy_total_C+$Girl_total_C;


		//1학년 남 전입 총원
		$Total_num_d_1_boy=
		$num_da_1_1+$num_da_1_2+$num_da_1_3+$num_da_1_4+$num_da_1_5+$num_da_1_6+$num_da_1_7+$num_da_1_8+$num_da_1_9+$num_da_1_10;
		//1학년 여 전입 총원
		$Total_num_d_1_girl=
		$num_db_1_1+$num_db_1_2+$num_db_1_3+$num_db_1_4+$num_db_1_5+$num_db_1_6+$num_db_1_7+$num_db_1_8+$num_db_1_9+$num_db_1_10;
		$Total_num_d_1 = $Total_num_d_1_boy+$Total_num_d_1_girl;

		//2학년 남 전입 총원
		$Total_num_d_2_boy=
		$num_da_2_1+$num_da_2_2+$num_da_2_3+$num_da_2_4+$num_da_2_5+$num_da_2_6+$num_da_2_7+$num_da_2_8+$num_da_2_9+$num_da_2_10;
		//2학년 여 전입 총원
		$Total_num_d_2_girl=
		$num_db_2_1+$num_db_2_2+$num_db_2_3+$num_db_2_4+$num_db_2_5+$num_db_2_6+$num_db_2_7+$num_db_2_8+$num_db_2_9+$num_db_2_10;
		$Total_num_d_2 = $Total_num_d_2_boy+$Total_num_d_2_girl;

		//3학년 남 전입 총원
		$Total_num_d_3_boy=
		$num_da_3_1+$num_da_3_2+$num_da_3_3+$num_da_3_4+$num_da_3_5+$num_da_3_6+$num_da_3_7+$num_da_3_8+$num_da_3_9+$num_da_3_10;
		//3학년 여 전입 총원
		$Total_num_d_3_girl=
		$num_db_3_1+$num_db_3_2+$num_db_3_3+$num_db_3_4+$num_db_3_5+$num_db_3_6+$num_db_3_7+$num_db_3_8+$num_db_3_9+$num_db_3_10;
		$Total_num_d_3 = $Total_num_d_3_boy+$Total_num_d_3_girl;

		//4학년 남 전입 총원
		$Total_num_d_4_boy=
		$num_da_4_1+$num_da_4_2+$num_da_4_3+$num_da_4_4+$num_da_4_5+$num_da_4_6+$num_da_4_7+$num_da_4_8+$num_da_4_9+$num_da_4_10;
		//4학년 여 전입 총원
		$Total_num_d_4_girl=
		$num_db_4_1+$num_db_4_2+$num_db_4_3+$num_db_4_4+$num_db_4_5+$num_db_4_6+$num_db_4_7+$num_db_4_8+$num_db_4_9+$num_db_4_10;
		$Total_num_d_4 = $Total_num_d_4_boy+$Total_num_d_4_girl;

		//5학년 남 전입 총원
		$Total_num_d_5_boy=
		$num_da_5_1+$num_da_5_2+$num_da_5_3+$num_da_5_4+$num_da_5_5+$num_da_5_6+$num_da_5_7+$num_da_5_8+$num_da_5_9+$num_da_5_10;
		//5학년 여 전입 총원
		$Total_num_d_5_girl=
		$num_db_5_1+$num_db_5_2+$num_db_5_3+$num_db_5_4+$num_db_5_5+$num_db_5_6+$num_db_5_7+$num_db_5_8+$num_db_5_9+$num_db_5_10;
		$Total_num_d_5 = $Total_num_d_5_boy+$Total_num_d_5_girl;
	
		//6학년 남 전입 총원
		$Total_num_d_6_boy=
		$num_da_6_1+$num_da_6_2+$num_da_6_3+$num_da_6_4+$num_da_6_5+$num_da_6_6+$num_da_6_7+$num_da_6_8+$num_da_6_9+$num_da_6_10;
		//6학년 여 전입 총원
		$Total_num_d_6_girl=
		$num_db_6_1+$num_db_6_2+$num_db_6_3+$num_db_6_4+$num_db_6_5+$num_db_6_6+$num_db_6_7+$num_db_6_8+$num_db_6_9+$num_db_6_10;
		$Total_num_d_6 = $Total_num_d_6_boy+$Total_num_d_6_girl;

		//전체 남 / 여 전입총원
		$Boy_total_D = $Total_num_d_1_boy+$Total_num_d_2_boy+$Total_num_d_3_boy+$Total_num_d_4_boy+$Total_num_d_5_boy+$Total_num_d_6_boy;
		$Girl_total_D = $Total_num_d_1_girl+$Total_num_d_2_girl+$Total_num_d_3_girl+$Total_num_d_4_girl+$Total_num_d_5_bgirl+$Total_num_d_6_girl;
		$TotalD1 = $Boy_total_D+$Girl_total_D;




		//1학년 남 전출 총원
		$Total_num_e_1_boy=
		$num_ea_1_1+$num_ea_1_2+$num_ea_1_3+$num_ea_1_4+$num_ea_1_5+$num_ea_1_6+$num_ea_1_7+$num_ea_1_8+$num_ea_1_9+$num_ea_1_10;
		//1학년 여 전출 총원
		$Total_num_e_1_girl=
		$num_eb_1_1+$num_eb_1_2+$num_eb_1_3+$num_eb_1_4+$num_eb_1_5+$num_eb_1_6+$num_eb_1_7+$num_eb_1_8+$num_eb_1_9+$num_eb_1_10;
		$Total_num_e_1 = $Total_num_e_1_boy+$Total_num_e_1_girl;

		//2학년 남 전출 총원
		$Total_num_e_2_boy=
		$num_ea_2_1+$num_ea_2_2+$num_ea_2_3+$num_ea_2_4+$num_ea_2_5+$num_ea_2_6+$num_ea_2_7+$num_ea_2_8+$num_ea_2_9+$num_ea_2_10;
		//2학년 여 전출 총원
		$Total_num_e_2_girl=
		$num_eb_2_1+$num_eb_2_2+$num_eb_2_3+$num_eb_2_4+$num_eb_2_5+$num_eb_2_6+$num_eb_2_7+$num_eb_2_8+$num_eb_2_9+$num_eb_2_10;
		$Total_num_e_2 = $Total_num_e_2_boy+$Total_num_e_2_girl;
		
		
		//3학년 남 전출 총원
		$Total_num_e_3_boy=
		$num_ea_3_1+$num_ea_3_2+$num_ea_3_3+$num_ea_3_4+$num_ea_3_5+$num_ea_3_6+$num_ea_3_7+$num_ea_3_8+$num_ea_3_9+$num_ea_3_10;
		//3학년 여 전출 총원
		$Total_num_e_3_girl=
		$num_eb_3_1+$num_eb_3_2+$num_eb_3_3+$num_eb_3_4+$num_eb_3_5+$num_eb_3_6+$num_eb_3_7+$num_eb_3_8+$num_eb_3_9+$num_eb_3_10;
		$Total_num_e_3 = $Total_num_e_3_boy+$Total_num_e_3_girl;

		//4학년 남 전츨 총원
		$Total_num_e_4_boy=
		$num_ea_4_1+$num_ea_4_2+$num_ea_4_3+$num_ea_4_4+$num_ea_4_5+$num_ea_4_6+$num_ea_4_7+$num_ea_4_8+$num_ea_4_9+$num_ea_4_10;
		//4학년 여 전츨 총원
		$Total_num_e_4_girl=
		$num_eb_4_1+$num_eb_4_2+$num_eb_4_3+$num_eb_4_4+$num_eb_4_5+$num_eb_4_6+$num_eb_4_7+$num_eb_4_8+$num_eb_4_9+$num_eb_4_10;
		$Total_num_e_4 = $Total_num_e_4_boy+$Total_num_e_4_girl;

		//5학년 남 전츨 총원
		$Total_num_e_5_boy=
		$num_ea_5_1+$num_ea_5_2+$num_ea_5_3+$num_ea_5_4+$num_ea_5_5+$num_ea_5_6+$num_ea_5_7+$num_ea_5_8+$num_ea_5_9+$num_ea_5_10;
		//5학년 여 전출 총원
		$Total_num_e_5_girl=
		$num_eb_5_1+$num_eb_5_2+$num_eb_5_3+$num_eb_5_4+$num_eb_5_5+$num_eb_5_6+$num_eb_5_7+$num_eb_5_8+$num_eb_5_9+$num_eb_5_10;
		$Total_num_e_5 = $Total_num_e_5_boy+$Total_num_e_5_girl;

		//6학년 남 전츨 총원
		$Total_num_e_6_boy=
		$num_ea_6_1+$num_ea_6_2+$num_ea_6_3+$num_ea_6_4+$num_ea_6_5+$num_ea_6_6+$num_ea_6_7+$num_ea_6_8+$num_ea_6_9+$num_ea_6_10;
		//6학년 여 전출 총원
		$Total_num_e_6_girl=
		$num_eb_6_1+$num_eb_6_2+$num_eb_6_3+$num_eb_6_4+$num_eb_6_5+$num_eb_6_6+$num_eb_6_7+$num_eb_6_8+$num_eb_36_9+$num_eb_6_10;
		$Total_num_e_6 = $Total_num_e_6_boy+$Total_num_e_6_girl;

		//전체 남 / 여 전출총원
		$Boy_total_E = $Total_num_e_1_boy+$Total_num_e_2_boy+$Total_num_e_3_boy+$Total_num_e_4_boy+$Total_num_e_5_boy+$Total_num_e_6_boy;
		$Girl_total_E = $Total_num_e_1_girl+$Total_num_e_2_girl+$Total_num_e_3_girl+$Total_num_e_4_girl+$Total_num_e_5_bgirl+$Total_num_e_6_girl;
		$TotalE1 = $Boy_total_E+$Girl_total_E;



		$DOC_TITLE = 'str:출결통계';
		$tpl->setLayout('@sub');
		$tpl->define('CONTENT', Display::getTemplate('member/attendance_list.htm'));

		$tpl->assign(array(
			'redir'		=>	$_REQUEST['redir'],
			//'num_date' =>$num_date,
			'dt_date' => $dt_date,
			'num_aa_1_1' =>$num_aa_1_1,
			'num_ab_1_1' =>$num_ab_1_1,
			'num_ba_1_1' =>$num_ba_1_1,
			'num_bb_1_1' =>$num_bb_1_1,
			'num_ca_1_1' =>$num_ca_1_1,
			'num_cb_1_1' =>$num_cb_1_1,
			'num_da_1_1' =>$num_da_1_1,
			'num_db_1_1' =>$num_db_1_1,
			'num_ea_1_1' =>$num_ea_1_1,
			'num_eb_1_1' =>$num_eb_1_1,  //1학년1반

			'num_aa_1_2' =>$num_aa_1_2,
			'num_ab_1_2' =>$num_ab_1_2,
			'num_ba_1_2' =>$num_ba_1_2,
			'num_bb_1_2' =>$num_bb_1_2,
			'num_ca_1_2' =>$num_ca_1_2,
			'num_cb_1_2' =>$num_cb_1_2,
			'num_da_1_2' =>$num_da_1_2,
			'num_db_1_2' =>$num_db_1_2,
			'num_ea_1_2' =>$num_ea_1_2,
			'num_eb_1_2' =>$num_eb_1_2, //1학년2반

			'num_aa_1_3' =>$num_aa_1_3,
			'num_ab_1_3' =>$num_ab_1_3,
			'num_ba_1_3' =>$num_ba_1_3,
			'num_bb_1_3' =>$num_bb_1_3,
			'num_ca_1_3' =>$num_ca_1_3,
			'num_cb_1_3' =>$num_cb_1_3,
			'num_da_1_3' =>$num_da_1_3,
			'num_db_1_3' =>$num_db_1_3,
			'num_ea_1_3' =>$num_ea_1_3,
			'num_eb_1_3' =>$num_eb_1_3,  //1학년3반

			'num_aa_1_4' =>$num_aa_1_4,
			'num_ab_1_4' =>$num_ab_1_4,
			'num_ba_1_4' =>$num_ba_1_4,
			'num_bb_1_4' =>$num_bb_1_4,
			'num_ca_1_4' =>$num_ca_1_4,
			'num_cb_1_4' =>$num_cb_1_4,
			'num_da_1_4' =>$num_da_1_4,
			'num_db_1_4' =>$num_db_1_4,
			'num_ea_1_4' =>$num_ea_1_4,
			'num_eb_1_4' =>$num_eb_1_4,  //1학년4반

			'num_aa_1_5' =>$num_aa_1_5,
			'num_ab_1_5' =>$num_ab_1_5,
			'num_ba_1_5' =>$num_ba_1_5,
			'num_bb_1_5' =>$num_bb_1_5,
			'num_ca_1_5' =>$num_ca_1_5,
			'num_cb_1_5' =>$num_cb_1_5,
			'num_da_1_5' =>$num_da_1_5,
			'num_db_1_5' =>$num_db_1_5,
			'num_ea_1_5' =>$num_ea_1_5,
			'num_eb_1_5' =>$num_eb_1_5,  //1학년5반

			'num_aa_1_6' =>$num_aa_1_6,
			'num_ab_1_6' =>$num_ab_1_6,
			'num_ba_1_6' =>$num_ba_1_6,
			'num_bb_1_6' =>$num_bb_1_6,
			'num_ca_1_6' =>$num_ca_1_6,
			'num_cb_1_6' =>$num_cb_1_6,
			'num_da_1_6' =>$num_da_1_6,
			'num_db_1_6' =>$num_db_1_6,
			'num_ea_1_6' =>$num_ea_1_6,
			'num_eb_1_6' =>$num_eb_1_6, //1학년 6반


			'num_aa_1_7' =>$num_aa_1_7,
			'num_ab_1_7' =>$num_ab_1_7,
			'num_ba_1_7' =>$num_ba_1_7,
			'num_bb_1_7' =>$num_bb_1_7,
			'num_ca_1_7' =>$num_ca_1_7,
			'num_cb_1_7' =>$num_cb_1_7,
			'num_da_1_7' =>$num_da_1_7,
			'num_db_1_7' =>$num_db_1_7,
			'num_ea_1_7' =>$num_ea_1_7,
			'num_eb_1_7' =>$num_eb_1_7,  //1학년7


			'num_aa_1_8' =>$num_aa_1_8,
			'num_ab_1_8' =>$num_ab_1_8,
			'num_ba_1_8' =>$num_ba_1_8,
			'num_bb_1_8' =>$num_bb_1_8,
			'num_ca_1_8' =>$num_ca_1_8,
			'num_cb_1_8' =>$num_cb_1_8,
			'num_da_1_8' =>$num_da_1_8,
			'num_db_1_8' =>$num_db_1_8,
			'num_ea_1_8' =>$num_ea_1_8,
			'num_eb_1_8' =>$num_eb_1_8,  //1학년8반

			'num_aa_1_9' =>$num_aa_1_9,
			'num_ab_1_9' =>$num_ab_1_9,
			'num_ba_1_9' =>$num_ba_1_9,
			'num_bb_1_9' =>$num_bb_1_9,
			'num_ca_1_9' =>$num_ca_1_9,
			'num_cb_1_9' =>$num_cb_1_9,
			'num_da_1_9' =>$num_da_1_9,
			'num_db_1_9' =>$num_db_1_9,
			'num_ea_1_9' =>$num_ea_1_9,
			'num_eb_1_9' =>$num_eb_1_9,  //1학년9반

			'num_aa_1_10' =>$num_aa_1_10,
			'num_ab_1_10' =>$num_ab_1_10,
			'num_ba_1_10' =>$num_ba_1_10,
			'num_bb_1_10' =>$num_bb_1_10,
			'num_ca_1_10' =>$num_ca_1_10,
			'num_cb_1_10' =>$num_cb_1_10,
			'num_da_1_10' =>$num_da_1_10,
			'num_db_1_10' =>$num_db_1_10,
			'num_ea_1_10' =>$num_ea_1_10,
			'num_eb_1_10' =>$num_eb_1_10,  //1학년10반

			'num_aa_2_1' =>$num_aa_2_1,
			'num_ab_2_1' =>$num_ab_2_1,
			'num_ba_2_1' =>$num_ba_2_1,
			'num_bb_2_1' =>$num_bb_2_1,
			'num_ca_2_1' =>$num_ca_2_1,
			'num_cb_2_1' =>$num_cb_2_1,
			'num_da_2_1' =>$num_da_2_1,
			'num_db_2_1' =>$num_db_2_1,
			'num_ea_2_1' =>$num_ea_2_1,
			'num_eb_2_1' =>$num_eb_2_1,  //2학년1반

			'num_aa_2_2' =>$num_aa_2_2,
			'num_ab_2_2' =>$num_ab_2_2,
			'num_ba_2_2' =>$num_ba_2_2,
			'num_bb_2_2' =>$num_bb_2_2,
			'num_ca_2_2' =>$num_ca_2_2,
			'num_cb_2_2' =>$num_cb_2_2,
			'num_da_2_2' =>$num_da_2_2,
			'num_db_2_2' =>$num_db_2_2,
			'num_ea_2_2' =>$num_ea_2_2,
			'num_eb_2_2' =>$num_eb_2_2, 

			'num_aa_2_3' =>$num_aa_2_3,
			'num_ab_2_3' =>$num_ab_2_3,
			'num_ba_2_3' =>$num_ba_2_3,
			'num_bb_2_3' =>$num_bb_2_3,
			'num_ca_2_3' =>$num_ca_2_3,
			'num_cb_2_3' =>$num_cb_2_3,
			'num_da_2_3' =>$num_da_2_3,
			'num_db_2_3' =>$num_db_2_3,
			'num_ea_2_3' =>$num_ea_2_3,
			'num_eb_2_3' =>$num_eb_2_3, 

			'num_aa_2_4' =>$num_aa_2_4,
			'num_ab_2_4' =>$num_ab_2_4,
			'num_ba_2_4' =>$num_ba_2_4,
			'num_bb_2_4' =>$num_bb_2_4,
			'num_ca_2_4' =>$num_ca_2_4,
			'num_cb_2_4' =>$num_cb_2_4,
			'num_da_2_4' =>$num_da_2_4,
			'num_db_2_4' =>$num_db_2_4,
			'num_ea_2_4' =>$num_ea_2_4,
			'num_eb_2_4' =>$num_eb_2_4,
				
			'num_aa_2_5' =>$num_aa_2_5,
			'num_ab_2_5' =>$num_ab_2_5,
			'num_ba_2_5' =>$num_ba_2_5,
			'num_bb_2_5' =>$num_bb_2_5,
			'num_ca_2_5' =>$num_ca_2_5,
			'num_cb_2_5' =>$num_cb_2_5,
			'num_da_2_5' =>$num_da_2_5,
			'num_db_2_5' =>$num_db_2_5,
			'num_ea_2_5' =>$num_ea_2_5,
			'num_eb_2_5' =>$num_eb_2_5,

			'num_aa_2_6' =>$num_aa_2_6,
			'num_ab_2_6' =>$num_ab_2_6,
			'num_ba_2_6' =>$num_ba_2_6,
			'num_bb_2_6' =>$num_bb_2_6,
			'num_ca_2_6' =>$num_ca_2_6,
			'num_cb_2_6' =>$num_cb_2_6,
			'num_da_2_6' =>$num_da_2_6,
			'num_db_2_6' =>$num_db_2_6,
			'num_ea_2_6' =>$num_ea_2_6,
			'num_eb_2_6' =>$num_eb_2_6,
				
			'num_aa_2_7' =>$num_aa_2_7,
			'num_ab_2_7' =>$num_ab_2_7,
			'num_ba_2_7' =>$num_ba_2_7,
			'num_bb_2_7' =>$num_bb_2_7,
			'num_ca_2_7' =>$num_ca_2_7,
			'num_cb_2_7' =>$num_cb_2_7,
			'num_da_2_7' =>$num_da_2_7,
			'num_db_2_7' =>$num_db_2_7,
			'num_ea_2_7' =>$num_ea_2_7,
			'num_eb_2_7' =>$num_eb_2_7,

			'num_aa_2_8' =>$num_aa_2_8,
			'num_ab_2_8' =>$num_ab_2_8,
			'num_ba_2_8' =>$num_ba_2_8,
			'num_bb_2_8' =>$num_bb_2_8,
			'num_ca_2_8' =>$num_ca_2_8,
			'num_cb_2_8' =>$num_cb_2_8,
			'num_da_2_8' =>$num_da_2_8,
			'num_db_2_8' =>$num_db_2_8,
			'num_ea_2_8' =>$num_ea_2_8,
			'num_eb_2_8' =>$num_eb_2_8,

			'num_aa_2_9' =>$num_aa_2_9,
			'num_ab_2_9' =>$num_ab_2_9,
			'num_ba_2_9' =>$num_ba_2_9,
			'num_bb_2_9' =>$num_bb_2_9,
			'num_ca_2_9' =>$num_ca_2_9,
			'num_cb_2_9' =>$num_cb_2_9,
			'num_da_2_9' =>$num_da_2_9,
			'num_db_2_9' =>$num_db_2_9,
			'num_ea_2_9' =>$num_ea_2_9,
			'num_eb_2_9' =>$num_eb_2_9,

			'num_aa_2_10' =>$num_aa_2_10,
			'num_ab_2_10' =>$num_ab_2_10,
			'num_ba_2_10' =>$num_ba_2_10,
			'num_bb_2_10' =>$num_bb_2_10,
			'num_ca_2_10' =>$num_ca_2_10,
			'num_cb_2_10' =>$num_cb_2_10,
			'num_da_2_10' =>$num_da_2_10,
			'num_db_2_10' =>$num_db_2_10,
			'num_ea_2_10' =>$num_ea_2_10,
			'num_eb_2_10' =>$num_eb_2_10,
				
			'num_aa_3_1' =>$num_aa_3_1,
			'num_ab_3_1' =>$num_ab_3_1,
			'num_ba_3_1' =>$num_ba_3_1,
			'num_bb_3_1' =>$num_bb_3_1,
			'num_ca_3_1' =>$num_ca_3_1,
			'num_cb_3_1' =>$num_cb_3_1,
			'num_da_3_1' =>$num_da_3_1,
			'num_db_3_1' =>$num_db_3_1,
			'num_ea_3_1' =>$num_ea_3_1,
			'num_eb_3_1' =>$num_eb_3_1,

			'num_aa_3_2' =>$num_aa_3_2,
			'num_ab_3_2' =>$num_ab_3_2,
			'num_ba_3_2' =>$num_ba_3_2,
			'num_bb_3_2' =>$num_bb_3_2,
			'num_ca_3_2' =>$num_ca_3_2,
			'num_cb_3_2' =>$num_cb_3_2,
			'num_da_3_2' =>$num_da_3_2,
			'num_db_3_2' =>$num_db_3_2,
			'num_ea_3_2' =>$num_ea_3_2,
			'num_eb_3_2' =>$num_eb_3_2,

			'num_aa_3_3' =>$num_aa_3_3,
			'num_ab_3_3' =>$num_ab_3_3,
			'num_ba_3_3' =>$num_ba_3_3,
			'num_bb_3_3' =>$num_bb_3_3,
			'num_ca_3_3' =>$num_ca_3_3,
			'num_cb_3_3' =>$num_cb_3_3,
			'num_da_3_3' =>$num_da_3_3,
			'num_db_3_3' =>$num_db_3_3,
			'num_ea_3_3' =>$num_ea_3_3,
			'num_eb_3_3' =>$num_eb_3_3,

			'num_aa_3_4' =>$num_aa_3_4,
			'num_ab_3_4' =>$num_ab_3_4,
			'num_ba_3_4' =>$num_ba_3_4,
			'num_bb_3_4' =>$num_bb_3_4,
			'num_ca_3_4' =>$num_ca_3_4,
			'num_cb_3_4' =>$num_cb_3_4,
			'num_da_3_4' =>$num_da_3_4,
			'num_db_3_4' =>$num_db_3_4,
			'num_ea_3_4' =>$num_ea_3_4,
			'num_eb_3_4' =>$num_eb_3_4,

			'num_aa_3_5' =>$num_aa_3_5,
			'num_ab_3_5' =>$num_ab_3_5,
			'num_ba_3_5' =>$num_ba_3_5,
			'num_bb_3_5' =>$num_bb_3_5,
			'num_ca_3_5' =>$num_ca_3_5,
			'num_cb_3_5' =>$num_cb_3_5,
			'num_da_3_5' =>$num_da_3_5,
			'num_db_3_5' =>$num_db_3_5,
			'num_ea_3_5' =>$num_ea_3_5,
			'num_eb_3_5' =>$num_eb_3_5,

			'num_aa_3_6' =>$num_aa_3_6,
			'num_ab_3_6' =>$num_ab_3_6,
			'num_ba_3_6' =>$num_ba_3_6,
			'num_bb_3_6' =>$num_bb_3_6,
			'num_ca_3_6' =>$num_ca_3_6,
			'num_cb_3_6' =>$num_cb_3_6,
			'num_da_3_6' =>$num_da_3_6,
			'num_db_3_6' =>$num_db_3_6,
			'num_ea_3_6' =>$num_ea_3_6,
			'num_eb_3_6' =>$num_eb_3_6,

			'num_aa_3_7' =>$num_aa_3_7,
			'num_ab_3_7' =>$num_ab_3_7,
			'num_ba_3_7' =>$num_ba_3_7,
			'num_bb_3_7' =>$num_bb_3_7,
			'num_ca_3_7' =>$num_ca_3_7,
			'num_cb_3_7' =>$num_cb_3_7,
			'num_da_3_7' =>$num_da_3_7,
			'num_db_3_7' =>$num_db_3_7,
			'num_ea_3_7' =>$num_ea_3_7,
			'num_eb_3_7' =>$num_eb_3_7,

			'num_aa_3_8' =>$num_aa_3_8,
			'num_ab_3_8' =>$num_ab_3_8,
			'num_ba_3_8' =>$num_ba_3_8,
			'num_bb_3_8' =>$num_bb_3_8,
			'num_ca_3_8' =>$num_ca_3_8,
			'num_cb_3_8' =>$num_cb_3_8,
			'num_da_3_8' =>$num_da_3_8,
			'num_db_3_8' =>$num_db_3_8,
			'num_ea_3_8' =>$num_ea_3_8,
			'num_eb_3_8' =>$num_eb_3_8,

			'num_aa_3_9' =>$num_aa_3_9,
			'num_ab_3_9' =>$num_ab_3_9,
			'num_ba_3_9' =>$num_ba_3_9,
			'num_bb_3_9' =>$num_bb_3_9,
			'num_ca_3_9' =>$num_ca_3_9,
			'num_cb_3_9' =>$num_cb_3_9,
			'num_da_3_9' =>$num_da_3_9,
			'num_db_3_9' =>$num_db_3_9,
			'num_ea_3_9' =>$num_ea_3_9,
			'num_eb_3_9' =>$num_eb_3_9,

			'num_aa_3_10' =>$num_aa_3_10,
			'num_ab_3_10' =>$num_ab_3_10,
			'num_ba_3_10' =>$num_ba_3_10,
			'num_bb_3_10' =>$num_bb_3_10,
			'num_ca_3_10' =>$num_ca_3_10,
			'num_cb_3_10' =>$num_cb_3_10,
			'num_da_3_10' =>$num_da_3_10,
			'num_db_3_10' =>$num_db_3_10,
			'num_ea_3_10' =>$num_ea_3_10,
			'num_eb_3_10' =>$num_eb_3_10,

			'num_aa_4_1' =>$num_aa_4_1,
			'num_ab_4_1' =>$num_ab_4_1,
			'num_ba_4_1' =>$num_ba_4_1,
			'num_bb_4_1' =>$num_bb_4_1,
			'num_ca_4_1' =>$num_ca_4_1,
			'num_cb_4_1' =>$num_cb_4_1,
			'num_da_4_1' =>$num_da_4_1,
			'num_db_4_1' =>$num_db_4_1,
			'num_ea_4_1' =>$num_ea_4_1,
			'num_eb_4_1' =>$num_eb_4_1,

			'num_aa_4_2' =>$num_aa_4_2,
			'num_ab_4_2' =>$num_ab_4_2,
			'num_ba_4_2' =>$num_ba_4_2,
			'num_bb_4_2' =>$num_bb_4_2,
			'num_ca_4_2' =>$num_ca_4_2,
			'num_cb_4_2' =>$num_cb_4_2,
			'num_da_4_2' =>$num_da_4_2,
			'num_db_4_2' =>$num_db_4_2,
			'num_ea_4_2' =>$num_ea_4_2,
			'num_eb_4_2' =>$num_eb_4_2,

			'num_aa_4_3' =>$num_aa_4_3,
			'num_ab_4_3' =>$num_ab_4_3,
			'num_ba_4_3' =>$num_ba_4_3,
			'num_bb_4_3' =>$num_bb_4_3,
			'num_ca_4_3' =>$num_ca_4_3,
			'num_cb_4_3' =>$num_cb_4_3,
			'num_da_4_3' =>$num_da_4_3,
			'num_db_4_3' =>$num_db_4_3,
			'num_ea_4_3' =>$num_ea_4_3,
			'num_eb_4_3' =>$num_eb_4_3,

			'num_aa_4_4' =>$num_aa_4_4,
			'num_ab_4_4' =>$num_ab_4_4,
			'num_ba_4_4' =>$num_ba_4_4,
			'num_bb_4_4' =>$num_bb_4_4,
			'num_ca_4_4' =>$num_ca_4_4,
			'num_cb_4_4' =>$num_cb_4_4,
			'num_da_4_4' =>$num_da_4_4,
			'num_db_4_4' =>$num_db_4_4,
			'num_ea_4_4' =>$num_ea_4_4,
			'num_eb_4_4' =>$num_eb_4_4,

			'num_aa_4_5' =>$num_aa_4_5,
			'num_ab_4_5' =>$num_ab_4_5,
			'num_ba_4_5' =>$num_ba_4_5,
			'num_bb_4_5' =>$num_bb_4_5,
			'num_ca_4_5' =>$num_ca_4_5,
			'num_cb_4_5' =>$num_cb_4_5,
			'num_da_4_5' =>$num_da_4_5,
			'num_db_4_5' =>$num_db_4_5,
			'num_ea_4_5' =>$num_ea_4_5,
			'num_eb_4_5' =>$num_eb_4_5,

			'num_aa_4_6' =>$num_aa_4_6,
			'num_ab_4_6' =>$num_ab_4_6,
			'num_ba_4_6' =>$num_ba_4_6,
			'num_bb_4_6' =>$num_bb_4_6,
			'num_ca_4_6' =>$num_ca_4_6,
			'num_cb_4_6' =>$num_cb_4_6,
			'num_da_4_6' =>$num_da_4_6,
			'num_db_4_6' =>$num_db_4_6,
			'num_ea_4_6' =>$num_ea_4_6,
			'num_eb_4_6' =>$num_eb_4_6,

			'num_aa_4_7' =>$num_aa_4_7,
			'num_ab_4_7' =>$num_ab_4_7,
			'num_ba_4_7' =>$num_ba_4_7,
			'num_bb_4_7' =>$num_bb_4_7,
			'num_ca_4_7' =>$num_ca_4_7,
			'num_cb_4_7' =>$num_cb_4_7,
			'num_da_4_7' =>$num_da_4_7,
			'num_db_4_7' =>$num_db_4_7,
			'num_ea_4_7' =>$num_ea_4_7,
			'num_eb_4_7' =>$num_eb_4_7,

			'num_aa_4_8' =>$num_aa_4_8,
			'num_ab_4_8' =>$num_ab_4_8,
			'num_ba_4_8' =>$num_ba_4_8,
			'num_bb_4_8' =>$num_bb_4_8,
			'num_ca_4_8' =>$num_ca_4_8,
			'num_cb_4_8' =>$num_cb_4_8,
			'num_da_4_8' =>$num_da_4_8,
			'num_db_4_8' =>$num_db_4_8,
			'num_ea_4_8' =>$num_ea_4_8,
			'num_eb_4_8' =>$num_eb_4_8,

			'num_aa_4_9' =>$num_aa_4_9,
			'num_ab_4_9' =>$num_ab_4_9,
			'num_ba_4_9' =>$num_ba_4_9,
			'num_bb_4_9' =>$num_bb_4_9,
			'num_ca_4_9' =>$num_ca_4_9,
			'num_cb_4_9' =>$num_cb_4_9,
			'num_da_4_9' =>$num_da_4_9,
			'num_db_4_9' =>$num_db_4_9,
			'num_ea_4_9' =>$num_ea_4_9,
			'num_eb_4_9' =>$num_eb_4_9,
			
			'num_aa_4_10' =>$num_aa_4_10,
			'num_ab_4_10' =>$num_ab_4_10,
			'num_ba_4_10' =>$num_ba_4_10,
			'num_bb_4_10' =>$num_bb_4_10,
			'num_ca_4_10' =>$num_ca_4_10,
			'num_cb_4_10' =>$num_cb_4_10,
			'num_da_4_10' =>$num_da_4_10,
			'num_db_4_10' =>$num_db_4_10,
			'num_ea_4_10' =>$num_ea_4_10,
			'num_eb_4_10' =>$num_eb_4_10,

			'num_aa_5_1' =>$num_aa_5_1,
			'num_ab_5_1' =>$num_ab_5_1,
			'num_ba_5_1' =>$num_ba_5_1,
			'num_bb_5_1' =>$num_bb_5_1,
			'num_ca_5_1' =>$num_ca_5_1,
			'num_cb_5_1' =>$num_cb_5_1,
			'num_da_5_1' =>$num_da_5_1,
			'num_db_5_1' =>$num_db_5_1,
			'num_ea_5_1' =>$num_ea_5_1,
			'num_eb_5_1' =>$num_eb_5_1,
			
			'num_aa_5_2' =>$num_aa_5_2,
			'num_ab_5_2' =>$num_ab_5_2,
			'num_ba_5_2' =>$num_ba_5_2,
			'num_bb_5_2' =>$num_bb_5_2,
			'num_ca_5_2' =>$num_ca_5_2,
			'num_cb_5_2' =>$num_cb_5_2,
			'num_da_5_2' =>$num_da_5_2,
			'num_db_5_2' =>$num_db_5_2,
			'num_ea_5_2' =>$num_ea_5_2,
			'num_eb_5_2' =>$num_eb_5_2,

			'num_aa_5_3' =>$num_aa_5_3,
			'num_ab_5_3' =>$num_ab_5_3,
			'num_ba_5_3' =>$num_ba_5_3,
			'num_bb_5_3' =>$num_bb_5_3,
			'num_ca_5_3' =>$num_ca_5_3,
			'num_cb_5_3' =>$num_cb_5_3,
			'num_da_5_3' =>$num_da_5_3,
			'num_db_5_3' =>$num_db_5_3,
			'num_ea_5_3' =>$num_ea_5_3,
			'num_eb_5_3' =>$num_eb_5_3,

			'num_aa_5_4' =>$num_aa_5_4,
			'num_ab_5_4' =>$num_ab_5_4,
			'num_ba_5_4' =>$num_ba_5_4,
			'num_bb_5_4' =>$num_bb_5_4,
			'num_ca_5_4' =>$num_ca_5_4,
			'num_cb_5_4' =>$num_cb_5_4,
			'num_da_5_4' =>$num_da_5_4,
			'num_db_5_4' =>$num_db_5_4,
			'num_ea_5_4' =>$num_ea_5_4,
			'num_eb_5_4' =>$num_eb_5_4,

			'num_aa_5_5' =>$num_aa_5_5,
			'num_ab_5_5' =>$num_ab_5_5,
			'num_ba_5_5' =>$num_ba_5_5,
			'num_bb_5_5' =>$num_bb_5_5,
			'num_ca_5_5' =>$num_ca_5_5,
			'num_cb_5_5' =>$num_cb_5_5,
			'num_da_5_5' =>$num_da_5_5,
			'num_db_5_5' =>$num_db_5_5,
			'num_ea_5_5' =>$num_ea_5_5,
			'num_eb_5_5' =>$num_eb_5_5,

			'num_aa_5_6' =>$num_aa_5_6,
			'num_ab_5_6' =>$num_ab_5_6,
			'num_ba_5_6' =>$num_ba_5_6,
			'num_bb_5_6' =>$num_bb_5_6,
			'num_ca_5_6' =>$num_ca_5_6,
			'num_cb_5_6' =>$num_cb_5_6,
			'num_da_5_6' =>$num_da_5_6,
			'num_db_5_6' =>$num_db_5_6,
			'num_ea_5_6' =>$num_ea_5_6,
			'num_eb_5_6' =>$num_eb_5_6,

			'num_aa_5_7' =>$num_aa_5_7,
			'num_ab_5_7' =>$num_ab_5_7,
			'num_ba_5_7' =>$num_ba_5_7,
			'num_bb_5_7' =>$num_bb_5_7,
			'num_ca_5_7' =>$num_ca_5_7,
			'num_cb_5_7' =>$num_cb_5_7,
			'num_da_5_7' =>$num_da_5_7,
			'num_db_5_7' =>$num_db_5_7,
			'num_ea_5_7' =>$num_ea_5_7,
			'num_eb_5_7' =>$num_eb_5_7,

			'num_aa_5_8' =>$num_aa_5_8,
			'num_ab_5_8' =>$num_ab_5_8,
			'num_ba_5_8' =>$num_ba_5_8,
			'num_bb_5_8' =>$num_bb_5_8,
			'num_ca_5_8' =>$num_ca_5_8,
			'num_cb_5_8' =>$num_cb_5_8,
			'num_da_5_8' =>$num_da_5_8,
			'num_db_5_8' =>$num_db_5_8,
			'num_ea_5_8' =>$num_ea_5_8,
			'num_eb_5_8' =>$num_eb_5_8,

			'num_aa_5_9' =>$num_aa_5_9,
			'num_ab_5_9' =>$num_ab_5_9,
			'num_ba_5_9' =>$num_ba_5_9,
			'num_bb_5_9' =>$num_bb_5_9,
			'num_ca_5_9' =>$num_ca_5_9,
			'num_cb_5_9' =>$num_cb_5_9,
			'num_da_5_9' =>$num_da_5_9,
			'num_db_5_9' =>$num_db_5_9,
			'num_ea_5_9' =>$num_ea_5_9,
			'num_eb_5_9' =>$num_eb_5_9,

			'num_aa_5_10' =>$num_aa_5_10,
			'num_ab_5_10' =>$num_ab_5_10,
			'num_ba_5_10' =>$num_ba_5_10,
			'num_bb_5_10' =>$num_bb_5_10,
			'num_ca_5_10' =>$num_ca_5_10,
			'num_cb_5_10' =>$num_cb_5_10,
			'num_da_5_10' =>$num_da_5_10,
			'num_db_5_10' =>$num_db_5_10,
			'num_ea_5_10' =>$num_ea_5_10,
			'num_eb_5_10' =>$num_eb_5_10,

			'num_aa_6_1' =>$num_aa_6_1,
			'num_ab_6_1' =>$num_ab_6_1,
			'num_ba_6_1' =>$num_ba_6_1,
			'num_bb_6_1' =>$num_bb_6_1,
			'num_ca_6_1' =>$num_ca_6_1,
			'num_cb_6_1' =>$num_cb_6_1,
			'num_da_6_1' =>$num_da_6_1,
			'num_db_6_1' =>$num_db_6_1,
			'num_ea_6_1' =>$num_ea_6_1,
			'num_eb_6_1' =>$num_eb_6_1,

			'num_aa_6_2' =>$num_aa_6_2,
			'num_ab_6_2' =>$num_ab_6_2,
			'num_ba_6_2' =>$num_ba_6_2,
			'num_bb_6_2' =>$num_bb_6_2,
			'num_ca_6_2' =>$num_ca_6_2,
			'num_cb_6_2' =>$num_cb_6_2,
			'num_da_6_2' =>$num_da_6_2,
			'num_db_6_2' =>$num_db_6_2,
			'num_ea_6_2' =>$num_ea_6_2,
			'num_eb_6_2' =>$num_eb_6_2,

			'num_aa_6_3' =>$num_aa_6_3,
			'num_ab_6_3' =>$num_ab_6_3,
			'num_ba_6_3' =>$num_ba_6_3,
			'num_bb_6_3' =>$num_bb_6_3,
			'num_ca_6_3' =>$num_ca_6_3,
			'num_cb_6_3' =>$num_cb_6_3,
			'num_da_6_3' =>$num_da_6_3,
			'num_db_6_3' =>$num_db_6_3,
			'num_ea_6_3' =>$num_ea_6_3,
			'num_eb_6_3' =>$num_eb_6_3,

			'num_aa_6_4' =>$num_aa_6_4,
			'num_ab_6_4' =>$num_ab_6_4,
			'num_ba_6_4' =>$num_ba_6_4,
			'num_bb_6_4' =>$num_bb_6_4,
			'num_ca_6_4' =>$num_ca_6_4,
			'num_cb_6_4' =>$num_cb_6_4,
			'num_da_6_4' =>$num_da_6_4,
			'num_db_6_4' =>$num_db_6_4,
			'num_ea_6_4' =>$num_ea_6_4,
			'num_eb_6_4' =>$num_eb_6_4,

			'num_aa_6_5' =>$num_aa_6_5,
			'num_ab_6_5' =>$num_ab_6_5,
			'num_ba_6_5' =>$num_ba_6_5,
			'num_bb_6_5' =>$num_bb_6_5,
			'num_ca_6_5' =>$num_ca_6_5,
			'num_cb_6_5' =>$num_cb_6_5,
			'num_da_6_5' =>$num_da_6_5,
			'num_db_6_5' =>$num_db_6_5,
			'num_ea_6_5' =>$num_ea_6_5,
			'num_eb_6_5' =>$num_eb_6_5,

			'num_aa_6_6' =>$num_aa_6_6,
			'num_ab_6_6' =>$num_ab_6_6,
			'num_ba_6_6' =>$num_ba_6_6,
			'num_bb_6_6' =>$num_bb_6_6,
			'num_ca_6_6' =>$num_ca_6_6,
			'num_cb_6_6' =>$num_cb_6_6,
			'num_da_6_6' =>$num_da_6_6,
			'num_db_6_6' =>$num_db_6_6,
			'num_ea_6_6' =>$num_ea_6_6,
			'num_eb_6_6' =>$num_eb_6_6,

			'num_aa_6_7' =>$num_aa_6_7,
			'num_ab_6_7' =>$num_ab_6_7,
			'num_ba_6_7' =>$num_ba_6_7,
			'num_bb_6_7' =>$num_bb_6_7,
			'num_ca_6_7' =>$num_ca_6_7,
			'num_cb_6_7' =>$num_cb_6_7,
			'num_da_6_7' =>$num_da_6_7,
			'num_db_6_7' =>$num_db_6_7,
			'num_ea_6_7' =>$num_ea_6_7,
			'num_eb_6_7' =>$num_eb_6_7,


			'num_aa_6_8' =>$num_aa_6_8,
			'num_ab_6_8' =>$num_ab_6_8,
			'num_ba_6_8' =>$num_ba_6_8,
			'num_bb_6_8' =>$num_bb_6_8,
			'num_ca_6_8' =>$num_ca_6_8,
			'num_cb_6_8' =>$num_cb_6_8,
			'num_da_6_8' =>$num_da_6_8,
			'num_db_6_8' =>$num_db_6_8,
			'num_ea_6_8' =>$num_ea_6_8,
			'num_eb_6_8' =>$num_eb_6_8,



			'num_aa_6_9' =>$num_aa_6_9,
			'num_ab_6_9' =>$num_ab_6_9,
			'num_ba_6_9' =>$num_ba_6_9,
			'num_bb_6_9' =>$num_bb_6_9,
			'num_ca_6_9' =>$num_ca_6_9,
			'num_cb_6_9' =>$num_cb_6_9,
			'num_da_6_9' =>$num_da_6_9,
			'num_db_6_9' =>$num_db_6_9,
			'num_ea_6_9' =>$num_ea_6_9,
			'num_eb_6_9' =>$num_eb_6_9,


			'num_aa_6_10' =>$num_aa_6_10,
			'num_ab_6_10' =>$num_ab_6_10,
			'num_ba_6_10' =>$num_ba_6_10,
			'num_bb_6_10' =>$num_bb_6_10,
			'num_ca_6_10' =>$num_ca_6_10,
			'num_cb_6_10' =>$num_cb_6_10,
			'num_da_6_10' =>$num_da_6_10,
			'num_db_6_10' =>$num_db_6_10,
			'num_ea_6_10' =>$num_ea_6_10,
			'num_eb_6_10' =>$num_eb_6_10,

			'TotalA_1_1'=>$TotalA_1_1,
			'TotalB_1_1'=>$TotalB_1_1,
			'TotalA_1_2'=>$TotalA_1_2,
			'TotalB_1_2'=>$TotalB_1_2,	
			'TotalA_1_3'=>$TotalA_1_3,
			'TotalB_1_3'=>$TotalB_1_3,	
			'TotalA_1_4'=>$TotalA_1_4,
			'TotalB_1_4'=>$TotalB_1_4,	
			'TotalA_1_5'=>$TotalA_1_5,
			'TotalB_1_5'=>$TotalB_1_5,	
			'TotalA_1_6'=>$TotalA_1_6,
			'TotalB_1_6'=>$TotalB_1_6,	
			'TotalA_1_7'=>$TotalA_1_7,
			'TotalB_1_7'=>$TotalB_1_7,	
			'TotalA_1_8'=>$TotalA_1_8,
			'TotalB_1_8'=>$TotalB_1_8,	
			'TotalA_1_9'=>$TotalA_1_9,
			'TotalB_1_9'=>$TotalB_1_9,	
			'TotalA_1_10'=>$TotalA_1_10,
			'TotalB_1_10'=>$TotalB_1_10,	
			'TotalA_2_1'=>$TotalA_2_1,
			'TotalB_2_1'=>$TotalB_2_1,
			'TotalA_2_2'=>$TotalA_2_2,
			'TotalB_2_2'=>$TotalB_2_2,	
			'TotalA_2_3'=>$TotalA_2_3,
			'TotalB_2_3'=>$TotalB_2_3,	
			'TotalA_2_4'=>$TotalA_2_4,
			'TotalB_2_4'=>$TotalB_2_4,	
			'TotalA_2_5'=>$TotalA_2_5,
			'TotalB_2_5'=>$TotalB_2_5,	
			'TotalA_2_6'=>$TotalA_2_6,
			'TotalB_2_6'=>$TotalB_2_6,	
			'TotalA_2_7'=>$TotalA_2_7,
			'TotalB_2_7'=>$TotalB_2_7,	
			'TotalA_2_8'=>$TotalA_2_8,
			'TotalB_2_8'=>$TotalB_2_8,	
			'TotalA_2_9'=>$TotalA_2_9,
			'TotalB_2_9'=>$TotalB_2_9,	
			'TotalA_2_10'=>$TotalA_2_10,
			'TotalB_2_10'=>$TotalB_2_10,
			'TotalA_3_1'=>$TotalA_3_1,
			'TotalB_3_1'=>$TotalB_3_1,
			'TotalA_3_2'=>$TotalA_3_2,
			'TotalB_3_2'=>$TotalB_3_2,	
			'TotalA_3_3'=>$TotalA_3_3,
			'TotalB_3_3'=>$TotalB_3_3,	
			'TotalA_3_4'=>$TotalA_3_4,
			'TotalB_3_4'=>$TotalB_3_4,	
			'TotalA_3_5'=>$TotalA_3_5,
			'TotalB_3_5'=>$TotalB_3_5,	
			'TotalA_3_6'=>$TotalA_3_6,
			'TotalB_3_6'=>$TotalB_3_6,	
			'TotalA_3_7'=>$TotalA_3_7,
			'TotalB_3_7'=>$TotalB_3_7,	
			'TotalA_3_8'=>$TotalA_3_8,
			'TotalB_3_8'=>$TotalB_3_8,	
			'TotalA_3_9'=>$TotalA_3_9,
			'TotalB_3_9'=>$TotalB_3_9,	
			'TotalA_3_10'=>$TotalA_3_10,
			'TotalB_3_10'=>$TotalB_3_10,		
			'TotalA_4_1'=>$TotalA_4_1,
			'TotalB_4_1'=>$TotalB_4_1,
			'TotalA_4_2'=>$TotalA_4_2,
			'TotalB_4_2'=>$TotalB_4_2,	
			'TotalA_4_3'=>$TotalA_4_3,
			'TotalB_4_3'=>$TotalB_4_3,	
			'TotalA_4_4'=>$TotalA_4_4,
			'TotalB_4_4'=>$TotalB_4_4,	
			'TotalA_4_5'=>$TotalA_4_5,
			'TotalB_4_5'=>$TotalB_4_5,	
			'TotalA_4_6'=>$TotalA_4_6,
			'TotalB_4_6'=>$TotalB_4_6,	
			'TotalA_4_7'=>$TotalA_4_7,
			'TotalB_4_7'=>$TotalB_4_7,	
			'TotalA_4_8'=>$TotalA_4_8,
			'TotalB_4_8'=>$TotalB_4_8,	
			'TotalA_4_9'=>$TotalA_4_9,
			'TotalB_4_9'=>$TotalB_4_9,	
			'TotalA_4_10'=>$TotalA_4_10,
			'TotalB_4_10'=>$TotalB_4_10,	
			'TotalA_5_1'=>$TotalA_5_1,
			'TotalB_5_1'=>$TotalB_5_1,
			'TotalA_5_2'=>$TotalA_5_2,
			'TotalB_5_2'=>$TotalB_5_2,	
			'TotalA_5_3'=>$TotalA_5_3,
			'TotalB_5_3'=>$TotalB_5_3,	
			'TotalA_5_4'=>$TotalA_5_4,
			'TotalB_5_4'=>$TotalB_5_4,	
			'TotalA_5_5'=>$TotalA_5_5,
			'TotalB_5_5'=>$TotalB_5_5,	
			'TotalA_5_6'=>$TotalA_5_6,
			'TotalB_5_6'=>$TotalB_5_6,	
			'TotalA_5_7'=>$TotalA_5_7,
			'TotalB_5_7'=>$TotalB_5_7,	
			'TotalA_5_8'=>$TotalA_5_8,
			'TotalB_5_8'=>$TotalB_5_8,	
			'TotalA_5_9'=>$TotalA_5_9,
			'TotalB_5_9'=>$TotalB_5_9,	
			'TotalA_5_10'=>$TotalA_5_10,
			'TotalB_5_10'=>$TotalB_5_10,
			'TotalA_6_1'=>$TotalA_6_1,
			'TotalB_6_1'=>$TotalB_6_1,
			'TotalA_6_2'=>$TotalA_6_2,
			'TotalB_6_2'=>$TotalB_6_2,	
			'TotalA_6_3'=>$TotalA_6_3,
			'TotalB_6_3'=>$TotalB_6_3,	
			'TotalA_6_4'=>$TotalA_6_4,
			'TotalB_6_4'=>$TotalB_6_4,	
			'TotalA_6_5'=>$TotalA_6_5,
			'TotalB_6_5'=>$TotalB_6_5,	
			'TotalA_6_6'=>$TotalA_6_6,
			'TotalB_6_6'=>$TotalB_6_6,	
			'TotalA_6_7'=>$TotalA_6_7,
			'TotalB_6_7'=>$TotalB_6_7,	
			'TotalA_6_8'=>$TotalA_6_8,
			'TotalB_6_8'=>$TotalB_6_8,	
			'TotalA_6_9'=>$TotalA_6_9,
			'TotalB_6_9'=>$TotalB_6_9,	
			'TotalA_6_10'=>$TotalA_6_10,
			'TotalB_6_10'=>$TotalB_6_10,			


			//재적
			'Total_num_a_1_boy'	=>$Total_num_a_1_boy,
			'Total_num_a_1_girl'		=>$Total_num_a_1_girl,
			'Total_num_a_2_boy'	=>$Total_num_a_2_boy,
			'Total_num_a_2_girl'		=>$Total_num_a_2_girl,
			'Total_num_a_3_boy'	=>$Total_num_a_3_boy,
			'Total_num_a_3_girl'		=>$Total_num_a_3_girl,
			'Total_num_a_4_boy'	=>$Total_num_a_4_boy,
			'Total_num_a_4_girl'		=>$Total_num_a_4_girl,
			'Total_num_a_5_boy'	=>$Total_num_a_5_boy,
			'Total_num_a_5_girl'		=>$Total_num_a_5_girl,
			'Total_num_a_6_boy'	=>$Total_num_a_6_boy,
			'Total_num_a_6_girl'		=>$Total_num_a_6_girl,
			'Total_num_a_1'			=>$Total_num_a_1,
			'Total_num_a_2'			=>$Total_num_a_2,
			'Total_num_a_3'			=>$Total_num_a_3,
			'Total_num_a_4'			=>$Total_num_a_4,
			'Total_num_a_5'			=>$Total_num_a_5,
			'Total_num_a_6'			=>$Total_num_a_6,
			'Boy_total_A'					=>$Boy_total_A,
			'Girl_total_A'					=>$Girl_total_A,
			'TotalA1'						=>$TotalA1,
			//출석
			'Total_TotalA_1'		=>$Total_TotalA_1,
			'Total_TotalB_1'		=>$Total_TotalB_1,
			'Total_TotalA_2'		=>$Total_TotalA_2,
			'Total_TotalB_2'		=>$Total_TotalB_2,
			'Total_TotalA_3'		=>$Total_TotalA_3,
			'Total_TotalB_3'		=>$Total_TotalB_3,
			'Total_TotalA_4'		=>$Total_TotalA_4,
			'Total_TotalB_4'		=>$Total_TotalB_4,
			'Total_TotalA_5'		=>$Total_TotalA_5,
			'Total_TotalB_5'		=>$Total_TotalB_5,
			'Total_TotalA_6'		=>$Total_TotalA_6,
			'Total_TotalB_6'		=>$Total_TotalB_6,
			'Total_Total1'			=>$Total_Total1,
			'Total_Total2'			=>$Total_Total2,
			'Total_Total3'			=>$Total_Total3,
			'Total_Total4'			=>$Total_Total4,
			'Total_Total5'			=>$Total_Total5,
			'Total_Total6'			=>$Total_Total6,
			'culsuk_A'				=>$culsuk_A,
			'culsuk_B'				=>$culsuk_B,
			'Total_culsuk'			=>$Total_culsuk,
			//결석
			'Total_num_b_1_boy'		=>$Total_num_b_1_boy,
			'Total_num_b_1_girl'			=>$Total_num_b_1_girl,
			'Total_num_b_2_boy'		=>$Total_num_b_2_boy,
			'Total_num_b_2_girl'			=>$Total_num_b_2_girl,
			'Total_num_b_3_boy'		=>$Total_num_b_3_boy,
			'Total_num_b_3_girl'			=>$Total_num_b_3_girl,
			'Total_num_b_4_boy'		=>$Total_num_b_4_boy,
			'Total_num_b_4_girl'			=>$Total_num_b_4_girl,
			'Total_num_b_5_boy'		=>$Total_num_b_5_boy,
			'Total_num_b_5_girl'			=>$Total_num_b_5_girl,
			'Total_num_b_6_boy'		=>$Total_num_b_6_boy,
			'Total_num_b_6_girl'			=>$Total_num_b_6_girl,
			'Total_num_b_1'				=>$Total_num_b_1,
			'Total_num_b_2'				=>$Total_num_b_2,
			'Total_num_b_3'				=>$Total_num_b_3,
			'Total_num_b_4'				=>$Total_num_b_4,
			'Total_num_b_5'				=>$Total_num_b_5,
			'Total_num_b_6'				=>$Total_num_b_6,
			'Boy_total_B'					=>$Boy_total_B,
			'Girl_total_B'						=>$Girl_total_B,
			'TotalB1'							=>$TotalB1,				
			//조퇴
			'Total_num_c_1_boy'		=>$Total_num_c_1_boy,
			'Total_num_c_1_girl'			=>$Total_num_c_1_girl,
			'Total_num_c_2_boy'		=>$Total_num_c_2_boy,
			'Total_num_c_2_girl'			=>$Total_num_c_2_girl,
			'Total_num_c_3_boy'		=>$Total_num_c_3_boy,
			'Total_num_c_3_girl'			=>$Total_num_c_3_girl,
			'Total_num_c_4_boy'		=>$Total_num_c_4_boy,
			'Total_num_c_4_girl'			=>$Total_num_c_4_girl,
			'Total_num_c_5_boy'		=>$Total_num_c_5_boy,
			'Total_num_c_5_girl'			=>$Total_num_c_5_girl,
			'Total_num_c_6_boy'		=>$Total_num_c_6_boy,
			'Total_num_c_6_girl'			=>$Total_num_c_6_girl,
			'Total_num_c_1'				=>$Total_num_c_1,			
			'Total_num_c_2'				=>$Total_num_c_2,			
			'Total_num_c_3'				=>$Total_num_c_3,			
			'Total_num_c_4'				=>$Total_num_c_4,			
			'Total_num_c_5'				=>$Total_num_c_5,			
			'Total_num_c_6'				=>$Total_num_c_6,
			'Boy_total_C'					=>$Boy_total_C,
			'Girl_total_C'						=>$Girl_total_C,
			'TotalC1'							=>$TotalC1,	

			//전입
			'Total_num_d_1_boy'		=>$Total_num_d_1_boy,
			'Total_num_d_1_girl'			=>$Total_num_d_1_girl,
			'Total_num_d_2_boy'		=>$Total_num_d_2_boy,
			'Total_num_d_2_girl'			=>$Total_num_d_2_girl,
			'Total_num_d_3_boy'		=>$Total_num_d_3_boy,
			'Total_num_d_3_girl'			=>$Total_num_d_3_girl,
			'Total_num_d_4_boy'		=>$Total_num_d_4_boy,
			'Total_num_d_4_girl'			=>$Total_num_d_4_girl,
			'Total_num_d_5_boy'		=>$Total_num_d_5_boy,
			'Total_num_d_5_girl'			=>$Total_num_d_5_girl,
			'Total_num_d_6_boy'		=>$Total_num_d_6_boy,
			'Total_num_d_6_girl'			=>$Total_num_d_6_girl,
			'Total_num_d_1'				=>$Total_num_d_1,			
			'Total_num_d_2'				=>$Total_num_d_2,			
			'Total_num_d_3'				=>$Total_num_d_3,			
			'Total_num_d_4'				=>$Total_num_d_4,			
			'Total_num_d_5'				=>$Total_num_d_5,			
			'Total_num_d_6'				=>$Total_num_d_6,
			'Boy_total_D'					=>$Boy_total_D,
			'Girl_total_D'						=>$Girl_total_D,
			'TotalD1'							=>$TotalD1,	

			//전출
			'Total_num_e_1_boy'		=>$Total_num_e_1_boy,
			'Total_num_e_1_girl'			=>$Total_num_e_1_girl,
			'Total_num_e_2_boy'		=>$Total_num_e_2_boy,
			'Total_num_e_2_girl'			=>$Total_num_e_2_girl,
			'Total_num_e_3_boy'		=>$Total_num_e_3_boy,
			'Total_num_e_3_girl'			=>$Total_num_e_3_girl,
			'Total_num_e_4_boy'		=>$Total_num_e_4_boy,
			'Total_num_e_4_girl'			=>$Total_num_e_4_girl,
			'Total_num_e_5_boy'		=>$Total_num_e_5_boy,
			'Total_num_e_5_girl'			=>$Total_num_e_5_girl,
			'Total_num_e_6_boy'		=>$Total_num_e_6_boy,
			'Total_num_e_6_girl'			=>$Total_num_e_6_girl,
			'Total_num_e_1'				=>$Total_num_e_1,			
			'Total_num_e_2'				=>$Total_num_e_2,			
			'Total_num_e_3'				=>$Total_num_e_3,			
			'Total_num_e_4'				=>$Total_num_e_4,			
			'Total_num_e_5'				=>$Total_num_e_5,			
			'Total_num_e_6'				=>$Total_num_e_6,
			'Boy_total_E'					=>$Boy_total_E,
			'Girl_total_E'						=>$Girl_total_E,
			'TotalE1'							=>$TotalE1,	
			


	

			));
		break;



	case 'GET':
		//호출되면 여기서부터 시작됨

		$DB = &WebApp::singleton('DB');

	
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
	
			
		$DOC_TITLE = 'str:출결통계';
		$tpl->setLayout('@sub');
		$tpl->define('CONTENT', Display::getTemplate('member/attendance_list_pre.htm'));
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
			'redir'		=>	$_REQUEST['redir'],
			'num_date' =>$num_date
		));
		break;
		exit;
}

?>