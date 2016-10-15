<?php

class m160411_120717_forum_status extends CDbMigration
{
	public function up()
	{
        $this->createTable('forum_status', array(
            'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'language_id'=>'int(11) unsigned DEFAULT NULL',
            'period' =>'int(11)  NOT NULL',
            'text'=>'text NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->createIndex('language_id_idx', 'forum_status', 'language_id');
        $this->createIndex('id_idx', 'forum_status', 'id' );
	}

	public function down()
	{
        $this->dropTable('forum_status');
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