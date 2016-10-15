<?php

class m151012_102952_products_releated_init extends CDbMigration
{
	public function up()
	{
		$this->createTable('products_releated', array(
			'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
			'product_id' =>'int(11) unsigned  NOT NULL',
			'releated_id' =>'int(11) unsigned  NOT NULL',
			'sort' =>'int(11) NOT NULL',
		), 'ENGINE=InnoDB');

		$this->createIndex('product_id_idx', 'products_releated', 'product_id' );
		$this->addForeignKey("fk_products_releated_catalog_products_id", "products_releated", "product_id", "catalog_products", "id", "CASCADE", "CASCADE");
		$this->addForeignKey("fk_products_releated_id_catalog_products_id", "products_releated", "releated_id", "catalog_products", "id", "CASCADE", "CASCADE");
	}

	public function down()
	{
		$this->dropForeignKey('fk_products_releated_catalog_products_id', 'products_releated');
		$this->dropForeignKey('fk_products_releated_id_catalog_products_id', 'products_releated');
		$this->dropTable('products_releated');
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