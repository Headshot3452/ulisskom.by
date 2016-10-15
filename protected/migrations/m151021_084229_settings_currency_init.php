<?php

class m151021_084229_settings_currency_init extends CDbMigration
{
	public function up()
	{
		$this->createTable('settings_currency', array(
			'id'=>'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'sort' => 'int(11) NOT NULL',
			'currency_name'=>'varchar(50) NOT NULL',
			'course' =>'float NOT NULL',
			'format' => 'tinyint(1) NOT NULL DEFAULT 0',
			'format_icon' => 'tinyint(1) NOT NULL DEFAULT 0',
			'status' => 'tinyint(1) NOT NULL DEFAULT 1'
		), 'ENGINE=InnoDB');

		$this->createTable('settings_currency_list', array(
			'name'=>'varchar(50) NOT NULL PRIMARY KEY',
			'icon' =>'TEXT NOT NULL',
			'basic' => 'tinyint(1) NOT NULL DEFAULT 0',
		), 'ENGINE=InnoDB');


		$this->createIndex('currency_name_idx', 'settings_currency', 'currency_name' );
		$this->createIndex('settings_currency_list_name', 'settings_currency_list', 'name' );
		$this->addForeignKey("fk_settings_currency_settings_currency_list", "settings_currency", "currency_name", "settings_currency_list", "name", "CASCADE", "CASCADE");

		$this->insert("settings_currency_list",array(
			"name"=>'RUB',
			"icon"=>'glyphicon glyphicon-ruble',
			"basic"=>"0",
		));

		$this->insert("settings_currency_list",array(
			"name"=>'USD',
			"icon"=>'glyphicon glyphicon-usd',
			"basic"=>"0",
		));

		$this->insert("settings_currency_list",array(
			"name"=>'EUR',
			"icon"=>'glyphicon glyphicon-euro',
			"basic"=>"0",
		));

        $this->insert("settings_currency_list",array(
            "name"=>'BYR',
            "icon"=>'fa fa-byr',
            "basic"=>"1",
        ));

        $this->insert("settings_currency_list",array(
            "name"=>'GBP',
            "icon"=>'glyphicon glyphicon-gbp',
            "basic"=>"0",
        ));

        $this->insert("settings_currency_list",array(
            "name"=>'INR',
            "icon"=>'fa fa-inr',
            "basic"=>"0",
        ));

        $this->insert("settings_currency_list",
            array(
                "name" => 'TRY',
                "icon" => 'fa fa-try',
                "basic" => "0",
            )
        );

        $this->insert("settings_currency_list",
            array(
                "name" => 'UAH',
                "icon" => 'fa fa-uah',
                "basic" => "0",
            )
        );

        $this->insert("settings_currency_list",
            array(
                "name" => 'WON',
                "icon" => 'fa fa-krw',
                "basic" => "0",
            )
        );

        $this->insert("settings_currency_list",
            array(
                "name" => 'YEN',
                "icon" => 'glyphicon glyphicon-yen',
                "basic" => "0",
            )
        );

        $this->insert("settings_currency",
            array(
                "currency_name" => 'BYR',
                "sort" => '1',
                "course" => '0',
                "format" => "0",
                "format_icon" => "0",
                "status" => "1",
            )
        );

		$this->insert("settings_currency",
            array(
                "currency_name" => 'EUR',
                "sort" => '2',
                "course" => '0',
                "format" => "0",
                "format_icon" => "0",
                "status" => "1",
		    )
        );

		$this->insert("settings_currency",
            array(
                "currency_name" => 'RUB',
                "sort" => '3',
                "course" => '0',
                "format" => "0",
                "format_icon" => "0",
                "status" => "1",
		    )
        );

		$this->insert("settings_currency",
            array(
                "currency_name" => 'USD',
                "sort" => '4',
                "course" => '0',
                "format" => "0",
                "format_icon" => "0",
                "status" => "1",
		    )
        );
	}

	public function down()
	{
		$this->dropForeignKey('fk_settings_currency_settings_currency_list', 'settings_currency');
		$this->dropTable('settings_currency');
		$this->dropTable('settings_currency_list');
	}
}