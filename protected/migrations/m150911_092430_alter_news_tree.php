<?php

class m150911_092430_alter_news_tree extends CDbMigration
{
	public function up()
	{
		$this->addColumn('news_tree','images','text  NOT NULL AFTER icon');
	}

	public function down()
	{
		$this->dropColumn('news_tree','images');
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