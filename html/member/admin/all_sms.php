







<script type="text/javascript" src="js/lib.validate.js"></script>
<script type="text/javascript" id="dynScript" onload="alert('ok');"></script>
<script type="text/javascript">
var searchResult = false;
var searchData = new Array();


function checkMsg(el) {
	str = el.value;
	len = calByte(str);
	if(len > 80) {
		tlen = 0;
		for (i=0; i<80; i++) {
			if(str.charAt(i).charCodeAt() > 128) {
				tlen += 2;
			} else {
				tlen++;
			}
			if(tlen>=80) break;
		}
		if(tlen > 80) i--;
		alert('80바이트 까지 입력가능합니다.(한글 40자)');
		str = str.substring(0,i+1);
		len = calByte(str);
		document.getElementById('sms_byte').innerHTML = len;
		el.value = str;
	} else {
		document.getElementById('sms_byte').innerHTML = len;
	}
}

function calByte(str) {
	var len = 0;
    str = this != window ? this : str;
    for (j=0; j<str.length; j++) {
        var chr = str.charAt(j);
        len += (chr.charCodeAt() > 128) ? 2 : 1;
    }
    return len;
}




function checkMobile(el, value) {
    var pattern = /^(010|011|016|017|018|019)-?([1-9]{1}[0-9]{2,3})-?([0-9]{4})$/;
    var num = value ? value : el.value;
    if (pattern.exec(num)) {
        if(RegExp.$1 == "011" || RegExp.$1 == "016" || RegExp.$1 == "017" || RegExp.$1 == "018" || RegExp.$1 == "019") {
            if(!el.getAttribute("span"))
                el.value = RegExp.$1 + "-" + RegExp.$2 + "-" + RegExp.$3;
        }
        return true;
    } else {
        return "invalid";
    }
}




</script>

<body onload="resizeTo(150,350)">
<table align="center"  border=0 cellspacing=0 cellpadding=0>
 <tr>
  <td>



<form name="smsForm" method="post" onsubmit="return prepare(this);" >

<input type="hidden" name="mode" value="send">

<input type="hidden" name="hp" value="{hp}">


<table width="150" class="table01" style="margin:0px;">
		<tr>
			<td align="center">
				<textarea name="str_msg" hname="SMS 메시지" errmsg="SMS 메시지를 작성하여 주십시오." style="width:120px;height:100px;" onkeyup="return checkMsg(this);" maxbyte="80" required></textarea>
			</td>
		</tr>
		<tr>
			<td align="center">
				<span id="sms_byte">0</span>byte / 80byte
			</td>
		</tr>
		</table>



		<table width="150">
		<tr height="50">
			<td>
				보내는 사람 전화번호<br>
				<input type="text" name="str_se_phone" hname="보내는 사람 전화번호" errmsg="보내는 사람 전화번호를 입력하여 주십시오." value="{__OPHONE}" style="width:100%;" option="phone" required>
			</td>
		</tr>
		<tr height="30">
			<td>
				<input type="submit" class="button" value="보내기" style="width:40%;height:30px;">
				<input type="button" class="button" value="다시작성" onclick="this.form.elements['str_msg'].value='';" style="width:57%;height:30px;"></td>
		</tr>
		
		<tr height="10"><td></td></tr>
		</table>

		<table width="150" class="table01" style="margin:0px;">
		<tr>
			<td align="center">
				현재 사용가능한<br>
				SMS 포인트는<br>
				<font color="red">{num_point} Point</font> 입니다.
			</td>
		</tr>
		<tr>
			<td align="center">
				<input type="button" class="button" value="포인트 충전" onclick="location.href='sms.req_point';">
			</td>
		</tr>
		</table>



</form>


  </td>


 </tr>
</table>
</body>