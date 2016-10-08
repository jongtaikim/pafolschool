<?

include "fileupload2.inc";
switch ($REQUEST_METHOD) {
	case "GET":

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title> 관리자 </title>
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
						<td height="26" >&nbsp;&nbsp;<IMG height=7 src="/theme/LMS1/images/head.gif" width=7 border=0>&nbsp;사이트관리 &gt; <B> 로고관리</B></td>
						<td background="images/mall4.gif" width="102"></td>
				</tr>
				<tr><td  height="1" bgcolor="#CCCCCC" colspan="2"></td></tr>
				<tr><td  height="1" bgcolor="#eeeeee" colspan="2"></td></tr>
				<tr>
						<td height="40" bgcolor=fcfcfc>
							<font color=666666>&nbsp;&nbsp;사이트에 표출한 로고를 설정합니다..
						</td>
				</tr>
				<tr>
						<td  height="1" bgcolor="#eeeeee" colspan="2"></td>
				</tr>
		</table><br>

<table width="725" class="table01"> 
<tbody>
<tr  align="center">
	
	<th width = 200>상단로고</th>
	<td    align="left">
	

이미지 <input type="file" name="upfile1" style="width:300;" >
	</td>
	
	
	
	</tr>
<tr  align="center">
	
	<th width = 200>하단로고 </th>
	<td    align="left">
	

이미지 <input type="file" name="upfile2" style="width:300;" >
	</td>
	
	
	
<tr  align="center">
	
	
	<td  colspan =2>
	

<input type="submit" value = "정보저장"  > 


	</td>
	
	
	
	</tr>

</tbody>




</table>

<br>
<table width="725" class="table01"> 
<tbody>
<tr  align="center">
	
	<th width = 200>상단로고</th>	<th width = 200>하단로고</th>	
</tr><tr>
	<td   align="center">
	
<img src = "/hosts/<?=$_SERVER['HTTP_HOST']?>/logo.gif" >


	</td>

		<td   align="center">
	

<img src = "/hosts/<?=$_SERVER['HTTP_HOST']?>/logo2.gif" >

	</td>


	
	
	
	</tr>
</table>

</form>
</html>

<?

	break;
	case "POST":

	
if($upfile1) {
$file = new FileUpload("upfile1"); // datafile은 form에서의 이름 
$file->Path = "./hosts/".$_SERVER['HTTP_HOST']."/";  // 마지막에 /꼭 붙여야함
//$file->file_mkdir(); 
if(!$file->Ext("gif"))  {
echo '<script>alert("gif 파일만 가능합니다.");   history.go(-1); </script>';
exit;
 }
$file->file_rename(); 
if(!$file->upload()){
echo '<script>alert("업로드에 실패 했습니다.");   history.go(-1); </script>';
exit;
}
$file->upload();
//$file->Resize_Image("162","58","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // 이미지일때 가로 세로 사이즈로 컨버팅


}




if($upfile2) {
$file = new FileUpload("upfile2"); // datafile은 form에서의 이름 
$file->Path = "./hosts/".$_SERVER['HTTP_HOST']."/";  // 마지막에 /꼭 붙여야함
//$file->file_mkdir(); 
if(!$file->Ext("gif"))  {
echo '<script>alert("gif 파일만 가능합니다.");   history.go(-1); </script>';
exit;
 }
$file->file_rename(2); 
if(!$file->upload()){
echo '<script>alert("업로드에 실패 했습니다.");   history.go(-1); </script>';
exit;
}
$file->upload();
//$file->Resize_Image("151","49","./hosts/".$_SERVER['HTTP_HOST']."/files/"); // 이미지일때 가로 세로 사이즈로 컨버팅


}







echo '<script>alert("저장했습니다.");
		
</script>';


echo "<meta http-equiv='Refresh' Content=\"0; URL='/lms_logo.setup2'\">";



	break;

}