<?
include 'file_lib.inc';

	
$FH = &WebApp::singleton('FileHost');
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->chmod(_DOC_ROOT.'/background/',777);
$FTP->mkdir(_DOC_ROOT.'/background/'._OID.'/');
$FTP->chmod(_DOC_ROOT.'/background/'._OID.'/',777);

$FTP->mkdir(_DOC_ROOT.'/background/'._OID.'/p'.$pcode);
$FTP->chmod(_DOC_ROOT.'/background/'._OID.'/p'.$pcode,777);





if($upfile1) {
$file = new FileUpload("upfile1"); // datafile은 form에서의 이름 
$file->Path = _DOC_ROOT."/background/"._OID.'/p'.$pcode."/";  // 마지막에 /꼭 붙여야함
//$file->file_mkdir(); 
if(!$file->Ext("jpg,gif,png,jpeg"))  {
echo '<script>alert("이미지 파일만 가능합니다.");   </script>';
exit;
 }
$file->file_rename(mktime()); 
if(!$file->upload()){
echo '<script>alert("업로드에 실패 했습니다.");   </script>';
exit;
}

//$file->Resize_Image("138","44","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // 일때 가로 세로 사이즈로 컨버팅

?>

<script>
alert('업로드완료');
parent.CreDivBackground("/background/<?=_OID?>/p<?=$pcode?>/<?=$file->SaveName?>");
</script>
<?

}



if($upfile2) {
$file = new FileUpload("upfile2"); // datafile은 form에서의 이름 
$file->Path = _DOC_ROOT."/background/"._OID.'/p'.$pcode."/";  // 마지막에 /꼭 붙여야함
//$file->file_mkdir(); 
if(!$file->Ext("jpg,gif,png,jpeg"))  {
echo '<script>alert("이미지 파일만 가능합니다.");   </script>';
exit;
 }
$file->file_rename(mktime()); 
if(!$file->upload()){
echo '<script>alert("업로드에 실패 했습니다.");   </script>';
exit;
}

//$file->Resize_Image("138","44","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // 일때 가로 세로 사이즈로 컨버팅

?>

<script>
alert('업로드완료');
parent.CreDivBackgroundTop("/background/<?=_OID?>/p<?=$pcode?>/<?=$file->SaveName?>");
</script>
<?

}
	
?>