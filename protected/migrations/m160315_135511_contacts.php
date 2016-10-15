<?php

class m160315_135511_contacts extends CDbMigration
{
	public function up()
	{
		$this->createTable('contacts_phone', array(
			'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
			'language_id'=>'int(11) unsigned DEFAULT NULL',
			'number'=>'varchar(255) NOT NULL',
			'operator'=>'varchar(255) NOT NULL',
			'status'=>'tinyint(4) NOT NULL',
			'sort'=>'int(11) NOT NULL',
		), 'ENGINE=InnoDB');

		$this->createTable('contacts_address', array(
			'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
			'language_id'=>'int(11) unsigned DEFAULT NULL',
			'map_id' => 'int(11) NOT NULL',
			'text'=>'varchar(255) NOT NULL',
			'status'=>'tinyint(4) NOT NULL',
		), 'ENGINE=InnoDB');

		$this->addColumn('settings','contact_show_feedback','int(2) NOT NULL');
	}

	public function down()
	{
		$this->dropTable('contacts_phone');
		$this->dropTable('contacts_address');

		$this->dropColumn('settings','contact_show_feedback');
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