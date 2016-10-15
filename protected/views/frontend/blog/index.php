<div class="blog">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <?php if(isset($_GET['category_id'])): ?>
                    <h1 class="col-md-12"><?php echo $tree->title; ?></h1>
                    <div class="col-md-12 info-cat">
                        <span>Постов: <?php echo count($dataProvider->getData()); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-12 buttons">
                        <?php
                            $category = isset($_GET['category_id'])?'&category_id='.$_GET['category_id']:'';
                            $prev = isset($_GET['prev'])?'?prev='.$_GET['prev']:'?prev=';
                            $tag = isset($_GET['tag_id'])?'&tag_id='.$_GET['tag_id']:'';
                        ?>
                        <a href="<?php echo $this->createUrl('blog/index').$prev.$category.$tag; ?>" class="<?php echo !isset($_GET['well'])?'btn btn-primary':''; ?>">Все подряд
                            <?php echo (BlogTree::getCountNewPosts(isset($_GET['category_id'])?$_GET['category_id']:0))?'<span class="badge">+'.BlogTree::getCountNewPosts(isset($_GET['category_id'])?$_GET['category_id']:0).'</span>':''; ?>
                        </a>
                        <a href="<?php echo $this->createUrl('blog/index').$prev.$category.$tag.'&well=true'; ?>" class="<?php echo isset($_GET['well'])?'btn btn-primary':''; ?>">Лучшие</a>
                    </div>
                    <div class="col-md-12 posts">
                        <?php
                            $this->renderPartial('posts', array('dataProvider'=>$dataProvider, 'prev_tree'=>$prev_tree));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 side-bar">
                <?php
                    $prev = !empty($_GET['prev'])?$prev_tree->title:'';

                    if(!empty($_GET['prev'])) {
                        $category = ($prev_tree->root != $prev_tree->id) ? '?category_id=' . $_GET['prev'] . '&prev=' . $prev_tree->parent()->find()->id : '?category_id=' . $_GET['prev'];
                    }
                    else
                        $category = '';

                    echo isset($_GET['category_id'])?'<a href="'.$this->createUrl('blog/index').$category.'" class="btn btn-default back"><span class="fa fa-long-arrow-left"></span> Вернуться в Категории '.$prev.'</a>':'';
                ?>
                <?php if(count($tree_menu)>0): ?>
                <div class="col-md-12 widget">
                    <div class="title row">
                        <div class="caption cat-categories">Категории <?php echo isset($_GET['category_id'])?$tree->title:''; ?></div>
                    </div>
                    <div class="row categories-widget">
                        <ul id="yw0" class="nav" role="menu">
                            <?php
                                $prev = isset($_GET['category_id'])?'&prev='.$_GET['category_id']:'&prev=';

                                foreach($tree_menu as $value)
                                {
                                    $count_new = BlogTree::getCountNewPosts($value->id);
                                    $badge = ($count_new>0)?'<span class="badge pull-right">'.$count_new.'</span>':'';

                                    echo '<li><a tabindex="-1" href="' . $this->createUrl('blog/index') . '?category_id=' . $value->id . $prev.'">' . $value->title .$badge.'</a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
                <?php
                    $category_id = isset($_GET['category_id'])?$_GET['category_id']:'0';

                    if(count(Tags::getPopularTags($category_id, $this->module_id, 10))>0):
                ?>
                <div class="col-md-12 widget">
                    <div class="title row border-bottom">
                        <div class="caption cat-categories">Популярные метки</div>
                    </div>
                    <div class="row body labels border-bottom">
                        <?php
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
                <?php endif; ?>
                <?php $this->renderPartial('_modal_labels', array('prev_tree'=>$prev_tree))?>
            </div>
        </div>
    </div>
</div>