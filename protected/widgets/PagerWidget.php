<?php

Yii::import('bootstrap.widgets.BsPager');

class PagerWidget extends BsPager
{
    protected function createPageLinks()
    {
        if ($this->nextPageLabel === null) {
            $this->nextPageLabel = Yii::t('yii', '&gt;');
        }

        if ($this->prevPageLabel === null) {
            $this->prevPageLabel = Yii::t('yii', '&lt;');
        }

        if ($this->firstPageLabel === null) {
            $this->firstPageLabel = Yii::t('yii', '&lt;&lt;');
        }

        if ($this->lastPageLabel === null) {
            $this->lastPageLabel = Yii::t('yii', '&gt;&gt;');
        }

        if ($this->activeLabelSrOnly === null) {
            $this->activeLabelSrOnly = Yii::t('yii', '(current)');
        }

        if (($pageCount = $this->getPageCount()) <= 1) {
            return array();
        }

        list($beginPage, $endPage) = $this->getPageRange();

        $currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $links = array();

// prev page
        if (($page = $currentPage - 1) < 0) {
            $page = 0;
        }
        $links[] = $this->createPageLink($this->prevPageLabel, $page, $currentPage <= 0, false);

// first page
        if ((!$this->hideFirstAndLast and ($pageCount > $this->maxButtonCount)) and ($currentPage >= $this->maxButtonCount-2)) {
            $links[] = $this->createPageLink($this->firstPageLabel, 0, $currentPage <= 0, false);
            $links[] = array('label' => ' ... ',);
        }


// internal pages
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $links[] = $this->createPageLink($i + 1, $i, false, $i == $currentPage);
        }

// last page
        if ((!$this->hideFirstAndLast and ($pageCount > $this->maxButtonCount)) and ($currentPage <= $pageCount-$this->maxButtonCount+1)) {
            $links[] = array('label' => ' ... ',);
            $links[] = $this->createPageLink(
                $this->lastPageLabel,
                $pageCount - 1,
                $currentPage >= $pageCount - 1,
                false
            );
        }

// next page
        if (($page = $currentPage + 1) >= $pageCount - 1) {
            $page = $pageCount - 1;
        }

        $links[] = $this->createPageLink($this->nextPageLabel, $page, $currentPage >= $pageCount - 1, false);

        return $links;
    }
}