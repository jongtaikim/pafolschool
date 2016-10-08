<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$_MEMBER = WebApp::getConf('member');
$tpl->assign($_MEMBER);
$tpl->assign(array('GPIN'=>_GPIN));




$ttmodule = "member";

switch ($act) {
	case "member.login":
	$_str_type = $ttmodule."#L";
	 break;
	case "member.findid":
	$_str_type = $ttmodule."#F";
	 break;

	case "member.join":
		$_str_type = $ttmodule."#J";
	 break;


	case "member.modify":
		$_str_type = $ttmodule."#M";
	 break;


	case "member.del":
		$_str_type = $ttmodule."#D";
	 break;

	}


			$school_year = WebApp::getConf('formation.school_year');
		
			function classList(){
					global $DB, $school_year ,$tpl;
					
					$sql = "select NUM_GRADE, STR_GRADE from ".TAB_CLASS_GRADE." where num_oid = "._OID." order by NUM_GRADE asc";
					$fmt = $DB -> sqlFetchAll($sql);

					for($ii=0; $ii<count($fmt); $ii++) {
					$sql = "SELECT 
							
							   NUM_GRADE, 
							   NUM_CLASS, STR_CLASS, STR_CAFE_ID
						 
							FROM ".TAB_FORMATION_SET." WHERE num_oid="._OID." AND num_year = ".$school_year." and num_grade = ".$fmt[$ii][num_grade]."  order by NUM_CLASS asc";

						$fmt[$ii][classTop] =  $DB -> sqlFetchAll($sql);
						
						for($iia=0; $iia<count($fmt[$ii][classTop]); $iia++) {
							$sql = "select count(*) from TAB_MEMBER where num_oid = "._OID." and num_fcode = '".$fmt[$ii][classTop][$iia][str_cafe_id]."' ";
							$fmt[$ii][classTop][$iia][counter] = $DB -> sqlFetchOne($sql);
							
						}

					}

					$tpl->assign(array('FMT'=>$fmt));
			}
?>