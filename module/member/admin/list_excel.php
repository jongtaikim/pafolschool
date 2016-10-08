<?
/*
* 작성일: 2008-11-11
* 작성자: 장진수
* 설	명: 회원관리목록 엑셀 데이터 내보내기
*****************************************************************
*/
$DB = &WebApp::singleton('DB');

$excelnm = "회원목록(" . date("Y-m-d") . ")"; // 엑셀 파일 명


if(!$page = $_REQUEST['page']) $page = 1;
if(!$listnum) {
$listnum = 15;	
}

$offset = ($page-1) * $listnum;

$mtypes = WebApp::get('member',array('key'=>'member_types'));

$sql = "SELECT * FROM ".TAB_GROUP." WHERE num_oid=$_OID";
$gdata = $DB->sqlFetchAll($sql);

$wehre = '';

switch($noauth) {
case "0":
	$where .= 'AND num_auth=0 ';
break;
case "1":
	$where .= 'AND num_auth=1 ';
break;

}


$search_key = $_REQUEST['search_key'];
$search_value = $_REQUEST['search_value'];
if(isset($search_key) && isset($search_value)) {
	if(substr($search_key,0,3) != "num") {
		$where = "AND $search_key LIKE '%$search_value%' ";
	} else {
		$where = "AND $search_key = '$search_value' ";
	}
}
$search_auth = $_REQUEST['search_auth'];
if($search_auth != '') $where .= "AND num_auth='$search_auth' ";
$search_mtype = $_REQUEST['search_mtype'];
if($search_mtype != '') $where .= "AND chr_mtype = '$search_mtype' ";



$sql = "SELECT COUNT(*) FROM TAB_MEMBER
		WHERE
			num_oid=$_OID $where $align";

$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;


$sql1 = "SELECT COUNT(*) FROM TAB_MEMBER WHERE num_oid=$_OID   and num_auth=0 ";
$total1 = $DB->sqlFetchOne($sql1);

$sql2 = "SELECT COUNT(*) FROM TAB_MEMBER WHERE num_oid=$_OID   and num_auth=1";
$total2 = $DB->sqlFetchOne($sql2);


switch($align) {
case "name":
	$align = " order by str_name ";
break;
case "id":
	$align = " order by str_id ";
break;
case "mtype":
	$align = " order by chr_mtype ";
break;
case "dt_date":
	$align = " order by dt_date ";
break;
case "str_nick":
	$align = " order by dt_date ";
break;
case "auth":
	$align = " order by num_auth ";
break;
case "str_phone":
	$align = " order by str_phone ";
break;
case "str_handphone":
	$align = " order by str_handphone ";
break;
default:
	$align = " order by dt_date desc ";
break;

}

header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=".$excelnm.".xls" ); 
header( "Content-Description: PHP5 Generated Data" ); 

$sql = "
SELECT 
	
*

FROM TAB_MEMBER 
WHERE
	num_oid=$_OID $where $align
";



$data = $DB->sqlFetchAll($sql);

/*
		return array(
		'n' => '비회원',
		
		's' => '학생',
		'g' => '학부모',
	
		'm' => '맨토',
		'z' => '최고관리자' );
	

*/

function member_type($type) { //DB 회원 등급 변환
	switch($type) {
		case 'n' :
			return '비회원';
		case 's' :
			return '학생';
		case 'g' :
			return '학부모';
		case 'm' :
			return '맨토';
		case 'z' :
			return '최고관리자';
	}
}
?>

<html> 
<body>

	<table cellspacing="0" cellpadding="0" border="1">
	<col width="72" />
	<col width="100" span="2" />
	<col width="130" />
	<col width="72" />
	<col width="90" />
	
	<tr height="22">
		<td height="22" width="72"><div align="center">번호</div></td>
		<td width="100"><div align="center">아이디</div></td>
		<td width="100"><div align="center">이름</div></td>
		<td width="100"><div align="center">email</div></td>

		<td width="130"><div align="center">휴대폰</div></td>
		<td width="130"><div align="center">집전화</div></td>
		<td width="130"><div align="center">주소</div></td>
		<td width="130"><div align="center">자기소개</div></td>
		<td width="72"><div align="center">로그인수</div></td>
		<td width="90"><div align="center">가입일</div></td>
		
		<td width="72"><div align="center">회원등급</div></td>
	</tr>
	<?

	if (!$data){
		echo ("<tr><td height='28' align='center' colspan='8' bgcolor='#FFFFFF'>데이터가 없습니다.</font></td></tr>");  
	}else{
		for($i=0; $i<sizeof($data) ; $i++){

	?>
	<tr height="22">
		<td height="22"><?= $i; ?></td>
		<td><?=$data[$i][str_id]?></td>
		<td><?=$data[$i][str_name]?></td>
		<td><?=$data[$i][str_email]?></td>
		<td><?=$data[$i][str_handphone]?></td>
		<td><?=$data[$i][str_phone]?></td>
		<td><?=$data[$i][chr_zip]?> <?=$data[$i][str_addr1]?><?=$data[$i][str_addr2]?></td>
		<td><?=$data[$i][str_introduct]?></td>
		<td><?=$data[$i][num_login_cnt]?></td>
		<td><?=date("Y-m-d",$data[$i][dt_date])?></td>

		<td><?=member_type($data[$i][chr_mtype]);?></td>
	</tr>
	<?
		}
	}
	?>
	</table>

</body> 
</html> 