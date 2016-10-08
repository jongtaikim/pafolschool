<?
/**
 * Bechu-Basic Skin for Gnuboard4
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

include_once("_common.php");
include_once("$board_skin_path/mw.lib/mw.skin.basic.lib.php");

if (!$is_member)
    alert_close("회원만 이용 가능합니다.");

$path = $comment_image_path;

$dest_file = "$path/$member[mb_id]";

@mkdir($path, 0707);
@chmod($path, 0707);

$indexfile = $path."/index.php";
$f = @fopen($indexfile, "w");
@fwrite($f, "");
@fclose($f);
@chmod($indexfile, 0606);

$file = $_FILES[comment_image];
$size = getImageSize($file[tmp_name]);
$mime = array('image/png', 'image/jpeg', 'image/gif');
$exts = array('png', 'jpg', 'gif');

$ext = substr($file[name], strlen($file[name])-3, 3);

if ($image_del)
    @unlink($dest_file);

if (is_uploaded_file($file[tmp_name])) {
    if (!in_array($size['mime'], $mime))
        alert_close("PNG, GIF, JPG 형식의 이미지 파일만 업로드 가능합니다.");

    if (!in_array($ext, $exts))
        alert_close("PNG, GIF, JPG 형식의 이미지 파일만 업로드 가능합니다.");

    if (!is_dir($path))
        alert_close("$path 디렉토리가 존재하지 않습니다.");

    if (!is_writable($path))
        alert_close("$path 디렉토리의 퍼미션을 707로 변경해주세요.");

    move_uploaded_file($file[tmp_name], $dest_file);

}

alert_close("완료되었습니다.");
?>
