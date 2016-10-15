<?php

class m150313_102126_articles extends CDbMigration
{
	public function up()
	{
		$this->createTable('articles', array(
			'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
			'language_id'=>'int(11) unsigned DEFAULT NULL',
			'seo_title'=>'varchar(255) NOT NULL',
			'seo_keywords'=>'varchar(255) NOT NULL',
			'seo_description'=>'text NOT NULL',
			'title'=>'varchar(255) NOT NULL',
			'name'=>'varchar(255) NOT NULL',
			'preview'=>'text NOT NULL',
			'text'=>'text NOT NULL',
			'images'=>'text NOT NULL',
			'create_time'=>'int(11) unsigned DEFAULT NULL',
			'update_time'=>'int(11) unsigned DEFAULT NULL',
			'author_id'=>'int(11) unsigned NOT NULL',
			'status'=>'tinyint(4) NOT NULL',
		), 'ENGINE=InnoDB');

		$this->createIndex('language_id_idx', 'articles', 'language_id,name,author_id,status' );
		$this->createIndex('create_time_idx', 'articles', 'create_time,update_time' );
		$this->createIndex('author_id_idx', 'articles', 'author_id' );
		$this->createIndex('status_idx', 'articles', 'status' );
		$this->createIndex('update_time_idx', 'articles', 'update_time' );

		$this->addForeignKey("fk_articles_users_author_id", "articles", "author_id", "users", "id", "RESTRICT", "RESTRICT");
		$this->addForeignKey("fk_articles_language_language_id", "articles", "language_id", "language", "id", "SET NULL", "CASCADE");
	}

	public function down()
	{
		$this->dropForeignKey('fk_articles_users_author_id', 'articles');
        $this->dropForeignKey('fk_articles_language_language_id', 'articles');
		
		$this->dropTable('articles');
		return true;
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