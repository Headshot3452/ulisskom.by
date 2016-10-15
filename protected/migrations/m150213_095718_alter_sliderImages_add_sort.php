<?php

class m150213_095718_alter_sliderImages_add_sort extends CDbMigration
{
	public function up()
	{
		$this->addColumn('slider_images','sort','int(11) NOT NULL');
	}

	public function down()
	{
		$this->dropColumn('slider_images','sort');
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