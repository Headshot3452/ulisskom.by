<?php
class Captcha extends CCaptcha
{
        public $model;
        public $attribute;

         public function run()
        {
                parent::run();
                echo CHtml::activeTextField($this->model, $this->attribute);
        }

}