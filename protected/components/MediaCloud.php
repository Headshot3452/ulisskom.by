<?php
class MediaCloud
{
    private static $_instance;
    public $log_file='log.txt';
    protected $_settings=array();
    protected $_files=array(
                        'images'=>array(),
                        'files'=>array()
    );

    private function __construct()
    {
        $this->_settings=Yii::app()->params['upload']['media'];
    }

    protected function __clone()
    {

    }

    public static function getInstance()
    {
        if (self::$_instance==null)
        {
            self::$_instance=new self;
        }
        return self::$_instance;
    }

    public function getImages()
    {
        if (empty($this->_files['images']))
        {
            $this->getFilesForKey('images');
        }
        return $this->_files['images'];
    }

    public function getFiles()
    {
        if (empty($this->_files['files']))
        {
            $this->getFilesForKey('files');
        }
        return $this->_files['files'];
    }

    public function addImage($file,$title)
    {
        $files=$this->getImages();
        $this->_files['images']['log'][$file]=array($this->getLogItemImage($file),'title'=>$title);
        $this->save('images');
    }

    public function addFile($file,$title,$size)
    {
        $files=$this->getFiles();
        $this->_files['files']['log'][$file]=array($this->getLogItemFile($file),'title'=>$title,'size'=>$size);
        $this->save('files');
    }

    protected function save($key)
    {
        $files=$this->_files[$key];
        $log=fopen(Yii::getPathOfAlias($this->_settings[$key]['path']).'/'.$this->log_file,'w');
        fwrite($log,serialize($files['log']));
    }

    protected function getFilesForKey($key)
    {
        $array=array();
        $path=Yii::getPathOfAlias($this->_settings[$key]['path']).'/';
        $log=array();
        $log_file=$path.'/'.$this->log_file;
        if (file_exists($log_file))
        {
            $log=@unserialize(file_get_contents($log_file));
        }
        $files=scandir($path);
        $files=array_slice($files,2,count($files));
        foreach($files as $file)
        {
            if ($file!='log.txt' && substr($file,0,1)!='.')
            {
                $temp=$this->getLogTemplate($key,$file);
                if (isset($log[$file]))
                {
                    $temp=array_merge($temp,$log[$file]);
                }
                $array[]=$temp;
            }
        }
        $this->_files[$key]=array('items'=>$array,'log'=>$log);
    }

    public function getImagePath()
    {
        return Yii::getPathOfAlias($this->_settings['images']['path']).'/';
    }

    public function getImageWebPath()
    {
        return $this->_settings['images']['webpath'];
    }

    public function getFilePath()
    {
        return Yii::getPathOfAlias($this->_settings['files']['path']).'/';
    }
    public function getFileWebPath()
    {
        return $this->_settings['files']['webpath'];
    }

    protected function getLogTemplate($key,$file)
    {
        $template=array();
        switch($key)
        {
            case 'images' :
                $template=$this->getLogItemImage($file);
                break;
            default:
                $template=$this->getLogItemFile($file);
                break;
        }
        return $template;
    }

    protected function getData($key)
    {
        $files=array();
        switch($key)
        {
            case 'images' :
                $files=$this->getImages();
                break;
            default:
                $files=$this->getFiles();
                break;
        }
        return $files;
    }


    protected function getLogItemImage($file)
    {
        $temp=array(
            'title'=>'',
            'image'=>$this->getImageWebPath().$file,
            'thumb'=>$this->getImageWebPath().$file,
        );
        return $temp;
    }
    protected function getLogItemFile($file)
    {
        $temp=array(
            'title'=>'',
            'name'=>$file,
            'link'=>$this->getFileWebPath().$file,
            'size'=>'0',
        );
        return $temp;
    }
}