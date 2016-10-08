<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: table_define.php
* 작성일: 2006-02-28
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$TABLE_NUM = '';
$ARTICLE_TABLE = 'TAB_BOARD'.$TABLE_NUM;
$CONFIG_TABLE = $ARTICLE_TABLE.'_CONFIG';
$COMMENT_TABLE = $ARTICLE_TABLE.'_COMMENT';

$ARTICLE_PRIMARY_INDEX = 'PK_'.$ARTICLE_TABLE;
$CONFIG_PRIMARY_INDEX = 'PK_'.$CONFIG_TABLE;
$COMMENT_PRIMARY_INDEX = 'PK_'.$COMMENT_TABLE;
$ARTICLE_SEARCH_INDEX = 'IDX_'.$ARTICLE_TABLE.'_SEARCH';
//$ARTICLE_DEPTH_INDEX = 'IDX_'.$ARTICLE_TABLE.'_DEPTH';
$ARTICLE_ALL_INDEX = 'IDX_'.$ARTICLE_TABLE.'_ALL';
?>