<?php

class m150106_182800_tags extends CDbMigration
{
	public function up()
	{
        $this->createTable('tags', array(
            'id'=>'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'language_id'=>'int(11) unsigned DEFAULT NULL',
            'title'=>'varchar(64) NOT NULL',
            'name'=>'varchar(64) NOT NULL',
            'type'=>'smallint(5) unsigned NOT NULL',
            'time'=>'int(11) unsigned NOT NULL',
            'count'=>'int(11) unsigned NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->createTable('tag_items', array(
            'id'=>'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'tag_id'=>'int(11) unsigned NOT NULL',
            'item_id'=>'int(11) unsigned NOT NULL',
            'module_id'=>'int(11) unsigned NOT NULL',
            'parent_id'=>'int(11) unsigned NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->createIndex('language_id_idx', 'tags', 'language_id' );
        $this->addForeignKey("fk_tags_language_language_id", "tags", "language_id", "language", "id", "SET NULL", "CASCADE");

        $this->createIndex('tag_id_idx', 'tag_items', 'tag_id');
        $this->createIndex('item_id_idx', 'tag_items', 'item_id');

        $this->addForeignKey("fk_tag_items_tags_tag_id", "tag_items", "tag_id", "tags", "id", "CASCADE", "CASCADE");

	}

	public function down()
	{
        $this->dropForeignKey('fk_tags_language_language_id', 'tags');
        $this->dropForeignKey('fk_tag_items_tags_tag_id', 'tag_items');

        $this->dropTable('tag_items');
        $this->dropTable('tags');

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