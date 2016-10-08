<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: member/admin/view.php
* 작성일: 2006-03-20
* 작성자: 이범민
* 설  명: 회원정보
*****************************************************************
* 
*/
if (!$id = $_REQUEST['id']) {
    WebApp::alert('잘못된 요청입니다.');
    WebApp::closeWin();
}
$DB = &WebApp::singleton('DB');

switch($REQUEST_METHOD) {
	case "GET":
        $sql = "SELECT
          str_name, str_id, 
		   str_passwd, chr_mtype, num_fcode, 
		   str_email, chr_zip, str_addr1, 
		   str_addr2, num_birthday, chr_birthday, 
		   num_happyday, str_introduct, str_photo, 
		   num_auth, num_login_cnt, str_ip, 
		   TO_CHAR(dt_date,'YYYYMMDD') dt_date, str_phone, str_handphone, 
		   num_jumin, str_job, str_voll, 
		   str_group, str_state, num_grade, 
		   num_hid

                FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_id='$id'";
        if(!$data = $DB->sqlFetch($sql)) {
            WebApp::alert('데이타가 존재하지 않습니다.');
            WebApp::closeWin();
        }
        $data['id'] = $id;
        $mem_types = WebApp::get('member',array('key'=>'member_types'));
        $data['mtype'] = $mem_types[$data['chr_mtype']];
        if($data['num_fcode']) {
            $sql = "SELECT str_fname_full FROM ".TAB_CLASS_FORMATION." WHERE num_oid=$_OID AND num_fcode=".$data['num_fcode'];
            $data['fname_full'] = $DB->sqlFetchOne($sql);
        }
        if($data['str_photo']) $data['photo_url'] = 'hosts/'.HOST.'/files/member/'.$data['str_photo'];
		

		$jumin = explode("-",$data[num_jumin]);
		$data[jumin1] = $jumin[0];
		$data[jumin2] = $jumin[1];
		
		
		$tel = explode("-",$data[str_handphone]);
		$data[tel1] = $tel[0];
		$data[tel2] = $tel[1];
		$data[tel3] = $tel[2];

	$tel1 = explode("-",$data[str_phone]);
		$data[tel11] = $tel1[0];
		$data[tel22] = $tel1[1];
		$data[tel33] = $tel1[2];



        // 등록된 그룹
        $sql = 'SELECT '.
                    'G.str_group_name '.
                'FROM '.TAB_GROUP_MEMBER.' GM '.
                'LEFT JOIN TAB_GROUP G ON '.
                    'G.num_oid=GM.num_oid AND '.
                    'G.str_group=GM.str_group '.
                'WHERE '.
                    'GM.num_oid='.$_OID.' AND '.
                    "GM.str_id='".$id."'";
        if($group_data = $DB->sqlFetchAll($sql)) {
            $groups = array();
            foreach($group_data as $row) {
                $groups[] = $row['str_group_name'];
            }
            $data['groups'] = implode(', ',$groups);
        }

		$tpl->setLayout('admin');
        $tpl->define('CONTENT','html/lms_member/admin/view_lms.htm');
        $tpl->assign($data);
	break;
	case "POST":
	
	


	
	break;
}
?>