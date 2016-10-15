<?php

class m160425_142616_followers extends CDbMigration
{
	public function up()
	{
        $this->createTable('followers', array(
            'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'user_id'=>'int(11) unsigned NOT NULL',
            'follower_id'=>'int(11) unsigned NOT NULL',
            'time' =>'int(11)  NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->createIndex('id_idx', 'followers', 'id' );
        $this->createIndex('user_id_idx', 'followers', 'user_id');
        $this->createIndex('follower_id_idx', 'followers', 'follower_id');

        $this->addForeignKey("fk_followers_users_id", "followers", "user_id", "users", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk_followers_follower_id", "followers", "follower_id", "users", "id", "CASCADE", "CASCADE");
    }

	public function down()
	{
        $this->dropForeignKey('fk_followers_users_id', 'followers');
        $this->dropForeignKey('fk_followers_follower_id', 'followers');

        $this->dropTable('followers');
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