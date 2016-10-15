<?php
    class FileUploadBehavior extends ActiveRecordBehavior
    {
        public $files_attr_name = 'item_file'; //attr_items
        public $files_attr_model = 'files'; //attr_model
        public $path = '/data/';
        public $max_files = 10;
        public $find_path = false; //свойство указывает какой метод вызвать у $owner для получения пути к папке

        public function beforeSave($event)
        {
            $owner = $this->getOwner();
            $files = $owner->{$this->files_attr_name};

            $oldFiles = $this->getFiles();
            $array = array();
            $i = 1;

    //        Добавлена проверка на массив, т.к. иногда приходила строка(если не было изображений)

            if (!empty($files) && is_array($files))
            {
                foreach ($files as $file)
                {
                    if ($this->max_files !== null && $this->max_files >= $i)
                    {
                        if (!isset($oldFiles[$file]))
                        {
                            try
                            {
                                if (($data = $this->saveFile($file)) !== null)
                                {
                                    $array[] = $data;
                                }
                            }
                            catch(CException $e)
                            {
                                $owner->addError($this->files_attr_model, Yii::t('app', 'Directory "{path}" not found', array('path' => $e->getMessage())));
                            }
                        }
                        else
                        {
                            $array[] = $oldFiles[$file];
                            unset($oldFiles[$file]);
                        }
                    }
                    else
                    {
                         $this->deleteFile($file);
                    }
                    $i++;
                }
            }
            if (!empty($oldFiles))
            {
                foreach($oldFiles as $file)
                {
                    $this->deleteFile($file['path'].$file['name']);
                }
            }

            if(empty($files) && !empty($oldFiles))
            {
                if($owner->scenario == 'update_status' || $owner->scenario == 'settings_user')
                {
                    $item = isset($owner->avatar) ? $owner->avatar : $owner->images;

                    $owner->{$this->files_attr_model} = $item;
                    $owner->{$this->files_attr_name} = $item;
                }
            }
            else
            {
                $owner->{$this->files_attr_model} = serialize($array);
                $owner->{$this->files_attr_name} = serialize($array);
            }
        }

        public function getFilesAttrName()
        {
            return $this->files_attr_name;
        }

        public function getFiles()
        {
            $owner=$this->getOwner();

            $array=array();

            if (($files = unserialize($owner->{$this->files_attr_model})))
            {
                if (!empty($files))
                {
                    foreach ($files as $file)
                    {
                        $array[$file['path'].$file['name']] = $file;
                    }
                }
            }
            return $array;
        }

        public function saveFile($file)
        {
            $owner = $this->getOwner();

            if (file_exists($file))
            {
                $ext = substr(strrchr($file,'.'), 1);
                $name = uniqid().'.'.$ext;

                if (!is_dir($this->path))
                {
                    if (!mkdir($this->path, 0775, true))
                    {
                        throw new CException($this->path);
                    }
                }

                if ($this->find_path !== false)
                {
                    $method = $this->find_path;
                    $this->path = $owner->$method();
                }

                if (copy($file, $this->path.$name))
                {
                    $this->deleteFile($file);
                    return array('path' => $this->path, 'name' => $name);
                }
            }
        }

        public function deleteFile($file)
        {
            if (file_exists($file))
            {
                unlink($file);
            }
        }

        public function getOneFile($size='')
        {
            $file='';

            $files=$this->getFiles();
            $keys=array_keys($files);
            if (!empty($keys))
            {
                if ($size=='')
                {
                    $file=$keys[0];
                }
                else
                {
                    $file=$files[$keys[0]]['path'].$size.'/'.$files[$keys[0]]['name'];
                }
            }
            return $file;
        }
    }
