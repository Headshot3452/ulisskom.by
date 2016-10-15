<?php

class m141028_120800_ok_user_info_add_sum extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user_info','sum','int(11) NOT NULL');
        $this->addColumn('user_info','discount','tinyint(4) NOT NULL');
	}

	public function down()
	{
        $this->dropColumn('user_info','sum');
        $this->dropColumn('user_info','discount');
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