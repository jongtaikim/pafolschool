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
$file = new FileUpload("upfile1"); // datafile�� form������ �̸� 
$file->Path = _DOC_ROOT."/background/"._OID.'/p'.$pcode."/";  // �������� /�� �ٿ�����
//$file->file_mkdir(); 
if(!$file->Ext("jpg,gif,png,jpeg"))  {
echo '<script>alert("�̹��� ���ϸ� �����մϴ�.");   </script>';
exit;
 }
$file->file_rename(mktime()); 
if(!$file->upload()){
echo '<script>alert("���ε忡 ���� �߽��ϴ�.");   </script>';
exit;
}

//$file->Resize_Image("138","44","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // �϶� ���� ���� ������� ������

?>

<script>
alert('���ε�Ϸ�');
parent.CreDivBackground("/background/<?=_OID?>/p<?=$pcode?>/<?=$file->SaveName?>");
</script>
<?

}



if($upfile2) {
$file = new FileUpload("upfile2"); // datafile�� form������ �̸� 
$file->Path = _DOC_ROOT."/background/"._OID.'/p'.$pcode."/";  // �������� /�� �ٿ�����
//$file->file_mkdir(); 
if(!$file->Ext("jpg,gif,png,jpeg"))  {
echo '<script>alert("�̹��� ���ϸ� �����մϴ�.");   </script>';
exit;
 }
$file->file_rename(mktime()); 
if(!$file->upload()){
echo '<script>alert("���ε忡 ���� �߽��ϴ�.");   </script>';
exit;
}

//$file->Resize_Image("138","44","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // �϶� ���� ���� ������� ������

?>

<script>
alert('���ε�Ϸ�');
parent.CreDivBackgroundTop("/background/<?=_OID?>/p<?=$pcode?>/<?=$file->SaveName?>");
</script>
<?

}
	
?>