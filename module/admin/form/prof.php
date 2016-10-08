<?php
/****************************************************
	작성 : 얼룩푸우(budget74@nate.com)
	용도 : 학급 편제 구성하기
	일자 : 2004년 02월 29일
*****************************************************/
include "Directory.php";
include _DB_INFO;
include _DB_CLASS;
include _MODULE;

##	디비 접속
$ewut_oci->connect();

##	변수 설정
$_VARS = decodeVARS();

switch ($REQUEST_METHOD) {
	case "GET":
		$tpl->define('CONTENT','html/admin/form/prof.htm');

		#	리스트
		$tpl->define('LOOP','CONTENT');
		$range = strlen($parent)+2;
		if($parent) $WHERE = " AND substr(NUM_SERIAL,0,".strlen($parent).")=".$parent ;
		$query = "SELECT NUM_STEP,NUM_SERIAL,STR_TITLE FROM "._TB_PROFESSION." WHERE num_oid=".$oid." AND Length(NUM_SERIAL)=".$range.$WHERE;
		$ewut_oci->parseExec($query);
		for( $i=0 ;$ewut_oci->fetchinto(&$row); $i++ )
		{
			$tpl->assign('_profession_step',$row[NUM_STEP] );
			$tpl->assign('_profession_serial',$row[NUM_SERIAL] );
			$tpl->assign('_profession_title',stripslashes($row[STR_TITLE]) );
			$tpl->parse('LOOP');
		}
		$tpl->parse('CONTENT');
		break;

	case "POST":

		$WHERE = "num_oid=".$oid;
		switch($_VARS[mode])
		{
			case "write":
				$range = strlen($parent)+2;
				$WHERE .= " AND length(NUM_SERIAL)=".$range;

				## SERIAL MAX
				if($parent) $WHERE .= " AND substr(NUM_SERIAL,0,".strlen($parent).")=".$parent ;

				$query = "SELECT /*+INDEX_DESC("._TB_PROFESSION." ".$_INDEX[_TB_PROFESSION][IDX].")*/ "
						."NUM_SERIAL FROM "._TB_PROFESSION." WHERE ".$WHERE." AND rownum = 1";
				$rowMAX = $ewut_oci -> one_row($query);
				$MAXal = ( $rowMAX["NUM_SERIAL"] ) ? 
						   $rowMAX["NUM_SERIAL"] + 1 : 
						   $iFirst = ( $parent ) ? $parent."10" : 10 ; ;

				## STEP MAX
				$query = "SELECT /*+INDEX_DESC("._TB_PROFESSION." ".$_INDEX[_TB_PROFESSION][PK].")*/ "
						."NUM_STEP FROM "._TB_PROFESSION." WHERE ".$WHERE." AND rownum = 1";
				$rowMAX = $ewut_oci -> one_row($query);
				$MAXep = $rowMAX["NUM_STEP"] + 1;

				##	 등록 쿼리
				$field = "NUM_OID,NUM_STEP,NUM_SERIAL,STR_TITLE";
				$value = $oid.",".$MAXep.",".$MAXal.",'".strip_tags($_VARS[formation])."'";
				$query = "INSERT INTO "._TB_PROFESSION."(".$field.") VALUES(".$value.")";
				$js_sql1 = $query;
				$ewut_oci -> Parse($query);
				$ewut_oci -> Commit();

				break;

			case "modify":
				$WHERE .= " and num_serial=".$_VARS[code];
				$ewut_oci -> Parse("UPDATE "._TB_PROFESSION." SET str_title='".strip_tags($_VARS[formation])."' WHERE ".$WHERE);
				$js_sql1 = "UPDATE "._TB_PROFESSION." SET str_title='".strip_tags($_VARS[formation])."' WHERE ".$WHERE;
				$ewut_oci -> Commit();				
				break;

			case "delete":

				for( $i=0; $i < sizeof($_VARS[code]); $i++ )
				{
					$WHERE = " AND substr(NUM_SERIAL,0,".strlen($_VARS[code][$i]).")=".$_VARS[code][$i] ;
					$ewut_oci->Parse("DELETE FROM "._TB_PROFESSION." WHERE num_oid=".$oid.$WHERE);
					$js_sql1 = "DELETE FROM "._TB_PROFESSION." WHERE num_oid=".$oid.$WHERE;
					$ewut_oci->Commit();
				}
				break;
		}

		//==-- 기존 캐시파일 지우기 --==//
		include "module/admin/inc.ftpsave.php";
		ftpdel("school/hosts/$HOST/inc.classlist.htm");
//		if (!ftpdel("school/hosts/$HOST/inc.classlist.htm")) WebApp::alert('캐시파일 비우기 오류');

		if( $parent ) $_VARS[act] .= "&parent=".$parent;


// ################# 06. 06. 21. 01. 로그입력위해. ###############

$js_log["filename"] = __FILE__;
$js_log["title"] = "[관리자모드][기본정보][교직편성]";
$js_log["moredata"] = array(
	"REQUEST_METHOD"=>$REQUEST_METHOD,
	"_".$REQUEST_METHOD=>${"_$REQUEST_METHOD"},
	"_VARS"=>$_VARS
);
$js_log["contents"] = array(
	"titles"=>array(
		"sql 1",
		"sql 2",
		"include file",
		" include file function : ftpdel ",
		"redirect url"
	),
	"values"=>array(
		$js_sql1,
		$js_sql2,
		"module/admin/inc.ftpsave.php",
		array( "school/hosts/$HOST/inc.classlist.htm" ),
		"?act=".$_VARS[act]
	)
);

//js_log_save($js_log);

// ################# 06. 06. 21. 01. 로그입력위해. ###############



		ReturnUrl("?act=".$_VARS[act]);
}
$ewut_oci->disconnect();
?>