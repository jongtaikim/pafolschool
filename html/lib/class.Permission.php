<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: lib/class.Permission.php
* �ۼ���: 2006-03-25
* �ۼ���: �̹���
* ��  ��: �۹̼� �����ϱ�
*****************************************************************
* 
*/

class Permission {
	var $DB;
    var $var = array();

	function Permission() {
		$this->DB = &WebApp::singleton('DB');
	}

	function check($sect='menu',$code='00',$cond='r' , $mode = '') {

		if(!isset($this->var[$sect][$code][$cond])) {
            if(!is_array($_SESSION['MEM_TYPE'])) $_SESSION['MEM_TYPE'] = array('n');
            $cond = $cond{0};
            $sql = "
                SELECT
                    COUNT(*)
                FROM
                    ".TAB_MENU_RIGHT."
                WHERE
                    num_oid="._OID." AND 
                    str_sect='".$sect."' AND 
                    str_code='".$code."' AND 
                    str_group IN ('".implode("','",$_SESSION['MEM_TYPE'])."') AND
                    INSTR(str_right,'$cond') > 0";

			if($mode !="ok") {
			$this->var[$sect][$code][$cond] = $this->DB->sqlFetchOne($sql);	
			}else{

			
		 if($cond == "r") {
			$this->var[$sect][$code][$cond] = 1;
		  }
		  if($cond == "l" ) {
			$this->var[$sect][$code][$cond] = 1;
		  }


			}
		
			
		
		
		
			
        }
		return $this->var[$sect][$code][$cond] || $_SESSION['ADMIN'];
	}

	function apply($sect='menu',$code='00',$cond='r',$mesg=false) {
		if (!$mesg) $mesg = '�� �������� ������ ������ �ʾҽ��ϴ�'; // _('You have no access permission for this page');
		if($_SERVER[HTTP_HOST] == "id01lms.iknock.co.kr") {
			$mesg = '�������� �����ϴ�.';
			}
		if (!$this->check($sect,$code,$cond)) WebApp::moveBack($mesg);
	}
}

?>
