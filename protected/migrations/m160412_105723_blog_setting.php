<?php

class m160412_105723_blog_setting extends CDbMigration
{
	public function up()
	{
        $this->createTable('blog_setting', array(
            'id'=>'int(11) unsigned NOT NULL  AUTO_INCREMENT PRIMARY KEY',
            'name'=>'varchar(255) NOT NULL',
            'status'=>'tinyint(2) NOT NULL',
        ), 'ENGINE=InnoDB');

        $this->insert('blog_setting',array(
            'name'=>'Разрешить комментировать незарегестрированным пользователям',
            'status'=>'1',
        ));
        $this->insert('blog_setting',array(
            'name'=>'Не размещать посты без модерации',
            'status'=>'1',
        ));
        $this->insert('blog_setting',array(
            'name'=>'Не размещать комментарии без модерации',
            'status'=>'1',
        ));
        $this->insert('blog_setting',array(
            'name'=>'Не отображать комментарии незарегестрированным пользователям',
            'status'=>'1',
        ));
        $this->insert('blog_setting',array(
            'name'=>'Не отправлять сообщения на почту об комментировании поста',
            'status'=>'1',
        ));
	}

	public function down()
	{
        $this->dropTable('blog_setting');
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