<?php

class m160407_114052_comments extends CDbMigration
{
	public function up()
	{
        $this->createTable('comments', array(
            'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'language_id'=>'int(11) unsigned DEFAULT NULL',
            'user_id'=>'int(11) unsigned NOT NULL',
            'time' =>'int(11)  NOT NULL',
            'post_id'=>'int(11) unsigned NOT NULL',
            'module_id'=>'int(11) unsigned NOT NULL',
            'parent_id'=>'int(11) unsigned NOT NULL',
            'text'=>'text NOT NULL',
            'status'=>'tinyint(4) NOT NULL',
            'rating'=>'int(11) NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->createIndex('language_id_idx', 'comments', 'language_id');
        $this->createIndex('status_idx', 'comments', 'status');
        $this->createIndex('id_idx', 'comments', 'id' );
        $this->createIndex('user_id_idx', 'comments', 'user_id');
        $this->createIndex('parent_id_idx', 'comments', 'parent_id');

        $this->addForeignKey("fk_comments_language_language_id", "comments", "language_id", "language", "id", "SET NULL", "CASCADE");
        $this->addForeignKey("fk_comments_users_id", "comments", "user_id", "users", "id", "CASCADE", "CASCADE");
    }

	public function down()
	{
        $this->dropTable('comments');
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