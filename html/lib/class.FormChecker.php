<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: lib/class.FormChecker.php
* �ۼ���: 2004-11-10
* �ۼ���: ��ģ����
* ��  ��: �� ���Ἲ üũ
*****************************************************************
* 
*/

if (!defined('FC_CONSTANTS')) {
	define('FC_CONSTANTS', true);
	define('FC_ERROR_NOBLANK', '{name}�� �ݵ�� �ԷµǾ�� �մϴ�');
	define('FC_ERROR_NOTVALID', '{name}�� �߸��Ǿ����ϴ�');
}

class FormChecker
{
	var $info;

	function FormChecker($infofile='')
    {
		$formstat = unserialize(base64_decode($_POST['__FORMSTAT']));
		if (!$infofile) $infofile = 'cache/dynamic/'.$formstat['__FORM_URL'].'/form_'.$formstat['__FORM_KEY'];
		if (!$this->_loadInfo($infofile)) $this->doError(_('Access Denied'));
	}

	function _loadInfo($infofile)
    {
		$fp = @fopen($infofile,'r');
		if (!$fp) return false;
		$_info_content = @fread($fp, filesize($infofile));
		$this->info = unserialize($_info_content);
		@fclose($fp);
		return true;
	}

	function check()
    {
		for ($i=0,$cnt=count($this->info); $i < $cnt; $i++) {
			$element = $this->info[$i];
			$_data = $_POST[$element['name']];
//			if ($element['required'] == 'required') {
			if ($element['required']) {
				if (!$_data) return $this->doError(FC_ERROR_NOBLANK,$element);
			}
            if ($element['option']) {
                $options = explode(' ',$element['option']);
                foreach ($option as $option) {
                    switch ($option) {
                        case 'email':
                            break;
                        case 'alpha':
                            break;
                        //...
                    }
                }
            }
		}
		return true;
	}

	function doError($msg,$el)
    {
		$elname = ($el['hname']) ? $el['hname'] : $el['name'];
		$msg = str_replace('{name}',$elname,$msg);
		$msg_func = (class_exists('WebApp')) ? array('WebApp','moveBack') : array(&$this,'moveBack');
		return call_user_func($msg_func,$msg);
	}

	function moveBack($msg="")
    {
		$msg = str_replace(array("\n","'"),array("\\n","\'"),$msg);
		echo "<script>alert('$msg');</script>";
		echo "<script>history.back();</script>";
		return false;
	}
}
?>
