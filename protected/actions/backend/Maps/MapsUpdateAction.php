<?php
class MapsUpdateAction extends BackendAction
{
    public function run()
    {
        $model = $this->getModel();

        $setBreadcrumb=true;

        if ($model->getIsNewRecord())
        {
            $title = Yii::t('app','Create page (module)');
        }
        else
        {
            $title = Yii::t('app','Editing pages').' '.$model->title;
        }

        if ($setBreadcrumb)
        {
            $this->controller->setLastBreadcrumb($title);
        }

        $this->controller->setPageTitle($title);

        $this->controller->pageTitleBlock=BackendHelper::htmlTitleBlockDefault(CHtml::link(CHtml::image('/images/icon-admin/contacts.png'), $this->controller->createUrl('admin/siteManagement')).$this->controller->getModuleName(),$this->controller->createUrl('admin/siteManagement'));

        if (!$model->isNewRecord)
        {
            $this->controller->addButtonsLeftMenu('active', array(
                'url'=>$this->controller->createUrl('active',array('id'=>$model->id)),
                'active'=>($model->status==$model::STATUS_OK) ? true : false)
            );
            $this->controller->addButtonsLeftMenu('delete',array(
                'url'=>$this->controller->createUrl('delete',array('id'=>$model->id))
                )
            );

            $this->controller->pageTitleBlock.='<a href="'.$this->controller->createUrl('setting', array('id'=>$model->id)).'" class="btn btn-default btn-setting-maps"><i class="fa fa-cog"></i>
            </a>';
        }

        if(isset($_POST['group']['center']))
        {
            foreach ($_POST['group']['center'] as $key => $value)
            {
                $model_group = new MapsPlacemarkGroup();
                $item = $model_group->findByPk($key);

                if(!empty($item->id))
                {
                    $item->center = $value;
                    $item->zoom = $_POST['group']['zoom'][$key];
                    $item->save();
                }
            }
        }

        if(isset($_POST[$this->modelName]))
        {
            $placemarks=array();

            if (!empty($model->mapsPlacemarks))
            {
                $placemarks=array_combine(CHtml::listData($model->mapsPlacemarks,'id','id'),$model->mapsPlacemarks);
            }

            $save=array();

            if (!empty($_POST['placemark']))
            {
                foreach($_POST['placemark'] as $item)
                {
                    $id=$item['id'];
                    
                    if (isset($placemarks[$id]))
                    {
                        $placemarks[$id]->attributes=$item;
                        $placemarks[$id]->iconContent=addslashes($item['iconContent']);
                        $placemarks[$id]->hintContent=addslashes($item['iconContent']);

                        $save[]=$placemarks[$id];
                        unset($placemarks[$id]);
                    }
                    else
                    {
                        $new=$model->getInstanceRelation('mapsPlacemarks');
                        $new->attributes=$item;
                        $new->iconContent=addslashes($item['iconContent']);
                        $placemarks[$id]->hintContent=addslashes($item['iconContent']);

                        $save[]=$new;
                    }
                }
            }

            foreach($placemarks as $del)
            {
                $del->delete();
            }

            $model->mapsPlacemarks=$save;


            $model->attributes = $_POST[$this->modelName];
            if ($model->validate())
            {
                $model->save(false);
                if ($this->scenario=='insert')
                {
                    $this->redirect();
                }
                else
                {
                    Yii::app()->user->setFlash('success', Yii::t('app','Saved'));
                    $this->refresh();
                }
            }
        }

        $this->render(array('model' => $model));
    }
}
?>
