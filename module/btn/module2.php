<?

$tmp_file = "../../tmp/".md5($text."|".$w."|".$h).".gif";

if(!is_file($tmp_file)) {
include './class.php';
$_CEZBtn = new EZBtn();
$_CEZBtn->TmpImage = $tmp_file;


$_CEZBtn->UseUTF8 = true;
$_CEZBtn->Mode = "4C";
$_CEZBtn->UseFont = "../../fonts/yg330.ttf";

//�ڸ� �̹��� ũ�⸦ �����Ѵ�.(4�𼭸� �Ǵ� ����, ���ϸ� �ڸ� �ȼ�ũ��)
$_CEZBtn->CutSize = 8;
if(!$color) $color = "ffffff";
if(!$top) $top = 10;
if(!$fontsize) $fontsize = 8;
//���ڸ� �Է��Ҷ� ũ��� ���� �̹��� ���� ������ ��ġ ���� (angle �� ���� ����)

//$text = $text." ����";

$w = strlen($text) * ($fontsize - 3.26);

$_CEZBtn->Config = array(
	'BtnWidth'=>$w,		//���� �����ȼ�
	'BtnHeight'=>$h,		//���� �����ȼ�
	'FontSize'=>8,		//��Ʈ ������
	'FontTop'=>10,			//��Ʈ ��ܿ���
	'FontLeft'=>1,		//��Ʈ ���ʿ���
	'FontAngle'=>0,		//��Ʈ ����
	'FontColor'=>$color,		//��Ʈ ��
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
