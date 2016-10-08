<?
/**********************************************
* 파일명: class.AttachFile.php
* 설  명: 첨부파일의 모든것
* 날  짜: 2003-06-05
* 작성자: 거친마루
***********************************************/

define (UPLOAD_ORIGINAL,0);
define (UPLOAD_TIMESTAMP,1);
define (UPLOAD_UNIQID,2);

define (UPLOAD_NOMKDIR,0);
define (UPLOAD_MKDIR,1);

class AttachFile {

	var $path;
	var $ext;
	var $naming;

	function AttachFile($naming=UPLOAD_ORIGINAL,$ext="") {
		if ($naming) $this->setNamingMethod($naming);
		if ($ext) $this->setSaveExt($ext);
	}

	function setSavePath($path,$noexists=UPLOAD_MKDIR) {
		$this->path = $path;
		if (!is_dir($this->path) && $noexists == UPLOAD_MKDIR) {
			AttachFile::mkdir($path);
		}
	}

	function setSaveExt($ext) {
		$this->ext = $ext;
	}

	function setNamingMethod($naming) {
		$this->naming = $naming;
	}

	function saveTo($path) {
		$this->setSavePath($path);
		return $this->save();
	}

	function save() {
		$argv = func_get_args();
		$argc = func_num_args();

		if ($argc > 0) {
			foreach($argv as $item) {
				$UPLOAD_FILES[$i] = &$_FILES[$item];
			}
		} else {
			$UPLOADED_FILES = &$_FILES;
		}

		if (count($UPLOADED_FILES) <= 0) return;

		$ret = array();
		foreach ($UPLOADED_FILES as $file) {
			if (is_array($file['name'])) {
				// todo: 같은 필드명으로 파일 여러개 올리때에 대한 처리
			} else {
				if ($file['size'] == 0) continue;

				$ext = AttachFile::extSplit($file['name'],$noext);
				if ($this->ext) $ext = $this->ext;
				if ($this->naming == UPLOAD_TIMESTAMP) {
					$noext = date("U");
				} elseif ($this->naming == UPLOAD_UNIQID) {
					srand((double)microtime()*1000000);
					$noext = md5(uniqid(rand(),1));
				}

				$seq = 0;
				do {
					$savename = "${noext}_${seq}.${ext}";
					$savepath = $this->path."/${savename}";
					$seq++;
				} while (is_file($savepath));
				$seq = 0;

				if (is_uploaded_file($file['tmp_name'])) {
					move_uploaded_file($file['tmp_name'],$savepath);
					$ret[] = array(
						filename => $file['name'],
						filetype => $ext,
						filesize => filesize($savepath),
						filepath => $savepath
					);
				}
			}
		}
		return $ret;
	}

	function extSplit($fileName,&$noext) {
		$dot = strrpos($fileName,".");
		$noext = substr($fileName,0, $dot);
		return ($ext = substr($fileName,$dot+1)) ? $ext : "noext";
	}

	function mkdir($path) {
		return !exec(escapeshellcmd("mkdir -p $path"));
	}
}
?>
