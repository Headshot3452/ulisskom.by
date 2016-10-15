<table class="table table-hover">
    <tbody>
    <tr>
        <td>
            <?php echo $data->getAttributeLabel('city_id'); ?>
        </td>
        <td>
            <?php echo CHtml::encode($data->city->title); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $data->getAttributeLabel('street'); ?>
        </td>
        <td>
            <?php echo CHtml::encode($data->street); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $data->getAttributeLabel('house'); ?>
        </td>
        <td>
            <?php echo CHtml::encode($data->house); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $data->getAttributeLabel('apartment'); ?>
        </td>
        <td>
            <?php echo CHtml::encode($data->apartment); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $data->getAttributeLabel('user_name'); ?>
        </td>
        <td>
            <?php echo CHtml::encode($data->user_name); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $data->getAttributeLabel('phone'); ?>
        </td>
        <td>
            <?php echo CHtml::encode($data->phone); ?>
        </td>
    </tr>
    </tbody>
</table>