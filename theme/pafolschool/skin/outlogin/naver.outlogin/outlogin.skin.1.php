<?
/**
 * Bechu-Outlogin Skin for Gnuboard4
 *
 * Copyright (c) 2008 Choi Jae-Young <www.miwit.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$url = '';
if ($g4['https_url']) {
    if (preg_match("/^\./", $urlencode))
        $url = $g4[url];
    else
        $url = $g4[url].$urlencode;
} else {
    $url = $urlencode;
}
?>

<!-- 로그인 전 외부로그인 시작 -->
<div id="mw-outlogin">
<form name="flogin" method="post" action="javascript:flogin_submit(document.flogin);" autocomplete="off">
<input type="hidden" name="url" value="<?=$url?>">
<div class="box-outside">
<div class="box-inside">
    <input type="text" name="mb_id" id="mb_id" class="login-mb_id" value="">
    <input type="password" name="mb_password" id="mb_password" class="login-mb_password" value="">
    <input type="image"  class="login-button" src="<?=$outlogin_skin_path?>/img/outlogin_button.gif" align="absmiddle">
    <input type="image"  class="login-div" src="<?=$outlogin_skin_path?>/img/login_div.gif" align="absmiddle">
 
   <div class="login-intro">

<a href="javascript:loginCheck();" class="text2">보안
<span id="login_level"><class='level_type2 bold'><B>2</B></span></li>
 단계</a>
 </div>



   <div class="login-intro_1">

<a href="javascript:useLevel(1);" title="보안1단계"> 
<img id="lv1_img" src="<?=$outlogin_skin_path?>/img/1.gif" alt="보안1단계" width="19" height="15" /> 
</a> 
 </div>
   <div class="login-intro_2">
<a href="javascript:useLevel(2);" title="보안2단계"> 
<img id="lv2_img" src="<?=$outlogin_skin_path?>/img/2_on.gif" alt="보안2단계" width="18" height="15" /> 
</a> 
 </div>
   <div class="login-intro_3">
<a href="javascript:useLevel(3);" title="보안3단계"> 
<img id="lv3_img" src="<?=$outlogin_skin_path?>/img/3.gif" alt="보안3단계" width="18" height="15" /> 
</a> 
 </div>






   <div class="login-IP">

        <a href="javascript:loginCheck();" class="ip">IP보안</a></li>
        <span id="login_ip"><a href="javascript:loginIp('Off');" class='ip_type1 bold'><B>ON</a></B></span></li>

</div>

<script type="text/javascript">

function useLevel(levelno) { 
if (levelno == 1) { 
document.getElementById("lv1_img").src="<?=$outlogin_skin_path?>/img/1_on.gif"; 
document.getElementById("lv2_img").src="<?=$outlogin_skin_path?>/img/2.gif"; 
document.getElementById("lv3_img").src="<?=$outlogin_skin_path?>/img/3.gif"; 
document.getElementById("login_level").innerHTML = "<B>1</B>";


} else if (levelno == 2) { 
document.getElementById("lv1_img").src="<?=$outlogin_skin_path?>/img/1.gif"; 
document.getElementById("lv2_img").src="<?=$outlogin_skin_path?>/img/2_on.gif"; 
document.getElementById("lv3_img").src="<?=$outlogin_skin_path?>/img/3.gif"; 
document.getElementById("login_level").innerHTML = "<B>2</B>";


} else if (levelno == 3) { 
document.getElementById("lv1_img").src="<?=$outlogin_skin_path?>/img/1.gif"; 
document.getElementById("lv2_img").src="<?=$outlogin_skin_path?>/img/2.gif"; 
document.getElementById("lv3_img").src="<?=$outlogin_skin_path?>/img/3_on.gif";
document.getElementById("login_level").innerHTML = "<B>3</B>";


} 
} 


function loginCheck()
{

    alert("보안 서비스 입니다.");
    return;

}



function loginIp(id)
{

    if (id == 'On') {

        document.getElementById("login_ip").innerHTML = "<a href=\"javascript:loginIp('Off');\" class='ip_type1 bold'><B>ON</a></B>";

    } else {

        document.getElementById("login_ip").innerHTML = "<a href=\"javascript:loginIp('On');\" class=''><B>OFF</a></B>";

    }

}
</script>









 </div>




    <div class="login-membership">
        <a href="<?=$g4[bbs_path]?>/register.php"><strong>회원가입</strong></a> <span>|</span>
        <a href="javascript:win_password_forget();">회원정보 찾기</a>
    </div>
</div>
</div>
</form>
</div>
<!-- 로그인 전 외부로그인 끝 -->

<script type="text/javascript">
document.getElementById("mb_id").onfocus = function() { mw_outlogin_focus_id(this); }
document.getElementById("mb_id").onblur = function() { mw_outlogin_blur_id(this); }
document.getElementById("mb_password").onfocus = function() { mw_outlogin_focus_pw(this); }
document.getElementById("mb_password").onblur = function() { mw_outlogin_blur_pw(this); }
document.getElementById("mb_password").onblur = function() { mw_outlogin_blur_pw(this); }
document.getElementById("auto_login").onclick = function() { mw_outlogin_auto(this); }

function mw_outlogin_focus_id(obj) {
    if (obj.value == "아이디") {
        obj.value = "";
    }
    //obj.style.border = "1px solid #7dacd8";
    obj.style.border = "1px solid #e2e2e2";
}
function mw_outlogin_blur_id(obj) {
    if (obj.value == "") {

    }
    obj.style.border = "1px solid #d3d3d3";
}
function mw_outlogin_focus_pw(obj) {
    if (obj.value == "") {
        obj.style.background = "#fff";
    }
    //obj.style.border = "1px solid #7dacd8";
    obj.style.border = "1px solid #e2e2e2";
}
function mw_outlogin_blur_pw(obj) {
    if (obj.value == "") {

    }
    obj.style.border = "1px solid #d3d3d3";
}

function flogin_submit(f)
{
    if (!f.mb_id.value) {
        alert("회원아이디를 입력하십시오.");
        f.mb_id.focus();
        return;
    }
    if (!f.mb_password.value) {
        alert("패스워드를 입력하십시오.");
        f.mb_password.focus();
        return;
    }

    <?
    if ($g4[https_url])
        echo "f.action = '$g4[https_url]/$g4[bbs]/login_check.php';";
    else
        echo "f.action = '$g4[bbs_path]/login_check.php';";
    ?>
    f.submit();
}
</script>

<style type="text/css">
#mw-outlogin .box-outside { width:250px; height:100px; background-color:#e2e2e2; }
#mw-outlogin .box-inside { position:absolute; margin:1px; width:248px; height:98px; background-color:#f3f4f3; }
#mw-outlogin .box-inside { line-height:16px; color:#7dacd8; font-size:9pt; font-family:gulim; }
#mw-outlogin .login-title { position:absolute; margin:5px 0 0 7px; }
#mw-outlogin .login-mb_id { position:absolute; margin:18px 0 0 7px; padding:3px 0 0 2px; border:1px solid #d3d3d3; width:155px; height:22px; }
#mw-outlogin .login-mb_id { font-size:8pt; color:#7dacd8; ime-mode:disabled; }
#mw-outlogin .login-mb_password { position:absolute; margin:43px 0 0 7px; padding:3px 0 0 2px; border:1px solid #d3d3d3; }
#mw-outlogin .login-mb_password { width:100px; height:22px; font-size:8pt; color:#7dacd8; }
#mw-outlogin .login-button { position:absolute; margin:43px 0 0 110px; }

#mw-outlogin .login-div { position:absolute; margin:19px 0 0 175px; }
#mw-outlogin .login-intro { position:absolute; margin:20px 0 0 184px; }
#mw-outlogin .login-intro_1 { position:absolute; margin:40px 0 0 187px; }
#mw-outlogin .login-intro_2 { position:absolute; margin:40px 0 0 206px; }
#mw-outlogin .login-intro_3 { position:absolute; margin:40px 0 0 224px; }
#mw-outlogin .login-IP { position:absolute; margin:70px 0 0 185px; }

#mw-outlogin .login-auto { position:absolute; margin:19px 0 0 115px; font-size:8pt; color:#878787; }
#mw-outlogin .login-membership { position:absolute; margin:70px 0 0 10px; padding:3px 0 0 8px; border-top:1px; }
#mw-outlogin .login-membership { text-align:center; font-size:9pt; color:#d0e1f1; }
#mw-outlogin .login-membership a { color:#7dacd8; font-size:8pt; text-decoration:none; }

#mw-outlogin .login-1 { position:absolute; margin:40px 0 0 240px; }
#mw-outlogin .login-2 { position:absolute; margin:40px 0 0 259px; }
#mw-outlogin .login-3 { position:absolute; margin:40px 0 0 278px; }

#mw-outlogin .box-outside { background-color:#e2e2e2; }
#mw-outlogin .box-inside { background-color:#f3f4f3; color:#6b7bb3; }
#mw-outlogin .login-mb_id { border:1px solid #d1d1d1; color:#e2e2e2; }
#mw-outlogin .login-mb_password { border:1px solid #d1d1d1; color:#e2e2e2; }
#mw-outlogin .login-membership { color:#4a4a4a; }
#mw-outlogin .login-membership a { color:#4a4a4a; }

</style>

