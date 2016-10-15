<?php
    foreach ($params as $key => $item)
    {
        $options = array();

        if(isset($item_params[$key]))
        {
            $value_model = $item_params[$key]->value;
        }
        else
        {
            $value_model = CatalogParamsVal::model();
        }

        if(empty($item->type))
        {
            $label[$item->id] = $item->title;
        }
        else
        {
            if(!isset($param_label) || $param_label != $label[$item->parent_id])
            {
                echo $form->labelEx($item, $item->title, array('label' => $label[$item->parent_id], 'class' => 'parent_label'));
                $param_label = $label[$item->parent_id];
            }

            echo '<div class="form-group">';
            echo $form->labelEx($item, $item->title, array('label' => $item->title, 'class' => 'child_label'));

            switch ($item->type)
            {
                case CatalogParams::TYPE_TEXT:
                    echo $form->textField($value_model, '[' . $key . ']value');
                    break;
                case CatalogParams::TYPE_YES_NO:
                    echo $form->checkBox($value_model, '[' . $key . ']value');
                    echo $form->label($value_model, '[' . $key . ']value', array('label' => ''));
                    break;
                case CatalogParams::TYPE_SELECT:
                    echo CHtml::dropDownList(get_class($value_model) . '[' . $key . '][value]', $value_model->id, CHtml::listData($item->catalogParamsVals(), 'id', 'value'));
                    break;
                case CatalogParams::TYPE_CHECKBOX:
                    if (isset($item_params[$key]))
                    {
                        $values = $item_params[$key]->getParamsValues();
                        if (!empty($values))
                        {
                            foreach ($values as $vl)
                            {
                                $options[] = $vl->value_id;
                            }
                        }
                    }
                    echo CHtml::hiddenField(get_class($value_model) . '[' . $key . '][value]', 0); //если пустой чекбокс лист, чтобы удалить из базы
                    echo CHtml::checkBoxList(get_class($value_model) . '[' . $key . '][value]', $options, CHtml::listData($item->catalogParamsVals(), 'id', 'value'), array('separator' => ''));
                    break;
            }
                echo $form->labelEx($item, $item->title, array('label' => $item->getUnitType($item->unit), 'class' => 'unit'));
            echo '</div>';
        }
    }