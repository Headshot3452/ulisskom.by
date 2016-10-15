<?php

class UrlManagerGenerator {

    public $class_structure='Structure';
    public $module_config_dir = '';//папка с конфигами модулей
    public $data_dir = '';//папка бэкапы
    public $url_manager_config = '';//файл конфига для генерации урл менеджера
    public $url_manager_config_bckp = '';//имя файла для конфига бекапов
    public $url_manager = '';//имя файла для урлменеджера
    public $url_manager_bckp = '';//имя файла для  бекапа урлменджера

    public $write_backup = true;//делать бекап
    public $multi_language = false; //компилить для всех языков

    public function __construct()
    {
        if(isset(Yii::app()->params['module_config_dir']))
            $this->module_config_dir =  Yii::app()->params['module_config_dir'];
        else
            $this->module_config_dir = 'application.config.module_config';

        $this->module_config_dir=Yii::getPathOfAlias($this->module_config_dir);

        if(isset(Yii::app()->params['data_dir']))
            $this->data_dir = Yii::app()->params['data_dir'];
        else
            $this->data_dir = 'application.data';

        $this->data_dir=Yii::getPathOfAlias($this->data_dir);

        if(isset(Yii::app()->params['url_manager_config']))
            $this->url_manager_config = $this->data_dir. DIRECTORY_SEPARATOR. Yii::app()->params['url_manager_config'];
        else
            $this->url_manager_config = $this->data_dir. DIRECTORY_SEPARATOR.'urlManagerConfig.json';

        if(isset(Yii::app()->params['url_manager_config_bckp']))
            $this->url_manager_config_bckp = $this->data_dir. DIRECTORY_SEPARATOR. Yii::app()->params['url_manager_config_bckp'];
        else
            $this->url_manager_config_bckp = $this->data_dir. DIRECTORY_SEPARATOR.'urlManagerConfig.json.bckp';

        if(isset(Yii::app()->params['url_manager']))
            $this->url_manager = Yii::getPathOfAlias('application.config') . DIRECTORY_SEPARATOR. Yii::app()->params['url_manager'];
        else
            $this->url_manager = Yii::getPathOfAlias('application.config').DIRECTORY_SEPARATOR.'frontendUrlManager.php';

        if(isset(Yii::app()->params['url_manager_bckp']))
            $this->url_manager_bckp = $this->data_dir . DIRECTORY_SEPARATOR . Yii::app()->params['url_manager_bckp'];
        else
            $this->url_manager_bckp = $this->data_dir . DIRECTORY_SEPARATOR . 'frontendUrlManager.php.bckp';

        if(isset(Yii::app()->params['write_backup']))
            $this->write_backup = Yii::app()->params['write_backup'];

        if(isset(Yii::app()->params['multi_language']))
            $this->multi_language = Yii::app()->params['multi_language'];
    }

    public function sort($a,$b)
    {
        $a_s=substr_count($a['name'],'/');
        $b_s=substr_count($b['name'],'/');
        if ($a_s==$b_s)
        {
            return 0;
        }
        return ($a_s < $b_s) ? 1 : -1;
    }

    /**
     * Создает урл менджер по конфигу
     * @throws Exception
     */

    public function generateUrlManager()
    {
        $config = $this->getUrlManagerConfig();

        if ($this->multi_language)
        {
            $languages=CHtml::listData(Language::getLanguageNotDefult(),'id','code');

            $language_str='';
            foreach($languages as $lang)
            {
                $language_str.=$lang;
            }
        }

        usort($config['structure'],array($this,'sort')); //сортируем, чтобы разрешить конфликт

        $content = "<?php return array(\n";

        //формируем урлы модулей, привязанных к структуре

        foreach($config['structure'] as $struct)
        {
            if(isset($struct['module_name'], $config['module_urls'][$struct['module_name']]) )
            {
                foreach($config['module_urls'][$struct['module_name']] as $key => $val)
                {
                    $content .= '"'.(($this->multi_language==true && isset($languages[$struct['language']])) ? '<language:'.$languages[$struct['language']].'>/' : '').$struct['name'].$key.'" => "'.$val.'",' . "\n";
                }
            }
        }

        if(isset($config['module_urls']['site']))
        {
            //записываем глобальные урлы сайта

            foreach($config['module_urls']['site'] as $key=>$val)
            {
                $content .= '"'.$key.'" => "'.$val.'",' . "\n";
                if ($this->multi_language)
                {
                    $content .= '"<language:('.$language_str.')>/'.$key.'" => "'.$val.'",' . "\n";
                }
            }
        }

        $content .= ");\n?>";

        //создаем файл урл менеджера с бекапом

        $this->createFile($content,$this->url_manager,$this->url_manager_bckp);
    }

    /**
     * Добавляет урлы модуля с привязкой к структуре в урл менеджер
     * @param $id_struct - id структуры
     * @param $struct_name - имя структуры
     * @param $module_name - имя модуля
     */

    public function addModuleToStruct($id_struct,$struct_name,$module_name)
    {
        $config = $this->getUrlManagerConfig();

        $this->addToConfigStuctureModule($config,$id_struct,Yii::app()->controller->getCurrentLanguage()->id,$struct_name,$module_name);

        $this->generateUrlManagerConfig($config);
        $this->generateUrlManager();
    }

    public function addToConfigStuctureModule(&$config,$id_struct,$langauge_id,$struct_name,$module_name)
    {
        $class = $this->class_structure;
        $child = $class::model()->findByPk($id_struct);
        $parents = $child->ancestors()->findAll();

        $url = '';
        $str_parents = array();

        if (!empty($parents))
        {
            array_shift($parents); //убрали root;
//            $parents = array_reverse($parents);

            foreach($parents as $parent)
            {
                $url.=$parent->name.'/';
                $config['structure'][$parent->id]['name'] = $url;
                $config['structure'][$parent->id]['children'][$id_struct] = $module_name;
                $config['structure'][$parent->id]['language'] = $langauge_id;
                $str_parents[] = $parent->id;
            }
        }
        $url.=$struct_name.'/';
        $config['structure'][$id_struct] = array('name' => $url, 'module_name' => $module_name, 'parents' => $str_parents, 'language' => $langauge_id);
    }

    /**
     * Удаляет модуль из структуры
     * @param $id_struct - id структуры
     */

    public function deleteModuleFromStruct($id_struct)
    {
        $config = $this->getUrlManagerConfig();

        if (empty($config['structure'][$id_struct]['children']))
        {
            unset($config['structure'][$id_struct]);
        }
        else
        {
            unset($config['structure'][$id_struct]['module_name']);
        }

        $this->generateUrlManagerConfig($config);
        $this->generateUrlManager();
    }


    /**
     * меняет имя структуры в урл менеджере
     * @param $id_struct
     * @param $name
     * @return bool
     */
    public function changeStructName($id_struct,$name)
    {
        $config = $this->getUrlManagerConfig();

        if(isset($config['structure'][$id_struct]))
        {
            $config['structure'][$id_struct]['name'] = $name;

            if (!empty($config['structure'][$id_struct]['children']))
            {
                foreach($config['structure'][$id_struct]['children'] as $key=>$module)
                {
                    $config['structure'][$key]['name'];
                }
            }

            $this->generateUrlManagerConfig($config);
            $this->generateUrlManager();

            return true;
        }
        return false;

    }


    /**
     * Обновляет урлы модулей в конфиге урл менеджера
     */

    public function refreshModuleUrls()
    {
        $config = $this->getUrlManagerConfig();

        $config['module_urls'] = $this->getModuleUrls();

        $this->generateUrlManagerConfig($config);
        $this->generateUrlManager();
    }


    /**
     * Пересобирает урл менеджер с привязкой модулей из базы данных
     */
    public function recompileUrlManger()
    {
        $this->generateUrlManagerConfig();
        $config = $this->getUrlManagerConfig();

        $scope_structure=array(
            'scopes'=>'active',
            'joinType'=>'INNER JOIN',
            'with'=>'language',
        );

        if (!$this->multi_language) // если не мулти то добавить еще scope
        {
            $language_id=Yii::app()->controller->getCurrentLanguage()->id;
            $scope_structure['scopes']=array(
                    'active',
                    'language'=>array(
                        'language_id'=>$language_id,
                    )
            );
        }

        $struct_modules = StructureModules::model()->with(
                                                        array(
                                                                'structure'=>$scope_structure,
                                                                'module'
                                                        )
                                                        )->findAll();

        foreach($struct_modules as $sm)
        {
            $this->addToConfigStuctureModule($config,$sm->structure->id,$sm->structure->language->id,$sm->structure->name,$sm->module->name);
        }

        $this->generateUrlManagerConfig($config);
        $this->generateUrlManager();
    }

    /**
     * Генерирует файл конфига урл менеджера
     * @param $config
     * @throws InvalidArgumentException
     */

    private function generateUrlManagerConfig($config = false)
    {
        if(!$config)//если нет конфига, генерируем начальный конфиг
        {
            //считываем конфиги урлов модулей
            $module_urls = $this->getModuleUrls();

            //структура конфига для генерации урл менеджера
            $config = array('module_urls'=>$module_urls,'structure'=>array());
        }

        $config = json_encode($config);
        if(!$config) throw new  InvalidArgumentException('JSON compile error');

        //создаем файл конфига с бекапом
        $this->createFile($config,$this->url_manager_config,$this->url_manager_config_bckp);
    }


    /**
     * Возвращает массив из файла конфига урл менеджера
     * @return mixed
     * @throws Exception
     */
    private function getUrlManagerConfig()
    {
        if(!file_exists($this->url_manager_config))
        {
            $this->generateUrlManagerConfig();
        }
        $config = json_decode(file_get_contents($this->url_manager_config),true);
        if(!$config) throw new Exception('Error decode file config '. $this->url_manager_config);

        return $config;
    }


    /**
     * Возврашает урлы модулей из конфига модуля
     * @return array
     */
    private function getModuleUrls()
    {
        //считываем конфиги урлов модулей
        $module_url = array();

        if ($handle = opendir( $this->module_config_dir))
        {
            while (false !== ($entry = readdir($handle)))
            {
                if($entry != '.' && $entry != '..')
                {
                    $filename = explode('.',$entry);

                    $module_config = include  $this->module_config_dir.DIRECTORY_SEPARATOR.$entry;
                    $module_url[$filename[0]] = isset($module_config['urlManager']) ? $module_config['urlManager'] : array();//если нет конфига урлов, в урл менеджер ничего запишется, но и не сломается
                }
            }
            closedir($handle);
        }

        return $module_url;
    }


    private function createFile($data,$file_orig,$file_backup)
    {
        //создаем бекап старого файла
        if($this->write_backup)
            $this->createBackup($file_orig,$file_backup);

        $file = fopen($file_orig, 'w');
        if(fwrite($file, $data))
        {
            fclose($file);
        }
        else
        {
            throw new  Exception('Error writing to file '.$file_orig);
        }
    }


    private function createBackup($file_orig,$file_backup)
    {
        //создаем бекап старого урлменеджера
        if(file_exists($file_orig))
        {
            $url_manager_backup = fopen($file_backup, 'a+');
            fwrite($url_manager_backup, strftime( '%d.%m.%Y %H:%M:%S' )."\n");
            fwrite($url_manager_backup, file_get_contents($file_orig));
            fwrite($url_manager_backup, "\n\n\n");
            fclose($url_manager_backup);
        }
    }

    public function getStructIdForRule($module, $name)
    {
        if (!file_exists($this->url_manager_config))
        {
            $this->recompileUrlManger();
        }

        $config=json_decode(file_get_contents($this->url_manager_config),true);

        $languages=array();

        if (!empty($config['structure']))
        {
            if ($this->multi_language) //еслиу включен подгурзить языки
            {
               $languages = CHtml::listData(Language::getLanguageNotDefult(), 'id', 'code');
            }

            foreach($config['structure'] as $key=>$structure)
            {
                if (preg_match('/' . str_replace('/', '\/', (isset($languages[$structure['language']]) ? $languages[$structure['language']] . '/' : '') . $structure['name']) . '/', $name . '/'))
                {
                    if (isset($structure['module_name']) && $module == $structure['module_name'])
                    {
                        return $key;
                    }
                    continue;
                }
            }
        }
    }
} 