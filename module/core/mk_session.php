<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: ���۽� ������..����
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



/*�����
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