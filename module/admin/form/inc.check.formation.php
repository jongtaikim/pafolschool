<?

/**
 * @author : Wes
 * @copyright 2008.02.26
 * @name : inc.check.formation.php
 */
	// �����н��������� ��� �б޳����� �����ϱ�����	
	if ($HOST) $edu_host = explode(".",$HOST);

	// �����ڷα����� ó������ �б��� ����
	if($_COOKIE['FOMATION_CHECK']!=true && $edu_host[0]!="edu"){
		// �г�, �����б�, ���� �б� Ȯ���� �б�ó�� 
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
			WebApp::redirect("/?act=admin.form.main", $school_year."�⵵ �б����� �����ϴ�. �б����������� �̵��մϴ� ");
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