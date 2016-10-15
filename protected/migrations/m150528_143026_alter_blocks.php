<?php

class m150528_143026_alter_blocks extends CDbMigration
{
	public function up()
	{
        $this->createIndex('language_id_idx_unigue','text_blocks','id,language_id',true);
	}

	public function down()
	{
        $this->dropIndex('language_id_idx_unigue','text_blocks');
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