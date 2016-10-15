<?php

class m150227_135547_add_product_sale_popular extends CDbMigration
{
	public function up()
	{
		$this->addColumn('catalog_products','sale','tinyint(4) DEFAULT NULL');
		$this->addColumn('catalog_products','popular','tinyint(4) DEFAULT NULL');
		$this->addColumn('catalog_products','new','tinyint(4) DEFAULT NULL');
		$this->addColumn('catalog_products','hit','tinyint(4) DEFAULT NULL');
	}

	public function down()
	{
		$this->dropColumn('catalog_products','sale');
		$this->dropColumn('catalog_products','popular');
		$this->dropColumn('catalog_products','new');
		$this->dropColumn('catalog_products','hit');
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