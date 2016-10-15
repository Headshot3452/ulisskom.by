<?php

class m150911_094654_alter_news_sort extends CDbMigration
{
	public function up()
	{
		$this->addColumn('news','sort','int(11)  NOT NULL AFTER language_id');
	}

	public function down()
	{
		$this->dropColumn('news','sort');
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