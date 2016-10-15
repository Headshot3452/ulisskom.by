<?php

class m141112_101601_alter_user_info extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user_info','orders_count','int(10) unsigned NOT NULL DEFAULT 0');
        $this->addColumn('user_info','status','tinyint(4) NOT NULL DEFAULT 1');
	}

	public function down()
	{
        $this->dropColumn('user_info','orders_count');
        $this->dropColumn('user_info','status');
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