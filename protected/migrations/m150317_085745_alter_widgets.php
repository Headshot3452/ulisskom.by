<?php

class m150317_085745_alter_widgets extends CDbMigration
{
	public function up()
	{
		$this->addColumn('widgets','name','varchar(255)  NOT NULL AFTER title');
	}

	public function down()
	{
		$this->dropColumn('widgets','name');
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