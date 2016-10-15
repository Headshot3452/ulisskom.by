<?php

class m160301_144013_new_ask_answer extends CDbMigration
{
	public function up()
	{
        $this->addColumn('ask_answer_tree', 'images', 'text');
        $this->addColumn('ask_answer', 'hits', 'int(11) unsigned NOT NULL');
	}

	public function down()
	{
        $this->dropColumn('ask_answer_tree','images');
        $this->dropColumn('ask_answer','hits');
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