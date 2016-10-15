<?php

class m141111_144954_alter_orders extends CDbMigration
{
	public function up()
	{
        $this->addColumn('orders','delivery_time','int(10) unsigned DEFAULT NULL AFTER update_time');
        $this->addColumn('orders','delivery_hours','varchar(16) AFTER delivery_time');
        $this->addColumn('orders','picker_id','int(10) unsigned DEFAULT NULL AFTER address_id');
        $this->addColumn('orders','executor_id','int(10) unsigned DEFAULT NULL AFTER address_id');
        $this->addColumn('orders','manager_id','int(10) unsigned DEFAULT NULL AFTER address_id');

        $this->createIndex('executor_id_idx', 'orders', 'executor_id' );
        $this->createIndex('picker_id_idx', 'orders', 'picker_id' );
        $this->createIndex('manager_id_idx', 'orders', 'manager_id' );

        $this->addForeignKey("fk_orders_workers_executor_id", "orders", "executor_id", "workers", "id", "RESTRICT", "CASCADE");
        $this->addForeignKey("fk_orders_workers_picker_id", "orders", "picker_id", "workers", "id", "RESTRICT", "CASCADE");
        $this->addForeignKey("fk_orders_workers_manager_id", "orders", "manager_id", "users", "id", "RESTRICT", "CASCADE");
	}

	public function down()
	{
        $this->dropForeignKey('fk_orders_workers_executor_id', 'orders');
        $this->dropForeignKey('fk_orders_workers_picker_id', 'orders');
        $this->dropForeignKey('fk_orders_workers_manager_id', 'orders');

        $this->dropColumn('orders','delivery_time');
        $this->dropColumn('orders','delivery_hours');
        $this->dropColumn('orders','picker_id');
        $this->dropColumn('orders','executor_id');
        $this->dropColumn('orders','manager_id');
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