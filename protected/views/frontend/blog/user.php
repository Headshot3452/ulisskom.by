<?php
$cs = Yii::app()->getClientScript();
$src = '
        $(".settings input[type=checkbox]").change(function () {
            var label=$("label[for="+$(this).attr("id")+"]").text();
            var user_id = $(this).val();
            var type;

            if ($(this).prop("checked"))
            {
                $("label[for="+$(this).attr("id")+"]").text("Читаю");
                type = "create";
            }
            else
            {
                $("label[for="+$(this).attr("id")+"]").text("Читать");
                type = "remove";
            }
            $.ajax({
                type: "POST",
                data: {user_id:user_id, type:type},
                success:function(){
                }
            });
        });

        $(".pagination li a").on("click", function(){
            $("body,html").animate({scrollTop:0});
        });
';
$cs->registerScript('checks', $src);
?>
<div class="user blog">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row user-info">
                    <div class="col-md-3 avatar">
                        <?php
                            $images = $model->getOneFile('original');

                            if(!empty($images))
                            {
                                echo CHtml::image('/'.$images, $model->login);
                            }
                            else
                                echo CHtml::image('/'.Yii::app()->params['noavatar'], $model->login);
                        ?>
                    </div>
                    <div class="col-md-9 info">
                        <h1 class="login">
                            <?php echo $model->user_info->nickname; ?>
                        </h1>

                        <h3 class="fullname">
                            <?php echo $model->user_info->getFullName(); ?>
                        </h3>

                        <div class="time">
                            <?php echo Users::getUserTimeOnSite($model->id); ?> на сайте
                        </div>

                        <?php if($model->id != Yii::app()->user->id): ?>
                        <div class="settings text-uppercase">
                            <input type="checkbox" value="<?php echo $model->id; ?>" class="checkbox" id="checkbox_name" <?php echo (Followers::getCountFollowersForUser($model->id)>0)?'checked':''; ?>/>
                            <label for="checkbox_name">Читать</label>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row tabs">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs text-uppercase">
                            <li class="active">
                                <a href="#posts" data-toggle="tab">Посты
                                    <span class="badge pull-right">
                                        <?php echo Blog::model()->count('user_id=:user_id AND status=:status',
                                            array(':user_id'=>$model->id, ':status'=>Blog::STATUS_PLACEMENT)); ?>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#readership" data-toggle="tab">Читатели
                                    <span class="badge pull-right">
                                        <?php echo Followers::model()->count('user_id=:user_id', array(':user_id'=>$model->id)); ?>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#comments" data-toggle="tab">Комментарии
                                    <span class="badge pull-right">
                                        <?php echo Comments::model()->count('user_id=:user_id AND status=:status',
                                            array(':user_id'=>$model->id, ':status'=>Comments::STATUS_PLACEMENT)); ?>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="posts">
                                <div class="posts">
                                    <?php
                                    $category = '';
                                    $prev = '';

                                    $this->widget('bootstrap.widgets.BsListView',array(
                                        'dataProvider'=>$dataProvider,
                                        'itemView'=>'_one-post',
                                        'viewData'=>array('category'=>$category, 'prev'=>$prev),
                                        'ajaxUpdate'=>true,
                                        'emptyText'=>'<h5>Пока нет ни одного поста.</h5>',
                                        'template'=>'{items}<div class=\"row text-center\">{pager}</div>',
                                        'pager' => array(
                                            'class' => 'bootstrap.widgets.BsPager',
                                            'firstPageLabel' => '<<',
                                            'prevPageLabel' => '<i class="fa fa-angle-left fa-lg"></i>',
                                            'nextPageLabel' => '<i class="fa fa-angle-right fa-lg"></i>',
                                            'lastPageLabel' => '>>',
                                            'hideFirstAndLast'=>true,
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="tab-pane" id="readership">
                                <div class="readerships">
                                    <?php
                                    $this->widget('bootstrap.widgets.BsListView',array(
                                        'dataProvider'=>$data_reader,
                                        'itemView'=>'_one-readership',
                                        'ajaxUpdate'=>true,
                                        'emptyText'=>'<h5>Пока нет ни одного читателя.</h5>',
                                        'template'=>'{items}<div class=\"row text-center\">{pager}</div>',
                                        'pager' => array(
                                            'class' => 'bootstrap.widgets.BsPager',
                                            'firstPageLabel' => '<<',
                                            'prevPageLabel' => '<i class="fa fa-angle-left fa-lg"></i>',
                                            'nextPageLabel' => '<i class="fa fa-angle-right fa-lg"></i>',
                                            'lastPageLabel' => '>>',
                                            'hideFirstAndLast'=>true,
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="tab-pane" id="comments">
                                <div class="comm">
                                    <?php
                                    $this->widget('bootstrap.widgets.BsListView',array(
                                        'dataProvider'=>$data_comments,
                                        'itemView'=>'_one-comment',
                                        'ajaxUpdate'=>true,
                                        'emptyText'=>'<h5>Пока нет ни одного комментария.</h5>',
                                        'template'=>'{items}<div class=\"row text-center\">{pager}</div>',
                                        'pager' => array(
                                            'class' => 'bootstrap.widgets.BsPager',
                                            'firstPageLabel' => '<<',
                                            'prevPageLabel' => '<i class="fa fa-angle-left fa-lg"></i>',
                                            'nextPageLabel' => '<i class="fa fa-angle-right fa-lg"></i>',
                                            'lastPageLabel' => '>>',
                                            'hideFirstAndLast'=>true,
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 side-bar">
                <div class="col-md-12 widget">
                    <div class="title row border-bottom">
                        <div class="caption cat-categories">Популярные метки</div>
                    </div>
                    <div class="row body labels border-bottom">
                        <?php
                            $category_id = isset($_GET['category_id'])?$_GET['category_id']:'0';

                            $category = isset($_GET['category_id'])?'&category_id='.$_GET['category_id']:'';
                            $prev = isset($_GET['prev'])?'&prev='.$_GET['prev']:'&prev=';

                            foreach(Tags::getPopularTags($category_id, $this->module_id, 10) as $value)
                            {
                                echo '<a href="'.$this->createUrl('blog/index').'?tag_id='.$value->id.$category.$prev.'">'.$value->title.'</a>';
                            }
                        ?>
                    </div>
                    <div class="footer">
                        <a href="#" data-toggle="modal" data-target="#allLabels">Все метки</a>
                    </div>
                </div>
                <?php $this->renderPartial('_modal_labels') ?>
            </div>
        </div>
    </div>
</div>

<?php echo $this->renderPartial('_modal_complaint_comment', array('complaint'=>new Complaints())); ?>

<?php echo $this->renderPartial('_posts_script'); ?>
<?php echo $this->renderPartial('_comments_script'); ?>

<?php echo $this->renderPartial('_modal_send', array('text'=>'Ваша жалоба отправлена.', 'id'=>'modal_complaint')); ?>