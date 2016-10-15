<?php
    class m140915_191731_initial extends CDbMigration
    {
        public function up()
        {
            $this->createTable('banners',
                array(
                    'id' => 'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                    'language_id' => 'int(10) unsigned DEFAULT NULL',
                    'title' => 'varchar(128) NOT NULL',
                    'url' => 'varchar(255) NOT NULL',
                    'image' => 'text NOT NULL',
                    'status' => 'tinyint(4) NOT NULL',
                ),
                'ENGINE = InnoDB'
            );

            $this->createTable('catalog_params', array(
                'id' => 'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'catalog_tree_id' => 'int(11) unsigned NOT NULL',
                'parent_id' => 'int(11) unsigned DEFAULT NULL',
                'title' => 'varchar(255) NOT NULL',
                'type' => 'tinyint(1) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('catalog_params_val',
                array(
                    'id' => 'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                    'params_id' => 'int(11) unsigned NOT NULL',
                    'value' => 'varchar(255) NOT NULL',
                    'sort' => 'int(11) NOT NULL',
                ),
                'ENGINE = InnoDB'
            );

            $this->createTable('catalog_products', array(
                'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'parent_id'=>'int(11) unsigned DEFAULT NULL',
                'language_id'=>'int(11) unsigned DEFAULT NULL',
                'seo_title'=>'varchar(255) NOT NULL',
                'seo_keywords'=>'varchar(255) NOT NULL',
                'seo_description'=>'text NOT NULL',
                'price'=>'float NOT NULL',
                'images'=>'text NOT NULL',
                'title'=>'varchar(255) NOT NULL',
                'name'=>'varchar(255) NOT NULL',
                'text'=>'text NOT NULL',
                'create_time'=>'int(11) unsigned DEFAULT NULL',
                'update_time'=>'int(11) unsigned DEFAULT NULL',
                'status'=>'tinyint(4) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('catalog_products_params', array(
                'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'product_id'=>'int(11) unsigned NOT NULL',
                'params_id'=>'int(11) unsigned NOT NULL',
                'value_id'=>'int(11) unsigned NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('catalog_tree',
                array(
                    'id' => 'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                    'lft' => 'int(11) NOT NULL',
                    'rgt' => 'int(11) NOT NULL',
                    'level' => 'int(11) NOT NULL',
                    'language_id' => 'int(11) unsigned DEFAULT NULL',
                    'icon' => 'text NOT NULL',
                    'seo_title' => 'varchar(255) NOT NULL',
                    'seo_keywords' => 'varchar(255) NOT NULL',
                    'seo_description' => 'text NOT NULL',
                    'title' => 'varchar(255) NOT NULL',
                    'name' => 'varchar(255) NOT NULL',
                    'text' => 'text NOT NULL',
                    'create_time' => 'int(11) unsigned DEFAULT NULL',
                    'update_time' => 'int(11) unsigned DEFAULT NULL',
                    'status' => 'tinyint(4) NOT NULL',
                    'type' => 'tinyint(4) NOT NULL',
                    'root' => 'int(11) unsigned DEFAULT NULL',
                ),
                'ENGINE = InnoDB'
            );

            $this->createTable('gallery', array(
                'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'language_id'=>'int(10) unsigned DEFAULT NULL',
                'title'=>'varchar(255) NOT NULL',
                'status'=>'tinyint(4) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('gallery_images', array(
                'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'gallery_id'=>'int(11) unsigned NOT NULL',
                'title'=>'varchar(255) NOT NULL',
                'description'=>'text NOT NULL',
                'images'=>'text NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('language', array(
                'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'title'=>'varchar(255) NOT NULL',
                'code'=>'varchar(50) NOT NULL',
                'status'=>'tinyint(4) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('menu_item', array(
                'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'menu_id'=>'int(11) unsigned NOT NULL',
                'structure_id'=>'int(11) unsigned NOT NULL',
                'title'=>'varchar(128) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('modules',
                array(
                    'id' => 'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                    'model' => 'varchar(50) NOT NULL',
                    'title' => 'varchar(255) NOT NULL',
                    'version' => 'varchar(255) NOT NULL',
                    'info' => 'text NOT NULL',
                    'name' => 'varchar(255) NOT NULL',
                    'files' => 'text NOT NULL',
                    'private' => 'tinyint(1) NOT NULL',
                    'status' => 'tinyint(1) NOT NULL',
                    'on_main' => 'tinyint(1) NOT NULL',
                    'common' => 'tinyint(1) NOT NULL',
                ),
                'ENGINE = InnoDB'
            );

            $this->createTable('news', array(
                'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'language_id'=>'int(11) unsigned DEFAULT NULL',
                'seo_title'=>'varchar(255) NOT NULL',
                'seo_keywords'=>'varchar(255) NOT NULL',
                'seo_description'=>'text NOT NULL',
                'title'=>'varchar(255) NOT NULL',
                'name'=>'varchar(255) NOT NULL',
                'time'=>'int(11) unsigned DEFAULT NULL',
                'preview'=>'text NOT NULL',
                'text'=>'text NOT NULL',
                'images'=>'text NOT NULL',
                'create_time'=>'int(11) unsigned DEFAULT NULL',
                'update_time'=>'int(11) unsigned DEFAULT NULL',
                'author_id'=>'int(11) unsigned NOT NULL',
                'status'=>'tinyint(4) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('settings', array(
                'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'otdel'=>'varchar(20) NOT NULL',
                'mts'=>'varchar(20) NOT NULL',
                'velcom'=>'varchar(20) NOT NULL',
                'fax'=>'varchar(20) NOT NULL',
                'street'=>'varchar(200) NOT NULL',
                'skype'=>'varchar(100) NOT NULL',
                'vk'=>'varchar(100) NOT NULL',
                'email'=>'varchar(50) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('slider', array(
                'id'=>'int(10) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'language_id'=>'int(10) unsigned DEFAULT NULL',
                'title'=>'varchar(128) NOT NULL',
                'status'=>'tinyint(4) NOT NULL DEFAULT \'1\'',
            ), 'ENGINE=InnoDB');

            $this->createTable('slider_images', array(
                'id'=>'int(10) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'slider_id'=>'int(10) unsigned NOT NULL',
                'title'=>'varchar(128) NOT NULL',
                'description'=>'text NOT NULL',
                'url'=>'varchar(255) NOT NULL',
                'image'=>'text NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('structure', array(
                'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'lft'=>'int(11) NOT NULL',
                'rgt'=>'int(11) NOT NULL',
                'level'=>'int(11) NOT NULL',
                'root'=>'int(11) NOT NULL',
                'language_id'=>'int(11) unsigned DEFAULT NULL',
                'seo_title'=>'varchar(255) NOT NULL',
                'seo_keywords'=>'varchar(255) NOT NULL',
                'seo_description'=>'text NOT NULL',
                'title'=>'varchar(255) NOT NULL',
                'name'=>'varchar(255) NOT NULL',
                'text'=>'text NOT NULL',
                'layout'=>'varchar(100) NOT NULL',
                'create_time'=>'int(11) DEFAULT NULL',
                'update_time'=>'int(11) DEFAULT NULL',
                'author_id'=>'int(11) unsigned NOT NULL',
                'system'=>'tinyint(1) NOT NULL',
                'status'=>'tinyint(4) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('structure_modules', array(
                'id'=>'int(10) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'structure_id'=>'int(10) unsigned NOT NULL',
                'module_id'=>'int(10) unsigned NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('structure_widgets', array(
                'id'=>'int(10) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'structure_id'=>'int(11) unsigned NOT NULL',
                'widget_id'=>'int(11) unsigned NOT NULL',
                'block'=>'varchar(50) NOT NULL',
                'settings'=>'text NOT NULL',
                'sort'=>'int(11) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('text_blocks', array(
                'id'=>'int(10) unsigned NOT NULL',
                'language_id'=>'int(11) unsigned DEFAULT NULL',
                'title'=>'text NOT NULL',
                'text'=>'text NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('users', array(
                'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'login'=>'varchar(50) NOT NULL',
                'password'=>'varchar(60) NOT NULL',
                'email'=>'varchar(100) NOT NULL',
                'role'=>'int(11) NOT NULL',
                'avatar'=>'text NOT NULL',
                'create_time'=>'int(10) unsigned DEFAULT NULL',
                'update_time'=>'int(11) unsigned DEFAULT NULL',
                'status'=>'tinyint(4) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('users_check_action', array(
                'id'=>'int(10) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'user_id'=>'int(10) unsigned NOT NULL',
                'type_action'=>'tinyint(3) unsigned NOT NULL',
                'hash'=>'varchar(32) NOT NULL',
                'time'=>'int(11) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createTable('users_sessions', array(
                'id'=>'char(32) NOT NULL',
                'user_id'=>'int(11) unsigned NOT NULL',
                'expire'=>'int(11) DEFAULT NULL',
                'data'=>'longblob DEFAULT NULL',
            ), 'ENGINE=InnoDB');

            $this->addPrimaryKey('pk_users_sessions', 'users_sessions', 'id');

            $this->createTable('widgets', array(
                'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
                'module_id'=>'int(10) unsigned NOT NULL',
                'title'=>'varchar(255) NOT NULL',
                'settings'=>'text NOT NULL',
                'private'=>'tinyint(1) NOT NULL',
                'status'=>'tinyint(1) NOT NULL',
            ), 'ENGINE=InnoDB');

            $this->createIndex('status_idx', 'banners', 'status' );
            $this->createIndex('language_id_idx', 'banners', 'language_id' );
            $this->createIndex('catalog_tree_id_idx', 'catalog_params', 'catalog_tree_id' );
            $this->createIndex('parent_id_idx', 'catalog_params', 'parent_id' );
            $this->createIndex('params_id_idx', 'catalog_params_val', 'params_id' );
            $this->createIndex('parent_id_idx', 'catalog_products', 'parent_id' );
            $this->createIndex('language_id_idx', 'catalog_products', 'language_id,name,status' );
            $this->createIndex('create_time_idx', 'catalog_products', 'create_time,update_time' );
            $this->createIndex('status_idx', 'catalog_products', 'status' );
            $this->createIndex('product_id_idx', 'catalog_products_params', 'product_id' );
            $this->createIndex('params_id_idx', 'catalog_products_params', 'params_id' );
            $this->createIndex('value_id_idx', 'catalog_products_params', 'value_id' );
            $this->createIndex('lft_idx', 'catalog_tree', 'lft,rgt,level' );
            $this->createIndex('status_idx', 'catalog_tree', 'status' );
            $this->createIndex('name_idx', 'catalog_tree', 'name' );
            $this->createIndex('language_id_idx', 'catalog_tree', 'language_id,name' );
            $this->createIndex('create_time_idx', 'catalog_tree', 'create_time,update_time' );
            $this->createIndex('status_idx', 'gallery', 'status' );
            $this->createIndex('language_id_idx', 'gallery', 'language_id' );
            $this->createIndex('gallery_id_idx', 'gallery_images', 'gallery_id' );
            $this->createIndex('menu_id_idx', 'menu_item', 'menu_id' );
            $this->createIndex('structure_id_idx', 'menu_item', 'structure_id' );
            $this->createIndex('language_id_idx', 'news', 'language_id,name,author_id,status' );
            $this->createIndex('create_time_idx', 'news', 'create_time,update_time' );
            $this->createIndex('author_id_idx', 'news', 'author_id' );
            $this->createIndex('status_idx', 'news', 'status' );
            $this->createIndex('time_idx', 'news', 'time' );
            $this->createIndex('update_time_idx', 'news', 'update_time' );
            $this->createIndex('status_idx', 'slider', 'status' );
            $this->createIndex('language_id_idx', 'slider', 'language_id' );
            $this->createIndex('slider_id_idx', 'slider_images', 'slider_id' );
            $this->createIndex('name_idx', 'structure', 'name' );
            $this->createIndex('language_id_idx', 'structure', 'language_id,name' );
            $this->createIndex('author_id_idx', 'structure', 'author_id' );
            $this->createIndex('lft_idx', 'structure', 'lft,rgt,level' );
            $this->createIndex('status_idx', 'structure', 'status' );
            $this->createIndex('create_time_idx', 'structure', 'create_time,update_time' );
            $this->createIndex('structure_id_idx', 'structure_modules', 'structure_id,module_id' );
            $this->createIndex('module_id_idx', 'structure_modules', 'module_id' );
            $this->createIndex('structure_id_idx', 'structure_widgets', 'structure_id' );
            $this->createIndex('widget_id_idx', 'structure_widgets', 'widget_id' );
            $this->createIndex('id_idx', 'text_blocks', 'id' );
            $this->createIndex('language_id_idx', 'text_blocks', 'language_id' );
            $this->createIndex('role_idx', 'users', 'role' );
            $this->createIndex('create_time_idx', 'users', 'create_time,update_time' );
            $this->createIndex('status_idx', 'users', 'status' );
            $this->createIndex('email_idx', 'users', 'email' );
            $this->createIndex('login_idx', 'users', 'login' );
            $this->createIndex('update_time_idx', 'users', 'update_time' );
            $this->createIndex('user_id_idx', 'users_check_action', 'user_id,type_action,hash' );
            $this->createIndex('user_id_idx', 'users_sessions', 'user_id' );
            $this->createIndex('module_id_idx', 'widgets', 'module_id' );

            $this->addForeignKey("fk_banners_language_language_id", "banners", "language_id", "language", "id", "SET NULL", "CASCADE");
            $this->addForeignKey("fk_catalog_params_catalog_params_parent_id", "catalog_params", "parent_id", "catalog_params", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_catalog_params_catalog_tree_catalog_tree_id", "catalog_params", "catalog_tree_id", "catalog_tree", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_catalog_params_val_catalog_params_params_id", "catalog_params_val", "params_id", "catalog_params", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_catalog_products_catalog_tree_parent_id", "catalog_products", "parent_id", "catalog_tree", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_catalog_products_language_language_id", "catalog_products", "language_id", "language", "id", "SET NULL", "CASCADE");
            $this->addForeignKey("fk_catalog_products_params_catalog_params_params_id", "catalog_products_params", "params_id", "catalog_params", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_catalog_products_params_catalog_params_val_value_id", "catalog_products_params", "value_id", "catalog_params_val", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_catalog_products_params_catalog_products_product_id", "catalog_products_params", "product_id", "catalog_products", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_catalog_tree_language_language_id", "catalog_tree", "language_id", "language", "id", "SET NULL", "CASCADE");
            $this->addForeignKey("fk_gallery_language_language_id", "gallery", "language_id", "language", "id", "SET NULL", "CASCADE");
            $this->addForeignKey("fk_gallery_images_gallery_gallery_id", "gallery_images", "gallery_id", "gallery", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_menu_item_structure_structure_id", "menu_item", "structure_id", "structure", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_news_users_author_id", "news", "author_id", "users", "id", "RESTRICT", "RESTRICT");
            $this->addForeignKey("fk_news_language_language_id", "news", "language_id", "language", "id", "SET NULL", "CASCADE");
            $this->addForeignKey("fk_slider_language_language_id", "slider", "language_id", "language", "id", "SET NULL", "CASCADE");
            $this->addForeignKey("fk_slider_images_slider_slider_id", "slider_images", "slider_id", "slider", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_structure_language_language_id", "structure", "language_id", "language", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_structure_modules_modules_module_id", "structure_modules", "module_id", "modules", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_structure_modules_structure_structure_id", "structure_modules", "structure_id", "structure", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_structure_widgets_structure_structure_id", "structure_widgets", "structure_id", "structure", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_structure_widgets_widgets_widget_id", "structure_widgets", "widget_id", "widgets", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_text_blocks_language_language_id", "text_blocks", "language_id", "language", "id", "SET NULL", "CASCADE");
            $this->addForeignKey("fk_users_check_action_users_user_id", "users_check_action", "user_id", "users", "id", "CASCADE", "CASCADE");
            $this->addForeignKey("fk_widgets_modules_module_id", "widgets", "module_id", "modules", "id", "CASCADE", "CASCADE");
        }


        public function down()
        {
            $this->dropForeignKey('fk_banners_language_language_id', 'banners');
            $this->dropForeignKey('fk_catalog_params_catalog_params_parent_id', 'catalog_params');
            $this->dropForeignKey('fk_catalog_params_catalog_tree_catalog_tree_id', 'catalog_params');
            $this->dropForeignKey('fk_catalog_params_val_catalog_params_params_id', 'catalog_params_val');
            $this->dropForeignKey('fk_catalog_products_catalog_tree_parent_id', 'catalog_products');
            $this->dropForeignKey('fk_catalog_products_language_language_id', 'catalog_products');
            $this->dropForeignKey('fk_catalog_products_params_catalog_params_params_id', 'catalog_products_params');
            $this->dropForeignKey('fk_catalog_products_params_catalog_params_val_value_id', 'catalog_products_params');
            $this->dropForeignKey('fk_catalog_products_params_catalog_products_product_id', 'catalog_products_params');
            $this->dropForeignKey('fk_catalog_tree_language_language_id', 'catalog_tree');
            $this->dropForeignKey('fk_gallery_language_language_id', 'gallery');
            $this->dropForeignKey('fk_gallery_images_gallery_gallery_id', 'gallery_images');
            $this->dropForeignKey('fk_menu_item_menu_menu_id', 'menu_item');
            $this->dropForeignKey('fk_menu_item_structure_structure_id', 'menu_item');
            $this->dropForeignKey('fk_news_users_author_id', 'news');
            $this->dropForeignKey('fk_news_language_language_id', 'news');
            $this->dropForeignKey('fk_slider_language_language_id', 'slider');
            $this->dropForeignKey('fk_slider_images_slider_slider_id', 'slider_images');
            $this->dropForeignKey('fk_structure_language_language_id', 'structure');
            $this->dropForeignKey('fk_structure_modules_modules_module_id', 'structure_modules');
            $this->dropForeignKey('fk_structure_modules_structure_structure_id', 'structure_modules');
            $this->dropForeignKey('fk_structure_widgets_structure_structure_id', 'structure_widgets');
            $this->dropForeignKey('fk_structure_widgets_widgets_widget_id', 'structure_widgets');
            $this->dropForeignKey('fk_text_blocks_language_language_id', 'text_blocks');
            $this->dropForeignKey('fk_users_check_action_users_user_id', 'users_check_action');
            $this->dropForeignKey('fk_widgets_modules_module_id', 'widgets');

            $this->dropTable('banners');
            $this->dropTable('catalog_params');
            $this->dropTable('catalog_params_val');
            $this->dropTable('catalog_products');
            $this->dropTable('catalog_products_params');
            $this->dropTable('catalog_tree');
            $this->dropTable('gallery');
            $this->dropTable('gallery_images');
            $this->dropTable('language');
            $this->dropTable('menu_item');
            $this->dropTable('modules');
            $this->dropTable('news');
            $this->dropTable('settings');
            $this->dropTable('slider');
            $this->dropTable('slider_images');
            $this->dropTable('structure');
            $this->dropTable('structure_modules');
            $this->dropTable('structure_widgets');
            $this->dropTable('text_blocks');
            $this->dropTable('users');
            $this->dropTable('users_check_action');
            $this->dropTable('users_sessions');
            $this->dropTable('widgets');
        }
    }