<?php
    /* @var $this StructureController */
    /* @var $model Structure */

    $this->widget('bootstrap.widgets.TbListView',
        array(
            'dataProvider'       => $model->language($this->getCurrentLanguage()->id)->search(),
            'id'                 => 'users-list',
            'itemView'           => '_item',
            'ajaxUpdate'         => false,
            'emptyText'          => 'В данной категории нет товаров.',
            'summaryText'        => "{start}&mdash;{end} из {count}",
            'template'           => '{summary} {sorter} {items} <hr> {pager}',
            'sorterHeader'       => 'Сортировать по:',
            'sortableAttributes' => array('login', 'email'),
            'pager' => array(
            'class'              => 'CLinkPager',
                'header'         => false,
                'cssFile'        => '/css/pager.css',
                'htmlOptions'    => array('class' => 'pager'),
            ),
        )
    );

