<?

$tmp_file = "../../tmp/".md5($text."|".$w."|".$h).".gif";

if(!is_file($tmp_file)) {
include './class.php';
$_CEZBtn = new EZBtn();
$_CEZBtn->TmpImage = $tmp_file;


$_CEZBtn->UseUTF8 = true;
$_CEZBtn->Mode = "4C";
$_CEZBtn->UseFont = "../../fonts/yg330.ttf";

//자를 이미지 크기를 지정한다.(4모서리 또는 양쪽, 상하를 자를 픽셀크기)
$_CEZBtn->CutSize = 8;
if(!$color) $color = "ffffff";
if(!$top) $top = 10;
if(!$fontsize) $fontsize = 8;
//글자를 입력할때 크기및 버턴 이미지 위에 입혀질 위치 지정 (angle 은 기울기 각도)

//$text = $text." 영역";

$w = strlen($text) * ($fontsize - 3.26);

$_CEZBtn->Config = array(
	'BtnWidth'=>$w,		//버턴 가로픽셀
	'BtnHeight'=>$h,		//버턴 세로픽셀
	'FontSize'=>8,		//폰트 사이즈
	'FontTop'=>10,			//폰트 상단여백
	'FontLeft'=>1,		//폰트 왼쪽여백
	'FontAngle'=>0,		//폰트 기울기
	'FontColor'=>$color,		//폰트 색
);



$_CEZBtn->IsSave = true;
$_CEZBtn->MakeBtnImg('../../bg2.gif',$text);	
echo file_get_contents($tmp_file);
exit;
}else{
header('Content-type: image/gif');
echo file_get_contents($tmp_file);
exit;
}








?>
