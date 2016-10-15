<?php

class ReviewSettingsUpdateAction extends BackendAction
{
    public function run()
    {
        $language = $this->controller->getCurrentLanguage();
        $language_id = $language->id;
        $model = new ReviewSetting();
        $criteria = new CDbCriteria();
        $criteria->select = 'MAX(`sort`) as `sort`';
        $sort = $model->find($criteria);
        $sort = $sort->sort + 1;
        $items=$model->findAll();
        foreach ($items as $item)
        {
            if(isset($_POST['checkbox'][$item->id]))
                $item->status = $_POST['checkbox'][$item->id];
            else
                $item->status = 0;
            $item->save();
        }
        Yii::app()->user->setFlash('modal', Yii::t('app','Settings have been saved'));
        $this->redirect($this->controller->createUrl('settings'));


//        $this->render(array('model'=>$model));
    }

}