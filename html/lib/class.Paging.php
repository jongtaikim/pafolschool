<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: lib/class.Paging.php
* �ۼ���: 2005-05-12
* �ۼ���: ��ģ����
* ��  ��: �������� ��� Ŭ����
*****************************************************************
* lib.paging.js �� �������̵忡�� �������ϵ��� ����
*/
require_once "class.WebAppURL.php";

class Paging
{
    var $config;
    var $totalItem;
    var $qs;

    function Paging($total=1,$qs='')
    {
        $this->config = array(
            'pageVariable'   => 'page',
            'numberFormat'   => '[%n]',
            'showFirstLast'  => true,   // ��ó��, �� ���������� ���� ��ũ�� ������ΰ�.
            'thisPageStyle'  => 'font-weight: bold;',
            'otherPageStyle' => '',
            'itemPerPage'    => 10, // ����Ʈ ��ϼ�
            'pagePerView'    => 10, // �������� �׺���̼� �׸��
            'prevIcon'       => null,   // ���������� ������
            'nextIcon'       => null,   // ���������� ������
            'firstIcon'      => null,   // ù�������� ������
            'lastIcon'       => null    // ������������ ������
        );

        $this->qs = new WebAppURL($qs);
        $this->totalItem = $total;
        $this->currentPage = $this->qs->vars[$this->config['pageVariable']];
    }

    function setConf($key,$val='')
    {
        if (is_array($key)) $this->config = array_merge($this->config,$key);
        else $this->config[$key] = $val;
    }

    function setTotal($total) {
        $this->totalItem = $total;
    }

    function output() {
        echo $this->__toString();
    }

    function calculate ()
    {
        $this->totalPage = max(ceil($this->totalItem / $this->config['itemPerPage']),1);
        $this->currentPage = $this->qs->vars[$this->config['pageVariable']];
        if (!$this->currentPage) $this->currentPage = 1;
        if ($this->currentPage > $this->totalPage) $this->currentPage = $this->totalPage;
        $this->lastPageItems = $this->totalPage % $this->config['itemPerPage'];

        $this->prevPage = $this->currentPage - 1;
        $this->nextPage = $this->currentPage + 1;
        $this->seek = $this->prevPage * $this->config['itemPerPage'];
        $this->currentScale = intval($this->currentPage / $this->config['pagePerView']);
        if ($this->currentPage % $this->config['pagePerView'] < 1) $this->currentScale--;
        $this->totalScale = intval($this->totalPage / $this->config['pagePerView']);
        $this->lastScalePages = $this->totalPage % $this->config['pagePerView'];
        if ($this->lastScalePages == 0) $this->totalScale--;
        $this->prevPage = $this->currentScale * $this->config['pagePerView'];
        $this->nextPage = $this->prevPage + $this->config['pagePerView'] + 1;
    }

    function getOffset() {
        return ($this->config['itemPerPage'] * ($this->currentPage - 1));
    }

    function __toString()
    {
        $this->calculate();
        if ($this->config['showFirstLast']) {
            if ($this->config['firstIcon'])
                $firstBtn = '<img src="'.$this->config['firstIcon'].'" border="0" align="absmiddle">';
            else
                $firstBtn = '[ó��]';
            $firstBtn = $this->_link($firstBtn, $this->qs->setVar($this->config['pageVariable'],1));

            if ($this->config['lastIcon'])
                $lastBtn = '<img src="'.$this->config['lastIcon'].'" border="0" align="absmiddle">';
            else
                $lastBtn = '[������]';
            $lastBtn = $this->_link($lastBtn, $this->qs->setVar($this->config['pageVariable'],$this->totalPage));
        } else {
            $firstBtn = $lastBtn = '';
        }

        if ($this->config['prevIcon'])
            $prevBtn ='<img src="'.$this->config['prevIcon'].'" border="0" align="absmiddle">';
        else
            $prevBtn = '��';
        if ($this->currentPage > $this->config['pagePerView'])
            $prevBtn = $this->_link($prevBtn, $this->qs->setVar($this->config['pageVariable'],$this->prevPage));

        $ss = $this->prevPage + 1;
        if (($this->currentScale >= $this->totalScale) && ($this->lastScalePages != 0))
            $se = $ss + $this->lastScalePages;
        else if ($this->currentScale <= -1)
            $se = $ss;
        else
            $se = $ss + $this->config['pagePerView'];

        $navBtn = '';
        for ($i = $ss; $i<$se; $i++) {
            $pageText = str_replace('%n', $i, $this->config['numberFormat']);
            if ($i == $this->currentPage) {
                $_btn = '<span style="'.$this->config['thisPageStyle'].'">'.$pageText.'</span>';
            } else {
                $_btn = '<a href="'.$this->qs->setVar($this->config['pageVariable'],$i).'" style="'.$this->config['otherPageStyle'].'">'.$pageText.'</a>';
            }
            $navBtn.= $_btn;
        }

        if ($this->config['prevIcon'])
            $nextBtn ='<img src="'.$this->config['nextIcon'].'" border="0" align="absmiddle">';
        else
            $nextBtn = '��';
        if ($this->totalPage > $this->nextPage)
            $nextBtn = $this->_link($nextBtn ,$this->qs->setVar($this->config['pageVariable'],$this->nextPage));

        return $firstBtn.' '.$prevBtn.$navBtn.$nextBtn.' '.$lastBtn;
    }

    function _link($text,$href)
    {
        return '<a href="'.$href.'" class="nav">'.$text.'</a>';
    }
}
?>
