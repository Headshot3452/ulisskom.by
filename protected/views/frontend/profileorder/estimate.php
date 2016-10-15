<div class="estimate order">
    <form>
        <div class="row title-one-order flex-center">
            <div class="col-md-12 flex-center">
                <a class="btn btn-default" href="/profileorder/order"><span class="fa fa-chevron-left"></span></a>

                <h2>Оценка заказа</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row general">
            <h5 class="text-uppercase col-md-12 gray-color"><?php echo Yii::t('app','Overall rating')?></h5>
            <?php
            echo CHtml::radioButtonList('name', 1, array(1 => '<span class="smile fa-stack fa-lg green-color">
                        <span class="fa fa-circle fa-stack-2x"></span>
                        <span class="fa fa-smile-o fa-stack-1x fa-inverse"></span>
                    </span>Положительная', 2 => '<span class="smile fa-stack fa-lg red-color">
                        <span class="fa fa-circle fa-stack-2x"></span>
                        <span class="fa fa-frown-o fa-stack-1x fa-inverse"></span>
                    </span>Негативная', 3 => '<span class="smile fa-stack fa-lg gray-color">
                        <span class="fa fa-circle fa-stack-2x"></span>
                        <span class="fa fa-meh-o fa-stack-1x fa-inverse"></span>
                    </span>Нейтральная'), array('separator' => '', 'container' => 'div', 'template' => '<div class="col-md-3">{input} {label}</div>'));
            ?>
        </div>
        <div class="row optional">
            <h5 class="text-uppercase col-md-12 gray-color"><?php echo Yii::t('app','Additional evaluation')?></h5>

            <div class="col-md-12 rating">
                <?php
                $this->widget('CStarRating', array(
                    'name' => 'rating0',
                    'value' => '1',
                    'minRating' => 1,
                    'maxRating' => 5,
                    'titles' => '1',
                    'cssFile' => '/css/rating/rating.css',
                ));
                ?>
                <span><?php echo Yii::t('app','The speed of order processing')?></span>
            </div>
            <div class="col-md-12 rating">
                <?php
                $this->widget('CStarRating', array(
                    'name' => 'rating1',
                    'value' => '1',
                    'minRating' => 1,
                    'maxRating' => 5,
                    'titles' => '1',
                    'cssFile' => '/css/rating/rating.css',
                ));
                ?>
                <span>Доставка</span>
            </div>
            <div class="col-md-12 rating">
                <?php
                $this->widget('CStarRating', array(
                    'name' => 'rating3',
                    'value' => '1',
                    'minRating' => 1,
                    'maxRating' => 5,
                    'titles' => '1',
                    'cssFile' => '/css/rating/rating.css',
                ));
                ?>
                <span><?php echo Yii::t('app','The politeness of staff')?></span>
            </div>
            <div class="col-md-12 rating">
                <?php
                $this->widget('CStarRating', array(
                    'name' => 'rating4',
                    'value' => '1',
                    'minRating' => 1,
                    'maxRating' => 5,
                    'titles' => '1',
                    'cssFile' => '/css/rating/rating.css',
                ));
                ?>
                <span><?php echo Yii::t('app','Product Quality')?></span>
            </div>
        </div>

        <div class="row optional comment">
            <h5 class="text-uppercase col-md-12 gray-color">Комментарий оценки</h5>

            <div class="col-md-7">
                <label>Ваш комментарий</label>
                <textarea placeholder="Текст комментария" class="form-control" rows="4"></textarea>
            </div>
        </div>
        <div class="row col-md-7 submit-buttons">
            <?php
            echo BsHtml::submitButton(Yii::t('app','Leave assessment'),
                array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'class' => ''));
            echo CHtml::link('Отмена', array('profile/settings'), array('class' => 'cancel_link'));
            ?>
        </div>
    </form>
</div>