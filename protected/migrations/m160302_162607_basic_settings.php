<?php

class m160302_162607_basic_settings extends CDbMigration
{
	public function up()
	{
        $this->addColumn('settings', 'site_name', 'varchar(50) NOT NULL AFTER id');
        $this->addColumn('settings', 'company', 'varchar(100) NOT NULL AFTER site_name');

        $this->addColumn('settings', 'facebook', 'varchar(100)');
        $this->addColumn('settings', 'odnoklasniki', 'varchar(100)');
        $this->addColumn('settings', 'google', 'varchar(100)');
        $this->addColumn('settings', 'twitter', 'varchar(100)');
        $this->addColumn('settings', 'images', 'text');
        $this->addColumn('settings', 'info', 'text');

        $this->addColumn('settings', 'email_order', 'varchar(50)');
        $this->addColumn('settings', 'email_comment', 'varchar(50)');
        $this->addColumn('settings', 'email_callback', 'varchar(50)');

        $this->dropColumn('settings','otdel');
        $this->dropColumn('settings','mts');
        $this->dropColumn('settings','velcom');
        $this->dropColumn('settings','fax');
        $this->dropColumn('settings','street');
        $this->dropColumn('settings','skype');
	}

	public function down()
	{
        $this->addColumn('settings', 'otdel', 'varchar(20)');
        $this->addColumn('settings', 'mts', 'varchar(20)');
        $this->addColumn('settings', 'velcom', 'varchar(20)');
        $this->addColumn('settings', 'fax', 'varchar(20)');
        $this->addColumn('settings', 'street', 'varchar(20)');
        $this->addColumn('settings', 'skype', 'varchar(20)');

        $this->dropColumn('settings','site_name');
        $this->dropColumn('settings','company');
        $this->dropColumn('settings','email_order');
        $this->dropColumn('settings','email_comment');
        $this->dropColumn('settings','email_callback');
        $this->dropColumn('settings', 'images');
        $this->dropColumn('settings', 'info');
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