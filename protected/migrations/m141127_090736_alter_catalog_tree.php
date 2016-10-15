<?php

class m141127_090736_alter_catalog_tree extends CDbMigration
{
	public function up()
	{
        $this->addColumn('catalog_tree','images','text  NOT NULL AFTER icon');
	}

	public function down()
	{
        $this->dropColumn('catalog_tree','images');
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