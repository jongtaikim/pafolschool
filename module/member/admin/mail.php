<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-10-21
* 작성자: 김종태
* 설  명: MAIL보내기 일반발송
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch($mode) {
	case "jak":
     
for($ii=0; $ii<count($ids); $ii++) {


  $sql = "SELECT str_email FROM ".TAB_MEMBER." WHERE num_oid=$_OID and str_id = '".$ids[$ii]."' ";
  $hhp = $DB->sqlFetchOne($sql);
  $hp .= $hhp."|";

	
}

		
        $sql = "SELECT num_point FROM ".TAB_SMS_ORGAN." WHERE num_oid=$_OID";
        $num_point = $DB->sqlFetchOne($sql);

		

        $tpl->setLayout('admin');
		$tpl->define('CONTENT','/html/member/admin/mail.htm');
		$tpl->assign(array(
			'hp'=>$hp,
		 'num_point'  => $num_point,	
		));
		
       
	break;
	case "send":

   
	$hp = substr($hp,0,strlen($hp)-1);

	$hp = explode("|",$hp);
	
 

	 for($ii=0; $ii<count($hp); $ii++) {
		
		$mail_header = "From: $name <$rmail>\n";
		$mail_header .= "Reply-to: $rmail\n";
		$mail_header .= "MIME-Version: 1.0\n";
		$mail_header .= "Content-Type: text/html; charset=euc-kr\n";
		$mail_header .= "X-Mailer: INNOMEDISYS Mailer\n";

		

		mail($hp[$ii],$title,$cont,$mail_header);

	 }
 
	
	

	echo '<script>alert("'.count($hp).'건 발송완료");</script>';
   echo "<script>  

   parent.closew2();
      self.close();
   </script>";
   exit;	
            
			   
				
			

		
	break;
}
?>