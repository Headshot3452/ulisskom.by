<?php

class m160226_124848_structure_images extends CDbMigration
{
	public function up()
	{
        $this->addColumn('structure','images','text NOT NULL AFTER layout');
	}

	public function down()
	{
        $this->dropColumn('structure','images');
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