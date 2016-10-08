<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 아작스 세션툴..ㅋㅋ
*****************************************************************
* 
*/


switch ($mode) {
	case "y":
	

	foreach( $_POST as $val => $value )
	{
	if($val !="mode") $_SESSION['mk_ses'][$val]= iconv("utf-8","euc-kr",$value);
	} 
	
	 break;
	case "n":
	unset($_SESSION['mk_ses']);
	break;
	}



/*사용방법
<script type="text/javascript" src="/js/ajax.js"></script>

<script type="text/javascript">
	function AjaxSession (set,name,val) {

	var params = name + '=' + encodeURIComponent(val) + '&mode='+set;  
	sendRequest("/core.mk_session", params, FromServer, "POST");
	}
	function FromServer() {
		if (httpRequest.readyState == 4) {
			if (httpRequest.status == 200) {
				var str_text = httpRequest.responseText;
				//alert(str_text)

			}
		}
	}
</script>

*/
?>