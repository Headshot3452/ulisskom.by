<?php
    /* @var $this MapsController */
    /* @var $model Maps */
    /* @var $form CActiveForm */
?>

<div class="form form-structure">

<?php
    $form = $this->beginWidget('BsActiveForm',
    array(
        'id' => 'maps-index-form',
        'enableAjaxValidation' => false,
        )
    );

    echo $form->errorSummary($model);
?>

    <div class="form-group">
        <div class="label-block"><?php echo $form->labelEx($model, 'title'); ?>:</div>
        <?php echo $form->textField($model, 'title'); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="form-group">
        <div class="label-block"><?php echo $form->labelEx($model,'description'); ?>:</div>
<?php
        $this->widget('application.widgets.ImperaviRedactorWidget',
            array(
                'model' => $model,
                'attribute' => 'description',
                'plugins' => array(
                    'imagemanager' => array(
                        'js' => array('imagemanager.js',),
                    ),
                    'filemanager' => array(
                        'js' => array('filemanager.js',),
                    ),
                    'fullscreen' => array(
                        'js' => array('fullscreen.js'),
                    ),
                    'table'=>array(
                        'js' => array('table.js'),
                    ),
                ),
                'options' => array(
                    'lang' => Yii::app()->language,
                    'imageUpload' => $this->createUrl('admin/imageImperaviUpload'),
                    'imageManagerJson' => $this->createUrl('admin/imageImperaviJson'),
                    'fileUpload' => $this->createUrl('admin/fileImperaviUpload'),
                    'fileManagerJson' => $this->createUrl('admin/fileImperaviJson'),
                    'uploadFileFields' => array(
                        'name' => '#redactor-filename'
                    ),
                    'changeCallback' => 'js:function()
                    {
                        viewSubmitButton(this.$element[0]);
                    }',
                    'buttonSource' => true,
                ),
            )
        );

        echo $form->error($model, 'description');
?>
    </div>

    <?php if(!$model->isNewRecord): ?>
    <?php
        $cs=Yii::app()->getClientScript();

        $cs->registerPackage('ractivejs');

        $map_script = '
             var iterator = 1;
             var placemarks = [];
             var map;

             ymaps.ready(function()
             {
                map = new ymaps.Map("map",
                {
                    center: ['.$model->getCenter().'],
                    zoom: '.$model->getZoom().',
                    type: "'.$model->getType().'",
                    controls: ["fullscreenControl", "searchControl", "zoomControl", "typeSelector"],
                });

                map.events.add("boundschange", function (event)
                {
                    if (event.get("newZoom") != event.get("oldZoom"))
                    {
                        if($("#group-placemark :selected").attr("value") == 0)
                            setValue("zoom", event.get("newZoom"));

                        //zoom для группы

                        $("#group-placemark :selected").attr("data-zoom", event.get("newZoom"));
                        $("input[type=hidden]#zoom-"+$("#group-placemark :selected").attr("value")).attr("value", event.get("newZoom"));
                    }
                    if (event.get("newCenter") != event.get("oldCenter"))
                    {
                        if($("#group-placemark :selected").attr("value")==0)
                            setValue("center",event.get("newCenter"));

                        //center для группы 
                        $("#group-placemark :selected").attr("data-center", event.get("newCenter"));
                        $("input[type=hidden]#center-"+$("#group-placemark :selected").attr("value")).attr("value", event.get("newCenter"));
                    }
                });

                map.events.add("typechange", function (event) {
                    setValue("type",event.get("target").getType());
                 });

                map.events.add("click", function (e)
                {
                    insertPlacemarkInMap(createPlacemark(e.get("coords"),"'.Yii::t('app','New placemark').'",$("#group-placemark :selected").attr("value"),"","islands#redStretchyIcon"));
                });
            });

             var ractive = new Ractive({
                  el: "placemarks-items",
                  template: "#placemarks",
                  data: { placemarks: placemarks },
                  twoway: false,
                });

             ractive.on("edit", function ( event ) {

                   var name=event.node.name;
                   var values=$("[name=\""+name+"\"]").closest("div");
                   event.context.properties.set({
                    iconContent: values.find("input.iconContent").val(),
                    group_id: values.find("input.group_id").val(),
                    balloonContent: values.find("input.balloonContent").val(),
                });
                 event.context.options.set({
                    preset: values.find("input.preset").val(),
                });
             });

             ractive.on("remove", function (event,index)
             {
                  map.geoObjects.remove(event.context);
                  placemarks.splice(index, 1);
                  return false;
             });

            //вставить значение в input
            function setValue(name,value)
            {
                $("#maps-index-form").find("input[id$="+name+"]").val(value);
            }

            function createPlacemark(coords,iconContent,group_id,balloonContent,preset)
            {
                var placemark = new ymaps.Placemark(coords,{
                    iconContent: iconContent,
                    group_id: group_id,
                    balloonContent: balloonContent,
                },
                {
                    preset: preset,
                    draggable: true
                });

                placemark.events.add("contextmenu", function (e)
                {
                    var item=parseInt(e.get("target").elementNum);
                    alert("'.Yii::t('app','Placemark').' №"+item);
                });

                placemark.events.add("dragend",function(e)
                {
                    var target=e.get("target");
                    var item=target.elementNum;
                    $("#placemarks-items input.coords-"+item).val(target.geometry.getCoordinates());
                    $("#placemarks-items input.groups-"+item).val(group_id);
                });

                return placemark;
            }

            //добавить на карту метку
            function insertPlacemarkInMap(placemark,id)
            {
                map.geoObjects.add(placemark);
                placemark.elementNum=iterator;
                placemark.id=id;
                iterator++;
                placemarks.push(placemark);
            }
        ';

        //вставляем метки с модели
        if (!empty($model->mapsPlacemarks))
        {
            $map_script.='ymaps.ready(function(){';
            foreach ($model->mapsPlacemarks as $item)
            {
                $map_script.='
                        insertPlacemarkInMap(createPlacemark(['.$item->position.'],"'.$item->iconContent.'","'.$item->group_id.'","'.$item->balloonContent.'","'.$item->preset.'"),"'.$item->id.'");
                        $("#placemarks-items .place-group").hide();
                        $("#placemarks-items #"+$("#group-placemark :selected").attr("value")).show();
                ';
            }
            $map_script.='});';
        }


        $cs->registerScriptFile('http://api-maps.yandex.ru/2.1/?lang='.Yii::app()->language);
        $cs->registerScript('map_script',$map_script);
    ?>
    <div id="map" style="width: 100%; height: 500px;">

    </div>

    <div class="form-group">
        <div class="label-block">Группы адресов:</div>
        <select class="form-control" id="group-placemark">
            <option data-zoom="<?php echo $model->getZoom(); ?>" data-center="<?php echo $model->getCenter(); ?>" value="0">-</option>
            <?php foreach(MapsPlacemarkGroup::getGroupPlacemark($model->id) as $key=>$value){
                echo '<option data-zoom="'.$value->zoom.'" data-center="'.$value->center.'" value="'.$value->id.'">'.$value->title.'</option>';
            }?>
        </select>
    </div>

    <?php foreach(MapsPlacemarkGroup::getGroupPlacemark($model->id) as $key=>$value){
            echo '<input type="hidden" id="center-'.$value->id.'" name="group[center]['.$value->id.']" value="'.$value->center.'">';
            echo '<input type="hidden" id="zoom-'.$value->id.'" name="group[zoom]['.$value->id.']" value="'.$value->zoom.'">';
    }?>

    <div id="placemarks-items">
    </div>

    <script id="placemarks" type="text/ractive">
        <div class="superheroes row">
            <div class="col-xs-12">
                <div class="label-block">
                    <label><?php echo Yii::t('app','Icon content'); ?>:</label>
                </div>
            </div>
            {{#each placemarks:num}}
            <div class="row place-group" id="{{properties.get("group_id")}}">
            <div class="col-xs-12">
                <div class="col-xs-9 form-group">
                    <input type="hidden" name="placemark[{{num}}][id]" on-change="edit" value="{{id}}">
                    <input type="hidden" class="coords-{{elementNum}}" name="placemark[{{num}}][position]" on-change="edit" value="{{geometry.getCoordinates()}}">
                    <input type="hidden" class="groups-{{elementNum}}" name="placemark[{{num}}][group_id]" on-change="edit" value="{{properties.get("group_id")}}">
                    <input type="text" class="iconContent form-control" name="placemark[{{num}}][iconContent]" on-change="edit" value="{{properties.get("iconContent")}}">
                </div>
                <div class="col-xs-1"><img class="delete" on-click="remove:{{num}}" src="/images/delete.png" alt="Удалить" title="Удалить"/></div>
            </div>
            </div>
            {{/each}}
        </div>
    </script>

    <?php echo $form->hiddenField($model,'center'); ?>
    <?php echo $form->hiddenField($model,'zoom'); ?>
    <?php echo $form->hiddenField($model,'type'); ?>

<?php endif; ?>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array()); ?>
        <span>Отмена</span>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form --> 

<?php
    $cs=Yii::app()->getClientScript();

    $group="
        $('#group-placemark').on('change',function(){
            var center = $('#group-placemark :selected').attr('data-center');
            var zoom = $('#group-placemark :selected').attr('data-zoom');
            var value = $('#group-placemark :selected').attr('value');

            $('#placemarks-items .place-group').hide();
            $('#placemarks-items #'+value).show();

            map.setCenter(center.split(','), zoom, {
                checkZoomRange: true
            });
        });
        ";


    $cs->registerPackage('jquery')->registerScript('group',$group);
?>