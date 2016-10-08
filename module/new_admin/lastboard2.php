<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
��
*****************************************************************
* 
*/



	$DB = &WebApp::singleton('DB');



	$sql = "SELECT
				/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
				 num_mcode, 
			str_title,  TO_CHAR(dt_date,'YYYY-MM-DD') dt_date, num_serial	
				FROM ".TAB_BOARD."
			WHERE
				NUM_OID='$_OID' AND
				NUM_MCODE = '$code' and
				ROWNUM <= 10 	
				
				
				";

	
	if($data = $DB->sqlFetchAll($sql)) {
		

		
		for($i=0,$cnt=count($data);$i<$cnt;$i++) {
			

			


$a = explode("-", $data[$i]['dt_date']);
	
 $data[$i]['dt_date2'] = $a[1]."/".$a[2]; 




			// �����
			if($use_thumb && $data[$i]['str_thumb']) {
				$data[$i]['thumb_url'] = $FH->get_thumb_url($data[$i]['str_thumb'],$conf['thumb_width']);
			}
      $data[$i]['is_recent'] = date('U') - strtotime($data[$i]['dt_date']) < 241920;
      // �۾� ���� ���� �ϴ� �κ�
	  $data[$i]['str_title2'] = Display::text_cut($data[$i]['str_title'],26,".."); 
	  $data[$i]['str_title3'] = Display::text_cut($data[$i]['str_title'],20,".."); //�强�׸� IJ3 �� ���� �������� ���ڼ� ����
	  $data[$i]['str_title4'] = Display::text_cut($data[$i]['str_title'],30,".."); //�׸� IJ2 �� ���� �������� ���ڼ� ����
	  $data[$i]['str_title5'] = Display::text_cut($data[$i]['str_title'],48,".."); //�׸� IJ2 �� ���� �������� ���ڼ� ����
	  	  $data[$i]['str_title6'] = Display::text_cut($data[$i]['str_title'],80,".."); //�׸� IJ2 �� ���� �������� ���ڼ� ����
		}
	}
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", WebApp::getTemplate("new_admin/lastboard2.htm"));
	$tpl->assign('LIST',$data);

	




?>