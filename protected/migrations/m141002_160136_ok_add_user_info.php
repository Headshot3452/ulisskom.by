<?php

class m141002_160136_ok_add_user_info extends CDbMigration
{
	public function up()
	{
        $this->createTable('user_info', array(
            'id'=>'int(10) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'user_id'=>'int(10) unsigned zerofill NOT NULL',
            'name'=>'varchar(128) NOT NULL',
            'patronymic'=>'varchar(128) NOT NULL',
            'last_name'=>'varchar(128) NOT NULL',
            'birth'=>'int(10) unsigned NOT NULL',
            'sex'=>'int(10) unsigned',
            'phone'=>'varchar(64) NOT NULL',
            'nickname'=>'varchar(64) NOT NULL',
        ), 'ENGINE=InnoDB');
        $this->createIndex('user_id_idx', 'user_info', 'user_id' );
        $this->addForeignKey("fk_user_info_users_user_id", "user_info", "user_id", "users", "id", "CASCADE", "CASCADE");
	}

	public function down()
	{
        $this->dropForeignKey('fk_user_info_users_user_id', 'user_info');
        $this->dropTable('user_info');
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