<?
/**********************************************
* 파일명: class.Thumbnail.php
* 설  명: 썸네일 생성
* 날  짜: 2003-05-29
* 작성자: 거친마루
* 
***********************************************/

// XXX: 좌우 비율이 상이하게 다르면 검정색 썸네일로 변하거나 심하게 왜곡되는 버그

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

//		$this->dstIm = ImageCreateTruecolor($width,$height);     //결과물 이미지 생성
		$this->dstIm = ImageCreate($width,$height);     //결과물 이미지 생성
		ImageColorAllocate($this->dstIm, 255, 255, 255);
//		ImageCopyResampled($this->dstIm, $this->srcIm, 0, 0, 0, 0, $width, $height, ImageSX($this->srcIm),ImageSY($this->srcIm));
		ImageCopyResized($this->dstIm, $this->srcIm, 0, 0, 0, 0, $width, $height, ImageSX($this->srcIm),ImageSY($this->srcIm));
		return $this->dstIm; 
	}
*/


	/**
	* <pre>
	* 가로세로 비율 유지하고 긴 축을 넘겨받은 파라미터 길이로 줄여주는 루틴
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
//		$this->dstIm = ImageCreate($width,$height);     //결과물 이미지 생성
		$this->dstIm = ImageCreateTrueColor($width,$height);     //결과물 이미지 생성
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