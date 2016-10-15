<?php

class m151002_112041_alter_catalog_params extends CDbMigration
{
	public function up()
	{
		$this->addColumn('catalog_params','sort','int(11)  NOT NULL AFTER title');
		$this->addColumn('catalog_params','unit','int(11)  NOT NULL AFTER sort');
		$this->addColumn('catalog_params','status', 'int(11)  NOT NULL DEFAULT 1 AFTER type');
	}

	public function down()
	{
		$this->dropColumn('catalog_params','sort');
		$this->dropColumn('catalog_params','unit');
		$this->dropColumn('catalog_params','status');
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