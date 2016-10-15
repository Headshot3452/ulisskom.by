<?php

class m160505_125836_feedback_create_system extends CDbMigration
{
	public function up()
	{
        $this->insert("settings_feedback",array(
            "id"=>1,
            "language_id"=>1,
            "sort"=>1,
            "name"=>"ФИО",
            "type"=>"2",
            "status"=>"1",
            "system"=>"1",
        ));

        $this->insert("settings_feedback",array(
            "id"=>2,
            "language_id"=>1,
            "sort"=>2,
            "name"=>"Телефон",
            "type"=>"2",
            "status"=>"1",
            "system"=>"1",
        ));

        $this->insert("settings_feedback",array(
            "id"=>3,
            "language_id"=>1,
            "sort"=>3,
            "name"=>"Email",
            "type"=>"2",
            "status"=>"1",
            "system"=>"1",
        ));

        $this->dropColumn('settings_feedback','tree_id');
        $this->addColumn('settings_feedback','tree_id','int(11) unsigned NULL');
	}

	public function down()
	{
        $this->execute('DELETE FROM settings_feedback');

        $this->dropColumn('settings_feedback','tree_id');
        $this->addColumn('settings_feedback','tree_id','int(11) unsigned NOT NULL');
	}
}