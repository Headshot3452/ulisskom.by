<?php

class m150227_123036_alter_order_items_edit extends CDbMigration
{
	public function up()
	{
        $this->addColumn('order_items','count_edit','smallint(6) NOT NULL AFTER count');
        $this->addColumn('order_items','status','tinyint(4) NOT NULL AFTER discount');
        $this->addColumn('order_items','product_type_add','tinyint(4) NOT NULL AFTER status');
	}

	public function down()
	{
        $this->dropColumn('order_items','count_edit');
        $this->dropColumn('order_items','status');
        $this->dropColumn('order_items','product_type_add');
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