<?php

class m160330_064436_blog extends CDbMigration
{
	public function up()
	{
		$this->createTable('blog', array(
			'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
			'language_id'=>'int(11) unsigned DEFAULT NULL',
            'user_id'=>'int(11) unsigned NOT NULL',
			'time' =>'int(11)  NOT NULL',
			'parent_id'=>'int(11) unsigned NOT NULL  NOT NULL',
			'title'=>'varchar(255) NOT NULL',
			'text'=>'TEXT NOT NULL',
            'name'=>'varchar(255) NOT NULL',
            'cause'=>'varchar(255) NOT NULL',
            'images'=>'varchar(255) NOT NULL',
            'rating' =>'int(11)  NOT NULL',
            'view' =>'int(11)  NOT NULL',
			'status'=>'tinyint(4) NOT NULL',
            'name'=>'varchar(255) NULL',
            'email'=>'varchar(64) NULL',
            'phone'=>'varchar(64) NULL',
		), 'ENGINE=InnoDB');

		$this->createIndex('language_id_idx', 'blog', 'language_id');
		$this->createIndex('status_idx', 'blog', 'status');
		$this->createIndex('tree_idx', 'blog', 'parent_id');
		$this->createIndex('id_idx', 'blog', 'id' );
        $this->createIndex('user_id_idx', 'blog', 'user_id');

		$this->createTable('blog_tree', array(
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

		$this->createIndex('id_idx', 'blog_tree', 'id' );
		$this->createIndex('language_id_idx', 'blog_tree', 'language_id' );

		$this->addForeignKey("fk_blog_tree_language_language_id", "blog_tree", "language_id", "language", "id", "SET NULL", "CASCADE");
		$this->addForeignKey("fk_blog_language_language_id", "blog", "language_id", "language", "id", "SET NULL", "CASCADE");
		
		$this->addForeignKey("fk_blog_blog_tree_id", "blog", "parent_id", "blog_tree", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk_blog_users_id", "blog", "user_id", "users", "id", "CASCADE", "CASCADE");
	}

	public function down()
	{
		$this->dropForeignKey('fk_blog_blog_tree_id', 'blog');
		$this->dropForeignKey('fk_blog_tree_language_language_id', 'blog_tree');
		$this->dropForeignKey('fk_blog_language_language_id', 'blog');

		$this->dropTable('blog');
		$this->dropTable('blog_tree');
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