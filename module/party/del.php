<?
unlink(_ROOT."/background/"._OID."/"_PCODE."/".$name);
echo "<script>parent.document.body.style.backgroundImage=''</script>";
echo '<script>alert("삭제되었습니다.");</script>';



?>