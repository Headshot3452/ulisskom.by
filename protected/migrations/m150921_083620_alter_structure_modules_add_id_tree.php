<?php

class m150921_083620_alter_structure_modules_add_id_tree extends CDbMigration
{
	public function up()
	{
		$this->addColumn('structure_modules','tree_id','int(11) DEFAULT 0 AFTER module_id');
	}

	public function down()
	{
		$this->dropColumn('structure_modules','tree_id');
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