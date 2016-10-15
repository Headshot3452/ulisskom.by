<?php
class UploadAction extends BackendAction
{
    public function run()
    {
        $tempFolder='data/temp/';

        @mkdir($tempFolder, 0777, TRUE);
        @mkdir($tempFolder.'chunks', 0777, TRUE);

        Yii::import("application.extensions.EFineUploader.qqFileUploader");

        $uploader = new qqFileUploader();
        $uploader->allowedExtensions = array();
        $uploader->sizeLimit = 2 * 1024 * 1024;//maximum file size in bytes
        $uploader->chunksFolder = $tempFolder.'chunks';

        //находим расширение изображения
        $ext=substr(strrchr($uploader->getName(),'.'), 1);

        $result = $uploader->handleUpload($tempFolder,  uniqid().'.'.$ext);
        $result['filename'] = $uploader->getUploadName();
        $result['folder'] = $tempFolder;

        $uploadedFile=$tempFolder.$result['filename'];

        header("Content-Type: text/plain");
        $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result;
        Yii::app()->end();
    }
}
?>
