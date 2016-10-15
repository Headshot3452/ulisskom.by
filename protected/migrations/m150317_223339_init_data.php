<?php
    class m150317_223339_init_data extends CDbMigration
    {
        public function up()
        {
            //Users

            $this->insert('users',
                array(
                    'email' => 'iwl@iwl.by',
                    'login' => 'iwl',
                    'password' => '$2y$13$1ndZXFYXTTdzxKJDhefIs.Lhxm0.JiEWrx8KA8iwfhrTJSqn7z4x6',
                    'role' => '1',
                    'avatar' => 'a:0:{}',
                    'status' => '1',
                )
            );

            $this->insert('users',
                array(
                    'email' => 'admin@admin.admin',
                    'login' => 'admin',
                    'password' => '$2y$13$weh102WJJ96QO76TMP2QwOObmJcjBB/dAYGO95nMshqVTkbvtxgd.',
                    'role' => '2',
                    'avatar' => 'a:0:{}',
                    'status' => '1',
                )
            );

            $this->insert('user_info',
                array(
                    'user_id' => '0000000002',
                    'name' => 'Администратор',
                    'last_name' => 'Администратор',
                    'status' => '1',
                )
            );

            //Language

            $this->insert('language',
                array(
                    'title' => 'Русский',
                    'code' => 'ru',
                    'status' => '1',
                )
            );

            $this->insert('language',
                array(
                    'title' => 'English',
                    'code' => 'en',
                    'status' => '2',
                )
            );

            //Modules

            $this->insert("modules",
                array(
                    "id" => "1",
                    "model" => "Structure",
                    "title" => "Структура",
                    "name" => "structure",
                    "files" => "structure.png",
                    "private" => "1",
                    "status" => "1",
                    "on_main" => "1",
                    "common" => "1",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "2",
                    "model" => "Menu",
                    "title" => "Меню",
                    "name" => "menu",
                    "files" => "menu.png",
                    "private" => "1",
                    "status" => "1",
                    "on_main" => "1",
                    "common" => "1",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "3",
                    "model" => "NewsTree",
                    "title" => "Новости, акции, статьи",
                    "name" => "news",
                    "files" => "news.png",
                    "private" => "0",
                    "status" => "1",
                    "on_main" => "1",
                    "common" => "1",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "4",
                    "model" => "SettingsCurrency",
                    "title" => "Валюта",
                    "name" => "settings/currency/",
                    "files" => "currency.png",
                    "private" => "1",
                    "status" => "1",
                    "on_main" => "1",
                    "common" => "0",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "5",
                    "model" => "Banners",
                    "title" => "Баннеры",
                    "name" => "promotions",
                    "files" => "banners.png",
                    "private" => "1",
                    "status" => "1",
                    "on_main" => "0",
                    "common" => "1",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "6",
                    "model" => "Blocks",
                    "title" => "Блоки",
                    "name" => "blocks",
                    "files" => "blocks.png",
                    "private" => "1",
                    "status" => "1",
                    "on_main" => "0",
                    "common" => "1",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "7",
                    "model" => "CatalogTree",
                    "title" => "Каталог",
                    "name" => "catalog",
                    "files" => "catalog.png",
                    "private" => "0",
                    "status" => "1",
                    "on_main" => "1",
                    "common" => "1",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "8",
                    "model" => "GalleryTree",
                    "title" => "Фотогалерея",
                    "name" => "gallery",
                    "files" => "gallery.png",
                    "private" => "1",
                    "status" => "1",
                    "on_main" => "0",
                    "common" => "1",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "9",
                    "model" => "Maps",
                    "title" => "Карты",
                    "name" => "maps",
                    "files" => "contacts.png",
                    "private" => "1",
                    "status" => "1",
                    "on_main" => "0",
                    "common" => "1",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "10",
                    "model" => "Orders",
                    "title" => "Заказы",
                    "name" => "orders",
                    "files" => "clients.png",
                    "private" => "1",
                    "status" => "1",
                    "on_main" => "0",
                    "common" => "1",
                 )
            );

            $this->insert("modules",
                array(
                    "id" => "11",
                    "model" => "Slider",
                    "title" => "Слайдер",
                    "name" => "slider",
                    "files" => "slider.png",
                    "private" => "1",
                    "status" => "1",
                    "on_main" => "0",
                    "common" => "1",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "12",
                    "model" => "AskAnswer",
                    "title" => "Вопрос ответ",
                    "name" => "askanswer",
                    "files" => "askanswer.png",
                    "private" => "1",
                    "status" => "1",
                    "on_main" => "0",
                    "common" => "1",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "13",
                    "model" => "Feedback",
                    "title" => "Обратная связь",
                    "name" => "feedback",
                    "files" => "feedback.png",
                    "private" => "1",
                    "status" => "1",
                    "on_main" => "1",
                    "common" => "1",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "14",
                    "model" => "Users",
                    "title" => "Пользователи",
                    "name" => "settings/permission/",
                    "files" => "all_users.png",
                    "private" => "1",
                    "status" => "1",
                    "on_main" => "1",
                    "common" => "0",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "15",
                    "model" => "Settings",
                    "title" => "Базовые настройки сайта",
                    "name" => "settings/basicSettings/",
                    "files" => "base-settings.png",
                    "private" => "1",
                    "status" => "1",
                    "on_main" => "0",
                    "common" => "0",
                )
            );

            $this->insert("modules",
                array(
                    "id" => "16",
                    "model" => "ReviewItem",
                    "title" => "Отзывы",
                    "name" => "review",
                    "files" => "reviews.png",
                    "private" => "0",
                    "status" => "1",
                    "on_main" => "1",
                    "common" => "1",
                )
            );

            $this->insert("modules",
                array(
                    "id"=>"17",
                    "model"=>"Feedback",
                    "title"=>"Контакты",
                    "name"=>"contacts",
                    "files"=>"contacts.png",
                    "private"=>"0",
                    "status"=>"1",
                    "on_main" => "0",
                    "common" => "1",
                )
            );

            $this->insert("modules",
                array(
                    "id"=>"18",
                    "model"=>"Blog",
                    "title"=>"Блог",
                    "name"=>"blog",
                    "files"=>"contacts.png",
                    "private"=>"1",
                    "status"=>"1",
                    "on_main" => "0",
                    "common" => "1",
                )
            );

            //Widgets

            $this->insert("widgets",
                array(
                    "module_id" => "3",
                    "title" => "Баннер",
                    "name" => "BannerDescriptionWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            $this->insert("widgets",
                array(
                    "module_id" => "4",
                    "title" => "Текстовый блок",
                    "name" => "BlockWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            $this->insert("widgets",
                array(
                    "module_id" => "6",
                    "title" => "Карусель изображений фотогалереи",
                    "name" => "CarouselGalleryWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            $this->insert("widgets",
                array(
                    "module_id" => "5",
                    "title" => "Карусель акционных товаров каталога",
                    "name" => "CarouselProductsWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            $this->insert("widgets",
                array(
                    "module_id" => "5",
                    "title" => "Уровень каталога с разделами и товарами",
                    "name" => "CatalogTreeViewWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            $this->insert("widgets",
                array(
                    "module_id" => "5",
                    "title" => "Дерево разделов",
                    "name" => "CatalogTreeWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            $this->insert("widgets",
                array(
                    "module_id" => "2",
                    "title" => "Последние статьи",
                    "name" => "LastArticlesWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            $this->insert("widgets",
                array(
                    "module_id" => "7",
                    "title" => "Карта",
                    "name" => "MapWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            $this->insert("widgets",
                array(
                    "module_id" => "8",
                    "title" => "Меню",
                    "name" => "MenuWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            $this->insert("widgets",
                array(
                    "module_id" => "1",
                    "title" => "Последние новости",
                    "name" => "NewsLastWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            $this->insert("widgets",
                array(
                    "module_id" => "10",
                    "title" => "Слайдер",
                    "name" => "SliderWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            $this->insert("widgets",
                array(
                    "module_id" => "16",
                    "title" => "Отзывы",
                    "name" => "ReviewWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            $this->insert("widgets",
                array(
                    "module_id" => "13",
                    "title" => "Обратная связь",
                    "name" => "FeedbackWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            $this->insert("widgets",
                array(
                    "module_id" => "12",
                    "title" => "Поиск вопроса",
                    "name" => "AskAnswerSearchWidget",
                    "private" => "0",
                    "status" => "1",
                )
            );

            //Каталог

            $this->insert("catalog_tree",
                array(
                    "id" => "1",
                    "lft" => "1",
                    "rgt" => "2",
                    "level" => "1",
                    "language_id" => "1",
                    "title" => "Каталог",
                    "name" => "catalog",
                    "status" => "1",
                    "root" => "1",
                )
            );

            $this->insert("catalog_tree",
                array(
                    "id" => "2",
                    "lft" => "1",
                    "rgt" => "2",
                    "level" => "1",
                    "language_id" => "2",
                    "title" => "Catalog",
                    "name" => "catalog",
                    "status" => "1",
                    "root" => "1",
                )
            );
        }

        public function down()
        {
            echo "m150317_223339_init_data does not support migration down.\n";
            return true;
        }
    }