<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	

	$sql = "select * from TAB_ANI_TEXT where num_oid = $_OID order by num_step asc ";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('LIST'=>$row));


	$tpl->define("CONTENT", Display::getTemplate("ani_text/admin/list.htm"));
	
	 break;
	case "POST":

			$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.ani_text.htm";
			unlink($cache_file);


			switch ($mode) {
				case "new":
				
				$sql = "select max(num_serial) +1 from TAB_ANI_TEXT where num_oid = $_OID ";
				$max_num = $DB -> sqlFetchOne($sql);
				if(!$max_num) $max_num= 1;

				$sql = "select max(num_step) +1 from TAB_ANI_TEXT where num_oid = $_OID ";
				$max_num_step = $DB -> sqlFetchOne($sql);
				if(!$max_num_step) $max_num_step= 1;

			$sql = "INSERT INTO ".TAB_ANI_TEXT." (
						num_oid,
						num_serial,
						str_text,
						num_view,
						str_url,
						num_step,
						str_date

							) VALUES (
						'$_OID',
						$max_num,
						'$str_text',
						'$num_view',
						'$str_url',
						$max_num_step,
						'".mktime()."'				
						) ";



			if($DB->query($sql)){
			$DB->commit();
			WebApp::moveBack('저장되었습니다.');
					
			}

				
				
				
				 break;
				case "update":

for($ii=0; $ii<count($num_serial); $ii++) {
$iia = $ii+1;
 
 if($num_del[$ii] == "Y") {
$sql = "delete from TAB_ANI_TEXT 
  WHERE 
 num_oid=$_OID and
 num_serial = ".$num_serial[$ii]." "	;
 $DB->query($sql);
 $DB->commit();

 }else{
 $sql = "UPDATE ".TAB_ANI_TEXT." SET 
 
	str_text='".$str_text[$ii]."',  
	str_url='".$str_url[$ii]."',
	num_view='".$num_view[$ii]."',
	num_step='".$iia."'

 
 WHERE 
 num_oid=$_OID and
 num_serial = ".$num_serial[$ii]."

 ";
 

 $DB->query($sql);
 $DB->commit();
 }

}



WebApp::moveBack();
					
					
					
				 break;
				}


	 break;
	}

?>