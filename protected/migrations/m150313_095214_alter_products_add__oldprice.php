<?php

class m150313_095214_alter_products_add__oldprice extends CDbMigration
{
	public function up()
	{
		$this->addColumn('catalog_products','old_price','float DEFAULT 0 after price');
	}

	public function down()
	{
		$this->dropColumn('catalog_products','old_price');
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