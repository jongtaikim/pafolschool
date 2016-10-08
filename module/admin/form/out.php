<?php
/*
��  �� : �ְ��г� ������Ű��
�ۼ��� : ������(budget74@nate.com)
�ۼ��� : 2005�� �� ��
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

			if( $gradyear <= $ent_year ) continue; // �����⵵�� �л����� ���� �Ǵ� �г��� ������ �⵵�� ���Ͽ� �����⵵ ���� ������ ������Ų��.

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
			";	// �л� ������ ������ ������ ��ȯ

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
		//WebApp::redirect('/?act=admin.summery_new','������ ó���� �Ϸ�Ǿ����ϴ�. �г⺯���� �ִ� �л����� ���� �������������� ���ؼ� �ݿ��˴ϴ�!!');
}
?>