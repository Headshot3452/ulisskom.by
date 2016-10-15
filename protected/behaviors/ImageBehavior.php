<?php
Yii::import('application.behaviors.FileUploadBehavior');
class ImageBehavior extends FileUploadBehavior
{
    public $quality = 75;
    public $resize = 'auto';//auto - ужимает в размеры сохраняя пропорции
                            //crop - подгоняет под размеры обрезая лишнее

    //sizes array { key=dir, array[0]=width, array[1]=height, array[2]=>resize_type }
    //sizes array {origin} for origin size

    public $sizes = array(
                    'small'=>array('200','200'),
                    'big'=>array('1000','1000'),
                    'origin'
    );

    public $watermark = array();

    public function deleteImage($images)
    {
        foreach ($images as $item)
        {
            $tmp_img=$item['path'].$item['name'];
            $this->deleteFile($tmp_img);
            foreach ($this->sizes as $key=>$size)
            {
                $tmp_img=$item['path'].$key.'/'.$item['name'];
                $this->deleteFile($tmp_img);
            }
        }
    }

    public function beforeSave($event)
    {
        $owner=$this->getOwner();

        $oldFiles=$this->getFiles();

        parent::beforeSave($event);
        $files = unserialize($owner->{$this->files_attr_name});

        if(isset($files) && !empty($files))
        {
            foreach ($files as $item)
            {
                $file = $item['path'] . $item['name'];

                if (!isset($oldFiles[$file]))
                {
                    //кастыль из другого компонента
                    //TODO: Переписать нормальный ватермарк
                    if ($this->watermark) {
                        Yii::app()->ih
                        ->load($file)
                        ->watermark($this->watermark['image'], 0, 0, $this->watermark['position'])
                        ->save($file);
                    }

                    if (!empty($this->sizes))
                    {
                        foreach ($this->sizes as $key => $size)
                        {
                            $image = Yii::app()->image->load($file);

                            //for origin size
                            if (is_string($size))
                            {
                                $key = $size;
                                $size = NULL;
                            }

                            if (!file_exists($this->path . $key))
                            {
                                mkdir($this->path . $key);
                            }

                            if (isset($size[0]) && isset($size[1]))
                            {
                                if ((isset($size[2]) && $size[2] == 'crop') || (!isset($size[2]) && $this->resize == 'crop'))
                                {
                                    if (($image->width / $size[0]) < ($image->height / $size[1]))
                                    {
                                        $master = CImage::WIDTH;
                                    }
                                    else
                                    {
                                        $master = CImage::HEIGHT;
                                    }
                                    $image->resize($size[0], $size[1], $master)->crop($size[0], $size[1])->quality($this->quality);
                                }
                                else
                                {
                                    $image->resize($size[0], $size[1])->quality($this->quality);
                                }
                                $image->save($this->path . $key . '/' . $item['name']);
                            }
                            else
                            {
                                copy($file, $this->path . $key . '/' . $item['name']);
                            }
                        }
                        $this->deleteFile($file);
                    }
                }
                else
                {
                    unset($oldFiles[$file]);
                }
            }
        }
        $this->deleteImage($oldFiles);
    }


    public function gridImage($image,$alt='',$options=array('height'=>'50px'))
    {
       if ($image!='')
       {
           $file=Yii::app()->request->baseUrl.'/'.$image;
           return CHtml::image($file,Chtml::encode($alt),$options);
       }
    }

    public function getOneFile($size='',$origin_gif = true)
    {
        $file='';

        $files = $this->getFiles();
        $keys = array_keys($files);
        if (!empty($keys))
        {
            if ($size=='')
            {
                $file=$keys[0];
            }
            else
            {
                $ext=substr(strrchr($files[$keys[0]]['name'],'.'), 1);
                if($ext == 'gif' && isset($this->sizes[0]))//если есть оригинальный размер, то его индекс 0
                {
                    $file=$files[$keys[0]]['path'].$this->sizes[0].'/'.$files[$keys[0]]['name'];
                }
                else
                {
                    $file=$files[$keys[0]]['path'].$size.'/'.$files[$keys[0]]['name'];
                }

            }
        }
        return $file;
    }
}
?>