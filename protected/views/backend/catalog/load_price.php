<?php
    echo BsHtml::form();

    $this->widget('application.extensions.EFineUploader.EFineUploader',
        array(
            'id' => 'FineUploaderLogo',
            'config' => array(
                'button' => "js:$('.download_image')[0]",
                'autoUpload' => true,
                'request' => array(
                    'endpoint' => $this->createUrl($this->id.'/upload'),
                    'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                ),
                'retry' => array('enableAuto' => true,'preventRetryResponseProperty' => true),
                'chunking' => array('enable' => true,'partSize' => 100),
                'callbacks' => array(
                    'onComplete' => 'js:function(id, name, response)
                                    {
                                        if (response["success"])
                                        {
                                            $(".file").html("<input type=\"hidden\" name=\"file\" value=\""+response["folder"]+response["filename"]+"\">");
                                        }
                                    }',
                ),
                'validation' => array(
                    'allowedExtensions' => array('csv'),
                    'sizeLimit' => 4 * 1024 * 1024,
                ),
            )
        )
    );

    echo
        '<div class="file">
            Файл не загружен
        </div>';
?>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app', 'Save'),array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

<?php
    echo BsHtml::endForm();
