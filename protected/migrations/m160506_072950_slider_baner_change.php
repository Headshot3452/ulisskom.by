<?php

class m160506_072950_slider_baner_change extends CDbMigration
{
	public function up()
	{
        $this->dropForeignKey('fk_slider_language_language_id', 'slider');
        $this->dropForeignKey('fk_slider_images_slider_slider_id', 'slider_images');
        $this->dropForeignKey('fk_banners_language_language_id', 'banners');

        $this->dropTable('slider');
        $this->dropTable('slider_images');
        $this->dropTable('banners');

        $this->createTable('slider_tree', array(
            'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'lft'=>'int(11) NOT NULL',
            'rgt'=>'int(11) NOT NULL',
            'level'=>'int(11) NOT NULL',
            'language_id'=>'int(11) unsigned DEFAULT NULL',
            'icon'=>'text NOT NULL',
            'seo_title'=>'varchar(255) NOT NULL',
            'seo_keywords'=>'varchar(255) NOT NULL',
            'seo_description'=>'text NOT NULL',
            'title'=>'varchar(255) NOT NULL',
            'name'=>'varchar(255) NOT NULL',
            'text'=>'text NOT NULL',
            'create_time'=>'int(11) unsigned DEFAULT NULL',
            'update_time'=>'int(11) unsigned DEFAULT NULL',
            'status'=>'tinyint(4) NOT NULL',
            'root'=>'int(11) unsigned DEFAULT NULL',
        ), 'ENGINE=InnoDB');

        $this->createTable('slider', array(
            'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'language_id'=>'int(11) unsigned DEFAULT NULL',
            'parent_id'=>'int(11) unsigned DEFAULT NULL',
            'title'=>'varchar(255) NOT NULL',
            'name'=>'varchar(255) NOT NULL',
            'time'=>'int(11) unsigned DEFAULT NULL',
            'text'=>'text NOT NULL',
            'images'=>'text NOT NULL',
            'create_time'=>'int(11) unsigned DEFAULT NULL',
            'update_time'=>'int(11) unsigned DEFAULT NULL',
            'author_id'=>'int(11) unsigned NOT NULL',
            'status'=>'tinyint(4) NOT NULL',
            'sort'=>'int(11) unsigned NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->createIndex('language_id_idx', 'slider_tree', 'language_id,name' );

        $this->addForeignKey("fk_slider_tree_language_language_id", "slider_tree", "language_id", "language", "id", "SET NULL", "CASCADE");
        $this->addForeignKey("fk_slider_slider_tree_slider_id", "slider", "parent_id", "slider_tree", "id", "CASCADE", "CASCADE");

        $this->addForeignKey("fk_slider_language_language_id", "slider", "language_id", "language", "id", "SET NULL", "CASCADE");

        $this->execute('DELETE FROM modules WHERE id=5');

        $this->update("modules",array(
            "model" => "SliderTree",
            "title" => "Слайдеры, баннеры",
        ), "id=11");
        $this->update("modules",array(
            "model" => "MenuItem",
        ), "id=2");

        $this->update("widgets",array(
            "module_id"=>11
        ), "id=11");
        $this->update("widgets",array(
            "module_id"=>2
        ), "id=9");
        $this->update("widgets",array(
            "module_id"=>9
        ), "id=8");
    }

	public function down()
	{
        $this->dropForeignKey('fk_slider_tree_language_language_id', 'slider_tree');
        $this->dropForeignKey('fk_slider_slider_tree_slider_id', 'slider');

        $this->dropTable('slider_tree');
        $this->dropTable('slider');

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

        $this->addForeignKey("fk_slider_language_language_id", "slider", "language_id", "language", "id", "SET NULL", "CASCADE");
        $this->addForeignKey("fk_slider_images_slider_slider_id", "slider_images", "slider_id", "slider", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk_banners_language_language_id", "banners", "language_id", "language", "id", "SET NULL", "CASCADE");

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

        $this->update("modules",array(
            "title"=>"Слайдер",
            "model" => "Slider"
        ), "id=11");
        $this->update("widgets",array(
            "module_id"=>10
        ), "id=11");
    }
}