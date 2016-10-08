<?
$DB = &WebApp::singleton("DB");


 




$sql = "select * from TAB_ATTACH_CONFIG where num_oid = '$_OID' and  
			str_layer = 'NONE' order by str_width";
$row = $DB -> sqlFetchAll($sql);

for($ii=0; $ii<count($row); $ii++) {
	
$iia = $ii +1;
	$sql = "update ".TAB_ATTACH_CONFIG." set
	
			num_step = '$iia'

			where  num_oid = '$_OID' and  str_layer = 'NONE' and str_name = '".$row[$ii][str_name]."' ";
        $DB->query($sql);
		$DB->commit();
//echo $sql."<br>";
}


WebApp::moveBack();




?>