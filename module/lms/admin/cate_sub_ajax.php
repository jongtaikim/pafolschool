<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2010-12-10
* 작성자: 김종태
* 설   명: 카테고리 리스트
*****************************************************************
* 
*/
header('Content-Type: text/html; charset=UTF-8');
$DB = &WebApp::singleton('DB');
$table2 = "TAB_LMS_CATE";

switch ($mode) {
	case "add":
	

	
	$sql = "select max(num_ccode)+1 from $table2 where num_oid = '$_OID'   and str_type = '$types' and  LENGTH(NUM_CCODE)=4  ";
	$max_cate = $DB -> sqlFetchOne($sql);
	if(!$max_cate) {
		if($types ==1) $max_cate =1010; else $max_cate =2010; 
	}


	$sql = "select max(num_step)+1 from $table2 where num_oid = '$_OID'  and str_type = '$types' and  LENGTH(NUM_CCODE)=4 ";
	$max_step = $DB -> sqlFetchOne($sql);
	if(!$max_step) $max_step =1;

	$str_title_ = iconv("UTF-8","euc-kr",$str_title);

	$sql = "INSERT INTO ". $table2." (
			
  			   NUM_OID,  NUM_CCODE, STR_TYPE, STR_TITLE,  NUM_STEP

			) VALUES (
			   '"._OID."', '".$max_cate."',  '".$types."','".$str_title_."', '".$max_step."'			
			) ";
	


	 if($DB->query($sql)){
		 $DB->commit();
		echo "add";
		exit;
	 }else{
		echo "error_db";
		exit;
	 }				
	
	 break;

	 case "del":
	
	  $sql = "UPDATE ".$table." SET num_ccode=0 WHERE num_oid=$_OID and num_ccode = '".$cate."'  and str_type = '$types' and  LENGTH(NUM_CCODE)=4 ";
	 
	  if($DB->query($sql)){
		  $DB->commit();
	  }
	 
	$sql = "delete from ".$table2." WHERE num_oid=$_OID and num_ccode = '".$cate."'  and str_type = '$types' and  LENGTH(NUM_CCODE)=4 ";
	 if($DB->query($sql)){
		 $DB->commit();
		echo "del";
		exit;
	 }else{
		echo "error_db";
		exit;
	 }				
	
	 break;

	  case "update":
	  
	  $str_title_ = iconv("UTF-8","euc-kr",$str_title);
	  $sql = "UPDATE ".$table2." SET str_title='".$str_title_."' WHERE num_oid=$_OID and num_ccode = '".$cate."'  and str_type = '$types' and  LENGTH(NUM_CCODE)=4 ";
	 
	  if($DB->query($sql)){
	   $DB->commit();
	  }else{
		echo "error_db";
		exit;
	 }				
	
	 break;
	default:
	
	$sql = "select * from $table2 where num_oid = '$_OID'  and str_type = '$types' and  LENGTH(NUM_CCODE)=4  order by num_step asc";
	$row = $DB -> sqlFetchAll($sql);

	if($row){
		for($ii=0; $ii<count($row); $ii++) {
			echo '<li class="listitem"><a href="#"  id="href_'.$row[$ii][num_ccode].'" class="title" ondblclick="togole(\''.$row[$ii][num_ccode].'\')" >'.iconv("euc-kr","UTF-8",$row[$ii][str_title]).'</a> 
			<input type="text"  value="'.$row[$ii][str_title].'"  id="text_'.$row[$ii][num_ccode].'" style="display:none;margin-left:16px" onchange="dataUpdatesUpdate(this.value,\''.$row[$ii][num_ccode].'\')">
			<a href="javascript:dataUpdatesDel(\''.$row[$ii][num_ccode].'\');" class="del"><img src="/images/delBtn.gif" alt="삭제" /></a><input type="hidden" name="cates[]" value="'.$row[$ii][num_ccode].'"></li>';
		}
	}else{
		echo _la('표시할 항목이 없습니다.');
	}


	 break;
	}






?>