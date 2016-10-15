<?php

class m150122_156000_askanswer extends CDbMigration
{
	public function up()
	{
        $this->createTable('ask_answer_groups', array(
            'id'=>'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'language_id'=>'int(11) unsigned DEFAULT NULL',
            'title'=>'varchar(120) NOT NULL',
            'status'=>'smallint(5) unsigned NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->createTable('ask_answer', array(
            'id'=>'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'language_id'=>'int(11) unsigned DEFAULT NULL',
            'group_id'=>'int(11) unsigned NOT NULL',
            'title'=>'varchar(255) NOT NULL',
            'text'=>'text NOT NULL',
            'status'=>'smallint(5) unsigned NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->createIndex('language_id_idx', 'ask_answer_groups', 'language_id' );
        $this->createIndex('language_id_idx', 'ask_answer', 'language_id' );

        $this->addForeignKey("fk_ask_answer_groups_language_language_id", "ask_answer_groups", "language_id", "language", "id", "SET NULL", "CASCADE");
        $this->addForeignKey("fk_ask_answer_language_language_id", "ask_answer", "language_id", "language", "id", "SET NULL", "CASCADE");

        $this->createIndex('group_id_idx', 'ask_answer', 'group_id');
        $this->addForeignKey("fk_ask_answer_ask_answer_groups_group_id", "ask_answer", "group_id", "ask_answer_groups", "id", "CASCADE", "CASCADE");
	}

	public function down()
	{
        $this->dropForeignKey('fk_ask_answer_ask_answer_groups_group_id', 'ask_answer');
        $this->dropForeignKey('fk_ask_answer_language_language_id', 'ask_answer');
        $this->dropForeignKey('fk_ask_answer_groups_language_language_id', 'ask_answer_groups');

        $this->dropTable('ask_answer_groups');
        $this->dropTable('ask_answer');

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