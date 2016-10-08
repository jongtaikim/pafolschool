<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* : lib/class.Permission3.php
* : 2004-11-25
* : 
*   :   (мс )
*****************************************************************
* 
*/

class Permission3 {
	var $_cond = array(
		'r' => 4,
		'w' => 2,
		'x' => 1
	);
	var $mcode;
	var $perm;
	var $is_admin;

	function Permission3() {
		$oid = WebApp::getConf('oid');
		$bid = $GLOBALS['bid'];
		$this->is_admin = ($oid == $bid);
		
		//==-- findout mcode from url --==//

		$this->mcode = $_REQUEST['code'];
		if( !isset($_REQUEST['code']) ){

			$this->mcode =$_REQUEST['mcode'];
		}

		$p = $_REQUEST['p'];
		if (!$this->mcode) {
			if ($p) {
				list(,$this->mcode) = explode('.',$p);
			} else {
				return;
			}
		}
		//==--    --==//
		$DB = &WebApp::singleton('DB');
		if ($menu_rights = $DB->sqlFetchAll("
			SELECT
				chr_group, num_right
			FROM
				TAB_BRANCH_MENU_RIGHT
			WHERE
				num_oid=$bid AND num_mcode=$this->mcode
		")) {
			$this->perm = array();
			foreach ($menu_rights as $rights) {
				$this->perm[$rights['chr_group']] = $rights['num_right'];
			}
		}
	}

	function check($cond='r') {
		$flag = false;
		if (!$this->is_admin) $mem_type = array('b');	// 'b' 
		else return true;
		foreach ($mem_type as $group) {
			if ($this->perm[$group] && ($this->perm[$group] & $this->_cond[$cond])) $flag = true;
		}
		return $flag;
	}

	function apply($cond='r') {
		if ($this->check($cond) == false) WebApp::moveBack('    ');
	}
}

?>