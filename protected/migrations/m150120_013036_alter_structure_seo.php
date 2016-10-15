<?php

class m150120_013036_alter_structure_seo extends CDbMigration
{
	public function up()
	{
        $this->addColumn('structure','meta_robots_index','smallint(1) NOT NULL AFTER layout');
		$this->addColumn('structure','meta_robots_follow','smallint(1) NOT NULL AFTER meta_robots_index');
		$this->addColumn('structure','sitemap','smallint(1) NOT NULL AFTER meta_robots_follow');
		$this->addColumn('structure','redirect','varchar(125) NOT NULL AFTER sitemap');
		$this->addColumn('structure','ping','smallint(1) NOT NULL AFTER redirect');
	}

	public function down()
	{
        $this->dropColumn('structure','meta_robots_index');
		$this->dropColumn('structure','meta_robots_follow');
		$this->dropColumn('structure','sitemap');
		$this->dropColumn('structure','redirect');
		$this->dropColumn('structure','ping');
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