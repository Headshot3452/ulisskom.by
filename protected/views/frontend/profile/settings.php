<h2>Профиль пользователя</h2>

<?php
$image = $user->getOneFile('small');

if (!file_exists($image)) {
    $image = Yii::app()->params['noavatar'];
}
?>

<div class="dl-lists row" id="profil_settings">

    <div class="col-md-4 col-md-push-6">
        <div class="text-uppercase label-title">Фотография профиля</div>

        <div class="avatar col-md-12 row">
            <img src="/<?php echo $image ?>">
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="col-md-6 col-md-pull-4">
        <div class="text-uppercase label-title">Личные данные</div>

        <table class="table table-hover">
            <tbody>
            <tr>
                <td>
                    <?php echo $user_info->getAttributeLabel('last_name'); ?>
                </td>
                <td>
                    <?php echo CHtml::encode($user_info->last_name); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $user_info->getAttributeLabel('name'); ?>
                </td>
                <td>
                    <?php echo CHtml::encode($user_info->name); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $user_info->getAttributeLabel('patronymic'); ?>
                </td>
                <td>
                    <?php echo CHtml::encode($user_info->patronymic); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $user_info->getAttributeLabel('nickname'); ?>
                </td>
                <td>
                    <?php echo CHtml::encode($user_info->nickname); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $user_info->getAttributeLabel('birth'); ?>
                </td>
                <td>
                    <?php echo Yii::app()->dateFormatter->format('dd MMM yyyy', $user_info->birth); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $user->getAttributeLabel('email'); ?>
                </td>
                <td>
                    <?php echo CHtml::encode($user->email); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $user_info->getAttributeLabel('phone'); ?>
                </td>
                <td>
                    <?php echo CHtml::encode($user_info->phone); ?>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
    <div class="clearfix"></div>
    <div class="form-group">
        <div class="col-md-12">
            <a href="<?php echo $this->createUrl('settingsEdit'); ?>" class="btn btn-primary">Редактировать профиль</a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
</div>
