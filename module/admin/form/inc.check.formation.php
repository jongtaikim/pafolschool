<?

/**
 * @author : Wes
 * @copyright 2008.02.26
 * @name : inc.check.formation.php
 */
	// 교수학습도움센터의 경우 학급노출을 억제하기위해	
	if ($HOST) $edu_host = explode(".",$HOST);

	// 관리자로그인후 처음에만 학급편성 공지
	if($_COOKIE['FOMATION_CHECK']!=true && $edu_host[0]!="edu"){
		// 학년, 현재학급, 지난 학급 확인후 분기처리 
		if(!$DB)$DB = &WebApp::singleton('DB');
		$query = "SELECT count(*) from TAB_FORMATION_SET Where num_oid=$oid and num_year=".$school_year;
		$countClass = $DB->sqlFetch($query);

			$query = "  SELECT
				(select count(*) from TAB_CLASS_GRADE Where num_oid=$oid ) grade,
				(select count(*) from TAB_FORMATION_SET Where num_oid=$oid and num_year=".$school_year." ) class
					FROM Dual";	
			$countClass = $DB->sqlFetch($query);

		if( $countClass['grade'] == 0 || $countClass['class'] == 0 ){
			setCookie('FOMATION_CHECK',true,0,'/','.'.$HOST);
			WebApp::redirect("/?act=admin.form.main", $school_year."년도 학급편성이 없습니다. 학급편성페이지로 이동합니다 ");
		}else {
			$sql = "SELECT to_char(mod_date,'yyyy-mm-dd') mod_master FROM tab_school WHERE num_oid=$oid";
			$master_date = $DB->sqlFetch($sql);
			if($master_date['mod_master']<"2009-03-01") {
				setCookie('FOMATION_CHECK',true,0,'/','.'.$HOST);
				WebApp::redirect("/?act=admin.form.master");
			}
			
		}

	}
?>