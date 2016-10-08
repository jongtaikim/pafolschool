<?
if($name){
$pop_skininfo = parse_ini_file("html/popup/".$area."/".$name."/skin.conf.php");
echo $pop_skininfo['name'];
}else{
echo "스킨을 선택하세요";
}
?>