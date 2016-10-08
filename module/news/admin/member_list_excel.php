<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$excelnm = "뉴스레터(" . date("Y-m-d") . ")"; // 엑셀 파일 명

$DB = &WebApp::singleton('DB');
$table = "TAB_NEWS_MEMBER";

switch ($REQUEST_METHOD) {
	case "GET":
	
	header( "Content-type: application/vnd.ms-excel" ); 
	header( "Content-Disposition: attachment; filename=".$excelnm.".xls" ); 
	header( "Content-Description: PHP5 Generated Data" ); 
	

	$sql = "
	select * from ".$table." where num_oid = '$_OID'   order by num_serial desc";

	//echo  $sql;

	$data = $DB->sqlFetchAll($sql);

	
	 break;
	}

?>

<table align="center" width="100%" border="1" cellspacing="0" cellpadding="0" class="tableTemp01" summary="">
<caption><span>뉴스레터 맴버</span></caption>
	<thead>
		<tr>
			<th>이름</th>
			<th>연락처</th>
			<th>이메일</th>
			<th>회사 및 소속</th>
			<th>신청경로</th>
			<th>구독여부</th>
		</tr>
	</thead>
	<tbody>
		<?
		for($ii=0; $ii<count($data); $ii++) { ?>
			
		
		<tr>
			<td ><?=$data[$ii][str_name]?></td>

			<td><?=$data[$ii][str_phone]?></td>
			<td><?=$data[$ii][str_email]?></td>
			<td><?=$data[$ii][str_compay]?></td>
			<td><?=$data[$ii][str_voll]?></td>
			<td><? if($data[$ii][str_mailing] == 'y'){?><span style="color:blue">구독</span><? }else{ ?><span style="color:red">해지</span><? } ?></td>
		</tr>

		<? } ?>
	</tbody>
</table>