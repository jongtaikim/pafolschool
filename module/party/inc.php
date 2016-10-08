<?

$DB = &WebApp::singleton("DB");

$data_one = $DB -> sqlFetch("select * from TAB_PARTY where num_oid = $_OID and num_pcode = $pcode ");


if($data_one[str_img2]) {
$picture = "http://".$_SERVER[HTTP_HOST]."/".$data_one[str_img2];	
}else{
$picture = "http://".$_SERVER[HTTP_HOST]."/party_img/title/3.jpg";	
$data_one[str_img2] = "/party_img/title/3.jpg";
}
$size=GetImageSize($picture);
$width2 = $size[0] - 15;

$tpl->assign(array(
			'pname'=>$data_one[str_pname],
			'str_img1'=>$data_one[str_img1],
			'str_img2'=>$data_one[str_img2],
			'str_img3'=>$data_one[str_img3],
			'str_memo'=>$data_one[str_memo],
			
			'size1'=>$size[0],
			'size2'=>$size[1],
			'width2'=>$width2,
			'str_color1'=>$data_one[str_color1],
			'str_color2'=>$data_one[str_color2],
			'str_color3'=>$data_one[str_color3],
			'str_color4'=>$data_one[str_color4],

			'off'=>$data_one[str_officer],
			'pcode'=>$pcode,
			));

$sql = "select num_pcode,str_pname from TAB_PARTY where num_oid = $_OID ";
$row = $DB -> sqlFetchAll($sql);
$tpl->assign(array('URL_LIST'=>$row));



//동아리 메뉴
if ($pcode) {
    //==-- 동아리 홈페이지 메뉴 --==//
     global $PARTY_CONF;
    $DB = &WebApp::singleton('DB');
    $sql = "SELECT /*+ INDEX_DESC (".TAB_PARTY_MENU." ".PK_TAB_PARTY_MENU.") */ * FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_view=1 ";
    $DB->query($sql);
    $data = array();


    while($row = $DB->fetch()) {
        $row['class'] = $class.($mcode == $row['num_mcode'] ? ' '.$class_current : '');
       	$row['str_title'] = Display::text_cut($row['str_title'],22,".."); 
		$data[] = $row;
			
			
    }
 

} 





$tpl->assign(array(
  'SUBMENU2'=>$data,
 
));



if ($_SESSION['ADMIN'] && !$_SESSION['ADMIN_PARTY_'.$pcode]) {
    $admin = "Y";
$tpl->assign(array(
  'admin'=>$admin,
 
));
}
?>