<?php

class m160223_132252_country_and_index extends CDbMigration
{
	public function up()
	{
        $this->addColumn('address','country','varchar(127) AFTER user_id');
        $this->addColumn('address','index','int(10) AFTER country');
	}

	public function down()
	{
        $this->dropColumn('address','country');
        $this->dropColumn('address','index');
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