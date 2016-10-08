<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-10
* 작성자: 김종태
* 설   명: 유권자 관리
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("vote/admin/people.htm"));
	
	 break;
	case "POST":

	
	
		$newline = chr(10);//\n
		$tab = chr(9);
		$arr_people = explode($newline,$people);

		for($i=0; $i<sizeof($arr_people); $i++){
		
			$start=0;
			list($name,$grade,$class,$jumin)=explode($tab,$arr_people[$i]);
			if(!$name)continue;
			$name=trim($name);
			$jumin=trim($jumin);
			$grade=trim($grade);
			$class=trim($class);

/*            if (getenv('REMOTE_ADDR') == '203.109.24.223') {
                echo "$name|$jumin|$grade|$class<br>";
            } else { */

			$start = rand(0,24);
			$base_code=substr(md5(date('s').$i),$start,5);
			$is_code=$DB->sqlFetchOne("SELECT str_code FROM tab_vote_people WHERE num_oid="._OID." AND str_code='$base_code'");
			$base_code=($is_code) ? substr($base_code,0,3).date('s') : $base_code ;

			$sql ="
					INSERT INTO 
						tab_vote_people(num_oid,str_jumin,str_name,str_grade,str_class,str_code) 
					VALUES
						("._OID.",'$jumin','$name','$grade','$class','$base_code')
			";
			$DB->query($sql);
			$DB->commit();



		}

		echo '<script>alert("등록되었습니다.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/vote.admin.people_list'\">";
		
		



	 break;
	}

?>