<?
unlink(_ROOT."/background/"._OID."/".$name);
echo "<script>parent.document.body.style.backgroundImage=''</script>";
if(!$no) WebApp::moveBack('삭제되었습니다.');

?>