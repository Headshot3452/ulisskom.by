<?php
    class CurrencyUpdateAction extends BackendAction
    {
        public function run()
        {
            $model = new SettingsCurrency();
            $item  = $model->findByPk($_GET['id']);
            switch($_GET['action'])
            {
                case 'format_icon' :
                    $item->format_icon = ($item->format_icon) ? 0 : 1;
                    break;
                case 'format' :
                    $item->format = ($item->format) ? 0 : 1;
                    break;
                case 'status' :
                    $item->status = ($item->status) ? 0 : 1;
                    break;
                case 'basic' :
                    $this->changeBasicCurrency($item);
                    $item->course = 1;
                    break;
                default:
                    $item->delete();
                    break;
            }

            if($item->save())
            {
                $this->redirect('/admin/settings/currency/');
            }

        }

        public function changeBasicCurrency($item)
        {
            $new_course = 1/$item->course;
            $model = new SettingsCurrency();
            $items = $model->findAll();
            foreach ($items as $value)
            {
                $value->course = $value->course * $new_course;
                $value->save();
            }
            $model_list = new SettingsCurrencyList();
            $criteria = new CDbCriteria();
            $criteria->condition = 'basic = :basic';
            $criteria->params = array(':basic' => 1);
            $old_basic = $model_list->find($criteria);
            $old_basic->basic = 0;
            $old_basic->save();
            $new_basic_currency = $model_list->findByPk($item->currency_name);
            $new_basic_currency->basic = 1;
            $new_basic_currency->save();

            $catalog_model = new CatalogProducts();
            $products = $catalog_model->findAll();

            foreach ($products as $value)
            {
                $value->price = $value->price * $new_course;
                $value->save();
            }
        }
    }
