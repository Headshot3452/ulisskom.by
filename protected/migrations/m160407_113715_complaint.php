<?php

class m160407_113715_complaint extends CDbMigration
{
	public function up()
	{
        $this->createTable('complaints', array(
            'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'language_id'=>'int(11) unsigned DEFAULT NULL',
            'user_id'=>'int(11) unsigned NOT NULL',
            'time' =>'int(11)  NOT NULL',
            'post_id'=>'int(11) unsigned NOT NULL',
            'module_id'=>'int(11) unsigned NOT NULL',
            'text'=>'text NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->createIndex('language_id_idx', 'complaints', 'language_id');
        $this->createIndex('id_idx', 'complaints', 'id' );
        $this->createIndex('user_id_idx', 'complaints', 'user_id');

        $this->addForeignKey("fk_complaints_language_language_id", "complaints", "language_id", "language", "id", "SET NULL", "CASCADE");
        $this->addForeignKey("fk_complaints_users_id", "complaints", "user_id", "users", "id", "CASCADE", "CASCADE");
    }

	public function down()
	{
        $this->dropTable('complaints');
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