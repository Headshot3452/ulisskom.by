<?php
/* @var $this UsersController */
/* @var $model Users */
?>
<?php //$this->widget('bootstrap.widgets.TbListView', array(
//    'dataProvider'=>$model->search(),
//    'id'=>'users-list',
//    'itemView'=>'_item',
//    'ajaxUpdate'=>false,
//    'emptyText'=>'В данной категории нет товаров.',
//    'summaryText'=>"{start}&mdash;{end} из {count}",
//    'template'=>'{summary} {sorter} {items} <hr> {pager}',
//    'sorterHeader'=>'Сортировать по:',
//    'sortableAttributes'=>array('login', 'email'),
//    'pager'=>array(
//        'class'=>'CLinkPager',
//        'header'=>false,
//        'cssFile'=>'/css/pager.css', // устанавливаем свой .css файл
//        'htmlOptions'=>array('class'=>'pager'),
//    ),
//)); ?>

<?php
    $this->renderPartial('_listGrid',array('model'=>$model))
?>
