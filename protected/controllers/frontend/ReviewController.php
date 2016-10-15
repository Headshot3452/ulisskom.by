<?php

class ReviewController extends FrontendController
{
    public $root_id;

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'padding' => 1,
                'backColor' => 0xFFFFFF,
                'maxLength' => 4,
                'minLength' => 4,
                'foreColor' => 0x727272,
                'width' => '98',
                'height' => '38',
            ),
        );
    }

    public function init()
    {
        parent::init();
        $this->root_id = 1;
    }

    public function actionIndex()
    {
        $setting = ReviewSetting::model()->findAll(array('select' => 'id, status'));
        $pagesize = 6;
        $this->setPageForUrl(Yii::app()->getRequest()->getPathInfo());
        $dataProvider = ReviewItem::model()->getReviewProvider($pagesize, '', '', ReviewItem::STATUS_PLACEMENT);

        $this->render('index', array('model' => $dataProvider, 'count' => $pagesize, 'setting' => $setting,));
    }

    public function actionAdd()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $setting = ReviewSetting::model()->findAll(array('select'=>'id, status'));
            $review = new ReviewItem();
            if (isset($_POST['ReviewItem'])) {
                $review->attributes = $_POST['ReviewItem'];
                if ($review->validate()) {
                    if ($setting[1]->status == 1) {
                        $review->status = ReviewItem::STATUS_PLACEMENT;
                    } else {
                        $review->status = ReviewItem::STATUS_NEW;
                    }
                    if (!Yii::app()->user->isGuest) {
                        $user = Users::model()->findByPk(Yii::app()->user->id);
                        $review->user_id = $user->id;
                        $review->email = $user->email;
                        $review->phone = isset($user->user_info) ? $user->user_info->phone : '';
                        $review->fullname = isset($user->user_info) ? $user->user_info->getFullName() : 'Администратор';
                    }
                    $review->save();
                    echo $review->validate();
                }
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(404, 'Указанная запись не найдена');
        }
    }

    public function actionList()
    {

    }
}