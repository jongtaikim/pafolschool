<?
/**************************************
* 파일명: class.FtpClient.php
* 작성일: 2003-02-24
* 작성자: 거친마루
* 설  명: ftp 클라이언트
* <알파버전>
***************************************/

/*
2003-03-02 queue 기능 추가
2003-07-02 put_r 기능 추가
2003-11-05 put_r 에 콜백함수 기능 추가
2004-01-04 ftp 포트가 21번이 아닐경우에 대한 처리
*/

define(FTP_AUTO,2);
define(FTP_DIRECTTO_BROWSER,1);

/** 
* ftp 클라이언트 클래스
* 
* @author 거친마루 (comfuture@maniacamp.com)
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
	* ASCII 모드로 전송하기 원하는 파일 확장자를 나열합니다.
	* 클라이언트 모드가 FTP_AUTO (이 클래스에서만 쓰이는 사용자정의 모드)일때 자동으로 모드를 결정할때 참조됩니다.
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
	* ftp 서버로 접속합니다.
	* $user와 $pass를 생략할 경우 anonymous로 접속을 시도합니다.
	* 
	* @param string $address : 접속할 ftp 주소
	* @param string $user : 로그인 사용자 아이디 (default "anonymous")
	* @param string $pass : 로그인 사용자 패스워드 (default "ftpclient@phpclass")
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
	* 전송시 사용될 모드를 결정합니다.
	* FTP_AUTO로 설정할 경우 전송할 파일의 확장자를 통해 자동으로 모드를 결정합니다.
	* 
	* @param int $mode {FTP_ASCII, FTP_BINARY, FTP_AUTO} 전송 모드
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
	* passive 모드를 사용할 것인가 여부를 설정합니다.
	* 서버가 방화벽 뒤에 있을경우 passive 모드로 접속해야 송수신이 가능합니다.
	* 
	* @param boolean $mode passive 모드 on 또는 off
	* @return boolean 모드 전환 성공 여부
	*/
	function pasv($mode) {
		return @ftp_pasv($this->conn,$mode);
	}

	/**
	* 현재 디렉토리 path 리턴
	* 
	* @return string
	*/
	function pwd() {
		return @ftp_pwd($this->conn);
	}

	/** 
	* 상위 디렉토리로 이동합니다.
	* 
	* @return string 상위 이동 성공시 현재 작업디렉토리명, 실패시 false
	*/
	function cdup() {
		if (@ftp_cdup($this->conn)) {
			return @ftp_pwd($this->conn);
		} else {
			$this->raiseError("상위 디렉토리로 이동할 수 없습니다");
			return false;
		}

	}

	/** 
	* 디렉토리를 작성합니다.
	* 
	* @param string $dir 작성할 디렉토리명
	* @return boolean 작성 성공여부
	*/
	function mkdir($dir) {
		return (@ftp_mkdir($this->conn,$dir));
	}

	/** 
	* 작업 디렉토리를 변경합니다
	* 
	* @param string $path 변경할 디렉토리명
	* @return string 디렉토리 이동 성공시 이동한 작업 디렉토리명, 실패시 false
	*/
	function chdir($path) {
		if (@ftp_chdir($this->conn,$path)) {
			return @ftp_pwd($this->conn);
		} else {
			$this->raiseError("디렉토리를 변경할 수 없습니다");
			return false;
		}
	}

	/** 
	* 디렉토리를 삭제합니다.
	* $recursive가 true 일경우 하위 디렉토리와 파일까지 모두 지웁니다.
	*
	* @param string $dir 삭제할 디렉토리명
	* @param $recursive 하위디렉토리까지 재귀적으로 삭제할 것인지 여부 (defualt: false)
	* @return boolean 삭제 성공여부
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
			$this->raiseError("디렉토리를 삭제할 수 없습니다");
			return false;
		}
		return true;
	}

	/** 
	* 현재 작업디렉토리의 파일 목록을 불러옵니다.
	* $detail 이 true 인경우 파일 사이즈, 작성일, 수정일까지 포함한 자세한 리스트를 중첩 배열로 리턴합니다.
	* 
	* @param string $dir 목록을 가져올 디렉토리명
	* @param boolean $detail 자세한 목록을 가져올지 여부
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
	* 파일명을 변경합니다.
	* 
	* @param string $from 기존 파일명
	* @param string $to 바꿀 파일명
	* @return boolean 이름변경 성공여부
	*/
	function rename($from,$to) {
		return (@ftp_rename($this->conn, $from, $to));
	}

	/** 
	* 파일을 지정한 경로로 옮깁니다.
	* rename 으로 사용 가능하지만.. 편의를 위해서 만들었습니다.
	* 
	* @param $file 이동시킬 파일명
	* @param $dir 타겟 디렉토리
	* @return boolean 이동 성공여부
	*/
	function move($file,$dir) {
		return (@ftp_rename($this->conn, $file, "$dir/$file"));
	}

	/** 
	* 파일을 삭제합니다.
	* 
	* @param string $file 삭제할 파일명
	* @return boolean 삭제 성공여부
	*/
	function delete($file) {
		return @ftp_delete($this->conn,$file);
	}

	/** 
	* 파일 permission 바꾸기
	* 
	* @param string $file 퍼미션 변경할 파일명
	* @param int $mode 변경할 모드 (ex. 0777)
	* @return boolean 모드 변경 성공여부
	*/
	function chmod($file,$mode) {
		return @ftp_site($this->conn, "CHMOD $mode $file");
	}

	/** 
	* 파일을 ftp 서버에 전송합니다.
	* 
	* @param stirng $localFile 내컴퓨터에 있는 파일 경로
	* @param string $remoteFile 서버에 저장할 파일 경로 및 파일명
	* @return boolean 전송 성공여부
	*/
	function put($localFile,$remoteFile="") {
		if ($this->_transModeAutoSelect == true) $this->_chooseMode($localFile);
		if (!$fp = @fopen($localFile,"r")) {
			$this->raiseError("로칼 파일을 열수 없습니다");
			return false;
		} else {
			if (!$remoteFile) {
				$remoteFile = $this->pwd().array_pop(explode("/",$localFile));
			}
			return (@ftp_put($this->conn, $remoteFile, $localFile, $this->transMode));
		}
	}

	/**
	* 스트링을 원격지 파일에 기록합니다.
	*
	* @param string $str 저장할 컨텐츠 
	* @param string $remoteFile 저장될 파일경로 
	* @return boolean 성공여부 
	*/
	function put_string($str, $remoteFile="") {
		$tmpfile = tempnam('/tmp','ftpsave_');
		$fp = fopen($tmpfile,'w');
		fwrite($fp,$str);
		return ($this->put($tmpfile, $remoteFile) & unlink($tmpfile));
	}

	/** 
	* 폴더를 구조대로 ftp 서버에 복사합니다.
	* 
	* @param stirng $localDir 내컴퓨터에 있는 폴더명
	* @param string $remoteDir 서버에 저장할 경로
	* @return boolean 전송 성공여부
	*/
	function put_r($localDir,$remoteDir=".",$callback=null) {
		if (!is_dir($localDir)) return $this->raiseError("로칼 디렉토리를 찾을 수 없습니다");
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
	* 해당 디렉토리가 존재하는지 체크하고 없으면 만들어준다.
	* 
	* @param stirng $dir 체크할 디렉토리
	* @param string $ndir 접근제한할 최상위 디렉토리
	* @return boolean 성공여부
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
	* 서버로부터 파일을 받아옵니다.
	* $localFile이 지정되지 않았거나 FTP_DIRECTTO_BROWSER로 설정된경우 웹페이지로 다운로드시켜줍니다.
	* 
	* @param string $remoteFile 다운받을 파일명
	* @param mixed $localFile 저장할 파일명 또는 FTP_DIRECTTO_BROWSER (직접 다운로드 모드)
	* @return boolean 다운로드 성공여부
	*/
	function get($remoteFile,$localFile="") {
		if ($this->_transModeAutoSelect == true) $this->_chooseMode($remoteFile);
		if (!$localFile) { }	// 파일명이 정해지지 않았을경우 다운로드 경로에 대한 설정 (개발중)
		if ($localFile == FTP_DIRECTTO_BROWSER) {
			if (headers_sent()) {
				$this->raiseError("헤더가 이미 전송되었습니다.");
				return false;
			}
			$localFile = tempnam("/tmp","FTPTMP_");
			@ftp_get($this->conn, $localFile, $remoteFile, $this->transMode);
			$filename = array_pop(explode("/",$remoteFile));

			// 이부분 보강 필요
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

	// 작업목록에 추가 (개발중)
	function queue($type,$targetFile,$destFile="") {
		$this->queue[] = array(
			type	=>	$type,
			target	=>	$targetFile,
			dest	=>	$destFile
		);
		return true;
	}

	// 작업목록 실행 (개발중)
	function cue() {
		if (count($this->queue) > 0) {
			foreach($thie->queue as $item) {
				$this->$item['type']($item['target'],$item['dest']);
			}
		}
	}

	/**
	* ftp 접속을 종료합니다
	* 
	*/
	function close() {
		@ftp_quit($this->conn);
	}

	/** 
	* ftp 커멘드를 직접 실행합니다
	* 
	* @param string $cmd 실행할 명령라인
	* @return boolean 실행후 리턴 메시지 또는 실패시 false
	*/
	function exec($cmd) {
		return (@ftp_exec($this->conn, $cmd));
	}

	//에러를 발생시킴
	function raiseError($msg) {
		$this->error[] = $msg;
		if ($this->debug) echo $msg."<br>\n";
		return false;
	}

	// 에러를 출력
	function showErrors() {
		for($i=0,$cnt=count($this->error); $i<$cnt; $i++) {
			echo $this->error[$i]."<br>\n";
		}
	}

	// 확장자에 따라 전송 모드 자동 선택
	function _chooseMode($file) {
		$ext = array_pop(explode(".",$file));
		if (array_search($ext,$this->forceAsciiExts)) {
			$this->transMode = FTP_ASCII;
		} else {
			$this->transMode = FTP_BINARY;
		}
		return $this->transMode;
	}

	// rawlist를 파싱
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
