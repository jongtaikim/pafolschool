<table cellpadding="0" cellspacing="0" border="0" width="690" height="45" background="/html/admin2/images/sub_title_bg.gif" >
				<tr>
					<td style="padding:0 6 0 2" width="20" align = right><img src="/html/admin2/images/icon4.gif"></td>
					<td style="padding:3 0 0 0; color:454545" width = 120><b> 데이터 이관
					</b></td>
				<td  style="padding:3 0 0 0; color:454545">&nbsp; 마지막으로 사포 했었음..</td>
				</tr>
			</table>

<br>
<FORM METHOD=POST ACTION="/board.curl.sapo" target="d_main">

<table cellpadding="0" cellspacing="0" border="0" width="690"  class= "table01">
<tr>
<th>게시판 고유 아이디</th>  <td><INPUT TYPE="text" NAME="bbs_id" value = "<?=$bbs_id?>"></td>
</tr>

<tr>
<th>우리쪽 mcode</th>  <td><INPUT TYPE="text" NAME="mcode" value = "<?=$mcode?>"></td>
</tr>

<tr>
<th>게시물 시작번호</th>  <td><INPUT TYPE="text" NAME="iis" value = "<?=$iis?>"></td>
</tr>

<tr>
<th>게시물 끝번호</th>  <td><INPUT TYPE="text" NAME="iie" value = "<?=$iie?>"></td>
</tr>


<tr>
<th>실행</th>  <td><INPUT TYPE="radio" NAME="run" value = ""> 보기 <INPUT TYPE="radio" NAME="run" value = "Y"> 저장</td>
</tr>


<tr>
 <td colspan = 2><INPUT TYPE="submit" value = "우즈 플리즈 실행할까?"></td>
</tr>

</table>

</FORM>

<iframe src ="" width = 100% height =500  frameborder =  0  style = ""  scrolling="auto"  noresize = "no" id = "d_main" name = "d_main"></iframe>