<?php
/*
용  도 : 최고학년 졸업시키기
작성자 : 서종석(budget74@nate.com)
작성일 : 2005년 월 일
*/
include _DB_INFO;

$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
		$tpl->define('CONTENT','html/admin/form/out.htm');
		$tpl->define('LOOP','CONTENT');
		$data=$DB->sqlFetchAll(" 
				SELECT 
					/*+INDEX_DESC(tab_formation pk_tab_formation)*/ num_serial,str_title  
				FROM 
					tab_formation 
				WHERE 
					num_oid=$oid AND length(num_serial)=2
			");
		$tpl->parse('LOOP',&$data);
		$tpl->parse('CONTENT');
		break;

	case "POST":
		$gradyear = date('Y');
		
		$data=$DB->sqlFetchAll("SELECT str_id,num_formation FROM tab_student 
								WHERE num_oid=$oid AND num_formation like '{$formation}%'");		
		foreach( $data as $dbh ){
			/*$ent_year=$DB->sqlFetchOne("SELECT to_char(dt_date,'YYYY') as entered FROM tab_member 
								WHERE num_oid=$oid AND str_id='".$dbh['str_id']."' AND chr_rank='s'");*/
			$ent_year=$DB->sqlFetchOne("SELECT to_char(m.dt_date,'YYYY') as entered" .
											" FROM tab_member_merge m" .
											" Left Outer Join tab_member_rank r on m.num_oid=r.num_oid And m.str_id=r.str_id" .
											" WHERE m.num_oid=$oid AND m.str_id='".$dbh['str_id']."' AND r.chr_rank='s'");

			if( $gradyear <= $ent_year ) continue; // 졸업년도와 학생으로 가입 또는 학년을 수정한 년도를 비교하여 졸업년도 보다 작으면 졸업시킨다.

			//$DB->query("DELETE FROM tab_alumnus WHERE num_oid=$oid AND str_id='".$dbh['str_id']."'");
			//$DB->commit();
			echo "DELETE FROM tab_alumnus WHERE num_oid=$oid AND str_id='".$dbh['str_id']."'\n";
			
			$sql = "
				INSERT INTO "._TB_ALUMNUS."
					(num_oid, str_id, chr_graduation, str_photo, str_intro)
				SELECT
					{$oid}, '{$dbh['str_id']}', '$gradyear', str_photo, str_intro
				FROM
					"._TB_STUDENT."
				WHERE
					num_oid={$oid} AND str_id='{$dbh['str_id']}'
			";	// 학생 정보를 졸업생 정보로 전환

			echo $sql."\n";

			if ($DB->query($sql)) {
				//$DB->query("DELETE FROM tab_student WHERE num_oid=$oid AND str_id='".$dbh['str_id']."'");
				//$DB->query("DELETE FROM tab_teacher WHERE num_oid=$oid AND str_id='".$dbh['str_id']."'");
				//$DB->query("DELETE FROM tab_parents WHERE num_oid=$oid AND str_id='".$dbh['str_id']."'");
				//$DB->query("DELETE FROM tab_general WHERE num_oid=$oid AND str_id='".$dbh['str_id']."'");
				//$DB->query("DELETE FROM tab_member WHERE num_oid=$oid AND str_id='".$dbh['str_id']."'");
				//$DB->commit();

				echo " DELETE FROM tab_student WHERE num_oid=$oid AND str_id='".$dbh['str_id']."'\n
						DELETE FROM tab_teacher WHERE num_oid=$oid AND str_id='".$dbh['str_id']."'\n
						DELETE FROM tab_parents WHERE num_oid=$oid AND str_id='".$dbh['str_id']."'\n
						DELETE FROM tab_general WHERE num_oid=$oid AND str_id='".$dbh['str_id']."'\n
						DELETE FROM tab_member WHERE num_oid=$oid AND str_id='".$dbh['str_id']."'\n";

				/*$gradname=$DB->sqlFetchOne("SELECT str_name FROM tbl_ewut_member 
								WHERE str_id='".$dbh['str_id']."'");*/
				$gradname=$DB->sqlFetchOne("SELECT str_name FROM tab_member_merge" .
													" WHERE str_id='".$dbh['str_id']."'");
				
				/*
				$DB->query("INSERT INTO tab_member(num_oid,str_id,chr_rank,str_ip,dt_date,str_name) 
						VALUES($oid,'".$dbh['str_id']."','a','".getenv('REMOTE_ADDR')."',sysdate,'{$gradname}')");
				$DB->commit();
				*/

				echo " INSERT INTO 
							tab_member(num_oid,str_id,chr_rank,str_ip,dt_date,str_name) 
						VALUES
							($oid,'".$dbh['str_id']."','a','".getenv('REMOTE_ADDR')."',sysdate,'{$gradname}')

				==========================================================================";
			} 
		}
		//WebApp::redirect('/?act=admin.summery_new','졸업생 처리가 완료되었습니다. 학년변동이 있는 학생들은 각자 개인정보수정을 통해서 반영됩니다!!');
}
?>