<?php

class m140930_133707_banner_description extends CDbMigration
{
	public function up()
	{
        $this->addColumn('banners','description','text NOT NULL AFTER title');
    }

	public function down()
	{
        $this->dropColumn('banners','description');
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