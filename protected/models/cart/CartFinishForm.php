<?php
    class CartFinishForm extends CFormModel
    {
        public $finish;
        public $step;

        public function rules()
        {
            return array(
                array('finish,step', 'safe'),
            );
        }
    }