<?php

class m141017_171300_ok_orders_address_table_fix extends CDbMigration
{
	public function up()
	{
        $this->addColumn('orders','type_delivery','tinyint(4) NOT NULL AFTER sum');
        $this->addColumn('orders','type_payments','tinyint(4) NOT NULL AFTER type_delivery');

        $this->dropForeignKey('fk_orders_address_address_id', 'orders');
        $this->addForeignKey("fk_orders_address_address_id", "orders", "address_id", "address", "id", "SET NULL", "CASCADE");
	}

	public function down()
	{
        $this->dropForeignKey('fk_orders_address_address_id', 'orders');
        $this->addForeignKey("fk_orders_address_address_id", "orders", "address_id", "address", "id", "RESTRICT", "RESTRICT");
        $this->dropColumn('orders','type_delivery');
        $this->dropColumn('orders','type_payments');
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