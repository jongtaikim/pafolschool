<?php

if(!$pcode) WebApp::moveBack('잘못된 요청입니다.');
$DB = &WebApp::singleton('DB');
//$FH = &WebApp::singleton('FileHost','party',$pcode.'.intro');

switch($REQUEST_METHOD) {
	case "GET":
      
        if(!$mode) {
			$mode = "10";
        }

		$sql = "
			SELECT
			  * FROM ".TAB_PARTY."
			WHERE 
			   num_oid=$_OID AND num_pcode=$pcode"
			;
			$data2 = $DB->sqlFetchAll($sql);

		$data2[0][mode] = $mode;
		
		$tpl->setLayout('admin');
        $tpl->define('CONTENT','html/party/demo.htm');

 $tpl->assign( 
	array(
		"CONFIG" => $data2,
		));

$tpl->assign(array('mode'=>$mode));



	break;
	
	
	
	
	
	
	
	case "POST":
		
	$mk = mktime();
	switch ($mode) {
	
	case "str_officer":

$sql = "update TAB_PARTY set   str_officer = '$str_officer'  where num_oid = '$_OID' and num_pcode = '$num_pcode' ";

		$DB->query($sql);
		if($DB->commit()){
		echo '<script>alert("저장했습니다.");  history.go(-1);</script>';
		}else{
		echo 	$sql;
		}

	break;
	
	case "str_memo":

$sql = "update TAB_PARTY set   str_memo = '$str_memo'  where num_oid = '$_OID' and num_pcode = '$num_pcode' ";

		$DB->query($sql);
		if($DB->commit()){
		echo '<script>alert("저장했습니다.");  history.go(-1);</script>';
		}else{
		echo 	$sql;
		}

	break;


case "pass":


$sql = "update TAB_PARTY set   str_pass = '$str_pass'  where num_oid = '$_OID' and num_pcode = '$num_pcode' ";

		$DB->query($sql);
		if($DB->commit()){
		echo '<script>alert("저장했습니다.");  history.go(-1);</script>';
		}else{
		echo 	$sql;
		}

	break;

	
case "upload1":
                if(!$logo_file1) {
					 WebApp::moveBack('파일을 선택해주세요.');
                }
			
				$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
                $addr=_DOC_ROOT.'/hosts/'.HOST.'/files/'.$pcode.$mk.'_logo_file.jpg';
				$addr2='/hosts/'.HOST.'/files/'.$pcode.$mk.'_logo_file.jpg';

				 $sql = "UPDATE ".TAB_PARTY." SET str_img1='$addr2' WHERE num_oid=$_OID AND num_pcode=$pcode";
				 if(!$DB->query($sql)) WebApp::moveBack('변경 실패하였습니다.');
                $DB->commit();

                $FTP->put($logo_file1,$addr);
                				

                WebApp::moveBack();
				break;



   case "upload_del1":
                $addr='hosts/'.$HOST.'/files/'.$str_img1;    
				
				$sql = "UPDATE ".TAB_PARTY." SET str_img1='' WHERE num_oid=$_OID AND num_pcode=$pcode";
				 if(!$DB->query($sql)) WebApp::moveBack('변경 실패하였습니다.');
                $DB->commit();
                
				if(file_exists($addr))
                {
                $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
                $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/files/'.$str_img1);
                }else{
                    echo "
                    <script>
                    alert('등록된 사진이없습니다');
                    </script> 
                    ";
                }
              break;  





case "upload2":
                if(!$logo_file2) {
					 WebApp::moveBack('파일을 선택해주세요.');
                }
			
				$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
                $addr=_DOC_ROOT.'/hosts/'.HOST.'/files/'.$pcode.$mk.'_logo_file.jpg';
				$addr2='/hosts/'.HOST.'/files/'.$pcode.$mk.'_logo_file.jpg';

				 $sql = "UPDATE ".TAB_PARTY." SET str_img3='$addr2' WHERE num_oid=$_OID AND num_pcode=$pcode";
				 if(!$DB->query($sql)) WebApp::moveBack('변경 실패하였습니다.');
                $DB->commit();

                $FTP->put($logo_file2,$addr);
                				

                WebApp::moveBack();
				break;



   case "upload_del2":
                $addr='hosts/'.$HOST.'/files/'.$str_img3;    
				
				$sql = "UPDATE ".TAB_PARTY." SET str_img3='' WHERE num_oid=$_OID AND num_pcode=$pcode";
				 if(!$DB->query($sql)) WebApp::moveBack('변경 실패하였습니다.');
                $DB->commit();
                
				if(file_exists($addr))
                {
                $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
                $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/files/'.$str_img3);
                }else{
                    echo "
                    <script>
                    alert('등록된 사진이없습니다');
                    </script> 
                    ";
                }
              break;  




   case "bgselect":
                
				
				$sql = "UPDATE ".TAB_PARTY." SET str_img2='$bgselect' WHERE num_oid=$_OID AND num_pcode=$pcode";
				 if(!$DB->query($sql)) WebApp::moveBack('변경 실패하였습니다.');
                if($DB->commit()){
				echo '<script>alert("저장했습니다.");  history.go(-1);</script>';
				}else{
				echo 	$sql;
				}
						
				
              break;  


	case "bgselect2":
                if(!$logo_file2) {
					 WebApp::moveBack('파일을 선택해주세요.');
                }
			
				$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
                $addr=_DOC_ROOT.'/hosts/'.HOST.'/files/'.$pcode.$mk.'_logo_file.jpg';
				$addr2='/hosts/'.HOST.'/files/'.$pcode.$mk.'_logo_file.jpg';

				 $sql = "UPDATE ".TAB_PARTY." SET str_img2='$addr2' WHERE num_oid=$_OID AND num_pcode=$pcode";
				 if(!$DB->query($sql)) WebApp::moveBack('변경 실패하였습니다.');
                $DB->commit();

                $FTP->put($bgselect2,$addr);
                				

                WebApp::moveBack();
				break;

		case "color":






		$sql = "update TAB_PARTY set   str_color1 = '$str_color1', str_color2 = '$str_color2'   where num_oid = '$_OID' and num_pcode = '$num_pcode' ";

		$DB->query($sql);
		if($DB->commit()){
		echo '<script>alert("저장했습니다.");  history.go(-1);</script>';
		}else{
		echo 	$sql;
		}

	break;
	
	
	}//각종 모드 끝


	break;
}
?>