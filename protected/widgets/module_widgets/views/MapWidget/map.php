<?php if($this->group):

$groups = MapsPlacemarkGroup::getGroupPlacemark($this->map_id);

if(count($groups)>0){
    $center = $groups[0]->center;
    $zoom = $groups[0]->zoom;
}
?>
<select class="form-control" id="group-placemark">
    <?php foreach($groups as $key=>$value){
        echo '<option data-zoom="'.$value->zoom.'" data-center="'.$value->center.'" value="'.$value->id.'">'.$value->title.'</option>';
    }?>
</select>
<?php endif; ?>

<?php
if(!$this->group || !isset($center) || !isset($zoom)){
    $center = $this->_data->getCenter();
    $zoom = $this->_data->getZoom();
}

echo '<div id="'.$this->id.'" class="map" style="width:'.$this->width.';height:'.$this->height.'"></div>';

$cs=Yii::app()->getClientScript();
$cs->registerScriptFile('http://api-maps.yandex.ru/2.1/?lang='.Yii::app()->language);

$map_script='
            var map;

            ymaps.ready(function(){
                map = new ymaps.Map("'.$this->id.'", {
                    center: ['.$center.'],
                    zoom: '.$zoom.',
                    type: "'.$this->_data->getType().'",
                    controls: ["fullscreenControl","geolocationControl","zoomControl","typeSelector"],
                });
            });


            function createPlacemark(coords,iconContent,hintContent,balloonContent,preset)
            {
                var placemark = new ymaps.Placemark(coords,{
                    iconContent: iconContent,
                    hintContent: hintContent,
                    balloonContent: balloonContent,
                },
                {
                    preset: preset
                });

                return placemark;
            }
        ';

if (!empty($this->_data->mapsPlacemarks))
{
    $map_script.='ymaps.ready(function(){';
    foreach ($this->_data->mapsPlacemarks as $item)
    {
        $map_script.='
                        map.geoObjects.add(createPlacemark(['.$item->position.'],"'.$item->iconContent.'","'.$item->hintContent.'","'.$item->balloonContent.'","'.$item->preset.'"));
                ';
    }
    $map_script.='});';
}

$cs->registerScript('map_script'.$this->id,$map_script);

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