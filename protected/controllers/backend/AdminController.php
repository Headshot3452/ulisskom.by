<?php
    class AdminController extends BackendController
    {
        public $layout_in = 'backend_one_block';

        public static function getActionsConfig()
        {
            return array(
                'sitemanagement' => array('label' => 'Управление сайтом', 'parent' => 'main_modules'),
            );
        }

        public function actionIndex()
        {
            $this->layout = 'main_backend';
            $item = Modules::model()->active()->findAll('on_main = :on_main', array(':on_main' => 1));
            $this->render('index', array('item' => $item));
        }

        public function actionSiteManagement()
        {
            $menu = array();

            $modules = Modules::model()->active()->findAll('common= :common', array(':common' => 1));

            foreach($modules as $module)
            {
                $menu[] = array(
                    'title' => $module->title,
                    'url' => Yii::app()->createUrl($module->name.'/index'),
                    'image' => $module->files ? 'images/icon-admin/'.$module->files :Yii::app()->params['noimage'],
                );
            }

            $this->render('menu_list',array('menu' => $menu));
        }

        public function actionGenerateUrlManager()
        {
            $ug = new UrlManagerGenerator();
            $ug->generateUrlManager();
        }

        public function actionRecompileUrlManager()
        {
            $ug = new UrlManagerGenerator();
            $ug->recompileUrlManger();
        }

        public function actionRefreshModuleUrls()
        {
            $ug = new UrlManagerGenerator();
            $ug->refreshModuleUrls();
        }

        public function actionImageImperaviUpload()
        {
            $file=CUploadedFile::getInstanceByName('file');
            if (!in_array(strtolower($file->getExtensionName()),array('jpg','png','jpeg','bmp','gif')))
            {
                throw new CException('Bad file extensions');
            }
            if (!$file->getHasError())
            {
                $media=MediaCloud::getInstance();
                $new_name=uniqid().'.'.$file->getExtensionName();
                if ($file->saveAs($media->getImagePath().$new_name))
                {
                     $media->addImage($new_name,$file->getName());
                }
                $result = array(
                    'filelink' => $media->getImageWebPath().$new_name
                );
            }
            else
            {
                $result = $file->getError();
            }
            echo CJSON::encode($result);
        }

        public function actionImageImperaviJson()
        {
            $media = MediaCloud::getInstance();
            $images = $media->getImages();
            echo CJSON::encode($images['items']);
        }

        public function actionFileImperaviUpload()
        {
            $file=CUploadedFile::getInstanceByName('file');
            if (!$file->getHasError())
            {
                $title=$file->getName();
                if (!empty($_POST['name']))
                {
                    $title=$_POST['name'];
                }
                $media=MediaCloud::getInstance();
                $new_name=uniqid().'.'.$file->getExtensionName();
                if ($file->saveAs($media->getFilePath().$new_name))
                {
                    $media->addFile($new_name,$title,$file->getSize());
                }
                $result = array(
                    'filelink' => $media->getFileWebPath().$new_name,
                    'filename' => $title
                );
            }
            else
            {
                $result=$file->getError();
            }
            echo CJSON::encode($result);
        }

        public function actionFileImperaviJson()
        {
            $media=MediaCloud::getInstance();
            $images=$media->getFiles();
            echo CJSON::encode($images['items']);
        }

        public function actionSettings()
        {
            $this->render('list', array('items' => array()));
        }

        public function actionLanguage($code)
        {
            $language=$this->setCurrentLanguage($code);

            Yii::app()->user->setState('language',$language->code);

            $this->redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER']: $this->createUrl('structure/index'));
        }
    }
