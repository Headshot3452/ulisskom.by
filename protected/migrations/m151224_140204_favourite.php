<?php

class m151224_140204_favourite extends CDbMigration
{
	public function up()
	{
        $this->createTable('favourite', array(
            'id'=>'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'user_id'=>'int(11) UNSIGNED NOT NULL',
            'module_id' =>'int(11) UNSIGNED NOT NULL',
            'item_id' => 'int(11) UNSIGNED NOT NULL'
        ), 'ENGINE=InnoDB');
	}

	public function down()
	{
        $this->dropTable('favourite');
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