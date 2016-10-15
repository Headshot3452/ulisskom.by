<?php
    class Core
    {
        public static function clearTempDir()
        {
            $time = time();
            $time_clear = 12*3600;

            if(!is_dir('data/temp/'))
            {
                mkdir('data/temp/');
            }

            if(!is_dir('data/temp/chunks/'))
            {
                mkdir('data/temp/chunks/');
            }

            $paths = array('data/temp/', 'data/temp/chunks/');

            foreach ($paths as $path)
            {
                $files = scandir($path);
                foreach ($files as $file)
                {
                    $temp_file = $path.$file;
                    if (is_file($temp_file))
                    {
                        if (($time - filemtime($temp_file)) > $time_clear)
                        {
                            unlink($temp_file);
                        }
                    }
                }
            }
        }

        public static function cutString($str, $length)
        {
            mb_internal_encoding("UTF-8");

            if(mb_strlen($str) > $length)
            {
                return mb_substr($str,0,$length).'...';
            }

            return $str;
        }

        public static function translit($text)
        {
            $converter = array(
                'а' => 'a',   'б' => 'b',   'в' => 'v',
                'г' => 'g',   'д' => 'd',   'е' => 'e',
                'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
                'и' => 'i',   'й' => 'y',   'к' => 'k',
                'л' => 'l',   'м' => 'm',   'н' => 'n',
                'о' => 'o',   'п' => 'p',   'р' => 'r',
                'с' => 's',   'т' => 't',   'у' => 'u',
                'ф' => 'f',   'х' => 'h',   'ц' => 'c',
                'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
                'ь' => '',    'ы' => 'y',   'ъ' => '',
                'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

                'А' => 'A',   'Б' => 'B',   'В' => 'V',
                'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
                'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
                'И' => 'I',   'Й' => 'Y',   'К' => 'K',
                'Л' => 'L',   'М' => 'M',   'Н' => 'N',
                'О' => 'O',   'П' => 'P',   'Р' => 'R',
                'С' => 'S',   'Т' => 'T',   'У' => 'U',
                'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
                'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
                'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
                'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
            );
            return strtr($text, $converter);
        }

        public static function strToUrl($text)
        {
            $text = self::translit(trim($text));
            $text = strtolower($text);
            $converter = array( '   ' => '-',   '  ' => '-',  ' ' => '-',);
            $text = strtr($text,$converter);
            $text = preg_replace('/[^a-z0-9_-]/u', '', $text);
            return $text;
        }

        public static function randomString($length = 32)
        {
            $chars = "abcdefghijkmnopqrstuvwxyz023456789";
            srand((double)microtime()*1000000);
            $i = 1;
            $string = '' ;

            while ($i <= $length)
            {
                $num = rand() % 33;
                $tmp = substr($chars, $num, 1);
                $string .= $tmp;
                $i++;
            }
            return $string;
        }

        public static function sendAdminMessage($email,$message,$subject)
        {
            $settings = Settings::getSettings(Yii::app()->params['settings_id']);

            self::sendMessage($settings->email, $subject, $message, $email);
        }

        public static function sendFromAdminMessage($email,$message,$subject)
        {
            $settings = Settings::getSettings(Yii::app()->params['settings_id']);
            self::sendMessage($email, $subject, $message, $settings->email);
        }

        public static function sendMessage($to, $subject, $message, $from, $html = true)
        {
            $mail = Yii::app()->mailer->isHtml($html)->setFrom($from);

            $mail->send($to, $subject, $message);
        }

        /**
         * Выгружаем конфиг модуля по названию
         * @param $module
         * @param null $path
         * @return mixed
         * @throws CException
         */

        public static function getConfigForModule($module,$path=null)
        {
            $config = array();

            if ($path !== null)
            {
            }
            elseif(isset(Yii::app()->params['urlManagerGenerator']['module_config_dir']))
            {
                $path = Yii::getPathOfAlias(Yii::app()->params['urlManagerGenerator']['module_config_dir']);
            }
            else
            {
                throw new CException('Not found module config');
            }

            $file = $path .DIRECTORY_SEPARATOR. $module.'.php';
            if (file_exists($file))
            {
                return $config = include $file;
            }
        }

        /**
         * Метод для построения дерева
         * @param $array - входной массив
         * @param string $field - поле по которому выстраивается иерархия
         * @param string $items_key - ключ массива для дочерних элементов
         * @return array
         */

        public static function getTreeForField($array, $field='parent_id', $items_key = 'children')
        {
            $result = array();
            $stack = array();
            foreach($array as $item)
            {
                if (!isset($stack[$item['id']])) //если нет в стэки добовляем
                {
                    $stack[$item['id']] = array($items_key => array());
                }

                if (is_object($item))
                {
                    $stack[$item['id']]['item'] = $item;
                }
                else
                {
                    $stack[$item['id']] = array_merge($stack[$item['id']], $item);
                }

                if (!is_null($item[$field]))
                {
                    $parent_id = $item[$field];
                    if (!isset($stack[$parent_id])) //нет в стэке родителя то создать
                    {
                        $stack[$parent_id] = array($items_key => array());
                    }
                    $stack[$parent_id][$items_key][] = &$stack[$item['id']];
                }
                else
                {
                    $parent_id = $item['id'];
                    $result[] = &$stack[$parent_id]; //корни в результат
                }
            }
            return $result;
        }
    }
?>
