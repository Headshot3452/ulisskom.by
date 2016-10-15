<?php

class m150911_072930_news_tree extends CDbMigration
{
	public function up()
	{
		$this->addColumn('news','parent_id','int(11) unsigned  NOT NULL AFTER language_id');

		$this->createIndex('parent_id_idx', 'news', 'parent_id' );

		$this->createTable('news_tree', array(
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
		$this->createIndex('language_id_idx', 'news_tree', 'language_id,name' );

		$this->addForeignKey("fk_news_tree_language_language_id", "news_tree", "language_id", "language", "id", "SET NULL", "CASCADE");
		$this->addForeignKey("fk_news_news_tree_parent_id", "news", "parent_id", "news_tree", "id", "CASCADE", "CASCADE");
	}

	public function down()
	{

		$this->dropForeignKey('fk_news_tree_language_language_id', 'news_tree');
		$this->dropForeignKey('fk_news_news_tree_parent_id', 'news');

		$this->dropColumn('news','parent_id');

		$this->dropTable('news_tree');

		return true;
	}
}