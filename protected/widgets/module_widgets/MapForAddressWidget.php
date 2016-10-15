<?php
    class MapForAddressWidget extends StructureWidget
    {
        public $width = '100%';
        public $height = '100%';
        public $address = "";
        public $zoom = 8;
        public $type = 'yandex#publicMap';
        public $controls = array(
            'fullscreenControl',
            'geolocationControl',
            'zoomControl',
            'typeSelector',
        );

        public function setData()
        {
            return true;
        }

        public function renderContent()
        {
            echo '<div id="'.$this->id.'" class="map" style="width:'.$this->width.';height:'.$this->height.'"></div>';

            $cs=Yii::app()->getClientScript();
            $cs->registerScriptFile('http://api-maps.yandex.ru/2.1/?lang='.Yii::app()->language);

            $map_script='
                var map;

                ymaps.ready(function()
                {
                    map = new ymaps.Map("'.$this->id.'",
                    {
                        center: [53.916667, 30.35],
                        zoom: '.$this->zoom.',
                        type: "'.$this->type.'",
                        controls: '.CJSON::encode($this->controls).',
                    });

                    var myGeocoder = ymaps.geocode("'.$this->address.'",
                    {
                        results: 1
                    });
                    console.log(myGeocoder);
                    myGeocoder.then(
                        function (res) {

                            var firstGeoObject = res.geoObjects.get(0),
                            // Координаты геообъекта.
                            coords = firstGeoObject.geometry.getCoordinates(),
                            // Область видимости геообъекта.
                            bounds = firstGeoObject.properties.get("boundedBy");

                            map.geoObjects.add(res.geoObjects);
                            map.setBounds(bounds, {
                                checkZoomRange: true // проверяем наличие тайлов на данном масштабе.
                            });
                        },
                        function (err) {
                            // обработка ошибки
                        }
                    );
                });
            ';
            $cs->registerScript('map_script',$map_script);
        }
    }