<?

include "fileupload.inc";
switch ($REQUEST_METHOD) {
	case "GET":

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title> ������ </title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<meta name="robots" content="noindex, nofollow">
<link rel="stylesheet" type="text/css" href="/css/admin.css">
</head>




<form name="f"  method="post" method="post" enctype='multipart/form-data'>

<table width="100%"  border="0" cellpadding="0" cellspacing="0" >

<tr><td>



<table  border="0" cellpadding="0" cellspacing="0" width=725>
				<tr><td height="7" colspan="2"></td></tr>
				<tr><td height="1" bgcolor="#CCCCCC" colspan="2"></td></tr>          
				<tr>
						<td height="26" >&nbsp;&nbsp;<IMG height=7 src="/theme/LMS1/images/head.gif" width=7 border=0>&nbsp;����Ʈ���� &gt; <B> �����÷��ð���</B></td>
						<td background="images/mall4.gif" width="102"></td>
				</tr>
				<tr><td  height="1" bgcolor="#CCCCCC" colspan="2"></td></tr>
				<tr><td  height="1" bgcolor="#eeeeee" colspan="2"></td></tr>
				<tr>
						<td height="40" bgcolor=fcfcfc>
							<font color=666666>&nbsp;&nbsp;����Ʈ�� ǥ���� �����÷��ø� �����մϴ�..
						</td>
				</tr>
				<tr>
						<td  height="1" bgcolor="#eeeeee" colspan="2"></td>
				</tr>
		</table><br>

<table width="725" class="table01"> 
<tbody>
<tr  align="center">
	
	<th width = 200>1��</th>
	<td    align="left">
	

    ��&nbsp;&nbsp;&nbsp;ũ <INPUT TYPE="text" NAME="link1"  style = "width:250px" value = <?=$_LINK1?>>
<br>�̹��� <input type="file" name="upfile1" style="width:300;" >
	</td>
	
	
	
	</tr>
<tr  align="center">
	
	<th width = 200>2�� </th>
	<td    align="left">
	

��&nbsp;&nbsp;&nbsp;ũ  <INPUT TYPE="text" NAME="link2"  style = "width:250px" value = <?=$_LINK2?>>
<br>�̹��� <input type="file" name="upfile2" style="width:300;" >
	</td>
	
	
	
	</tr>
	<tr  align="center">
	
	<th width = 200>3��</th>
	<td    align="left">
	

��&nbsp;&nbsp;&nbsp;ũ <INPUT TYPE="text" NAME="link3"  style = "width:250px" value = <?=$_LINK3?>>
<br>�̹��� <input type="file" name="upfile3" style="width:300;" >
	</td>
	
	
	
	</tr>
<tr  align="center">
	
	
	<td  colspan =2>
	

<input type="submit" value = "��������"  > 


	</td>
	
	
	
	</tr>

</tbody>




</table>

<br>
<table width="725" class="table01"> 
<tbody>
<tr  align="center">
	
	<th width = 200>1�� �̹���</th>	<th width = 200>3�� �̹���</th>	<th width = 200>3�� �̹���</th>
</tr><tr>
	<td   align="center">
	
<img src = "/hosts/<?=$_SERVER['HTTP_HOST']?>/files/img0.jpg" width = 200 height = 65>


	</td>

		<td   align="center">
	

<img src = "/hosts/<?=$_SERVER['HTTP_HOST']?>/files/img1.jpg" width = 200 height = 65>

	</td>

		<td   align="center">
	

<img src = "/hosts/<?=$_SERVER['HTTP_HOST']?>/files/img2.jpg" width = 200 height = 65>

	</td>
	
	
	
	</tr>
</table>

</form>
</html>

<?

	break;
	case "POST":

	
if($upfile1) {
$file = new FileUpload("upfile1"); // datafile�� form������ �̸� 
$file->Path = "./hosts/".$_SERVER['HTTP_HOST']."/files/";  // �������� /�� �ٿ�����
//$file->file_mkdir(); 
if(!$file->Ext("jpg"))  {
echo '<script>alert("jpg ���ϸ� �����մϴ�.");   history.go(-1); </script>';
exit;
 }
$file->file_rename(0); 
if(!$file->upload()){
echo '<script>alert("���ε忡 ���� �߽��ϴ�.");   history.go(-1); </script>';
exit;
}
$file->upload();
$file->Resize_Image("518","165","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // �̹����϶� ���� ���� ������� ������


}




if($upfile2) {
$file = new FileUpload("upfile2"); // datafile�� form������ �̸� 
$file->Path = "./hosts/".$_SERVER['HTTP_HOST']."/files/";  // �������� /�� �ٿ�����
//$file->file_mkdir(); 
if(!$file->Ext("jpg"))  {
echo '<script>alert("jpg ���ϸ� �����մϴ�.");   history.go(-1); </script>';
exit;
 }
$file->file_rename(1); 
if(!$file->upload()){
echo '<script>alert("���ε忡 ���� �߽��ϴ�.");   history.go(-1); </script>';
exit;
}
$file->upload();
$file->Resize_Image("518","165","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // �̹����϶� ���� ���� ������� ������


}


if($upfile3) {
$file = new FileUpload("upfile3"); // datafile�� form������ �̸� 
$file->Path = "./hosts/".$_SERVER['HTTP_HOST']."/files/";  // �������� /�� �ٿ�����
//$file->file_mkdir(); 
if(!$file->Ext("jpg"))  {
echo '<script>alert("jpg ���ϸ� �����մϴ�.");   history.go(-1); </script>';
exit;
 }
$file->file_rename(2); 
if(!$file->upload()){
echo '<script>alert("���ε忡 ���� �߽��ϴ�.");   history.go(-1); </script>';
exit;
}
$file->upload();
$file->Resize_Image("518","165","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // �̹����϶� ���� ���� ������� ������


}







$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

$INI = &WebApp::singleton("IniFile");
$INI->load('hosts/'.HOST.'/conf/global.conf.php');
$INI->setVar("link1",$link1);
$INI->setVar("link2",$link2);
$INI->setVar("link3",$link3);

$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');


echo '<script>alert("�����߽��ϴ�.");
		
</script>';


echo "<meta http-equiv='Refresh' Content=\"0; URL='/setUp.setup'\">";



	break;

}