<?php

class m160421_143353_rating extends CDbMigration
{
    public function up()
    {
        $this->createTable('rating', array(
            'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'user_id'=>'int(11) unsigned NOT NULL',
            'post_id'=>'int(11) unsigned NOT NULL',
            'module_id'=>'int(11) unsigned NOT NULL',
            'value'=>'tinyint(5) NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->createIndex('id_idx', 'rating', 'id' );
        $this->createIndex('user_id_idx', 'rating', 'user_id');

        $this->addForeignKey("fk_rating_users_id", "rating", "user_id", "users", "id", "CASCADE", "CASCADE");
    }

    public function down()
    {
        $this->dropTable('rating');
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