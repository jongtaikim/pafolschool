<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: namespace/wa/zipsearch.php
* �ۼ���: 2005-07-08
* �ۼ���: ��ģ����
* ��  ��: �����ȣ �˻���ư ����
*****************************************************************
* 
*/
if (!$innerHTML) $innerHTML = _('Search zipcode');
return <<<__EOS__
<script type="text/javascript">
function popup_zip(form) {
	wZip = window.open('core.zipcode?el_addr={$attr['addr']}&el_zip={$attr['name']}&el_focus={$attr['focus']}&form='+form,'zipsearch','width=400, height=200');
}
</script>
<input type="text" size="7" {$_attr} />
<input type="button" onClick="popup_zip(this.form.getAttribute('NAME'));" value="{$innerHTML}" class="button" />
__EOS__;
?>
