<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: read.php
* ��  ��: �Խ��� �� �б�
* ��  ¥: 2008-06-24
* �ۼ���: ������
*****************************************************************
*
*/
$r_url = "http://".$_SERVER[HTTP_HOST]."/board/".$mcode."/".$id;
$tpl->assign(array('URL'=>$r_url));





if($_SESSION[nonBoard]){
	$PERM->apply('menu',$_SESSION[nonBoard],'r');
}else{
	$PERM->apply('menu',$mcode,'r');
}

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);

//echo "ARTICLE_TABLE:$ARTICLE_TABLE";exit;



$sql = "
SELECT
num_mcode AS mcode, num_serial AS serial, num_notice, num_group, str_user, str_name AS name, str_email AS email, str_title, str_text, 
chr_html AS use_html, dt_date AS reg_date, num_hit AS hit, num_file, str_ip AS remote_addr, num_comment, str_hak, num_input_pass,str_main,str_category,num_rank,str_pass, str_tmp1, str_tmp2, str_tmp3,  str_tmp4, str_tmp5, str_tmp6,  str_tmp7, str_tmp8, str_tmp9, str_tmp10,str_tag,str_coment,str_scrab,str_rss,str_nick
FROM
$ARTICLE_TABLE
WHERE
num_oid={$oid} AND num_mcode={$mcode} AND num_serial={$id}
";




if($data = $DB->sqlFetch($sql)) { }else{ WebApp::moveBack('���� �����ϴ�.');}

$data[reg_date] = date("Y-m-d",$data[reg_date]);


//2008-08-25 ���� ȸ������
/*if($data[str_user]){

	$sql = "select
	STR_NAME,
	STR_ID,
	NUM_LOGIN_POINT,
	NUM_BOARD_POINT,
	NUM_COMMINT_POINT,
	NUM_REPALY_POINT,CHR_MTYPE from TAB_MEMBER where num_oid = $_OID and str_id = '".$data[str_user]."' ";

	$member_data = $DB -> sqlFetch($sql);

	if(is_file(_DOC_ROOT."/hosts/".HOST."/files/member/".$data[str_user].".gif")) {
		$member_data[mem_img] = "/hosts/".HOST."/files/member/".$data[str_user].".gif_100";
	}


	$tpl->assign($member_data);


}*/
if($_SESSION['ADMIN'] || $_SESSION['ADMIN_sub']){
	$board_admin = "y";
}

//2008-06-25 ��б� ���� üũ�κ�
if(!$board_admin  &&  ($_SESSION['USERID'] != $board_admin_id)) {

	if($_SESSION['USERID'] != $data['str_user']) {

		if($data['num_input_pass'] || $_conf[chr_listtype] =="D") {

			if($data['str_pass'] != $_SESSION['bbs_pass']) {

				echo "<meta http-equiv='Refresh' Content=\"0; URL='/board.pass?mcode=$mcode&id=$id'\">";
				exit;
			}
		}
	}
}
unset($_SESSION['bbs_pass']);
@_format_data(&$data);

$data['content'] = $FH->set_content($data['content']);

//2008-11-20 ���� �ֹι�ȣ ���͸� �߰�
//$pattern = "([0-9]{6})([\s-*_=]*)([1-6])([0-9]{6})";
//$data['content'] = preg_replace("/$pattern/m", "$1$2$3*******", $data['content']);
//$data['content'] = preg_replace("/$pattern/m", "******-*******", $data['content']);

$DB->query("
UPDATE
$ARTICLE_TABLE
SET
num_hit=num_hit+1
WHERE
num_oid=$oid AND num_mcode=$mcode AND num_serial=$id
");


$DB->commit();

if ($data['use_html'] == 'N') html2txt($data['content']);
if ($data['str_email']) $data['name'] = "<a href='mailto:$data[str_email]'>".$data['name']."</a>";


$listalllink = $URL->alterVar(array(key=>'',search=>''));
$env['listall'] = ($_GET['search'] != '');

// {{{ ������,������ (2004-08-25)
if ($key && $search) $whereadd = "AND $key LIKE '%$search%'";
$sql = "
SELECT

num_serial,str_title,num_notice,str_category,num_input_pass,str_name ,dt_date,str_text
FROM
$ARTICLE_TABLE
WHERE
num_oid={$oid} AND
num_mcode={$mcode} AND
num_group>".$data['num_group']."  {$whereadd} order by num_group asc  limit 0,1
";



if($next_data = $DB->sqlFetch($sql)) {
			
			if($next_data[str_text]) $nextlink_text =  cut_str( str_replace("&nbsp;","",strip_tags($next_data[str_text])), "300");
			$nextlink = '<dl class="prev">
									<dt class="title">������</dt>
									<dd class="preTitle"><a href="/board.read?mcode='.$mcode.'&id='.$next_data['num_serial'].'" style="color:#0000CC">'.$next_data[str_title].'</a></dd>
									<dd class="admin">/ '.$next_data[str_name].'</dd>
									<dd class="time">'.date("Y.m.d",$next_data[dt_date]).'</dd>
									<dd class="content">'.$nextlink_text.'</dd>
								</dl>';

}


$sql = "
SELECT

num_serial,str_title,num_notice,str_category,num_input_pass,str_name ,dt_date,str_text
FROM
$ARTICLE_TABLE
WHERE
num_oid={$oid} AND
num_mcode={$mcode}  AND
num_group<".$data['num_group']."  {$whereadd} order by num_group desc  limit 0,1
";




if($prev_data = $DB->sqlFetch($sql)) {


			if($prev_data[str_text]) $prev_data_text =  cut_str( str_replace("&nbsp;","",strip_tags($prev_data[str_text])), "300");
			$prevlink = '<dl class="next">
									<dt class="title">������</dt>
									<dd class="preTitle"><a href="/board.read?mcode='.$mcode.'&id='.$prev_data['num_serial'].'" style="color:#0000CC">'.$prev_data[str_title].'</a></dd>
									<dd class="admin">/ '.$prev_data[str_name].'</dd>
									<dd class="time">'.date("Y.m.d",$prev_data[dt_date]).'</dd>
									<dd class="content">'.$prev_data_text.'</dd>
								</dl>';


		

}

// }}}


$FH = &WebApp::singleton('FileHost','menu',$mcode);
$files = $FH->get_files_info($id);
$total_size = array_pop($files);

$tpl->assign("FILE",&$files);
$tpl->assign(array('FILE_COUNT'=>count($files)));



// �ַ��� �̸�����
$content_front = '';
$fnumber = 0;
foreach($files as $file) {


$fnumber ++;
	   if(!ereg('(jpe?g|gif|png|swf|wmv|avi|mpg|mpeg)',$file['str_ftype'])) continue;

	if($file['str_ftype'] =="swf") {
		$content_front = "<embed menu='true' width='100%' loop='true' play='true'  src='".$file['file_url']."'></embed>";
	}else if(eregi($file['real_url'],$data['content'])){
		$content_front2 .= '<a href="'.$file['file_url'].'?nocount=1'.'"  rel="lightbox1">'.
		'<img src="'.$file['file_url'].'?nocount=1'.'" border="0" align="center" '.
		'width=80  vspace="5" hspace="5" style="border-width:3px;border-style:solid;border-color:#b0b0b0;"></a>';
	
	}else if($file['str_ftype'] =="wmv" || $file['str_ftype'] =="avi" || $file['str_ftype'] =="mpg" ||$file['str_ftype'] =="mpeg") {
	

$content_front_wmv .= "
<div style = 'text-align:center'><object classid='clsid:6bf52a52-394a-11d3-b153-00c04f79faa6' width='529' height='408' codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701'>
<param name='src' value='".$file['file_url']."' />
<param name='url' value='".$file['file_url']."' /><embed type='application/x-mplayer2' width='529' height='408' src='".$file['file_url']."'' url=''".$file['file_url']."'></embed>
</object></div><br>

";


}else{
	
		
		//2007-10-27 ���� �ָ��� �����̹��� ���� ���߱�

		$f_img =  $file['file_url'];

		$normal_gallery=GetImageSize(_DOC_ROOT."/hosts/".HOST."/menu/".$file[str_refile]);

		$bbs_width = 250;
		$bbs_height = 250;

		$ratio1 = $bbs_width/$normal_gallery[0]; // �Խ��� ����ũ�⿡ ���� �̹��� ���� ���� ���
		$ratio2 = $bbs_height/$normal_gallery[1]; // �Խ��� ����ũ�⿡ ���� �̹��� ���� ���� ���

		if($ratio1 >= 1 && $ratio2 >= 1 )
		{
			$img_w = $normal_gallery[0]; // ������ ũ�⺸�� ������� ���� ������� ���
			$img_h = $normal_gallery[1];
		}
		elseif($ratio1 > $ratio2)
		{
			$img_w = $normal_gallery[0]*$ratio2; // �������� ���ο� ���ο� ������ ���� ����
			$img_h = $normal_gallery[1]*$ratio2; // ���� ���� ���� ����
		}
		elseif($ratio1 <= $ratio2)
		{
			$img_w = $normal_gallery[0]*$ratio1; // �������� ���ο� ���ο� ������ ���� ����
			$img_h = $normal_gallery[1]*$ratio1; // ���� ���� ���� ����
		}
		else
		{
			$img_w = $normal_gallery[0]; // ������ ũ�⺸�� ������� ���� ������� ���
			$img_h = $normal_gallery[1];
		}

		$content_front1 .= '<center><a href="'.$file['file_url'].'?nocount=1'.'"  rel="lightbox1">'.
		'<img src="'.$file['file_url'].'?nocount=1'.'" border="0" align="center" '.
		'width ='.$img_w.'  vspace="5" alt="'.$data[str_title].'�� ÷���̹��� '.$fnumber.'"></a></center><br>';

		$bbs_width2 = 600;
		$bbs_height2 = 600;

		$ratio1 = $bbs_width2/$normal_gallery[0]; // �Խ��� ����ũ�⿡ ���� �̹��� ���� ���� ���
		$ratio2 = $bbs_height2/$normal_gallery[1]; // �Խ��� ����ũ�⿡ ���� �̹��� ���� ���� ���

		if($ratio1 >= 1 && $ratio2 >= 1 )
		{
			$img_w2 = $normal_gallery[0]; // ������ ũ�⺸�� ������� ���� ������� ���
			$img_h2 = $normal_gallery[1];
		}
		elseif($ratio1 > $ratio2)
		{
			$img_w2 = $normal_gallery[0]*$ratio2; // �������� ���ο� ���ο� ������ ���� ����
			$img_h2 = $normal_gallery[1]*$ratio2; // ���� ���� ���� ����
		}
		elseif($ratio1 <= $ratio2)
		{
			$img_w2 = $normal_gallery[0]*$ratio1; // �������� ���ο� ���ο� ������ ���� ����
			$img_h2 = $normal_gallery[1]*$ratio1; // ���� ���� ���� ����
		}
		else
		{
			$img_w2 = $normal_gallery[0]; // ������ ũ�⺸�� ������� ���� ������� ���
			$img_h2 = $normal_gallery[1];
		}

		$content_front3 .= '<a href="'.$file['file_url'].'?nocount=1'.'"  rel="lightbox1">'.
		'<img src="'.$file['file_url'].'?nocount=1'.'" border="0" align="center" '.
		'width ='.$img_w2.'  vspace="5"  alt="'.$data[str_title].'�� ÷���̹��� '.$fnumber.'"></a><br>';

	}
}

$content_front_res = "<center>".$content_front3."<br>".$content_front_wmv."</center>";

$tpl->assign(array('img_list'=>$content_front1,'img_list2'=>$content_front_res,'img_list3'=>$content_front_wmv,));


	$data[content] = $content_front_res.$data[content];
	



// {{{ �����Ѹ���

if ($_conf['chr_comment']) {
	if ($data['num_comment'] > 0) {

		$sql = "SELECT

		num_main, num_serial, str_user, str_name , str_comment,  dt_date,
		str_icon,str_nick,chr_mtype
		FROM
		$COMMENT_TABLE
		WHERE
		num_oid=$oid AND num_mcode=$mcode AND num_main=$id order by num_serial asc
		";

		$comments = $DB->sqlFetchAll($sql);
		//@array_walk($comments,'_format_data');
		$tpl->assign("COMMENT",&$comments);
	}
	$env['comment_write'] = true;//$PERM->check('w');
}
// }}}
$env['show_ip'] = !$env['admin'];
$tpl->define("CONTENT", WebApp::getTemplate("board/skin/${skin}/read.htm"));

$tpl->assign(array(
'id'=>$id,
'env'=>$env,
'prevlink'=>$prevlink,
'nextlink'=>$nextlink,
'gon' => $gon,
'delcommlink' => "/board.del_comment",
));

$tpl->assign($data);

//include dirname(__FILE__).'/inc_list.php';

// {{{ Functions
function html2txt(&$str) {
	$str = str_replace(array("&","<",">","\n"),array("&amp;","&lt;","&gt;"," <br>\n"),$str);
}


function cut_str($str,$len,$tail="..") {
	if(strlen($str) > $len) {
	for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
		$str=substr($str,0,$i).$tail;
	}
	return $str;
}

function _format_data(&$arr) {
	$URL = &WebApp::singleton('WebAppURL');
	$arr['name'] = &$arr['name'];
	
	if($arr['str_category']){
	$arr['str_title'] = "[".$arr['str_category']."] ".$arr['str_title'];
	}else{
	$arr['str_title'] = "[�Ϲ�] ".$arr['str_title'];
	}

	if($arr['str_text']) $arr['content'] = $arr['str_text'];


	$arr['del_link'] = $URL->getVar(array(
	'act' => '.del_comment',
	'main'=>$arr['num_main'],
	'id' => $arr['num_serial']
	));
}

function allow_tags(&$str,$allow="b|i|font") {
	//Ư�� �±׸� ���
	if (is_array($allow)) $allow = implode("|",$allow);
	$str = preg_replace("/<(\/?)(?!\/|$allow)([^<>]*)?>/i", "&lt;\\1\\2&gt;", $str);

	return $str;
}
// }}}
?>
