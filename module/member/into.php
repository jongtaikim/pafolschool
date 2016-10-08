<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/



$sql = "select * from TAB_GPIN_AUTH where str_no = '".$_GET[no]."' ";
$gpcount = $DB -> sqlFetchOne($sql);



if($gpcount){
	$sql = "select * from TAB_GPIN_AUTH where str_no = '".$_GET[no]."' ";
	$gpin = $DB -> sqlFetch($sql);
	$_SESSION[vr_no] = $gpin[str_virtualno];

		$sql = "select * from TAB_MEMBER where num_oid = "._OID." and str_vr_no = '".$gpin[str_virtualno]."' ";
		$mcount = $DB -> sqlFetchOne($sql);

			if($mcount){
			$sql = "select * from TAB_MEMBER where num_oid = '"._OID."' and str_vr_no = '".$gpin[str_virtualno]."' ";
			$row = $DB -> sqlFetch($sql);
			}


}


if($mcount){


		 ?>
			<script type="text/javascript">
			// <![CDATA[
			window.opener.location.href = '/member.join_step22?str_id=<?=$row[str_id]?>'	;
			window.close();
			// ]]>
			</script>

			<?

/*T.STR_NO, T.STR_VIRTUALNO, T.STR_NAME, 
   T.NUM_SEX, T.NUM_AUTHINFO, T.NUM_NATIONALINFO, 
   T.STR_IP, T.NUM_BIRTHDATE, T.NUM_OID*/
}else{

		if($gpin)	{
		 if(!$_SESSION[themeset_]){
		 ?>
			<script type="text/javascript">
			// <![CDATA[
			window.opener.location.href = '/member.join_step2?num_birthday=<?=$gpin["num_birthdate"]?>&chr_mtype=<?=$chr_mtype?>&str_name=<?=urlencode($gpin["str_name"])?>&chr_birthday=s&str_sex=<?=$gpin["num_sex"]?>'	;
			window.close();
			// ]]>
			
			</script>
		<?
		 }else{
			
					 ?>
			<script type="text/javascript">
			// <![CDATA[
			window.opener.location.href = '/member.join?num_birthday=<?=$gpin["num_birthdate"]?>&chr_mtype=<?=$chr_mtype?>&str_name=<?=urlencode($gpin["str_name"])?>&chr_birthday=s&str_sex=<?=$gpin["num_sex"]?>'	;
			window.close();
			// ]]>
			
			</script>
		<?
			
		}
		}
}			
?>