<?php
class MapsController extends ModuleController
{
    public $layout_in='backend_left_menu';

    public function init()
    {
        parent::init();

        $this->addButtonsLeftMenu('create', array(
                'url'=>$this->createUrl('create')
            )
        );
    }

    public static function getModuleName()
    {
        return Yii::t('app','Maps');
    }

   public function actions()
   {
       return array_merge(
                parent::actions(),
                array(
                    'create'=>array(
                        'class'=>'actionsBackend.Maps.MapsUpdateAction',
                        'scenario'=>'insert',
                    ),
                    'update'=>array(
                        'class'=>'actionsBackend.Maps.MapsUpdateAction',
                        'scenario'=>'update',
                    ),
                    'active'=>array(
                        'class'=>'actionsBackend.ActiveAction',
                        'scenario'=>'update',
                    ),
                    'settings_group'=>array(
                        'class'=>'actionsBackend.Maps.SettingMapsUpdateAction',
                        'scenario'=>'update',
                        'Model'=>'MapsPlacemarkGroup',
                    ),
                    'params_sort'=> array(
                        'class'=>'actionsBackend.Maps.SortAction',
                        'Model'=>'MapsPlacemarkGroup',
                    ),
                )
       );
   }

   public function actionIndex()
   {
        $this->redirect($this->createUrl('create'));
   }

   public function actionSetting($id)
   {
        $model = new MapsPlacemarkGroup();

        $criteria = new CDbCriteria();
        $criteria->compare('maps_id', $id);
        $criteria->order = 'sort ASC';

        $data = $model::model()->active()->findAll($criteria);

        $this->pageTitleBlock=BackendHelper::htmlTitleBlockDefault(CHtml::link(CHtml::image('/images/icon-admin/contacts.png'), '/admin/maps/update/?id='.$id).$this->getModuleName(),'/admin/maps/update/?id='.$id);

        $this->render('settings', array('model'=>$model, 'data'=>$data));
   }

    public function getLeftMenu()
    {
        $maps = Maps::getAllForMenu();
        $menu = array();
        foreach($maps as $val)
        {
            $menu[]=array(
                'label'=>$val->title,
                'url'=>$this->createUrl('update',array('id'=>$val->id)),
                'active'=>(isset($_GET['id']) && $_GET['id'] == $val->id ? 1 : 0),
                'itemOptions' => array('class' => ($val->status==2)?'disable maps':'maps')
            );

        }
        return $menu;
    }

    public static function getActionsConfig()
    {
        return array(
            'create' => array('label' => 'Редактирование группы', 'parent'=>'main_modules'),
            'update' => array('label' => 'Редактирование группы', 'parent'=>'main_modules'),
            'setting' => array('label' => 'Редактирование группы', 'parent'=>'main_modules'),
        );
    }
}