<?php
/***************************************************************
* ���ϸ�: module/member/attendance.php
* �ۼ���: 2006.11.8
* �ۼ���: sangsun.Park
* ��  ��:  �⼮üũ 
******************************************************************/
//php���� Ȯ��
//phpinfo();exit;
$Today = "20".date(y)."-".date(m)."-".date(d); //�Էµ� ��¥�� ���ó�¥���� üũ�ϱ� ���ؼ� ���ó�¥ ����

switch (REQUEST_METHOD) {
	case 'POST':
		/************************************************************
		�Ѿ�� ������ ����
		_REQUEST["USERID"] ���̵�
		_REQUEST["NAME"] �̸�
		_POST["dt_date"] ��¥: 2006-11-13 ����
		_POST["subtarget"]  ���к����� (��ȸ��� attendance�Ѿ��) 
		_POST["hak_search"] 1�г� 3�� (�г�� ������)
		_POST["ban"] 2 
		_POST["num_oid"] 20056 �б��ڵ��ȣ
		_POST["num_fcode"] 1012  ���ڵ�
		************************************************************/
        $DOC_TITLE = 'str:������';
		$tpl->setLayout('@sub');

		$DB = &WebApp::singleton('DB');

		//�������� �⺻������ �������� 
		$sql = "SELECT str_id,str_name,chr_mtype,num_fcode,num_auth, num_oid FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_id='".$USERID."' AND chr_mtype='t'";

		$data = $DB->sqlFetch($sql);

		$Str_name = $data['str_name'];				//�̸�
		$Str_id = $data['str_id']; //���̵�
		$Chr_mtype = $data['chr_mtype'];			//����,�л� Ű��: ����:t �л�:s
		$Num_fcode = $data['num_fcode'];			//���ڵ�
		$Num_oid = $data['num_oid'];
		$dt_date = $_POST["dt_date"];

		//������ ��������
		$sql2 ="select str_fname_full, str_fname from tab_class_formation where num_oid=$Num_oid and num_fcode=$Num_fcode";
		
		$data2 = $DB->sqlFetch($sql2);

		$Str_fname_full = $data2['str_fname_full'];				//��
		$Str_fname = $data2['str_fname'];


		//���� ���� �ѿ� ������
		$sql_u = "SELECT num_aa FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND str_type1='".$Num_fcode."' AND num_date like '".$dt_date."' ORDER BY num_date DESC";
		
		$data_u = $DB->sqlFetch($sql_u);

		$confirm = $data_u['num_aa']; // �̰��� ������ ���� �������ؾ� �ϴ� ��¥

		if($confirm == "" && $Subtarget != "insert")
		{	

			//�Էµ� ���� �ִ���.. ������ �ֱ� update�� ��¥�� �������� �����´�. �������� 0����
			$sql_pre = "SELECT num_aa, num_ab, num_ba, num_bb, num_ca, num_cb, num_da, num_db, num_ea, num_eb FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND str_type1='".$Num_fcode."' ORDER BY num_date DESC";
			
			$data_pre = $DB->sqlFetch($sql_pre);
		
			$total_boy_data_pre = $data_pre['num_aa'];
			$total_girl_data_pre = $data_pre['num_ab'];  //�ѿ�

			$num_ba = "0";
			$num_bb = "0";
			$num_ca = "0";
			$num_cb = "0";
			$num_da = "0";
			$num_db = "0";
			$num_ea = "0";
			$num_eb = "0";

			//���ø��� �Ѱ��� ���� ����, ����, ��¥, �Ἦ, ���� ���.........
			$tpl->define('CONTENT', Display::getTemplate('member/attendance.htm'));
			$tpl->assign(array(
				'redir'		=>	$_REQUEST['redir'],
				'num_aa' => "$total_boy_data_pre",
				'num_ab' => "$total_girl_data_pre",
				'num_ba' => "$num_ba",
				'num_bb' => "$num_bb",
				'num_ca' => "$num_ca",
				'num_cb' => "$num_cb",
				'num_da' => "$num_da",
				'num_db' => "$num_db",
				'num_ea' => "$num_ea",
				'num_eb' => "$num_eb",
				'str_name' => "$Str_name",
				'str_fname_full' => "$Str_fname_full",
				'num_date' => "$dt_date"
			));
			break;
			
		}

			// �ش� ��¥ �˻� ����Ȳ ����Ÿ ������//////////////////////////////////////////////////////////////////////////////////////////
			if ($Subtarget == "search" && $confirm != "")
			{
				$sql3 = "SELECT num_aa, num_ab, num_ba, num_bb, num_ca, num_cb, num_da, num_db, num_ea, num_eb FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND num_date like '".$dt_date."' AND str_type1='".$Num_fcode."'";
				
				$select_data2 = $DB->sqlFetch($sql3);
				$total_boy = $select_data2['num_aa'];
				$total_girl = $select_data2['num_ab'];  //�ѿ�
				$num_ba = $select_data2['num_ba'];
				$num_bb = $select_data2['num_bb']; //�Ἦ
				$num_ca = $select_data2['num_ca'];
				$num_cb = $select_data2['num_cb']; //����
				$num_da = $select_data2['num_da'];
				$num_db = $select_data2['num_db']; //����
				$total_man = $select_data2['num_ea'];
				$total_man = $select_data2['num_eb'];
			}
		// �ش� ��¥ �˻� ����Ȳ ����Ÿ ������ ��////////////////////////////////////////////////////////////////////////////////////////


		//����Ȳ DB �μ�Ʈ//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		if ($Subtarget == "insert") 
		{
			$sql3_1 = "SELECT num_aa, num_ab, num_ba, num_bb, num_ca, num_cb, num_da, num_db, num_ea, num_eb FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND num_date like '".$dt_date."' AND str_type1='".$Num_fcode."'";
			
			$select_data3 = $DB->sqlFetch($sql3_1);
			$total_boy_select_data3 =		$select_data3['num_aa'];
			$total_gir_select_data3l =		$select_data3['num_ab'];  //�ѿ�
			$num_ba_select_data3 =		$select_data3['num_ba'];
			$num_bb_select_data3 =		$select_data3['num_bb']; //�Ἦ
			$num_ca_select_data3 =		$select_data3['num_ca'];
			$num_cb_select_data3 =		$select_data3['num_cb']; //����
			$num_da_select_data3 =		$select_data3['num_da'];
			$num_db_select_data3 =		$select_data3['num_db']; //����
			$total_man_select_data3 =	$select_data3['num_ea'];
			$total_man_select_data3 =	$select_data3['num_eb'];

			//���� ó������ �ߺ����� �˻��Ѵ�. 
			$sql_pre_select1 = "SELECT num_date, num_oid, str_id, str_type1 FROM ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND num_date like '".$dt_date."'";

			$select_data1 = $DB->sqlFetch($sql_pre_select1);
			$select_date = $select_data1['num_date'];
			$select_oid = $select_data1['num_oid'];
			$select_id = $select_data1['str_id'];
			$select_class = $select_data1['str_type1'];

			//������ ��ġ���� ������ �ߺ��̹Ƿ� ���� ���� ������Ʈ ��Ų��
			if ($select_date == $dt_date & $select_oid == $Num_oid & $Num_fcode == $select_class)
			{
				$str_id = $USERID;
				$str_name = $NAME;
				$str_grade_sub1 = substr($Str_fname_full, 0,1);
				$str_class_sub1 = substr($Str_fname, 0,1);
					if ($str_class_sub1 == "1"){
						$str_class = "a";
					}else if ($str_class_sub2 == "2"){
						$str_class = "b";
					}else if ($str_class_sub2 == "3"){
						$str_class = "b";
					}else if ($str_class_sub2 == "4"){
						$str_class = "b";
					}else if ($str_class_sub2 == "5"){
						$str_class = "b";
					}else if ($str_class_sub2 == "6"){
						$str_class = "b";
					}else if ($str_class_sub2 == "7"){
						$str_class = "b";
					}else if ($str_class_sub2 == "8"){
						$str_class = "b";
					}else if($str_class_sub2 == "9"){
						$str_class = "b";
					}
				$ban_code = $Num_fcode;
				$num_aa = $mjejuk;  //�� ����
				$num_ab = $wjejuk;   // �� ����
				$num_total = $num_aa+$num_ab;
				$num_ba = $mgyulsuk; //�� �Ἦ
				$num_bb = $wgyulsuk; //�� �Ἦ
				$num_ca = $mjotoi; //�� ����
				$num_cb = $wjotoi; //�� ����
				$num_da = $mjunip; //�� ����
				$num_db = $wjunip; //�� ����
				$num_ea = $mjunchul; //�� ����
				$num_eb = $mjunchul; //�� ����
				$num_oid = $Num_oid; // �б���ȣ
				$num_fcode = $Num_fcode; //���ڵ�

				if ($dt_date == "")
							{
								echo "
								<script>
								alert('��¥�� �Է��ϼ���');
								history.go(-1);
								</script>
								";
							}
			
				$sql4_update = "UPDATE TAB_ATTENDANCE SET
								num_oid='$num_oid', str_grade='$str_grade_sub1', str_class='$str_class_sub1', num_total=$num_total, num_aa=$num_aa, num_ab=$num_ab, num_ba=$num_ba, num_bb=$num_bb, num_ca=$num_ca, num_cb=$num_cb, num_da=$num_da, num_db=$num_db, num_ea=$num_ea, num_eb=$num_eb, str_name='$str_name', str_id='$str_id', str_type1='$num_fcode' WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND str_type1='".$Num_fcode."' AND num_date like '".$dt_date."'";

				$DB->query($sql4_update);

				$DB->commit();

				$_url = "member.attendance?Subtarget=complet&set_date=".$dt_date;
				$redir_url = $redir.$_url;
				echo "
						<script>
						alert('����� ���� �Ǿ����ϴ�.');
						</script>
						";
				WebApp::redirect($redir_url);
	
			}else{

					//�μ�Ʈ ������ ����
					$str_id = $USERID;
					$str_name = $NAME;
					$str_grade_sub1 = substr($Str_fname_full, 0,1);
					$str_class_sub1 = substr($Str_fname, 0,1);
						if ($str_class_sub1 == "1"){
							$str_class = "a";
						}else if ($str_class_sub2 == "2"){
							$str_class = "b";
						}else if ($str_class_sub2 == "3"){
							$str_class = "b";
						}else if ($str_class_sub2 == "4"){
							$str_class = "b";
						}else if ($str_class_sub2 == "5"){
							$str_class = "b";
						}else if ($str_class_sub2 == "6"){
							$str_class = "b";
						}else if ($str_class_sub2 == "7"){
							$str_class = "b";
						}else if ($str_class_sub2 == "8"){
							$str_class = "b";
						}else if($str_class_sub2 == "9"){
							$str_class = "b";
						}
					$ban_code = $Num_fcode;

					$num_aa = $mjejuk;  //�� ����
					$num_ab = $wjejuk;   // �� ����
					$num_total = $num_aa+$num_ab;
					$num_ba = $mgyulsuk; //�� �Ἦ
					$num_bb = $wgyulsuk; //�� �Ἦ
					$num_ca = $mjotoi; //�� ����
					$num_cb = $wjotoi; //�� ����
					$num_da = $mjunip; //�� ����
					$num_db = $wjunip; //�� ����
					$num_ea = $mjunchul; //�� ����
					$num_eb = $mjunchul; //�� ����
					$num_oid = $Num_oid; // �б���ȣ
					$num_fcode = $Num_fcode; //���ڵ�

					if ($dt_date == "")
					{
						echo "
						<script>
						alert('��¥�� �Է��ϼ���');
						history.go(-1);
						</script>
						";
					}
					
					$sql4 = "INSERT INTO TAB_ATTENDANCE 
								(num_date, num_oid, str_grade, str_class, num_total, num_aa, num_ab, num_ba, num_bb, num_ca, num_cb, num_da, num_db, num_ea, num_eb, str_name, str_id, str_type1)
								VALUES 
								('$dt_date','$num_oid','$str_grade_sub1','$str_class_sub1',$num_total,$num_aa,$num_ab,$num_ba,$num_bb,$num_ca,$num_cb,$num_da,$num_db,$num_ea,$num_eb,'$str_name','$str_id','$num_fcode')
								";
					$DB->query($sql4);

					$DB->commit();

					$_url = "member.attendance?Subtarget=complet&set_date=".$dt_date;
					$redir_url = $redir.$_url;
					 echo "
						<script>
						alert('����� ���õǾ����ϴ�.');
						</script>
						";
						WebApp::redirect($redir_url);

			}
					
		}
		//����Ȳ DB �μ�Ʈ ��///////////////////////////////////////////////////////////////////////////////////////////////////////////

		$tpl->define('CONTENT', Display::getTemplate('member/attendance.htm'));
		$tpl->assign(array(
			'redir'		=>	$_REQUEST['redir']
		));
		$tpl->assign($data); //���ø��� ������ �Ѱ���
		$tpl->assign($data2); //
		$tpl->assign($_POST); //�Ѿ�� �� 
		$tpl->assign($select_data2); //��ᰪ ������
		$tpl->assign($select_data3); //�μ�Ʈ �� �׳�¥ ��ᰪ ������
		$tpl->assign($data_pre);

		break;

	case 'GET':
		$DB = &WebApp::singleton('DB');

		//�μ�Ʈ, ������Ʈ �Ϸ��� ���õ� �� ��������
		if ($Subtarget == "complet")
		{
			$dt_date = $set_date;
			
			$sql_view = "SELECT str_id,str_name,chr_mtype,num_fcode,num_auth, num_oid FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_id='".$USERID."' AND chr_mtype='t'";

			$data_view = $DB->sqlFetch($sql_view);

			$Str_name = $data_view['str_name'];				//�̸�
			$Str_id = $data_view['str_id']; //���̵�
			$Chr_mtype = $data_view['chr_mtype'];			//����,�л� Ű��: ����:t �л�:s
			$Num_fcode = $data_view['num_fcode'];			//���ڵ�
			$Num_oid = $data_view['num_oid'];
	
			$sql3_view = "SELECT num_date, num_aa, num_ab, num_ba, num_bb, num_ca, num_cb, num_da, num_db, num_ea, num_eb FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND num_date like '".$dt_date."' AND str_type1='".$Num_fcode."'";
			
			$select_data2_view = $DB->sqlFetch($sql3_view);
			$total_boy = $select_data2_view['num_aa'];
			$total_girl = $select_data2_view['num_ab'];  //�ѿ�
			$num_ba = $select_data2_view['num_ba'];
			$num_bb = $select_data2_view['num_bb']; //�Ἦ
			$num_ca = $select_data2_view['num_ca'];
			$num_cb = $select_data2_view['num_cb']; //����
			$num_da = $select_data2_view['num_da'];
			$num_db = $select_data2_view['num_db']; //����
			$total_man = $select_data2_view['num_ea'];
			$total_man = $select_data2_view['num_eb'];
			$dt_date = $select_data2_view['num_date'];

			$sql2_view ="select str_fname_full from tab_class_formation where num_oid=$Num_oid and num_fcode=$Num_fcode";
		
			$data2_view = $DB->sqlFetch($sql2_view);

			$Str_fname_full = $data2_view['str_fname_full'];	

		}else{

			if($dt_date == "") //��¥���� ���ٸ�
			{
				$sql0 = "SELECT str_id,str_name,chr_mtype,num_fcode,num_auth, num_oid FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_id='".$USERID."' AND chr_mtype='t'";

				$data0 = $DB->sqlFetch($sql0);

				$Str_name = $data0['str_name'];				//�̸�
				$Str_id = $data0['str_id']; //���̵�
				$Chr_mtype = $data0['chr_mtype'];			//����,�л� Ű��: ����:t �л�:s
				$Num_fcode = $data0['num_fcode'];			//���ڵ�
				$Num_oid = $data0['num_oid'];

				$sql00 = "SELECT num_date FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND str_type1='".$Num_fcode."' ORDER BY num_date DESC";
				
				$data_sql00 = $DB->sqlFetch($sql00);
				$check_today = $data_sql00['num_date'];

				if ($check_today == $Today)
				{
					$sql_pre = "SELECT num_aa, num_ab, num_ba, num_bb, num_ca, num_cb, num_da, num_db, num_ea, num_eb FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND str_type1='".$Num_fcode."' ORDER BY num_date DESC";
							
					$data_pre = $DB->sqlFetch($sql_pre);
				

					$total_boy_data_pre = $data_pre['num_aa'];
					$total_girl_data_pre = $data_pre['num_ab'];  //�ѿ�
				}else if($check_today != $Today)
				{
					$sql_pre = "SELECT num_aa, num_ab FROM  ".TAB_ATTENDANCE." WHERE num_oid='".$Num_oid."' AND str_id='".$USERID."' AND str_type1='".$Num_fcode."' ORDER BY num_date DESC";
							
					$data_pre = $DB->sqlFetch($sql_pre);
				

					$total_boy_data_pre = $data_pre['num_aa'];
					$total_girl_data_pre = $data_pre['num_ab'];  //�ѿ�

					$num_ba = "0";
					$num_bb = "0";
					$num_ca = "0";
					$num_cb = "0";
					$num_da = "0";
					$num_db = "0";
					$num_ea = "0";
					$num_eb = "0";
				}

				//���ø��� �Ѱ��� ���� ����, ����, ��¥, �Ἦ, ���� ���.........
				$tpl->define('CONTENT', Display::getTemplate('member/attendance.htm'));
				$tpl->assign(array(
					'redir'		=>	$_REQUEST['redir'],
					'num_aa' => "$total_boy_data_pre",
					'num_ab' => "$total_girl_data_pre",
					'num_ba' => "$num_ba",
					'num_bb' => "$num_bb",
					'num_ca' => "$num_ca",
					'num_cb' => "$num_cb",
					'num_da' => "$num_da",
					'num_db' => "$num_db",
					'num_ea' => "$num_ea",
					'num_eb' => "$num_eb",
					'str_name' => "$Str_name",
					'str_fname_full' => "$Str_fname_full",
					'num_date' => "$Today"
				));
				//break;
			}

			//�μ�Ʈ, ������Ʈ�� �ƴϸ� 
			$sql = "SELECT str_id,str_name,chr_mtype,num_fcode,num_auth, num_oid FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_id='".$USERID."' AND chr_mtype='t'";

			$data = $DB->sqlFetch($sql);

			$Str_name = $data['str_name'];				//�̸�
			$Str_id = $data['str_id']; //���̵�
			$Chr_mtype = $data['chr_mtype'];			//����,�л� Ű��: ����:t �л�:s
			$Num_fcode = $data['num_fcode'];			//���ڵ�
			$Num_oid = $data['num_oid'];

			if ($Str_name == "")									// ���������� üũ
			{
				 echo "
					<script>
					alert('�����Ը��� �����Դϴ�.');
					history.go(-1);
					</script>
					";
			}
			$sql2 ="select str_fname_full from tab_class_formation where num_oid=$Num_oid and num_fcode=$Num_fcode";
		
			$data2 = $DB->sqlFetch($sql2);

			$Str_fname_full = $data2['str_fname_full'];				//��
		
		}
			
		$DOC_TITLE = 'str:������';
		$tpl->setLayout('@sub');
		$tpl->define('CONTENT', Display::getTemplate('member/attendance.htm'));
        $tpl->assign($data);
		$tpl->assign($data_view);
		$tpl->assign($data2);
		$tpl->assign($select_data2); //��ᰪ ������
		$tpl->assign($select_data2_view);
		$tpl->assign($data_pre);
		$tpl->assign($data2_view);
		$tpl->assign($num_ba);
		$tpl->assign($num_bb);
		$tpl->assign($num_ca);
		$tpl->assign($num_cb);
		$tpl->assign($num_da);
		$tpl->assign($num_db);
		$tpl->assign($num_ea);
		$tpl->assign($num_eb);
		$tpl->assign(array(
			'redir'		=>	$_REQUEST['redir']
		));
		break;
		exit;
}

?>