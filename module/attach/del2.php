<?

unlink(_DOC_ROOT.'/hosts/'.HOST.'/'.$name);
$a = explode("_",$name);
$a = explode(".",$a[1]);

echo "<script>parent.document.getElementById('".$a[0]."').style.backgroundImage='none'</script>";
WebApp::moveBack('삭제되었습니다.');

?>