<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/
$excelnm = "��������(" . date("Y-m-d") . ")"; // ���� ���� ��

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
<caption><span>�������� �ɹ�</span></caption>
	<thead>
		<tr>
			<th>�̸�</th>
			<th>����ó</th>
			<th>�̸���</th>
			<th>ȸ�� �� �Ҽ�</th>
			<th>��û���</th>
			<th>��������</th>
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
			<td><? if($data[$ii][str_mailing] == 'y'){?><span style="color:blue">����</span><? }else{ ?><span style="color:red">����</span><? } ?></td>
		</tr>

		<? } ?>
	</tbody>
</table>