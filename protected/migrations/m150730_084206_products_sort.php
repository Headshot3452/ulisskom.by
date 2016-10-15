<?php

class m150730_084206_products_sort extends CDbMigration
{
	public function up()
	{
        $this->addColumn('catalog_products','sort','int(11)  NOT NULL AFTER language_id');
	}

	public function down()
	{
        $this->dropColumn('catalog_products','sort');
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