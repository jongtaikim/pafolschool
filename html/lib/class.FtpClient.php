<?
/**************************************
* ���ϸ�: class.FtpClient.php
* �ۼ���: 2003-02-24
* �ۼ���: ��ģ����
* ��  ��: ftp Ŭ���̾�Ʈ
* <���Ĺ���>
***************************************/

/*
2003-03-02 queue ��� �߰�
2003-07-02 put_r ��� �߰�
2003-11-05 put_r �� �ݹ��Լ� ��� �߰�
2004-01-04 ftp ��Ʈ�� 21���� �ƴҰ�쿡 ���� ó��
*/

define(FTP_AUTO,2);
define(FTP_DIRECTTO_BROWSER,1);

/** 
* ftp Ŭ���̾�Ʈ Ŭ����
* 
* @author ��ģ���� (comfuture@maniacamp.com)
* @date 2003-02-24
* @access public
* @see http://kr.php.net/manual/kr/ref.ftp.php
*/
class FtpClient {

	var $conn;
	var $addr;
	var $user;
	var $pass;
	var $error;
	var $queue;
	var $debug;
	var $osType;
	var $transMode;
	var $_transModeAutoSelect;

	/** 
	* ASCII ���� �����ϱ� ���ϴ� ���� Ȯ���ڸ� �����մϴ�.
	* Ŭ���̾�Ʈ ��尡 FTP_AUTO (�� Ŭ���������� ���̴� ��������� ���)�϶� �ڵ����� ��带 �����Ҷ� �����˴ϴ�.
	*
	* @var array
	*/
	var $forceAsciiExts = array(
		"txt","html","htm","php","php3","inc","phtml","js","pl","py","c","cpp","h","sql"
	);

	function FtpClient($address="",$user="anonymous",$pass="ftpclient@phpclass") {
		if (!@function_exists("ftp_connect")) {
			$this->raiseError(_('Error: ftp extension not loaded'));
			return false;
		}
		if ($address) $this->connect($address,$user,$pass);
		$this->queue = array();
		$this->error = array();
		register_shutdown_function(array(&$this,"close"));
	}

	/** 
	* ftp ������ �����մϴ�.
	* $user�� $pass�� ������ ��� anonymous�� ������ �õ��մϴ�.
	* 
	* @param string $address : ������ ftp �ּ�
	* @param string $user : �α��� ����� ���̵� (default "anonymous")
	* @param string $pass : �α��� ����� �н����� (default "ftpclient@phpclass")
	* @return boolean
	*/
	function connect($address, $user="anonymous",$pass="ftpclient@phpclass") {
		if (is_array($address)) { 
			list($address,$user,$pass) = array_values($address);
		}
		$this->addr = $address;
		$this->user = $user;
		$this->pass = $pass;
		$this->port = 21;
		if (strpos($this->addr,':')) {
			$_tmp = explode(':',$this->addr);
			$this->addr = $_tmp[0];
			$this->port = $_tmp[1];
		}


		$this->conn = @ftp_connect($this->addr,$this->port);
		if ($this->conn) {
			if (!@ftp_login($this->conn,$this->user,$this->pass)) {
				$this->raiseError(_('Error: invalid user or password'));
				return false;
			}
			$this->osType = @ftp_systype($this->conn);
			$this->setMode(FTP_AUTO);
		} else {
			$this->raiseError(_('Error: Can not connect to server'));
			return false;
		}
		return true;
	}

	/** 
	* ���۽� ���� ��带 �����մϴ�.
	* FTP_AUTO�� ������ ��� ������ ������ Ȯ���ڸ� ���� �ڵ����� ��带 �����մϴ�.
	* 
	* @param int $mode {FTP_ASCII, FTP_BINARY, FTP_AUTO} ���� ���
	* @return true
	*/
	function setMode($mode=FTP_AUTO) {
		if ($mode == FTP_AUTO) {
			$this->_transModeAutoSelect = true;
		} else {
			$this->_transModeAutoSelect = false;
			$this->transMode = $mode;
		}
		return true;
	}

	/** 
	* passive ��带 ����� ���ΰ� ���θ� �����մϴ�.
	* ������ ��ȭ�� �ڿ� ������� passive ���� �����ؾ� �ۼ����� �����մϴ�.
	* 
	* @param boolean $mode passive ��� on �Ǵ� off
	* @return boolean ��� ��ȯ ���� ����
	*/
	function pasv($mode) {
		return @ftp_pasv($this->conn,$mode);
	}

	/**
	* ���� ���丮 path ����
	* 
	* @return string
	*/
	function pwd() {
		return @ftp_pwd($this->conn);
	}

	/** 
	* ���� ���丮�� �̵��մϴ�.
	* 
	* @return string ���� �̵� ������ ���� �۾����丮��, ���н� false
	*/
	function cdup() {
		if (@ftp_cdup($this->conn)) {
			return @ftp_pwd($this->conn);
		} else {
			$this->raiseError("���� ���丮�� �̵��� �� �����ϴ�");
			return false;
		}

	}

	/** 
	* ���丮�� �ۼ��մϴ�.
	* 
	* @param string $dir �ۼ��� ���丮��
	* @return boolean �ۼ� ��������
	*/
	function mkdir($dir) {
		return (@ftp_mkdir($this->conn,$dir));
	}

	/** 
	* �۾� ���丮�� �����մϴ�
	* 
	* @param string $path ������ ���丮��
	* @return string ���丮 �̵� ������ �̵��� �۾� ���丮��, ���н� false
	*/
	function chdir($path) {
		if (@ftp_chdir($this->conn,$path)) {
			return @ftp_pwd($this->conn);
		} else {
			$this->raiseError("���丮�� ������ �� �����ϴ�");
			return false;
		}
	}

	/** 
	* ���丮�� �����մϴ�.
	* $recursive�� true �ϰ�� ���� ���丮�� ���ϱ��� ��� ����ϴ�.
	*
	* @param string $dir ������ ���丮��
	* @param $recursive �������丮���� ��������� ������ ������ ���� (defualt: false)
	* @return boolean ���� ��������
	*/
	function rmdir($dir,$recursive=false) {
		if ($recursive) {
			$list = @ftp_nlist($this->conn,$dir);
			if (is_array($list)) {
				foreach($list as $item) {
					if (@ftp_size($this->conn,"$dir/$item") == -1) {
						$this->rmdir("$dir/$item");
					} else {
						@ftp_delete($this->conn,"$dir/$item");
					}
				}
			}
		}
		if (!@ftp_rmdir($this->conn,$dir)) {
			$this->raiseError("���丮�� ������ �� �����ϴ�");
			return false;
		}
		return true;
	}

	/** 
	* ���� �۾����丮�� ���� ����� �ҷ��ɴϴ�.
	* $detail �� true �ΰ�� ���� ������, �ۼ���, �����ϱ��� ������ �ڼ��� ����Ʈ�� ��ø �迭�� �����մϴ�.
	* 
	* @param string $dir ����� ������ ���丮��
	* @param boolean $detail �ڼ��� ����� �������� ����
	*/
	function getList($dir="./", $detail=true) {
		if ($detail) {
			$ret = @ftp_rawlist($this->conn,$dir);
			if (is_array($ret)) {
				array_walk($ret,array($this,"_cbParse"));
			}
		} else {
			$ret = @ftp_nlist($this->conn,$dir);
		}
		return $ret;
	}

	/** 
	* ���ϸ��� �����մϴ�.
	* 
	* @param string $from ���� ���ϸ�
	* @param string $to �ٲ� ���ϸ�
	* @return boolean �̸����� ��������
	*/
	function rename($from,$to) {
		return (@ftp_rename($this->conn, $from, $to));
	}

	/** 
	* ������ ������ ��η� �ű�ϴ�.
	* rename ���� ��� ����������.. ���Ǹ� ���ؼ� ��������ϴ�.
	* 
	* @param $file �̵���ų ���ϸ�
	* @param $dir Ÿ�� ���丮
	* @return boolean �̵� ��������
	*/
	function move($file,$dir) {
		return (@ftp_rename($this->conn, $file, "$dir/$file"));
	}

	/** 
	* ������ �����մϴ�.
	* 
	* @param string $file ������ ���ϸ�
	* @return boolean ���� ��������
	*/
	function delete($file) {
		return @ftp_delete($this->conn,$file);
	}

	/** 
	* ���� permission �ٲٱ�
	* 
	* @param string $file �۹̼� ������ ���ϸ�
	* @param int $mode ������ ��� (ex. 0777)
	* @return boolean ��� ���� ��������
	*/
	function chmod($file,$mode) {
		return @ftp_site($this->conn, "CHMOD $mode $file");
	}

	/** 
	* ������ ftp ������ �����մϴ�.
	* 
	* @param stirng $localFile ����ǻ�Ϳ� �ִ� ���� ���
	* @param string $remoteFile ������ ������ ���� ��� �� ���ϸ�
	* @return boolean ���� ��������
	*/
	function put($localFile,$remoteFile="") {
		if ($this->_transModeAutoSelect == true) $this->_chooseMode($localFile);
		if (!$fp = @fopen($localFile,"r")) {
			$this->raiseError("��Į ������ ���� �����ϴ�");
			return false;
		} else {
			if (!$remoteFile) {
				$remoteFile = $this->pwd().array_pop(explode("/",$localFile));
			}
			return (@ftp_put($this->conn, $remoteFile, $localFile, $this->transMode));
		}
	}

	/**
	* ��Ʈ���� ������ ���Ͽ� ����մϴ�.
	*
	* @param string $str ������ ������ 
	* @param string $remoteFile ����� ���ϰ�� 
	* @return boolean �������� 
	*/
	function put_string($str, $remoteFile="") {
		$tmpfile = tempnam('/tmp','ftpsave_');
		$fp = fopen($tmpfile,'w');
		fwrite($fp,$str);
		return ($this->put($tmpfile, $remoteFile) & unlink($tmpfile));
	}

	/** 
	* ������ ������� ftp ������ �����մϴ�.
	* 
	* @param stirng $localDir ����ǻ�Ϳ� �ִ� ������
	* @param string $remoteDir ������ ������ ���
	* @return boolean ���� ��������
	*/
	function put_r($localDir,$remoteDir=".",$callback=null) {
		if (!is_dir($localDir)) return $this->raiseError("��Į ���丮�� ã�� �� �����ϴ�");
		$d = dir($localDir);
//		$wholesize = `du -s $localDir`;
		while($file = $d->read()) {
			if ($file{0} != ".") {
				if (is_dir($localDir."/".$file)) {
					if (!$this->chdir($remoteDir."/".$file)) {
						$this->mkdir($remoteDir."/".$file);
					}
					$_perm = substr((string)decoct(fileperms($localDir.'/'.$file)),-4);
					$this->chmod($remoteDir."/".$file, $_perm);
					$this->put_r($localDir."/".$file, $remoteDir."/".$file, $callback);

				} else {
					$this->put($localDir."/".$file, $remoteDir."/".$file);
					$filesize = filesize("$localDir/$file");
					$_perm = substr((string)decoct(fileperms($localDir.'/'.$file)),-4);
					$this->chmod($remoteDir."/".$file, $_perm);
				}
				
				if ($callback != null) {
					call_user_func($callback,$filesize,"$remoteDir/$file");
				}
			}
		}
		$d->close();
	}

	/** 
	* �ش� ���丮�� �����ϴ��� üũ�ϰ� ������ ������ش�.
	* 
	* @param stirng $dir üũ�� ���丮
	* @param string $ndir ���������� �ֻ��� ���丮
	* @return boolean ��������
	*/
	function check_dir($dir = '',$ndir = '') {
		if($dir == '') return false;
		if($this->chdir($dir)) {
			return true;
		} else {
			if($dir == $ndir) return false;
			$pdir = substr($dir,0,strrpos($dir,'/'));
			if($this->check_dir($pdir,$ndir)) {
				if(!$this->mkdir(substr($dir,strrpos($dir,'/')+1))) return false;
				if($this->chdir($dir)) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

	/** 
	* �����κ��� ������ �޾ƿɴϴ�.
	* $localFile�� �������� �ʾҰų� FTP_DIRECTTO_BROWSER�� �����Ȱ�� ���������� �ٿ�ε�����ݴϴ�.
	* 
	* @param string $remoteFile �ٿ���� ���ϸ�
	* @param mixed $localFile ������ ���ϸ� �Ǵ� FTP_DIRECTTO_BROWSER (���� �ٿ�ε� ���)
	* @return boolean �ٿ�ε� ��������
	*/
	function get($remoteFile,$localFile="") {
		if ($this->_transModeAutoSelect == true) $this->_chooseMode($remoteFile);
		if (!$localFile) { }	// ���ϸ��� �������� �ʾ������ �ٿ�ε� ��ο� ���� ���� (������)
		if ($localFile == FTP_DIRECTTO_BROWSER) {
			if (headers_sent()) {
				$this->raiseError("����� �̹� ���۵Ǿ����ϴ�.");
				return false;
			}
			$localFile = tempnam("/tmp","FTPTMP_");
			@ftp_get($this->conn, $localFile, $remoteFile, $this->transMode);
			$filename = array_pop(explode("/",$remoteFile));

			// �̺κ� ���� �ʿ�
			Header("Content-type: file/unknown");
			Header("Content-Length: ".filesize($localFile));
			Header("Content-Disposition: attachment; filename=$filename");
			Header("Expires: 0"); 

			$fp = fopen($localFile,"r");
			@fpassthru($fp);
			@fclose($fp);
			@unlink($localFile);
		} else {
			return @ftp_get($this->conn, $localFile, $remoteFile, $this->transMode);
		}
	}

	// �۾���Ͽ� �߰� (������)
	function queue($type,$targetFile,$destFile="") {
		$this->queue[] = array(
			type	=>	$type,
			target	=>	$targetFile,
			dest	=>	$destFile
		);
		return true;
	}

	// �۾���� ���� (������)
	function cue() {
		if (count($this->queue) > 0) {
			foreach($thie->queue as $item) {
				$this->$item['type']($item['target'],$item['dest']);
			}
		}
	}

	/**
	* ftp ������ �����մϴ�
	* 
	*/
	function close() {
		@ftp_quit($this->conn);
	}

	/** 
	* ftp Ŀ��带 ���� �����մϴ�
	* 
	* @param string $cmd ������ ��ɶ���
	* @return boolean ������ ���� �޽��� �Ǵ� ���н� false
	*/
	function exec($cmd) {
		return (@ftp_exec($this->conn, $cmd));
	}

	//������ �߻���Ŵ
	function raiseError($msg) {
		$this->error[] = $msg;
		if ($this->debug) echo $msg."<br>\n";
		return false;
	}

	// ������ ���
	function showErrors() {
		for($i=0,$cnt=count($this->error); $i<$cnt; $i++) {
			echo $this->error[$i]."<br>\n";
		}
	}

	// Ȯ���ڿ� ���� ���� ��� �ڵ� ����
	function _chooseMode($file) {
		$ext = array_pop(explode(".",$file));
		if (array_search($ext,$this->forceAsciiExts)) {
			$this->transMode = FTP_ASCII;
		} else {
			$this->transMode = FTP_BINARY;
		}
		return $this->transMode;
	}

	// rawlist�� �Ľ�
	function _cbParse(&$line) {
		$types = array('d'=>"directory",'l'=>"link",'-'=>"file");
		$ret = array();
		if ($this->osType == "UNIX") {
			if (ereg("([-dl])([rwxst-]{9}).* ([0-9]*) [a-zA-Z]+ [0-9: ]*[0-9] (.+)",$line,&$reg)) { 
				$ret['type'] = $types[$reg[1]];
				$ret['permission'] = $reg[2];
				$ret['size'] = $reg[3]; 
				$ret['filename'] = $reg[4]; 
			}
		} elseif ($this->osType == "NT") {
			if(ereg("([-0-9]+ *[0-9:]+[PA]?M? +<DIR> {10})(.*)",$line,&$reg)) {
				$ret['type'] = "directory";
			} elseif(ereg("[-0-9]+ *[0-9:]+[PA]?M? +([0-9]+) (.*)",$line,&$reg)) { 
				$ret['type'] = "file";
			}
			$ret['size'] = $reg[1];
			$ret['filename'] = $reg[2];
		}
		if ($ret['type'] == "file") $ret['modifydate'] = @ftp_mdtm($this->conn, $ret['filename']);

		$line = $ret;
	}
	
}


?>
