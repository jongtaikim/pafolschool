<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/manage/organ.php
* 작성일: 2008-11-26
* 작성자: 김종태
* 설  명:  학교정보검색
*****************************************************************
* 
*/
exit;
$DB = &WebApp::singleton('DB');
if(!$code) {
	$code = "SCHOOL";
}

$sql = "SELECT COUNT(*) FROM TAB_ORGAN where  str_hometype = 'HOME'   $where $psql $psql2 $psql3 $psql4";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;

$sql = "	
SELECT * FROM ".TAB_ORGAN." where str_hometype = 'HOME' and num_oid>20260 order by num_oid";
$data = $DB->sqlFetchAll($sql);
for($a=0 ; $a<sizeof($data) ; $a++){
	echo$data[$a]['num_oid']."<br>";

	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'1','210','공지사항','board#B', 1, 1,'admin')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'2','211','자료실','board#B', 1, 1,'admin')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'3','212','앨범','board#B', 1, 1,'admin')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'4','213','설문조사','poll', 1, 1,'admin')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_BOARD_CONFIG(num_oid, num_mcode, str_title, str_skin, num_listnum, num_navnum,num_titlelen, 
				chr_listtype, chr_oddcolor, chr_evencolor, chr_comment, chr_recent)
			VALUES(".$data[$a]['num_oid'].", '210', '공지사항','A_board','20',10,100,'B','#FFFFFF','#FFFFFF','N','N')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_BOARD_CONFIG(num_oid, num_mcode, str_title, str_skin, num_listnum, num_navnum,num_titlelen, 
				chr_listtype, chr_oddcolor, chr_evencolor, chr_comment, chr_recent)
			VALUES(".$data[$a]['num_oid'].", '211', '자료실','A_board','20',10,100,'B','#FFFFFF','#FFFFFF','Y','N')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_BOARD_CONFIG(num_oid, num_mcode, str_title, str_skin, num_listnum, num_navnum,num_titlelen, 
				chr_listtype, chr_oddcolor, chr_evencolor, chr_comment, chr_recent)
			VALUES(".$data[$a]['num_oid'].", '212', '앨범','A_gallery','20',10,100,'B','#FFFFFF','#FFFFFF','Y','N')";
	$DB->query($sql);

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','210','a','lrw')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','210','b','lrw')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','210','c','lrw')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','210','d','lrw')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','210','t','lr')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','211','a','lrw')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','211','b','lrw')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','211','c','lrw')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','211','d','lrw')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','211','t','lrw')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','212','a','lrw')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','212','b','lrw')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','212','c','lrw')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','212','d','lrw')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','212','t','lrw')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','213','a','l')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','213','b','l')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','213','c','l')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','213','d','l')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','213','t','l')");
	
	$DB->commit();

}
?>