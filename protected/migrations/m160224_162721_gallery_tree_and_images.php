<?php

class m160224_162721_gallery_tree_and_images extends CDbMigration
{
	public function up()
	{
        $this->dropForeignKey('fk_gallery_language_language_id', 'gallery');
        $this->dropForeignKey('fk_gallery_images_gallery_gallery_id', 'gallery_images');

        $this->dropTable('gallery');
        $this->dropTable('gallery_images');

		$this->createTable('gallery_tree', array(
				'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
				'lft'=>'int(11) NOT NULL',
				'rgt'=>'int(11) NOT NULL',
				'level'=>'int(11) NOT NULL',
				'language_id'=>'int(11) unsigned DEFAULT NULL',
				'icon'=>'text NOT NULL',
				'images'=>'text NOT NULL',
				'small_width'=>'int(4) unsigned DEFAULT 160',
				'big_width'=>'int(4) unsigned DEFAULT 960',
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

        $this->createTable('gallery_images', array(
            'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'parent_id'=>'int(11) unsigned NOT NULL',
            'language_id'=>'int(11) unsigned DEFAULT NULL',
            'seo_title'=>'varchar(255) NOT NULL',
            'seo_keywords'=>'varchar(255) NOT NULL',
            'seo_description'=>'text NOT NULL',
            'images'=>'text NOT NULL',
            'title'=>'varchar(255) NOT NULL',
            'url'=>'varchar(255) NOT NULL',
            'author_id'=>'int(11) unsigned NOT NULL',
            'description'=>'text NOT NULL',
            'create_time'=>'int(11) unsigned DEFAULT NULL',
            'update_time'=>'int(11) unsigned DEFAULT NULL',
            'sort'=>'int(11) unsigned NOT NULL',
            'status'=>'tinyint(4) NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->insert('gallery_tree',array(
            'lft'=>'1',
            'rgt'=>'2',
            'level'=>'1',
            'language_id'=>'1',
            'title'=>'Корневая директория',
            'name'=>'root',
            'status'=>'1',
            'root'=>'1',
        ));
	}

	public function down()
	{
        $this->dropTable('gallery_tree');
        $this->dropTable('gallery_images');

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

        $this->addForeignKey("fk_gallery_language_language_id", "gallery", "language_id", "language", "id", "SET NULL", "CASCADE");
        $this->addForeignKey("fk_gallery_images_gallery_gallery_id", "gallery_images", "gallery_id", "gallery", "id", "CASCADE", "CASCADE");
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}