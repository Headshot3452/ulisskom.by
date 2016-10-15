<?php

class m160217_101930_last_ip_and_online extends CDbMigration
{
    public function up()
    {
        $this->addColumn('users','last_ip','varchar(100) AFTER update_time');
        $this->addColumn('user_info','comment','text AFTER phone');
    }

    public function down()
    {
        $this->dropColumn('users','last_ip');
        $this->dropColumn('user_info','comment');
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