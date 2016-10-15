<?php
$category_id = isset($_GET['category_id'])?$_GET['category_id']:'0';

$category = isset($_GET['category_id'])?'&category_id='.$_GET['category_id']:'';
$prev = !empty($prev_tree)?'&prev='.$prev_tree->id:'&prev=';
?>

<!-- Modal -->
<div class="modal fade" id="allLabels" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Алфавитный указатель меток</h4>
            </div>
            <div class="modal-body row">
                <div class="col-md-12 letter border-bottom">
                    <a href="#">#</a>
                    <?php
                        foreach(range(chr(0xC0), chr(0xDF)) as $value)
                        {
                            echo '<a href="#">'.iconv('CP1251', 'UTF-8', $value).'</a>';
                        }
                    ?>
                    <br>
                    <a href="#">#</a>
                    <?php
                        foreach(range('A', 'Z') as $value)
                        {
                            echo '<a href="#">'.$value.'</a>';
                        }
                    ?>
                </div>
                <div class="col-md-12">
                    <h3>Все метки</h3>
                    <div class="labels row">
                        <?php
                            foreach(Tags::getAllTags($category_id, $this->module_id) as $value)
                            {
                                echo '<a href="'.$this->createUrl('blog/index').'?tag_id='.$value->id.$category.$prev.'">'.$value->title.'</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
            </div>
        </div>
    </div>
</div>

<?php
$cs = Yii::app()->getClientScript();

$tags_modal = "
        $('#allLabels .letter a').on('click', function(){
            var value = $(this).text();
            var prev = '".$prev."';
            var category = '".$category."';
            var category_id = '".$category_id."';

            $('#allLabels .modal-body h3').text('Метки на букву: '+ value);

            $.ajax({
                type: 'POST',
                url: '".$this->createUrl('blog/index')."',
                data: {
                    title:value,
                    category:category,
                    prev:prev,
                    category_id:category_id
                },
                success: function(data){
                    $('#allLabels .labels').html(data);
                }
            });

            return false;
        });
    ";

$cs->registerPackage('jquery')->registerScript('tags_modal', $tags_modal);
?>