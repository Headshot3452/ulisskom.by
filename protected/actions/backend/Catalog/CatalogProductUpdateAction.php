<?php
    class CatalogProductUpdateAction extends BackendAction
    {
        public function run($tree_id = null)
        {
            $model = $this->getModel();

            $this->controller->setActiveCategoryId($model->parent_id);

            $this->controller->addButtonsLeftMenu('create',
                array(
                    'url' => $this->controller->createUrl('create_category').'?parent='.$model->parent_id
                )
            );
            if ($tree_id === null)
            {
                $tree_id = $model->parent_id;
            }
            elseif($model->isNewRecord)
            {
                $model->parent_id=$tree_id;
                $criteria = new CDbCriteria();
                $criteria->select = 'MAX(`sort`) as `sort`';
                $criteria->condition = '`parent_id` = :parent_id';
                $criteria->params = array(':parent_id' => $model->parent_id);
                $sort = CatalogProducts::model()->active()->find($criteria);
                $model->sort = $sort->sort + 1;
            }

            $tree = CatalogTree::model()->findByPk($tree_id);

            if ($tree === null)
            {
                throw new CHttpException(404);
            }

            $params = $this->controller->getParamsForTree($tree);

            $item_params = $model->parameters_uniq;
            if($item_params)
            {
                $item_params = array_combine(CHtml::listData($item_params, 'params_id', 'params_id'), $item_params);
            }

            if(isset($_POST['CatalogProductsReviews']))
            {
                $productsReview = CatalogProductsReviews::model()->findByPk($_POST['CatalogProductsReviews']['id']);
                $productsReview->attributes = $_POST['CatalogProductsReviews'];

                if($productsReview->validate())
                {
                    $productsReview->save();
                }
            }

            if(isset($_POST['CatalogProducts']))
            {
                $model->attributes = $_POST['CatalogProducts'];

                $model->price = str_replace(" ", "", $model->price);
                $model->count = str_replace(" ", "", $model->count);

                if($model->validate())
                {
                    if($model->type != 2)
                    {
                        $sale_value = str_replace(" ", "", $_POST['sale_value']);
                        if($sale_value != '0.00')
                        {
                            $model->sale_info = serialize(array($sale_value, $_POST['sale_type'], $_POST['date_from'], $_POST['date_to']));
                        }
                    }
                    else
                    {
                        $model->sale_info = '';
                        $model->price = '';
                    }

                    if($model->type == 1 || $model->type == 4)
                    {
                        foreach($model->opt_price as $value)
                        {
                            $value->delete();
                        }
                    }

                    $model->stock = serialize(array($_POST['stock'], $_POST['days']));
                    $model->unit_id = $_POST['unit_id'];

                    $model->save(false);

                    if(isset($_POST['OptPrice']))
                    {
                        $old_opt_price = array();

                        $opt_price = $model->opt_price;
                        if($opt_price)
                        {
                            $opt_price = array_combine(CHtml::listData($opt_price, 'id', 'id'), $opt_price);
                            $old_opt_price = $opt_price;
                        }

                        foreach($_POST['OptPrice'] as $key => $value)
                        {
                            if(isset($opt_price[$key]))
                            {
                                $opt_price[$key]->attributes = $value;

                                if($opt_price[$key]->validate())
                                {
                                    $opt_price[$key]->save();
                                }

                                unset($old_opt_price[$key]);
                            }
                            else
                            {
                                $opt_price = new OptPrice();
                                $opt_price->attributes = $value;

                                if($opt_price->validate())
                                {
                                    $opt_price->product_id = $model->id;
                                    $opt_price->save(false);
                                }
                            }
                        }

                        foreach($old_opt_price as $value)
                        {
                            $value->delete();
                        }
                    }

                    if(isset($_POST['CatalogParamsVal']))
                    {
                        foreach($_POST['CatalogParamsVal'] as $key => $val)
                        {
                            $item_params_save = true;

                            if(isset($item_params[$key]))
                            {
                                $item_param_value =$item_params[$key]->value;
                                $param_type = $item_params[$key]->params->type;
                            }
                            else
                            {
                                $item_param_value = new CatalogParamsVal();
                                $param = CatalogParams::model()->findByPk($key);
                                $param_type = $param->type;
                            }

                            switch($param_type)
                            {
                                case CatalogParams::TYPE_SELECT:
                                    $value =  $val['value'];
                                    break;

                                case CatalogParams::TYPE_TEXT: case CatalogParams::TYPE_YES_NO:
                                    if ($val['value'])
                                    {
                                        $value = $this->saveCatalogParamsVal($item_param_value, $val['value'], $key);
                                    }
                                    else
                                    {
                                        if(isset($item_params[$key]))
                                        {
                                            $item_params[$key]->delete();
                                        }
                                        $item_params_save = false;
                                    }
                                    break;

                                case CatalogParams::TYPE_CHECKBOX:
                                    if(isset($item_params[$key]))
                                    {
                                        $checkbox_value = $item_params[$key]->getParamsValues();
                                        if ($checkbox_value)
                                        {
                                            $checkbox_value = array_combine(CHtml::listData($checkbox_value, 'value_id', 'value_id'), $checkbox_value);
                                        }
                                        else
                                        {
                                            $checkbox_value = array();
                                        }
                                        if (!empty($val['value']) && is_array($val['value']))
                                        {
                                            foreach($val['value'] as $vl)
                                            {
                                                if (!isset($checkbox_value[$vl]))
                                                {
                                                    $this->saveCatalogProductsParams($key, $model->id, $vl);
                                                }
                                                unset($checkbox_value[$vl]);
                                            }
                                        }
                                        foreach($checkbox_value as $obj_vl)
                                        {
                                            $obj_vl->delete();
                                        }
                                    }
                                    else
                                    {
                                        if (!empty($val['value']) && is_array($val['value']))
                                        {
                                            foreach($val['value'] as $vl)
                                            {
                                                $this->saveCatalogProductsParams($key, $model->id, $vl);
                                            }
                                        }
                                    }
                                    $item_params_save = false;
                                break;
                            }

                            if($item_params_save)
                            {
                                if(isset($item_params[$key]))
                                {
                                    $item_params[$key]->value_id = $value;
                                    $item_params[$key]->save();
                                }
                                else
                                {
                                    $this->saveCatalogProductsParams($key, $model->id, $value);
                                }
                            }

                        }
                    }
                    if(!empty($_POST['releated_delete']))
                    {
                        foreach ($_POST['releated_delete'] as $key => $value)
                        {
                            ProductsReleated::model()->deleteByPk($key);
                        }
                    }

                    Yii::app()->user->setFlash('alert-swal',
                        array(
                            'header' => 'Выполнено',
                            'content' => 'Данные успешно сохранены!',
                        )
                    );

                    $this->redirect($this->controller->createUrl('update_product', array('id' => $model->id)));
                }
            }

            $products_releated = array();
            if(!$model->isNewRecord)
            {
                $this->controller->pageTitleBlock = BackendHelper::htmlTitleBlockDefault('', $this->controller->createUrl('index'));
                $this->controller->pageTitleBlock .= $this->controller->renderPartial('_product_one_for_head_title', array('data' => $model), true);
                $products_releated_ids = ProductsReleated::getReleatedProducts($model->id);
                $keys_array = array();
                foreach ($products_releated_ids as $value)
                {
                    $keys_array[] = $value->releated_id;
                }
                $ids = implode(', ', $keys_array);
                if(!empty($ids))
                {
                    $products_releated = CatalogProducts::model()->notDeleted()->findAll(array('condition' => '`t`.`id` IN ('.$ids.')', 'with' => 'productsReleatedsId', 'order' => '`productsReleatedsId`.`sort` '));
                }
            }

            $products_review = CatalogProductsReviews::model()->notDeleted()->search($model);

            $count_item = $products_review->getTotalItemCount();

            $this->render(array('model' => $model, 'params' => $params, 'count_item' => $count_item, 'item_params' => $item_params, 'products_releated' => $products_releated, 'products_review' => $products_review));
        }

        public function saveCatalogParamsVal($obj,$value,$params_id=null)
        {
            $obj->value = $value;
            if ($params_id !== null)
            {
                $obj->params_id = $params_id;
            }
            $obj->save();
            return $obj->id;
        }

        public function saveCatalogProductsParams($params_id, $product_id, $value)
        {
            $product_param = new CatalogProductsParams();
            $product_param->params_id = $params_id;
            $product_param->product_id = $product_id;
            $product_param->value_id = $value;
            $product_param->save();
            return $product_param;
        }
    }