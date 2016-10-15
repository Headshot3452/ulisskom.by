<?php

class m141110_100039_workers extends CDbMigration
{
	public function up()
	{
        $this->createTable('workers', array(
            'id'=>'int(10) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'name'=>'varchar(128) NOT NULL',
            'role'=>'tinyint(4) NOT NULL',
            'status'=>'tinyint(4) NOT NULL',
        ), 'ENGINE=InnoDB');

    }

	public function down()
	{
        $this->dropTable('workers');
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