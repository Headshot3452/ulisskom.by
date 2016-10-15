<?php
    class UsersController extends ModuleController
    {
        public function init()
        {
            parent::init();

            $this->addButtonsLeftMenu('create',
                array(
                    'url' => $this->createUrl('create')
                )
            );
        }

        public static function getModuleName()
        {
            return Yii::t('app', 'Users');
        }

        public function actions()
        {
            return CMap::mergeArray(
                parent::actions(),
                array(
                    'update' => 'actionsBackend.Users.UsersUpdateAction',
                    'status_products' => array(
                        'class' => 'actionsBackend.Tree.StatusAction',
                        'Model' => 'Users',
                    ),
                )
            );
        }

        public function getLeftMenu()
        {
            return array(
                array('label' => Yii::t('app', 'Create'), 'url' => $this->createUrl('create')),
            );
        }
    }