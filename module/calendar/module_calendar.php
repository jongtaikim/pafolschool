<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-11-12
* �ۼ���: ������
* ��  ��: main.php ǥ�� ����
*****************************************************************
* 
*/
$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.calendar.htm";
if($del =="y") unlink($cache_file);
if(!is_file($cache_file) || date('Ymd H') > date('Ymd H',filemtime($cache_file))) {


$DB = &WebApp::singleton("DB"); //���Ŭ����
$URL = &WebApp::singleton('WebAppURL'); //URL Ŭ����
$tpl = &WebApp::singleton('Display'); //���ø����� Ŭ����
$mcode = $param['code'];  //<wa:��� code="{mcode}"> wa�ױ׿��� ���� ������ $mcode


if(!$conf[title2]) $conf[title2]=$conf[title1];

$tpl->assign($conf);
$tpl->assign($conf_main);


/*...... �̰��� ��� select�� ���� ���� �۾��� ���� .... */

	$CAL = &WebApp::singleton('Calendar');
	
	# �̴��� ����
	$startdate = date("Ym")."01";
	$lastdate =  date("Ym").date('t',strtotime($ym.'01'));
	$sql = "SELECT /*+ INDEX(".TAB_CALENDAR." ".IDX_TAB_CALENDAR_DATE.") */ num_serial,num_date FROM ".TAB_CALENDAR." ".
           "WHERE num_oid="._OID." AND num_date >= $startdate AND num_date <= $lastdate";
	$DB->query($sql);
	while($row = $DB->fetch()) {
		$CAL->setEvent(substr($row['num_date'],6,2), $row['num_serial']);
	}

	$sql2 = "SELECT /*+ INDEX(".TAB_CALENDAR." ".IDX_TAB_CALENDAR_DATE.") */ num_serial,num_date,str_title FROM ".TAB_CALENDAR." ".
           "WHERE num_oid="._OID." AND num_date >= $startdate AND num_date <= $lastdate " ;

	$row2 = $DB-> sqlFetchAll($sql2);
	$mk = date("m");
	for($ii=0; $ii<count($row2); $ii++) {

		$row2[$ii][num_date2] = substr($row2[$ii][num_date],6,2);
		$row2[$ii][num_date2] = $row2[$ii][num_date2];
		$row2[$ii]['str_title'] = Display::text_cut($row2[$ii]['str_title'],26,".."); 
	}


	$CAL->setEventHandler('<a href="#" onclick="window.open(\'calendar.view?date=%N\',\'calendar\',\'width=600,height=600,scrollbars=1\');"><span class=" haveSchedule" title="�o��?">%d</span></a>');


    if(isset($param['print_header'])) $CAL->config['print_header'] = $param['print_header'];
    $calendar_body = $CAL->get_body();
	$calendar = $CAL->__toString();

    $today = date('Y/m/d');
    list($year,$month,$day) = explode('/',$today);
	
	$tpl->assign(array(
    'LIST_calendar'=>$row2   ,
	'calendar_body' => $calendar_body,
		'calendar'      => $calendar,
		'date'          => $today,
		'today'         => $today,
        'year'          => $year,
        'month'         => $month,
        'day'           => $day
	));

$make = "y";
} else {
	$fp = fopen($cache_file,'r');
	$content = fread($fp,filesize($cache_file));
	fclose($fp);
}



?>