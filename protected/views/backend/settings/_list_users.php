<?php
    if(!empty($data))
    {
        $image = $data->getOneFile('original');
        if (!$image)
        {
            $image = Yii::app()->params['noimage'];
        }
        $link = $this->createUrl('settings/permission', array('id'=>$data->id));
?>

        <tr>
            <td class="table-bold left">
                <div class="one_item" id="<?php echo $data->id; ?>"
                <div class="col-xs-1">
                    <div class="status <?php echo ($data->status == 1) ? 'active' : 'not_active'; ?>">
                        <?php echo BsHtml::checkBox('checkbox[' . $data->id . ']', false, array('class' => 'checkbox group')); ?>
                        <?php echo BsHtml::label('', 'checkbox_' . $data->id, false, array('class' => 'checkbox')); ?>
                    </div>
                </div>
                </div>
            </td>
            <td>
                <a href="<?php echo $link ;?>">
                    <div class="table-img"><img src="/<?php echo $image ;?>"/></div>
                    <div class="number-user"># <?php echo $data->id ;?></div>
                    <div class="user">
                        <img src="/images/icon-admin/little_user_company.png"/><?php echo $data->user_info->getFullName() ;?>
                    </div>
                    <div class="mail">
                        <img src="/images/icon-admin/little_message_company.png"/><?php echo $data->email ;?>
                    </div>
                    <div class="phone">
                        <img src="/images/icon-admin/little_phone.png"/><?php echo $data->user_info->phone ;?>
                    </div>
                </a>
            </td>
            <td>
                <div
                class="create"><?php echo Yii::app()->dateFormatter->format('d MMMM yyyy', $data->create_time); ?></div>
                <div
                class="redact"><?php echo Yii::app()->dateFormatter->format('d MMMM yyyy', $data->update_time); ?></div>
            </td>
            <td>
                <div class="role"><?php echo $data->getRole($data->role); ?></div>
            </td>
            <td>
                <?php echo isset($data->usersSession->id) ? '<div class="status v-seti">В сети</div>' : '<div class="status offline">Не в сети</div>'; ?>
            </td>
            <td>
                <a href="<?php echo $this->createUrl('active', array('id' => $data->id)) ?>"
                   class="btn btn-small btn-active"><span
                    class="icon-admin-power-switch-<?php echo($data->status == CatalogProducts::STATUS_OK ? 'green' : 'red'); ?>"></span></a>
            </td>
        </tr>
<?php
    }
?>