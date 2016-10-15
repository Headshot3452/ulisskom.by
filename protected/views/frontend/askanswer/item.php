<div class="ask-answer">
    <div class="container">
        <div class='row'>
            <div class="col-md-8 one-ask">
                <div class="row">
                    <h1 class="ask col-md-12">
                        <?php echo $model->title ?>
                    </h1>

                    <div class="col-md-12">
                        <?php
                        echo CHtml::link('<span class="fa fa-long-arrow-left"></span> Назад к вопросам', $this->createUrl('askanswer/index'), array('class' => 'btn btn-default pull-left'));
                        echo "<span class='ask-id pull-right'>#" . $model->id . "</span>";
                        ?>

                    </div>

                    <div class="answer col-md-12">
                        <?php
                            echo $model->text;
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4 side-bar">
                <?php $this->renderPartial('_side_bar') ?>
            </div>
        </div>
    </div>
</div>