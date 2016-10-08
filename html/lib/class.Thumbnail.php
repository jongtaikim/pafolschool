<?
/**********************************************
* ���ϸ�: class.Thumbnail.php
* ��  ��: ����� ����
* ��  ¥: 2003-05-29
* �ۼ���: ��ģ����
* 
***********************************************/

// XXX: �¿� ������ �����ϰ� �ٸ��� ������ ����Ϸ� ���ϰų� ���ϰ� �ְ�Ǵ� ����

class Thumbnail {

	var $file;
	var $srcIm;
	var $dstIm;
	var $orgX;
	var $orgY;
	var $path;

	function Thumbnail($file='') {
		$this->file = $file;
		if ($file) $this->load($file);
	}

	function setSavePath($path) {
		$this->path = $path;
	}

	function load($fName) { 
		$_info = getImageSize($fName);

		switch ($_info[2]) {
			case 1:
				$im = @ImageCreateFromGIF($fName);
			break;
			case 2:
				$im = @ImageCreateFromJPEG($fName);
			break;
			case 3:
				$im = @ImageCreateFromPNG($fName);
			break;
			default:
				list(,$file_ext) = explode(' ',`file $fname`);
				$im = @${"ImageCreateFrom".$file_ext}($fName);
			break;
		} 

		if (!$im) {
			$im = ImageCreate(150, 30); 
			$bgc = ImageColorAllocate($im, 255, 255, 255); 
			$tc  = ImageColorAllocate($im, 0, 0, 0); 
			ImageFilledRectangle($im, 0, 0, 150, 30, $bgc); 
			ImageString($im, 1, 5, 5, "Error loading $fName", $tc); 
		} 
		$this->srcIm = $im;
		$this->orgX = $_info[0];
		$this->orgY = $_info[1];
		return $im; 
	}

/*
	function _process($width="",$height="") {
		if($this->orgX <= $width) {
			$width = $this->orgX;
			$height = $this->orgY;
		}

		if($this->orgX > $width){
			$height = ceil(($width / $this->orgX) * $this->orgY);
		}

//		$this->dstIm = ImageCreateTruecolor($width,$height);     //����� �̹��� ����
		$this->dstIm = ImageCreate($width,$height);     //����� �̹��� ����
		ImageColorAllocate($this->dstIm, 255, 255, 255);
//		ImageCopyResampled($this->dstIm, $this->srcIm, 0, 0, 0, 0, $width, $height, ImageSX($this->srcIm),ImageSY($this->srcIm));
		ImageCopyResized($this->dstIm, $this->srcIm, 0, 0, 0, 0, $width, $height, ImageSX($this->srcIm),ImageSY($this->srcIm));
		return $this->dstIm; 
	}
*/


	/**
	* <pre>
	* ���μ��� ���� �����ϰ� �� ���� �Ѱܹ��� �Ķ���� ���̷� �ٿ��ִ� ��ƾ
	* </pre>
	* 
	*/
	function _process($length=100) {
		if($this->orgX <= $this->orgY) {
			$width = ceil($length * ($this->orgX / $this->orgY));
			$height = $length;
		} else {
			$width = $length;
			$height = ceil($length * ($this->orgY / $this->orgX));
		}
//		$this->dstIm = ImageCreate($width,$height);     //����� �̹��� ����
		$this->dstIm = ImageCreateTrueColor($width,$height);     //����� �̹��� ����
		ImageColorAllocate($this->dstIm, 255, 255, 255);
//		ImageCopyResampled($this->dstIm, $this->srcIm, 0, 0, 0, 0, $width, $height, ImageSX($this->srcIm),ImageSY($this->srcIm));
		ImageCopyResized($this->dstIm, $this->srcIm, 0, 0, 0, 0, $width, $height, ImageSX($this->srcIm),ImageSY($this->srcIm));
		return $this->dstIm; 
	}

	function thumbJPEG($length=100,$newfile="#undefined") {
		if ($newfile == "#undefined") {
			imageJPEG($this->_process($length));
		} else {
			header('Content-type: image/jpeg');
			imageJPEG($this->_process($length),$newfile);
			return $newfile;
		}
	}

	function thumbGIF($length=100,$newfile="#undefined") {
		if ($newfile == "#undefined") {
			imageGIF($this->_process($length));
		} else {
			header('Content-type: image/gif');
			imageGIF($this->_process($length),$newfile);
			return $newfile;
		}
	}

	function thumbPNG($length=100,$newfile="#undefined") {
		if ($newfile == "#undefined") {
			imagePNG($this->_process($length));
		} else {
			header('Content-type: image/png');
			imagePNG($this->_process($length),$newfile);
			return $newfile;
		}
	}
}


?>