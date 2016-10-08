<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 자신만의 코드를 넣어주세요.

// 배추빌더 추가 : 중복로그인
if ($mw[config][cf_overlogin]) {
    $login_time = date("Y-m-d H:i:s", $g4[server_time] - 60*10); // 10분
    $sql = "select * from $mw[session_table] where mb_id = '$mb[mb_id]' and ss_ip != '$_SERVER[REMOTE_ADDR]' and ss_datetime > '$login_time' ";
    $sql.= "order by ss_datetime desc limit 1";
    $row = sql_fetch($sql);
    if ($row) {
	alert("다른 컴퓨터에서 로그인 되어 있습니다.");
    }

    // 배추빌더 추가 : 로그인하면서 기존 세션을 삭제한다.
    sql_query("delete from $mw[session_table] where mb_id = '$mb[mb_id]'");
}
?>
