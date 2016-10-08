<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/board/table_define.php
* �ۼ���: 2006-05-16
* �ۼ���: �̹���
* ��  ��: DB Table Define
*****************************************************************
* 
*/
$TABLE_NUM = '';
$ARTICLE_TABLE = 'TAB_PARTY_BOARD'.$TABLE_NUM;
$CONFIG_TABLE = $ARTICLE_TABLE.'_CONFIG';
$COMMENT_TABLE = $ARTICLE_TABLE.'_COMMENT';

$ARTICLE_PRIMARY_INDEX = 'PK_'.$ARTICLE_TABLE;
$CONFIG_PRIMARY_INDEX = 'PK_'.$CONFIG_TABLE;
$COMMENT_PRIMARY_INDEX = 'PK_'.$COMMENT_TABLE;
$ARTICLE_SEARCH_INDEX = 'IDX_'.$ARTICLE_TABLE.'_SEARCH';
$ARTICLE_ALL_INDEX = 'IDX_'.$ARTICLE_TABLE.'_ALL';
?>