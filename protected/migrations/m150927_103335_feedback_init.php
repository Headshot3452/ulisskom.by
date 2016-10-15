<?php

class m150927_103335_feedback_init extends CDbMigration
{
	public function up()
	{
		$this->createTable('settings_feedback', array(
			'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
			'language_id'=>'int(11) unsigned DEFAULT NULL',
			'sort' =>'int(11)  NOT NULL',
			'name'=>'varchar(255) NOT NULL',
			'type'=>'tinyint(4) NOT NULL',
			'status'=>'tinyint(4) NOT NULL',
			'system'=>'tinyint(4) NOT NULL',
		), 'ENGINE=InnoDB');

		$this->createIndex('language_id_idx', 'settings_feedback', 'language_id' );

		$this->createIndex('id_idx', 'settings_feedback', 'id' );

		$this->createTable('feedback', array(
			'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
			'language_id'=>'int(11) unsigned DEFAULT NULL',
			'sort' =>'int(11)  NOT NULL',
			'time' =>'int(11)  NOT NULL',
			'tree_id'=>'int(11) unsigned NOT NULL  NOT NULL',
			'ask'=>'TEXT NOT NULL',
			'primech'=>'varchar(255) NOT NULL',
			'status'=>'tinyint(4) NOT NULL',
		), 'ENGINE=InnoDB');

		$this->createIndex('language_id_idx', 'feedback', 'language_id' );
		$this->createIndex('status_idx', 'feedback', 'status' );
		$this->createIndex('tree_idx', 'feedback', 'tree_id' );
		$this->createIndex('id_idx', 'feedback', 'id' );

		$this->createTable('feedback_tree', array(
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

		$this->createIndex('id_idx', 'feedback_tree', 'id' );
		$this->createIndex('language_id_idx', 'feedback_tree', 'language_id' );

		$this->createTable('feedback_answers', array(
			'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
			'language_id'=>'int(11) unsigned DEFAULT NULL',
			'feedback_id'=>'int(11) unsigned DEFAULT NULL',
			'settings_feedback_id'=>'int(11) unsigned DEFAULT NULL',
			'value' =>'text  NOT NULL',
		), 'ENGINE=InnoDB');

		$this->createIndex('language_id_idx', 'feedback_answers', 'language_id' );
		$this->createIndex('id_idx', 'feedback_answers', 'id' );



		$this->addForeignKey("fk_feedback_tree_language_language_id", "feedback_tree", "language_id", "language", "id", "SET NULL", "CASCADE");
		$this->addForeignKey("fk_feedback_language_language_id", "feedback", "language_id", "language", "id", "SET NULL", "CASCADE");
		$this->addForeignKey("fk_settings_feedback_language_id", "settings_feedback", "language_id", "language", "id", "SET NULL", "CASCADE");


		$this->addForeignKey("fk_feedback_answers_feedback_id", "feedback_answers", "feedback_id", "feedback", "id", "SET NULL", "CASCADE");
		$this->addForeignKey("fk_feedback_answers_settings_feedback_id", "feedback_answers", "settings_feedback_id", "settings_feedback", "id", "SET NULL", "CASCADE");


		$this->addForeignKey("fk_feedback_feedback_tree_id", "feedback", "tree_id", "feedback_tree", "id", "CASCADE", "CASCADE");

		$this->insert("settings_feedback",array(
			"language_id"=>1,
			"sort"=>1,
			"name"=>"ФИО",
			"type"=>"2",
			"status"=>"1",
			"system"=>"1",
		));

		$this->insert("settings_feedback",array(
			"language_id"=>1,
			"sort"=>2,
			"name"=>"Email",
			"type"=>"1",
			"status"=>"1",
			"system"=>"1",
		));

		$this->insert("settings_feedback",array(
			"language_id"=>1,
			"sort"=>3,
			"name"=>"Ваш вопрос",
			"type"=>"2",
			"status"=>"1",
			"system"=>"1",
		));

	}

	public function down()
	{
		$this->dropForeignKey('fk_feedback_feedback_tree_id', 'feedback');
		$this->dropForeignKey('fk_feedback_tree_language_language_id', 'feedback_tree');
		$this->dropForeignKey('fk_feedback_language_language_id', 'feedback');
		$this->dropForeignKey('fk_feedback_answers_feedback_id', 'feedback_answers');
		$this->dropForeignKey('fk_feedback_answers_settings_feedback_id', 'feedback_answers');
		$this->dropForeignKey('fk_settings_feedback_language_id', 'settings_feedback');


		$this->dropTable('settings_feedback');
		$this->dropTable('feedback');
		$this->dropTable('feedback_tree');
		$this->dropTable('feedback_answers');
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