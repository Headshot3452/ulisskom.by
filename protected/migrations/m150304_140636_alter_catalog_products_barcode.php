<?php

class m150304_140636_alter_catalog_products_barcode extends CDbMigration
{
	public function up()
	{
        $this->addColumn('catalog_products','barcode','varchar(20) NOT NULL AFTER text');
        $this->addColumn('catalog_products','article','varchar(15) NOT NULL AFTER barcode');
	}

	public function down()
	{
        $this->dropColumn('catalog_products','article');
        $this->dropColumn('catalog_products','barcode');
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