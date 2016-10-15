<?php

class m150925_124412_ask_answer_init extends CDbMigration
{
	public function up()
	{
		$this->createTable('ask_answer', array(
			'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
			'language_id'=>'int(11) unsigned DEFAULT NULL',
			'parent_id'=>'int(11) unsigned  NOT NULL',
			'sort' =>'int(11)  NOT NULL',
			'answer_ok' => 'int(11) NOT NULL',
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

		$this->createTable('ask_answer_tree', array(
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



		$this->createIndex('parent_id_idx', 'ask_answer', 'parent_id' );
		$this->createIndex('language_id_idx', 'ask_answer', 'language_id,name,author_id,status' );
		$this->createIndex('create_time_idx', 'ask_answer', 'create_time,update_time' );
		$this->createIndex('author_id_idx', 'ask_answer', 'author_id' );
		$this->createIndex('status_idx', 'ask_answer', 'status' );
		$this->createIndex('time_idx', 'ask_answer', 'time' );
		$this->createIndex('update_time_idx', 'ask_answer', 'update_time' );
		$this->createIndex('language_id_idx', 'ask_answer_tree', 'language_id,name' );



		$this->addForeignKey("fk_ask_answer_tree_language_language_id", "ask_answer_tree", "language_id", "language", "id", "SET NULL", "CASCADE");
		$this->addForeignKey("fk_ask_answer_ask_answer_tree_parent_id", "ask_answer", "parent_id", "ask_answer_tree", "id", "CASCADE", "CASCADE");
		$this->addForeignKey("fk_ask_answer_users_author_id", "ask_answer", "author_id", "users", "id", "RESTRICT", "RESTRICT");
		$this->addForeignKey("fk_ask_answer_language_language_id", "ask_answer", "language_id", "language", "id", "SET NULL", "CASCADE");


	}

	public function down()
	{
		$this->dropForeignKey('fk_ask_answer_tree_language_language_id', 'ask_answer_tree');
		$this->dropForeignKey('fk_ask_answer_ask_answer_tree_parent_id', 'ask_answer');
		$this->dropForeignKey('fk_ask_answer_users_author_id', 'ask_answer');
		$this->dropForeignKey('fk_ask_answer_language_language_id', 'ask_answer');
		$this->dropTable('ask_answer');
		$this->dropTable('ask_answer_tree');
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