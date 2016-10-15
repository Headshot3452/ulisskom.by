<?php

class m141016_173400_ok_adress_and_order extends CDbMigration
{
	public function up()
	{
        $this->addColumn('address','user_name','varchar(128)  DEFAULT NULL');
        $this->addColumn('address','phone','varchar(64)  DEFAULT NULL');
        $this->addColumn('address','default','tinyint(4) NOT NULL');
        $this->addColumn('orders','address_id','int(10) unsigned DEFAULT NULL AFTER user_id');
        $this->addColumn('orders','address_text','text DEFAULT NULL AFTER address_id');

        $this->createIndex('orders_address_id_idx', 'orders', 'address_id');
        $this->addForeignKey("fk_orders_address_address_id", "orders", "address_id", "address", "id", "RESTRICT", "RESTRICT");
	}

	public function down()
	{
        $this->dropForeignKey('fk_orders_address_address_id', 'orders');
        $this->dropColumn('address','user_name');
        $this->dropColumn('address','phone');
        $this->dropColumn('address','default');
        $this->dropColumn('orders','address_id');
        $this->dropColumn('orders','address_text');
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