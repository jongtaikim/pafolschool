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

$sql = "SELECT * FROM ".TAB_ORGAN." where str_hometype = 'HOME' and num_oid>20261 order by num_oid";
$data = $DB->sqlFetchAll($sql);
for($a=0 ; $a<sizeof($data) ; $a++){
	echo$data[$a]['num_oid']."<br>";

	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'3','310','개설강좌','lms#A', 1, 1,'admin')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'1','311','내강의실','lms#M', 1, 1,'admin')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'4','312','오프라인강좌신청','lms#O', 1, 1,'admin')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'5','313','강사소개','lms#J', 1, 1,'admin')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'6','314','커뮤니티','board#A', 1, 1,'admin')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'2','315','신청내역','pay#C', 1, 1,'admin')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'1','31010','동영상강좌1','lms#C', 1, 1,'admin')";
	$DB->query($sql);
	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'2','31011','동영상강좌2','lms#C', 1, 1,'admin')";
	$DB->query($sql);
	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'3','31012','동영상강좌3','lms#C', 1, 1,'admin')";
	$DB->query($sql);
	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'1','31310','국어선생님','lms#E', 1, 1,'admin')";
	$DB->query($sql);
	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'2','31311','수학선생님','lms#E', 1, 1,'admin')";
	$DB->query($sql);
	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'3','31312','영어선생님','lms#E', 1, 1,'admin')";
	$DB->query($sql);
	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'1','31410','국어 게시판','board#B', 1, 1,'admin')";
	$DB->query($sql);
	$sql = "INSERT INTO TAB_MENU(num_oid, num_step, num_mcode, str_title, str_type, num_view, num_enable_remove,str_layout)
			VALUES(".$data[$a]['num_oid'].",'2','31411','수학 게시판','board#B', 1, 1,'admin')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_BOARD_CONFIG(num_oid, num_mcode, str_title, str_skin, num_listnum, num_navnum,num_titlelen, 
				chr_listtype, chr_oddcolor, chr_evencolor, chr_comment, chr_recent)
			VALUES(".$data[$a]['num_oid'].", '314', '커뮤니티','A_board','20',10,30,'A','#FFFFFF','#FFFFFF','Y','N')";

	$sql = "INSERT INTO TAB_BOARD_CONFIG(num_oid, num_mcode, str_title, str_skin, num_listnum, num_navnum,num_titlelen, 
				chr_listtype, chr_oddcolor, chr_evencolor, chr_comment, chr_recent)
			VALUES(".$data[$a]['num_oid'].", '31410', '국어 게시판','A_board','20',10,100,'B','#FFFFFF','#FFFFFF','Y','N')";
	$DB->query($sql);

	$sql = "INSERT INTO TAB_BOARD_CONFIG(num_oid, num_mcode, str_title, str_skin, num_listnum, num_navnum,num_titlelen, 
				chr_listtype, chr_oddcolor, chr_evencolor, chr_comment, chr_recent)
			VALUES(".$data[$a]['num_oid'].", '31411', '수학 게시판','A_board','20',10,100,'B','#FFFFFF','#FFFFFF','Y','N')";
	$DB->query($sql);

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','310','a','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','310','b','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','310','c','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','310','d','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','310','t','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','310','u','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','310','v','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','310','w','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','310','x','lr')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','311','a','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','311','b','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','311','c','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','311','d','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','311','t','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','311','u','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','311','v','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','311','w','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','311','x','lr')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','312','a','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','312','b','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','312','c','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','312','d','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','312','t','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','312','u','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','312','v','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','312','w','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','312','x','lr')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','313','a','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','313','b','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','313','c','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','313','d','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','313','t','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','313','u','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','313','v','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','313','w','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','313','x','lr')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','314','a','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','314','b','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','314','c','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','314','d','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','314','t','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','314','u','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','314','v','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','314','w','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','314','x','lr')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31010','a','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31010','b','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31010','c','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31010','d','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31010','t','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31010','u','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31010','v','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31010','w','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31010','x','lr')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31011','a','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31011','b','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31011','c','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31011','d','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31011','t','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31011','u','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31011','v','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31011','w','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31011','x','lr')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31012','a','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31012','b','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31012','c','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31012','d','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31012','t','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31012','u','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31012','v','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31012','w','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31012','x','lr')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31310','a','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31310','b','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31310','c','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31310','d','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31310','t','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31310','u','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31310','v','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31310','w','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31310','x','lr')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31311','a','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31311','b','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31311','c','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31311','d','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31311','t','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31311','u','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31311','v','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31311','w','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31311','x','lr')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31312','a','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31312','b','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31312','c','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31312','d','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31312','t','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31312','u','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31312','v','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31312','w','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31312','x','lr')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31410','a','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31410','b','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31410','c','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31410','d','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31410','t','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31410','u','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31410','v','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31410','w','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31410','x','lr')");

	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31411','a','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31411','b','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31411','c','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31411','d','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31411','t','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31411','u','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31411','v','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31411','w','lr')");
	$DB->query("insert into TAB_MENU_RIGHT(num_oid, str_sect, str_code, str_group, str_right) values('".$data[$a]['num_oid']."','menu','31411','x','lr')");


	$DB->commit();

}
?>