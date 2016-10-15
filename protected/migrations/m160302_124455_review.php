<?php

class m160302_124455_review extends CDbMigration
{
    public function up()
    {
        $this->createTable('review_setting', array(
            'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'language_id'=>'int(11) unsigned DEFAULT NULL',
            'sort' =>'int(11)  NOT NULL',
            'name'=>'varchar(255) NOT NULL',
            'type'=>'tinyint(4) NOT NULL',
            'status'=>'tinyint(4) NOT NULL',
            'system'=>'tinyint(4) NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->createTable('review_themes_tree', array(
            'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'lft'=>'int(11) NOT NULL',
            'rgt'=>'int(11) NOT NULL',
            'level'=>'int(11) NOT NULL',
            'language_id'=>'int(11) unsigned DEFAULT NULL',
            'title'=>'varchar(255) NOT NULL',
            'name'=>'varchar(255) NOT NULL',
            'status'=>'tinyint(4) NOT NULL',
            'root'=>'int(11) unsigned DEFAULT NULL',
        ), 'ENGINE=InnoDB');

        $this->createTable('review_item', array(
            'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'parent_id'=>'int(11) unsigned',
            'user_id'=>'int(11) unsigned',
            'language_id'=>'int(11) unsigned DEFAULT NULL',
            'create_time'=>'int(11) unsigned DEFAULT NULL',
            'status'=>'tinyint(4) NOT NULL',
            'rating'=>'tinyint(4) NOT NULL DEFAULT 0',
            'text'=>'text NOT NULL',
            'note'=>'text',
            'fullname'=>'varchar(255)',
            'email'=>'varchar(30)',
            'phone'=>'varchar(15)',
        ), 'ENGINE=InnoDB');

        $this->insert('review_themes_tree',array(
            'lft'=>'1',
            'rgt'=>'2',
            'level'=>'1',
            'language_id'=>'1',
            'title'=>'Корневая директория',
            'name'=>'root',
            'status'=>'1',
            'root'=>'1',
        ));

        $this->insert('review_setting',array(
            'language_id'=>'1',
            'sort' =>'1',
            'name'=>'Темы отзывов',
            'type'=>'1',
            'status'=>'1',
            'system'=>'1',
        ));
        $this->insert('review_setting',array(
            'language_id'=>'1',
            'sort' =>'1',
            'name'=>'Размещать отзыв сразу, без модерации',
            'type'=>'1',
            'status'=>'0',
            'system'=>'1',
        ));
        $this->insert('review_setting',array(
            'language_id'=>'1',
            'sort' =>'1',
            'name'=>'Оставить отзыв можно только зарегистрированным пользователям',
            'type'=>'1',
            'status'=>'1',
            'system'=>'1',
        ));
        $this->insert('review_setting',array(
            'language_id'=>'1',
            'sort' =>'1',
            'name'=>'Ф.И.О.',
            'type'=>'1',
            'status'=>'1',
            'system'=>'1',
        ));
        $this->insert('review_setting',array(
            'language_id'=>'1',
            'sort' =>'1',
            'name'=>'E-mail',
            'type'=>'1',
            'status'=>'1',
            'system'=>'1',
        ));
        $this->insert('review_setting',array(
            'language_id'=>'1',
            'sort' =>'1',
            'name'=>'Телефон',
            'type'=>'1',
            'status'=>'1',
            'system'=>'1',
        ));
        $this->insert('review_setting',array(
            'language_id'=>'1',
            'sort' =>'1',
            'name'=>'Не использовать рейтинг',
            'type'=>'1',
            'status'=>'0',
            'system'=>'1',
        ));
    }

    public function down()
    {
        $this->dropTable('review_setting');
        $this->dropTable('review_item');
        $this->dropTable('review_themes_tree');
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