<?php

class m160429_135034_user_settings extends CDbMigration
{
	public function up()
	{
        $this->createTable('user_settings', array(
            'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'user_id'=>'int(11) unsigned NOT NULL',
            'send_complaint'=>'tinyint(1) NULL',
            'send_block'=>'tinyint(1) NULL',
        ), 'ENGINE=InnoDB');

        $this->createIndex('id_idx', 'user_settings', 'id' );
        $this->createIndex('user_id_idx', 'user_settings', 'user_id');

        $this->addForeignKey("fk_user_settings_users_id", "user_settings", "user_id", "users", "id", "CASCADE", "CASCADE");
    }

	public function down()
	{
        $this->dropForeignKey('fk_user_settings_users_id', 'user_settings');
        $this->dropTable('user_settings');
	}
}