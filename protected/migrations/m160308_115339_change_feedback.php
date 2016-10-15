<?php

class m160308_115339_change_feedback extends CDbMigration
{
	public function up()
	{
		$this->execute('ALTER TABLE `feedback` CHANGE `tree_id` `parent_id` INT(11) UNSIGNED NOT NULL');

		$this->execute('DELETE FROM settings_feedback');
		
		$this->addColumn('feedback','files','text');

		$this->addColumn('settings_feedback','tree_id','int(11) unsigned NOT NULL');

		$this->addColumn('settings','load_file_feedback','int(2) unsigned NOT NULL');
		$this->addColumn('settings','thema_question_feedback','int(2) unsigned NOT NULL');
	}

	public function down()
	{
		$this->execute('ALTER TABLE `feedback` CHANGE `parent_id` `tree_id` INT(11) UNSIGNED NOT NULL');
		
		$this->dropColumn('feedback','files');

		$this->dropColumn('settings_feedback','tree_id');

		$this->dropColumn('settings','load_file_feedback');
		$this->dropColumn('settings','thema_question_feedback');
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