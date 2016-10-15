<?php
class GalleryController extends ModuleController
{
    public $layout_in = 'backend_left_tree_with_buttons';

    private $_active_gallery_id = null;
    private $_active_gallery = null;

    public $active_gallery = null;


    public function init()
    {
        parent::init();

        $this->addButtonsLeftMenu('create', array(
                'url'=>$this->createUrl('create_gallery').'?parent='.$this->_active_gallery_id
            )
        );

        $this->pageTitleBlock = BackendHelper::htmlTitleBlockDefault('', $this->createUrl('admin/siteManagement'));
        $this->pageTitleBlock .=
                            '<div class="img-cont">
                                <a href="'.$this->createUrl("admin/siteManagement").'">
                                    <img src="/images/icon-admin/gallery.png" alt="" title="">
                                </a>
                            </div>';
        $this->pageTitleBlock .= '<span class="pull-left title">Фотогалерея</span>';
    }

    public static function getModuleName()
    {
        return Yii::t('app','Gallery');
    }

    public function filters()
    {
        return array_merge(
            parent::filters(),
            array('ajaxOnly + treeUpdate, search')
        );
    }

    public function actions()
    {
        return array(
            'create_gallery'=>array(
                'class'=>'actionsBackend.Nested.NestedMultiRootWithMaxLevelUpdateAction',
                'Model'=>'GalleryTree',
                'scenario'=>'insert',
                'View'=>'gallery'
            ),
            'update_gallery'=>array(
                'class'=>'actionsBackend.Nested.NestedMultiRootUpdateAction',
                'Model'=>'GalleryTree',
                'scenario'=>'update',
                'View'=>'gallery'
            ),
            'delete_category'=>array(
                'class'=>'actionsBackend.Nested.NestedDeleteAction',
                'Model'=>'GalleryTree',
                'scenario'=>'update',
            ),
            'up_category'=>array(
                'class'=>'actionsBackend.Nested.NestedUpAction',
                'Model'=>'GalleryTree',
            ),
            'down_category'=>array(
                'class'=>'actionsBackend.Nested.NestedDownAction',
                'Model'=>'GalleryTree',
            ),
            'tree_update'=>array(
                'class'=>'actionsBackend.Nested.NestedMoveTreeAction',
                'Model'=>'GalleryTree',
            ),
            'tree_status'=>array(
                'class'=>'actionsBackend.Nested.NestedActiveAction',
                'Model'=>'GalleryTree',
            ),
            'upload' => 'actionsBackend.UploadAction',
            'create_product'=>array(
                'class'=>'actionsBackend.Gallery.GalleryImagesUpdateAction',
                'scenario'=>'insert',
                'Model'=>'GalleryImages',
                'View'=>'image'
            ),
            'update_product'=>array(
                'class'=>'actionsBackend.Gallery.GalleryImagesUpdateAction',
                'scenario'=>'update',
                'Model'=>'GalleryImages',
                'View'=>'image'
            ),
            'delete_product' => array(
                'class'=>'actionsBackend.DeleteAction',
                'Model'=>'GalleryImages',
            ),
            'settings'=>array('class'=>'actionsBackend.SettingsAction'),
            'products_sort'=> array(
                'class'=>'actionsBackend.Tree.SortAction',
                'Model'=>'GalleryImages',
            ),
            'copy_product'=> array(
                'class'=>'actionsBackend.Tree.CopyMoveAction',
                'Model'=>'GalleryImages',
            ),
            'status_products'=> array(
                'class'=>'actionsBackend.Tree.StatusAction',
                'Model'=>'GalleryImages',
            ),
            'active'=> array(
                'class'=>'actionsBackend.ActiveAction',
                'Model'=>'GalleryImages',
            ),
        );
    }

    public function actionIndex()
    {
        $category_id=1;
        $this->_active_gallery_id = $category_id;

        if(! $this->_active_gallery_id || !($this->_active_gallery = GalleryTree::model()->findByPk( $this->_active_gallery_id)))
            throw new CHttpException('404');
        $this->addButtonsLeftMenu('create', array(
                'url'=>$this->createUrl('create_gallery').'?parent='.$this->_active_gallery_id
            )
        );

        if($this->_active_gallery_id)
        {
            $this->addButtonsLeftMenu('update', array(
                    'url'=>$this->createUrl('update_gallery').'?id='.$this->_active_gallery_id
                )
            );
            $this->addButtonsLeftMenu('delete', array(
                    'url'=>$this->createUrl('delete_category').'?id='.$this->_active_gallery_id
                )
            );
            $this->addButtonsLeftMenu('active', array(
                    'url'=>$this->createUrl('tree_status').'?id='.$this->_active_gallery_id,
                    'active'=>(GalleryTree::model()->findByPk( $this->_active_gallery_id)->status == GalleryTree::STATUS_OK) ? true : false,
                )
            );
        }
        $count = (!empty($_COOKIE['count'])) ? $_COOKIE['count'] : 20;
        $this->render('gallery_images',
            array(
                'model'=>GalleryImages::model()->notDeleted()->getAll(),
                'category_id'=>$category_id,
                'count'=>$count,
            ));
    }


    public function actionProducts($category_id)
    {
        $this->_active_gallery_id = $category_id;

        if(! $this->_active_gallery_id || !($this->_active_gallery = GalleryTree::model()->findByPk( $this->_active_gallery_id)))
            throw new CHttpException('404');
        $this->addButtonsLeftMenu('create', array(
                'url'=>$this->createUrl('create_gallery').'?parent='.$this->_active_gallery_id
            )
        );

        if($this->_active_gallery_id)
        {
            $this->addButtonsLeftMenu('update', array(
                    'url'=>$this->createUrl('update_gallery').'?id='.$this->_active_gallery_id
                )
            );
            $this->addButtonsLeftMenu('delete', array(
                    'url'=>$this->createUrl('delete_category').'?id='.$this->_active_gallery_id
                )
            );
            $this->addButtonsLeftMenu('active', array(
                    'url'=>$this->createUrl('tree_status').'?id='.$this->_active_gallery_id,
                    'active'=>(GalleryTree::model()->findByPk( $this->_active_gallery_id)->status == GalleryTree::STATUS_OK) ? true : false,
                )
            );
        }

        $count = (!empty($_COOKIE['count'])) ? $_COOKIE['count'] : 20;
        $this->render('gallery_images',array('model'=>GalleryImages::model()->notDeleted()->parent($this->_active_gallery_id),'category_id'=>$category_id,'count'=>$count));
    }

    public function actionImages($tree_id)
    {
        $tree=GalleryTree::model()->findByPk($tree_id);

        if ($tree===null)
            throw new CHttpException(404);

        if(isset($_POST['item_file']))
        {
            $images =$_POST['item_file'];

            foreach($images as $img){
                $model = new GalleryImages();
                $model->status = GalleryImages::STATUS_OK;
                $model->author_id = Yii::app()->user->id;
                $model->item_file = array($img);
                $model->parent_id = $tree->id;

                $criteria = new CDbCriteria();
                $criteria->select = 'MAX(`sort`) as `sort`';
                $criteria->condition = '`parent_id`=:parent_id';
                $criteria->params = array(':parent_id' => $model->parent_id);
                $sort = GalleryImages::model()->active()->find($criteria);
                $model->sort = $sort->sort + 1;
               $model->save();
            }
            Yii::app()->user->setFlash('modal', Yii::t('app','Product has been saved'));
            $this->redirect($this->createUrl('products',array('category_id'=>$tree->id)));
        }
        $this->render('load_images',array('model'=>GalleryImages::model()));
    }


    public function getLeftMenu()
    {
        if(!$this->_active_gallery && $this->_active_gallery_id)
        {
            $this->_active_gallery = GalleryTree::model()->findByPk($this->_active_gallery_id);
        }

        $model=new GalleryTree();
        $categories = $model::getAllTree($this->getCurrentLanguage()->id);
        return array_merge(
            array(
                array('text'=>CHtml::link('<img class="root-folder-orange" src="/images/icon-admin/add_folder.png"><span>'.
                    Yii::t('app','Create root category'),array('create_gallery')),'children'=>array())
            ),
            NestedSetHelper::nestedToTreeViewWithOptions($categories,'id',$this->getTreeOptions(),$this->_active_gallery_id)
        );
    }

    public function getTreeOptions()
    {
        return array(
            array('catalog_icon'=>'icon','title'=>'title','url'=>$this->createUrl('products').'?category_id='),
        );
    }

    public static function getActionsConfig()
    {
        return array(
            'index'=>array('label'=>static::getModuleName(),'parent'=>'main_modules'),
            'list'=>array('label'=>Yii::t('app','List'),'parent'=>'index'),
            'view'=>array('label'=>Yii::t('app','View'),'parent'=>'index'),
            'create_gallery'=>array('label'=>Yii::t('app','Create'),'parent'=>'index'),
            'update_gallery'=>array('label'=>Yii::t('app','Gallery'),'parent'=>'index'),
            'treeparams'=>array('label'=>Yii::t('app','Gallery'),'parent'=>'index'),
            'products'=>array('label'=>Yii::t('app','Gallery'),'parent'=>'index'),
            'create_product'=>array('label'=>Yii::t('app','Gallery'),'parent'=>'index'),
            'update_product'=>array('label'=>Yii::t('app','Gallery'),'parent'=>'index'),
            'settings'=>array('label'=>Yii::t('app','Settings'). ' ' .static::getModuleName(),'parent'=>'settings/index'),
        );
    }

    public function getLeftMenuModal()
    {
        if(!$this->_active_gallery && $this->_active_gallery_id)
        {
            $this->_active_gallery = GalleryTree::model()->findByPk($this->_active_gallery_id);
        }

        $model=new GalleryTree();

        $categories = $model::getAllTree($this->getCurrentLanguage()->id);
        return array_merge(
            array(
                array('text'=>CHtml::link('',array('create_gallery')),'children'=>array())
            ),
            NestedSetHelper::nestedToTreeViewWithOptions($categories,'id',$this->getTreeOptionsModal())
        );
    }

    public function getTreeOptionsModal()
    {
        return array(
            array('catalog_icon'=>'icon','title'=>'title','url'=>'', 'data-id'=>'')
        );
    }

    public function setActiveCategoryId($active_category_id)
    {
        $this->_active_gallery_id = $active_category_id;
    }
}
?>