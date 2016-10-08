<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2011-08-02
* 작성자: 김종태
* 설   명: now_sch 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');



function make_where ($blank_is, $column_list, $word, $ban)
{
global $word_list;

   if($ban)
   {
   $like   = "NOT LIKE";
   $join   = "AND";
   }
   else
   {
   $like   = "LIKE";
   $join   = "OR";
   }

$word   = stripslashes($word);
$temp        = eregi_replace("(\")(.*)( +)(.*)(\")","\\2[###blank###]\\4",$word);
$temp        = eregi_replace("\(|\)| and | or "," \\0 ",$temp);
$temp        = trim(eregi_replace(" {2,}"," ",$temp));
$result[word]   = eregi_replace("\(|\)| and | or "," ",$temp);
$temp        = explode(" ",$temp);

   for($i=0; $i<sizeof($temp); $i++)
   {
        if($i)
        {
             if(eregi("^\)$",$temp[$i-1]) && !eregi("^or$|^and$",$temp[$i]))
             {
             $temp2[]   = $blank_is;
             }
   
             if(!eregi("^(\(|\)|and|or)$",$temp[$i-1]) && eregi("^\($",$temp[$i]))
             {
             $temp2[]   = $blank_is;
             }

             if(!eregi("^(\(|\)|and|or)$",$temp[$i-1]) && !eregi("^(\(|\)|and|or)$",$temp[$i]))
             {
             $temp2[]   = $blank_is;
             }
        }

   $temp2[]   = $temp[$i];
   }



   for($i=0; $i<sizeof($temp2); $i++)
   {
        if(eregi("^(\(|\)|and|or)$",$temp2[$i]))
        {
        continue;
        }

   unset($temp);
   $temp        .= "(";
   $temp2[$i]   = addslashes($temp2[$i]);
   $column_list_array =explode(",",$column_list);

        for($j=0; $j<sizeof($column_list_array); $j++)
        {
             if($j && $temp && $temp!="(")
             {
             $temp   .= " $join";
             }

        $temp   .= " $column_list_array[$j] $like '%$temp2[$i]%'";

        
        }

   $temp   .= ")";
   $temp2[$i] = $temp;
   }

$temp       = implode(" ",$temp2);
$result[where]   = str_replace("[###blank###]"," ",$temp);

return $result;
}


function cut_str($str,$len,$tail="..") {
	if(strlen($str) > $len) {
	for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
		$str=substr($str,0,$i).$tail;
	}
	return $str;
}


function cut2($a,$b,$res,$array="1"){
	
	if($array =="0") $array ="1";

	$tmp = explode($a,$res);
	$tmp = explode($b,$tmp[$array]);
	$tmp = $tmp[0];
	return $tmp;
}


switch ($REQUEST_METHOD) {
	case "GET":
	
	$DOC_TITLE="str:검색결과";
	$DOC_TITLE2="str:Search";

	if($keyword){
		$datas[num_oid] = _OID;
		$datas[str_keyword] = $keyword;

		$DB->insertQuery($keyword_table,$datas);
		$DB->commit(); 
		
		 $sql = "UPDATE ".$keyword_table." SET num_hit=num_hit+1 WHERE num_oid=$_OID and str_keyword = '".$keyword."'";
		 if($DB->query($sql)){
		  $DB->commit();
		}
		
	}
	
	$sql = "select * from $keyword_table where num_oid = '$_OID' and str_keyword like '%$keyword%' order by num_hit desc  limit 0,5 ";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('keyword_LIST'=>$row));
	
	

	$psql = make_where("or","str_text,str_title,str_location" ,$keyword,'0');
	$psql = $psql[where];
	$psql .= " or str_title like '%".str_replace(" ","",$keyword)."%'";

	if(!$page = $_REQUEST['page']) $page = 1;
	
	if(!$listnum)$listnum = 10;
	$sql = "SELECT COUNT(*) FROM ".$table." WHERE $psql  ";
	
	$total = $DB->sqlFetchOne($sql);
	if(!$total) $total = 0;
	
	$seek = $listnum * ($page - 1);
	$offset = $seek + $listnum;
	
	$sql = "
	select * from $table where $psql order by num_hit desc limit $seek, $listnum ";
	
	

	$row = $DB -> sqlFetchAll($sql);
	for($ii=0; $ii<count($row); $ii++) {
		$row[$ii][str_text_len] = cut_str($row[$ii][str_text],300,'...');
		$row[$ii][mcode] = cut2("?mcode=","&",$row[$ii][str_url]);

		$row[$ii]['location'] = 
		 $DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate=".substr($row[$ii][mcode],0,-2))." >".$DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate=".$row[$ii][mcode]);

	}
	
	
	$tpl->assign(array(
		'LIST'=>$row,
		'page'=>$page,
		'total'=>$total,
		'listnum'=>$listnum,
 	));
	
	

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("now_sch/query.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>