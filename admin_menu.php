<?

$menu = array();




$cate1 = 0;

$menu[$cate1]['title'] = "�����";
$menu[$cate1]['link'] = "/admin.common";
	
	$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "Ȩ������ �⺻����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin.common"; 
	$menu[$cate1]['submenu'][$cate2]['tip'] = "Ȩ�������� �⺻������ �Է��մϴ�."; 
	
	$cate2 = 1;
	$menu[$cate1]['submenu'][$cate2]['title'] = "������ ��ȣ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin.passwd";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "������ ��ȣ�� �����մϴ�.";
	
	$cate2 = 2;
	$menu[$cate1]['submenu'][$cate2]['title'] = "����������ȣ��ħ ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin.pra";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "Ȩ������ ȸ���� �������� ��ȣ��ħ�� �ۼ��մϴ�.";

	$cate2 = 3;
	$menu[$cate1]['submenu'][$cate2]['title'] = "Ȩ������ �̿��� ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin.pra3";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "Ȩ������ ȸ���� �̿����� �ۼ��մϴ�.";

	$cate2 = 4;
	$menu[$cate1]['submenu'][$cate2]['title'] = "���۱� ��ȣ��ħ ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin.pra2";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "���۱� ��ȣ��ħ�� �ۼ��մϴ�.";
	$cate2 = 5;
	$menu[$cate1]['submenu'][$cate2]['title'] = "�Խ��� ���͸� ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin.bitext?PageNum=020303";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "�� �Խ��ǿ� ��Ģ� �ϰ������� �����մϴ�.";
/*
	$cate2 = 6;
	$menu[$cate1]['submenu'][$cate2]['title'] = "÷������ ��뷮";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/manage.admin.organ_view?mode=disk";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "���ε�� ���� ��Ȳ Ȯ��";
	
	$cate2 = 7;
	$menu[$cate1]['submenu'][$cate2]['title'] = "�Խ��� ��� ��Ȳ";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/manage.admin.organ_view?mode=board";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "����,�Ϻ� �Խù� ���ε� ��Ȳ Ȯ��";
	
*/	
	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "�湮�� ���";
	$menu[$cate1]['submenu'][$cate2]['link'] = "manage.admin.organ_view?mode=count";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "����,�Ϻ� �湮�� ��ȲȮ��";
	






$cate1 = 1;
$menu[$cate1]['title'] = "��ɰ���";
$menu[$cate1]['link'] = "/banner.admin.list";
	
	/*$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "�޴�����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/menu.admin.frame";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "Ȩ�������� �Խ���, ������������ �޴��� �����մϴ�."; 

	$cate2 = 1;
	$menu[$cate1]['submenu'][$cate2]['title'] = "�޴��̵� ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/menu.admin.move";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "Ȩ������ �޴� ��ġ�� �����մϴ�."; 

	/*$cate2 = 2;
	$menu[$cate1]['submenu'][$cate2]['title'] = "����Ʈ �ٷΰ��� ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/menu.admin.site_add";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "����Ʈ �ڽ� ������ ��ũ �޴��Դϴ�."; */
/*
	$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "��� ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/banner.admin.list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "��ʸ� ����ϰ� �����մϴ�."; 

	$cate2 = 1;
	$menu[$cate1]['submenu'][$cate2]['title'] = "��������";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/poll.admin.list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "�������縦 �Խ��մϴ�."; 

	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "����ȭ�� ���־����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/vis.admin.list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "����ȭ�� ���־��� �����մϴ�."; 
*/
	$cate2=0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "��û�� ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "form.admin.main?admin=y";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "����ڻ� ������ ���� �Է��� �����͸� �����ϰ� �����մϴ�."; 

	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "�˾�����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/popup.admin.list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "�˾��� �����մϴ�.";
	
	/*
	$cate2 = 1;
	$menu[$cate1]['submenu'][$cate2]['title'] = "Ȩ������ ���޴� ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/qmenu.admin.main";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "Ȩ�������� ���޴�(�ٷΰ���)�� �����մϴ�."; 

	$cate2 = 2;
	$menu[$cate1]['submenu'][$cate2]['title'] = "�˾�/��ʰ���";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/banner.admin.list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "�˾��� ��ʸ� �����մϴ�.";

	$cate2 = 3;
	$menu[$cate1]['submenu'][$cate2]['title'] = "����������� ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/calendar.admin.list?PageNum=030401";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "�پ��� ���� ������ ��ɵ��� ���� �ϴ� ���Դϴ�.";
	*/

	
	
	/*
	$cate2 = 5;
	$menu[$cate1]['submenu'][$cate2]['title'] = "Ŀ�´�Ƽ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/party.admin.list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "���Ƹ�, ��������, ��ǥ ���";
	*/




$cate1 = 2;
$menu[$cate1]['title'] = "ȸ������";
$menu[$cate1]['link'] = "/member.admin.list?noauth=1";




	$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "��ȸ������";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/member.admin.list?noauth=1";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "������ �Ϸ�� ȸ���� ����� �����ݴϴ�."; 


/*
	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "�������ȸ������";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/member.admin.list?noauth=0";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "������� ȸ������ ����� �����ݴϴ�."; 
*/	

	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "ȸ���׷����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/member.admin.group_list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "�⺻���ѱ׷�Ʒ� �����з��� ����ϴ�."; 


	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "ȸ�� ����Ʈ ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/member.admin.point_list";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "ȸ������ ����Ʈ�� �����մϴ�."; 


	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "�ҷ�ȸ�� ���ܰ���";
	$menu[$cate1]['submenu'][$cate2]['link'] = "member.admin.crossuser";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "���Էκ�, �ҷ�ȸ���� �����մϴ�."; 
	
	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "ȸ������ ��� ����Ʈ";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/member.admin.list_ac";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "ȸ������ ��� ��Ȳ�� Ȯ�� �� ���� �� �� �ֽ��ϴ�."; 
	

	
	/*$cate2 = 5;
	$menu[$cate1]['submenu'][$cate2]['title'] = "��å �� �̿���";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/member.admin.info";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "����������å�̳� �̿����� �����մϴ�.";
*/
global $DB;
$sql = "select num_ccode from TAB_LMS_CATE where str_delete='n' order by num_step asc limit 1 ";
$f_ccode = $DB -> sqlFetchOne($sql);


$cate1 = 3;
$menu[$cate1]['title'] = "�߰����";
$menu[$cate1]['link'] = "/lms.admin.main";
	
	

	$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "ķ�� ���α׷� ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/lms.admin.list?ccode=".$f_ccode;
	$menu[$cate1]['submenu'][$cate2]['tip'] = "ķ�� ���α׷��� �����մϴ�.";
		
		$cate3 = 0;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['title'] = "ķ�� ��� ����";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['link'] = "/lms.admin.list?ccode=".$f_ccode;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['tip'] = "�������α׷� ����� ���";

		$cate3 = 1;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['title'] = "ķ�� ���α׷� ����";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['link'] = "/lms.admin.cate";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['tip'] = "������ ī�װ��� �����մϴ�.";

		

	
	
	
	$cate2 = 1;
	$menu[$cate1]['submenu'][$cate2]['title'] = "ķ������";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/lms.admin.order_list?all=y";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "ķ�� ��û��ȲȮ�� �� ���並 �����մϴ�.";
		
		$cate3 = 0;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['title'] = "��ü����";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['link'] = "/lms.admin.order_list?all=y";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['tip'] = "���� ��û ���";

		$cate3++;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['title'] = "������û ����";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['link'] = "/lms.admin.order_list";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['tip'] = "���� ��û ���";

		$cate3++;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['title'] = "��û ����� ����";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['link'] = "/lms.admin.order_list?hold=y";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['tip'] = "ķ�� ��û ����� ���";

		$cate3++;
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['title'] = "���/ȯ�� ����";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['link'] = "/lms.admin.order_list?cancel=y";
		$menu[$cate1]['submenu'][$cate2]['submenu_sub'][$cate3]['tip'] = "ķ�� ��û ��� ���";


		
	$cate2 = 2;
	$menu[$cate1]['submenu'][$cate2]['title'] = "���� ����";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/lms.admin.tach";
	$menu[$cate1]['submenu'][$cate2]['tip'] = " ���並 �����մϴ�.";






	 for($ii=0; $ii<count($menu); $ii++) { 
		$iia = $ii +1;

		if(strstr($menu[$ii]['link'],"?")) {
		$menu[$ii]['pn'] ="&PageNum=0".$iia."0100";	
		}else{
		$menu[$ii]['pn'] ="?PageNum=0".$iia."0100";	
		}
		

		for($i=0; $i<count($menu[$ii]['submenu']); $i++) {
		$ia = $i +1;
			if(strstr($menu[$ii]['submenu'][$i]['link'],"?")) {
			$menu[$ii]['submenu'][$i]['pn'] ="&PageNum=0".$iia."0".$ia."00";	
			}else{
			$menu[$ii]['submenu'][$i]['pn'] ="?PageNum=0".$iia."0".$ia."00";	
			}
			
			for($iii=0; $iii<count($menu[$ii]['submenu'][$i]['submenu_sub']); $iii++) {
				$iaa = $iii +1;
				
				if(strstr($menu[$ii]['submenu'][$i]['submenu_sub'][$iii]['link'],"?")) {
				$menu[$ii]['submenu'][$i]['submenu_sub'][$iii]['pn'] ="&PageNum=0".$iia."0".$ia."0".$iaa;	
				}else{
				$menu[$ii]['submenu'][$i]['submenu_sub'][$iii]['pn'] ="?PageNum=0".$iia."0".$ia."0".$iaa;	
				}
			
			}
			

		}

	 }


?>